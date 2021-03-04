<?php
if( !function_exists('houzez_testimonials_metaboxes') ) {

    function houzez_testimonials_metaboxes( $meta_boxes ) {
        $houzez_prefix = 'fave_';
        
        $meta_boxes[] = array(
            'id'        => 'fave_testimonials',
            'title'     => esc_html__('Testimonial Details', 'houzez' ),
            'post_types'     => array( 'houzez_testimonials' ),
            'context' => 'normal',

            'fields'    => array(
                array(
                    'name'      => esc_html__('Text', 'houzez' ),
                    'id'        => $houzez_prefix . 'testi_text',
                    'type'      => 'textarea',
                    'desc'      => esc_html__('Enter the testimonial message','houzez'),
                ),
                array(
                    'name'      => esc_html__('Name', 'houzez'),
                    'id'        => $houzez_prefix . 'testi_name',
                    'type'      => 'text',
                    'placeholder'      => esc_html__('Enter the testimonial name','houzez'),
                ),
                array(
                    'name'      => esc_html__('Position', 'houzez'),
                    'id'        => $houzez_prefix . 'testi_position',
                    'type'      => 'text',
                    'placeholder'      => esc_html__('Example: Founder & CEO.','houzez'),
                ),
                array(
                    'name'      => esc_html__('Company Name', 'houzez'),
                    'placeholder'      => esc_html__('Enter the company name','houzez'),
                    'id'        => $houzez_prefix . 'testi_company',
                    'type'      => 'text',
                    'desc'      => '',
                ),
                array(
                    'name'      => esc_html__('Photo', 'houzez'),
                    'id'        => $houzez_prefix . 'testi_photo',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                    'desc'      => '',
                ),
                array(
                    'name'      => esc_html__('Company Logo', 'houzez'),
                    'id'        => $houzez_prefix . 'testi_logo',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                    'desc'      => '',
                )
            )
        );
        

        return apply_filters('houzez_testimonials_meta', $meta_boxes);

    }

    add_filter( 'rwmb_meta_boxes', 'houzez_testimonials_metaboxes' );
}