<?php
if( !function_exists('houzez_packages_metaboxes') ) {

    function houzez_packages_metaboxes( $meta_boxes ) {
        $houzez_prefix = 'fave_';
        
        $meta_boxes[] = array(
            'title'  => esc_html__( 'Package Details', 'houzez' ),
            'post_types'  => array('houzez_packages'),
            'fields' => array(
                array(
                    'id' => "{$houzez_prefix}billing_time_unit",
                    'name' => esc_html__( 'Billing Period', 'houzez' ),
                    'type' => 'select',
                    'std' => "",
                    'options' => array( 'Day' => esc_html__('Day', 'houzez' ), 'Week' => esc_html__('Week', 'houzez' ), 'Month' => esc_html__('Month', 'houzez' ), 'Year' => esc_html__('Year', 'houzez' ) ),
                    'columns' => 6,
                ),
                array(
                    'id' => "{$houzez_prefix}billing_unit",
                    'name' => esc_html__( 'Billing Frequency', 'houzez' ),
                    'placeholder' => esc_html__( 'Enter the frequency number', 'houzez' ),
                    'type' => 'text',
                    'std' => "0",
                    'columns' => 6,
                ),
                array(
                    'id' => "{$houzez_prefix}package_listings",
                    'name' => esc_html__( 'How many listings are included?', 'houzez' ),
                    'placeholder' => esc_html__( 'Enter the number of listings', 'houzez' ),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,

                ),
                array(
                    'id' => "{$houzez_prefix}unlimited_listings",
                    'name' => esc_html__( "Unlimited listings", 'houzez' ),
                    'type' => 'checkbox',
                    'desc' => esc_html__('Unlimited listings', 'houzez'),
                    'std' => "",
                    'columns' => 6,
                ),
                array(
                    'id' => "{$houzez_prefix}package_featured_listings",
                    'name' => esc_html__( 'How many Featured listings are included?', 'houzez' ),
                    'placeholder' => esc_html__( 'Enter the number of listings', 'houzez' ),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                ),
                array(
                    'id' => "{$houzez_prefix}package_price",
                    'name' => esc_html__( 'Package Price ', 'houzez' ),
                    'placeholder' => esc_html__( 'Enter the price', 'houzez' ),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                ),
                array(
                    'id' => "{$houzez_prefix}package_stripe_id",
                    'name' => esc_html__( 'Package Stripe id (Example: gold_pack)', 'houzez' ),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                ),
                array(
                    'id' => "{$houzez_prefix}package_visible",
                    'name' => esc_html__( 'Is It Visible?', 'houzez' ),
                    'type' => 'select',
                    'std' => "",
                    'options' => array( 'yes' => esc_html__( 'Yes', 'houzez' ), 'no' => esc_html__( 'No', 'houzez' ) ),
                    'columns' => 6,
                ),

                array(
                    'id' => "{$houzez_prefix}package_images",
                    'name' => esc_html__( 'How many images are included per listing?', 'houzez' ),
                    'placeholder' => esc_html__( 'Enter the number of images', 'houzez' ),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,

                ),
                array(
                    'id' => "{$houzez_prefix}unlimited_images",
                    'name' => esc_html__( "Unlimited Images", 'houzez' ),
                    'type' => 'checkbox',
                    'desc' => esc_html__('Same as defined in Theme Options', 'houzez'),
                    'std' => "",
                    'columns' => 6,
                ),
                array(
                    'id' => "{$houzez_prefix}package_tax",
                    'name' => esc_html__( 'Taxes', 'houzez' ),
                    'placeholder' => esc_html__( 'Enter the tax percentage (Only digits)', 'houzez' ),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,

                ),
                array(
                    'id' => "{$houzez_prefix}package_popular",
                    'name' => esc_html__( 'Is Popular/Featured?', 'houzez' ),
                    'type' => 'select',
                    'std' => "no",
                    'options' => array( 'no' => esc_html__( 'No', 'houzez' ), 'yes' => esc_html__( 'Yes', 'houzez' ) ),
                    'columns' => 6,
                ),
                array(
                    'id' => "{$houzez_prefix}package_custom_link",
                    'name' => esc_html__( 'Custom Link', 'houzez' ),
                    'desc' => esc_html__('Leave empty if you do not want to custom link.', 'houzez'),
                    'placeholder' => esc_html__( 'Enter the custom link', 'houzez' ),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 12,

                ),
            ),
        );
        

        return apply_filters('houzez_packages_meta', $meta_boxes);

    }

    add_filter( 'rwmb_meta_boxes', 'houzez_packages_metaboxes' );
}