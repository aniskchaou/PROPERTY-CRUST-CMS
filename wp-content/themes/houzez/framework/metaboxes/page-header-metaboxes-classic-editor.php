<?php
if( !function_exists('houzez_page_header_metaboxes') ) {

    function houzez_page_header_metaboxes( $meta_boxes ) {
        $houzez_prefix = 'fave_';
        
        $prop_locations = array();

        houzez_get_terms_array( 'property_city', $prop_locations );
        

        $meta_boxes[] = array(
            'id'        => 'fave_page_settings',
            'title'     => esc_html__('Page Header Options', 'houzez' ),
            'post_types'     => array( 'page' ),
            'context' => 'normal',
            'hide'       => array(
                'template' => array(
                    'template/template-splash.php',
                    'template/property-listings-map.php',
                    'template/user_dashboard_submit.php',
                    'template/template-compare.php',
                    'template/template-thankyou.php',
                    'template/template-packages.php',
                    'template/template-payment.php',
                    'template/template-stripe-charge.php',
                    'template/user_dashboard_crm.php',
                    'template/user_dashboard_favorites.php',
                    'template/user_dashboard_insight.php',
                    'template/user_dashboard_invoices.php',
                    'template/user_dashboard_membership.php',
                    'template/user_dashboard_messages.php',
                    'template/user_dashboard_profile.php',
                    'template/user_dashboard_properties.php',
                    'template/user_dashboard_saved_search.php',
                ),
            ),

            'fields'    => array(
                array(
                    'name'      => esc_html__('Header Type', 'houzez' ),
                    'id'        => $houzez_prefix . 'header_type',
                    'type'      => 'select',
                    'options'   => array(
                        'none' => esc_html__('None', 'houzez' ),
                        'property_slider' => esc_html__('Properties Slider', 'houzez' ),
                        'rev_slider' => esc_html__('Revolution Slider', 'houzez' ),
                        'property_map' => esc_html__('Properties Map', 'houzez' ),
                        'static_image' => esc_html__('Image', 'houzez' ),
                        'video' => esc_html__('Video', 'houzez' ),
                        'elementor' => esc_html__('Elementor', 'houzez' ),
                    ),
                    'std'       => array( 'none' ),
                    'desc'      => esc_html__('Select the page header type','houzez')
                ),
                array(
                    'name'      => esc_html__('Title', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_title',
                    'placeholder' => esc_html__( 'Enter the title', 'houzez' ),
                    'type' => 'text',
                    'std' => '',
                    'desc' => '',
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),
                array(
                    'name'      => esc_html__('Subtitle', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_subtitle',
                    'placeholder' => esc_html__( 'Enter the subtitle', 'houzez' ),
                    'type' => 'text',
                    'std' => '',
                    'desc' => '',
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),
                array(
                    'name'      => esc_html__('Image', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_image',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                    'desc'      => '',
                    'visible' => array( $houzez_prefix.'header_type', '=', 'static_image' )
                ),

                array(
                    'name' => esc_html__('MP4 File', 'houzez'),
                    'id' => "{$houzez_prefix}page_header_bg_mp4",
                    'placeholder' => esc_html__( 'Upload the video file', 'houzez' ),
                    'desc' => esc_html__( 'This file is mandatory', 'houzez' ),
                    'type' => 'file_input',
                    'visible' => array( $houzez_prefix.'header_type', '=', 'video' )
                ),
                array(
                    'name' => esc_html__('WEBM File', 'houzez'),
                    'id' => "{$houzez_prefix}page_header_bg_webm",
                    'placeholder' => esc_html__( 'Upload the video file', 'houzez' ),
                    'desc' => esc_html__( 'This file is mandatory', 'houzez' ),
                    'type' => 'file_input',
                    'visible' => array( $houzez_prefix.'header_type', '=', 'video' )
                ),
                array(
                    'name' => esc_html__('OGV File', 'houzez'),
                    'id' => "{$houzez_prefix}page_header_bg_ogv",
                    'placeholder' => esc_html__( 'Upload the video file', 'houzez' ),
                    'desc' => esc_html__( 'This file is mandatory', 'houzez' ),
                    'type' => 'file_input',
                    'visible' => array( $houzez_prefix.'header_type', '=', 'video' )
                ),

                array(
                    'name'      => esc_html__('Video Image', 'houzez'),
                    'id'        => $houzez_prefix . 'page_header_video_img',
                    'placeholder' => esc_html__( 'Upload a video cover image', 'houzez' ),
                    'desc' => esc_html__( 'This file is mandatory', 'houzez' ),
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                    'visible' => array( $houzez_prefix.'header_type', '=', 'video' )
                ),

                array(
                    'name'      => esc_html__('Height', 'houzez' ),
                    'placeholder' => esc_html__( 'Enter the banner height', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_image_height',
                    'type' => 'text',
                    'std' => '',
                    'desc' => esc_html__('Default is 600px', 'houzez'),
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),

                array(
                    'name'      => esc_html__('Height Mobile', 'houzez' ),
                    'placeholder' => esc_html__( 'Enter the banner height for mobile devices', 'houzez' ),
                    'id'        => $houzez_prefix . 'header_image_height_mobile',
                    'type' => 'text',
                    'std' => '',
                    'desc' => esc_html__('Default is 400px', 'houzez'),
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),

                array(
                    'name'      => esc_html__('Overlay Color Opacity', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_image_opacity',
                    'type' => 'select',
                    'options' => array(
                        '0' => '0',
                        '0.1' => '1',
                        '0.2' => '2',
                        '0.3' => '3',
                        '0.35' => '3.5',
                        '0.4' => '4',
                        '0.5' => '5',
                        '0.6' => '6',
                        '0.7' => '7',
                        '0.8' => '8',
                        '0.9' => '9',
                        '1' => '10',
                    ),
                    'std'       => array( '0.35' ),
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),

                array(
                    'name'      => esc_html__('Banner Search', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_search',
                    'type' => 'switch',
                    'style'     => 'rounded',
                    'on_label'  => esc_html__('Enable', 'houzez' ),
                    'off_label' => esc_html__('Disable', 'houzez' ),
                    'std'       => 0,
                    'desc' => '',
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),
                
                array(
                    'name'      => esc_html__('Full Screen', 'houzez' ),
                    'id'        => $houzez_prefix . 'header_full_screen',
                    'type' => 'switch',
                    'style'     => 'rounded',
                    'on_label'  => esc_html__('Enable', 'houzez' ),
                    'off_label' => esc_html__('Disable', 'houzez' ),
                    'std'       => 0,
                    'desc'      => esc_html__('If "Enable" it will fit according to screen size' ,'houzez'),
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video', 'property_map', 'property_slider' ) )
                ),
        
                /*------------------ Slider Revolution -------------*/
                array(
                    'name'      => esc_html__('Revolution Slider', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_revslider',
                    'type' => 'select_advanced',
                    'std' => '',
                    'options' => houzez_get_revolution_slider(),
                    'multiple'    => false,
                    'placeholder' => esc_html__( 'Select an Slider', 'houzez' ),
                    'desc' => '',
                    'hidden' => array( $houzez_prefix.'header_type', '!=', 'rev_slider' )
                ),

                /*----------------- Map Settings ----------------*/
                array(
                    'name'      => esc_html__('Select City', 'houzez'),
                    'id'        => $houzez_prefix . 'map_city',
                    'type'      => 'select',
                    'options'   => $prop_locations,
                    'desc'      => esc_html__('Select a city where to start the property map on header page. You can select multiple cities or keep all un-select to display properties from all the cities', 'houzez'),
                    'multiple' => true,
                    'class' => 'houzez-map-cities',
                    'hidden' => array( 'fave_header_type', '!=', 'property_map' )
                ),
            )
        );

        return apply_filters('houzez_page_header_meta', $meta_boxes);

    }

    add_filter( 'rwmb_meta_boxes', 'houzez_page_header_metaboxes' );
}