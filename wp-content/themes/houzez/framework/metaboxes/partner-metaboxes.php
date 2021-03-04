<?php
if( !function_exists('houzez_partner_metaboxes') ) {

    function houzez_partner_metaboxes( $meta_boxes ) {
        $houzez_prefix = 'fave_';
        
        $meta_boxes[] = array(
            'id'        => 'fave_partners',
            'title'     => esc_html__('Partner Details', 'houzez'),
            'post_types'     => array( 'houzez_partner' ),
            'context' => 'normal',

            'fields'    => array(
                array(
                    'name'      => esc_html__('Partner website address', 'houzez'),
                    'placeholder'      => esc_html__('Enter the website address','houzez'),
                    'id'        => $houzez_prefix . 'partner_website',
                    'type'      => 'url',
                    'desc'      => esc_html__('Example: https://houzez.co/','houzez'),
                )
            )
        );

        return apply_filters('houzez_partner_meta', $meta_boxes);

    }

    add_filter( 'rwmb_meta_boxes', 'houzez_partner_metaboxes' );
}