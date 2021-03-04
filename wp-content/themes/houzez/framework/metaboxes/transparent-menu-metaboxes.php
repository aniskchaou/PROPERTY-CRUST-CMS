<?php
if( !function_exists('houzez_transparent_menu_metaboxes') ) {

    function houzez_transparent_menu_metaboxes( $meta_boxes ) {
        $houzez_prefix = 'fave_';
        
        $meta_boxes[] = array(
            'id'        => 'fave_menu_settings',
            'title'     => esc_html__('Page Navigation Options', 'houzez' ),
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
                    'name'      => esc_html__('Main Menu Transparent?', 'houzez'),
                    'id'        => $houzez_prefix . 'main_menu_trans',
                    'type'      => 'select',
                    'options'   => array(
                        'no' => esc_html__('No', 'houzez' ),
                        'yes' => esc_html__('Yes', 'houzez' )
                    ),
                    'std'       => array( 'no' ),
                    'desc'      => esc_html__('This option only works if you are using the header 4. You can choose the header 4 from theme options','houzez')
                ),
            )
        );

        return apply_filters('houzez_transparent_menu_meta', $meta_boxes);

    }

    add_filter( 'rwmb_meta_boxes', 'houzez_transparent_menu_metaboxes' );
}