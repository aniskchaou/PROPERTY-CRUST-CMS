<?php
if(!function_exists('houzez_map_listing_meta')) {
    function houzez_map_listing_meta() {
        $output = '';
        $inner = '';
        $metadata = '';

        $output .= '<ul class="item-amenities '.houzez_v1_4_meta_type().'">';
            $listing_data_composer = houzez_option('listing_data_composer');
            $data_composer = $listing_data_composer['enabled'];
            if(empty($data_composer)) {
                $data_composer = array();
            }
            unset($data_composer['placebo']);

            $i = 0;
            if ($data_composer) {
                foreach ($data_composer as $key=>$value) { $i ++;
                    if(in_array($key, houzez_listing_composer_fields())) {
                        
                        ob_start();
                        
                        get_template_part('template-parts/listing/partials/'.$key);

                        $preBuilt = ob_get_contents();
                        ob_end_clean();
                        
                        $output .= $preBuilt;

                    } else {
                        $custom_field_value = houzez_get_listing_data($key);
                        $inner = '';
                        if( $custom_field_value != '' ) { 
                            $inner .= '<li class="h-'.$key.'">';

                                if(houzez_option('icons_type') == 'font-awesome') {
                                    $inner .= '<i class="'.houzez_option('fa_'.$key).' mr-1"></i>';

                                } elseif (houzez_option('icons_type') == 'custom') {
                                    $cus_icon = houzez_option($key);
                                    if(!empty($cus_icon['url'])) {
                                        $inner .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
                                    }
                                }
                                
                                $inner .= '<span class="item-amenities-text">'.esc_attr($value).':</span> <span>'.esc_attr($custom_field_value).'</span>';
                            $inner .= '</li>';
                        }
                        $output .= $inner;
                    }
                if($i == 4)
                    break;
                }
            }

            if(houzez_option('disable_type', 1)) {
                $property_type = houzez_taxonomy_simple('property_type');
                if(!empty($property_type)) {
                    $inner .= '<li class="h-type">';
                        $inner .= '<span>'.$property_type.'</span>';
                    $inner .= '</li>';
                }
            }

            $output .= $inner;

        $output .= '</ul>';

        return $output;
    }
}
if(!function_exists( 'houzez_enqueue_marker_clusterer' )) {
    function houzez_enqueue_marker_clusterer() {
        if(houzez_option('map_cluster_enable') != 0) { 
            wp_enqueue_script('googlemap-marker-clusterer', HOUZEZ_JS_DIR_URI. 'vendors/markerclusterer.min.js', array('houzez-google-map-api'), '2.1.1');
            wp_script_add_data( 'googlemap-marker-clusterer', 'async', true );
        }
    }
}

if(!function_exists( 'houzez_enqueue_richmarker' )) {
    function houzez_enqueue_richmarker() {

        if(houzez_option('markerPricePins') == 'yes') {
            wp_enqueue_script('richmarker', HOUZEZ_JS_DIR_URI. 'vendors/richmarker-compiled.js', array('houzez-google-map-api'), HOUZEZ_THEME_VERSION);
            wp_script_add_data( 'richmarker', 'defer', true );
        }
    }
}

if(!function_exists( 'houzez_enqueue_marker_spiderfier' )) {
    function houzez_enqueue_marker_spiderfier() {

        if(houzez_option('marker_spiderfier') != 0) {
            wp_enqueue_script('googlemap-marker-spiderfier', HOUZEZ_JS_DIR_URI. 'vendors/oms.min.js', array('houzez-google-map-api'), '1.12.2');
            wp_script_add_data( 'googlemap-marker-spiderfier', 'async', true );
        }
    }
}

if(!function_exists('houzez_enqueue_google_api')) {
    function houzez_enqueue_google_api() {

        if( !wp_script_is('houzez-google-map-api') ) {
            $googlemap_api_key = houzez_option('googlemap_api_key');
            wp_enqueue_script('houzez-google-map-api', 'https://maps.google.com/maps/api/js?libraries=places&language=' . get_locale() . '&key=' . esc_html($googlemap_api_key), array(), false, false);
            wp_script_add_data( 'houzez-google-map-api', 'defer', true );
             
        }
    }
}

if(!function_exists('houzez_enqueue_geo_location_js')) {
    function houzez_enqueue_geo_location_js() {

        if( !wp_script_is('google-map-properties') ) {
            $map_options = array();
            wp_register_script( 'google-map-properties', get_theme_file_uri('/js/google-map-properties' . houzez_minify_js() . '.js'), array( 'jquery', 'houzez-google-map-api' ), HOUZEZ_THEME_VERSION, true );
            wp_localize_script( 'google-map-properties', 'houzez_map_properties', $map_options );
            wp_enqueue_script( 'google-map-properties' );
            wp_script_add_data( 'google-map-properties', 'async', true );
        }
    }
}

if(!function_exists('houzez_google_maps_scripts')) {
    function houzez_google_maps_scripts() {

        if(houzez_map_needed()) {
            global $post;

            $post_id = isset($post->ID) ? $post->ID : 0;
            $header_type = get_post_meta($post_id, 'fave_header_type', true);
            
            houzez_enqueue_google_api();

            if ( is_singular( 'property' ) ) {

                houzez_enqueue_richmarker();
                houzez_get_single_property_map();

            } elseif($header_type == 'property_map' || is_page_template('template/property-listings-map.php')) {
                houzez_enqueue_marker_clusterer();
                houzez_enqueue_marker_spiderfier();
                houzez_enqueue_richmarker();
                houzez_get_google_map_properties();

            } elseif(is_page_template('template/template-search.php') && houzez_option('search_result_page') == 'half_map') {
                
                houzez_enqueue_marker_clusterer();
                houzez_enqueue_marker_spiderfier();
                houzez_enqueue_richmarker();
                houzez_get_google_map_properties();
            }

            
        } // End Houzez Map Needed
    }
}

if( !function_exists( 'houzez_get_google_map_properties' ) ) {
    
    function houzez_get_google_map_properties() { 

        wp_register_script( 'google-map-properties', get_theme_file_uri('/js/google-map-properties' . houzez_minify_js() . '.js'), array( 'jquery', 'houzez-google-map-api' ), HOUZEZ_THEME_VERSION, true );
        
        $tax_query = array();
        $properties_limit = 1000;
        if( empty( $properties_limit ) ) {
            $properties_limit = -1;
        }
        $wp_query_args = array(
            'post_type' => 'property',
            'posts_per_page' => apply_filters( 'houzez_header_map_properties', $properties_limit ),
            'post_status' => 'publish'
        );

        if(houzez_is_listings_template()) {

            $wp_query_args = apply_filters( 'houzez20_property_filter', $wp_query_args );
            //$wp_query_args['posts_per_page'] = -1;
            $wp_query_args = houzez_prop_sort ( $wp_query_args );

        } elseif(is_page_template(array('template/template-search.php'))) {
            global $paged;

            $wp_query_args = apply_filters( 'houzez20_search_filters', $wp_query_args );
            $wp_query_args = houzez_prop_sort ( $wp_query_args );

            $properties_limit = intval( houzez_option('search_num_posts', 12) );
            if ( $properties_limit <= 0  ) {
                $properties_limit = 12;
            }
            $wp_query_args['posts_per_page'] = $properties_limit;

            $wp_query_args['paged'] = $paged;

            $wp_query_args = houzez_prop_sort ( $wp_query_args );
            

        } elseif( houzez_is_tax() ) {

            global $wp_query, $paged;
            $tax_query[] = array(
                'taxonomy' => $wp_query->query_vars['taxonomy'],
                'field' => 'slug',
                'terms' => $wp_query->query_vars['term']
            );

            $tax_count = count( $tax_query );
            if( $tax_count > 0 ) {
                $wp_query_args['tax_query'] = $tax_query;
            }
            
            $properties_limit = intval( houzez_option('taxonomy_num_posts', 12) );
            if ( $properties_limit <= 0  ) {
                $properties_limit = 12;
            }
            $wp_query_args['posts_per_page'] = $properties_limit;

            $wp_query_args['paged'] = $paged;

            $wp_query_args = houzez_prop_sort ( $wp_query_args );

        } elseif( houzez_get_listing_data('header_type') == 'property_map' ) {

            $cities = houzez_get_listing_data('map_city', false);
            if (!empty($cities)) {
                $tax_query[] = array(
                    'taxonomy' => 'property_city',
                    'field' => 'slug',
                    'terms' => $cities
                );
            }

            $tax_count = count( $tax_query );
            if( $tax_count > 1 ) {
                $tax_query['relation'] = 'AND';
            }
            if( $tax_count > 0 ) {
                $wp_query_args['tax_query'] = $tax_query;
            }

            $wp_query_args = houzez_prop_sort ( $wp_query_args );
        }

        $map_options = array();
        $properties_data = array();
        $prop_map_query = new WP_Query( $wp_query_args );
        
        if ( $prop_map_query->have_posts() ) :
            while ( $prop_map_query->have_posts() ) : $prop_map_query->the_post();

                $property_array_temp = array();

                $property_array_temp[ 'title' ] = get_the_title();
                $property_array_temp[ 'url' ] = get_permalink();
                $property_array_temp['price'] = houzez_listing_price_v5();
                $property_array_temp['property_id'] = get_the_ID();
                $property_array_temp['pricePin'] = houzez_listing_price_map_pins();

                $address = houzez_get_listing_data('property_map_address');
                if(!empty($address)) {
                    $property_array_temp['address'] = $address;
                }

                //Property type
                $property_array_temp['property_type'] = houzez_taxonomy_simple('property_type');

                $property_location = houzez_get_listing_data('property_location');
                if(!empty($property_location)){
                    $lat_lng = explode(',',$property_location);
                    $property_array_temp['lat'] = $lat_lng[0];
                    $property_array_temp['lng'] = $lat_lng[1];
                }

                //Get marker 
                $property_type = get_the_terms( get_the_ID(), 'property_type' );
                if ( $property_type && ! is_wp_error( $property_type ) ) {
                    foreach ( $property_type as $p_type ) {

                        $marker_id = get_term_meta( $p_type->term_id, 'fave_marker_icon', true );
                        $property_array_temp[ 'term_id' ] = $p_type->term_id;

                        if ( ! empty ( $marker_id ) ) {
                            $marker_url = wp_get_attachment_url( $marker_id );

                            if ( $marker_url ) {
                                $property_array_temp[ 'marker' ] = esc_url( $marker_url );

                                $retina_marker_id = get_term_meta( $p_type->term_id, 'fave_marker_retina_icon', true );
                                if ( ! empty ( $retina_marker_id ) ) {
                                    $retina_marker_url = wp_get_attachment_url( $retina_marker_id );
                                    if ( $retina_marker_url ) {
                                        $property_array_temp[ 'retinaMarker' ] = esc_url( $retina_marker_url );
                                    }
                                }
                                break;
                            }
                        }
                    }
                }

                //Se default markers if property type has no marker uploaded
                if ( ! isset( $property_array_temp[ 'marker' ] ) ) {
                    $property_array_temp[ 'marker' ]       = HOUZEZ_IMAGE . 'map/pin-single-family.png';           
                    $property_array_temp[ 'retinaMarker' ] = HOUZEZ_IMAGE . 'map/pin-single-family.png';  
                }

                //Featured image
                if ( has_post_thumbnail() ) {
                    $thumbnail_id         = get_post_thumbnail_id();
                    $thumbnail_array = wp_get_attachment_image_src( $thumbnail_id, 'houzez-item-image-1' );
                    if ( ! empty( $thumbnail_array[ 0 ] ) ) {
                        $property_array_temp[ 'thumbnail' ] = $thumbnail_array[ 0 ];
                    }
                }

                $properties_data[] = $property_array_temp;
            endwhile;
        endif;
        wp_reset_postdata();

        wp_localize_script( 'google-map-properties', 'houzez_map_properties', $properties_data );

        $map_cluster = houzez_option( 'map_cluster', false, 'url' );
        if($map_cluster != '') {
            $map_options['clusterIcon'] = $map_cluster;
        } else {
            $map_options['clusterIcon'] = HOUZEZ_IMAGE . 'map/cluster-icon.png';
        }
        $map_options['map_cluster_enable'] = houzez_option('map_cluster_enable');
        $map_options['clusterer_zoom'] = houzez_option('googlemap_zoom_cluster');
        $map_options['markerPricePins'] = houzez_option('markerPricePins');
        $map_options['marker_spiderfier'] = houzez_option('marker_spiderfier');
        $map_options['map_type'] = houzez_option('houzez_map_type');
        $map_options['googlemap_style'] = houzez_option('googlemap_stype');
        $map_options['closeIcon'] = HOUZEZ_IMAGE . 'map/close.png';
        $map_options['infoWindowPlac'] = HOUZEZ_IMAGE. 'pixel.gif';//houzez_get_image_placeholder_url( 'houzez-item-image-1' );
        wp_localize_script( 'google-map-properties', 'houzez_map_options', $map_options );
        wp_enqueue_script( 'google-map-properties' );
        wp_script_add_data( 'google-map-properties', 'async', true );

    }
}


/*-----------------------------------------------------------------------
* Single Property Map
*----------------------------------------------------------------------*/
if( !function_exists( 'houzez_get_single_property_map' ) ) {
    
    function houzez_get_single_property_map() {

        wp_register_script( 'houzez-single-property-map', get_theme_file_uri('/js/single-property-google-map' . houzez_minify_js() . '.js'), array( 'jquery', 'houzez-google-map-api' ), HOUZEZ_THEME_VERSION, true );
        
        $map_options = array();
        $property_data = array();

        $address  = houzez_get_listing_data('property_map_address');
        $location = houzez_get_listing_data('property_location');
        $show_map = houzez_get_listing_data('property_map');

        if( !empty($location) && $show_map != 0 ) {

            $property_data[ 'title' ] = get_the_title();
            $property_data['price']   = houzez_listing_price_v5();
            $property_data['property_id'] = get_the_ID();
            $property_data['pricePin'] = houzez_listing_price_map_pins();
            $property_data['property_type'] = houzez_taxonomy_simple('property_type');
            $property_data['address'] = $address;

            $lat_lng = explode(',', $location);
            $property_data['lat'] = $lat_lng[0];
            $property_data['lng'] = $lat_lng[1];

            //Get marker 
            $property_type = get_the_terms( get_the_ID(), 'property_type' );
            if ( $property_type && ! is_wp_error( $property_type ) ) {
                foreach ( $property_type as $p_type ) {

                    $marker_id = get_term_meta( $p_type->term_id, 'fave_marker_icon', true );
                    $property_data[ 'term_id' ] = $p_type->term_id;

                    if ( ! empty ( $marker_id ) ) {
                        $marker_url = wp_get_attachment_url( $marker_id );

                        if ( $marker_url ) {
                            $property_data[ 'marker' ] = esc_url( $marker_url );

                            $retina_marker_id = get_term_meta( $p_type->term_id, 'fave_marker_retina_icon', true );
                            if ( ! empty ( $retina_marker_id ) ) {
                                $retina_marker_url = wp_get_attachment_url( $retina_marker_id );
                                if ( $retina_marker_url ) {
                                    $property_data[ 'retinaMarker' ] = esc_url( $retina_marker_url );
                                }
                            }
                            break;
                        }
                    }
                }
            }

            //Se default markers if property type has no marker uploaded
            if ( ! isset( $property_data[ 'marker' ] ) ) {
                $property_data[ 'marker' ]       = HOUZEZ_IMAGE . 'map/pin-single-family.png';           
                $property_data[ 'retinaMarker' ] = HOUZEZ_IMAGE . 'map/pin-single-family.png';  
            }

            //Featured image
            if ( has_post_thumbnail() ) {
                $thumbnail_id         = get_post_thumbnail_id();
                $thumbnail_array = wp_get_attachment_image_src( $thumbnail_id, 'houzez-item-image-1' );
                if ( ! empty( $thumbnail_array[ 0 ] ) ) {
                    $property_data[ 'thumbnail' ] = $thumbnail_array[ 0 ];
                }
            }
        }

        $map_options['markerPricePins'] = houzez_option('markerPricePins');
        $map_options['single_map_zoom'] = houzez_option('single_mapzoom', 15);
        $map_options['map_type'] = houzez_option('houzez_map_type');
        $map_options['map_pin_type'] = houzez_option('detail_map_pin_type', 'marker');
        $map_options['googlemap_stype'] = houzez_option('googlemap_stype');
        $map_options['closeIcon'] = HOUZEZ_IMAGE . 'map/close.png';
        $map_options['show_map'] = $show_map;
        $map_options['infoWindowPlac'] = HOUZEZ_IMAGE. 'pixel.gif';//houzez_get_image_placeholder_url( 'houzez-item-image-1' );

        wp_localize_script( 'houzez-single-property-map', 'houzez_single_property_map', $property_data );
        wp_localize_script( 'houzez-single-property-map', 'houzez_map_options', $map_options );
        wp_enqueue_script( 'houzez-single-property-map' );

    }
}
