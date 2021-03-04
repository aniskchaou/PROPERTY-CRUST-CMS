<?php
global $houzez_opt_name;

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Taxonomies Layout', 'houzez' ),
    'id'     => 'taxonomies-pages',
    'desc'   => esc_html__( 'Select taxonomies (type, status, country, city, state, features, areas, labels) pages layout', 'houzez' ),
    'icon'   => 'el-icon-th-list el-icon-small',
    'subsection' => false,
    'fields' => array(
        array(
            'id'       => 'taxonomy_layout',
            'type'     => 'image_select',
            'title'    => __('Page Layout', 'houzez'),
            'subtitle' => '',
            'options'  => array(
                'no-sidebar' => array(
                    'alt'   => '',
                    'img'   => HOUZEZ_IMAGE. '1c.png'
                ),
                'left-sidebar' => array(
                    'alt'   => '',
                    'img'   => HOUZEZ_IMAGE. '2cl.png'
                ),
                'right-sidebar' => array(
                    'alt'   => '',
                    'img'  => HOUZEZ_IMAGE. '2cr.png'
                )
            ),
            'default' => 'right-sidebar'
        ),
        array(
            'id'       => 'taxonomy_content_position',
            'type'     => 'select',
            'title'    => __('Content Position', 'houzez'),
            'desc' => __('Select content position for taxonomies pages. Content can be added in desciption field for each taxonomy', 'houzez'),
            'options'  => array(
                'above' => esc_html__('Above listings', 'houzez'),
                'bottom' => esc_html__('Below listings', 'houzez'),
            ),
            'default' => 'above'
        ),
        /*array(
            'id'       => 'tax_show_map',
            'type'     => 'switch',
            'title'    => esc_html__( 'Show Map', 'houzez' ),
            'desc' => esc_html__( 'Show the map on top of taxonomy pages', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),*/

        array(
            'id'       => 'taxonomy_posts_layout',
            'type'     => 'select',
            'title'    => __('Listings Layout', 'houzez'),
            'desc' => __('Select the listings layout for the taxonomy page.', 'houzez'),
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
                'grid-view-v4' => 'Grid View v4',
                'Listings Version 5' => array(
                    'list-view-v5' => 'List View',
                    'grid-view-v5' => 'Grid View',
                ),
                'grid-view-v6' => 'Grid View v6',
            ),
            'default' => 'list-view-v1'
        ),

        array(
            'id'       => 'taxonomy_default_order',
            'type'     => 'select',
            'title'    => __('Default Order', 'houzez'),
            'desc' => esc_html__('Select the taxonomy page listings order.', 'houzez'),
            'options'  => array(
                'd_date' => esc_html__( 'Date New to Old', 'houzez' ),
                'a_date' => esc_html__( 'Date Old to New', 'houzez' ),
                'd_price' => esc_html__( 'Price (High to Low)', 'houzez' ),
                'a_price' => esc_html__( 'Price (Low to High)', 'houzez' ),
                'featured_first' => esc_html__( 'Show Featured Listings on Top', 'houzez' ),
            ),
            'default' => 'd_date'
        ),

        array(
            'id'       => 'taxonomy_num_posts',
            'type'     => 'text',
            'title'    => esc_html__('Number of Listings to Show', 'houzez'),
            'subtitle' => '',
            'desc' => esc_html__('Enter the number of listings to display.', 'houzez'),
            'default'  => '9',
            'validate' => 'numeric',
        ),
    )
));