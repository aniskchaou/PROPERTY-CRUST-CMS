<?php
if( !function_exists('houzez_listings_templates_metaboxes') ) {

    function houzez_listings_templates_metaboxes( $meta_boxes ) {
        $houzez_prefix = 'fave_';

        $page_filters = houzez_option('houzez_page_filters');

        $agents_for_templates = array_slice( houzez_get_agents_array(), 1, null, true );

        $prop_states = array();
        $prop_locations = array();
        $prop_types = array();
        $prop_status = array();
        $prop_features = array();
        $prop_neighborhood = array();
        $prop_label = array();

        
        houzez_get_terms_array( 'property_feature', $prop_features );
        houzez_get_terms_array( 'property_status', $prop_status );
        houzez_get_terms_array( 'property_type', $prop_types );
        houzez_get_terms_array( 'property_city', $prop_locations );
        houzez_get_terms_array( 'property_state', $prop_states );
        houzez_get_terms_array( 'property_label', $prop_label );
        houzez_get_terms_array( 'property_area', $prop_neighborhood );
        
        
        $meta_boxes[] = array(
            'id'        => 'fave_page_content_area',
            'title'     => esc_html__('Content Area', 'houzez'),
            'post_types'     => array( 'page' ),
            'context'    => 'normal',
            //'priority'   => 'normal',
            'show'       => array(
                'template' => array(
                    'template/template-listing-list-v1.php',
                    'template/template-listing-list-v1-fullwidth.php',
                    'template/template-listing-list-v2.php',
                    'template/template-listing-list-v2-fullwidth.php',
                    'template/template-listing-list-v5.php',
                    'template/template-listing-list-v5-fullwidth.php',
                    'template/template-listing-grid-v1.php',
                    'template/template-listing-grid-v1-fullwidth-2cols.php',
                    'template/template-listing-grid-v1-fullwidth-3cols.php',
                    'template/template-listing-grid-v1-fullwidth-4cols.php',
                    'template/template-listing-grid-v2.php',
                    'template/template-listing-grid-v2-fullwidth-2cols.php',
                    'template/template-listing-grid-v2-fullwidth-3cols.php',
                    'template/template-listing-grid-v2-fullwidth-4cols.php',
                    'template/template-listing-grid-v4.php',
                    'template/template-listing-grid-v5.php',
                    'template/template-listing-grid-v5-fullwidth-2cols.php',
                    'template/template-listing-grid-v5-fullwidth-3cols.php',
                    'template/template-listing-grid-v6.php',
                    'template/template-listing-grid-v6-fullwidth-2cols.php',
                    'template/template-listing-grid-v6-fullwidth-3cols.php',
                    'template/template-listing-grid-v3.php',
                    'template/template-listing-grid-v3-fullwidth-2cols.php',
                    'template/template-listing-grid-v3-fullwidth-3cols.php',
                    'template/properties-parallax.php',
                    'template/template-agents.php',
                    'template/template-agencies.php',
                    'template/template-compare.php',
                    'template/template-search.php',
                    'template/property-listings-map.php'
                ),
            ),
            'fields'    => array(
                array(
                    'id' => $houzez_prefix."listing_page_content_area",
                    'name' => esc_html__('Show Content Above Footer?', 'houzez'),
                    'desc' => esc_html__( 'Yes', 'houzez' ),
                    'type' => 'checkbox',
                    'std' => 0,
                ),
            )
        );


        $property_area_filter = array(
            'id'   => 'field_id_area',
            'type' => 'divider',
            'class' => 'houzez_hidden',
            'columns' => 6,
        );
        if( !in_array('property_area', (array)$page_filters) ) {
            $property_area_filter = array(
                    'name'      => esc_html__('Areas', 'houzez'),
                    'id'        => $houzez_prefix . 'area',
                    'type'      => 'select',
                    'options'   => $prop_neighborhood,
                    'desc'      => '',
                    'columns' => 6,
                    'select_all_none' => true,
                    'multiple' => true
                );
        }

        $property_type_filter = array(
            'id'   => 'field_id_type',
            'type' => 'divider',
            'class' => 'houzez_hidden',
            'columns' => 6,
        );
        if( !in_array('property_type', (array)$page_filters) ) {
            $property_type_filter = array(
                    'name'      => esc_html__('Types', 'houzez'),
                    'id'        => $houzez_prefix . 'types',
                    'type'      => 'select',
                    'options'   => $prop_types,
                    'desc'      => '',
                    'columns' => 6,
                    'select_all_none' => true,
                    'multiple' => true
                );
        }

        $property_status_filter = array(
            'id'   => 'field_id_statuses',
            'type' => 'divider',
            'class' => 'houzez_hidden',
            'columns' => 6,
        );
        if( !in_array('property_status', (array)$page_filters) ) {
            $property_status_filter = array(
                    'name'      => esc_html__('Status', 'houzez' ),
                    'id'        => $houzez_prefix . 'status',
                    'type'      => 'select',
                    'options'   => $prop_status,
                    'desc'      => '',
                    'columns' => 6,
                    'select_all_none' => true,
                    'multiple' => true
                );
        }

        $property_label_filter = array(
            'id'   => 'field_id_label',
            'type' => 'divider',
            'class' => 'houzez_hidden',
            'columns' => 6,
        );
        if( !in_array('property_label', (array)$page_filters) ) {
            $property_label_filter = array(
                    'name'      => esc_html__('Labels', 'houzez'),
                    'id'        => $houzez_prefix . 'labels',
                    'type'      => 'select',
                    'options'   => $prop_label,
                    'desc'      => '',
                    'columns' => 6,
                    'select_all_none' => true,
                    'multiple' => true
                );
        }

        $property_state_filter = array(
            'id'   => 'field_id_state',
            'type' => 'divider',
            'class' => 'houzez_hidden',
            'columns' => 6,
        );
        if( !in_array('property_state', (array)$page_filters) ) {
            $property_state_filter = array(
                    'name'      => esc_html__('States', 'houzez'),
                    'id'        => $houzez_prefix . 'states',
                    'type'      => 'select',
                    'options'   => $prop_states,
                    'desc'      => '',
                    'columns' => 6,
                    'select_all_none' => true,
                    'multiple' => true
                );
        }

        $property_city_filter = array(
            'id'   => 'field_id_city',
            'type' => 'divider',
            'class' => 'houzez_hidden',
            'columns' => 6,
        );
        if( !in_array('property_city', (array)$page_filters) ) {
            $property_city_filter = array(
                    'name'      => esc_html__('Cities', 'houzez'),
                    'id'        => $houzez_prefix . 'locations',
                    'type'      => 'select',
                    'options'   => $prop_locations,
                    'desc'      => '',
                    'columns' => 6,
                    'select_all_none' => true,
                    'multiple' => true
                );
        }

        $property_feature_filter = array(
            'id'   => 'field_id_feature',
            'type' => 'divider',
            'class' => 'houzez_hidden',
            'columns' => 6,
        );
        if( !in_array('property_feature', (array)$page_filters) ) {
            $property_feature_filter = array(
                    'name'      => esc_html__('Features', 'houzez' ),
                    'id'        => $houzez_prefix . 'features',
                    'type'      => 'select',
                    'options'   => $prop_features,
                    'desc'      => '',
                    'columns' => 6,
                    'select_all_none' => true,
                    'multiple' => true
                );
        }

        /*------------------------------------------------------------------------
        * Listings templates
        *-----------------------------------------------------------------------*/
        $meta_boxes[] = array(
            'id'        => 'fave_listing_template',
            'title'     => esc_html__('Listings Template Settings', 'houzez'),
            'post_types'     => array( 'page' ),
            'context'    => 'normal',
            'priority'   => 'high',
            'show'       => array(
                'template' => array(
                    'template/template-listing-list-v1.php',
                    'template/template-listing-list-v1-fullwidth.php',
                    'template/template-listing-list-v2.php',
                    'template/template-listing-list-v2-fullwidth.php',
                    'template/template-listing-list-v5.php',
                    'template/template-listing-list-v5-fullwidth.php',
                    'template/template-listing-grid-v1.php',
                    'template/template-listing-grid-v1-fullwidth-2cols.php',
                    'template/template-listing-grid-v1-fullwidth-3cols.php',
                    'template/template-listing-grid-v1-fullwidth-4cols.php',
                    'template/template-listing-grid-v2.php',
                    'template/template-listing-grid-v2-fullwidth-2cols.php',
                    'template/template-listing-grid-v2-fullwidth-3cols.php',
                    'template/template-listing-grid-v2-fullwidth-4cols.php',
                    'template/template-listing-grid-v4.php',
                    'template/template-listing-grid-v5.php',
                    'template/template-listing-grid-v5-fullwidth-2cols.php',
                    'template/template-listing-grid-v5-fullwidth-3cols.php',
                    'template/template-listing-grid-v6.php',
                    'template/template-listing-grid-v6-fullwidth-2cols.php',
                    'template/template-listing-grid-v6-fullwidth-3cols.php',
                    'template/template-listing-grid-v3.php',
                    'template/template-listing-grid-v3-fullwidth-2cols.php',
                    'template/template-listing-grid-v3-fullwidth-3cols.php',
                    'template/property-listings-map.php',
                    'template/properties-parallax.php',
                ),
            ),
            'fields'    => array(
                array(
                    'id' => $houzez_prefix."prop_no",
                    'name' => esc_html__('Number of listings to display', 'houzez'),
                    'desc' => "",
                    'type' => 'number',
                    'std' => "9",
                    'tab' => 'listing_temp_general',
                    'columns' => 6
                ),
                array(
                    'name'      => esc_html__('Order Properties By', 'houzez'),
                    'id'        => $houzez_prefix . 'properties_sort',
                    'type'      => 'select',
                    'options'   => array(
                        'd_date'  => esc_html__('Date New to Old', 'houzez'),
                        'a_date'  => esc_html__('Date Old to New', 'houzez'),
                        'd_price' => esc_html__('Price (High to Low)', 'houzez'),
                        'a_price' => esc_html__('Price (Low to High)', 'houzez'),
                        'featured_first' => esc_html__('Show Featured Listings on Top', 'houzez')
                    ),
                    'std'       => array( 'd_date' ),
                    'desc'      => '',
                    'columns' => 6
                ),
                
                array(
                    'id' => $houzez_prefix."listings_tabs",
                    'name' => esc_html__('Tabs', 'houzez'),
                    'desc' => esc_html__('Enable/disable the tabs on the listing page(not work for half map and parallax listing template)', 'houzez'),
                    'type' => 'select',
                    'std' => "disable",
                    'options' => array('enable' => esc_html__('Enabled', 'houzez'), 'disable' => esc_html__('Disabled', 'houzez')),
                    'columns' => 12
                ),
                array(
                    'id' => $houzez_prefix."listings_tab_1",
                    'name' => esc_html__('Tabs One', 'houzez'),
                    'desc' => esc_html__('Choose the property status for this tab', 'houzez'),
                    'type' => 'select',
                    'std' => "",
                    'options' => $prop_status,
                    'columns' => 6
                ),
                array(
                    'id' => $houzez_prefix."listings_tab_2",
                    'name' => esc_html__('Tabs Two', 'houzez'),
                    'desc' => esc_html__('Choose the property status for this tab', 'houzez'),
                    'type' => 'select',
                    'std' => "",
                    'options' => $prop_status,
                    'columns' => 6
                ),

                //Filters
                $property_type_filter,
                $property_status_filter,
                $property_label_filter,
                $property_state_filter,
                $property_city_filter,
                $property_feature_filter,
                $property_area_filter,
                

                array(
                    'name'            => esc_html__( 'Properties by Agents', 'houzez' ),
                    'id'              => $houzez_prefix. 'properties_by_agents',
                    'type'            => 'select',
                    'options'         => $agents_for_templates,
                    'multiple'        => true,
                    'select_all_none' => true,
                    'columns'         => 6,
                ),

                array(
                    'name'      => esc_html__('Min Price', 'houzez'),
                    'id'        => $houzez_prefix . 'min_price',
                    'type'      => 'number',
                    'options'   => '',
                    'desc'      => '',
                    'columns' => 6
                ),
                array(
                    'name'      => esc_html__('Max Price', 'houzez'),
                    'id'        => $houzez_prefix . 'max_price',
                    'type'      => 'number',
                    'options'   => '',
                    'desc'      => '',
                    'columns' => 6
                ),

                array(
                    'id'      => $houzez_prefix. 'properties_min_beds',
                    'name'    => esc_html__( 'Minimum Beds', 'houzez' ),
                    'type'    => 'number',
                    'step'    => 'any',
                    'min'     => 0,
                    'std'     => 0,
                    'columns' => 6,
                ),

                array(
                    'id'      => $houzez_prefix. 'properties_min_baths',
                    'name'    => esc_html__( 'Minimum Baths', 'houzez' ),
                    'type'    => 'number',
                    'step'    => 'any',
                    'min'     => 0,
                    'std'     => 0,
                    'columns' => 6,
                ),
            )
        );
        

        return apply_filters('houzez_listings_templates_meta', $meta_boxes);

    }

    add_filter( 'rwmb_meta_boxes', 'houzez_listings_templates_metaboxes', 7 );
}