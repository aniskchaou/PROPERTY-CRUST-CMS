<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 03/10/15
 * Time: 7:57 PM
 */

/*-----------------------------------------------------------------------------------*/
/*	 Get Profile Picture
/*-----------------------------------------------------------------------------------*/
if(!function_exists('houzez_get_profile_pic')) {
    function houzez_get_profile_pic($user_id = null) {

        if(empty($user_id)) {
            $user_id = get_the_author_meta( 'ID' );
        }
        
        $author_picture_id      =   get_the_author_meta( 'fave_author_picture_id' , $user_id );
        $user_custom_picture = get_the_author_meta( 'fave_author_custom_picture', $user_id );

        if( !empty( $author_picture_id ) ) {
            $author_picture_id = intval( $author_picture_id );
            if ( $author_picture_id ) {
                $img = wp_get_attachment_image_src( $author_picture_id, 'large' );
                $user_custom_picture = $img[0];

            }
        }

        if($user_custom_picture =='' ) {
            $user_custom_picture = HOUZEZ_IMAGE. 'profile-avatar.png';
        }

        return $user_custom_picture;
    }
}


/*-----------------------------------------------------------------------------------*/
/*   Upload picture for user profile using ajax
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'houzez_user_picture_upload' ) ) {
    function houzez_user_picture_upload( ) {

        $user_id = $_REQUEST['user_id'];
        $verify_nonce = $_REQUEST['verify_nonce'];
        if ( ! wp_verify_nonce( $verify_nonce, 'houzez_upload_nonce' ) ) {
            echo json_encode( array( 'success' => false , 'reason' => 'Invalid request' ) );
            die;
        }

        $houzez_user_image = $_FILES['houzez_file_data_name'];
        $houzez_wp_handle_upload = wp_handle_upload( $houzez_user_image, array( 'test_form' => false ) );

        if ( isset( $houzez_wp_handle_upload['file'] ) ) {
            $file_name  = basename( $houzez_user_image['name'] );
            $file_type  = wp_check_filetype( $houzez_wp_handle_upload['file'] );

            $uploaded_image_details = array(
                'guid'           => $houzez_wp_handle_upload['url'],
                'post_mime_type' => $file_type['type'],
                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            $profile_attach_id      =   wp_insert_attachment( $uploaded_image_details, $houzez_wp_handle_upload['file'] );
            $profile_attach_data    =   wp_generate_attachment_metadata( $profile_attach_id, $houzez_wp_handle_upload['file'] );
            wp_update_attachment_metadata( $profile_attach_id, $profile_attach_data );

            $thumbnail_url = wp_get_attachment_image_src( $profile_attach_id, 'large' );
            houzez_save_user_photo($user_id, $profile_attach_id, $thumbnail_url);

            echo json_encode( array(
                'success'   => true,
                'url' => $thumbnail_url[0],
                'attachment_id'    => $profile_attach_id
            ));
            die;

        } else {
            echo json_encode( array( 'success' => false, 'reason' => 'Profile Photo upload failed!' ) );
            die;
        }

    }
}
add_action( 'wp_ajax_houzez_user_picture_upload', 'houzez_user_picture_upload' );    // only for logged in user

if( !function_exists('houzez_save_user_photo')) {
    function houzez_save_user_photo($user_id, $pic_id, $thumbnail_url) {
        
        update_user_meta( $user_id, 'fave_author_picture_id', $pic_id );
        update_user_meta( $user_id, 'fave_author_custom_picture', $thumbnail_url[0] );

        $user_agent_id = get_the_author_meta('fave_author_agent_id', $user_id);
        $user_agency_id = get_the_author_meta('fave_author_agency_id', $user_id);
        
        if( !empty($user_agent_id) ) {
            update_post_meta( $user_agent_id, '_thumbnail_id', $pic_id );

        } else if( !empty($user_agency_id) ) {
            update_post_meta( $user_agency_id, '_thumbnail_id', $pic_id );
        }

    }
}

/* ------------------------------------------------------------------------------
* Ajax Update Profile function
/------------------------------------------------------------------------------ */
add_action( 'wp_ajax_nopriv_houzez_ajax_update_profile', 'houzez_ajax_update_profile' );
add_action( 'wp_ajax_houzez_ajax_update_profile', 'houzez_ajax_update_profile' );

if( !function_exists('houzez_ajax_update_profile') ):

    function houzez_ajax_update_profile(){
        global $current_user;
        wp_get_current_user();
        $userID  = $current_user->ID;
        check_ajax_referer( 'houzez_profile_ajax_nonce', 'houzez-security-profile' );

        $user_company = $userlangs = $latitude = $longitude = $tax_number = $user_location = $license = $user_address = $fax_number = $firstname = $lastname = $title = $about = $userphone = $usermobile = $userskype = $facebook = $twitter = $linkedin = $instagram = $pinterest = $profile_pic = $profile_pic_id = $website = $useremail = $service_areas = $specialties = $whatsapp = '';

        // Update first name
        if ( !empty( $_POST['firstname'] ) ) {
            $firstname = sanitize_text_field( $_POST['firstname'] );
            update_user_meta( $userID, 'first_name', $firstname );
        } else {
            delete_user_meta( $userID, 'first_name' );
        }

        // Update GDPR
        if ( !empty( $_POST['gdpr_agreement'] ) ) {
            $gdpr_agreement = sanitize_text_field( $_POST['gdpr_agreement'] );
            update_user_meta( $userID, 'gdpr_agreement', $gdpr_agreement );
        } else {
            delete_user_meta( $userID, 'gdpr_agreement' );
        }

        // Update last name
        if ( !empty( $_POST['lastname'] ) ) {
            $lastname = sanitize_text_field( $_POST['lastname'] );
            update_user_meta( $userID, 'last_name', $lastname );
        } else {
            delete_user_meta( $userID, 'last_name' );
        }

        // Update Language
        if ( !empty( $_POST['userlangs'] ) ) {
            $userlangs = sanitize_text_field( $_POST['userlangs'] );
            update_user_meta( $userID, 'fave_author_language', $userlangs );
        } else {
            delete_user_meta( $userID, 'fave_author_language' );
        }


        // Update user_company
        if ( !empty( $_POST['user_company'] ) ) {
            $agency_id = get_user_meta($userID, 'fave_author_agency_id', true);
            $user_company = sanitize_text_field( $_POST['user_company'] );
            if( !empty($agency_id) ) {
                $user_company = get_the_title($agency_id);
            }
            update_user_meta( $userID, 'fave_author_company', $user_company );
        } else {
            $agency_id = get_user_meta($userID, 'fave_author_agency_id', true);
            if( !empty($agency_id) ) {
                update_user_meta( $userID, 'fave_author_company', get_the_title($agency_id) );
            } else {
                delete_user_meta($userID, 'fave_author_company');
            }
        }

        // Update Title
        if ( !empty( $_POST['title'] ) ) {
            $title = sanitize_text_field( $_POST['title'] );
            update_user_meta( $userID, 'fave_author_title', $title );
        } else {
            delete_user_meta( $userID, 'fave_author_title' );
        }

        // Update About
        if ( !empty( $_POST['bio'] ) ) {
            $about = wp_kses_post(  wpautop( wptexturize( $_POST['bio'] ) ) );
            update_user_meta( $userID, 'description', $about );
        } else {
            delete_user_meta( $userID, 'description' );
        }

        // Update Phone
        if ( !empty( $_POST['userphone'] ) ) {
            $userphone = sanitize_text_field( $_POST['userphone'] );
            update_user_meta( $userID, 'fave_author_phone', $userphone );
        } else {
            delete_user_meta( $userID, 'fave_author_phone' );
        }

        // Update Fax
        if ( !empty( $_POST['fax_number'] ) ) {
            $fax_number = sanitize_text_field( $_POST['fax_number'] );
            update_user_meta( $userID, 'fave_author_fax', $fax_number );
        } else {
            delete_user_meta( $userID, 'fave_author_fax' );
        }

        // fave_author_service_areas
        if ( !empty( $_POST['service_areas'] ) ) {
            $service_areas = sanitize_text_field( $_POST['service_areas'] );
            update_user_meta( $userID, 'fave_author_service_areas', $service_areas );
        } else {
            delete_user_meta( $userID, 'fave_author_service_areas' );
        }

        // Specialties
        if ( !empty( $_POST['specialties'] ) ) {
            $specialties = sanitize_text_field( $_POST['specialties'] );
            update_user_meta( $userID, 'fave_author_specialties', $specialties );
        } else {
            delete_user_meta( $userID, 'fave_author_specialties' );
        }

        // Update Mobile
        if ( !empty( $_POST['usermobile'] ) ) {
            $usermobile = sanitize_text_field( $_POST['usermobile'] );
            update_user_meta( $userID, 'fave_author_mobile', $usermobile );
        } else {
            delete_user_meta( $userID, 'fave_author_mobile' );
        }

        // Update WhatsApp
        if ( !empty( $_POST['whatsapp'] ) ) {
            $whatsapp = sanitize_text_field( $_POST['whatsapp'] );
            update_user_meta( $userID, 'fave_author_whatsapp', $whatsapp );
        } else {
            delete_user_meta( $userID, 'fave_author_whatsapp' );
        }

        // Update Skype
        if ( !empty( $_POST['userskype'] ) ) {
            $userskype = sanitize_text_field( $_POST['userskype'] );
            update_user_meta( $userID, 'fave_author_skype', $userskype );
        } else {
            delete_user_meta( $userID, 'fave_author_skype' );
        }

        // Update facebook
        if ( !empty( $_POST['facebook'] ) ) {
            $facebook = sanitize_text_field( $_POST['facebook'] );
            update_user_meta( $userID, 'fave_author_facebook', $facebook );
        } else {
            delete_user_meta( $userID, 'fave_author_facebook' );
        }

        // Update twitter
        if ( !empty( $_POST['twitter'] ) ) {
            $twitter = sanitize_text_field( $_POST['twitter'] );
            update_user_meta( $userID, 'fave_author_twitter', $twitter );
        } else {
            delete_user_meta( $userID, 'fave_author_twitter' );
        }

        // Update linkedin
        if ( !empty( $_POST['linkedin'] ) ) {
            $linkedin = sanitize_text_field( $_POST['linkedin'] );
            update_user_meta( $userID, 'fave_author_linkedin', $linkedin );
        } else {
            delete_user_meta( $userID, 'fave_author_linkedin' );
        }

        // Update instagram
        if ( !empty( $_POST['instagram'] ) ) {
            $instagram = sanitize_text_field( $_POST['instagram'] );
            update_user_meta( $userID, 'fave_author_instagram', $instagram );
        } else {
            delete_user_meta( $userID, 'fave_author_instagram' );
        }

        // Update pinterest
        if ( !empty( $_POST['pinterest'] ) ) {
            $pinterest = sanitize_text_field( $_POST['pinterest'] );
            update_user_meta( $userID, 'fave_author_pinterest', $pinterest );
        } else {
            delete_user_meta( $userID, 'fave_author_pinterest' );
        }

        // Update youtube
        if ( !empty( $_POST['youtube'] ) ) {
            $youtube = sanitize_text_field( $_POST['youtube'] );
            update_user_meta( $userID, 'fave_author_youtube', $youtube );
        } else {
            delete_user_meta( $userID, 'fave_author_youtube' );
        }

        // Update vimeo
        if ( !empty( $_POST['vimeo'] ) ) {
            $vimeo = sanitize_text_field( $_POST['vimeo'] );
            update_user_meta( $userID, 'fave_author_vimeo', $vimeo );
        } else {
            delete_user_meta( $userID, 'fave_author_vimeo' );
        }

        // Update Googleplus
        if ( !empty( $_POST['googleplus'] ) ) {
            $googleplus = sanitize_text_field( $_POST['googleplus'] );
            update_user_meta( $userID, 'fave_author_googleplus', $googleplus );
        } else {
            delete_user_meta( $userID, 'fave_author_googleplus' );
        }

        // Update website
        if ( !empty( $_POST['website'] ) ) {
            $website = sanitize_text_field( $_POST['website'] );
            wp_update_user( array( 'ID' => $userID, 'user_url' => $website ) );
        } else {
            $website = '';
            wp_update_user( array( 'ID' => $userID, 'user_url' => $website ) );
        }

        //For agency Role

        if ( !empty( $_POST['license'] ) ) {
            $license = sanitize_text_field( $_POST['license'] );
            update_user_meta( $userID, 'fave_author_license', $license );
        } else {
            delete_user_meta( $userID, 'fave_author_license' );
        }

        if ( !empty( $_POST['tax_number'] ) ) {
            $tax_number = sanitize_text_field( $_POST['tax_number'] );
            update_user_meta( $userID, 'fave_author_tax_no', $tax_number );
        } else {
            delete_user_meta( $userID, 'fave_author_tax_no' );
        }

        if ( !empty( $_POST['user_address'] ) ) {
            $user_address = sanitize_text_field( $_POST['user_address'] );
            update_user_meta( $userID, 'fave_author_address', $user_address );
        } else {
            delete_user_meta( $userID, 'fave_author_address' );
        }

        if ( !empty( $_POST['user_location'] ) ) {
            $user_location = sanitize_text_field( $_POST['user_location'] );
            update_user_meta( $userID, 'fave_author_google_location', $user_location );
        } else {
            delete_user_meta( $userID, 'fave_author_google_location' );
        }

        if ( !empty( $_POST['latitude'] ) ) {
            $latitude = sanitize_text_field( $_POST['latitude'] );
            update_user_meta( $userID, 'fave_author_google_latitude', $latitude );
        } else {
            delete_user_meta( $userID, 'fave_author_google_latitude' );
        }

        if ( !empty( $_POST['longitude'] ) ) {
            $longitude = sanitize_text_field( $_POST['longitude'] );
            update_user_meta( $userID, 'fave_author_google_longitude', $longitude );
        } else {
            delete_user_meta( $userID, 'fave_author_google_longitude' );
        }

        // Update email
        if( !empty( $_POST['useremail'] ) ) {
            $useremail = sanitize_email( $_POST['useremail'] );
            $useremail = is_email( $useremail );
            if( !$useremail ) {
                echo json_encode( array( 'success' => false, 'msg' => esc_html__('The Email you entered is not valid. Please try again.', 'houzez') ) );
                wp_die();
            } else {
                $email_exists = email_exists( $useremail );
                if( $email_exists ) {
                    if( $email_exists != $userID ) {
                        echo json_encode( array( 'success' => false, 'msg' => esc_html__('This Email is already used by another user. Please try a different one.', 'houzez') ) );
                        wp_die();
                    }
                } else {
                    $return = wp_update_user( array ('ID' => $userID, 'user_email' => $useremail ) );
                    if ( is_wp_error( $return ) ) {
                        $error = $return->get_error_message();
                        echo esc_attr( $error );
                        wp_die();
                    }
                }

                $profile_pic_id = intval( $_POST['profile-pic-id'] );

                $agent_id = get_user_meta( $userID, 'fave_author_agent_id', true );
                $agency_id = get_user_meta( $userID, 'fave_author_agency_id', true );
                $user_as_agent = houzez_option('user_as_agent');

                if (in_array('houzez_agent', (array)$current_user->roles)) {
                    houzez_update_user_agent ( $agent_id, $firstname, $lastname, $title, $about, $userphone, $usermobile, $whatsapp, $userskype, $facebook, $twitter, $linkedin, $instagram, $pinterest, $youtube, $vimeo, $googleplus, $profile_pic, $profile_pic_id, $website, $useremail, $license, $tax_number, $fax_number, $userlangs, $user_address, $user_company, $service_areas, $specialties );
                } elseif(in_array('houzez_agency', (array)$current_user->roles)) {
                    houzez_update_user_agency ( $agency_id, $firstname, $lastname, $title, $about, $userphone, $usermobile, $whatsapp, $userskype, $facebook, $twitter, $linkedin, $instagram, $pinterest, $youtube, $vimeo, $googleplus, $profile_pic, $profile_pic_id, $website, $useremail, $license, $tax_number, $user_address, $user_location, $latitude, $longitude, $fax_number, $userlangs );
                }

            }
        }
        wp_update_user( array ('ID' => $userID, 'display_name' => $_POST['display_name'] ) );
        echo json_encode( array( 'success' => true, 'msg' => esc_html__('Profile updated', 'houzez') ) );
        die();
    }
endif; // end   houzez_ajax_update_profile

/* ------------------------------------------------------------------------------
* Update agency user
/------------------------------------------------------------------------------ */
if( !function_exists('houzez_update_user_agency') ) {
    function houzez_update_user_agency ( $agency_id, $firstname, $lastname, $title, $about, $userphone, $usermobile, $whatsapp, $userskype, $facebook, $twitter, $linkedin, $instagram, $pinterest, $youtube, $vimeo, $googleplus, $profile_pic, $profile_pic_id, $website, $useremail, $license, $tax_number, $user_address, $user_location, $latitude, $longitude, $fax_number, $userlangs ) {

        $args = array(
            'ID' => $agency_id,
            'post_title' => $title,
            'post_content' => $about
        );
        $post_id = wp_update_post($args);

        update_post_meta( $agency_id, 'fave_agency_licenses', $license );
        update_post_meta( $agency_id, 'fave_agency_tax_no', $tax_number );
        update_post_meta( $agency_id, 'fave_agency_fax', $fax_number );
        update_post_meta( $agency_id, 'fave_agency_facebook', $facebook );
        update_post_meta( $agency_id, 'fave_agency_linkedin', $linkedin );
        update_post_meta( $agency_id, 'fave_agency_twitter', $twitter );
        update_post_meta( $agency_id, 'fave_agency_pinterest', $pinterest );
        update_post_meta( $agency_id, 'fave_agency_instagram', $instagram );
        update_post_meta( $agency_id, 'fave_agency_youtube', $youtube );
        update_post_meta( $agency_id, 'fave_agency_vimeo', $vimeo );
        update_post_meta( $agency_id, 'fave_agency_web', $website );
        update_post_meta( $agency_id, 'fave_agency_googleplus', $googleplus );
        update_post_meta( $agency_id, 'fave_agency_phone', $userphone );
        update_post_meta( $agency_id, 'fave_agency_mobile', $usermobile );
        update_post_meta( $agency_id, 'fave_agency_whatsapp', $whatsapp );
        update_post_meta( $agency_id, 'fave_agency_address', $user_address );
        update_post_meta( $agency_id, 'fave_agency_map_address', $user_location );
        update_post_meta( $agency_id, 'fave_agency_location', $latitude.','.$longitude );
        update_post_meta( $agency_id, 'fave_agency_email', $useremail );
        update_post_meta( $agency_id, 'fave_agency_language', $userlangs );

    }
}

/* ------------------------------------------------------------------------------
* Update agent user
/------------------------------------------------------------------------------ */
if( !function_exists('houzez_update_user_agent') ) {
    function houzez_update_user_agent ( $agent_id, $firstname, $lastname, $title, $about, $userphone, $usermobile, $whatsapp, $userskype, $facebook, $twitter, $linkedin, $instagram, $pinterest, $youtube, $vimeo, $googleplus, $profile_pic, $profile_pic_id, $website, $useremail, $license, $tax_number, $fax_number, $userlangs, $user_address, $user_company, $service_areas, $specialties ) {


        if( !empty( $firstname ) || !empty( $lastname ) ) {
            $agr = array(
                'ID' => $agent_id,
                'post_title' => $firstname.' '.$lastname,
                'post_content' => $about
            );
            $post_id = wp_update_post($agr);
        } else {
            $agr = array(
                'ID' => $agent_id,
                'post_content' => $about
            );
            $post_id = wp_update_post($agr);
        }

        
        update_post_meta( $agent_id, 'fave_agent_license', $license );
        update_post_meta( $agent_id, 'fave_agent_tax_no', $tax_number );
        update_post_meta( $agent_id, 'fave_agent_facebook', $facebook );
        update_post_meta( $agent_id, 'fave_agent_linkedin', $linkedin );
        update_post_meta( $agent_id, 'fave_agent_twitter', $twitter );
        update_post_meta( $agent_id, 'fave_agent_pinterest', $pinterest );
        update_post_meta( $agent_id, 'fave_agent_instagram', $instagram );
        update_post_meta( $agent_id, 'fave_agent_youtube', $youtube );
        update_post_meta( $agent_id, 'fave_agent_vimeo', $vimeo );
        update_post_meta( $agent_id, 'fave_agent_website', $website );
        update_post_meta( $agent_id, 'fave_agent_googleplus', $googleplus );
        update_post_meta( $agent_id, 'fave_agent_office_num', $userphone );
        update_post_meta( $agent_id, 'fave_agent_fax', $fax_number );
        update_post_meta( $agent_id, 'fave_agent_mobile', $usermobile );
        update_post_meta( $agent_id, 'fave_agent_whatsapp', $whatsapp );
        update_post_meta( $agent_id, 'fave_agent_skype', $userskype );
        update_post_meta( $agent_id, 'fave_agent_position', $title );
        update_post_meta( $agent_id, 'fave_agent_des', $about );
        update_post_meta( $agent_id, 'fave_agent_email', $useremail );
        update_post_meta( $agent_id, 'fave_agent_language', $userlangs );
        update_post_meta( $agent_id, 'fave_agent_address', $user_address );
        update_post_meta( $agent_id, 'fave_agent_company', $user_company );
        update_post_meta( $agent_id, 'fave_agent_service_area', $service_areas );
        update_post_meta( $agent_id, 'fave_agent_specialties', $specialties );

    }
}

/* ------------------------------------------------------------------------------
* Update agency user agent
/------------------------------------------------------------------------------ */
if( !function_exists('houzez_update_agency_user_agent') ) {
    function houzez_update_agency_user_agent($agency_user_agent_id, $firstname, $lastname, $useremail)
    {
        if (!empty($firstname) || !empty($lastname)) {
            $agr = array(
                'ID' => $agency_user_agent_id,
                'post_title' => $firstname . ' ' . $lastname
            );
            $post_id = wp_update_post($agr);
        }
        update_post_meta( $post_id, 'fave_agent_email', $useremail );
    }
}

/* ------------------------------------------------------------------------------
* Ajax Reset Password function
/------------------------------------------------------------------------------ */
add_action( 'wp_ajax_nopriv_houzez_ajax_password_reset', 'houzez_ajax_password_reset' );
add_action( 'wp_ajax_houzez_ajax_password_reset', 'houzez_ajax_password_reset' );

if( !function_exists('houzez_ajax_password_reset') ):
    function houzez_ajax_password_reset () {
        $userID         = get_current_user_id();
        $allowed_html   = array();

        $newpass        = wp_kses( $_POST['newpass'], $allowed_html );
        $confirmpass    = wp_kses( $_POST['confirmpass'], $allowed_html );

        if( $newpass == '' || $confirmpass == '' ) {
            echo json_encode( array( 'success' => false, 'msg' => esc_html__('New password or confirm password is blank', 'houzez') ) );
            die();
        }
        if( $newpass != $confirmpass ) {
            echo json_encode( array( 'success' => false, 'msg' => esc_html__('Passwords do not match', 'houzez') ) );
            die();
        }

        check_ajax_referer( 'houzez_pass_ajax_nonce', 'houzez-security-pass' );

        $user = get_user_by( 'id', $userID );
        if( $user ) {
            wp_set_password( $newpass, $userID );
            echo json_encode( array( 'success' => true, 'msg' => esc_html__('Password Updated', 'houzez') ) );
        } else {
            echo json_encode( array( 'success' => false, 'msg' => esc_html__('Something went wrong', 'houzez') ) );
        }
        die();
    }
endif; // end houzez_ajax_password_reset

/*-----------------------------------------------------------------------------------*/
/*	 Get uploaded file url
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'houzez_uploaded_image_url' ) ) {
    function houzez_uploaded_image_url( $attachment_data ) {
        $houzez_wp_upload_dir     =   wp_upload_dir();
        $upload_file_path_array   =   explode( '/', $attachment_data['file'] );
        $upload_file_path_array   =   array_slice( $upload_file_path_array, 0, count( $upload_file_path_array ) - 1 );
        $uploaded_image_dir       =   implode( '/', $upload_file_path_array );
        $houzez_thumbnail     =   null;
        if ( isset( $attachment_data['sizes']['houzez-image350_350'] ) ) {
            $houzez_thumbnail     =   $attachment_data['sizes']['houzez-image350_350']['file'];
        } else {
            $houzez_thumbnail     =   $attachment_data['sizes']['thumbnail']['file'];
        }
        return $houzez_wp_upload_dir['baseurl'] . '/' . $uploaded_image_dir . '/' . $houzez_thumbnail ;
    }
}


/* ------------------------------------------------------------------------------
/  User Profile Link
/ ------------------------------------------------------------------------------ */
if( !function_exists('houzez_get_dashboard_profile_link') ):
    function houzez_get_dashboard_profile_link(){
        $get_pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template/user_dashboard_profile.php'
        ));

        if( $get_pages ){
            $get_dash_link = get_permalink( $get_pages[0]->ID);
        }else{
            $get_dash_link = home_url();
        }

        return $get_dash_link;
    }
endif; // end   houzez_get_dashboard_profile_link

/* ------------------------------------------------------------------------------
/  Update User Profile on register
/ ------------------------------------------------------------------------------ */
if( !function_exists('houzez_update_profile') ):

    function houzez_update_profile( $userID ) {

    }
endif; // end houzez_update_profile

/*-----------------------------------------------------------------------------------*/
/*  Houzez Delete Account
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_houzez_delete_account', 'houzez_delete_account' );
add_action( 'wp_ajax_houzez_delete_account', 'houzez_delete_account' );

if ( !function_exists( 'houzez_delete_account' ) ) :

    function houzez_delete_account() {

        global $current_user;
        wp_get_current_user();
        $userID = $current_user->ID;
        $agent_id = get_user_meta($userID, 'fave_author_agent_id', true);
        $agency_id = get_user_meta($userID, 'fave_author_agency_id', true);

        wp_delete_user( $userID );

        if( !empty( $agent_id ) ) {
            houzez_delete_user_agent($agent_id);
        }
        if( !empty( $agency_id ) ) {
            houzez_delete_user_agency($agency_id);
        }
        
        houzez_delete_user_searches($userID);

        echo json_encode( array( 'success' => true, 'msg' => esc_html__('success', 'houzez') ) );
        wp_die();
    }

endif;

if(!function_exists('houzez_delete_user_agent')) {
    function houzez_delete_user_agent($agent_id) {
        wp_delete_post( $agent_id );
        return true;
    }
}

if(!function_exists('houzez_delete_user_agency')) {
    function houzez_delete_user_agency($agency_id) {
        wp_delete_post( $agency_id );
        return true;
    }
}

if(!function_exists('houzez_delete_user_searches')) {
    function houzez_delete_user_searches($user_id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'houzez_search';
        $wpdb->query( 
            $wpdb->prepare("DELETE FROM $table_name WHERE auther_id = %d", $user_id)
        );
        return true;
    }
}

add_action( 'delete_user', 'houzez_delete_user_admin' );
if(!function_exists('houzez_delete_user_admin')) {
    function houzez_delete_user_admin($user_id) {
        $agent_id = get_user_meta($user_id, 'fave_author_agent_id', true);

        houzez_delete_user_agent($agent_id);
        houzez_delete_user_searches($user_id);
    }
}

/*-----------------------------------------------------------------------------------*/
/*  Houzez Delete agency agent Account
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_houzez_delete_agency_agent', 'houzez_delete_agency_agent' );
add_action( 'wp_ajax_houzez_delete_agency_agent', 'houzez_delete_agency_agent' );

if ( !function_exists( 'houzez_delete_agency_agent' ) ) :

    function houzez_delete_agency_agent() {

        check_ajax_referer( 'agent_delete_nonce', 'agent_delete_security' );

        global $current_user;
        wp_get_current_user();
        $userID = $current_user->ID;

        $agent_id = $_POST['agent_id'];
        $agent_parent = get_user_meta($agent_id, 'fave_agent_agency', true);
        $agent_cpt_id = get_user_meta($agent_id, 'fave_author_agent_id', true);

        if( $userID == $agent_parent ) {
            wp_delete_user( $agent_id );
        }

        if( !empty($agent_cpt_id) ) {
            wp_delete_post( $agent_cpt_id, true );
        }

        echo json_encode( array( 'success' => true, 'msg' => esc_html__('success', 'houzez') ) );
        wp_die();
    }

endif;

add_action( 'wp_ajax_nopriv_houzez_change_user_currency', 'houzez_change_user_currency' );
add_action( 'wp_ajax_houzez_change_user_currency', 'houzez_change_user_currency' );
if(!function_exists('houzez_change_user_currency')) {
    function houzez_change_user_currency() {

        if ( is_user_logged_in() && isset( $_POST['currency'] ) ) {

            global $current_user;
            wp_get_current_user();
            $userID = $current_user->ID;

            update_user_meta( $userID, 'fave_author_currency', $_POST['currency']);

            $ajax_response = array('success' => true, 'reason' => esc_html__('Currency updated!', 'houzez'));

            echo json_encode($ajax_response);

            wp_die();
        }
    }
}


add_action( 'wp_ajax_nopriv_houzez_change_user_role', 'houzez_change_user_role' );
add_action( 'wp_ajax_houzez_change_user_role', 'houzez_change_user_role' );
if ( !function_exists( 'houzez_change_user_role' ) ) :
    function houzez_change_user_role()
    {

        check_ajax_referer( 'houzez_role_pass_ajax_nonce', 'houzez-role-security-pass' );

        $ajax_response = array();
        $user_roles = Array ( 'houzez_agency', 'houzez_agent', 'houzez_buyer', 'houzez_seller', 'houzez_owner', 'houzez_manager' );

        if ( is_user_logged_in() && isset( $_POST['role'] ) && in_array( $_POST['role'], $user_roles ) ) {

            global $current_user;
            wp_get_current_user();
            $userID = $current_user->ID;
            $username = $current_user->user_login;
            $user_email = $current_user->user_email;
            $role = $_POST['role'];
            $current_author_meta = get_user_meta( $userID );
            $authorAgentID = $current_author_meta['fave_author_agent_id'][0];
            $authorAgencyID = $current_author_meta['fave_author_agency_id'][0];

            $user_id = wp_update_user( Array ( 'ID' => $userID, 'role' => $role ) );

            if ( is_wp_error( $user_id ) ) {

                $ajax_response = array('success' => false, 'reason' => esc_html__('Role not updated!', 'houzez'));

            } else {

                $ajax_response = array('success' => true, 'reason' => esc_html__('Role updated!', 'houzez'));

                if( $role == 'houzez_agent' || $role == 'houzez_agency' ) {
                    if( $role == 'houzez_agency' ) {
                        wp_delete_post( $authorAgentID, true );
                        houzez_register_as_agency($username, $user_email, $userID);
                        update_user_meta( $userID, 'fave_author_agent_id', '');
                        
                    }elseif( $role == 'houzez_agent' ) {
                        wp_delete_post( $authorAgencyID, true );
                        houzez_register_as_agent($username, $user_email, $userID);
                        update_user_meta( $userID, 'fave_author_agency_id', '');
                    }
                } else {
                    wp_delete_post( $authorAgentID, true );
                    wp_delete_post( $authorAgencyID, true );
                    update_user_meta( $userID, 'fave_author_agent_id', '');
                    update_user_meta( $userID, 'fave_author_agency_id', '');
                }
            }

        } else {

            $ajax_response = array('success' => false, 'reason' => esc_html__('Role not updated!', 'houzez'));

        }

        echo json_encode($ajax_response);

        wp_die();
    }
endif;

add_filter( 'random_user_name', 'random_user_name', 10, 1 );

if( !function_exists('random_user_name') ) {
    function random_user_name($username)
    {

        $user_name = $username . rand(3, 5);

        if (username_exists($user_name)) :

            apply_filters( 'random_user_name', $username );

        else :

            return $user_name;

        endif;
    }
}

/* -----------------------------------------------------------------------------------------------------------
 *  Forgot PassWord function
 -------------------------------------------------------------------------------------------------------------*/

$reset_password_link = houzez_get_template_link_2( 'template/reset_password.php' );

if ( !empty( $reset_password_link ) ) :

    add_action( 'login_form_rp', 'redirect_to_custom_password_reset' );
    add_action( 'login_form_resetpass', 'redirect_to_custom_password_reset' );

endif;

if ( !function_exists( 'redirect_to_custom_password_reset' ) ) :

    function redirect_to_custom_password_reset() {

        if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) :

            $reset_password_link = houzez_get_template_link_2( 'template/reset_password.php' );

            // Verify key / login combo
            $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );

            if ( ! $user || is_wp_error( $user ) ) :

                if ( $user && $user->get_error_code() === 'expired_key' ) :

                    wp_redirect( home_url( $reset_password_link. '?login=expiredkey' ) );

                else :

                    wp_redirect( home_url( $reset_password_link. '?login=invalidkey' ) );

                endif;

                exit;

            endif;


            $redirect_url = add_query_arg( 
                array(
                    'login' => esc_attr( $_REQUEST['login'] ), 
                    'key' => esc_attr( $_REQUEST['key'] ),
                ),
                $reset_password_link 
            );

            wp_redirect( $redirect_url );

            exit;

        endif;

    }

endif;

add_action( 'wp_ajax_nopriv_houzez_reset_password_2', 'houzez_reset_password_2' );
add_action( 'wp_ajax_houzez_reset_password_2', 'houzez_reset_password_2' );

if( !function_exists('houzez_reset_password_2') ) {
    function houzez_reset_password_2() {
        $allowed_html   = array();

        $newpass        = wp_kses( $_POST['password'], $allowed_html );
        $confirmpass    = wp_kses( $_POST['confirm_pass'], $allowed_html );
        $rq_login   = wp_kses( $_POST['rq_login'], $allowed_html );
        $rp_key   = wp_kses( $_POST['rp_key'], $allowed_html );

        $user = check_password_reset_key( $rp_key, $rq_login );

        if ( ! $user || is_wp_error( $user ) ) {

            if ($user && $user->get_error_code() === 'expired_key') {
                echo json_encode(array('success' => false, 'msg' => esc_html__('Reset password Session key expired.', 'houzez')));
                die();
            } else {
                echo json_encode(array('success' => false, 'msg' => esc_html__('Invalid password reset Key', 'houzez')));
                die();
            }
        }

        if( $newpass == '' || $confirmpass == '' ) {
            echo json_encode( array( 'success' => false, 'msg' => esc_html__('New password or confirm password is blank', 'houzez') ) );
            die();
        }
        if( $newpass != $confirmpass ) {
            echo json_encode( array( 'success' => false, 'msg' => esc_html__('Passwords do not match', 'houzez') ) );
            die();
        }

        reset_password( $user, $newpass );
        echo json_encode( array( 'success' => true, 'msg' => esc_html__('Password reset successfully, you can login now.', 'houzez') ) );
        die();
    }
}

/* -----------------------------------------------------------------------------------------------------------
 *  Add user custom fields - Deprecated Since V1.5.0
 -------------------------------------------------------------------------------------------------------------*/
if ( ! function_exists( 'houzez_author_info' ) ) :

    function houzez_author_info( $contactmethods ) {

        global $current_user;
        $current_user = wp_get_current_user();


        $contactmethods['fave_author_title']          = esc_html__( 'Title/Position', 'houzez' );
        $contactmethods['fave_author_company']        = esc_html__( 'Company Name', 'houzez' );
        $contactmethods['fave_author_phone']          = esc_html__( 'Phone', 'houzez' );
        $contactmethods['fave_author_fax']            = esc_html__( 'Fax Number', 'houzez' );
        $contactmethods['fave_author_mobile']         = esc_html__( 'Mobile', 'houzez' );
        $contactmethods['fave_author_skype']          = esc_html__( 'Skype', 'houzez' );
        $contactmethods['fave_author_custom_picture'] = esc_html__( 'Picture Url', 'houzez' );

        //if ( in_array('houzez_agency', (array)$current_user->roles) ) {
        $contactmethods['fave_author_agency_id'] = esc_html__( 'Agency ID', 'houzez' );
        //}

        //if ( in_array('houzez_agent', (array)$current_user->roles) || in_array('author', (array)$current_user->roles) || in_array('administrator', (array)$current_user->roles) ) {
        $contactmethods['fave_author_agent_id'] = esc_html__( 'User Agent ID', 'houzez' );
        //}

        $contactmethods['package_id']                   = 'Package Id';
        $contactmethods['package_activation']           = 'Package Activation';
        $contactmethods['package_listings']             = 'Listings available';
        $contactmethods['package_featured_listings']    = 'Featured Listings available';
        $contactmethods['fave_paypal_profile']          = 'Paypal Recuring Profile';
        $contactmethods['fave_stripe_user_profile']     = 'Stripe Consumer Profile';
        $contactmethods['fave_author_facebook']       = esc_html__( 'Facebook', 'houzez' );
        $contactmethods['fave_author_linkedin']       = esc_html__( 'LinkedIn', 'houzez' );
        $contactmethods['fave_author_twitter']        = esc_html__( 'Twitter', 'houzez' );
        $contactmethods['fave_author_pinterest']      = esc_html__( 'Pinterest', 'houzez' );
        $contactmethods['fave_author_instagram']      = esc_html__( 'Instagram', 'houzez' );
        $contactmethods['fave_author_youtube']        = esc_html__( 'Youtube', 'houzez' );
        $contactmethods['fave_author_vimeo']        = esc_html__( 'Vimeo', 'houzez' );
        $contactmethods['fave_author_googleplus']     = esc_html__( 'Google Plus', 'houzez' );

        return $contactmethods;
    }
endif; // add_agent_contact_info
//add_filter( 'user_contactmethods', 'houzez_author_info', 10, 1 );

/* -----------------------------------------------------------------------------------------------------------
 *  Update profile
 -------------------------------------------------------------------------------------------------------------*/
add_action( 'profile_update', 'houzez_profile_update', 10, 2 );
if( !function_exists('houzez_profile_update') ) {
    function houzez_profile_update($user_id, $old_user_data)
    {
        $user_agent_id = get_the_author_meta('fave_author_agent_id', $user_id);

        $user_agency_id = get_the_author_meta('fave_author_agency_id', $user_id);
        $roles = get_the_author_meta('roles', $user_id);

        if ( in_array('houzez_agent', (array)$roles ) || in_array('houzez_agency', (array)$roles ) ) {
            $email = get_the_author_meta('email', $user_id);
            $website = get_the_author_meta('url', $user_id);
            $first_name = get_the_author_meta('first_name', $user_id);
            $last_name = get_the_author_meta('last_name', $user_id);
            $description = get_the_author_meta('description', $user_id);
            $fave_author_title = get_the_author_meta('fave_author_title', $user_id);
            $fave_author_company = get_the_author_meta('fave_author_company', $user_id);
            $fave_author_phone = get_the_author_meta('fave_author_phone', $user_id);
            $fave_author_fax = get_the_author_meta('fave_author_fax', $user_id);
            $fave_author_mobile = get_the_author_meta('fave_author_mobile', $user_id);
            $fave_author_whatsapp = get_the_author_meta('fave_author_whatsapp', $user_id);
            $fave_author_skype = get_the_author_meta('fave_author_skype', $user_id);
            $fave_author_custom_picture = get_the_author_meta('fave_author_custom_picture', $user_id);
            $fave_author_facebook = get_the_author_meta('fave_author_facebook', $user_id);
            $fave_author_linkedin = get_the_author_meta('fave_author_linkedin', $user_id);
            $fave_author_twitter = get_the_author_meta('fave_author_twitter', $user_id);
            $fave_author_pinterest = get_the_author_meta('fave_author_pinterest', $user_id);
            $fave_author_instagram = get_the_author_meta('fave_author_instagram', $user_id);
            $fave_author_youtube = get_the_author_meta('fave_author_youtube', $user_id);
            $fave_author_vimeo = get_the_author_meta('fave_author_vimeo', $user_id);
            $fave_author_googleplus = get_the_author_meta('fave_author_googleplus', $user_id);
            $fave_author_language = get_the_author_meta('fave_author_language', $user_id);
            $fave_author_tax_no = get_the_author_meta('fave_author_tax_no', $user_id);
            $fave_author_license = get_the_author_meta('fave_author_license', $user_id);

            $agent_featured_iamge = houzez_get_image_id($fave_author_custom_picture);

            if ( in_array('houzez_agent', (array)$roles ) ) {
                if (!empty($user_agent_id)) {
                    if( !empty($first_name) || !empty($last_name) ) {

                        $my_post = array(
                            'ID' => $user_agent_id,
                            'post_title' => $first_name.' '.$last_name
                        );
                        wp_update_post($my_post);
                    }

                    update_post_meta($user_agent_id, 'houzez_user_meta_id', $user_id);  // used when agent custom post type updated
                    update_post_meta($user_agent_id, 'fave_agent_des', $description);
                    update_post_meta($user_agent_id, 'fave_agent_position', $fave_author_title);
                    update_post_meta($user_agent_id, 'fave_agent_mobile', $fave_author_mobile);
                    update_post_meta($user_agent_id, 'fave_agent_whatsapp', $fave_author_whatsapp);
                    update_post_meta($user_agent_id, 'fave_agent_office_num', $fave_author_phone);
                    update_post_meta($user_agent_id, 'fave_agent_fax', $fave_author_fax);
                    update_post_meta($user_agent_id, 'fave_agent_skype', $fave_author_skype);
                    update_post_meta($user_agent_id, 'fave_agent_website', $website);
                    update_post_meta($user_agent_id, 'fave_agent_language', $fave_author_language);
                    update_post_meta($user_agent_id, 'fave_agent_tax_no', $fave_author_tax_no);
                    update_post_meta($user_agent_id, 'fave_agent_licenses', $fave_author_license);
                    update_post_meta($user_agent_id, '_thumbnail_id', $agent_featured_iamge);

                    update_post_meta($user_agent_id, 'fave_agent_facebook', $fave_author_facebook);
                    update_post_meta($user_agent_id, 'fave_agent_linkedin', $fave_author_linkedin);
                    update_post_meta($user_agent_id, 'fave_agent_twitter', $fave_author_twitter);
                    update_post_meta($user_agent_id, 'fave_agent_googleplus', $fave_author_googleplus);
                    update_post_meta($user_agent_id, 'fave_agent_youtube', $fave_author_youtube);
                    update_post_meta($user_agent_id, 'fave_agent_instagram', $fave_author_instagram);
                    update_post_meta($user_agent_id, 'fave_agent_pinterest', $fave_author_pinterest);
                    update_post_meta($user_agent_id, 'fave_agent_vimeo', $fave_author_vimeo);
                    update_post_meta($user_agent_id, 'fave_agent_email', $email);

                    $agency_id = get_user_meta($user_id, 'fave_author_agency_id', true);
                    if( !empty($agency_id) ) {
                        $fave_author_company = get_the_title($agency_id);
                    }
                    update_post_meta($user_agent_id, 'fave_agent_company', $fave_author_company);

                }
            } elseif ( in_array('houzez_agency', (array)$roles ) ) {
                if (!empty($user_agency_id)) {
                    update_post_meta($user_agency_id, 'houzez_user_meta_id', $user_id);  // used when agent custom post type updated

                    update_post_meta($user_agency_id, 'fave_agency_mobile', $fave_author_mobile);
                    update_post_meta($user_agent_id,  'fave_agency_whatsapp', $fave_author_whatsapp);
                    update_post_meta($user_agency_id, 'fave_agency_phone', $fave_author_phone);
                    update_post_meta($user_agency_id, 'fave_agency_fax', $fave_author_fax);
                    update_post_meta($user_agency_id, 'fave_agency_language', $fave_author_language);
                    update_post_meta($user_agency_id, 'fave_agency_tax_no', $fave_author_tax_no);
                    update_post_meta($user_agency_id, 'fave_agency_licenses', $fave_author_license);
                    update_post_meta($user_agency_id, 'fave_agency_web', $website);
                    update_post_meta($user_agency_id, 'fave_agency_email', $email);
                    update_post_meta($user_agency_id, '_thumbnail_id', $agent_featured_iamge);

                    update_post_meta($user_agency_id, 'fave_agency_facebook', $fave_author_facebook);
                    update_post_meta($user_agency_id, 'fave_agency_linkedin', $fave_author_linkedin);
                    update_post_meta($user_agency_id, 'fave_agency_twitter', $fave_author_twitter);
                    update_post_meta($user_agency_id, 'fave_agency_googleplus', $fave_author_googleplus);
                    update_post_meta($user_agency_id, 'fave_agency_youtube', $fave_author_youtube);
                    update_post_meta($user_agency_id, 'fave_agency_instagram', $fave_author_instagram);
                    update_post_meta($user_agency_id, 'fave_agency_pinterest', $fave_author_pinterest);
                    update_post_meta($user_agency_id, 'fave_agency_vimeo', $fave_author_vimeo);
                }
            }
        } // End roles if
    }
}



/**
 * Show custom user profile fields
 * @param  obj $user The user object.
 * @return void
 */
if( !function_exists('houzez_custom_user_profile_fields')) {
    function houzez_custom_user_profile_fields($user) {

        if ( in_array('houzez_agent', (array)$user->roles ) ) {
            $information_title = esc_html__('Agent Profile Info', 'houzez');
            $title = esc_html__('Title/Position', 'houzez');

        } elseif ( in_array('houzez_agency', (array)$user->roles ) ) {
            $information_title = esc_html__('Agency Profile Info', 'houzez');
            $title = esc_html__('Agency Name', 'houzez');

        } elseif ( in_array('author', (array)$user->roles ) ) {
            $information_title = esc_html__('Author Profile Info', 'houzez');
            $title = esc_html__('Title/Position', 'houzez');
        } else {
            $information_title = esc_html__('Profile Info', 'houzez');
            $title = esc_html__('Title/Position', 'houzez');
        }
    ?>
        <h2><?php echo $information_title; ?></h2>
        <table class="form-table">
            <input type="hidden" name="houzez_role" value="<?php echo esc_attr($user->roles[0]); ?>">
            <tbody>
                <tr class="user-fave_author_title-wrap">
                    <th><label for="fave_author_title"><?php echo $title; ?></label></th>
                    <td><input type="text" name="fave_author_title" id="fave_author_title" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_title', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>

                <?php if ( !in_array('houzez_agency', (array)$user->roles ) ) { ?>
                <tr class="user-fave_author_company-wrap">
                    <th><label for="fave_author_company"><?php echo esc_html__('Company Name', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_company" id="fave_author_company" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_company', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <?php } ?>

                <tr class="user-fave_author_language-wrap">
                    <th><label for="fave_author_language"><?php echo esc_html__('Language', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_language" id="fave_author_language" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_language', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_license-wrap">
                    <th><label for="fave_author_license"><?php echo esc_html__('License', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_license" id="fave_author_license" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_license', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_tax_no-wrap">
                    <th><label for="fave_author_tax_no"><?php echo esc_html__('Tax Number', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_tax_no" id="fave_author_tax_no" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_tax_no', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_phone-wrap">
                    <th><label for="fave_author_phone"><?php echo esc_html__('Phone', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_phone" id="fave_author_phone" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_phone', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_fax-wrap">
                    <th><label for="fave_author_fax"><?php echo esc_html__('Fax Number', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_fax" id="fave_author_fax" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_fax', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_mobile-wrap">
                    <th><label for="fave_author_mobile"><?php echo esc_html__('Mobile', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_mobile" id="fave_author_mobile" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_mobile', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_whatsapp-wrap">
                    <th><label for="fave_author_whatsapp"><?php echo esc_html__('WhatsApp', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_whatsapp" id="fave_author_whatsapp" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_whatsapp', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_skype-wrap">
                    <th><label for="fave_author_skype"><?php echo esc_html__('Skype', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_skype" id="fave_author_skype" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_skype', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_custom_picture-wrap">
                    <th><label for="fave_author_custom_picture"><?php echo esc_html__('Picture Url', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_custom_picture" id="fave_author_custom_picture" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_custom_picture', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_agency_id-wrap">
                    <th><label for="fave_author_agency_id"><?php echo esc_html__('Agency ID', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_agency_id" id="fave_author_agency_id" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_agency_id', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_agent_id-wrap">
                    <th><label for="fave_author_agent_id"><?php echo esc_html__('User Agent ID', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_agent_id" id="fave_author_agent_id" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_agent_id', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_agent_id-wrap">
                    <th><label for="fave_author_agent_id"><?php echo esc_html__('Currency', 'houzez'); ?></label></th>
                    <td><input placeholder="<?php echo esc_html__('Enter currency shortcode', 'houzez'); ?>" type="text" name="fave_author_currency" id="fave_author_currency" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_currency', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>

                <tr class="user-fave_author_agent_id-wrap">
                    <th><label for="fave_author_agent_id"><?php echo esc_html__('Service Areas', 'houzez'); ?></label></th>
                    <td><input placeholder="<?php echo esc_html__('Enter your service areas', 'houzez'); ?>" type="text" name="fave_author_service_areas" id="fave_author_service_areas" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_service_areas', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>

                <tr class="user-fave_author_agent_id-wrap">
                    <th><label for="fave_author_agent_id"><?php echo esc_html__('Specialties', 'houzez'); ?></label></th>
                    <td><input placeholder="<?php echo esc_html__('Enter your specialties', 'houzez'); ?>" type="text" name="fave_author_specialties" id="fave_author_specialties" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_specialties', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_agent_id-wrap">
                    <th><label for="fave_author_agent_id"><?php echo esc_html__('Address', 'houzez'); ?></label></th>
                    <td><input placeholder="<?php echo esc_html__('Enter your address', 'houzez'); ?>" type="text" name="fave_author_address" id="fave_author_address" value="<?php echo esc_attr( get_the_author_meta( 'fave_author_address', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
            </tbody>
        </table>

        <h2><?php echo esc_html__('Package Info', 'houzez'); ?></h2>
        <table class="form-table">
            <tbody>
                <tr class="user-package_id-wrap">
                    <th><label for="package_id"><?php echo esc_html__('Package Id', 'houzez'); ?></label></th>
                    <td><input type="text" name="package_id" id="package_id" value="<?php echo esc_attr( get_the_author_meta( 'package_id', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-package_activation-wrap">
                    <th><label for="package_activation"><?php echo esc_html__('Package Activation', 'houzez'); ?></label></th>
                    <td><input type="text" name="package_activation" id="package_activation" value="<?php echo esc_attr( get_the_author_meta( 'package_activation', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-package_listings-wrap">
                    <th><label for="package_listings"><?php echo esc_html__('Listings available', 'houzez'); ?></label></th>
                    <td><input type="text" name="package_listings" id="package_listings" value="<?php echo esc_attr( get_the_author_meta( 'package_listings', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-package_featured_listings-wrap">
                    <th><label for="package_featured_listings"><?php echo esc_html__('Featured Listings available', 'houzez'); ?></label></th>
                    <td><input type="text" name="package_featured_listings" id="package_featured_listings" value="<?php echo esc_attr( get_the_author_meta( 'package_featured_listings', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_paypal_profile-wrap">
                    <th><label for="fave_paypal_profile"><?php echo esc_html__('Paypal Recuring Profile', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_paypal_profile" id="fave_paypal_profile" value="<?php echo esc_attr( get_the_author_meta( 'fave_paypal_profile', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_stripe_user_profile-wrap">
                    <th><label for="fave_stripe_user_profile"><?php echo esc_html__('Stripe Consumer Profile', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_stripe_user_profile" id="fave_stripe_user_profile" value="<?php echo esc_attr( get_the_author_meta( 'fave_stripe_user_profile', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
            </tbody>
        </table>

        <h2><?php echo esc_html__('Social Info', 'houzez'); ?></h2>
        <table class="form-table">
            <tbody>
                <tr class="user-fave_author_facebook-wrap">
                    <th><label for="fave_author_facebook"><?php echo esc_html__('Facebook', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_facebook" id="fave_author_facebook" value="<?php echo esc_url( get_the_author_meta( 'fave_author_facebook', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_linkedin-wrap">
                    <th><label for="fave_author_linkedin"><?php echo esc_html__('LinkedIn', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_linkedin" id="fave_author_linkedin" value="<?php echo esc_url( get_the_author_meta( 'fave_author_linkedin', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_twitter-wrap">
                    <th><label for="fave_author_twitter"><?php echo esc_html__('Twitter', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_twitter" id="fave_author_twitter" value="<?php echo esc_url( get_the_author_meta( 'fave_author_twitter', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_pinterest-wrap">
                    <th><label for="fave_author_pinterest"><?php echo esc_html__('Pinterest', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_pinterest" id="fave_author_pinterest" value="<?php echo esc_url( get_the_author_meta( 'fave_author_pinterest', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_instagram-wrap">
                    <th><label for="fave_author_instagram"><?php echo esc_html__('Instagram', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_instagram" id="fave_author_instagram" value="<?php echo esc_url( get_the_author_meta( 'fave_author_instagram', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_youtube-wrap">
                    <th><label for="fave_author_youtube"><?php echo esc_html__('Youtube', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_youtube" id="fave_author_youtube" value="<?php echo esc_url( get_the_author_meta( 'fave_author_youtube', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_vimeo-wrap">
                    <th><label for="fave_author_vimeo"><?php echo esc_html__('Vimeo', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_vimeo" id="fave_author_vimeo" value="<?php echo esc_url( get_the_author_meta( 'fave_author_vimeo', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
                <tr class="user-fave_author_googleplus-wrap">
                    <th><label for="fave_author_googleplus"><?php echo esc_html__('Google Plus', 'houzez'); ?></label></th>
                    <td><input type="text" name="fave_author_googleplus" id="fave_author_googleplus" value="<?php echo esc_url( get_the_author_meta( 'fave_author_googleplus', $user->ID ) ); ?>" class="regular-text"></td>
                </tr>
            </tbody>
        </table>

    <?php
    }
}
add_action('show_user_profile', 'houzez_custom_user_profile_fields');
add_action('edit_user_profile', 'houzez_custom_user_profile_fields');


if( !function_exists('houzez_update_extra_profile_fields') ) {
    function houzez_update_extra_profile_fields($user_id)
    {
        if (current_user_can('edit_user', $user_id))

        /*
         * Agent and agency Info
        --------------------------------------------------------------------------------*/
        update_user_meta($user_id, 'fave_author_title', $_POST['fave_author_title']);
        update_user_meta($user_id, 'fave_author_agent_id', $_POST['fave_author_agent_id']);
        update_user_meta($user_id, 'fave_author_tax_no', $_POST['fave_author_tax_no']);
        update_user_meta($user_id, 'fave_author_license', $_POST['fave_author_license']);
        update_user_meta($user_id, 'fave_author_agency_id', $_POST['fave_author_agency_id']);
        update_user_meta($user_id, 'fave_author_language', $_POST['fave_author_language']);

        $agency_id = get_user_meta($user_id, 'fave_author_agency_id', true);
        $user_company = $_POST['fave_author_company'];
        if( !empty($agency_id) ) {
            $user_company = get_the_title($agency_id);
        }
        update_user_meta($user_id, 'fave_author_company', $user_company);

        /*
         * Common Info
        --------------------------------------------------------------------------------*/
        update_user_meta($user_id, 'fave_author_phone', $_POST['fave_author_phone']);
        update_user_meta($user_id, 'fave_author_fax', $_POST['fave_author_fax']);
        update_user_meta($user_id, 'fave_author_mobile', $_POST['fave_author_mobile']);
        update_user_meta($user_id, 'fave_author_whatsapp', $_POST['fave_author_whatsapp']);
        update_user_meta($user_id, 'fave_author_skype', $_POST['fave_author_skype']);
        update_user_meta($user_id, 'fave_author_currency', $_POST['fave_author_currency']);
        update_user_meta($user_id, 'fave_author_custom_picture', $_POST['fave_author_custom_picture']);


        /*
         * Package Info
        --------------------------------------------------------------------------------*/
        update_user_meta($user_id, 'package_id', $_POST['package_id']);
        update_user_meta($user_id, 'package_activation', $_POST['package_activation']);
        update_user_meta($user_id, 'package_listings', $_POST['package_listings']);
        update_user_meta($user_id, 'package_featured_listings', $_POST['package_featured_listings']);
        update_user_meta($user_id, 'fave_paypal_profile', $_POST['fave_paypal_profile']);
        update_user_meta($user_id, 'fave_stripe_user_profile', $_POST['fave_stripe_user_profile']);


        /*
         * Social Info
        --------------------------------------------------------------------------------*/
        update_user_meta($user_id, 'fave_author_facebook', $_POST['fave_author_facebook']);
        update_user_meta($user_id, 'fave_author_linkedin', $_POST['fave_author_linkedin']);
        update_user_meta($user_id, 'fave_author_twitter', $_POST['fave_author_twitter']);
        update_user_meta($user_id, 'fave_author_pinterest', $_POST['fave_author_pinterest']);
        update_user_meta($user_id, 'fave_author_instagram', $_POST['fave_author_instagram']);
        update_user_meta($user_id, 'fave_author_youtube', $_POST['fave_author_youtube']);
        update_user_meta($user_id, 'fave_author_vimeo', $_POST['fave_author_vimeo']);
        update_user_meta($user_id, 'fave_author_googleplus', $_POST['fave_author_googleplus']);

    }
}
add_action('edit_user_profile_update', 'houzez_update_extra_profile_fields');
add_action('personal_options_update', 'houzez_update_extra_profile_fields');


if( !function_exists('houzez_registration_save')) {
    function houzez_registration_save($user_id)
    {

        $user_role = houzez_user_role_by_user_id($user_id);
        $user_login = isset($_POST['user_login']) ? $_POST['user_login'] : '';
        $email = $_POST['email'];
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $usermane = $first_name . ' ' . $last_name;

        if ($user_role == 'houzez_agent') {
           houzez_register_as_agent($usermane, $email, $user_id);
        } else if ($user_role == 'houzez_agency') {
            houzez_register_as_agency($usermane, $email, $user_id);
        }
    }

    //add_action('user_register', 'houzez_registration_save', 10, 1);
}

if(!function_exists('houzez_gdrf_data_request')) {
    function houzez_gdrf_data_request() {
        $errors      = array();
        $gdpr_data_type       = isset($_POST['gdpr_data_type']) ? $_POST['gdpr_data_type'] : '';
        $gdpr_data_type       = sanitize_key( $gdpr_data_type );
        $gdrf_data_email      = sanitize_email( $_POST['gdrf_data_email'] );
        $gdrf_data_nonce      = esc_html( filter_input( INPUT_POST, 'gdrf_data_nonce', FILTER_SANITIZE_STRING ) );

        if ( ! empty( $gdrf_data_email ) ) {
            if ( ! wp_verify_nonce( $gdrf_data_nonce, 'houzez_gdrf_nonce' ) ) {
                $errors[] = esc_html__( 'Security check failed, please refresh page and try again.', 'houzez' );
            } else {
                if ( ! is_email( $gdrf_data_email ) ) {
                    $errors[] = esc_html__( 'Email address is not valid.', 'houzez' );
                }
                
                if ( ! in_array( $gdpr_data_type, array( 'export_personal_data', 'remove_personal_data' ), true ) ) {
                    $errors[] = esc_html__( 'Please select request type.', 'houzez' );
                }
            }
        } else {
            $errors[] = esc_html__( 'Fields are required', 'houzez' );
        }

        if ( empty( $errors ) ) {
            $request_id = wp_create_user_request( $gdrf_data_email, $gdpr_data_type );
            if ( is_wp_error( $request_id ) ) {
                wp_send_json_error( $request_id->get_error_message() );
            } elseif ( ! $request_id ) {
                wp_send_json_error( esc_html__( 'Unable to initiate confirmation request. Please contact the administrator.', 'houzez' ) );
            } else {
                $send_request = wp_send_user_request( $request_id );
                wp_send_json_success( esc_html__('Confirmation request initiated successfully.', 'houzez'));
            }
        } else {
            wp_send_json_error($errors);
        }
        die();


    }
}

add_action( 'wp_ajax_houzez_gdrf_data_request', 'houzez_gdrf_data_request' );
add_action( 'wp_ajax_nopriv_houzez_gdrf_data_request', 'houzez_gdrf_data_request' );