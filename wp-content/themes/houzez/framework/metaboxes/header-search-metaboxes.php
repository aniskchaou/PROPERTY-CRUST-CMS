<?php
if( !function_exists('houzez_header_search_metaboxes') ) {

    function houzez_header_search_metaboxes( $meta_boxes ) {
        $houzez_prefix = 'fave_';
        
        $meta_boxes[] = array(
            'id' => 'fave_advanced_search',
            'title' => esc_html__('Advanced Search', 'houzez' ),
            'pages' => array( 'page' ),
            'context' => 'side',
            'priority' => 'high',

            'fields' => array(

                array(
                    'name' => esc_html__('Advanced Search', 'houzez'),
                    'desc' => '',
                    'id' => $houzez_prefix . 'adv_search_enable',
                    'type' => 'select',
                    'options' => array(
                        'global' => esc_html__('Global ( As theme options settings )', 'houzez'),
                        'current_page' => esc_html__('Custom Settings for this Page', 'houzez')
                    ),
                    'std'   => array( 'global' ),
                    'desc'  => ''
                ),
                array(
                    'name' => esc_html__('Search Options ', 'houzez'),
                    'desc' => '',
                    'id' => $houzez_prefix . 'adv_search',
                    'type' => 'select',
                    'options' => array(
                        'hide' => esc_html__('Hide on this page', 'houzez'),
                        'show' => esc_html__('Show on this page', 'houzez'),
                        'hide_show' => esc_html__('Hide but show on scroll', 'houzez'),
                    ),
                    'std'   => array( 'hide' ),
                    'hidden' => array( 'fave_adv_search_enable', '!=', 'current_page' ),
                ),
                array(
                    'name' => esc_html__('Search Position ', 'houzez'),
                    'desc' => '',
                    'id' => $houzez_prefix . 'adv_search_pos',
                    'type' => 'select',
                    'options' => array(
                        'under_menu' => esc_html__('Under Navigation', 'houzez'),
                        'under_banner' => esc_html__('Under Banners (Sliders, Map, Video, etc)', 'houzez')
                    ),
                    'std'   => array( 'under_menu' ),
                    'hidden' => array( 'fave_adv_search_enable', '!=', 'current_page' ),
                )
            )
        );

        return apply_filters('houzez_header_search_meta', $meta_boxes);

    }

    add_filter( 'rwmb_meta_boxes', 'houzez_header_search_metaboxes' );
}