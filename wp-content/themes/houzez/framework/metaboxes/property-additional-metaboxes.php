<?php
if( !function_exists('houzez_property_additional_metaboxes') ) {

    function houzez_property_additional_metaboxes( $meta_boxes ) {
        $houzez_prefix = 'fave_';
        
        $meta_boxes[] = array(
            'title' => esc_html__('Additional Features', 'houzez'),
            'post_types' => array( 'property' ),
            'fields' => array(
                
                array(
                    'id' => 'additional_features',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        array(
                            'name' => esc_html__('Title', 'houzez'),
                            'id' => "{$houzez_prefix}additional_feature_title",
                            'placeholder' => esc_html__('Enter the title', 'houzez'),
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => esc_html__('Value', 'houzez'),
                            'id' => "{$houzez_prefix}additional_feature_value",
                            'placeholder' => esc_html__('Enter the value', 'houzez'),
                            'type' => 'text',
                            'columns' => 6,
                        )
                    ),
                ),
            ),
        );

        return $meta_boxes;

    }

    add_filter( 'rwmb_meta_boxes', 'houzez_property_additional_metaboxes' );
}