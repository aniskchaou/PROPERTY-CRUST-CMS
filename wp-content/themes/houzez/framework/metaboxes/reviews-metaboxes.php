<?php
if( !function_exists('houzez_reviews_metaboxes') ) {

    function houzez_reviews_metaboxes( $meta_boxes ) {
        $houzez_prefix = 'fave_';
        
        $meta_boxes[] = array(
            'id'        => 'houzez_reviews',
            'title'     => esc_html__('Details', 'houzez'),
            'post_types'     => array( 'houzez_reviews' ),
            'context' => 'normal',

            'fields'    => array(
                array(
                    'name'    => esc_html__('Where to display?', 'houzez'),
                    'id'      => 'review_post_type',
                    'type'    => 'radio',
                    'options' => array(
                        'property' => esc_html__('Property Detail Page', 'houzez'),
                        'houzez_agent' => esc_html__('Agent Profile', 'houzez'),
                        'houzez_agency' => esc_html__('Agency Profile', 'houzez'),
                    ),
                ),

                array(
                    'name'        => esc_html__('Select a property', 'houzez'),
                    'id'        => 'review_property_id',
                    'type'        => 'post',
                    'post_type'   => 'property',
                    'field_type'  => 'select_advanced',
                    'placeholder' => esc_html__('Select a Property', 'houzez'),
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                    ),
                    'hidden' => array( 'review_post_type', '!=', 'property' )
                ),

                array(
                    'name'        => esc_html__('Select an Agent', 'houzez'),
                    'id'          => 'review_agent_id',
                    'type'        => 'post',
                    'post_type'   => 'houzez_agent',
                    'field_type'  => 'select_advanced',
                    'placeholder' => esc_html__('Select an Agent', 'houzez'),
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                    ),
                    'hidden' => array( 'review_post_type', '!=', 'houzez_agent' )
                ),

                array(
                    'name'        => esc_html__('Select an Agency', 'houzez'),
                    'id'          => 'review_agency_id',
                    'type'        => 'post',
                    'post_type'   => 'houzez_agency',
                    'field_type'  => 'select_advanced',
                    'placeholder' => esc_html__('Select an Agency', 'houzez'),
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                    ),
                    'hidden' => array( 'review_post_type', '!=', 'houzez_agency' )
                ),

                array(
                    'name'            => esc_html__('Rating', 'houzez'),
                    'id'              => 'review_stars',
                    'type'            => 'select',
                    'options' => array(
                        '1' => esc_html__('1 Star - Poor', 'houzez'),
                        '2' => esc_html__('2 Star -  Fair', 'houzez'),
                        '3' => esc_html__('3 Star - Average', 'houzez'),
                        '4' => esc_html__('4 Star - Good', 'houzez'),
                        '5' => esc_html__('5 Star - Excellent', 'houzez'),
                    ),
                    'std'        => '1',
                ),
            )
        );
        

        return apply_filters('houzez_reviews_meta', $meta_boxes);

    }

    add_filter( 'rwmb_meta_boxes', 'houzez_reviews_metaboxes' );
}