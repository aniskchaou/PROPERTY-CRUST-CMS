<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 07/10/15
 * Time: 11:31 AM
 */

if( !function_exists('houzez_listing_expire')) {
    function houzez_listing_expire() {
        global $post;

        //If manual expire date set
        $manual_expire = get_post_meta( $post->ID, 'houzez_manual_expire', true );
        if( !empty( $manual_expire )) {
            $expiration_date = get_post_meta( $post->ID,'_houzez_expiration_date',true );
            echo ( $expiration_date ? get_date_from_gmt(gmdate('Y-m-d H:i:s', $expiration_date), get_option('date_format').' '.get_option('time_format')) : __('Never', 'houzez'));
        } else {
            $submission_type = houzez_option('enable_paid_submission');
            // Per listing
            if( $submission_type == 'per_listing' || $submission_type == 'free_paid_listing' || $submission_type == 'no' ) {
                $per_listing_expire_unlimited = houzez_option('per_listing_expire_unlimited');
                if( $per_listing_expire_unlimited != 0 ) {
                    $per_listing_expire = houzez_option('per_listing_expire');

                    $publish_date = $post->post_date;
                    echo date_i18n( get_option('date_format').' '.get_option('time_format'), strtotime( $publish_date. ' + '.$per_listing_expire.' days' ) );
                }
            } elseif( $submission_type == 'membership' ) {
                $post_author = get_post_field( 'post_author', $post->ID );
                $package_id = get_user_meta( $post_author, 'package_id', true );
                if( !empty($package_id) ) {
                    $billing_time_unit = get_post_meta( $package_id, 'fave_billing_time_unit', true );
                    $billing_unit = get_post_meta( $package_id, 'fave_billing_unit', true );

                    if( $billing_time_unit == 'Day')
                        $billing_time_unit = 'days';
                    elseif( $billing_time_unit == 'Week')
                        $billing_time_unit = 'weeks';
                    elseif( $billing_time_unit == 'Month')
                        $billing_time_unit = 'months';
                    elseif( $billing_time_unit == 'Year')
                        $billing_time_unit = 'years';

                    $publish_date = $post->post_date;
                    echo date_i18n( get_option('date_format').' '.get_option('time_format'), strtotime( $publish_date. ' + '.$billing_unit.' '.$billing_time_unit ) );
                }
            }
        }
    }
}

if( !function_exists('houzez_get_property_gallery') ) {
    function houzez_get_property_gallery($size = 'thumbnail') {
        global $post;

        if ( ! houzez_option('disable_property_gallery', 1) ) {
            return;
        }

        $gallery_ids = get_post_meta( $post->ID, 'fave_property_images', false );

        if ( has_post_thumbnail() || $gallery_ids ) {
            $images = [];
            if ( has_post_thumbnail() ) {
                $images[] = get_the_post_thumbnail_url($post, $size);
            }

            if ( empty($gallery_ids) ) {
                return;
            }
            foreach ( $gallery_ids as $id ) {
                $img = wp_get_attachment_image_url($id, $size);
                if ( $img ) {
                    $images[] = $img;
                }
            }

            return 'data-images="'.esc_attr(json_encode($images)).'"';
        }
    }
}

if( !function_exists('houzez_property_gallery') ) {
    function houzez_property_gallery($size = 'thumbnail') {
       echo houzez_get_property_gallery($size);
    }
}




/*-----------------------------------------------------------------------------------*/
// Submit Property filter
/*-----------------------------------------------------------------------------------*/
add_filter('houzez_submit_listing', 'houzez_submit_listing');

if( !function_exists('houzez_submit_listing') ) {
    function houzez_submit_listing($new_property) {

        $userID = get_current_user_id();
        $listings_admin_approved = houzez_option('listings_admin_approved');
        $edit_listings_admin_approved = houzez_option('edit_listings_admin_approved');
        $enable_paid_submission = houzez_option('enable_paid_submission');

        // Title
        if( isset( $_POST['prop_title']) ) {
            $new_property['post_title'] = sanitize_text_field( $_POST['prop_title'] );
        }

        if( $enable_paid_submission == 'membership' ) {
            $user_submit_has_no_membership = isset($_POST['user_submit_has_no_membership']) ? $_POST['user_submit_has_no_membership'] : '';
        } else {
            $user_submit_has_no_membership = 'no';
        }

        // Description
        if( isset( $_POST['prop_des'] ) ) {
            $new_property['post_content'] = wp_kses_post( $_POST['prop_des'] );
        }

        $new_property['post_author'] = $userID;

        $submission_action = $_POST['action'];
        $prop_id = 0;

        if( $submission_action == 'add_property' ) {

            if( houzez_is_admin() ) {
                $new_property['post_status'] = 'publish';
            } else {
                if( $listings_admin_approved != 'yes' && ( $enable_paid_submission == 'no' || $enable_paid_submission == 'free_paid_listing' || $enable_paid_submission == 'membership' ) ) {
                    if( $user_submit_has_no_membership == 'yes' ) {
                        $new_property['post_status'] = 'draft';
                    } else {
                        $new_property['post_status'] = 'publish';
                    }
                } else {
                    if( $user_submit_has_no_membership == 'yes' && $enable_paid_submission = 'membership' ) {
                        $new_property['post_status'] = 'draft';
                    } else {
                        $new_property['post_status'] = 'pending';
                    }
                }
            }

            /*
             * Filter submission arguments before insert into database.
             */
            $new_property = apply_filters( 'houzez_before_submit_property', $new_property );
            $prop_id = wp_insert_post( $new_property );

            if( $prop_id > 0 ) {
                $submitted_successfully = true;
                if( $enable_paid_submission == 'membership'){ // update package status
                    houzez_update_package_listings( $userID );
                }
            }

        } else if( $submission_action == 'update_property' ) {

            $new_property['ID'] = intval( $_POST['prop_id'] );

            if( get_post_status( intval( $_POST['prop_id'] ) ) == 'draft' ) {
                if( $enable_paid_submission == 'membership') {
                    houzez_update_package_listings($userID);
                }
                if( $listings_admin_approved != 'yes' && ( $enable_paid_submission == 'no' || $enable_paid_submission == 'free_paid_listing' || $enable_paid_submission == 'membership' ) ) {
                    $new_property['post_status'] = 'publish';
                } else {
                    $new_property['post_status'] = 'pending';
                }
            } elseif( $edit_listings_admin_approved == 'yes' ) {
                    $new_property['post_status'] = 'pending';
            }

            if( houzez_is_admin() ) {
                $new_property['post_status'] = 'publish';
            }

            /*
             * Filter submission arguments before update property.
             */
            $new_property = apply_filters( 'houzez_before_update_property', $new_property );
            $prop_id = wp_update_post( $new_property );

        }

        if( $prop_id > 0 ) {


            if(class_exists('Houzez_Fields_Builder')) {
                $fields_array = Houzez_Fields_Builder::get_form_fields();
                if(!empty($fields_array)):
                    foreach ( $fields_array as $value ):
                        $field_name = $value->field_id;
                        $field_type = $value->type;

                        if( isset( $_POST[$field_name] ) && !empty( $_POST[$field_name] ) ) {

                            if( $field_type == 'checkbox_list' || $field_type == 'multiselect' ) {
                                delete_post_meta( $prop_id, 'fave_'.$field_name );
                                foreach ( $_POST[ $field_name ] as $value ) {
                                    add_post_meta( $prop_id, 'fave_'.$field_name, sanitize_text_field( $value ) );
                                }
                            } else {
                                update_post_meta( $prop_id, 'fave_'.$field_name, sanitize_text_field( $_POST[$field_name] ) );
                            }

                        } else {
                            delete_post_meta( $prop_id, 'fave_'.$field_name );
                        }

                    endforeach; 
                endif;
            }


            if( $user_submit_has_no_membership == 'yes' ) {
                update_user_meta( $userID, 'user_submit_has_no_membership', $prop_id );
                update_user_meta( $userID, 'user_submitted_without_membership', 'yes' );
            }

            // Add price post meta
            if( isset( $_POST['prop_price'] ) ) {
                update_post_meta( $prop_id, 'fave_property_price', sanitize_text_field( $_POST['prop_price'] ) );

                if( isset( $_POST['prop_label'] ) ) {
                    update_post_meta( $prop_id, 'fave_property_price_postfix', sanitize_text_field( $_POST['prop_label']) );
                }
            }

            //price prefix
            if( isset( $_POST['prop_price_prefix'] ) ) {
                update_post_meta( $prop_id, 'fave_property_price_prefix', sanitize_text_field( $_POST['prop_price_prefix']) );
            }

            // Second Price
            if( isset( $_POST['prop_sec_price'] ) ) {
                update_post_meta( $prop_id, 'fave_property_sec_price', sanitize_text_field( $_POST['prop_sec_price'] ) );
            }

            // currency
            if( isset( $_POST['currency'] ) ) {
                update_post_meta( $prop_id, 'fave_currency', sanitize_text_field( $_POST['currency'] ) );
                if(class_exists('Houzez_Currencies')) {
                    $currencies = Houzez_Currencies::get_property_currency_2($prop_id, $_POST['currency']);

                    update_post_meta( $prop_id, 'fave_currency_info', $currencies );
                }
            }


            // Area Size
            if( isset( $_POST['prop_size'] ) ) {
                update_post_meta( $prop_id, 'fave_property_size', sanitize_text_field( $_POST['prop_size'] ) );
            }

            // Area Size Prefix
            if( isset( $_POST['prop_size_prefix'] ) ) {
                update_post_meta( $prop_id, 'fave_property_size_prefix', sanitize_text_field( $_POST['prop_size_prefix'] ) );
            }

            // Land Area Size
            if( isset( $_POST['prop_land_area'] ) ) {
                update_post_meta( $prop_id, 'fave_property_land', sanitize_text_field( $_POST['prop_land_area'] ) );
            }

            // Land Area Size Prefix
            if( isset( $_POST['prop_land_area_prefix'] ) ) {
                update_post_meta( $prop_id, 'fave_property_land_postfix', sanitize_text_field( $_POST['prop_land_area_prefix'] ) );
            }

            // Bedrooms
            if( isset( $_POST['prop_beds'] ) ) {
                update_post_meta( $prop_id, 'fave_property_bedrooms', sanitize_text_field( $_POST['prop_beds'] ) );
            }

            // Bedrooms
            if( isset( $_POST['prop_rooms'] ) ) {
                update_post_meta( $prop_id, 'fave_property_rooms', sanitize_text_field( $_POST['prop_rooms'] ) );
            }

            // Bathrooms
            if( isset( $_POST['prop_baths'] ) ) {
                update_post_meta( $prop_id, 'fave_property_bathrooms', sanitize_text_field( $_POST['prop_baths'] ) );
            }

            // Garages
            if( isset( $_POST['prop_garage'] ) ) {
                update_post_meta( $prop_id, 'fave_property_garage', sanitize_text_field( $_POST['prop_garage'] ) );
            }

            // Garages Size
            if( isset( $_POST['prop_garage_size'] ) ) {
                update_post_meta( $prop_id, 'fave_property_garage_size', sanitize_text_field( $_POST['prop_garage_size'] ) );
            }

            // Virtual Tour
            if( isset( $_POST['virtual_tour'] ) ) {
                update_post_meta( $prop_id, 'fave_virtual_tour', $_POST['virtual_tour'] );
            }

            // Year Built
            if( isset( $_POST['prop_year_built'] ) ) {
                update_post_meta( $prop_id, 'fave_property_year', sanitize_text_field( $_POST['prop_year_built'] ) );
            }

            // Property ID
            $auto_property_id = houzez_option('auto_property_id');
            if( $auto_property_id != 1 ) {
                if (isset($_POST['property_id'])) {
                    update_post_meta($prop_id, 'fave_property_id', sanitize_text_field($_POST['property_id']));
                }
            } else {
                    update_post_meta($prop_id, 'fave_property_id', $prop_id );
            }

            // Property Video Url
            if( isset( $_POST['prop_video_url'] ) ) {
                update_post_meta( $prop_id, 'fave_video_url', sanitize_text_field( $_POST['prop_video_url'] ) );
            }

            // property video image - in case of update
            $property_video_image = "";
            $property_video_image_id = 0;
            if( $submission_action == "update_property" ) {
                $property_video_image_id = get_post_meta( $prop_id, 'fave_video_image', true );
                if ( ! empty ( $property_video_image_id ) ) {
                    $property_video_image_src = wp_get_attachment_image_src( $property_video_image_id, 'houzez-property-detail-gallery' );
                    $property_video_image = $property_video_image_src[0];
                }
            }

            // clean up the old meta information related to images when property update
            if( $submission_action == "update_property" ){
                delete_post_meta( $prop_id, 'fave_property_images' );
                delete_post_meta( $prop_id, 'fave_attachments' );
                delete_post_meta( $prop_id, 'fave_agents' );
                delete_post_meta( $prop_id, 'fave_property_agency' );
                delete_post_meta( $prop_id, '_thumbnail_id' );
            }

            // Property Images
            if( isset( $_POST['propperty_image_ids'] ) ) {
                if (!empty($_POST['propperty_image_ids']) && is_array($_POST['propperty_image_ids'])) {
                    $property_image_ids = array();
                    foreach ($_POST['propperty_image_ids'] as $prop_img_id ) {
                        $property_image_ids[] = intval( $prop_img_id );
                        add_post_meta($prop_id, 'fave_property_images', $prop_img_id);
                    }

                    // featured image
                    if( isset( $_POST['featured_image_id'] ) ) {
                        $featured_image_id = intval( $_POST['featured_image_id'] );
                        if( in_array( $featured_image_id, $property_image_ids ) ) {
                            update_post_meta( $prop_id, '_thumbnail_id', $featured_image_id );

                            /* if video url is provided but there is no video image then use featured image as video image */
                            if ( empty( $property_video_image ) && !empty( $_POST['prop_video_url'] ) ) {
                                update_post_meta( $prop_id, 'fave_video_image', $featured_image_id );
                            }
                        }
                    } elseif ( ! empty ( $property_image_ids ) ) {
                        update_post_meta( $prop_id, '_thumbnail_id', $property_image_ids[0] );

                        /* if video url is provided but there is no video image then use featured image as video image */
                        if ( empty( $property_video_image ) && !empty( $_POST['prop_video_url'] ) ) {
                            update_post_meta( $prop_id, 'fave_video_image', $property_image_ids[0] );
                        }
                    }
                }
            }

            if( isset( $_POST['propperty_attachment_ids'] ) ) {
                    $property_attach_ids = array();
                    foreach ($_POST['propperty_attachment_ids'] as $prop_atch_id ) {
                        $property_attach_ids[] = intval( $prop_atch_id );
                        add_post_meta($prop_id, 'fave_attachments', $prop_atch_id);
                    }
            }
 

            // Add property type
            if( isset( $_POST['prop_type'] ) && ( $_POST['prop_type'] != '-1' ) ) {
                $type = array_map( 'intval', $_POST['prop_type'] );
                wp_set_object_terms( $prop_id, $type, 'property_type' );
            } else {
                wp_set_object_terms( $prop_id, '', 'property_type' );
            }

            // Add property status
            if( isset( $_POST['prop_status'] ) && ( $_POST['prop_status'] != '-1' ) ) {
                $prop_status = array_map( 'intval', $_POST['prop_status'] );
                wp_set_object_terms( $prop_id, $prop_status, 'property_status' );
            } else {
                wp_set_object_terms( $prop_id, '', 'property_status' );
            }

            // Add property status
            if( isset( $_POST['prop_labels'] ) ) {
                $prop_labels = array_map( 'intval', $_POST['prop_labels'] );
                wp_set_object_terms( $prop_id, $prop_labels, 'property_label' );
            } else {
                wp_set_object_terms( $prop_id, '', 'property_label' );
            }

            // Country
            if( isset( $_POST['country'] ) ) {
                $property_country = sanitize_text_field( $_POST['country'] );
                $country_id = wp_set_object_terms( $prop_id, $property_country, 'property_country' );
            } else {
                $default_country = houzez_option('default_country');
                $country_id = wp_set_object_terms( $prop_id, $default_country, 'property_country' );
            }
            
            // Postal Code
            if( isset( $_POST['postal_code'] ) ) {
                update_post_meta( $prop_id, 'fave_property_zip', sanitize_text_field( $_POST['postal_code'] ) );
            }

            
            if( isset( $_POST['locality'] ) ) {
                $property_city = sanitize_text_field( $_POST['locality'] );
                $city_id = wp_set_object_terms( $prop_id, $property_city, 'property_city' );

                $houzez_meta = array();
                $houzez_meta['parent_state'] = isset( $_POST['administrative_area_level_1'] ) ? $_POST['administrative_area_level_1'] : '';
                if( !empty( $city_id) ) {
                    update_option('_houzez_property_city_' . $city_id[0], $houzez_meta);
                }
            }

            if( isset( $_POST['neighborhood'] ) ) {
                $property_area = sanitize_text_field( $_POST['neighborhood'] );
                $area_id = wp_set_object_terms( $prop_id, $property_area, 'property_area' );

                $houzez_meta = array();
                $houzez_meta['parent_city'] = isset( $_POST['locality'] ) ? $_POST['locality'] : '';
                if( !empty( $area_id) ) {
                    update_option('_houzez_property_area_' . $area_id[0], $houzez_meta);
                }
            }


            // Add property state
            if( isset( $_POST['administrative_area_level_1'] ) ) {
                $property_state = sanitize_text_field( $_POST['administrative_area_level_1'] );
                $state_id = wp_set_object_terms( $prop_id, $property_state, 'property_state' );

                $houzez_meta = array();
                $country_short = isset( $_POST['country'] ) ? $_POST['country'] : '';
                if(!empty($country_short)) {
                   $country_short = strtoupper($country_short); 
                } else {
                    $country_short = '';
                }
                
                $houzez_meta['parent_country'] = $country_short;
                if( !empty( $state_id) ) {
                    update_option('_houzez_property_state_' . $state_id[0], $houzez_meta);
                }
            }
           
            // Add property features
            if( isset( $_POST['prop_features'] ) ) {
                $features_array = array();
                foreach( $_POST['prop_features'] as $feature_id ) {
                    $features_array[] = intval( $feature_id );
                }
                wp_set_object_terms( $prop_id, $features_array, 'property_feature' );
            }

            // additional details
            if( isset( $_POST['additional_features'] ) ) {
                $additional_features = $_POST['additional_features'];
                if( ! empty( $additional_features ) ) {
                    update_post_meta( $prop_id, 'additional_features', $additional_features );
                    update_post_meta( $prop_id, 'fave_additional_features_enable', 'enable' );
                }
            } else {
                update_post_meta( $prop_id, 'additional_features', '' );
            }

            //Floor Plans
            if( isset( $_POST['floorPlans_enable'] ) ) {
                $floorPlans_enable = $_POST['floorPlans_enable'];
                if( ! empty( $floorPlans_enable ) ) {
                    update_post_meta( $prop_id, 'fave_floor_plans_enable', $floorPlans_enable );
                }
            }

            if( isset( $_POST['floor_plans'] ) ) {
                $floor_plans_post = $_POST['floor_plans'];
                if( ! empty( $floor_plans_post ) ) {
                    update_post_meta( $prop_id, 'floor_plans', $floor_plans_post );
                }
            }

            //Multi-units / Sub-properties
            if( isset( $_POST['multiUnits'] ) ) {
                $multiUnits_enable = $_POST['multiUnits'];
                if( ! empty( $multiUnits_enable ) ) {
                    update_post_meta( $prop_id, 'fave_multiunit_plans_enable', $multiUnits_enable );
                }
            }

            if( isset( $_POST['fave_multi_units'] ) ) {
                $fave_multi_units = $_POST['fave_multi_units'];
                if( ! empty( $fave_multi_units ) ) {
                    update_post_meta( $prop_id, 'fave_multi_units', $fave_multi_units );
                }
            }

            // Make featured
            if( isset( $_POST['prop_featured'] ) ) {
                $featured = intval( $_POST['prop_featured'] );
                update_post_meta( $prop_id, 'fave_featured', $featured );
            }

            // fave_loggedintoview
            if( isset( $_POST['login-required'] ) ) {
                $featured = intval( $_POST['login-required'] );
                update_post_meta( $prop_id, 'fave_loggedintoview', $featured );
            }

            // Mortgage
            if( $submission_action == 'add_property' ) {
                update_post_meta( $prop_id, 'fave_mortgage_cal', 0 );
                
            }

            // Private Note
            if( isset( $_POST['private_note'] ) ) {
                $private_note = wp_kses_post( $_POST['private_note'] );
                update_post_meta( $prop_id, 'fave_private_note', $private_note );
            }

            // disclaimer 
            if( isset( $_POST['property_disclaimer'] ) ) {
                $property_disclaimer = wp_kses_post( $_POST['property_disclaimer'] );
                update_post_meta( $prop_id, 'fave_property_disclaimer', $property_disclaimer );
            }

            //Energy Class
            if(isset($_POST['energy_class'])) {
                $energy_class = sanitize_text_field($_POST['energy_class']);
                update_post_meta( $prop_id, 'fave_energy_class', $energy_class );
            }
            if(isset($_POST['energy_global_index'])) {
                $energy_global_index = sanitize_text_field($_POST['energy_global_index']);
                update_post_meta( $prop_id, 'fave_energy_global_index', $energy_global_index );
            }
            if(isset($_POST['renewable_energy_global_index'])) {
                $renewable_energy_global_index = sanitize_text_field($_POST['renewable_energy_global_index']);
                update_post_meta( $prop_id, 'fave_renewable_energy_global_index', $renewable_energy_global_index );
            }
            if(isset($_POST['energy_performance'])) {
                $energy_performance = sanitize_text_field($_POST['energy_performance']);
                update_post_meta( $prop_id, 'fave_energy_performance', $energy_performance );
            }
            if(isset($_POST['epc_current_rating'])) {
                $epc_current_rating = sanitize_text_field($_POST['epc_current_rating']);
                update_post_meta( $prop_id, 'fave_epc_current_rating', $epc_current_rating );
            }
            if(isset($_POST['epc_potential_rating'])) {
                $epc_potential_rating = sanitize_text_field($_POST['epc_potential_rating']);
                update_post_meta( $prop_id, 'fave_epc_potential_rating', $epc_potential_rating );
            }


            // Property Payment
            if( isset( $_POST['prop_payment'] ) ) {
                $prop_payment = sanitize_text_field( $_POST['prop_payment'] );
                update_post_meta( $prop_id, 'fave_payment_status', $prop_payment );
            }


            if( isset( $_POST['fave_agent_display_option'] ) ) {

                $prop_agent_display_option = sanitize_text_field( $_POST['fave_agent_display_option'] );

                if( $prop_agent_display_option == 'agent_info' ) {

                    $prop_agent = $_POST['fave_agents'];

                    if(is_array($prop_agent)) {
                        foreach ($prop_agent as $agent) {
                            add_post_meta($prop_id, 'fave_agents', intval($agent) );
                        }
                    }
                    update_post_meta( $prop_id, 'fave_agent_display_option', $prop_agent_display_option );

                    if (houzez_is_agency()) {
                        $user_agency_id = get_user_meta( $userID, 'fave_author_agency_id', true );
                        if( !empty($user_agency_id)) {
                            update_post_meta($prop_id, 'fave_property_agency', $user_agency_id);
                        }
                    }

                } elseif( $prop_agent_display_option == 'agency_info' ) {

                    $user_agency_ids = $_POST['fave_property_agency'];

                    if (houzez_is_agency()) {
                        $user_agency_id = get_user_meta( $userID, 'fave_author_agency_id', true );
                        if( !empty($user_agency_id)) {
                            update_post_meta($prop_id, 'fave_property_agency', $user_agency_id);
                            update_post_meta($prop_id, 'fave_agent_display_option', $prop_agent_display_option);
                        } else {
                            update_post_meta( $prop_id, 'fave_agent_display_option', 'author_info' );
                        }

                    } else {

                        if(is_array($user_agency_ids)) {
                            foreach ($user_agency_ids as $agency) {
                                add_post_meta($prop_id, 'fave_property_agency', intval($agency) );
                            }
                        }
                        update_post_meta($prop_id, 'fave_agent_display_option', $prop_agent_display_option);
                    }
                    
                    
                } else {
                    update_post_meta( $prop_id, 'fave_agent_display_option', $prop_agent_display_option );
                }

            } else {

                if (houzez_is_agency()) {
                    $user_agency_id = get_user_meta( $userID, 'fave_author_agency_id', true );
                    if( !empty($user_agency_id) ) {
                        update_post_meta($prop_id, 'fave_agent_display_option', 'agency_info');
                        update_post_meta($prop_id, 'fave_property_agency', $user_agency_id);
                    } else {
                        update_post_meta( $prop_id, 'fave_agent_display_option', 'author_info' );
                    }

                } elseif(houzez_is_agent()){
                    $user_agent_id = get_user_meta( $userID, 'fave_author_agent_id', true );

                    if ( !empty( $user_agent_id ) ) {

                        update_post_meta($prop_id, 'fave_agent_display_option', 'agent_info');
                        update_post_meta($prop_id, 'fave_agents', $user_agent_id);

                    } else {
                        update_post_meta($prop_id, 'fave_agent_display_option', 'author_info');
                    }

                } else {
                    update_post_meta($prop_id, 'fave_agent_display_option', 'author_info');
                }
            }

            // Address
            if( isset( $_POST['property_map_address'] ) ) {
                update_post_meta( $prop_id, 'fave_property_map_address', sanitize_text_field( $_POST['property_map_address'] ) );
                update_post_meta( $prop_id, 'fave_property_address', sanitize_text_field( $_POST['property_map_address'] ) );
            }

            if( ( isset($_POST['lat']) && !empty($_POST['lat']) ) && (  isset($_POST['lng']) && !empty($_POST['lng'])  ) ) {
                $lat = sanitize_text_field( $_POST['lat'] );
                $lng = sanitize_text_field( $_POST['lng'] );
                $streetView = sanitize_text_field( $_POST['prop_google_street_view'] );
                $lat_lng = $lat.','.$lng;

                update_post_meta( $prop_id, 'houzez_geolocation_lat', $lat );
                update_post_meta( $prop_id, 'houzez_geolocation_long', $lng );
                update_post_meta( $prop_id, 'fave_property_location', $lat_lng );
                update_post_meta( $prop_id, 'fave_property_map', '1' );
                update_post_meta( $prop_id, 'fave_property_map_street_view', $streetView );

            }
            

            if( $submission_action == 'add_property' ) {
                do_action( 'houzez_after_property_submit', $prop_id );

                if( houzez_option('add_new_property') == 1 ) {
                    houzez_webhook_post( $_POST, 'houzez_add_new_property' );
                }

            } else if ( $submission_action == 'update_property' ) {
                do_action( 'houzez_after_property_update', $prop_id );

                if( houzez_option('add_new_property') == 1 ) {
                    houzez_webhook_post( $_POST, 'houzez_update_property' );
                }
            }

        return $prop_id;
        }
    }
}

if( !function_exists('houzez_update_property_from_draft') ) {
    function houzez_update_property_from_draft( $property_id ) {
        $listings_admin_approved = houzez_option('listings_admin_approved');

        if( $listings_admin_approved != 'yes' ) {
            $prop_status = 'publish';
        } else {
            $prop_status = 'pending';
        }

        $updated_property = array(
            'ID' => $property_id,
            'post_type' => 'property',
            'post_status' => $prop_status
        );
        $prop_id = wp_update_post( $updated_property );
    }
}

add_action('wp_ajax_houzez_relist_free', 'houzez_relist_free');
if( !function_exists('houzez_relist_free') ) {
    function houzez_relist_free() {
        $listings_admin_approved = houzez_option('listings_admin_approved');

        if( $listings_admin_approved != 'yes' ) {
            $prop_status = 'publish';
        } else {
            $prop_status = 'pending';
        }
        
        $propID = $_POST['propID'];
        $updated_property = array(
            'ID' => $propID,
            'post_type' => 'property',
            'post_status' => $prop_status,
            'post_date'     => current_time( 'mysql' ),
        );
        $post_id = wp_update_post( $updated_property );
    }
}

/*-----------------------------------------------------------------------------------*/
// validate Email
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_save_as_draft', 'save_property_as_draft');
if( !function_exists('save_property_as_draft') ) {
    function save_property_as_draft() {
        global $current_user;

        wp_get_current_user();
        $userID = $current_user->ID;

        $new_property = array(
            'post_type' => 'property'
        );

        $submission_action = isset($_POST['update_property']) ? $_POST['update_property'] : '';

        // Title
        if( isset( $_POST['prop_title']) ) {
            $new_property['post_title'] = sanitize_text_field( $_POST['prop_title'] );
        }
        // Description
        if( isset( $_POST['description'] ) ) {
            $new_property['post_content'] = wp_kses_post( $_POST['description'] );
        }

        $new_property['post_author'] = $userID;

        $prop_id = 0;
        $new_property['post_status'] = 'draft';

        if( isset($_POST['draft_prop_id']) && !empty( $_POST['draft_prop_id'] ) ) {
            $new_property['ID'] = $_POST['draft_prop_id'];
            $prop_id = wp_update_post( $new_property );
        } else {
            $prop_id = wp_insert_post( $new_property );
        }


        if( $prop_id > 0 ) {
            
            //Custom Fields
            if(class_exists('Houzez_Fields_Builder')) {
                $fields_array = Houzez_Fields_Builder::get_form_fields();
                if(!empty($fields_array)):
                    foreach ( $fields_array as $value ):
                        $field_name = $value->field_id;

                        if( isset( $_POST[$field_name] ) ) {
                            update_post_meta( $prop_id, 'fave_'.$field_name, sanitize_text_field( $_POST[$field_name] ) );
                        }

                    endforeach; endif;
            }
            
            // Add price post meta
            if( isset( $_POST['prop_price'] ) ) {
                update_post_meta( $prop_id, 'fave_property_price', sanitize_text_field( $_POST['prop_price'] ) );

                if( isset( $_POST['prop_label'] ) ) {
                    update_post_meta( $prop_id, 'fave_property_price_postfix', sanitize_text_field( $_POST['prop_label']) );
                }
            }

            //price prefix
            if( isset( $_POST['prop_price_prefix'] ) ) {
                update_post_meta( $prop_id, 'fave_property_price_prefix', sanitize_text_field( $_POST['prop_price_prefix']) );
            }

            // Second Price
            if( isset( $_POST['prop_sec_price'] ) ) {
                update_post_meta( $prop_id, 'fave_property_sec_price', sanitize_text_field( $_POST['prop_sec_price'] ) );
            }

            // Area Size
            if( isset( $_POST['prop_size'] ) ) {
                update_post_meta( $prop_id, 'fave_property_size', sanitize_text_field( $_POST['prop_size'] ) );
            }

            // Area Size Prefix
            if( isset( $_POST['prop_size_prefix'] ) ) {
                update_post_meta( $prop_id, 'fave_property_size_prefix', sanitize_text_field( $_POST['prop_size_prefix'] ) );
            }
            // Land Area Size
            if( isset( $_POST['prop_land_area'] ) ) {
                update_post_meta( $prop_id, 'fave_property_land', sanitize_text_field( $_POST['prop_land_area'] ) );
            }

            // Land Area Size Prefix
            if( isset( $_POST['prop_land_area_prefix'] ) ) {
                update_post_meta( $prop_id, 'fave_property_land_postfix', sanitize_text_field( $_POST['prop_land_area_prefix'] ) );
            }

            // Bedrooms
            if( isset( $_POST['prop_beds'] ) ) {
                update_post_meta( $prop_id, 'fave_property_bedrooms', sanitize_text_field( $_POST['prop_beds'] ) );
            }

            // Bathrooms
            if( isset( $_POST['prop_baths'] ) ) {
                update_post_meta( $prop_id, 'fave_property_bathrooms', sanitize_text_field( $_POST['prop_baths'] ) );
            }

            // Garages
            if( isset( $_POST['prop_garage'] ) ) {
                update_post_meta( $prop_id, 'fave_property_garage', sanitize_text_field( $_POST['prop_garage'] ) );
            }

            // Garages Size
            if( isset( $_POST['prop_garage_size'] ) ) {
                update_post_meta( $prop_id, 'fave_property_garage_size', sanitize_text_field( $_POST['prop_garage_size'] ) );
            }

            // Virtual Tour
            if( isset( $_POST['virtual_tour'] ) ) {
                update_post_meta( $prop_id, 'fave_virtual_tour', $_POST['virtual_tour'] );
            }

            // Year Built
            if( isset( $_POST['prop_year_built'] ) ) {
                update_post_meta( $prop_id, 'fave_property_year', sanitize_text_field( $_POST['prop_year_built'] ) );
            }

            // Property ID
            $auto_property_id = houzez_option('auto_property_id');
            if( $auto_property_id != 1 ) {
                if (isset($_POST['property_id'])) {
                    update_post_meta($prop_id, 'fave_property_id', sanitize_text_field($_POST['property_id']));
                }
            } else {
                update_post_meta($prop_id, 'fave_property_id', $prop_id );
            }

            // Property Video Url
            if( isset( $_POST['prop_video_url'] ) ) {
                update_post_meta( $prop_id, 'fave_video_url', sanitize_text_field( $_POST['prop_video_url'] ) );
            }

            // property video image - in case of update
            $property_video_image = "";
            $property_video_image_id = 0;
            if( $submission_action == "update_property" ) {
                $property_video_image_id = get_post_meta( $prop_id, 'fave_video_image', true );
                if ( ! empty ( $property_video_image_id ) ) {
                    $property_video_image_src = wp_get_attachment_image_src( $property_video_image_id, 'houzez-property-detail-gallery' );
                    $property_video_image = $property_video_image_src[0];
                }
            }

            // clean up the old meta information related to images when property update
            if( $submission_action == "update_property" ){
                delete_post_meta( $prop_id, 'fave_property_images' );
                delete_post_meta( $prop_id, '_thumbnail_id' );
            }

            // Property Images
            if( isset( $_POST['propperty_image_ids'] ) ) {
                if (!empty($_POST['propperty_image_ids']) && is_array($_POST['propperty_image_ids'])) {
                    $property_image_ids = array();
                    foreach ($_POST['propperty_image_ids'] as $prop_img_id ) {
                        $property_image_ids[] = intval( $prop_img_id );
                        add_post_meta($prop_id, 'fave_property_images', $prop_img_id);
                    }

                    // featured image
                    if( isset( $_POST['featured_image_id'] ) ) {
                        $featured_image_id = intval( $_POST['featured_image_id'] );
                        if( in_array( $featured_image_id, $property_image_ids ) ) {
                            update_post_meta( $prop_id, '_thumbnail_id', $featured_image_id );

                            /* if video url is provided but there is no video image then use featured image as video image */
                            if ( empty( $property_video_image ) && !empty( $_POST['prop_video_url'] ) ) {
                                update_post_meta( $prop_id, 'fave_video_image', $featured_image_id );
                            }
                        }
                    } elseif ( ! empty ( $property_image_ids ) ) {
                        update_post_meta( $prop_id, '_thumbnail_id', $property_image_ids[0] );
                    }
                }
            }


            // Add property type
            if( isset( $_POST['prop_type'] ) && ( $_POST['prop_type'] != '-1' ) ) {
                $type = array_map( 'intval', $_POST['prop_type'] );
                wp_set_object_terms( $prop_id, $type, 'property_type' );
            }

            // Add property status
            if( isset( $_POST['prop_status'] ) && ( $_POST['prop_status'] != '-1' ) ) {
                $prop_status = array_map( 'intval', $_POST['prop_status'] );
                wp_set_object_terms( $prop_id, $prop_status, 'property_status' );
            }

            // Add property label
            if( isset( $_POST['prop_labels'] ) ) {
                $prop_labels = array_map( 'intval', $_POST['prop_labels'] );
                wp_set_object_terms( $prop_id, $prop_labels, 'property_label' );
            }


            // Add property city
            if( isset( $_POST['locality'] ) ) {
                $property_city = sanitize_text_field( $_POST['locality'] );
                $city_id = wp_set_object_terms( $prop_id, $property_city, 'property_city' );

                $houzez_meta = array();
                $houzez_meta['parent_state'] = isset( $_POST['administrative_area_level_1'] ) ? $_POST['administrative_area_level_1'] : '';
                if( !empty( $city_id) ) {
                    update_option('_houzez_property_city_' . $city_id[0], $houzez_meta);
                }
            }

            // Add property area
            if( isset( $_POST['neighborhood'] ) ) {
                $property_area = sanitize_text_field( $_POST['neighborhood'] );
                $area_id = wp_set_object_terms( $prop_id, $property_area, 'property_area' );

                $houzez_meta = array();
                $houzez_meta['parent_city'] = isset( $_POST['locality'] ) ? $_POST['locality'] : '';
                if( !empty( $area_id) ) {
                    update_option('_houzez_property_area_' . $area_id[0], $houzez_meta);
                }
            }

            // Add property state
            if( isset( $_POST['administrative_area_level_1'] ) ) {
                $property_state = sanitize_text_field( $_POST['administrative_area_level_1'] );
                $state_id = wp_set_object_terms( $prop_id, $property_state, 'property_state' );

                $houzez_meta = array();
                $houzez_meta['parent_country'] = isset( $_POST['country_short'] ) ? $_POST['country_short'] : '';
                if( !empty( $state_id) ) {
                    update_option('_houzez_property_state_' . $state_id[0], $houzez_meta);
                }
            }

            // Add property features
            if( isset( $_POST['prop_features'] ) ) {
                $features_array = array();
                foreach( $_POST['prop_features'] as $feature_id ) {
                    $features_array[] = intval( $feature_id );
                }
                wp_set_object_terms( $prop_id, $features_array, 'property_feature' );
            }

            // additional details
            if( isset( $_POST['additional_features'] ) ) {
                $additional_features = $_POST['additional_features'];
                if( ! empty( $additional_features ) ) {
                    update_post_meta( $prop_id, 'additional_features', $additional_features );
                    update_post_meta( $prop_id, 'fave_additional_features_enable', 'enable' );
                }
            }

            //Floor Plans
            if( isset( $_POST['floorPlans_enable'] ) ) {
                $floorPlans_enable = $_POST['floorPlans_enable'];
                if( ! empty( $floorPlans_enable ) ) {
                    update_post_meta( $prop_id, 'fave_floor_plans_enable', $floorPlans_enable );
                }
            }

            if( isset( $_POST['floor_plans'] ) ) {
                $floor_plans_post = $_POST['floor_plans'];
                if( ! empty( $floor_plans_post ) ) {
                    update_post_meta( $prop_id, 'floor_plans', $floor_plans_post );
                }
            }

            //Multi-units / Sub-properties
            if( isset( $_POST['multiUnits'] ) ) {
                $multiUnits_enable = $_POST['multiUnits'];
                if( ! empty( $multiUnits_enable ) ) {
                    update_post_meta( $prop_id, 'fave_multiunit_plans_enable', $multiUnits_enable );
                }
            }

            if( isset( $_POST['fave_multi_units'] ) ) {
                $fave_multi_units = $_POST['fave_multi_units'];
                if( ! empty( $fave_multi_units ) ) {
                    update_post_meta( $prop_id, 'fave_multi_units', $fave_multi_units );
                }
            }

            // Make featured
            if( isset( $_POST['prop_featured'] ) ) {
                $featured = intval( $_POST['prop_featured'] );
                update_post_meta( $prop_id, 'fave_featured', $featured );
            }

            // Private Note
            if( isset( $_POST['private_note'] ) ) {
                $private_note = wp_kses_post( $_POST['private_note'] );
                update_post_meta( $prop_id, 'fave_private_note', $private_note );
            }

            // disclaimer 
            if( isset( $_POST['property_disclaimer'] ) ) {
                $property_disclaimer = wp_kses_post( $_POST['property_disclaimer'] );
                update_post_meta( $prop_id, 'fave_property_disclaimer', $property_disclaimer );
            }

            // Property Payment
            if( isset( $_POST['prop_payment'] ) ) {
                $prop_payment = sanitize_text_field( $_POST['prop_payment'] );
                update_post_meta( $prop_id, 'fave_payment_status', $prop_payment );
            }

             //Energy Class
            if(isset($_POST['energy_class'])) {
                $energy_class = sanitize_text_field($_POST['energy_class']);
                update_post_meta( $prop_id, 'fave_energy_class', $energy_class );
            }
            if(isset($_POST['energy_global_index'])) {
                $energy_global_index = sanitize_text_field($_POST['energy_global_index']);
                update_post_meta( $prop_id, 'fave_energy_global_index', $energy_global_index );
            }
            if(isset($_POST['renewable_energy_global_index'])) {
                $renewable_energy_global_index = sanitize_text_field($_POST['renewable_energy_global_index']);
                update_post_meta( $prop_id, 'fave_renewable_energy_global_index', $renewable_energy_global_index );
            }
            if(isset($_POST['energy_performance'])) {
                $energy_performance = sanitize_text_field($_POST['energy_performance']);
                update_post_meta( $prop_id, 'fave_energy_performance', $energy_performance );
            }

            // Property Agent
            if( isset( $_POST['fave_agent_display_option'] ) ) {

                $prop_agent_display_option = sanitize_text_field( $_POST['fave_agent_display_option'] );
                if( $prop_agent_display_option == 'agent_info' ) {

                    $prop_agent = sanitize_text_field( $_POST['fave_agents'] );
                    update_post_meta( $prop_id, 'fave_agent_display_option', $prop_agent_display_option );
                    update_post_meta( $prop_id, 'fave_agents', $prop_agent );

                } else {
                    update_post_meta( $prop_id, 'fave_agent_display_option', $prop_agent_display_option );
                }

            } else {
                update_post_meta( $prop_id, 'fave_agent_display_option', 'author_info' );
            }

            // Address
            if( isset( $_POST['property_map_address'] ) ) {
                update_post_meta( $prop_id, 'fave_property_map_address', sanitize_text_field( $_POST['property_map_address'] ) );
                update_post_meta( $prop_id, 'fave_property_address', sanitize_text_field( $_POST['property_map_address'] ) );
            }

            if( ( isset($_POST['lat']) && !empty($_POST['lat']) ) && (  isset($_POST['lng']) && !empty($_POST['lng'])  ) ) {
                $lat = sanitize_text_field( $_POST['lat'] );
                $lng = sanitize_text_field( $_POST['lng'] );
                $streetView = sanitize_text_field( $_POST['prop_google_street_view'] );
                $lat_lng = $lat.','.$lng;

                update_post_meta( $prop_id, 'houzez_geolocation_lat', $lat );
                update_post_meta( $prop_id, 'houzez_geolocation_long', $lng );
                update_post_meta( $prop_id, 'fave_property_location', $lat_lng );
                update_post_meta( $prop_id, 'fave_property_map', '1' );
                update_post_meta( $prop_id, 'fave_property_map_street_view', $streetView );

            }
            // Country
            if( isset( $_POST['country_short'] ) ) {
                update_post_meta( $prop_id, 'fave_property_country', sanitize_text_field( $_POST['country_short'] ) );
            }
            // Postal Code
            if( isset( $_POST['postal_code'] ) ) {
                update_post_meta( $prop_id, 'fave_property_zip', sanitize_text_field( $_POST['postal_code'] ) );
            }
        }
        echo json_encode( array( 'success' => true, 'property_id' => $prop_id, 'msg' => esc_html__('Successfull', 'houzez') ) );
        wp_die();
    }
}

/*-----------------------------------------------------------------------------------*/
// validate Email
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_houzez_check_email', 'houzez_check_email');
add_action('wp_ajax_nopriv_houzez_check_email', 'houzez_check_email');

if( !function_exists('houzez_check_email') ) {
    function houzez_check_email() {
        $allowed_html = array();
        $email = wp_kses( $_POST['useremail'], $allowed_html );

        if( email_exists( $email ) ) {
            echo json_encode( array( 'success' => false, 'msg' => esc_html__('This email address is already registered.', 'houzez') ) );
            wp_die();
        
        } elseif( !is_email( $email ) ) {
            echo json_encode( array( 'success' => false, 'msg' => esc_html__('Invalid email address.', 'houzez') ) );
            wp_die();
        } else {
            echo json_encode( array( 'success' => true, 'msg' => esc_html__('Successfull', 'houzez') ) );
            wp_die();
        }

        wp_die();
    }
}

/*-----------------------------------------------------------------------------------*/
// Add custom post status Expired
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('houzez_custom_post_status') ) {
    function houzez_custom_post_status() {

        $args = array(
            'label'                     => _x( 'Expired', 'Status General Name', 'houzez' ),
            'label_count'               => _n_noop( 'Expired (%s)',  'Expired (%s)', 'houzez' ),
            'public'                    => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'exclude_from_search'       => false,
        );
        register_post_status( 'expired', $args );

    }
    add_action( 'init', 'houzez_custom_post_status', 1 );
}

/*-----------------------------------------------------------------------------------*/
// Add custom post status Hold
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists('houzez_custom_post_status_on_hold') ) {
    function houzez_custom_post_status_on_hold() {

        $args = array(
            'label'                     => _x( 'On Hold', 'Status General Name', 'houzez' ),
            'label_count'               => _n_noop( 'On Hold (%s)',  'On Hold (%s)', 'houzez' ),
            'public'                    => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'exclude_from_search'       => false,
        );
        register_post_status( 'on_hold', $args );

    }
    add_action( 'init', 'houzez_custom_post_status_on_hold', 1 );
}

add_action( 'wp_ajax_houzez_save_search', 'houzez_save_search' );
if( !function_exists('houzez_save_search') ) {
    function houzez_save_search() {

        $nonce = $_REQUEST['houzez_save_search_ajax'];
        if( !wp_verify_nonce( $nonce, 'houzez-save-search-nounce' ) ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__( 'Unverified Nonce!', 'houzez')
            ));
            wp_die();
        }

        global $wpdb, $current_user;

        wp_get_current_user();
        $userID       =  $current_user->ID;
        $userEmail    =  $current_user->user_email;
        $search_args  =  $_REQUEST['search_args'];
        $table_name   = $wpdb->prefix . 'houzez_search';
        $request_url  = $_REQUEST['search_URI'];

        $wpdb->insert(
            $table_name,
            array(
                'auther_id' => $userID,
                'query'     => $search_args,
                'email'     => $userEmail,
                'url'       => $request_url,
                'time'      => current_time( 'mysql' )
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );

        echo json_encode( array( 'success' => true, 'msg' => esc_html__('Search is saved. You will receive an email notification when new properties matching your search will be published', 'houzez') ) );
        wp_die();
    }
}

/*-----------------------------------------------------------------------------------*/
/*     Remove Search
/*-----------------------------------------------------------------------------------*/

add_action('wp_ajax_houzez_delete_search', 'houzez_delete_search');
if(!function_exists('houzez_delete_search') ) {
    function houzez_delete_search () {
        global $current_user;
        wp_get_current_user();
        $userID = $current_user->ID;

        $property_id = intval( $_POST['property_id']);

        if( !is_numeric( $property_id ) ){
            echo json_encode( array(
                'success' => false,
                'msg' => esc_html__('you don\'t have the right to delete this', 'houzez')
            ));
            wp_die();
        }else{

            global $wpdb;

            $table_name     = $wpdb->prefix . 'houzez_search';
            $results        = $wpdb->get_row( 'SELECT * FROM ' . $table_name . ' WHERE id = ' . $property_id );
            if ( $userID != $results->auther_id ) :

                echo json_encode( array(
                    'success' => false,
                    'msg' => esc_html__('you don\'t have the right to delete this', 'houzez')
                ));

                wp_die();

            else :

                $wpdb->delete( $table_name, array( 'id' => $property_id ), array( '%d' ) );

                echo json_encode( array(
                    'success' => true,
                    'msg' => esc_html__('Deleted Successfully', 'houzez')
                ));

                wp_die();

            endif;
        }
    }
}


/*-----------------------------------------------------------------------------------*/
// Property paypal payment
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_houzez_property_paypal_payment', 'houzez_property_paypal_payment');
if( !function_exists('houzez_property_paypal_payment') ) {
    function houzez_property_paypal_payment() {
        global $current_user;
        $propID        =   intval($_POST['prop_id']);
        $is_prop_featured   =   intval($_POST['is_prop_featured']);
        $is_prop_upgrade    =   intval($_POST['is_prop_upgrade']);
        $price_per_submission = houzez_option('price_listing_submission');
        $price_featured_submission = houzez_option('price_featured_listing_submission');
        $currency = houzez_option('currency_paid_submission');

        $blogInfo = esc_url( home_url() );

        wp_get_current_user();
        $userID =   $current_user->ID;
        $post   =   get_post($propID);

        if( $post->post_author != $userID ){
            wp_die('Are you kidding?');
        }

        $is_paypal_live             =   houzez_option('paypal_api');
        $host                       =   'https://api.sandbox.paypal.com';
        $price_per_submission       =   floatval( $price_per_submission );
        $price_featured_submission  =   floatval( $price_featured_submission );
        $submission_curency         =   esc_html( $currency );
        $payment_description        =   esc_html__('Listing payment on ','houzez').$blogInfo;

        if( $is_prop_featured == 0 ) {
            $total_price =  number_format( $price_per_submission, 2, '.','' );
        } else {
            $total_price = $price_per_submission + $price_featured_submission;
            $total_price = number_format( $total_price, 2, '.','' );
        }

        if ( $is_prop_upgrade == 1 ) {
            $total_price     =  number_format($price_featured_submission, 2, '.','');
            $payment_description =   esc_html__('Upgrade to featured listing on ','houzez').$blogInfo;
        }

        // Check if payal live
        if( $is_paypal_live =='live'){
            $host='https://api.paypal.com';
        }

        $url             =   $host.'/v1/oauth2/token';
        $postArgs        =   'grant_type=client_credentials';

        // Get Access token
        $paypal_token    =   houzez_get_paypal_access_token( $url, $postArgs );
        $url             =   $host.'/v1/payments/payment';
        $cancel_link     =   houzez_dashboard_listings();
        $return_link     =   houzez_get_template_link('template/template-thankyou.php');

        $payment = array(
            'intent' => 'sale',
            "redirect_urls" => array(
                "return_url" => $return_link,
                "cancel_url" => $cancel_link
            ),
            'payer' => array("payment_method" => "paypal"),
        );

        /* Prepare basic payment details
        *--------------------------------------*/
        $payment['transactions'][0] = array(
            'amount' => array(
                'total' => $total_price,
                'currency' => $submission_curency,
                'details' => array(
                    'subtotal' => $total_price,
                    'tax' => '0.00',
                    'shipping' => '0.00'
                )
            ),
            'description' => $payment_description
        );


        /* Prepare individual items
        *--------------------------------------*/
        if( $is_prop_upgrade == 1 ) {

            $payment['transactions'][0]['item_list']['items'][] = array(
                'quantity' => '1',
                'name' => esc_html__('Upgrade to Featured Listing','houzez'),
                'price' => $total_price,
                'currency' => $submission_curency,
                'sku' => 'Upgrade Listing',
            );

        } else {
            if( $is_prop_featured == 1 ) {

                $payment['transactions'][0]['item_list']['items'][] = array(
                    'quantity' => '1',
                    'name' => esc_html__('Listing with Featured Payment option','houzez'),
                    'price' => $total_price,
                    'currency' => $submission_curency,
                    'sku' => 'Featured Paid Listing',
                );

            } else {
                $payment['transactions'][0]['item_list']['items'][] = array(
                    'quantity' => '1',
                    'name' => esc_html__('Listing Payment','houzez'),
                    'price' => $total_price,
                    'currency' => $submission_curency,
                    'sku' => 'Paid Listing',
                );
            }
        }

        /* Convert PHP array into json format
        *--------------------------------------*/
        $jsonEncode = json_encode($payment);
        $json_response = houzez_execute_paypal_request( $url, $jsonEncode, $paypal_token );

        //print_r($json_response);
        foreach ($json_response['links'] as $link) {
            if($link['rel'] == 'execute'){
                $payment_execute_url = $link['href'];
            } else  if($link['rel'] == 'approval_url'){
                $payment_approval_url = $link['href'];
            }
        }

        // Save data in database for further use on processor page
        $output['payment_execute_url'] = $payment_execute_url;
        $output['paypal_token']        = $paypal_token;
        $output['property_id']         = $propID;
        $output['is_prop_featured']    = $is_prop_featured;
        $output['is_prop_upgrade']     = $is_prop_upgrade;

        $save_output[$current_user->ID]   =   $output;
        update_option('houzez_paypal_transfer',$save_output);

        print $payment_approval_url;

        wp_die();

    }
}


/* -----------------------------------------------------------------------------------------------------------
 *  Resend Property for Approval per listing
 -------------------------------------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_houzez_resend_for_approval_perlisting', 'houzez_resend_for_approval_perlisting' );
add_action( 'wp_ajax_houzez_resend_for_approval_perlisting', 'houzez_resend_for_approval_perlisting' );

if( !function_exists('houzez_resend_for_approval_perlisting') ):

    function houzez_resend_for_approval_perlisting() {

        global $current_user;
        $prop_id = intval($_POST['propid']);

        wp_get_current_user();
        $userID = $current_user->ID;
        $post   = get_post($prop_id);

        if( $post->post_author != $userID){
            wp_die('get out of my cloud');
        }

        $time = current_time('mysql');
        $prop = array(
            'ID'            => $prop_id,
            'post_type'     => 'property',
            'post_status'   => 'pending',
            'post_date'     => current_time( 'mysql' ),
            'post_date_gmt' => get_gmt_from_date( $time )
        );
        wp_update_post( $prop );
        update_post_meta( $prop_id, 'fave_featured', 0 );
        update_post_meta( $prop_id, 'fave_payment_status', 'not_paid' );

        echo json_encode( array( 'success' => true, 'msg' => esc_html__('Sent for approval','houzez') ) );

        $submit_title =   get_the_title( $prop_id) ;

        $args = array(
            'submission_title' =>  $submit_title,
            'submission_url'   =>  get_permalink( $prop_id )
        );
        houzez_email_type( get_option('admin_email'), 'admin_expired_listings', $args );

        wp_die();



    }

endif; // end

/*-----------------------------------------------------------------------------------*/
// Houzez listings template filter for version 2.0 and above
/*-----------------------------------------------------------------------------------*/
add_filter('houzez20_property_filter', 'houzez20_property_filter_callback');
if( !function_exists('houzez20_property_filter_callback') ) {
    function houzez20_property_filter_callback( $property_query_args ) {
        global $paged;

        $page_id = get_the_ID();
        $tax_query = array();
        $meta_query = array();

        $paged = 1;
        if ( get_query_var( 'paged' ) ) {
            $paged = get_query_var( 'paged' );
        } elseif ( get_query_var( 'page' ) ) { // if is static front page
            $paged = get_query_var( 'page' );
        }

        $property_query_args['paged'] = $paged;

        $fave_prop_no = get_post_meta( $page_id, 'fave_prop_no', true );
        $fave_listings_tabs = get_post_meta( $page_id, 'fave_listings_tabs', true );


        if(!$fave_prop_no){
            $property_query_args[ 'posts_per_page' ]  = 9;
        } else {
            $property_query_args[ 'posts_per_page' ] = $fave_prop_no;
        }


        if ( isset( $_GET['tab'] ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_status',
                'field' => 'slug',
                'terms' => esc_attr($_GET['tab'])
            );
        }

        $states = get_post_meta( $page_id, 'fave_states', false );
        if ( ! empty( $states ) && is_array( $states ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_state',
                'field' => 'slug',
                'terms' => $states
            );
        }

        $locations = get_post_meta( $page_id, 'fave_locations', false );
        if ( ! empty( $locations ) && is_array( $locations ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_city',
                'field' => 'slug',
                'terms' => $locations
            );
        }

        $types = get_post_meta( $page_id, 'fave_types', false );
        if ( ! empty( $types ) && is_array( $types ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => $types
            );
        }

        $labels = get_post_meta( $page_id, 'fave_labels', false );
        if ( ! empty( $labels ) && is_array( $labels ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_label',
                'field' => 'slug',
                'terms' => $labels
            );
        }

        $fave_areas = get_post_meta( $page_id, 'fave_area', false );
        if ( ! empty( $fave_areas ) && is_array( $fave_areas ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_area',
                'field' => 'slug',
                'terms' => $fave_areas
            );
        }

        $features = get_post_meta( $page_id, 'fave_features', false );
        if ( ! empty( $features ) && is_array( $features ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_feature',
                'field' => 'slug',
                'terms' => $features
            );
        }

        if( !isset( $_GET['tab'] ) ) {
            $status = get_post_meta($page_id, 'fave_status', false);
            if (!empty($status) && is_array($status)) {
                $tax_query[] = array(
                    'taxonomy' => 'property_status',
                    'field' => 'slug',
                    'terms' => $status
                );
            }
        }

        $min_price = get_post_meta( $page_id, 'fave_min_price', true );
        $max_price = get_post_meta( $page_id, 'fave_max_price', true );

        // min and max price logic
        if (!empty($min_price) && !empty($max_price)) {
            $min_price = doubleval(houzez_clean($min_price));
            $max_price = doubleval(houzez_clean($max_price));

            if ($min_price >= 0 && $max_price > $min_price) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => array($min_price, $max_price),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN',
                );
            }
        } else if (!empty($min_price)) {
            $min_price = doubleval(houzez_clean($min_price));
            if ($min_price >= 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => $min_price,
                    'type' => 'NUMERIC',
                    'compare' => '>=',
                );
            }
        } else if (!empty($max_price)) {
            $max_price = doubleval(houzez_clean($max_price));
            if ($max_price >= 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => $max_price,
                    'type' => 'NUMERIC',
                    'compare' => '<=',
                );
            }
        }


        $min_beds = get_post_meta( $page_id, 'fave_properties_min_beds', true );
        if ( ! empty( $min_beds ) ) {
            $min_beds = intval( $min_beds );
            if ( $min_beds > 0 ) {
                $meta_query[] = array(
                    'key'     => 'fave_property_bedrooms',
                    'value'   => $min_beds,
                    'compare' => '>=',
                    'type'    => 'DECIMAL'
                );
            }
        }

        $min_baths = get_post_meta( $page_id, 'fave_properties_min_baths', true );
        if ( ! empty( $min_baths ) ) {
            $min_baths = intval( $min_baths );
            if ( $min_baths > 0 ) {
                $meta_query[] = array(
                    'key'     => 'fave_property_bathrooms',
                    'value'   => $min_baths,
                    'compare' => '>=',
                    'type'    => 'DECIMAL'
                );
            }
        }


        $agents = array_filter( get_post_meta( $page_id, 'fave_properties_by_agents', false ) );
        if ( count( $agents ) >= 1 ) {
            $meta_query[] = array(
                'key'     => 'fave_agents',
                'value'   => $agents,
                'compare' => 'IN',
            );
        }

        $meta_count = count($meta_query);
        if( $meta_count > 1 ) {
            $meta_query['relation'] = 'AND';
        }
        if ($meta_count > 0) {
            $property_query_args['meta_query'] = $meta_query;
        }


        $tax_count = count( $tax_query );
        if( $tax_count > 1 ) {
            $tax_query['relation'] = 'AND';
        }
        if( $tax_count > 0 ) {
            $property_query_args['tax_query'] = $tax_query;
        }
        return $property_query_args;
    }
}


/*-----------------------------------------------------------------------------------*/
// Simple property filter - deprecated
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_property_filter') ) {
    function houzez_property_filter( $property_query_args ) {
        global $paged;

        $page_id = get_the_ID();
        $what_to_show = get_post_meta( $page_id, 'fave_properties_sort', true );
        $fave_prop_no = get_post_meta( $page_id, 'fave_prop_no', true );
        $fave_listings_tabs = get_post_meta( $page_id, 'fave_listings_tabs', true );

        $tax_query = array();
        $meta_query = array();


        if($what_to_show == 'x_featured_first' || $what_to_show == 'x_rand_featured_first') { 
            $meta_query[] = array(
                'key' => 'fave_featured',
                'value' => '0',
                'compare' => '='
            );
        }

        if ( isset( $_GET['tab'] ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_status',
                'field' => 'slug',
                'terms' => $_GET['tab']
            );
        }

        $states = get_post_meta( $page_id, 'fave_states', false );
        if ( ! empty( $states ) && is_array( $states ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_state',
                'field' => 'slug',
                'terms' => $states
            );
        }

        $locations = get_post_meta( $page_id, 'fave_locations', false );
        if ( ! empty( $locations ) && is_array( $locations ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_city',
                'field' => 'slug',
                'terms' => $locations
            );
        }

        $types = get_post_meta( $page_id, 'fave_types', false );
        if ( ! empty( $types ) && is_array( $types ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => $types
            );
        }

        $labels = get_post_meta( $page_id, 'fave_labels', false );
        if ( ! empty( $labels ) && is_array( $labels ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_label',
                'field' => 'slug',
                'terms' => $labels
            );
        }

        $fave_areas = get_post_meta( $page_id, 'fave_area', false );
        if ( ! empty( $fave_areas ) && is_array( $fave_areas ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_area',
                'field' => 'slug',
                'terms' => $fave_areas
            );
        }

        $features = get_post_meta( $page_id, 'fave_features', false );
        if ( ! empty( $features ) && is_array( $features ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_feature',
                'field' => 'slug',
                'terms' => $features
            );
        }

        if( !isset( $_GET['tab'] ) ) {
            $status = get_post_meta($page_id, 'fave_status', false);
            if (!empty($status) && is_array($status)) {
                $tax_query[] = array(
                    'taxonomy' => 'property_status',
                    'field' => 'slug',
                    'terms' => $status
                );
            }
        }

        $min_price = get_post_meta( $page_id, 'fave_min_price', true );
        $max_price = get_post_meta( $page_id, 'fave_max_price', true );

        // min and max price logic
        if (!empty($min_price) && !empty($max_price)) {
            $min_price = doubleval(houzez_clean($min_price));
            $max_price = doubleval(houzez_clean($max_price));

            if ($min_price >= 0 && $max_price > $min_price) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => array($min_price, $max_price),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN',
                );
            }
        } else if (!empty($min_price)) {
            $min_price = doubleval(houzez_clean($min_price));
            if ($min_price >= 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => $min_price,
                    'type' => 'NUMERIC',
                    'compare' => '>=',
                );
            }
        } else if (!empty($max_price)) {
            $max_price = doubleval(houzez_clean($max_price));
            if ($max_price >= 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => $max_price,
                    'type' => 'NUMERIC',
                    'compare' => '<=',
                );
            }
        }

        $meta_count = count($meta_query);
        if( $meta_count > 1 ) {
            $meta_query['relation'] = 'AND';
        }
        if ($meta_count > 0) {
            $property_query_args['meta_query'] = $meta_query;
        }


        $tax_count = count( $tax_query );
        if( $tax_count > 1 ) {
            $tax_query['relation'] = 'AND';
        }
        if( $tax_count > 0 ) {
            $property_query_args['tax_query'] = $tax_query;
        }
        //print_r($property_query_args);
        return $property_query_args;
    }
}
add_filter('houzez_property_filter', 'houzez_property_filter');

/*-----------------------------------------------------------------------------------*/
// Featured property filter - deprecated
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_featured_property_filter') ) {
    function houzez_featured_property_filter( $property_query_args ) {
        global $paged;

        $page_id = get_the_ID();
        $what_to_show = get_post_meta( $page_id, 'fave_properties_sort', true );
        $fave_featured_prop_no = get_post_meta( $page_id, 'fave_featured_prop_no', true );
        $fave_listings_tabs = get_post_meta( $page_id, 'fave_listings_tabs', true );

        $tax_query = array();
        $meta_query = array();

        if ( is_front_page()  ) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        }

        if(!$fave_featured_prop_no){
            $property_query_args[ 'posts_per_page' ]  = 4;
        } else {
            $property_query_args[ 'posts_per_page' ] = $fave_featured_prop_no;
        }

        if (!empty($paged)) {
            $property_query_args['paged'] = $paged;
        } else {
            $property_query_args['paged'] = 1;
        }

        $meta_query[] = array(
            'key' => 'fave_featured',
            'value' => '1',
            'compare' => '='
        );


        if($what_to_show == 'x_rand_featured_first') { 
            $property_query_args['orderby'] = 'rand';
        }

        if ( isset( $_GET['tab'] ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_status',
                'field' => 'slug',
                'terms' => $_GET['tab']
            );
        }

        $states = get_post_meta( $page_id, 'fave_states', false );
        if ( ! empty( $states ) && is_array( $states ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_state',
                'field' => 'slug',
                'terms' => $states
            );
        }

        $locations = get_post_meta( $page_id, 'fave_locations', false );
        if ( ! empty( $locations ) && is_array( $locations ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_city',
                'field' => 'slug',
                'terms' => $locations
            );
        }

        $types = get_post_meta( $page_id, 'fave_types', false );
        if ( ! empty( $types ) && is_array( $types ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => $types
            );
        }

        $features = get_post_meta( $page_id, 'fave_features', false );
        if ( ! empty( $features ) && is_array( $features ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_feature',
                'field' => 'slug',
                'terms' => $features
            );
        }

        if( !isset( $_GET['tab'] ) ) {
            $status = get_post_meta($page_id, 'fave_status', false);
            if (!empty($status) && is_array($status)) {
                $tax_query[] = array(
                    'taxonomy' => 'property_status',
                    'field' => 'slug',
                    'terms' => $status
                );
            }
        }

        $labels = get_post_meta( $page_id, 'fave_labels', false );
        if ( ! empty( $labels ) && is_array( $labels ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_label',
                'field' => 'slug',
                'terms' => $labels
            );
        }

        $fave_areas = get_post_meta( $page_id, 'fave_area', false );
        if ( ! empty( $fave_areas ) && is_array( $fave_areas ) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_area',
                'field' => 'slug',
                'terms' => $fave_areas
            );
        }

        $min_price = get_post_meta( $page_id, 'fave_min_price', false );
        $max_price = get_post_meta( $page_id, 'fave_max_price', false );

        // min and max price logic
        if (!empty($min_price) && !empty($max_price)) {
            $min_price = doubleval(houzez_clean($min_price));
            $max_price = doubleval(houzez_clean($max_price));

            if ($min_price >= 0 && $max_price > $min_price) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => array($min_price, $max_price),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN',
                );
            }
        } else if (!empty($min_price)) {
            $min_price = doubleval(houzez_clean($min_price));
            if ($min_price >= 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => $min_price,
                    'type' => 'NUMERIC',
                    'compare' => '>=',
                );
            }
        } else if (!empty($max_price)) {
            $max_price = doubleval(houzez_clean($max_price));
            if ($max_price >= 0) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => $max_price,
                    'type' => 'NUMERIC',
                    'compare' => '<=',
                );
            }
        }

        $meta_count = count($meta_query);
        if( $meta_count > 1 ) {
            $meta_query['relation'] = 'AND';
        }
        if ($meta_count > 0) {
            $property_query_args['meta_query'] = $meta_query;
        }


        $tax_count = count( $tax_query );
        if( $tax_count > 1 ) {
            $tax_query['relation'] = 'AND';
        }
        if( $tax_count > 0 ) {
            $property_query_args['tax_query'] = $tax_query;
        }

        return $property_query_args;
    }
}
add_filter('houzez_featured_property_filter', 'houzez_featured_property_filter');


/*-----------------------------------------------------------------------------------*/
// Properties search 2 - deprecated since v2.0
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_property_search_2') ) {
    function houzez_property_search_2($search_query)
    {

        
        return $search_query;
    }
}
add_filter('houzez_search_parameters_2', 'houzez_property_search_2');


/*-----------------------------------------------------------------------------------*/
/*  Get Properties for Header Map
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_houzez_header_map_listings', 'houzez_header_map_listings' );
add_action( 'wp_ajax_houzez_header_map_listings', 'houzez_header_map_listings' );
if( !function_exists('houzez_header_map_listings') ) {
    function houzez_header_map_listings() {
       
        $meta_query = array();
        $tax_query = array();
        $date_query = array();
        $allowed_html = array();
        $keyword_array =  '';

        
        $dummy_array = array();

        $custom_fields_values = isset($_POST['custom_fields_values']) ? $_POST['custom_fields_values'] : '';
        
        if(!empty($custom_fields_values)) {
            foreach ($custom_fields_values as $value) {
               $dummy_array[] = $value;
            }
        }


        $initial_city = isset($_POST['initial_city']) ? $_POST['initial_city'] : '';
        $features = isset($_POST['features']) ? $_POST['features'] : '';
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
        $country = isset($_POST['country']) ? ($_POST['country']) : '';
        $state = isset($_POST['state']) ? ($_POST['state']) : '';
        $location = isset($_POST['location']) ? ($_POST['location']) : '';
        $area = isset($_POST['area']) ? ($_POST['area']) : '';
        $status = isset($_POST['status']) ? ($_POST['status']) : '';
        $type = isset($_POST['type']) ? ($_POST['type']) : '';
        $label = isset($_POST['label']) ? ($_POST['label']) : '';
        $property_id = isset($_POST['property_id']) ? ($_POST['property_id']) : '';
        $bedrooms = isset($_POST['bedrooms']) ? ($_POST['bedrooms']) : '';
        $bathrooms = isset($_POST['bathrooms']) ? ($_POST['bathrooms']) : '';
        $min_price = isset($_POST['min_price']) ? ($_POST['min_price']) : '';
        $max_price = isset($_POST['max_price']) ? ($_POST['max_price']) : '';
        $currency = isset($_POST['currency']) ? ($_POST['currency']) : '';
        $min_area = isset($_POST['min_area']) ? ($_POST['min_area']) : '';
        $max_area = isset($_POST['max_area']) ? ($_POST['max_area']) : '';
        $publish_date = isset($_POST['publish_date']) ? ($_POST['publish_date']) : '';

        $search_location = isset( $_POST[ 'search_location' ] ) ? esc_attr( $_POST[ 'search_location' ] ) : false;
        $use_radius = isset( $_POST[ 'use_radius' ] ) && 'on' == $_POST[ 'use_radius' ];
        $search_lat = isset($_POST['search_lat']) ? (float) $_POST['search_lat'] : false;
        $search_long = isset($_POST['search_long']) ? (float) $_POST['search_long'] : false;
        $search_radius = isset($_POST['search_radius']) ? (int) $_POST['search_radius'] : false;


        $prop_locations = array();
        houzez_get_terms_array( 'property_city', $prop_locations );

        $keyword_field = houzez_option('keyword_field');
        $beds_baths_search = houzez_option('beds_baths_search');
        $property_id_prefix = houzez_option('property_id_prefix');

        $property_id = str_replace($property_id_prefix, "", $property_id);

        $search_criteria = '=';
        if( $beds_baths_search == 'greater') {
            $search_criteria = '>=';
        }

        $query_args = array(
            'post_type' => 'property',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        );

        $query_args = apply_filters('houzez_radius_filter', $query_args, $search_lat, $search_long, $search_radius, $use_radius, $search_location );

        $keyword = stripcslashes($keyword);

        if ( $keyword != '') {

            if( $keyword_field == 'prop_address' ) {
                $meta_keywork = wp_kses($keyword, $allowed_html);
                $address_array = array(
                    'key' => 'fave_property_map_address',
                    'value' => $meta_keywork,
                    'type' => 'CHAR',
                    'compare' => 'LIKE',
                );

                $street_array = array(
                    'key' => 'fave_property_address',
                    'value' => $meta_keywork,
                    'type' => 'CHAR',
                    'compare' => 'LIKE',
                );

                $zip_array = array(
                    'key' => 'fave_property_zip',
                    'value' => $meta_keywork,
                    'type' => 'CHAR',
                    'compare' => '=',
                );
                $propid_array = array(
                    'key' => 'fave_property_id',
                    'value' => str_replace($property_id_prefix, "", $meta_keywork),
                    'type' => 'CHAR',
                    'compare' => '=',
                );

                $keyword_array = array(
                    'relation' => 'OR',
                    $address_array,
                    $street_array,
                    $propid_array,
                    $zip_array
                );
            } else if( $keyword_field == 'prop_city_state_county' ) {
                $taxlocation[] = sanitize_title (  esc_html( wp_kses($keyword, $allowed_html) ) );

                $_tax_query = Array();
                $_tax_query['relation'] = 'OR';

                $_tax_query[] = array(
                    'taxonomy'     => 'property_area',
                    'field'        => 'slug',
                    'terms'        => $taxlocation
                );

                $_tax_query[] = array(
                    'taxonomy'     => 'property_city',
                    'field'        => 'slug',
                    'terms'        => $taxlocation
                );

                $_tax_query[] = array(
                    'taxonomy'      => 'property_state',
                    'field'         => 'slug',
                    'terms'         => $taxlocation
                );
                $tax_query[] = $_tax_query;

            } else {
                $keyword = trim( $keyword );
                if ( ! empty( $keyword ) ) {
                    $query_args['s'] = $keyword;
                }
            }
        }

        //Date Query
        if( !empty($publish_date) ) {
            $publish_date = explode('/', $publish_date);
            $query_args['date_query'] = array(
                array(
                    'year' => $publish_date[2],
                    'compare'   => '>=',
                ),
                array(
                    'month' => $publish_date[1],
                    'compare'   => '>=',
                ),
                array(
                    'day' => $publish_date[0],
                    'compare'   => '>=',
                )
            );
        }


        //Custom Fields
        if(class_exists('Houzez_Fields_Builder')) {
            $fields_array = Houzez_Fields_Builder::get_form_fields();
            if(!empty($fields_array)):
                
                foreach ( $fields_array as $key => $value ):
                    $field_title = $value->label;
                    $field_name = $value->field_id;
                    $is_search = $value->is_search;

                    if( $is_search == 'yes' ) {
                        if(!empty($dummy_array[$key])) {
                            $meta_query[] = array(
                                'key' => 'fave_'.$field_name,
                                'value' => $dummy_array[$key],
                                'type' => 'CHAR',
                                'compare' => '=',
                            );
                        }
                    }
                endforeach; endif;
        }

        if(!empty($currency)) {
            $meta_query[] = array(
                'key' => 'fave_currency',
                'value' => $currency,
                'type' => 'CHAR',
                'compare' => '=',
            );
        }

        // Meta Queries
        $meta_query[] = array(
            'key' => 'fave_property_map_address',
            'compare' => 'EXISTS',
        );

        // Property ID
        if( !empty( $property_id )  ) {
            $meta_query[] = array(
                'key' => 'fave_property_id',
                'value'   => $property_id,
                'type'    => 'char',
                'compare' => '=',
            );
        }

        if( !empty($location) && $location != 'all' ) {
            $tax_query[] = array(
                'taxonomy' => 'property_city',
                'field' => 'slug',
                'terms' => $location
            );

        } else {
            if( $location == 'all' ) {
                /*$tax_query[] = array(
                    'taxonomy' => 'property_city',
                    'field' => 'slug',
                    'terms' => $prop_locations
                );*/
            } else {
                if (!empty($initial_city)) {
                    $tax_query[] = array(
                        'taxonomy' => 'property_city',
                        'field' => 'slug',
                        'terms' => $initial_city
                    );
                }
            }
        }

        if( !empty($area) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_area',
                'field' => 'slug',
                'terms' => $area
            );
        }
        if( !empty($state) ) {
            $tax_query[] = array(
                'taxonomy'      => 'property_state',
                'field'         => 'slug',
                'terms'         => $state
            );
        }

        if( !empty( $country ) ) {
            $meta_query[] = array(
                'key' => 'fave_property_country',
                'value'   => $country,
                'type'    => 'CHAR',
                'compare' => '=',
            );
        }

        if( !empty($status) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_status',
                'field' => 'slug',
                'terms' => $status
            );
        }
        if( !empty($type) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => $type
            );
        }

        if ( !empty($label) ) {
            $tax_query[] = array(
                'taxonomy' => 'property_label',
                'field' => 'slug',
                'terms' => $label
            );
        }

        if( !empty( $features ) ) {

            foreach ($features as $feature):
                $tax_query[] = array(
                    'taxonomy' => 'property_feature',
                    'field' => 'slug',
                    'terms' => $feature
                );
            endforeach;
        }

        // bedrooms logic
        if( !empty( $bedrooms ) && $bedrooms != 'any'  ) {
            $bedrooms = sanitize_text_field($bedrooms);
            $meta_query[] = array(
                'key' => 'fave_property_bedrooms',
                'value'   => $bedrooms,
                'type'    => 'CHAR',
                'compare' => $search_criteria,
            );
        }

        // bathrooms logic
        if( !empty( $bathrooms ) && $bathrooms != 'any'  ) {
            $bathrooms = sanitize_text_field($bathrooms);
            $meta_query[] = array(
                'key' => 'fave_property_bathrooms',
                'value'   => $bathrooms,
                'type'    => 'CHAR',
                'compare' => $search_criteria,
            );
        }

        // min and max price logic
        if( !empty( $min_price ) && $min_price != 'any' && !empty( $max_price ) && $max_price != 'any' ) {
            $min_price = doubleval( houzez_clean( $min_price ) );
            $max_price = doubleval( houzez_clean( $max_price ) );

            if( $min_price > 0 && $max_price > $min_price ) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => array($min_price, $max_price),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN',
                );
            }
        } else if( !empty( $min_price ) && $min_price != 'any'  ) {
            $min_price = doubleval( houzez_clean( $min_price ) );
            if( $min_price > 0 ) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => $min_price,
                    'type' => 'NUMERIC',
                    'compare' => '>=',
                );
            }
        } else if( !empty( $max_price ) && $max_price != 'any'  ) {
            $max_price = doubleval( houzez_clean( $max_price ) );
            if( $max_price > 0 ) {
                $meta_query[] = array(
                    'key' => 'fave_property_price',
                    'value' => $max_price,
                    'type' => 'NUMERIC',
                    'compare' => '<=',
                );
            }
        }

        // min and max area logic
        if( !empty( $min_area ) && !empty( $max_area ) ) {
            $min_area = intval( $min_area );
            $max_area = intval( $max_area );

            if( $min_area > 0 && $max_area > $min_area ) {
                $meta_query[] = array(
                    'key' => 'fave_property_size',
                    'value' => array($min_area, $max_area),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN',
                );
            }

        } else if( !empty( $max_area ) ) {
            $max_area = intval( $max_area );
            if( $max_area > 0 ) {
                $meta_query[] = array(
                    'key' => 'fave_property_size',
                    'value' => $max_area,
                    'type' => 'NUMERIC',
                    'compare' => '<=',
                );
            }
        } else if( !empty( $min_area ) ) {
            $min_area = intval( $min_area );
            if( $min_area > 0 ) {
                $meta_query[] = array(
                    'key' => 'fave_property_size',
                    'value' => $min_area,
                    'type' => 'NUMERIC',
                    'compare' => '>=',
                );
            }
        }

        $meta_count = count($meta_query);

        if( $meta_count > 0 || !empty($keyword_array)) {
            $query_args['meta_query'] = array(
                'relation' => 'AND',
                $keyword_array,
                array(
                    'relation' => 'AND',
                    $meta_query
                ),
            );
        }

        $tax_count = count($tax_query);


        $tax_query['relation'] = 'AND';


        if( $tax_count > 0 ) {
            $query_args['tax_query']  = $tax_query;
        }


        $query_args = new WP_Query( $query_args );


        $properties = array();

        while( $query_args->have_posts() ): $query_args->the_post();

            $post_id = get_the_ID();
            $property_location = get_post_meta( get_the_ID(),'fave_property_location',true);
            $lat_lng = explode(',', $property_location);
            $prop_images        = get_post_meta( get_the_ID(), 'fave_property_images', false );
            $prop_featured       = get_post_meta( get_the_ID(), 'fave_featured', true );
            $prop_type = wp_get_post_terms( get_the_ID(), 'property_type', array("fields" => "ids") );

            $prop = new stdClass();

            $prop->id = $post_id;
            $prop->title = get_the_title();
            $prop->sanitizetitle = sanitize_title(get_the_title());
            $prop->lat = $lat_lng[0];
            $prop->lng = $lat_lng[1];
            $prop->bedrooms = get_post_meta( get_the_ID(), 'fave_property_bedrooms', true );
            $prop->bathrooms = get_post_meta( get_the_ID(), 'fave_property_bathrooms', true );
            $prop->address = get_post_meta( get_the_ID(), 'fave_property_map_address', true );
            $prop->thumbnail = get_the_post_thumbnail( $post_id, 'houzez-property-thumb-image' );
            $prop->url = get_permalink();
            $prop->prop_meta = houzez_listing_meta_v1();
            $prop->type = houzez_taxonomy_simple('property_type');
            $prop->images_count = count( $prop_images );
            $prop->price = houzez_listing_price_v1();
            $prop->pricePin = houzez_listing_price_map_pins();

            foreach( $prop_type as $term_id ) {
                $icon = get_tax_meta( $term_id, 'fave_prop_type_icon');
                $retinaIcon = get_tax_meta( $term_id, 'fave_prop_type_icon_retina');

                $prop->term_id = $term_id;

                if( !empty($icon['src']) ) {
                    $prop->icon = $icon['src'];
                } else {
                    $prop->icon = get_template_directory_uri() . '/images/map/pin-single-family.png';
                }
                if( !empty($retinaIcon['src']) ) {
                    $prop->retinaIcon = $retinaIcon['src'];
                } else {
                    $prop->retinaIcon = get_template_directory_uri() . '/images/map/pin-single-family.png';
                }
            }

            array_push($properties, $prop);

        endwhile;

        wp_reset_postdata();

        if( count($properties) > 0 ) {
            echo json_encode( array( 'getProperties' => true, 'properties' => $properties ) );
            exit();
        } else {
            echo json_encode( array( 'getProperties' => false ) );
            exit();
        }
        die();
    }
}


/*-----------------------------------------------------------------------------------*/
/*  Get Properties for Half Map listings - deprecated since v2.0
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_half_map_listings') ) {
    function houzez_half_map_listings() {
        
    }
}

/*-----------------------------------------------------------------------------------*/
// Add to favorite
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_houzez_add_to_favorite', 'houzez_favorites' );
if( !function_exists( 'houzez_favorites' ) ) {
    // a:1:{i:0;i:543;}
    function houzez_favorites () {
        global $current_user;
        wp_get_current_user();
        $userID      =   $current_user->ID;
        $fav_option = 'houzez_favorites-'.$userID;
        $property_id = intval( $_POST['listing_id'] );
        $current_prop_fav = get_option( 'houzez_favorites-'.$userID );

        // Check if empty or not
        if( empty( $current_prop_fav ) ) {
            $prop_fav = array();
            $prop_fav['1'] = $property_id;
            update_option( $fav_option, $prop_fav );
            $arr = array( 'added' => true, 'response' => esc_html__('Added', 'houzez') );
            echo json_encode($arr);
            wp_die();
        } else {
            if(  ! in_array ( $property_id, $current_prop_fav )  ) {
                $current_prop_fav[] = $property_id;
                update_option( $fav_option,  $current_prop_fav );
                $arr = array( 'added' => true, 'response' => esc_html__('Added', 'houzez') );
                echo json_encode($arr);
                wp_die();
            } else {
                $key = array_search( $property_id, $current_prop_fav );

                if( $key != false ) {
                    unset( $current_prop_fav[$key] );
                }

                update_option( $fav_option, $current_prop_fav );
                $arr = array( 'added' => false, 'response' => esc_html__('Removed', 'houzez') );
                echo json_encode($arr);
                wp_die();
            }
        }
        wp_die();
    }
}

/*-----------------------------------------------------------------------------------*/
/*  Properties sorting
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'houzez_prop_sort' ) ){

    function houzez_prop_sort( $query_args ) {
        $sort_by = '';
        if ( isset( $_GET['sortby'] ) ) {
            $sort_by = $_GET['sortby'];
        } else {

            if ( houzez_is_listings_template() ) {
                $sort_by = get_post_meta( get_the_ID(), 'fave_properties_sort', true );

            } else if( is_page_template( array( 'template/template-search.php' )) ) {
                
                $sort_by = houzez_option('search_default_order');
                
            } else if ( is_tax() ) {
                $sort_by = houzez_option('taxonomy_default_order');
                
            } else if(is_singular('houzez_agent')) {
                $sort_by = houzez_option('agent_listings_order');

            } else if(is_singular('houzez_agency')) {
                $sort_by = houzez_option('agency_listings_order');

            }
        }

        if ( $sort_by == 'a_price' ) {
            $query_args['orderby'] = 'meta_value_num';
            $query_args['meta_key'] = 'fave_property_price';
            $query_args['order'] = 'ASC';
        } else if ( $sort_by == 'd_price' ) {
            $query_args['orderby'] = 'meta_value_num';
            $query_args['meta_key'] = 'fave_property_price';
            $query_args['order'] = 'DESC';
        } else if ( $sort_by == 'featured' ) {
            $query_args['meta_key'] = 'fave_featured';
            $query_args['meta_value'] = '1';
            $query_args['orderby'] = 'meta_value date';
        } else if ( $sort_by == 'a_date' ) {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'ASC';
        } else if ( $sort_by == 'd_date' ) {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'DESC';
        } else if ( $sort_by == 'featured_first' ) {
            $query_args['orderby'] = 'meta_value date';
            $query_args['meta_key'] = 'fave_featured';
        } else if ( $sort_by == 'featured_top' ) {
            $query_args['orderby'] = 'meta_value date';
            $query_args['meta_key'] = 'fave_featured';
        }

        return apply_filters( 'houzez_sort_properties', $query_args );

    }
}


/*-----------------------------------------------------------------------------------*/
// Remove property attachments
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_houzez_remove_property_thumbnail', 'houzez_remove_property_thumbnail' );
add_action( 'wp_ajax_nopriv_houzez_remove_property_thumbnail', 'houzez_remove_property_thumbnail' );
if( !function_exists('houzez_remove_property_thumbnail') ) {
    function houzez_remove_property_thumbnail() {

        $nonce = $_POST['removeNonce'];
        $remove_attachment = false;
        if (!wp_verify_nonce($nonce, 'verify_gallery_nonce')) {

            echo json_encode(array(
                'remove_attachment' => false,
                'reason' => esc_html__('Invalid Nonce', 'houzez')
            ));
            wp_die();
        }

        if (isset($_POST['thumb_id']) && isset($_POST['prop_id'])) {
            $thumb_id = intval($_POST['thumb_id']);
            $prop_id = intval($_POST['prop_id']);

            $property_status = get_post_status ( $prop_id );

            if ( $thumb_id > 0 && $prop_id > 0 && $property_status != "draft" ) {
                delete_post_meta($prop_id, 'fave_property_images', $thumb_id);
                $remove_attachment = wp_delete_attachment($thumb_id);
            } elseif ( $thumb_id > 0 && $prop_id > 0 && $property_status == "draft" ) {
                delete_post_meta($prop_id, 'fave_property_images', $thumb_id);
                $remove_attachment = true;
            } elseif ($thumb_id > 0) {
                if( false == wp_delete_attachment( $thumb_id )) {
                    $remove_attachment = false;
                } else {
                    $remove_attachment = true;
                }
            }
        }

        echo json_encode(array(
            'remove_attachment' => $remove_attachment,
        ));
        wp_die();

    }
}

/*-----------------------------------------------------------------------------------*/
/*   Upload property gallery images
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_houzez_property_img_upload', 'houzez_property_img_upload' );    // only for logged in user
add_action( 'wp_ajax_nopriv_houzez_property_img_upload', 'houzez_property_img_upload' );
if( !function_exists( 'houzez_property_img_upload' ) ) {
    function houzez_property_img_upload( ) {

        // Check security Nonce
        $verify_nonce = $_REQUEST['verify_nonce'];
        if ( ! wp_verify_nonce( $verify_nonce, 'verify_gallery_nonce' ) ) {
            echo json_encode( array( 'success' => false , 'reason' => 'Invalid nonce!' ) );
            die;
        }

        $submitted_file = $_FILES['property_upload_file'];
        $uploaded_image = wp_handle_upload( $submitted_file, array( 'test_form' => false ) );

        if ( isset( $uploaded_image['file'] ) ) {
            $file_name          =   basename( $submitted_file['name'] );
            $file_type          =   wp_check_filetype( $uploaded_image['file'] );

            // Prepare an array of post data for the attachment.
            $attachment_details = array(
                'guid'           => $uploaded_image['url'],
                'post_mime_type' => $file_type['type'],
                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            $attach_id      =   wp_insert_attachment( $attachment_details, $uploaded_image['file'] );
            $attach_data    =   wp_generate_attachment_metadata( $attach_id, $uploaded_image['file'] );
            wp_update_attachment_metadata( $attach_id, $attach_data );

            $thumbnail_url = wp_get_attachment_image_src( $attach_id, 'houzez-item-image-1' );

            $feat_image_url = wp_get_attachment_url( $attach_id );

            $ajax_response = array(
                'success'   => true,
                'url' => $thumbnail_url[0],
                'attachment_id'    => $attach_id,
                'full_image'    => $feat_image_url
            );

            echo json_encode( $ajax_response );
            die;

        } else {
            $ajax_response = array( 'success' => false, 'reason' => 'Image upload failed!' );
            echo json_encode( $ajax_response );
            die;
        }

    }
}


/*-----------------------------------------------------------------------------------*/
/*   Upload property gallery images
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_houzez_property_attachment_upload', 'houzez_property_attachment_upload' );    // only for logged in user
add_action( 'wp_ajax_nopriv_houzez_property_attachment_upload', 'houzez_property_attachment_upload' );
if( !function_exists( 'houzez_property_attachment_upload' ) ) {
    function houzez_property_attachment_upload( ) {

        // Check security Nonce
        $verify_nonce = $_REQUEST['verify_nonce'];
        if ( ! wp_verify_nonce( $verify_nonce, 'verify_gallery_nonce' ) ) {
            echo json_encode( array( 'success' => false , 'reason' => 'Invalid nonce!' ) );
            die;
        }

        $submitted_file = $_FILES['property_attachment_file'];
        $uploaded_image = wp_handle_upload( $submitted_file, array( 'test_form' => false ) );

        if ( isset( $uploaded_image['file'] ) ) {
            $file_name          =   basename( $submitted_file['name'] );
            $file_type          =   wp_check_filetype( $uploaded_image['file'] );

            // Prepare an array of post data for the attachment.
            $attachment_details = array(
                'guid'           => $uploaded_image['url'],
                'post_mime_type' => $file_type['type'],
                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            $attach_id      =   wp_insert_attachment( $attachment_details, $uploaded_image['file'] );
            $attach_data    =   wp_generate_attachment_metadata( $attach_id, $uploaded_image['file'] );
            wp_update_attachment_metadata( $attach_id, $attach_data );

            $thumbnail_url = wp_get_attachment_image_src( $attach_id, 'full' );
            $attachment_title = get_the_title($attach_id);
            $fullimage_url = wp_get_attachment_url( $attach_id );

            $ajax_response = array(
                'success'   => true,
                'url' => $thumbnail_url[0],
                'attachment_id'    => $attach_id,
                'full_image'    => $fullimage_url,
                'attach_title'    => $attachment_title,
            );

            echo json_encode( $ajax_response );
            die;

        } else {
            $ajax_response = array( 'success' => false, 'reason' => 'File upload failed!' );
            echo json_encode( $ajax_response );
            die;
        }

    }
}

/*-----------------------------------------------------------------------------------*/
/*  Houzez get ajax single property
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_houzez_get_single_property', 'houzez_get_single_property' );
add_action( 'wp_ajax_houzez_get_single_property', 'houzez_get_single_property' );

if( !function_exists('houzez_get_single_property') ) {
    function houzez_get_single_property() {
        check_ajax_referer('houzez_map_ajax_nonce', 'security');

        $prop_id = isset($_POST['prop_id']) ? sanitize_text_field($_POST['prop_id']) : '';

        $args = array(
            'p' => $prop_id,
            'posts_per_page' => 1,
            'post_type' => 'property',
            'post_status' => 'publish'
        );


        $query = new WP_Query($args);
        $props = array();

        while( $query->have_posts() ) {
            $query->the_post();

            $post_id = get_the_ID();
            $property_location = get_post_meta( get_the_ID(),'fave_property_location',true);
            $lat_lng = explode(',', $property_location);
            $prop_images        = get_post_meta( get_the_ID(), 'fave_property_images', false );
            $prop_featured       = get_post_meta( get_the_ID(), 'fave_featured', true );
            $prop_type = wp_get_post_terms( get_the_ID(), 'property_type', array("fields" => "ids") );

            $prop = new stdClass();

            $prop->id = $post_id;
            $prop->title = get_the_title();
            $prop->lat = $lat_lng[0];
            $prop->lng = $lat_lng[1];
            $prop->bedrooms = get_post_meta( get_the_ID(), 'fave_property_bedrooms', true );
            $prop->bathrooms = get_post_meta( get_the_ID(), 'fave_property_bathrooms', true );
            $prop->address = get_post_meta( get_the_ID(), 'fave_property_map_address', true );
            $prop->thumbnail = get_the_post_thumbnail( $post_id, 'houzez-property-thumb-image' );
            $prop->url = get_permalink();
            $prop->prop_meta = houzez_listing_meta_v1();
            $prop->type = houzez_taxonomy_simple('property_type');
            $prop->images_count = count( $prop_images );
            $prop->price = houzez_listing_price_v1();
            $prop->pricePin = houzez_listing_price_map_pins();

            foreach( $prop_type as $term_id ) {
                $icon = get_tax_meta( $term_id, 'fave_prop_type_icon');
                $retinaIcon = get_tax_meta( $term_id, 'fave_prop_type_icon_retina');

                $prop->term_id = $term_id;

                if( !empty($icon['src']) ) {
                    $prop->icon = $icon['src'];
                } else {
                    $prop->icon = get_template_directory_uri() . '/images/map/pin-single-family.png';
                }
                if( !empty($retinaIcon['src']) ) {
                    $prop->retinaIcon = $retinaIcon['src'];
                } else {
                    $prop->retinaIcon = get_template_directory_uri() . '/images/map/pin-single-family.png';
                }
            }

            array_push($props, $prop);
        }

        wp_reset_postdata();

        if(count($props) > 0) {
            echo json_encode(array('getprops'=>true, 'props'=>$props));
            exit();
        } else {
            echo json_encode(array('getprops'=>false));
            exit();
        }

        die();

    }
}


/*-----------------------------------------------------------------------------------*/
/*  Houzez Print Property
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_houzez_create_print', 'houzez_create_print' );
add_action( 'wp_ajax_houzez_create_print', 'houzez_create_print' );

if( !function_exists('houzez_create_print')) {
    function houzez_create_print () {

        if(!isset($_POST['propid'])|| !is_numeric($_POST['propid'])){
            exit();
        }
        global $hide_fields;
        $hide_fields = houzez_option('hide_detail_prop_fields');
        $property_id = intval($_POST['propid']);
    
        print  '<html><head><link href="'.get_stylesheet_uri().'" rel="stylesheet" type="text/css" />';
        print  '<html><head><link href="'.HOUZEZ_CSS_DIR_URI.'bootstrap.min.css" rel="stylesheet" type="text/css" />';
        print  '<html><head><link href="'.HOUZEZ_CSS_DIR_URI.'main.css" rel="stylesheet" type="text/css" />';
        print  '<html><head><link href="'.HOUZEZ_CSS_DIR_URI.'icons.css" rel="stylesheet" type="text/css" />';
        print  '<html><head><link href="'.HOUZEZ_CSS_DIR_URI.'font-awesome.min.css" rel="stylesheet" type="text/css" />';

        if( is_rtl() ) {
            print '<link href="'.HOUZEZ_CSS_DIR_URI.'/rtl.css" rel="stylesheet" type="text/css" />';
            print '<link href="'.HOUZEZ_CSS_DIR_URI.'/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />';
        }
        print '</head>';
        print  '<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script><script>$(window).load(function(){ print(); });</script>';
        print  '<body class="print-page">';

        $print_logo = houzez_option( 'print_page_logo', false, 'url' );

        $print_agent = houzez_option('print_agent');
        $print_description = houzez_option('print_description');
        $print_details = houzez_option('print_details');
        $print_details_additional = houzez_option('print_details_additional');
        $print_features = houzez_option('print_features');
        $print_floorplans = houzez_option('print_floorplans');
        $print_gallery = houzez_option('print_gallery');
        $print_gr_code = houzez_option('print_gr_code');

        $args = array(
            'post_type' => 'property',
            'p' => $property_id,
        );

        $the_query = new WP_Query($args);

        if($the_query->have_posts()): 
            while($the_query->have_posts()): $the_query->the_post(); 
                global $features, $energy_class;
                $image_id     = get_post_thumbnail_id( get_the_ID() );
                $full_img     = wp_get_attachment_image_src($image_id, 'full');
                $full_img     = $full_img [0];
                $features     = wp_get_post_terms( get_the_ID(), 'property_feature', array("fields" => "all"));
                $energy_class = houzez_get_listing_data('energy_class');
                $floor_plans  = get_post_meta( get_the_ID(), 'floor_plans', true );
                $prop_images  = get_post_meta( get_the_ID(), 'fave_property_images', false );
                $agent_array = houzez20_property_contact_form();

        ?>

            <div class="print-main-wrap">
                <div class="print-wrap">
                    <header class="print-header">
                        <div class="print-logo-wrap">
                            <div class="logo">
                                <a href="#">
                                    <img src="<?php echo esc_url($print_logo); ?>" alt="logo">
                                </a>
                            </div><!-- .logo -->
                            <div class="primary-text"><?php bloginfo( 'description' ); ?></div>
                        </div><!-- print-logo-wrap -->
                        
                        <div class="print-title-wrap">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <?php get_template_part('property-details/partials/title'); ?>      
                                    <?php get_template_part('property-details/partials/item-address'); ?>
                                </div>          
                                <?php get_template_part('property-details/partials/item-price'); ?>
                            </div><!-- d-flex -->
                        </div><!-- print-title-wrap -->
                        
                        <?php if( !empty($full_img) ) { ?>
                        <div class="print-banner-wrap">
                            <?php if($print_gr_code != 0) { ?>
                            <div class="qr-code">
                                <img class="img-fluid" src="https://chart.googleapis.com/chart?chs=105x104&cht=qr&chl=<?php echo esc_url( get_permalink($property_id) ); ?>&choe=UTF-8" title="<?php echo esc_attr(get_the_title()); ?>" />
                            </div>
                            <?php } ?>
                            <img class="img-fluid" src="<?php echo esc_url( $full_img ); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                        </div><!-- print-banner-wrap -->
                        <?php } ?>
                        
                        <?php 
                        if( $print_agent != 0 && !empty($agent_array)) { ?>
                        <div class="print-agent-info-wrap">
                            
                            <h2 class="print-title"><?php echo esc_html__('Contact Information', 'houzez'); ?></h2>
                            
                            <div class="agent-details">
                                <div class="d-flex align-items-center">
                                    <?php if(!empty($agent_array['picture'])) { ?>
                                    <div class="agent-image">
                                        <img class="rounded" src="<?php echo esc_url($agent_array['picture']); ?>" alt="<?php echo esc_attr($agent_array['agent_name']); ?>" width="80" height="80">
                                    </div>
                                    <?php } ?>

                                    <ul class="list-unstyled m-0 ml-3 mr-3>
                                        <li class="agent-name">
                                            <i class="houzez-icon icon-single-neutral mr-1"></i> <?php echo esc_attr($agent_array['agent_name']); ?>
                                        </li>
                                        <li class="agent-phone-wrap clearfix">
                                            <?php if(!empty($agent_array['agent_phone'])) { ?>
                                            <i class="houzez-icon icon-phone mr-1"></i> <strong><?php echo esc_attr($agent_array['agent_phone']); ?></strong>
                                            <?php } ?>

                                            <?php if(!empty($agent_array['agent_mobile'])) { ?>
                                            <i class="houzez-icon icon-mobile-phone mr-1"></i> <strong><?php echo esc_attr($agent_array['agent_mobile']); ?></strong>
                                            <?php } ?>
                                        </li>

                                        <?php if(!empty($agent_array['agent_email'])) { ?>
                                        <li><i class="houzez-icon icon-envelope mr-1"></i> <strong><?php echo esc_attr($agent_array['agent_email']); ?></strong></li>
                                        <?php } ?>
                                    </ul>
                                </div><!-- d-flex -->
                            </div><!-- agent-details -->
                        </div><!-- print-agent-info-wrap -->
                        <?php } ?>

                    </header>  

                    
                    <section class="print-content">
                        
                        <?php 
                        if( $print_description != 0 ) { ?>

                            <div class="print-section">
                                <h2 class="print-title"><?php echo esc_html__('Description', 'houzez'); ?></h2>
                                <?php the_content(); ?>       
                            </div>

                        <?php } ?>

                        <?php 
                        if( $print_details != 0 ) { ?>

                            <div class="print-section">
                                <h2 class="print-title"><?php echo esc_html__('Detail', 'houzez'); ?></h2>
                                <div class="block-content-wrap">
                                    <?php get_template_part('property-details/partials/details'); ?> 
                                </div><!-- block-content-wrap -->
                            </div>

                        <?php } ?>

                        <?php 
                        if( $print_features != 0 && !empty($features)) { ?>

                            <div class="print-section">
                                <h2 class="print-title"><?php echo esc_html__('Features', 'houzez'); ?></h2>
                                <div class="block-content-wrap">
                                    <?php get_template_part('property-details/partials/features'); ?>  
                                </div><!-- block-content-wrap -->
                            </div>

                        <?php } ?>

                        <?php
                        if( houzez_option('print_energy_class') != 0 && !empty($energy_class) ) { ?>
                            <div class="print-section">
                                <h2 class="print-title"><?php echo esc_html__('Energy Efficiency', 'houzez'); ?></h2>
                                <div class="block-content-wrap">
                                    <?php get_template_part('property-details/partials/energy-class'); ?> 
                                </div><!-- block-content-wrap -->
                            </div><!-- print-section -->
                        <?php } ?>

                        <?php 
                        if( !empty( $floor_plans ) && $print_floorplans != 0 ) { ?>

                            <div class="print-section">
                                <h2 class="print-title"><?php echo esc_html__('Floor Plans', 'houzez'); ?></h2>
                                
                                <?php 
                                foreach( $floor_plans as $plan ):
                                    $price_postfix = '';
                                    if( !empty( $plan['fave_plan_price_postfix'] ) ) {
                                        $price_postfix = ' / '.$plan['fave_plan_price_postfix'];
                                    }
                                    $filetype = wp_check_filetype($plan['fave_plan_image']);
                                ?>
                                <div class="floor-plan-wrap">
                                    <div class="floor-plan-top">
                                        <div class="d-flex align-items-center">
                                            <div class="accordion-title flex-grow-1">
                                                <?php echo esc_attr( $plan['fave_plan_title'] ); ?>
                                            </div><!-- accordion-title -->
                                            <ul class="floor-information list-unstyled list-inline m-0">
                                                <?php if( !empty( $plan['fave_plan_size'] ) ) { ?>
                                                    <li class="list-inline-item">
                                                        <?php esc_html_e( 'Size', 'houzez' ); ?>: 
                                                        <strong> <?php echo esc_attr( $plan['fave_plan_size'] ); ?></strong>
                                                    </li>
                                                <?php } ?>

                                                <?php if( !empty( $plan['fave_plan_rooms'] ) ) { ?>
                                                    <li class="list-inline-item">
                                                        <i class="houzez-icon icon-hotel-double-bed-1 mr-1"></i>
                                                        <strong><?php echo esc_attr( $plan['fave_plan_rooms'] ); ?></strong>
                                                    </li>
                                                <?php } ?>

                                                <?php if( !empty( $plan['fave_plan_bathrooms'] ) ) { ?>
                                                    <li class="list-inline-item">
                                                        <i class="houzez-icon icon-bathroom-shower-1 mr-1"></i>
                                                        <strong><?php echo esc_attr( $plan['fave_plan_bathrooms'] ); ?></strong>
                                                    </li>
                                                <?php } ?>

                                                <?php if( !empty( $plan['fave_plan_price'] ) ) { ?>
                                                    <li class="list-inline-item">
                                                        <?php esc_html_e( 'Price', 'houzez' ); ?>: 
                                                        <strong><?php echo houzez_get_property_price( $plan['fave_plan_price'] ).$price_postfix; ?></strong>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div><!-- d-flex -->
                                    </div><!-- floor-plan-top -->
                                    
                                    <?php 
                                    if( !empty( $plan['fave_plan_image'] ) ) { ?>
                    
                                        <?php if($filetype['ext'] != 'pdf' ) {?>
                                        <a href="<?php echo esc_url( $plan['fave_plan_image'] ); ?>" target="_blank">
                                            <img class="img-fluid" src="<?php echo esc_url( $plan['fave_plan_image'] ); ?>" alt="image">
                                        </a>
                                        <?php } ?>
                                        
                                    <?php } ?>

                                    <?php
                                    if( !empty( $plan['fave_plan_description'] ) ) { ?>
                                    <div class="floor-plan-description mt-3">
                                        <p>
                                            <?php echo wp_kses_post( $plan['fave_plan_description'] ); ?>
                                        </p>
                                    </div><!-- floor-plan-description -->
                                    <?php } ?>

                                </div><!-- floor-plan-wrap -->
                                <?php endforeach; ?>

                            </div>
                        <?php } ?>


                        <?php 
                        if( !empty( $prop_images ) && $print_gallery != 0 ) { ?>
                        <div class="print-section">
                            <h2 class="print-title"><?php esc_html_e('Property images', 'houzez'); ?></h2>
                            <?php foreach( $prop_images as $img_id ): ?>
                                <div class="print-gallery-image"> <?php echo wp_get_attachment_image( $img_id, 'full', "", array('class' => 'img-fluid mb-3') ); ?> </div>
                            <?php endforeach; ?>
                        </div>
                        <?php } ?>


                    </section>
                </div><!-- print-wrap -->
            </div><!-- print-main-wrap -->

        <?php
            endwhile;
        endif;

        ?>

<?php
        print '</body></html>';
        wp_die();
    }
}

/*-----------------------------------------------------------------------------------*/
// Get Current Area | @return mixed|string|void
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'houzez_get_current_area' ) ) {

    function houzez_get_current_area() {

        if ( isset( $_COOKIE[ "houzez_current_area" ] ) ) {
            $current_area = $_COOKIE[ "houzez_current_area" ];
        }

        if ( empty( $current_area ) ) {
            $current_area = houzez_option('houzez_base_area');
        }

        return $current_area;
    }
}

/*-----------------------------------------------------------------------------------*/
// Ajax Area Switch
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'houzez_switch_area' ) ) {

    function houzez_switch_area() {

        if ( isset( $_POST[ 'switch_to_area' ] ) ):

            $expiry_period = '';

            $switch_to_area = $_POST[ 'switch_to_area' ];

            // expiry time
            $expiry_period = intval( $expiry_period );
            if ( ! $expiry_period ) {
                $expiry_period = 60 * 60;   // one hour
            }
            $expiry = time() + $expiry_period;

            // save cookie
            if ( setcookie( 'houzez_current_area', $switch_to_area, $expiry, '/' ) ) {
                echo json_encode( array(
                    'success' => true
                ) );
            } else {
                echo json_encode( array(
                    'success' => false,
                    'message' => __( "Failed to updated cookie !", 'houzez' )
                ) );
            }

        else:
            echo json_encode( array(
                    'success' => false,
                    'message' => __( "Invalid Request !", 'houzez' )
                )
            );
        endif;

        die;

    }

    add_action( 'wp_ajax_nopriv_houzez_switch_area', 'houzez_switch_area' );
    add_action( 'wp_ajax_houzez_switch_area', 'houzez_switch_area' );
}


if( !function_exists('houzez_get_area_size') ) {
    function houzez_get_area_size( $areaSize ) {
        $prop_size = $areaSize;
        $prop_area_size = '';
        $houzez_base_area = houzez_option('houzez_base_area');

        if( !empty( $prop_size ) ) {

            if( isset( $_COOKIE[ "houzez_current_area" ] ) ) {
                if( $_COOKIE[ "houzez_current_area" ] == 'sq_meter' && $houzez_base_area != 'sq_meter'  ) {
                    $prop_size = $prop_size * 0.09290304; //m2 = ft2 x 0.09290304

                } elseif( $_COOKIE[ "houzez_current_area" ] == 'sqft' && $houzez_base_area != 'sqft' ) {
                    $prop_size = $prop_size / 0.09290304; //ft2 = m2 ÷ 0.09290304
                }
            }

            $prop_area_size = esc_attr( round( $prop_size ) );

        }
        return $prop_area_size;

    }
}

if( !function_exists('houzez_get_size_unit') ) {
    function houzez_get_size_unit( $areaUnit ) {
        $measurement_unit_global = houzez_option('measurement_unit_global');
        $area_switcher_enable = houzez_option('area_switcher_enable');

        if( $area_switcher_enable != 0 ) {
            $prop_size_prefix = houzez_option('houzez_base_area');

            if( isset( $_COOKIE[ "houzez_current_area" ] ) ) {
                $prop_size_prefix =$_COOKIE[ "houzez_current_area" ];
            }

            if( $prop_size_prefix == 'sqft' ) {
                $prop_size_prefix = houzez_option('measurement_unit_sqft_text');
            } elseif( $prop_size_prefix == 'sq_meter' ) {
                $prop_size_prefix = houzez_option('measurement_unit_square_meter_text');
            }

        } else {
            if ($measurement_unit_global == 1) {
                $prop_size_prefix = houzez_option('measurement_unit');

                if( $prop_size_prefix == 'sqft' ) {
                    $prop_size_prefix = houzez_option('measurement_unit_sqft_text');
                } elseif( $prop_size_prefix == 'sq_meter' ) {
                    $prop_size_prefix = houzez_option('measurement_unit_square_meter_text');
                }

            } else {
                $prop_size_prefix = $areaUnit;
            }
        }
        return $prop_size_prefix;
    }
}

if( !function_exists('houzez_autocomplete_search') ) {
    function houzez_autocomplete_search() {

        return;
    }
}

if( !function_exists('houzez_generate_invoice') ):
    function houzez_generate_invoice( $billingFor, $billionType, $packageID, $invoiceDate, $userID, $featured, $upgrade, $paypalTaxID, $paymentMethod, $is_package = 0 ) {

        $total_taxes = 0;
        $price_per_submission = houzez_option('price_listing_submission');
        $price_featured_submission = houzez_option('price_featured_listing_submission');

        $price_per_submission      = floatval( $price_per_submission );
        $price_featured_submission = floatval( $price_featured_submission );

        $args = array(
            'post_title'    => 'Invoice ',
            'post_status'   => 'publish',
            'post_type'     => 'houzez_invoice'
        );
        $inserted_post_id =  wp_insert_post( $args );

        if( $billionType != 'one_time' ) {
            $billionType = __( 'Recurring', 'houzez' );
        } else {
            $billionType = __( 'One Time', 'houzez' );
        }

        if( $is_package == 0 ) {
            if( $upgrade == 1 ) {
                $total_price = $price_featured_submission;

            } else {
                if( $featured == 1 ) {
                    $total_price = $price_per_submission+$price_featured_submission;
                } else {
                    $total_price = $price_per_submission;
                }
            }
        } else {
            $pack_price = get_post_meta( $packageID, 'fave_package_price', true);
            $pack_tax = get_post_meta( $packageID, 'fave_package_tax', true );

            if( !empty($pack_tax) && !empty($pack_price) ) {
                $total_taxes = intval($pack_tax)/100 * $pack_price;
                $total_taxes = round($total_taxes, 2);
            }
            
            $total_price = $pack_price + $total_taxes;
        }
        
        $fave_meta = array();

        $fave_meta['invoice_billion_for'] = $billingFor;
        $fave_meta['invoice_billing_type'] = $billionType;
        $fave_meta['invoice_item_id'] = $packageID;
        $fave_meta['invoice_item_price'] = $total_price;
        $fave_meta['invoice_tax'] = $total_taxes;
        $fave_meta['invoice_purchase_date'] = $invoiceDate;
        $fave_meta['invoice_buyer_id'] = $userID;
        $fave_meta['paypal_txn_id'] = $paypalTaxID;
        $fave_meta['invoice_payment_method'] = $paymentMethod;

        update_post_meta( $inserted_post_id, 'HOUZEZ_invoice_buyer', $userID );
        update_post_meta( $inserted_post_id, 'HOUZEZ_invoice_type', $billionType );
        update_post_meta( $inserted_post_id, 'HOUZEZ_invoice_for', $billingFor );
        update_post_meta( $inserted_post_id, 'HOUZEZ_invoice_item_id', $packageID );
        update_post_meta( $inserted_post_id, 'HOUZEZ_invoice_price', $total_price );
        update_post_meta( $inserted_post_id, 'HOUZEZ_invoice_tax', $total_taxes );
        update_post_meta( $inserted_post_id, 'HOUZEZ_invoice_date', $invoiceDate );
        update_post_meta( $inserted_post_id, 'HOUZEZ_paypal_txn_id', $paypalTaxID );
        update_post_meta( $inserted_post_id, 'HOUZEZ_invoice_payment_method', $paymentMethod );

        update_post_meta( $inserted_post_id, '_houzez_invoice_meta', $fave_meta );

        // Update post title
        $update_post = array(
            'ID'         => $inserted_post_id,
            'post_title' => 'Invoice '.$inserted_post_id,
        );
        wp_update_post( $update_post );
        return $inserted_post_id;
    }
endif;

/*-----------------------------------------------------------------------------------*/
/*  Houzez Invoice Filter
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_houzez_invoices_ajax_search', 'houzez_invoices_ajax_search' );
add_action( 'wp_ajax_houzez_invoices_ajax_search', 'houzez_invoices_ajax_search' );

if( !function_exists('houzez_invoices_ajax_search') ){
    function houzez_invoices_ajax_search() {
        global $current_user, $houzez_local;
        wp_get_current_user();
        $userID = $current_user->ID;

        $houzez_local = houzez_get_localization();

        $meta_query = array();
        $date_query = array();

        if( isset($_POST['invoice_status']) &&  $_POST['invoice_status'] !='' ){
            $meta_query[] = array(
                'key' => 'invoice_payment_status',
                'value' => esc_html( $_POST['invoice_status'] ),
                'type' => 'NUMERIC',
                'compare' => '=',
            );
        }

        if( isset($_POST['invoice_type']) &&  $_POST['invoice_type'] !='' ){
        
            $meta_query[] = array(
                'key' => 'HOUZEZ_invoice_for',
                'value' => esc_html( $_POST['invoice_type'] ),
                'type' => 'CHAR',
                'compare' => 'LIKE',
            );


        }

        if( isset($_POST['startDate']) &&  $_POST['startDate'] !='' ){
            $temp_array = array();
            $temp_array['after'] = esc_html( $_POST['startDate'] );
            $date_query[] = $temp_array;
        }

        if( isset($_POST['endDate']) &&  $_POST['endDate'] !='' ){
            $temp_array = array();
            $temp_array['before'] = esc_html( $_POST['endDate'] );
            $date_query[] = $temp_array;
        }

        $meta_query[] = array(
                'key' => 'HOUZEZ_invoice_buyer',
                'value' => get_current_user_id(),
                'compare' => '='
            );


        $invoices_args = array(
            'post_type' => 'houzez_invoice',
            'posts_per_page' => '-1',
            'date_query' => $date_query,
        );

        $meta_count = count($meta_query);
        $meta_query['relation'] = 'AND';
        if ($meta_count > 0) {
            $invoices_args['meta_query'] = $meta_query;
        }

        $invoices = new WP_Query( $invoices_args );
        $total_price = 0;

        ob_start();
        while ( $invoices->have_posts()): $invoices->the_post();
            $fave_meta = houzez_get_invoice_meta( get_the_ID() );
            get_template_part('template-parts/dashboard/invoice/invoice-item');

            $total_price += $fave_meta['invoice_item_price'];
        endwhile;

        $result = ob_get_contents();
        ob_end_clean();

        echo json_encode( array( 'success' => true, 'result' => $result, 'total_price' => houzez_get_invoice_price( $total_price ) ) );
        wp_die();
    }
}

if( !function_exists('houzez_get_agent_info') ) {
    function houzez_get_agent_info( $args, $type ) {
        if( $type == 'for_grid_list' ) {
            return '<a href="'.$args[ 'link' ].'">'.$args[ 'agent_name' ].'</a> ';

        } elseif( $type == 'agent_form' ) {
            $output = '';

            $output .= '<div class="media agent-media">';
                $output .= '<div class="media-left">';
                    $output .= '<input type="checkbox">';
                    $output .= '<a href="'.$args[ 'link' ].'">';
                        $output .= '<img src="'.$args[ 'picture' ].'" alt="'.$args[ 'agent_name' ].'" width="75" height="75">';
                    $output .= '</a>';
                $output .= '</div>';

                $output .= '<div class="media-body">';
                    $output .= '<dl>';
                        if( !empty($args[ 'agent_name' ]) ) {
                            $output .= '<dd><i class="fa fa-user"></i> '.$args[ 'agent_name' ].'</dd>';
                        }
                        if( !empty( $args[ 'agent_mobile' ] ) ) {
                            $output .= '<dd><i class="fa fa-phone"></i><span class="clickToShow">'.esc_attr( $args[ 'agent_mobile' ] ).'</span></dd>';
                        }
                        $output .= '<dd><a href="'.$args[ 'link' ].'" class="view">'.esc_html__('View my listing', 'houzez' ).'</a></dd>';
                    $output .= '</dl>';
                $output .= '</div>';
            $output .= '</div>';

            return $output;
        }
    }
}

if( !function_exists('houzez_get_property_agent') ) {
    function houzez_get_property_agent($prop_id) {

        $agent_display_option = get_post_meta( $prop_id, 'fave_agent_display_option', true );
        $prop_agent_display = get_post_meta( $prop_id, 'fave_agents', true );
        $listing_agent = '';
        $prop_agent_num = $agent_num_call = $prop_agent = $prop_agent_link = $property_agent = '';
        if( $prop_agent_display != '-1' && $agent_display_option == 'agent_info' ) {

            $prop_agent_ids = get_post_meta( $prop_id, 'fave_agents' );
            // remove invalid ids
            $prop_agent_ids = array_filter( $prop_agent_ids, function($hz){
                return ( $hz > 0 );
            });

            $prop_agent_ids = array_unique( $prop_agent_ids );

            if ( ! empty( $prop_agent_ids ) ) {
                $agents_count = count( $prop_agent_ids );
                $listing_agent = array();
                foreach ( $prop_agent_ids as $agent ) {
                    if ( 0 < intval( $agent ) ) {
                        $agent_args = array();
                        $agent_args[ 'agent_id' ] = intval( $agent );
                        $agent_args[ 'agent_name' ] = get_the_title( $agent_args[ 'agent_id' ] );
                        $agent_args[ 'agent_mobile' ] = get_post_meta( $agent_args[ 'agent_id' ], 'fave_agent_mobile', true );
                        $agent_num_call = str_replace(array('(',')',' ','-'),'', $agent_args[ 'agent_mobile' ]);
                        $agent_args[ 'agent_email' ] = get_post_meta( $agent_args[ 'agent_id' ], 'fave_agent_email', true );
                        $agent_args[ 'link' ] = get_permalink($agent_args[ 'agent_id' ]);
                        $listing_agent[] = houzez_get_agent_info( $agent_args, 'for_grid_list' );
                    }
                }
            }

        } elseif( $agent_display_option == 'agency_info' ) {

            $prop_agency_ids = get_post_meta( $prop_id, 'fave_property_agency' );
            // remove invalid ids
            $prop_agency_ids = array_filter( $prop_agency_ids, function($hz){
                return ( $hz > 0 );
            });

            $prop_agency_ids = array_unique( $prop_agency_ids );

            if ( ! empty( $prop_agency_ids ) ) {
                $agency_count = count( $prop_agency_ids );
                $listing_agent = array();
                foreach ( $prop_agency_ids as $agency ) {
                    if ( 0 < intval( $agency ) ) {
                        $agency_args = array();
                        $agency_args[ 'agent_id' ] = intval( $agency );
                        $agency_args[ 'agent_name' ] = get_the_title( $agency_args[ 'agent_id' ] );
                        $agency_args[ 'agent_mobile' ] = get_post_meta( $agency_args[ 'agent_id' ], 'fave_agency_mobile', true );
                        $agent_num_call = str_replace(array('(',')',' ','-'),'', $agency_args[ 'agent_mobile' ]);
                        $agency_args[ 'agent_email' ] = get_post_meta( $agency_args[ 'agent_id' ], 'fave_agency_email', true );
                        $agency_args[ 'link' ] = get_permalink($agency_args[ 'agent_id' ]);
                        $listing_agent[] = houzez_get_agent_info( $agency_args, 'for_grid_list' );
                    }
                }
            }

        } else {

            $listing_agent = array();
            $author_args = array();
            $author_args[ 'agent_name' ] = get_the_author();
            $author_args[ 'agent_mobile' ] = get_the_author_meta( 'fave_author_mobile' );
            $agent_num_call = str_replace(array('(',')',' ','-'),'', get_the_author_meta( 'fave_author_mobile' ));
            $author_args[ 'agent_email' ] = get_the_author_meta( 'email' );
            $author_args[ 'link' ] = get_author_posts_url( get_the_author_meta( 'ID' ) );

            $listing_agent[] = houzez_get_agent_info( $author_args, 'for_grid_list' );
        }
        return $listing_agent;
    }
}

add_action( 'wp_ajax_nopriv_houzez_get_auto_complete_search', 'houzez_get_auto_complete_search' );
add_action( 'wp_ajax_houzez_get_auto_complete_search', 'houzez_get_auto_complete_search' );

if ( !function_exists( 'houzez_get_auto_complete_search' ) ) {

    function houzez_get_auto_complete_search() {
        $current_language = apply_filters( 'wpml_current_language', null );
        global $wpdb;
        $key = $_POST['key'];
        $keyword_field = houzez_option('keyword_field');
        $houzez_local = houzez_get_localization();
        $response = '';

        if( $keyword_field != 'prop_city_state_county' ) {

            if ( $keyword_field == "prop_title" ) {

                $table = $wpdb->posts;
                $data = $wpdb->get_results( "SELECT DISTINCT * FROM $table WHERE post_type='property' and post_status='publish' and (post_title LIKE '%$key%' OR post_content LIKE '%$key%')" );

                if ( sizeof( $data ) != 0 ) {

                    $search_url = add_query_arg( 'keyword', $key, houzez_get_search_template_link() );

                    echo '<div class="auto-complete-keyword">';
                    echo '<ul class="list-group">';

                    foreach ( $data as $post ) {

                        $propID = $post->ID;

                        $post_language = apply_filters( 'wpml_element_language_code', null, array('element_id' => $propID, 'element_type' => 'post'));
                        if ($post_language !== $current_language)
                            continue;
                        
                        // echo $prop_thumb = get_the_post_thumbnail( $propID );
                        $prop_beds = get_post_meta( $propID, 'fave_property_bedrooms', true );
                        $prop_baths = get_post_meta( $propID, 'fave_property_bathrooms', true );
                        $prop_size = houzez_get_listing_area_size( $propID );
                        $prop_type = houzez_taxonomy_simple('property_type');
                        $prop_img = get_the_post_thumbnail_url( $propID, array ( 40, 40 ) );

                        if ( empty( $prop_img ) ) {
                            $prop_img = houzez_get_image_placeholder_url('thumbnail');
                        }

                        ?>

                        <li class="list-group-item" data-text="<?php echo $post->post_title; ?>">
                            <div class="d-flex align-items-center">
                                <div class="auto-complete-image-wrap">
                                    <a href="<?php the_permalink( $propID ); ?>">
                                        <img class="img-fluid rounded" src="<?php echo $prop_img; ?>" width="40" height="40" alt="image">
                                    </a>    
                                </div><!-- auto-complete-image-wrap -->
                                <div class="auto-complete-content-wrap ml-3">
                                    <div class="auto-complete-title">
                                        <a href="<?php the_permalink( $propID ); ?>"><?php echo $post->post_title; ?></a>
                                    </div>
                                </div><!-- auto-complete-content-wrap -->
                            </div><!-- d-flex -->
                        </li><!-- list-group-item -->
                        <?php

                    }

                    echo '</ul>';

                    echo '<div class="auto-complete-footer">';
                        echo '<span class="auto-complete-count"><i class="houzez-icon icon-pin mr-1"></i> ' . sizeof( $data ) . ' '.$houzez_local['listins_found'].'</span>';
                        echo '<a target="_blank" href="' . $search_url . '" class="search-result-view">'.$houzez_local['view_all_results'].'</a>';
                    echo '</div>';


                    echo '</div>';

                } else {

               ?>
               <ul class="list-group">
                   <li class="list-group-item"> <?php echo $houzez_local['auto_result_not_found']; ?> </li>
               </ul>
               <?php

           }

       } else if ( $keyword_field == "prop_address" ) {

                $posts_table = $wpdb->posts;
                $postmeta_table = $wpdb->postmeta;
                $data = $wpdb->get_results( "SELECT DISTINCT post.ID, meta.meta_value FROM $postmeta_table AS meta INNER JOIN $posts_table AS post ON meta.post_id=post.ID AND post.post_type='property' and post.post_status='publish' AND meta.meta_value LIKE '%$key%'AND ( meta.meta_key='fave_property_map_address' OR meta.meta_key='fave_property_zip' OR meta.meta_key='fave_property_address' OR meta.meta_key='fave_property_id' )" );

                if ( sizeof( $data ) != 0 ) {

                    echo '<ul class="list-group">';

                    foreach ( $data as $title ) {

                        $post_language = apply_filters( 'wpml_element_language_code', null, array('element_id' => $title->ID, 'element_type' => 'post'));
                        if ($post_language !== $current_language)
                            continue;
                        ?>
                        
                        <li class="list-group-item" data-text="<?php echo $title->meta_value; ?>">
                            <div class="d-flex align-items-center">
                                <div class="auto-complete-content-wrap flex-fill">
                                    <i class="houzez-icon icon-pin mr-1"></i> <?php echo $title->meta_value; ?>
                                </div><!-- auto-complete-content-wrap -->
                            </div><!-- d-flex -->
                        </li>
                        <?php

                    }

                    echo '</ul>';

                } else {

               ?>
               <ul class="list-group">
                   <li class="list-group-item"> <?php echo $houzez_local['auto_result_not_found']; ?> </li>
               </ul>
               <?php

           }

            }

        } else {
            $terms_table = $wpdb->terms;
            $term_taxonomy = $wpdb->term_taxonomy;
            $data = $wpdb->get_results( "SELECT DISTINCT * FROM $terms_table as term INNER JOIN $term_taxonomy AS term_taxonomy
                ON term.term_id=term_taxonomy.term_id AND term.name LIKE '%$key%' AND ( term_taxonomy.taxonomy = 'property_area' OR term_taxonomy.taxonomy = 'property_city' OR term_taxonomy.taxonomy = 'property_state' )" );

            if ( sizeof( $data ) != 0 ) {

                echo '<ul class="list-group">';

                foreach ( $data as $term ) {
                    
                    $term_language = apply_filters( 'wpml_element_language_code', null, array('element_id' => $term->term_id, 'element_type' => 'category'));
                    if ($term_language !== $current_language)
                        continue;
                    $taxonomy_img_id = get_term_meta( $term->term_id, 'fave_taxonomy_img', true );
                    $term_type = explode( 'property_', $term->taxonomy );
                    $term_type = $term_type[1];
                    $prop_count = $term->count;

                    if ( empty( $term_img ) ) {
                       $term_img = '<img src="http://placehold.it/40x40" width="40" height="40">';
                   } else {
                        $term_img = wp_get_attachment_image( $taxonomy_img_id, array( 40, 40 ), array( "class" => "img-fluid rounded" ) );
                   }

                    if ( $term_type == 'city' ) {
                        $term_type = $houzez_local['auto_city'];
                    } elseif ( $term_type == 'area' ) {
                        $term_type = $houzez_local['auto_area'];
                    } else {
                        $term_type = $houzez_local['auto_state'];
                    }

                    ?>
                    <li class="list-group-item" data-text="<?php echo $term->name; ?>">
                        <div class="d-flex align-items-center">
                            <div class="auto-complete-image-wrap">
                                <a href="<?php echo get_term_link( $term ); ?>">
                                    <?php echo $term_img; ?>
                                </a>    
                            </div><!-- auto-complete-image-wrap -->
                            <div class="auto-complete-content-wrap flex-fill ml-3">
                                <div class="auto-complete-title"><?php echo esc_attr($term->name); ?></div>
                                <ul class="item-amenities">
                                    <li><?php if ( !empty( $term_type ) ) { ?>
                                    <?php echo $term_type; ?>
                                <?php } ?>
                                <?php if ( !empty( $prop_count ) ) : ?>
                                     - <?php echo $prop_count . ' ' . $houzez_local['auto_listings']; ?>
                                <?php endif; ?></li>
                                </ul>
                            </div><!-- auto-complete-content-wrap -->
                            <div class="auto-complete-content-wrap ml-3">
                                <a target="_blank" href="<?php echo get_term_link( $term ); ?>" class="search-result-view"><?php echo $houzez_local['auto_view_lists']; ?></a>
                            </div><!-- auto-complete-content-wrap -->
                        </div><!-- d-flex -->
                    </li>
                    <?php

                }

                echo '</ul>';

            } else {

               ?>
               <ul class="list-group">
                   <li class="list-group-item"> <?php echo $houzez_local['auto_result_not_found']; ?> </li>
               </ul>
               <?php

           }

        }

        wp_die();

    }

}

/*-------------------------------------------------------------------------------
*
* Agency ajax pagination data
*-------------------------------------------------------------------------------*/
add_action('wp_ajax_houzez_ajax_agency_filter', 'houzez_ajax_agency_filter');
add_action('wp_ajax_nopriv_houzez_ajax_agency_filter', 'houzez_ajax_agency_filter');

if( !function_exists('houzez_ajax_agency_filter')) {
    function houzez_ajax_agency_filter() {

        $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : '';
        $agency_id = $_POST['agency_id'];

        $agency_agents = Houzez_Query::get_agency_agents_ids($agency_id);

        $loop_get_agent_properties_ids = Houzez_Query::loop_get_agent_properties_ids($agency_agents);
        $loop_agency_properties_ids = Houzez_Query::loop_agency_properties_ids($agency_id);
        $properties_ids = array_merge($loop_get_agent_properties_ids, $loop_agency_properties_ids);

        if(empty($properties_ids)) {
            
            $agency_listing_args = array(
                'post_type' => 'property',
                'posts_per_page' => 9,
                'paged' => $paged,
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'fave_property_agency',
                        'value' => $agency_id,
                        'compare' => '='
                    )
                )
            );

            ?>
            <div class="grid-view grid-view-3-col">
                <div class="row">
            <?php
            $agency_qry = new WP_Query( $agency_listing_args );
            if( $agency_qry->have_posts() ):
                while( $agency_qry->have_posts() ): $agency_qry->the_post();
                    get_template_part('template-parts/property-for-listing');
                endwhile;
                wp_reset_postdata();
            else:
                get_template_part('template-parts/property', 'none');
            endif;
            echo '</div>';
            echo '</div>';
            echo '<hr>';
            houzez_halpmap_ajax_pagination( $agency_qry->max_num_pages, $paged, $range = 2 );

        } else {
            
            $agency_listing_args = array(
                'post_type' => 'property',
                'posts_per_page' => 9,
                'paged' => $paged,
                'post__in' => $properties_ids,
                'post_status' => 'publish'
            );

            ?>
            <div class="grid-view grid-view-3-col">
                <div class="row">
            <?php
            $agency_qry = new WP_Query( $agency_listing_args );
            if( $agency_qry->have_posts() ):
                while( $agency_qry->have_posts() ): $agency_qry->the_post();
                    get_template_part('template-parts/property-for-listing');
                endwhile;
                wp_reset_postdata();
            else:
                get_template_part('template-parts/property', 'none');
            endif;
            echo '</div>';
            echo '</div>';
            echo '<hr>';
            houzez_halpmap_ajax_pagination( $agency_qry->max_num_pages, $paged, $range = 2 );

        }

        wp_die();
    }
}


if ( !function_exists( 'houzez_get_agent_info_bottom' ) ) {
    function houzez_get_agent_info_bottom( $args, $type, $is_single = true ) {

        $view_listing = houzez_option('agent_view_listing');
        $agent_phone_num = houzez_option('agent_phone_num');
        if( empty($args['agent_name']) ) {
            return '';
        }
        if( $type == 'for_grid_list' ) {
            return '<a href="'.$args[ 'link' ].'">'.$args[ 'agent_name' ].'</a> ';

        } elseif( $type == 'agent_form' ) {
            $output = '';

            $output .= '<div class="agent-details">';
                $output .= '<div class="d-flex align-items-center">';
                    
                    $output .= '<div class="agent-image">';
                        if ( $is_single == false ) :
                            $output .= '<input type="checkbox" checked="checked" class="houzez-hidden multiple-agent-check" name="target_email[]" value="' . $args['agent_email'] . '" >';
                        endif;
                        
                        $output .= '<a href="'.$args[ 'link' ].'">';
                            $output .= '<img class="rounded" src="'.$args[ 'picture' ].'" alt="'.$args[ 'agent_name' ].'" width="80" height="80">';
                        $output .= '</a>';
                    $output .= '</div>';

                    $output .= '<ul class="agent-information list-unstyled">';
                        
                        if ( !empty( $args[ 'agent_name' ] ) ) :
                        $output .= '<li class="agent-name">';
                            $output .= '<i class="houzez-icon icon-single-neutral mr-1"></i> '.$args[ 'agent_name' ];
                        $output .= '</li>';
                        endif;


                        $output .= '<li class="agent-phone-wrap clearfix">';

                            if ( !empty( $args[ 'agent_phone' ] ) && houzez_option('agent_phone_num', 1) ) :
                            $output .= '<i class="houzez-icon icon-phone mr-1"></i>';
                            $output .= '<span class="agent-phone '.houzez_get_show_phone().'">';
                                 $output .= '<a href="tel:'.esc_attr( $args[ 'agent_phone_call' ] ).'">'.esc_attr($args[ 'agent_phone' ]).'</a>';
                            $output .= '</span>';
                            endif;

                            if ( !empty( $args[ 'agent_mobile' ] ) && houzez_option('agent_mobile_num', 1) ) :
                            $output .= '<i class="houzez-icon icon-mobile-phone mr-1"></i>';
                            $output .= '<span class="agent-phone '.houzez_get_show_phone().'">';
                                 $output .= '<a href="tel:'.esc_attr( $args[ 'agent_mobile_call' ] ).'">'.esc_attr($args[ 'agent_mobile' ]).'</a>';
                            $output .= '</span>';
                            endif;

                            if ( !empty( $args[ 'agent_skype' ] ) && $args[ 'agent_skype' ] != "#" && houzez_option('agent_skype_con', 1) ) :
                            $output .= '<i class="houzez-icon icon-video-meeting-skype mr-1"></i>';
                            $output .= '<span>';
                                 $output .= '<a href="skype:'.esc_attr( $args[ 'agent_skype' ] ).'?call">'.esc_attr( $args[ 'agent_skype' ] ).'</a>';
                            $output .= '</span>';
                            endif;

                            if ( !empty( $args[ 'agent_whatsapp' ] ) && houzez_option('agent_whatsapp_num', 1) ) :
                            $output .= '<i class="houzez-icon icon-messaging-whatsapp mr-1"></i>';
                            $output .= '<span>';
                                 $output .= '<a target="_blank" href="https://api.whatsapp.com/send?phone='.esc_attr( $args[ 'agent_whatsapp_call' ] ).'&text='.houzez_option('spl_con_interested', "Hello, I am interested in").' ['.get_the_title().'] '.get_permalink().'">'.esc_html__('WhatsApp', 'houzez').'</a>';
                            $output .= '</span>';
                            endif;

                        $output .= '</li>';


                        if( houzez_option('agent_con_social', 1) ) {
                            $output .= '<li class="agent-social-media">';
                                
                                if( !empty( $args[ 'facebook' ] ) ) :
                                $output .= '<span>';
                                    $output .= '<a class="btn-facebook" target="_blank" href="'.esc_url($args['facebook']).'">';
                                        $output .= '<i class="houzez-icon icon-social-media-facebook mr-2"></i>';
                                    $output .= '</a>';
                                $output .= '</span>';
                                endif;
                                
                                if( !empty( $args[ 'instagram' ] ) ) :
                                $output .= '<span>';
                                    $output .= '<a class="btn-instagram" target="_blank" href="'.esc_url($args['instagram']).'">';
                                        $output .= '<i class="houzez-icon icon-social-instagram mr-2"></i>';
                                    $output .= '</a>';
                                $output .= '</span>';
                                endif;

                                if( !empty( $args[ 'twitter' ] ) ) :
                                $output .= '<span>';
                                    $output .= '<a class="btn-twitter" target="_blank" href="'.esc_url($args['twitter']).'">';
                                        $output .= '<i class="houzez-icon icon-social-media-twitter mr-2"></i>';
                                    $output .= '</a>';
                                $output .= '</span>';
                                endif;

                                if( !empty( $args[ 'linkedin' ] ) ) :
                                $output .= '<span>';
                                    $output .= '<a class="btn-linkedin" target="_blank" href="'.esc_url($args['linkedin']).'">';
                                        $output .= '<i class="houzez-icon icon-professional-network-linkedin mr-2"></i>';
                                    $output .= '</a>';
                                $output .= '</span>';
                                endif;

                                if( !empty( $args[ 'googleplus' ] ) ) :
                                $output .= '<span>';
                                    $output .= '<a class="btn-google-plus" target="_blank" href="'.esc_url($args['googleplus']).'">';
                                        $output .= '<i class="houzez-icon icon-social-media-google-plus-1 mr-2"></i>';
                                    $output .= '</a>';
                                $output .= '</span>';
                                endif;

                                if( !empty( $args[ 'youtube' ] ) ) :
                                $output .= '<span>';
                                    $output .= '<a class="btn-youtube" target="_blank" href="'.esc_url($args['youtube']).'">';
                                       $output .= '<i class="houzez-icon icon-social-video-youtube-clip mr-2"></i>';
                                    $output .= '</a>';
                                $output .= '</span>';
                                endif;

                            $output .= '</li>';
                        }
                    $output .= '</ul>';
                $output .= '</div>';
            $output .= '</div>';


            return $output;

        }

    }
}

if ( !function_exists( 'houzez_get_agent_info_bottom_v2' ) ) {
    function houzez_get_agent_info_bottom_v2( $args, $type, $is_single = true ) {

        if( empty($args['agent_name']) ) {
            return '';
        }
        ob_start();
        ?>
        <div class="agent-details">
    
            <div class="agent-image">
                <img class="rounded" src="<?php echo esc_url( $args[ 'picture' ] ); ?>" alt="<?php echo esc_attr( $args['agent_name'] ); ?>" width="80" height="80">
                <?php if ( $is_single == false ) { ?>
                <input type="checkbox" class="houzez-hidden multiple-agent-check" checked="checked" name="target_email[]" value="<?php echo $args['agent_email']; ?>" >
                <?php } ?>
            </div>

            <ul class="agent-information list-unstyled">
                <li class="agent-name">
                    <?php if( !empty( $args['agent_name'] ) ) { ?>
                        <i class="houzez-icon icon-single-neutral mr-1"></i> <?php echo esc_attr( $args['agent_name'] ); ?>
                    <?php } ?>
                </li>

                <li class="agent-phone-wrap clearfix">
        
                    <?php if( !empty( $args['agent_phone'] ) && houzez_option('agent_phone_num', 1) ) { ?>
                        <i class="houzez-icon icon-phone mr-1"></i>
                        <span class="agent-phone <?php houzez_show_phone(); ?>">
                            <?php echo esc_attr( $args['agent_phone'] );?>
                        </span>
                    <?php } ?>

                    <?php if( !empty( $args['agent_mobile'] ) && houzez_option('agent_mobile_num', 1) ) { ?>
                        <i class="houzez-icon icon-mobile-phone mr-1"></i>
                        <span class="agent-phone <?php houzez_show_phone(); ?>">
                            <?php echo esc_attr( $args['agent_mobile'] );?>
                        </span>
                    <?php } ?>

                    <?php if( !empty( $args['agent_skype'] ) && houzez_option('agent_skype_con', 1) ) { ?>
                        <i class="houzez-icon icon-video-meeting-skype mr-1"></i>
                        <span>
                            <a href="skype:<?php esc_attr( $args[ 'agent_skype' ] ); ?>?call"><?php echo esc_attr( $args[ 'agent_skype' ] ); ?></a>
                        </span>
                    <?php } ?>

                    <?php if( !empty( $args['agent_whatsapp'] ) && houzez_option('agent_whatsapp_num', 1) ) { ?>
                        <i class="houzez-icon icon-messaging-whatsapp mr-1"></i>
                        <span>
                            <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo esc_attr( $args[ 'agent_whatsapp_call' ] ); ?>&text=<?php echo houzez_option('spl_con_interested', "Hello, I am interested in").' ['.get_the_title().'] '.get_permalink(); ?> "><?php echo esc_html__('WhatsApp', 'houzez'); ?></a>
                        </span>
                    <?php } ?>

                </li>

                <?php if( houzez_option('agent_con_social', 1) ) { ?>
                <li class="agent-social-media mb-3">
                    <?php if( !empty( $args['facebook'] ) ) { ?>
                        <span><a class="btn-facebook" target="_blank" href="<?php echo esc_url( $args['facebook'] ); ?>"><i class="houzez-icon icon-social-media-facebook mr-2"></i></a></span>
                    <?php } ?>

                    <?php if( !empty( $args['twitter'] ) ) { ?>
                        <span><a class="btn-twitter" target="_blank" href="<?php echo esc_url( $args['twitter'] ); ?>"><i class="houzez-icon icon-social-media-twitter mr-2"></i></a></span>
                    <?php } ?>

                    <?php if( !empty( $args['linkedin'] ) ) { ?>
                        <span><a class="btn-linkedin" target="_blank" href="<?php echo esc_url( $args['linkedin'] ); ?>"><i class="houzez-icon icon-professional-network-linkedin mr-2"></i></a></span>
                    <?php } ?>

                    <?php if( !empty( $args['googleplus'] ) ) { ?>
                        <span><a class="btn-google-plus" target="_blank" href="<?php echo esc_url( $args['googleplus'] ); ?>"><i class="houzez-icon icon-social-media-google-plus-1 mr-2"></i></a></span>
                    <?php } ?>

                    <?php if( !empty( $args['youtube'] ) ) { ?>
                        <span><a class="btn-youtube" target="_blank" href="<?php echo esc_url( $args['youtube'] ); ?>"><i class="houzez-icon icon-social-video-youtube-clip mr-2"></i></a></span>
                    <?php } ?>

                    <?php if( !empty( $args['instagram'] ) ) { ?>
                        <span><a class="btn-instagram" target="_blank" href="<?php echo esc_url( $args['instagram'] ); ?>"><i class="houzez-icon icon-social-video-instagram-clip mr-2"></i></a></span>
                    <?php } ?>
                </li>
                <?php } ?>
            </ul>

            <?php if( houzez_option('agent_view_listing') != 0 ) { ?>
            <a class="btn btn-primary btn-slim" href="<?php echo esc_url($args[ 'link' ]); ?>" target="_blank"><?php echo houzez_option('spl_con_view_listings', 'View listings'); ?></a>
            <?php } ?>
        </div><!-- agent-details -->

        <?php
        $data = ob_get_contents();
        ob_clean();

        return $data;

    }
}

if ( !function_exists( 'houzez_get_agent_info_top' ) ) {
    function houzez_get_agent_info_top($args, $type, $is_single = true)
    {
        $view_listing = houzez_option('agent_view_listing');
        $agent_phone_num = houzez_option('agent_phone_num');

        if( empty($args['agent_name']) ) {
            return '';
        }

        if ($type == 'for_grid_list') {
            return '<a href="' . $args['link'] . '">' . $args['agent_name'] . '</a> ';

        } elseif ($type == 'agent_form') {
            $output = '';

            $output .= '<div class="agent-details">';
                $output .= '<div class="d-flex align-items-center">';
                    
                    $output .= '<div class="agent-image">';
                        
                        if ( $is_single == false ) {
                            $output .= '<input type="checkbox" class="houzez-hidden" checked="checked" class="multiple-agent-check" name="target_email[]" value="' . $args['agent_email'] . '" >';
                        }

                        $output .= '<img class="rounded" src="' . $args['picture'] . '" alt="' . $args['agent_name'] . '" width="70" height="70">';

                    $output .= '</div>';

                    $output .= '<ul class="agent-information list-unstyled">';

                        if (!empty($args['agent_name'])) {
                            $output .= '<li class="agent-name">';
                                $output .= '<i class="houzez-icon icon-single-neutral mr-1"></i> '.$args['agent_name'];
                            $output .= '</li>';
                        }
                        
                        if ( $is_single == false && !empty($args['agent_mobile'])) {
                            $output .= '<li class="agent-phone agent-phone-hidden">';
                                $output .= '<i class="houzez-icon icon-phone mr-1"></i> ' . esc_attr($args['agent_mobile']);
                            $output .= '</li>';
                        }

                        
                        if($view_listing != 0) {
                            $output .= '<li class="agent-link">';
                                $output .= '<a href="' . $args['link'] . '">' . houzez_option('spl_con_view_listings', 'View listings') . '</a>';
                            $output .= '</li>';
                        }


                    $output .= '</ul>';
                $output .= '</div>';
            $output .= '</div>';

            return $output;
        }
    }
}

if(!function_exists('houzez20_property_contact_form')) {
    function houzez20_property_contact_form($is_top = true, $luxury = false) {
        $allowed_html_array = array(
            'a' => array(
                'href' => array(),
                'title' => array()
            )
        );
        $listing_agent = $prop_agent = $prop_agent_phone = $prop_agent_mobile = $picture = $agent_id = '';
        $prop_agent_num = $agent_num_call = $prop_agent_email = $prop_agent_permalink = '';
        $return_array = array();

        $agent_display = houzez_get_listing_data('agent_display_option');
        $is_single_agent = true;

        if( $agent_display != 'none' ) {
            if( $agent_display == 'agent_info' ) {

                $agents_ids = houzez_get_listing_data('agents', false);

                $agents_ids = array_filter( $agents_ids, function($hz){
                    return ( $hz > 0 );
                });

                $agents_ids = array_unique( $agents_ids );

                if ( ! empty( $agents_ids ) ) {
                    $agents_count = count( $agents_ids );
                    if ( $agents_count > 1 ) :
                        $is_single_agent = false;
                    endif;
                    $listing_agent = '';
                    foreach ( $agents_ids as $agent ) {
                        if ( 0 < intval( $agent ) ) {

                            $agent_id = intval( $agent );
                            $prop_agent_phone = get_post_meta( $agent_id, 'fave_agent_office_num', true );
                            $prop_agent_mobile = get_post_meta( $agent_id, 'fave_agent_mobile', true );
                            $prop_agent_whatsapp = get_post_meta( $agent_id, 'fave_agent_whatsapp', true );
                            $prop_agent_email = get_post_meta( $agent_id, 'fave_agent_email', true );
                            $agent_num_call = str_replace(array('(',')',' ','-'),'', $prop_agent_mobile);
                            $prop_agent = get_the_title( $agent_id );
                            $thumb_id = get_post_thumbnail_id( $agent_id );
                            $thumb_url_array = wp_get_attachment_image_src( $thumb_id, array(150,150), true );
                            $prop_agent_photo_url = $thumb_url_array[0];
                            $prop_agent_permalink = get_post_permalink( $agent_id );

                            $agent_args = array();
                            $agent_args[ 'agent_id' ] = $agent_id;
                            $agent_args[ 'agent_skype' ] = get_post_meta( $agent_id, 'fave_agent_skype', true );
                            $agent_args[ 'agent_name' ] = $prop_agent;
                            $agent_args[ 'agent_mobile' ] = $prop_agent_mobile;
                            $agent_args[ 'agent_mobile_call' ] = str_replace(array('(',')',' ','-'),'', $prop_agent_mobile);
                            $agent_args[ 'agent_whatsapp' ] = $prop_agent_whatsapp;
                            $agent_args[ 'agent_whatsapp_call' ] = str_replace(array('(',')',' ','-'),'', $prop_agent_whatsapp);
                            $agent_args[ 'agent_phone' ] = $prop_agent_phone;
                            $agent_args[ 'agent_phone_call' ] = str_replace(array('(',')',' ','-'),'', $prop_agent_phone);
                            $agent_args[ 'agent_email' ] = $prop_agent_email;
                            $agent_args[ 'link' ] = $prop_agent_permalink;
                            $agent_args[ 'facebook' ] = get_post_meta( $agent_id, 'fave_agent_facebook', true );
                            $agent_args[ 'twitter' ] = get_post_meta( $agent_id, 'fave_agent_twitter', true );
                            $agent_args[ 'linkedin' ] = get_post_meta( $agent_id, 'fave_agent_linkedin', true );
                            $agent_args[ 'googleplus' ] = get_post_meta( $agent_id, 'fave_agent_googleplus', true );
                            $agent_args[ 'youtube' ] = get_post_meta( $agent_id, 'fave_agent_youtube', true );
                            $agent_args[ 'instagram' ] = get_post_meta( $agent_id, 'fave_agent_instagram', true );

                            if( empty( $prop_agent_photo_url )) {
                                $agent_args[ 'picture' ] = HOUZEZ_IMAGE. 'profile-avatar.png';
                                $picture = HOUZEZ_IMAGE. 'profile-avatar.png';
                            } else {
                                $agent_args[ 'picture' ] = $prop_agent_photo_url;
                                $picture = $prop_agent_photo_url;
                            }
                
                            if($is_top) {
                                $listing_agent .= houzez_get_agent_info_top( $agent_args, 'agent_form', $is_single_agent );
                            } else {

                                if($luxury) {
                                    $listing_agent .= houzez_get_agent_info_bottom_v2( $agent_args, 'agent_form', $is_single_agent );
                                } else {
                                    $listing_agent .= houzez_get_agent_info_bottom( $agent_args, 'agent_form', $is_single_agent );
                                }
                                
                            }

                        }
                    }
                }

            } elseif( $agent_display == 'agency_info' ) {
                $agent_id = get_post_meta( get_the_ID(), 'fave_property_agency', true );

                $prop_agent_phone = get_post_meta( $agent_id, 'fave_agency_phone', true );
                $prop_agent_mobile = get_post_meta( $agent_id, 'fave_agency_mobile', true );
                $prop_agent_whatsapp = get_post_meta( $agent_id, 'fave_agency_whatsapp', true );
                $prop_agent_email = get_post_meta( $agent_id, 'fave_agency_email', true );
                $agent_num_call = str_replace(array('(',')',' ','-'),'', $prop_agent_mobile);
                $prop_agent = get_the_title( $agent_id );
                $thumb_id = get_post_thumbnail_id( $agent_id );
                $thumb_url_array = wp_get_attachment_image_src( $thumb_id, array(150,150), true );
                $prop_agent_photo_url = $thumb_url_array[0];
                $prop_agent_permalink = get_post_permalink( $agent_id );

                $agent_args = array();
                $agent_args[ 'agent_id' ] = $agent_id;
                $agent_args[ 'agent_skype' ] = get_post_meta( $agent_id, 'fave_agency_skype', true );
                $agent_args[ 'agent_name' ] = $prop_agent;
                $agent_args[ 'agent_mobile' ] = $prop_agent_mobile;
                $agent_args[ 'agent_mobile_call' ] = str_replace(array('(',')',' ','-'),'', $prop_agent_mobile);
                $agent_args[ 'agent_whatsapp' ] = $prop_agent_whatsapp;
                $agent_args[ 'agent_whatsapp_call' ] = str_replace(array('(',')',' ','-'),'', $prop_agent_whatsapp);
                $agent_args[ 'agent_phone' ] = $prop_agent_phone;
                $agent_args[ 'agent_phone_call' ] = str_replace(array('(',')',' ','-'),'', $prop_agent_phone);
                $agent_args[ 'agent_email' ] = $prop_agent_email;
                $agent_args[ 'link' ] = $prop_agent_permalink;
                $agent_args[ 'facebook' ] = get_post_meta( $agent_id, 'fave_agency_facebook', true );
                $agent_args[ 'twitter' ] = get_post_meta( $agent_id, 'fave_agency_twitter', true );
                $agent_args[ 'linkedin' ] = get_post_meta( $agent_id, 'fave_agency_linkedin', true );
                $agent_args[ 'googleplus' ] = get_post_meta( $agent_id, 'fave_agency_googleplus', true );
                $agent_args[ 'youtube' ] = get_post_meta( $agent_id, 'fave_agency_youtube', true );
                $agent_args[ 'instagram' ] = get_post_meta( $agent_id, 'fave_agency_instagram', true );

                if( empty( $prop_agent_photo_url )) {
                    $agent_args[ 'picture' ] = HOUZEZ_IMAGE. 'profile-avatar.png';
                    $picture = HOUZEZ_IMAGE. 'profile-avatar.png';
                } else {
                    $agent_args[ 'picture' ] = $prop_agent_photo_url;
                    $picture = $prop_agent_photo_url;
                }

                if($is_top) {
                    $listing_agent .= houzez_get_agent_info_top( $agent_args, 'agent_form' );
                } else {
                    if($luxury) {
                        $listing_agent .= houzez_get_agent_info_bottom_v2( $agent_args, 'agent_form' );
                    } else {
                        $listing_agent .= houzez_get_agent_info_bottom( $agent_args, 'agent_form' );
                    }
                }
            

            } else {

                $prop_agent = get_the_author();
                $prop_agent_permalink = get_author_posts_url( get_the_author_meta( 'ID' ) );
                $prop_agent_phone = get_the_author_meta( 'fave_author_phone' );
                $prop_agent_mobile = get_the_author_meta( 'fave_author_mobile' );
                $prop_agent_whatsapp = get_the_author_meta( 'fave_author_whatsapp' );
                $agent_num_call = str_replace(array('(',')',' ','-'),'', $prop_agent_num);
                $prop_agent_photo_url = get_the_author_meta( 'fave_author_custom_picture' );
                $prop_agent_email = get_the_author_meta( 'email' );

                $agent_args = array();
                $agent_id   = get_the_author_meta( 'ID' );
                $agent_args[ 'agent_id' ] = get_the_author_meta( 'ID' );
                $agent_args[ 'agent_skype' ] = get_the_author_meta( 'fave_author_skype' );
                $agent_args[ 'agent_name' ] = $prop_agent;
                $agent_args[ 'agent_mobile' ] = $prop_agent_mobile;
                $agent_args[ 'agent_mobile_call' ] = str_replace(array('(',')',' ','-'),'', $prop_agent_mobile);

                $agent_args[ 'agent_whatsapp' ] = $prop_agent_whatsapp;
                $agent_args[ 'agent_whatsapp_call' ] = str_replace(array('(',')',' ','-'),'', $prop_agent_whatsapp);
                $agent_args[ 'agent_phone' ] = $prop_agent_phone;
                $agent_args[ 'agent_phone_call' ] = str_replace(array('(',')',' ','-'),'', $prop_agent_phone);
                $agent_args[ 'agent_email' ] = $prop_agent_email;
                $agent_args[ 'link' ] = $prop_agent_permalink;
                $agent_args[ 'facebook' ] = get_the_author_meta( 'fave_author_facebook' );
                $agent_args[ 'twitter' ] = get_the_author_meta( 'fave_author_twitter' );
                $agent_args[ 'linkedin' ] = get_the_author_meta( 'fave_author_linkedin' );
                $agent_args[ 'googleplus' ] = get_the_author_meta( 'fave_author_googleplus' );
                $agent_args[ 'youtube' ] = get_the_author_meta( 'fave_author_youtube' );
                $agent_args[ 'instagram' ] = get_the_author_meta( 'fave_author_instagram' );

                if( empty( $prop_agent_photo_url )) {
                    $agent_args[ 'picture' ] = HOUZEZ_IMAGE. 'profile-avatar.png';
                    $picture = HOUZEZ_IMAGE. 'profile-avatar.png';
                } else {
                    $agent_args[ 'picture' ] = $prop_agent_photo_url;
                    $picture = $prop_agent_photo_url;
                }

                if($is_top) {
                    $listing_agent .= houzez_get_agent_info_top( $agent_args, 'agent_form' );
                } else {
                    if($luxury) {
                        $listing_agent .= houzez_get_agent_info_bottom_v2( $agent_args, 'agent_form' );
                    } else {
                        $listing_agent .= houzez_get_agent_info_bottom( $agent_args, 'agent_form' );
                    }
                }

            }

            $return_array['agent_data'] = $listing_agent;
            $return_array['is_single_agent'] = $is_single_agent;
            $return_array['agent_email'] = $prop_agent_email;
            $return_array['agent_name'] = $prop_agent;
            $return_array['agent_phone'] = $prop_agent_phone;
            $return_array['agent_phone_call'] = str_replace(array('(',')',' ','-'),'', $prop_agent_phone);
            $return_array['agent_mobile'] = $prop_agent_mobile;
            $return_array['agent_mobile_call'] = str_replace(array('(',')',' ','-'),'', $prop_agent_mobile);

            $return_array['agent_whatsapp'] = $prop_agent_whatsapp;
            $return_array['agent_whatsapp_call'] = str_replace(array('(',')',' ','-'),'', $prop_agent_whatsapp);
            $return_array['picture'] = $picture;
            $return_array['link'] = $prop_agent_permalink;
            $return_array['agent_type'] = $agent_display;
            $return_array['agent_id'] = $agent_id;
        }

        return $return_array;
    } // End function
}

// houzez_property_clone
add_action( 'wp_ajax_nopriv_houzez_property_clone', 'houzez_property_clone' );
add_action( 'wp_ajax_houzez_property_clone', 'houzez_property_clone' );

if ( !function_exists( 'houzez_property_clone' ) ) {
    function houzez_property_clone() {

        if ( isset( $_POST['propID'] ) ) {

            global $wpdb;
            if (! isset( $_POST['propID'] ) ) {
                wp_die('No post to duplicate has been supplied!');
            }
            $post_id = absint( $_POST['propID'] );
            $post = get_post( $post_id );
            $current_user = wp_get_current_user();
            $new_post_author = $current_user->ID;

            if (isset( $post ) && $post != null) {

                /*
                 * new post data array
                 */
                $args = array(
                    'comment_status' => $post->comment_status,
                    'ping_status'    => $post->ping_status,
                    'post_author'    => $new_post_author,
                    'post_content'   => $post->post_content,
                    'post_excerpt'   => $post->post_excerpt,
                    'post_name'      => $post->post_name,
                    'post_parent'    => $post->post_parent,
                    'post_password'  => $post->post_password,
                    'post_status'    => 'draft',
                    'post_title'     => $post->post_title,
                    'post_type'      => $post->post_type,
                    'to_ping'        => $post->to_ping,
                    'menu_order'     => $post->menu_order
                );

                /*
                 * insert the post by wp_insert_post() function
                 */
                $new_post_id = wp_insert_post( $args );

                /*
                 * get all current post terms ad set them to the new post draft
                 */
                $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
                foreach ($taxonomies as $taxonomy) {
                    $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
                    wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
                }

                /*
                 * duplicate all post meta just in two SQL queries
                 */
                $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
                if (count($post_meta_infos)!=0) {
                    $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
                    foreach ($post_meta_infos as $meta_info) {
                        $meta_key = $meta_info->meta_key;
                        $meta_value = addslashes($meta_info->meta_value);
                        $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
                    }
                    $sql_query.= implode(" UNION ALL ", $sql_query_sel);
                    $wpdb->query($sql_query);
                }

                update_post_meta( $new_post_id, 'fave_featured', 0 );
                update_post_meta( $new_post_id, 'fave_payment_status', 'not_paid' );

                $dashboard_listings = houzez_get_template_link_2('template/user_dashboard_properties.php');
                $dashboard_listings = add_query_arg( 'cloned', 1, $dashboard_listings );

                echo json_encode( array(
                    'success'   => true,
                    'redirect'  => $dashboard_listings,
                    'message' => 'Successfully cloned',
                ));
                /*
                 * finally, redirect to the edit post screen for the new draft
                 */
                // wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
                wp_die();
            } else {
                echo json_encode( array(
                    'success'   => false,
                    'message' => 'Failed',
                ));
                wp_die('Post creation failed, could not find original post: ' . $post_id);
            }

        }

    }
}

// houzez_property_on_hold
add_action( 'wp_ajax_houzez_property_on_hold', 'houzez_property_on_hold' );

if ( !function_exists( 'houzez_property_on_hold' ) ) {
    function houzez_property_on_hold() {

        if ( isset( $_POST['propID'] ) ) {

            global $wpdb;
            if (! isset( $_POST['propID'] ) ) {
                wp_die('No post to put on hold has been supplied!');
            }
            $post_id = absint( $_POST['propID'] );
            
            $post_status = get_post_status( $post_id );

            if($post_status == 'publish') { 
                $post = array(
                    'ID'            => $post_id,
                    'post_status'   => 'on_hold'
                );
            } elseif ($post_status == 'on_hold') {
                $post = array(
                    'ID'            => $post_id,
                    'post_status'   => 'publish'
                );
            }
            $post_id =  wp_update_post($post);
            
            return true;
        }

    }
}

/*-----------------------------------------------------------------------------------*/
/*  Houzez Invoice Print Property
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_houzez_create_invoice_print', 'houzez_create_invoice_print' );
add_action( 'wp_ajax_houzez_create_invoice_print', 'houzez_create_invoice_print' );

if ( !function_exists( 'houzez_create_invoice_print' ) ) {
    function houzez_create_invoice_print() {

        if(!isset($_POST['invoice_id'])|| !is_numeric($_POST['invoice_id'])){
            exit();
        }

        $houzez_local = houzez_get_localization();
        $invoice_id = intval($_POST['invoice_id']);
        $the_post= get_post( $invoice_id );

        if( $the_post->post_type != 'houzez_invoice' || $the_post->post_status != 'publish' ) {
            exit();
        }

        print  '<html><head><link href="'.get_stylesheet_uri().'" rel="stylesheet" type="text/css" />';
        print  '<html><head><link href="'.get_template_directory_uri().'/css/bootstrap.min.css" rel="stylesheet" type="text/css" />';
        print  '<html><head><link href="'.get_template_directory_uri().'/css/main.css" rel="stylesheet" type="text/css" />';

        if( is_rtl() ) {
            print '<link href="'.get_template_directory_uri().'/css/rtl.css" rel="stylesheet" type="text/css" />';
            print '<link href="'.get_template_directory_uri().'/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />';
        }
        print '</head>';
        print  '<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script><script>$(window).load(function(){ print(); });</script>';
        print  '<body class="print-page">';

        global $current_user;
        wp_get_current_user();
        $userID         = $current_user->ID;
        $user_login     = $current_user->user_login;
        $user_email     = $current_user->user_email;
        $first_name     = $current_user->first_name;
        $last_name     = $current_user->last_name;
        $user_address = get_user_meta( $userID, 'fave_author_address', true);
        if( !empty($first_name) && !empty($last_name) ) {
            $fullname = $first_name.' '.$last_name;
        } else {
            $fullname = $current_user->display_name;
        }
        $invoice_id = $_REQUEST['invoice_id'];
        $post = get_post( $invoice_id );
        $invoice_data = houzez_get_invoice_meta( $invoice_id );

        $publish_date = $post->post_date;
        $publish_date = date_i18n( get_option('date_format'), strtotime( $publish_date ) );
        $invoice_logo = houzez_option( 'invoice_logo', false, 'url' );
        $invoice_company_name = houzez_option( 'invoice_company_name' );
        $invoice_address = houzez_option( 'invoice_address' );
        $invoice_phone = houzez_option( 'invoice_phone' );
        $invoice_additional_info = houzez_option( 'invoice_additional_info' );
        $invoice_thankyou = houzez_option( 'invoice_thankyou' );
        ?>
        <div class="print-main-wrap">
            <div class="print-wrap">
                <div class="invoice-wrap">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">
                            <div class="invoice-logo mb-3">
                                <div class="logo">
                                    <?php if( !empty($invoice_logo) ) { ?>
                                        <img src="<?php echo esc_url($invoice_logo); ?>" alt="logo">
                                    <?php } ?>
                                </div>
                            </div>
                        </div><!-- col-md-9 col-sm-12 -->
                        <div class="col-md-3 col-sm-12">
                            <div class="invoice-date mb-3">
                                <ul class="list-unstyled">
                                    <li>
                                        <strong><?php esc_html_e('Invoice', 'houzez'); ?>:</strong> 
                                        <?php echo esc_attr($invoice_id); ?>
                                    </li>
                                    <li>
                                        <strong><?php esc_html_e('Date', 'houzez'); ?>:</strong> 
                                        <?php echo $publish_date; ?>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- col-md-3 col-sm-12 -->
                    </div><!-- row -->

                    <div class="invoice-spacer mb-5"></div>
                    
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <ul class="list-unstyled">
                                <li><strong><?php esc_html_e('To:', 'houzez'); ?>:</strong></li>
                                <li><?php echo esc_attr($fullname); ?></li>
                                <?php if( !empty($user_address)) { ?>
                                <li><?php echo esc_attr($user_address); ?></li>
                                <?php } ?>

                                <li><?php esc_html_e('Email:', 'houzez'); ?> <?php echo esc_attr($user_email);?></li>
                            </ul>
                        </div><!-- col-md-6 col-sm-12 -->
                        <div class="col-md-6 col-sm-12">
                            <ul class="list-unstyled">
                                
                                <?php if( !empty($invoice_company_name) ) { ?>
                                <li> 
                                    <strong> <?php echo esc_attr($invoice_company_name); ?>:</strong>
                                </li>
                                <?php } ?>

                                <?php if( !empty($invoice_address) ) { ?>
                                <li><?php echo ($invoice_address); ?></li>
                                <?php } ?>

                                <?php if( !empty($invoice_phone) ) { ?>
                                <li><?php esc_html_e('Phone', 'houzez'); ?>: <?php echo esc_attr($invoice_phone); ?></li>
                                <?php } ?>
                            </ul>

                        </div><!-- col-md-6 col-sm-12 -->
                    </div><!-- row -->

                    <div class="invoice-spacer mb-5"></div>

                    <div class="invoce-content">
                        <ul class="list-unstyled">
                            <li>
                                <strong><?php echo $houzez_local['billing_for']; ?></strong> 
                                <span>
                                    <?php
                                    if( $invoice_data['invoice_billion_for'] != 'package' && $invoice_data['invoice_billion_for'] != 'Package' ) {
                                        echo esc_html($invoice_data['invoice_billion_for']);
                                    } else {
                                        echo esc_html__('Membership Plan', 'houzez').' '. get_the_title( get_post_meta( $invoice_id, 'HOUZEZ_invoice_item_id', true) );
                                    }
                                    ?>
                                </span>
                            </li>

                            <li>
                                <strong><?php echo $houzez_local['billing_type']; ?></strong> 
                                <span><?php echo esc_html( $invoice_data['invoice_billing_type'] ); ?></span>
                            </li>

                            <li>
                                <strong><?php echo $houzez_local['payment_method']; ?></strong> 
                                <span>
                                    <?php if( $invoice_data['invoice_payment_method'] == 'Direct Bank Transfer' ) {
                                        echo $houzez_local['bank_transfer'];
                                    } else {
                                        echo $invoice_data['invoice_payment_method'];
                                    } ?>
                                </span>
                            </li>

                            <li>
                                <strong><?php echo $houzez_local['invoice_price']; ?>:</strong> 
                                <span><?php echo houzez_get_invoice_price( $invoice_data['invoice_item_price'] )?></span>
                            </li>
                        </ul>
                    </div><!-- invoce-content -->

                    <div class="invoice-spacer mb-5"></div>
                    
                    <?php if( !empty($invoice_additional_info) || !empty($invoice_thankyou) ) { ?>
        
                        <?php if( !empty($invoice_additional_info)) { ?>
                        <div class="invoce-information">
                            <p><strong><?php echo esc_html__('Additional Information:', 'houzez'); ?>:</strong></p>
                            <p><?php echo $invoice_additional_info; ?> </p>
                        </div><!-- invoce-information -->
                        <?php } ?>
                    
                    <div class="invoice-spacer mb-5"></div>

                    <p><strong><?php echo $invoice_thankyou; ?></strong></p>
                    <?php } ?>

                </div><!-- invoice-wrap -->


            </div><!-- print-wrap -->
        </div><!-- print-main-wrap -->
        
        <?php

        print '</body></html>';
        wp_die();
    }
}


/* --------------------------------------------------------------------------
* Property delete ajax
* --------------------------------------------------------------------------- */
add_action( 'wp_ajax_nopriv_houzez_delete_property', 'houzez_delete_property' );
add_action( 'wp_ajax_houzez_delete_property', 'houzez_delete_property' );

if ( !function_exists( 'houzez_delete_property' ) ) {

    function houzez_delete_property()
    {

        $dashboard_listings = houzez_get_template_link_2('template/user_dashboard_properties.php');
        $dashboard_listings = add_query_arg( 'deleted', 1, $dashboard_listings );

        $nonce = $_REQUEST['security'];
        if ( ! wp_verify_nonce( $nonce, 'delete_my_property_nonce' ) ) {
            $ajax_response = array( 'success' => false , 'reason' => esc_html__( 'Security check failed!', 'houzez' ) );
            echo json_encode( $ajax_response );
            die;
        }

        if ( !isset( $_REQUEST['prop_id'] ) ) {
            $ajax_response = array( 'success' => false , 'reason' => esc_html__( 'No Property ID found', 'houzez' ) );
            echo json_encode( $ajax_response );
            die;
        }

        $propID = $_REQUEST['prop_id'];
        $post_author = get_post_field( 'post_author', $propID );

        global $current_user;
        wp_get_current_user();
        $userID      =   $current_user->ID;

        if ( $post_author == $userID ) {

            if( get_post_status($propID) != 'draft' ) {
                houzez_delete_property_attachments_frontend($propID);
            }
            wp_delete_post( $propID );
            $ajax_response = array( 'success' => true , 'redirect' => $dashboard_listings, 'mesg' => esc_html__( 'Property Deleted', 'houzez' ) );
            echo json_encode( $ajax_response );
            die;
        } else {
            $ajax_response = array( 'success' => false , 'reason' => esc_html__( 'Permission denied', 'houzez' ) );
            echo json_encode( $ajax_response );
            die;
        }

    }

}


/* --------------------------------------------------------------------------
* Property load more
* --------------------------------------------------------------------------- */
add_action( 'wp_ajax_nopriv_houzez_loadmore_properties', 'houzez_loadmore_properties' );
add_action( 'wp_ajax_houzez_loadmore_properties', 'houzez_loadmore_properties' );

if ( !function_exists( 'houzez_loadmore_properties' ) ) {
    function houzez_loadmore_properties() {
        global $houzez_local;

        $houzez_local = houzez_get_localization();
        $fake_loop_offset = 0; 

        $tax_query = array();
        $card_version = sanitize_text_field($_POST['card_version']);
        $property_type = houzez_traverse_comma_string($_POST['type']);
        $property_status = houzez_traverse_comma_string($_POST['status']);
        $property_state = houzez_traverse_comma_string($_POST['state']);
        $property_city = houzez_traverse_comma_string($_POST['city']);
        $property_country = houzez_traverse_comma_string($_POST['country']);
        $property_area = houzez_traverse_comma_string($_POST['area']);
        $property_label = houzez_traverse_comma_string($_POST['label']);
        $houzez_user_role = $_POST['user_role'];
        $featured_prop = $_POST['featured_prop'];
        $posts_limit = $_POST['prop_limit'];
        $sort_by = $_POST['sort_by'];
        $offset = $_POST['offset'];
        $paged = $_POST['paged'];

        $wp_query_args = array(
            'ignore_sticky_posts' => 1
        );

        if( !empty($houzez_user_role) ) {
            $role_ids = houzez_author_ids_by_role( $houzez_user_role );
            if (!empty($role_ids)) {
                $wp_query_args['author__in'] = $role_ids;
            }
        }

        if (!empty($property_type)) {
            $tax_query[] = array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => $property_type
            );
        }

        if (!empty($property_status)) {
            $tax_query[] = array(
                'taxonomy' => 'property_status',
                'field' => 'slug',
                'terms' => $property_status
            );
        }
        if (!empty($property_country)) {
            $tax_query[] = array(
                'taxonomy' => 'property_country',
                'field' => 'slug',
                'terms' => $property_country
            );
        }
        if (!empty($property_state)) {
            $tax_query[] = array(
                'taxonomy' => 'property_state',
                'field' => 'slug',
                'terms' => $property_state
            );
        }
        if (!empty($property_city)) {
            $tax_query[] = array(
                'taxonomy' => 'property_city',
                'field' => 'slug',
                'terms' => $property_city
            );
        }
        if (!empty($property_area)) {
            $tax_query[] = array(
                'taxonomy' => 'property_area',
                'field' => 'slug',
                'terms' => $property_area
            );
        }
        if (!empty($property_label)) {
            $tax_query[] = array(
                'taxonomy' => 'property_label',
                'field' => 'slug',
                'terms' => $property_label
            );
        }

        if ( $sort_by == 'a_price' ) {
            $wp_query_args['orderby'] = 'meta_value_num';
            $wp_query_args['meta_key'] = 'fave_property_price';
            $wp_query_args['order'] = 'ASC';
        } else if ( $sort_by == 'd_price' ) {
            $wp_query_args['orderby'] = 'meta_value_num';
            $wp_query_args['meta_key'] = 'fave_property_price';
            $wp_query_args['order'] = 'DESC';
        } else if ( $sort_by == 'a_date' ) {
            $wp_query_args['orderby'] = 'date';
            $wp_query_args['order'] = 'ASC';
        } else if ( $sort_by == 'd_date' ) {
            $wp_query_args['orderby'] = 'date';
            $wp_query_args['order'] = 'DESC';
        } else if ( $sort_by == 'featured_top' ) {
            $wp_query_args['orderby'] = 'meta_value';
            $wp_query_args['meta_key'] = 'fave_featured';
            $wp_query_args['order'] = 'DESC';
        } else if ( $sort_by == 'random' ) {
            $wp_query_args['orderby'] = 'rand';
            $wp_query_args['order'] = 'DESC';
        }

        if (!empty($featured_prop)) {
            
            if( $featured_prop == "yes" ) {
                $wp_query_args['meta_key'] = 'fave_featured';
                $wp_query_args['meta_value'] = '1';
            } else {
                $wp_query_args['meta_key'] = 'fave_featured';
                $wp_query_args['meta_value'] = '0';
            }
        }

        $tax_count = count( $tax_query );

    
        if( $tax_count > 1 ) {
            $tax_query['relation'] = 'AND';
        }
        if( $tax_count > 0 ){
            $wp_query_args['tax_query'] = $tax_query;
        }

        $wp_query_args['post_status'] = 'publish';

        if (empty($posts_limit)) {
            $posts_limit = get_option('posts_per_page');
        }
        $wp_query_args['posts_per_page'] = $posts_limit;

        if (!empty($paged)) {
            $wp_query_args['paged'] = $paged;
        } else {
            $wp_query_args['paged'] = 1;
        }

        if (!empty($offset) and $paged > 1) {
            $wp_query_args['offset'] = $offset + ( ($paged - 1) * $posts_limit) ;
        } else {
            $wp_query_args['offset'] = $offset ;
        }

        $fake_loop_offset = $offset;

        $wp_query_args['post_type'] = 'property';
        
        $the_query = new WP_Query($wp_query_args);

        
        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) : $the_query->the_post();

                get_template_part('template-parts/listing/'.$card_version);

            endwhile;
            wp_reset_postdata();
        else:
            echo 'no_result';
        endif;
        

        wp_die();
    }
}


if(!function_exists('houzez_get_custom_add_listing_field')) {
    function houzez_get_custom_add_listing_field($key) {

        if(class_exists('Houzez_Fields_Builder')) {

            $field_array = Houzez_Fields_Builder::get_field_by_slug($key);
            $field_title = houzez_wpml_translate_single_string($field_array['label']);
            $placeholder = houzez_wpml_translate_single_string($field_array['placeholder']);

            $field_name = $field_array['field_id'];
            $field_type = $field_array['type'];
            $field_options = $field_array['fvalues'];

            $selected = '';
            if (!houzez_edit_property()) {
                $selected = 'selected=selected';
            }

            $data_value = '';
            if (houzez_edit_property()) {
                global $prop_meta_data;
                $data_value = isset( $prop_meta_data[ 'fave_'.$key ] ) ? ( ( 'checkbox_list' == $field_type || 'radio' == $field_type ) || 'multiselect' == $field_type ? $prop_meta_data[ 'fave_'.$key ] : $prop_meta_data[ 'fave_'.$key ][0] ) : '';
            }


            if($field_type == 'select' ) { ?>

                <div class="form-group">
                    <label for="<?php echo esc_attr($field_name); ?>">
                        <?php echo $field_title.houzez_required_field($field_name); ?>
                    </label>

                    <select name="<?php echo esc_attr($field_name);?>" data-size="5" class="selectpicker <?php houzez_required_field_2($field_name); ?> form-control bs-select-hidden" title="<?php echo esc_attr($placeholder); ?>" data-live-search="false">
                        
                        <option <?php echo esc_attr($selected); ?> value=""><?php esc_html_e('None', 'houzez'); ?> </option>
                        <?php
                        $options = unserialize($field_options);
                        
                        foreach ($options as $key => $val) {
                            $val = houzez_wpml_translate_single_string($val);
                            
                            $selected_val = houzez_get_field_meta($field_name);

                            echo '<option '.selected($selected_val, $key, false).' value="'.esc_attr($key).'">'.esc_attr($val).'</option>';
                        }
                        ?>

                    </select><!-- selectpicker -->
                </div>

            <?php
            } else if($field_type == 'multiselect' ) { ?>

                <div class="form-group">
                    <label for="<?php echo esc_attr($field_name); ?>">
                        <?php echo $field_title.houzez_required_field($field_name); ?>
                    </label>

                    <select name="<?php echo esc_attr($field_name).'[]'; ?>" data-size="5" data-actions-box="true" class="selectpicker <?php houzez_required_field_2($field_name); ?> form-control bs-select-hidden" title="<?php echo esc_attr($placeholder); ?>" data-live-search="false" data-select-all-text="<?php echo houzez_option('cl_select_all', 'Select All'); ?>" data-deselect-all-text="<?php echo houzez_option('cl_deselect_all', 'Deselect All'); ?>" data-count-selected-text="{0}" multiple>
                        
                        <?php
                        $options = unserialize($field_options);
                        
                        foreach ($options as $key => $val) {
                            $val = houzez_wpml_translate_single_string($val);
                            $selected = ( houzez_edit_property() && ! empty( $data_value ) && in_array( $key, $data_value ) ) ? 'selected' : '';

                            echo '<option '.esc_attr($selected).' value="'.esc_attr($key).'">'.esc_attr($val).'</option>';
                        }
                        ?>

                    </select><!-- selectpicker -->
                </div>

            <?php
            } else if( $field_type == 'checkbox_list' ) { ?>

                <div class="form-group">
                    <label for="<?php echo esc_attr($field_name); ?>">
                        <?php echo $field_title.houzez_required_field($field_name); ?>
                    </label>
                    <div class="features-list houzez-custom-field">
                        <?php
                        $options    = unserialize( $field_options );
                        $options    = explode( ',', $options );
                        $options    = array_filter( array_map( 'trim', $options ) );
                        $checkboxes = array_combine( $options, $options );

                        foreach ($checkboxes as $checkbox) {

                            $checked = ( houzez_edit_property() && ! empty( $data_value ) && in_array( $checkbox, $data_value ) ) ? 'checked' : '';
                            $checkbox_title = houzez_wpml_translate_single_string($checkbox);
                            echo '<label class="control control--checkbox">';
                                echo '<input type="checkbox" '.esc_attr($checked).' name="'.esc_attr($field_name).'[]" value="'.esc_attr($checkbox).'">'.esc_attr($checkbox_title);
                                echo '<span class="control__indicator"></span>';
                            echo '</label>';

                        }
                        ?>
                    </div><!-- features-list -->
                </div>

            <?php
            } else if( $field_type == 'radio' ) { ?>

                <div class="form-group">
                    <label for="<?php echo esc_attr($field_name); ?>">
                        <?php echo $field_title.houzez_required_field($field_name); ?>
                    </label>
                    <div class="features-list houzez-custom-field">
                        <?php
                        $options    = unserialize( $field_options );
                        $options    = explode( ',', $options );
                        $options    = array_filter( array_map( 'trim', $options ) );
                        $radios     = array_combine( $options, $options );

                        echo '<label class="control control--radio">';
                            echo '<input type="radio" name="'.esc_attr($field_name).'" value="">'.esc_html__('None', 'houzez');
                            echo '<span class="control__indicator"></span>';
                        echo '</label>';

                        foreach ($radios as $radio) {

                            $radio_checked = ( houzez_edit_property() && ! empty( $data_value ) && in_array( $radio, $data_value ) ) ? 'checked' : '';

                            $radio_title = houzez_wpml_translate_single_string($radio);
                            echo '<label class="control control--radio">';
                                echo '<input type="radio" '.esc_attr($radio_checked).' name="'.esc_attr($field_name).'" value="'.esc_attr($radio).'">'.esc_attr($radio_title);
                                echo '<span class="control__indicator"></span>';
                            echo '</label>';

                        }
                        ?>
                    </div><!-- features-list -->
                </div>

            <?php
            } else if( $field_type == 'number' ) { ?>

                <div class="form-group">
                    <label for="<?php echo esc_attr($field_name); ?>">
                        <?php echo $field_title.houzez_required_field($field_name); ?>
                    </label>
                    <input name="<?php echo esc_attr($field_name);?>" <?php houzez_required_field_2($field_name); ?> type="number" min="1" class="form-control" value="<?php
                    if (houzez_edit_property()) {
                        houzez_field_meta($field_name);
                    } ?>" placeholder="<?php echo esc_attr($placeholder);?>">
                </div>

            <?php
            } else { ?>

                <div class="form-group">
                    <label for="<?php echo esc_attr($field_name); ?>">
                        <?php echo $field_title.houzez_required_field($field_name); ?>
                    </label>

                    <input name="<?php echo esc_attr($field_name);?>" <?php houzez_required_field_2($field_name); ?> type="text" class="form-control" value="<?php
                    if (houzez_edit_property()) {
                        houzez_field_meta($field_name);
                    } ?>" placeholder="<?php echo esc_attr($placeholder);?>">
                </div>

            <?php
            }

        }
    }
}

add_action('wp_ajax_load_lightbox_content', 'houzez_listing_model');
add_action('wp_ajax_nopriv_load_lightbox_content', 'houzez_listing_model');

if( !function_exists('houzez_listing_model')) {
    function houzez_listing_model() {
        $listing_id = isset($_POST['listing_id']) ? $_POST['listing_id'] : '';

        if(empty($listing_id)) {
            echo esc_html__('Nothing found', 'houzez');
            return;
        }
        

        $lightbox_logo = houzez_option( 'lightbox_logo', false, 'url' );

        $userID      =   get_current_user_id();
        $fav_option = 'houzez_favorites-'.$userID;
        $fav_option = get_option( $fav_option );
        $icon = $key = '';
        if( !empty($fav_option) ) {
            $key = array_search($listing_id, $fav_option);
        }
        if( $key != false || $key != '' ) {
            $icon = 'text-danger';
        }
    
        $prop_id = houzez_get_listing_data_by_id('property_id', $listing_id);
        $prop_size = houzez_get_listing_data_by_id('property_size', $listing_id);
        $land_area = houzez_get_listing_data_by_id('property_land', $listing_id);
        $bedrooms = houzez_get_listing_data_by_id('property_bedrooms', $listing_id);
        $rooms = houzez_get_listing_data_by_id('property_rooms', $listing_id);
        $bathrooms = houzez_get_listing_data_by_id('property_bathrooms', $listing_id);
        $year_built = houzez_get_listing_data_by_id('property_year', $listing_id);
        $garage = houzez_get_listing_data_by_id('property_garage', $listing_id);
        $property_type = houzez_taxonomy_simple_2('property_type', $listing_id);
        $garage_size = houzez_get_listing_data_by_id('property_garage_size', $listing_id);
        $address = houzez_get_listing_data_by_id('property_map_address', $listing_id);

        $term_status = wp_get_post_terms( $listing_id, 'property_status', array("fields" => "all"));
        $term_label = wp_get_post_terms( $listing_id, 'property_label', array("fields" => "all"));

        $size = 'houzez-gallery';
        $properties_images = rwmb_meta( 'fave_property_images', 'type=plupload_image&size='.$size, $listing_id );

        $token = wp_generate_password(5, false, false);

    ?>
    <div class="modal-header">
        <div class="d-flex align-items-center">
            <div class="lightbox-logo flex-grow-1">
                <?php if(!empty($lightbox_logo)) { ?>
                <img class="img-fluid" src="<?php echo esc_url($lightbox_logo); ?>" alt="logo">
                <?php } ?>
            </div><!-- lightbox-logo -->
            <div class="lightbox-tools">
                <ul class="list-inline">
                    <?php if( houzez_option('disable_favorite') != 0 ) { ?>
                    <li class="list-inline-item btn-favorite">
                        <a class="add-favorite-js" data-listid="<?php echo intval($listing_id)?>" href="#"><i class="houzez-icon icon-love-it mr-2 <?php echo esc_attr($icon); ?>"></i> <span class="display-none"><?php esc_html_e('Favorite', 'houzez'); ?></span></a>
                    </li>
                    <?php } ?>
                </ul>
            </div><!-- lightbox-tools -->
        </div><!-- d-flex -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div><!-- modal-header -->

    <div class="modal-body clearfix">

        <div class="lightbox-gallery-wrap">
            <a class="btn-expand">
                <i class="houzez-icon icon-expand-3"></i>
            </a>
            
            <?php  if( !empty($properties_images) && count($properties_images)) { ?>
            <div class="lightbox-gallery">
                <div id="preview-js-<?php echo esc_attr($token); ?>" class="lightbox-slider">
                    
                    <?php
                    $lightbox_caption = houzez_option('lightbox_caption', 0); 
                    foreach( $properties_images as $prop_image_id => $prop_image_meta ) {
                        $output = '';
                        $output .= '<div>';
                            $output .= '<img class="img-fluid" src="'.esc_url( $prop_image_meta['full_url'] ).'" alt="'.esc_attr($prop_image_meta['alt']).'" title="'.esc_attr($prop_image_meta['title']).'">';

                            if( !empty($prop_image_meta['caption']) && $lightbox_caption != 0 ) {
                                $output .= '<span class="hz-image-caption">'.esc_attr($prop_image_meta['caption']).'</span>';
                            }

                        $output .= '</div>';

                        echo $output;
                    }
                    ?>
                    
                </div>
            </div><!-- lightbox-gallery -->
            <?php 
            } else { 
                $featured_image_url = houzez_get_image_url('full', $listing_id);
                echo '<div>
                    <img class="img-fluid" src="'.esc_url($featured_image_url[0]).'">
                </div>';
            } ?>

        </div><!-- lightbox-gallery-wrap -->


        <div class="lightbox-content-wrap lightbox-form-wrap">
        
            <div class="labels-wrap labels-right"> 
                <?php 
                if( !empty($term_status) ) {
                    foreach( $term_status as $status ) {
                        $status_id = $status->term_id;
                        $status_name = $status->name;
                        echo '<a href="'.get_term_link($status_id).'" class="label-status label status-color-'.intval($status_id).'">
                                '.esc_attr($status_name).'
                            </a>';
                    }
                }

                if( !empty($term_label) ) {
                    foreach( $term_label as $label ) {
                        $label_id = $label->term_id;
                        $label_name = $label->name;
                        echo '<a href="'.get_term_link($label_id).'" class="label label-color-'.intval($label_id).'">
                                '.esc_attr($label_name).'
                            </a>';
                    }
                }
                ?>       
            </div>
            
            <h2 class="item-title">
                <a href="<?php echo esc_url(get_permalink($listing_id)); ?>"><?php echo get_the_title($listing_id); ?></a>
            </h2><!-- item-title -->

            <?php 
            if(!empty($address)) {
                echo '<address class="item-address">'.esc_attr($address).'</address>';
            }
            ?>
            
            <ul class="item-price-wrap hide-on-list">
                <?php echo houzez_listing_price_v1($listing_id); ?>
            </ul>

            <p><?php echo houzez_get_excerpt(23, $listing_id); ?></p>

            <div class="property-overview-data">
                <?php
                $listing_data_composer = houzez_option('preview_data_composer');
                $data_composer = $listing_data_composer['enabled'];

                $meta_type = houzez_option('preview_meta_type');

                $bd_output = $b_output = $id_output = $garage_output = $area_size_output = $land_output = $year_output = $icon = $icon_bt = $icon_prop_id = $icon_garage = $icon_areasize = $icon_land = $icon_year = $cus_output = $cus_icon = '';
                $i = 0;
                if ($data_composer) {
                    unset($data_composer['placebo']);
                    foreach ($data_composer as $key=>$value) { $i ++;

                        $listing_area_size = houzez_get_listing_area_size( $listing_id );
                        $listing_size_unit = houzez_get_listing_size_unit( $listing_id );

                        $listing_land_size = houzez_get_land_area_size( $listing_id );
                        $listing_land_unit = houzez_get_land_size_unit( $listing_id );

                        if( $key == 'bed' && $bedrooms != '' ) {

                            $bd_output .= '<ul class="list-unstyled flex-fill">';
                                $bd_output .= '<li class="property-overview-item">';
                                    
                                    if(houzez_option('icons_type') == 'font-awesome') {
                                        $icon .= '<i class="'.houzez_option('fa_bed').' mr-1"></i>';

                                    } elseif (houzez_option('icons_type') == 'custom') {
                                        $cus_icon = houzez_option('bed');
                                        if(!empty($cus_icon['url'])) {
                                            $icon .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon .= '<i class="houzez-icon icon-hotel-double-bed-1 mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $bd_output .= $icon;
                                    }
                                    
                                    $bd_output .= '<strong>'.esc_attr($bedrooms).'</strong>';
                                    
                                $bd_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $prop_bed_label = ($bedrooms > 1 ) ? houzez_option('glc_bedrooms', 'Bedrooms') : houzez_option('glc_bedroom', 'Bedroom');
                                    $bd_output .= '<li class="h-beds">'.esc_attr($prop_bed_label).'</li>';
                                }

                            $bd_output .= '</ul>';

                            if(!empty($bd_output)) {
                                echo $bd_output;
                            }

                        } else if( $key == 'room' && $rooms != '' ) {

                            $rooms_output .= '<ul class="list-unstyled flex-fill">';
                                $rooms_output .= '<li class="property-overview-item">';
                                    
                                    if(houzez_option('icons_type') == 'font-awesome') {
                                        $room_icon .= '<i class="'.houzez_option('fa_room').' mr-1"></i>';

                                    } elseif (houzez_option('icons_type') == 'custom') {
                                        $cus_icon = houzez_option('room');
                                        if(!empty($cus_icon['url'])) {
                                            $room_icon .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $room_icon .= '<i class="houzez-icon icon-hotel-double-bed-1 mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $rooms_output .= $room_icon;
                                    }
                                    
                                    $rooms_output .= '<strong>'.esc_attr($rooms).'</strong>';
                                    
                                $rooms_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $prop_room_label = ($rooms > 1 ) ? houzez_option('glc_rooms', 'Rooms') : houzez_option('glc_room', 'Room');
                                    $rooms_output .= '<li class="h-beds">'.esc_attr($prop_room_label).'</li>';
                                }

                            $rooms_output .= '</ul>';

                            if(!empty($rooms_output)) {
                                echo $rooms_output;
                            }

                        } elseif( $key == 'bath' && $bathrooms != "" ) {

                            $b_output .= '<ul class="list-unstyled flex-fill">';
                                $b_output .= '<li class="property-overview-item">';
                                    
                                    if(houzez_option('icons_type') == 'font-awesome') {
                                        $icon_bt .= '<i class="'.houzez_option('fa_bath').' mr-1"></i>';

                                    } elseif (houzez_option('icons_type') == 'custom') {
                                        $cus_icon = houzez_option('bath');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_bt .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_bt .= '<i class="houzez-icon icon-bathroom-shower-1 mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $b_output .= $icon_bt;
                                    }
                                    
                                    $b_output .= '<strong>'.esc_attr($bathrooms).'</strong>';
                                    
                                $b_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $prop_bath_label = ($bathrooms > 1 ) ? houzez_option('glc_bathrooms', 'Bathrooms') : houzez_option('glc_bathroom', 'Bathroom');
                                    $b_output .= '<li class="h-baths">'.esc_attr($prop_bath_label).'</li>';
                                }

                            $b_output .= '</ul>';

                            if(!empty($b_output)) {
                                echo $b_output;
                            }

                        } elseif( $key == 'property-id' && $prop_id != "" ) {

                            $id_output .= '<ul class="list-unstyled flex-fill">';
                                $id_output .= '<li class="property-overview-item">';
                                    
                                    if(houzez_option('icons_type') == 'font-awesome') {
                                        $icon_prop_id .= '<i class="'.houzez_option('fa_property-id').' mr-1"></i>';

                                    } elseif (houzez_option('icons_type') == 'custom') {
                                        $cus_icon = houzez_option('property-id');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_prop_id .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_prop_id .= '<i class="houzez-icon icon-tags mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $id_output .= $icon_prop_id;
                                    }
                                    
                                    $id_output .= '<strong>'.esc_attr($prop_id).'</strong>';
                                    
                                $id_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $prop_id_label = houzez_option('glc_listing_id', 'Listing ID');
                                    $id_output .= '<li class="h-property-id">'.esc_attr($prop_id_label).'</li>';
                                }

                            $id_output .= '</ul>';

                            if(!empty($id_output)) {
                                echo $id_output;
                            }

                        } elseif( $key == 'garage' && $garage != "" ) {

                            $garage_output .= '<ul class="list-unstyled flex-fill">';
                                $garage_output .= '<li class="property-overview-item">';
                                    
                                    if(houzez_option('icons_type') == 'font-awesome') {
                                        $icon_garage .= '<i class="'.houzez_option('fa_garage').' mr-1"></i>';

                                    } elseif (houzez_option('icons_type') == 'custom') {
                                        $cus_icon = houzez_option('garage');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_garage .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_garage .= '<i class="houzez-icon icon-car-1 mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $garage_output .= $icon_garage;
                                    }
                                    
                                    $garage_output .= '<strong>'.esc_attr($garage).'</strong>';
                                    
                                $garage_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $prop_garage_label = ($garage > 1 ) ? houzez_option('glc_garages', 'Garages') : houzez_option('glc_garage', 'Garage');
                                    $garage_output .= '<li class="h-garage">'.esc_attr($prop_garage_label).'</li>';
                                }

                            $garage_output .= '</ul>';

                            if(!empty($garage_output)) {
                                echo $garage_output;
                            }

                        } elseif( $key == 'area-size' && $listing_area_size != "" ) {

                            $area_size_output .= '<ul class="list-unstyled flex-fill">';
                                $area_size_output .= '<li class="property-overview-item">';
                                    
                                    if(houzez_option('icons_type') == 'font-awesome') {
                                        $icon_areasize .= '<i class="'.houzez_option('fa_area-size').' mr-1"></i>';

                                    } elseif (houzez_option('icons_type') == 'custom') {
                                        $cus_icon = houzez_option('area-size');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_areasize .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_areasize .= '<i class="houzez-icon icon-ruler-triangle mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $area_size_output .= $icon_areasize;
                                    }
                                    
                                    $area_size_output .= '<strong>'.esc_attr($listing_area_size).'</strong>';
                                    
                                $area_size_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $area_size_output .= '<li class="h-area">'.$listing_size_unit.'</li>';
                                }

                            $area_size_output .= '</ul>';

                            if(!empty($area_size_output)) {
                                echo $area_size_output;
                            }

                        } elseif( $key == 'land-area' && $listing_land_size != "" ) {

                            $land_output .= '<ul class="list-unstyled flex-fill">';
                                $land_output .= '<li class="property-overview-item">';
                                    
                                    if(houzez_option('icons_type') == 'font-awesome') {
                                        $icon_land .= '<i class="'.houzez_option('fa_land-area').' mr-1"></i>';

                                    } elseif (houzez_option('icons_type') == 'custom') {
                                        $cus_icon = houzez_option('land-area');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_land .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_land .= '<i class="houzez-icon icon-real-estate-dimensions-map mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $land_output .= $icon_land;
                                    }
                                    
                                    $land_output .= '<strong>'.esc_attr($listing_land_size).'</strong>';
                                    
                                $land_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $land_output .= '<li class="h-land-area">'.$listing_land_unit.'</li>';
                                }

                            $land_output .= '</ul>';

                            if(!empty($listing_land_size)) {
                                echo $land_output;
                            }

                        }  elseif( $key == 'year-built' && $year_built != "" ) {

                            $year_output .= '<ul class="list-unstyled flex-fill">';
                                $year_output .= '<li class="property-overview-item">';
                                    
                                    if(houzez_option('icons_type') == 'font-awesome') {
                                        $icon_year .= '<i class="'.houzez_option('fa_year-built').' mr-1"></i>';

                                    } elseif (houzez_option('icons_type') == 'custom') {
                                        $cus_icon = houzez_option('year-built');
                                        if(!empty($cus_icon['url'])) {
                                            $icon_year .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                        }
                                    } else {
                                        $icon_year .= '<i class="houzez-icon icon-attachment mr-1"></i>';
                                    }

                                    if( $meta_type != 'text' ) {
                                        $year_output .= $icon_year;
                                    }
                                    
                                    $year_output .= '<strong>'.esc_attr($year_built).'</strong>';
                                    
                                $year_output .= '</li>';

                                if( $meta_type != 'icons' ) {
                                    $year_output .= '<li class="h-year-built">'.houzez_option('glc_year_built', 'Year Built').'</li>';
                                }

                            $year_output .= '</ul>';

                            if(!empty($year_built)) {
                                echo $year_output;
                            }

                        } else {
                            
                            $cus_output = '';
                            $cus_data = houzez_get_listing_data_by_id($key, $listing_id);

                            $cus_output .= '<ul class="list-unstyled flex-fill">';
                            $cus_output .= '<li class="property-overview-item">';
                                
                                if(houzez_option('icons_type') == 'font-awesome') {
                                    $cus_icon .= '<i class="'.houzez_option('fa_'.$key).' mr-1"></i>';

                                } elseif (houzez_option('icons_type') == 'custom') {
                                    $cus_icon = houzez_option($key);
                                    if(!empty($cus_icon['url'])) {
                                        $cus_icon .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                    }
                                } 

                                if( $meta_type != 'text' ) {
                                    $cus_output .= $cus_icon;
                                }
                                
                                $cus_output .= '<strong>'.esc_attr($cus_data).'</strong>';
                                
                            $cus_output .= '</li>';

                            if( $meta_type != 'icons' ) {
                                $cus_output .= '<li class="h-year-built">'.esc_attr($value).'</li>';
                            }

                        $cus_output .= '</ul>';

                        if(!empty($cus_data)) {
                            echo $cus_output;
                        }

                        } // end else
                    if($i == 6)
                        break;
                    }
                }

                ?>
                
            </div>
            
            <a class="btn btn-primary btn-item" href="<?php echo esc_url(get_permalink($listing_id)); ?>">
                <?php echo houzez_option('glc_detail_btn', 'Details'); ?>
            </a><!-- btn-item -->

        </div><!-- lightbox-content-wrap -->
    </div><!-- modal-body -->
    <div class="modal-footer">
        
    </div><!-- modal-footer -->

    <?php
    wp_die();
    }
}

if ( ! function_exists( 'houzez_taxonomy_pagination' ) ) {
    /**
     * Update Taxonomy Pagination according to theme option
     *
     * @param $query
     */
    function houzez_taxonomy_pagination( $query ) {
        if ( is_tax( 'property_type' ) || is_tax( 'property_status' ) || is_tax( 'property_label' ) || is_tax( 'property_city' ) || is_tax( 'property_feature' ) || is_tax( 'property_country' ) || is_tax( 'property_state' ) || is_tax( 'property_area' ) ) {
            if ( $query->is_main_query() ) {
                $taxonomy_num_posts = houzez_option('taxonomy_num_posts');
                $number_of_prop = intval($taxonomy_num_posts);
                if(!$number_of_prop){
                    $number_of_prop = 9;
                }
                $query->set( 'posts_per_page', $number_of_prop );
            }
        }
    }

    add_action( 'pre_get_posts', 'houzez_taxonomy_pagination' );
}