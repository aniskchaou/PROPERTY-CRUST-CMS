<?php
global $houzez_opt_name, $allowed_html_array;

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Half Map', 'houzez' ),
    'id'     => 'halfmap-settings',
    'desc'   => esc_html__( 'Half Map Listings Template', 'houzez' ),
    'icon'   => 'el-icon-globe el-icon-small',
    'subsection' => false,
    'fields' => array(
        
        array(
            'id'       => 'halfmap_posts_layout',
            'type'     => 'select',
            'title'    => __('Properties Layout', 'houzez'),
            'desc' => __('Select property layout to display on the half map page.', 'houzez'),
            'options'  => array(
                'Listings Version 1' => array(
                    'list-view-v1' => 'List View',
                    'grid-view-v1' => 'Grid View',
                ),
                'Listings Version 2' => array(
                    'list-view-v2' => 'List View',
                    'grid-view-v2' => 'Grid View',
                ),
                'grid-view-v3' => 'Grid View v3',
                'Listings Version 5' => array(
                    'list-view-v5' => 'List View',
                    'grid-view-v5' => 'Grid View',
                ),
                'grid-view-v6' => 'Grid View v6',
            ),
            'default' => 'list-view-v1'
        ),
    )
));