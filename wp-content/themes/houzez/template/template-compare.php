<?php
/**
 * Template Name: Compare Properties
 */
get_header();
global $houzez_local;

$page_content_position = houzez_get_listing_data('listing_page_content_area');

$prop_ids = explode(',', $_COOKIE['houzez_compare_listings']);

$basic_info = $prop_address = $prop_status = $prop_type = $listing_title = $listing_price = $prop_city = $prop_state = $prop_zipcode = $prop_additional_features = $prop_country = $prop_beds = $prop_baths = $property_id = $prop_size = $prop_garage = $prop_garage_size = $prop_year = '';
?>

<section class="listing-wrap">
    <div class="container">
        <div class="page-title-wrap">
            <?php get_template_part('template-parts/page/breadcrumb'); ?>
            <div class="d-flex align-items-center">
                <?php get_template_part('template-parts/page/page-title'); ?> 
            </div><!-- d-flex -->  
        </div><!-- page-title-wrap -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                
                <?php
                if ( $page_content_position !== '1' ) {
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            ?>
                            <article <?php post_class(); ?>>
                                <?php the_content(); ?>
                            </article>
                            <?php
                        }
                    } 
                }


                if( !empty($prop_ids) ) {
                    $args = array(
                        'post_type' => 'property',
                        'post__in' => $prop_ids,
                        'post_status' => 'publish',
                        'order' => 'ASC',
                        'orderby' => 'post__in'
                    );

                    $all_featurs = get_terms( array( 'taxonomy' => 'property_feature', 'fields' => 'names' ) );
                    $compare_terms = array();


                    foreach ( $prop_ids as $post_ID ) :

                    $compare_terms[ $post_ID ] = wp_get_post_terms( $post_ID, 'property_feature', array( 'fields' => 'names' ) );

                    endforeach;

                    $custom_compare_data = array();

                    $the_query = New WP_Query($args);
                    if( $the_query->have_posts() ): 
                        while( $the_query->have_posts() ): $the_query->the_post();

                        $address = get_post_meta( get_the_ID(), 'fave_property_address', true );
                        $zipcode = get_post_meta( get_the_ID(), 'fave_property_zip', true );
                        $country = get_post_meta( get_the_ID(), 'fave_property_country', true );
                        $type = houzez_taxonomy_simple('property_type');
                        $status = houzez_taxonomy_simple('property_status');
                        $city = houzez_taxonomy_simple('property_city');
                        $state = houzez_taxonomy_simple('property_state');
                        $country = houzez_taxonomy_simple('property_country');
                        $neighbourhood = houzez_taxonomy_simple('property_area');

                        $prop_id = get_post_meta( get_the_ID(), 'fave_property_id', true );
                        $property_size = get_post_meta( get_the_ID(), 'fave_property_size', true );
                        $bedrooms = get_post_meta( get_the_ID(), 'fave_property_bedrooms', true );
                        $bathrooms = get_post_meta( get_the_ID(), 'fave_property_bathrooms', true );
                        $year_built = get_post_meta( get_the_ID(), 'fave_property_year', true );
                        $garage = get_post_meta( get_the_ID(), 'fave_property_garage', true );
                        $garage_size = get_post_meta( get_the_ID(), 'fave_property_garage_size', true );

                        $bedrooms_label = ($bedrooms > 1 ) ? houzez_option('spl_bedrooms', 'Bedrooms') : houzez_option('spl_bedroom', 'Bedroom');

                        $bath_label = ($bathrooms > 1 ) ? houzez_option('spl_bathrooms', 'Bathrooms') : houzez_option('spl_bathroom', 'Bathroom');

                        $garage_label = ($garage > 1 ) ? houzez_option('spl_garages', 'Garages') : houzez_option('spl_garage', 'Garage');

                            $basic_info .= '
                            <th><a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail( get_the_id(), 'large', array( 'class' => 'img-fluid' ) ).'</a></th>';

                            $listing_title .= '<td>' . get_the_title() . '</td>';
                            $listing_price .= '<td>' . houzez_listing_price() . '</td>';

                            if( !empty($address) ) {
                                $prop_address .= '<td>' . $address . '</td>';
                            } else {
                                $prop_address .= '<td>---</td>';
                            }
                            if( !empty($city) ) {
                                $prop_city .= '<td>' . $city . '</td>';
                            } else {
                                $prop_city .= '<td>---</td>';
                            }

                            if( !empty($type) ) {
                                $prop_type .= '<td>' . $type . '</td>';
                            } else {
                                $prop_type .= '<td>---</td>';
                            }

                            if( !empty($status) ) {
                                $prop_status .= '<td>' . $status . '</td>';
                            } else {
                                $prop_status .= '<td>---</td>';
                            }

                            if( !empty($state) ) {
                                $prop_state .= '<td>' . $state . '</td>';
                            } else {
                                $prop_state .= '<td>---</td>';
                            }

                            if( !empty($zipcode) ) {
                                $prop_zipcode .= '<td>' . $zipcode . '</td>';
                            } else {
                                $prop_zipcode .= '<td>---</td>';
                            }

                            if( !empty( $country ) ) {
                                $prop_country .= '<td>' . $country . '</td>';
                            } else {
                                $prop_country .= '<td>---</td>';
                            }

                            if( !empty($prop_id) ) {
                                $property_id .= '<td>' . $prop_id . '</td>';
                            } else {
                                $property_id .= '<td>---</td>';
                            }

                            if( !empty($bedrooms) ) {
                                $prop_beds .= '<td>' . $bedrooms . '</td>';
                            } else {
                                $prop_beds .= '<td>---</td>';
                            }

                            if( !empty($bathrooms) ) {
                                $prop_baths .= '<td>' . $bathrooms . '</td>';
                            } else {
                                $prop_baths .= '<td>---</td>';
                            }

                            if( !empty($property_size) ) {
                                $prop_size .= '<td>' . houzez_property_size( 'after' ) . '</td>';
                            } else {
                                $prop_size .= '<td>---</td>';
                            }

                            if( !empty($year_built) ) {
                                $prop_year .= '<td>' . $year_built . '</td>';
                            } else {
                                $prop_year .= '<td>---</td>';
                            }

                            if( !empty($garage) ) {
                                $prop_garage .= '<td>' . $garage . '</td>';
                            } else {
                                $prop_garage .= '<td>---</td>';
                            }

                            if( !empty($garage_size) ) {
                                $prop_garage_size .= '<td>' . $garage_size . '</td>';
                            } else {
                                $prop_garage_size .= '<td>---</td>';
                            }


                            /*if(class_exists('Houzez_Fields_Builder')) {
                                $fields_array = Houzez_Fields_Builder::get_form_fields(); 

                                    if(!empty($fields_array)) {
                                        foreach ( $fields_array as $value ) {

                                            $field_type = $value->type;
                                            $meta_type = true;

                                            if( $field_type == 'checkbox_list' || $field_type == 'multiselect' ) {
                                                $meta_type = false;
                                            }

                                            $data_value = get_post_meta( get_the_ID(), 'fave_'.$value->field_id, $meta_type );
                                            $field_title = $value->label;
                                            $field_id = houzez_clean_20($value->field_id);
                                            
                                            $field_title = houzez_wpml_translate_single_string($field_title);

                                            if( $meta_type == true ) {
                                                $data_value = houzez_wpml_translate_single_string($data_value);
                                            } else {
                                                $data_value = houzez_array_to_comma($data_value);
                                            }

                                            if( ! empty($data_value) ) {
                                                $custom_compare_data['title'][] = esc_attr($field_title);
                                                $custom_compare_data['value'][] = esc_attr( $data_value );
                                            } else {
                                                $custom_compare_data['title'][] = esc_attr($field_title);
                                                $custom_compare_data['value'][] = '-';
                                            }
                                        }
                                    }
                                }*/


                        endwhile; 
                    endif;
                }

                //print_r($custom_compare_data);
                ?>         
                <div class="compare-table">
                    <table class="table-striped table-hover">
                        <thead>
                            <tr>
                                <th><!-- empty --></th>
                                <?php echo $basic_info; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong><?php esc_html_e('Title', 'houzez'); ?></strong></td>
                                <?php echo $listing_title; ?>
                            </tr>
                            <tr>
                                <td><strong><?php echo houzez_option('spl_price', 'Price'); ?></strong></td>
                                <?php echo $listing_price; ?>
                            </tr>
                            <tr>
                                <td><strong><?php echo houzez_option('spl_prop_type', 'Property Type'); ?></strong></td>
                                <?php echo $prop_type; ?>
                            </tr>
    
                            <tr>
                                <td><strong><?php echo houzez_option('spl_address', 'Address'); ?></strong></td>
                                <?php echo $prop_address; ?>
                            </tr>
                            <tr>
                                <td><strong><?php echo houzez_option( 'spl_city', 'City' ); ?></strong></td>
                                <?php echo $prop_city; ?>
                            </tr>
                            <tr>
                                <td><strong><?php echo houzez_option('spl_state', 'County/State'); ?></strong></td>
                                <?php echo $prop_state; ?>
                            </tr>
                            <tr>
                                <td><strong><?php echo houzez_option('spl_zip', 'Zip/Postal Code'); ?></strong></td>
                                <?php echo $prop_zipcode; ?>
                            </tr>
                            <tr>
                                <td><strong><?php echo houzez_option('spl_country', 'Country'); ?></strong></td>
                                <?php echo $prop_country; ?>
                            </tr>
                            <tr>
                                <td><strong><?php echo houzez_option('spl_prop_size', 'Property Size'); ?></strong></td>
                                <?php echo $prop_size; ?>
                            </tr>
                            <tr>
                                <td><strong><?php echo houzez_option('spl_prop_id', 'Property ID'); ?></strong></td>
                                <?php echo $property_id; ?>
                            </tr>
                            <tr>
                                <td><strong><?php echo $bedrooms_label; ?></strong></td>
                                <?php echo $prop_beds; ?>
                            </tr>
                            <tr>
                                <td><strong><?php echo $bath_label; ?></strong></td>
                                <?php echo $prop_baths; ?>
                            </tr>
                            <tr>
                                <td><strong><?php echo $garage_label; ?></strong></td>
                                <?php echo $prop_garage; ?>
                            </tr>

                            <?php
                            foreach ( $all_featurs as $data ) :

                            ?>
                            <tr>
                                <td><strong><?php echo $data; ?></strong></td>
                                <?php

                                foreach ( $prop_ids as $post_ID ) :

                                    if ( in_array( $data, $compare_terms[ $post_ID ] ) ) :

                                        echo '<td><i class="houzez-icon icon-check-circle-1 text-success"></i></td>';

                                    else :

                                        echo '<td><i class="houzez-icon icon-remove-circle text-danger"></i></td>';

                                    endif;

                                endforeach;

                                ?>
                            </tr>
                            <?php

                            endforeach;

                            ?>
    
                        </tbody>
                    </table>
                </div>
            </div><!-- col-lg-12 col-md-12 -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- listing-wrap -->

<?php
if ('1' === $page_content_position ) {
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            ?>
            <section class="content-wrap">
                <?php the_content(); ?>
            </section>
            <?php
        }
    }
}
?>

<?php get_footer(); ?>
