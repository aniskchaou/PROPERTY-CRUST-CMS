<?php
global $houzez_opt_name, $custom_fields_array;

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Property Detail', 'houzez' ),
    'id'     => 'property-page',
    'desc'   => '',
    'icon'   => 'el-icon-home el-icon-small',
    'fields'		=> array(
        array(
            'id'       => 'prop-top-area',
            'type'     => 'image_select',
            'title'    => esc_html__('Property Banner', 'houzez'),
            'subtitle' => esc_html__('Select the banner version you want to display in the property detail page', 'houzez'),
            'desc'     => esc_html__('Select the banner version', 'houzez'),
            'options'  => array(
                'v1' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'property/property-banner-style-1.jpg'
                ),
                'v2' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'property/property-banner-style-2.jpg'
                ),
                'v3' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'property/property-banner-style-3.jpg'
                ),
                'v4' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'property/property-banner-style-4.jpg'
                ),
                'v5' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'property/property-banner-style-5.jpg'
                ),
                'v6' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'property/property-banner-style-6.jpg'
                ),
            ),
            'default'  => 'v1',
        ),
        array(
            'id'       => 'prop_default_active_tab',
            'type'     => 'select',
            'title'    => esc_html__('Property Banner Active Tab', 'houzez'),
            'subtitle' => esc_html__('The property top banner has three tabs, the image/gallery, map view and street view. Select the one you want to display first', 'houzez'),
            'desc'     => esc_html__('Select the which one has to be the first tab', 'houzez'),
            'options'  => array(
                'image_gallery'   => esc_html__( 'Image/Gallery', 'houzez' ),
                'map_view'        => esc_html__( 'Map View', 'houzez' )
            ),
            'default'  => 'image_gallery',
        ),
        array(
            'id'       => 'prop-content-layout',
            'type'     => 'select',
            'title'    => esc_html__('Property Content Layout', 'houzez'),
            'subtitle' => '',
            'desc'     => esc_html__('Select the contet layout', 'houzez'),
            'options'  => array(
                'simple' => esc_html__( 'Default', 'houzez' ),
                'tabs'   => esc_html__( 'Tabs', 'houzez' ),
                'tabs-vertical' => esc_html__( 'Tabs Vertical', 'houzez' ),
                'v2' => esc_html__( 'Luxury Homes', 'houzez' ),
            ),
            'default'  => 'simple',
        ),

        array(
            'id'       => 'is_full_width',
            'type'     => 'switch',
            'title'    => esc_html__( 'Full Width Property Content Layout', 'houzez' ),
            'subtitle'     => esc_html__('If you select yes the property page will be full-width without the sidebar', 'houzez'),
            'desc' => esc_html__( 'Do you want to make the property page full width?', 'houzez' ),
            'default'  => 0,
            'required' => array( 'prop-content-layout', '!=', 'v2' ),
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),

        array(
            'id'       => 'prop_details_cols',
            'type'     => 'select',
            'title'    => esc_html__('Details section columns', 'houzez'),
            'subtitle' => esc_html__('Select number of columns you show for details section', 'houzez'),
            'desc'     => '',
            'options'  => array(
                'list-1-cols'   => esc_html__( '1 Column', 'houzez' ),
                'list-2-cols'   => esc_html__( '2 Columns', 'houzez' ),
                'list-3-cols'   => esc_html__( '3 Columns', 'houzez' )
            ),
            'default'  => 'list-2-cols',
        ),

        array(
            'id'       => 'prop_address_cols',
            'type'     => 'select',
            'title'    => esc_html__('Address section columns', 'houzez'),
            'subtitle' => esc_html__('Select number of columns you show for address section', 'houzez'),
            'desc'     => '',
            'options'  => array(
                'list-1-cols'   => esc_html__( '1 Column', 'houzez' ),
                'list-2-cols'   => esc_html__( '2 Columns', 'houzez' ),
                'list-3-cols'   => esc_html__( '3 Columns', 'houzez' )
            ),
            'default'  => 'list-2-cols',
        ),

        array(
            'id'       => 'prop_features_cols',
            'type'     => 'select',
            'title'    => esc_html__('Features section columns', 'houzez'),
            'subtitle' => esc_html__('Select number of columns you show for features section', 'houzez'),
            'desc'     => '',
            'options'  => array(
                'list-1-cols'   => esc_html__( '1 Column', 'houzez' ),
                'list-2-cols'   => esc_html__( '2 Columns', 'houzez' ),
                'list-3-cols'   => esc_html__( '3 Columns', 'houzez' )
            ),
            'default'  => 'list-3-cols',
        ),

        array(
            'id'       => 'prop-detail-nav',
            'type'     => 'select',
            'title'    => esc_html__('Property Detail Navigation', 'houzez'),
            'subtitle' => esc_html__('It works only for default layout', 'houzez'),
            'desc'     => esc_html__('Do you wan to display the property detail page sticky navigation bar?', 'houzez'),
            'options'  => array(
                'no' => esc_html__( 'No', 'houzez' ),
                'yes'   => esc_html__( 'Yes', 'houzez' )
            ),
            'default'  => 'no',
        ),
        array(
            'id'       => 'map_in_section',
            'type'     => 'switch',
            'title'    => esc_html__( 'Address Map Section', 'houzez' ),
            'subtitle' => esc_html__( 'If enabled, the map in the top banner will not displayed', 'houzez' ),
            'desc'     => esc_html__( 'Enable or disable the map in the address section', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'send_agent_message_copy',
            'type'     => 'switch',
            'title'    => esc_html__( 'Do you want to receive the copy of message sent to agent ?', 'houzez' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),
        array(
            'id'       => 'send_agent_message_email',
            'type'     => 'text',
            'required' => array( 'send_agent_message_copy', '=', '1' ),
            'title'    => esc_html__( 'Email address to receive message copy.', 'houzez' ),
            'desc'     => esc_html__('This email address will receive a copy of message sent to agent from property detail page.', 'houzez'),
            'subtitle' => 'Enter valid email address.'
        ),
        
    ),
));


/* Sections
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Layout Manager - Default', 'houzez' ),
    'id'     => 'property-section',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'      => 'property_blocks',
            'type'    => 'sorter',
            'title'   => 'Property Layout Manager',
            'subtitle'    => 'Use this tool if you selected "Default" on the "Property Content Layout" option',
            'desc'    => 'Drag and drop layout manager to quickly organize your property page content',
            'options' => array(
                'enabled'  => array(
                    'overview'     => esc_html__('Overview', 'houzez'),
                    'description'  => esc_html__('Description', 'houzez'),
                    'address'      => esc_html__('Address', 'houzez'),
                    'details'      => esc_html__('Details', 'houzez'),
                    'features'     => esc_html__('Features', 'houzez'),
                    'floor_plans'  => esc_html__('Floor Plans', 'houzez'),
                    'video'        => esc_html__('Video', 'houzez'),
                    'virtual_tour' => esc_html__('360° Virtual Tour', 'houzez'),
                    'walkscore'    => esc_html__('Walkscore', 'houzez'),
                    'mortgage_calculator'        => esc_html__('Mortgage Calculator', 'houzez'),
                    'agent_bottom' => esc_html__('Agent bottom', 'houzez'),
                    'review'        => esc_html__('Reviews', 'houzez'),
                    'similar_properties' => esc_html__('Similar Listings', 'houzez'),
                ),
                'disabled' => array(
                    'yelp_nearby'  => esc_html__('Near by Places', 'houzez'),
                    'block_gallery'  => esc_html__('Section Gallery', 'houzez'),
                    'schedule_tour' => esc_html__('Schedule Tour', 'houzez'),
                    'energy_class' => esc_html__('Energy Class', 'houzez'),
                    'unit'         => esc_html__('Multi Unit / Sub Listings', 'houzez'),
                    'adsense_space_1' => esc_html__('Adsense Space 1', 'houzez'),
                    'adsense_space_2' => esc_html__('Adsense Space 2', 'houzez'),
                    'adsense_space_3' => esc_html__('Adsense Space 3', 'houzez'),
                    'booking_calendar' => esc_html__('Availability Calendar', 'houzez'),
                )
            ),
        ),

        array(
            'id'       => 'block_gallery_visible',
            'type'     => 'text',
            'title'    => esc_html__('Section Gallery Number of Visible Images', 'houzez'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '9',
            'validate' => 'numeric'
        ),

        array(
            'id'       => 'block_gallery_columns',
            'type'     => 'text',
            'title'    => esc_html__('Section Gallery Images in a row', 'houzez'),
            'subtitle' => '',
            'desc'     => '',
            'default'  => '3',
            'validate' => 'numeric'
        ),
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Layout Manager - Tabs', 'houzez' ),
    'id'     => 'property-section-tabs',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'      => 'property_blocks_tabs',
            'type'    => 'sorter',
            'title'   => 'Property Layout Manager',
            'subtitle'    => 'Use this tool if you selected "Tab" or "Vertical Tabs" on the "Property Content Layout" option',
            'desc'    => 'Drag and drop layout manager to quickly organize your property page content',
            'options' => array(
                'enabled'  => array(
                    'description'  => esc_html__('Description', 'houzez'),
                    'address'      => esc_html__('Address', 'houzez'),
                    'details'      => esc_html__('Details', 'houzez'),
                    'features'     => esc_html__('Features', 'houzez'),
                    'floor_plans'  => esc_html__('Floor Plans', 'houzez'),
                    'video'        => esc_html__('Video', 'houzez'),
                ),
                'disabled' => array(
                    'virtual_tour' => esc_html__('360° Virtual Tour', 'houzez'),
                )
            ),
        ),
        array(
            'id'       => 'tabs_agent_bottom',
            'type'     => 'switch',
            'title'    => esc_html__( 'Agent contact form section', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable agent contact for section section.', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'houzez_availability_calendar',
            'type'     => 'switch',
            'title'    => esc_html__( 'Availability Calendar', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the availability calendar section.', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'houzez_energy_class',
            'type'     => 'switch',
            'title'    => esc_html__( 'Energy Efficiency', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the energy class sectio.', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'houzez_mortgage',
            'type'     => 'switch',
            'title'    => esc_html__( 'Mortgage Calculator', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable mortgage calculator section.', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'houzez_sublisting',
            'type'     => 'switch',
            'title'    => esc_html__( 'Sub Listings', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the sub listings section.', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'houzez_tabs_schedule',
            'type'     => 'switch',
            'title'    => esc_html__( 'Schedule Tour', 'houzez' ),
            'subtitle' => esc_html__( 'Enable or disable the schedule a tour form.', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
    )
));


Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Layout Manager - Luxury Homes', 'houzez' ),
    'id'     => 'property-section-luxury-homes',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'      => 'property_blocks_luxuryhomes',
            'type'    => 'sorter',
            'title'   => 'Property Layout Manager',
            'subtitle'    => 'Use this tool if you selected "Luxury Homes" on the "Property Content Layout" option',
            'desc'    => 'Drag and drop layout manager to quickly organize your property page content',
            'options' => array(
                'enabled'  => array(
                    'description'  => esc_html__('Description & Details', 'houzez'),
                    'features'     => esc_html__('Features', 'houzez'),
                    'address'      => esc_html__('Address', 'houzez'),
                    'gallery'      => esc_html__('Gallery', 'houzez'),
                    'floor_plans'  => esc_html__('Floor Plans', 'houzez'),
                    'video'        => esc_html__('Video', 'houzez'),
                    'mortgage_calculator'        => esc_html__('Mortgage Calculator', 'houzez'),
                    'agent_form'   => esc_html__('Agent Contact', 'houzez'),
                    'review'        => esc_html__('Reviews', 'houzez'),
                    'similar_properties' => esc_html__('Similar Listings', 'houzez'),
                ),
                'disabled' => array(
                    'virtual_tour' => esc_html__('360° Virtual Tour', 'houzez'),
                    'energy_class' => esc_html__('Energy Class', 'houzez'),
                    'yelp_nearby'  => esc_html__('Nearby', 'houzez'),
                    'unit'         => esc_html__('Multi Unit / Sub Listings', 'houzez'),
                    'walkscore'    => esc_html__('Walkscore', 'houzez'),
                    'schedule_tour' => esc_html__('Schedule Tour', 'houzez'),
                    'adsense_space_1' => esc_html__('Adsense Space 1', 'houzez'),
                    'adsense_space_2' => esc_html__('Adsense Space 2', 'houzez'),
                    'adsense_space_3' => esc_html__('Adsense Space 3', 'houzez'),
                    'booking_calendar' => esc_html__('Availability Calendar', 'houzez'),
                )
            ),
        )
    )
));

$overview_composer = array(
    'type' => esc_html__('Property Type', 'houzez'),
    'bedrooms' => esc_html__('Bedrooms', 'houzez'),
    'bathrooms' => esc_html__('Bathrooms', 'houzez'),
    'garage' => esc_html__('Garage', 'houzez'),
    'area-size' => esc_html__('Area Size', 'houzez'),
    'year-built' => esc_html__('Year Built', 'houzez'),

);

$overview_composer_disabled = array(
    'rooms' => esc_html__('Rooms', 'houzez'),
    'land-area' => esc_html__('Land Area', 'houzez'),
    'property-id' => esc_html__('Property ID', 'houzez'),
);

$overview_composer_disabled = array_merge($overview_composer_disabled, $custom_fields_array);

/* Overview Composer 
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Overview Section', 'houzez' ),
    'id'     => 'overview-section',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'show_id_head',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property ID', 'houzez' ),
            'desc' => esc_html__( 'Show property id in section header.', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Show', 'houzez' ),
            'off'      => esc_html__( 'Hide', 'houzez' ),
        ),
        array(
            'id'      => 'overview_data_composer',
            'type'    => 'sorter',
            'title'   => 'Overview Data Composer',
            'subtitle'    => esc_html__( 'Drag and drop data manage for overview section', 'houzez' ),
            'desc'    => '',
            'options' => array(
                'enabled'  => $overview_composer,
                'disabled' => $overview_composer_disabled
            ),
        ),
    )
));

/* Energy Class
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Energy Class', 'houzez' ),
    'id'     => 'energy-class-section',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'energy_class_data',
            'type'     => 'text',
            'title'    => esc_html__( 'Energy Classes', 'houzez' ),
            'default'  => 'A+, A, B, C, D, E, F, G, H',
            'subtitle' => esc_html__( 'Enter comma separated energy classes', 'houzez' ),
        ),
        array(
            'id'       => 'energy_1_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Class 1 Color', 'houzez' ),
            'desc' => '',
            'default'  => '#33a357',
            'transparent' => false,
        ),
        array(
            'id'       => 'energy_2_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Class 2 Color', 'houzez' ),
            'desc' => '',
            'default'  => '#79b752',
            'transparent' => false,
        ),
        array(
            'id'       => 'energy_3_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Class 3 Color', 'houzez' ),
            'desc' => '',
            'default'  => '#c3d545',
            'transparent' => false,
        ),
        array(
            'id'       => 'energy_4_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Class 4 Color', 'houzez' ),
            'desc' => '',
            'default'  => '#fff12c',
            'transparent' => false,
        ),
        array(
            'id'       => 'energy_5_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Class 5 Color', 'houzez' ),
            'desc' => '',
            'default'  => '#edb731',
            'transparent' => false,
        ),
        array(
            'id'       => 'energy_6_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Class 6 Color', 'houzez' ),
            'desc' => '',
            'default'  => '#d66f2c',
            'transparent' => false,
        ),
        array(
            'id'       => 'energy_7_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Class 7 Color', 'houzez' ),
            'desc' => '',
            'default'  => '#cc232a',
            'transparent' => false,
        ),
        array(
            'id'       => 'energy_8_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Class 8 Color', 'houzez' ),
            'desc' => '',
            'default'  => '#cc232a',
            'transparent' => false,
        ),
        array(
            'id'       => 'energy_9_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Class 9 Color', 'houzez' ),
            'desc' => '',
            'default'  => '#cc232a',
            'transparent' => false,
        ),
        array(
            'id'       => 'energy_10_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Class 10 Color', 'houzez' ),
            'desc' => '',
            'default'  => '#cc232a',
            'transparent' => false,
        ),
    )
));

$prop_details_showhide_options = array(
    'prop_id' => esc_html__('Property ID', 'houzez'),
    'prop_type' => esc_html__('Type', 'houzez'),
    'prop_status' => esc_html__('Status', 'houzez'),
    'prop_label' => esc_html__('Label', 'houzez'),
    'sale_rent_price' => esc_html__('Sale or Rent Price', 'houzez'),
    'bedrooms' => esc_html__('Bedrooms', 'houzez'),
    'rooms' => esc_html__('Rooms', 'houzez'),
    'bathrooms' => esc_html__('Bathrooms', 'houzez'),
    'area_size' => esc_html__('Area Size', 'houzez'),
    'land_area' => esc_html__('Land Area', 'houzez'),
    'garages' => esc_html__('Garages', 'houzez'),
    'year_built' => esc_html__('Year Built', 'houzez'),
    'updated_date' => esc_html__('Updated Date', 'houzez'),
    'additional_details' => esc_html__('Additional Details', 'houzez'),
    'address' => esc_html__('Address', 'houzez'),
    'country' => esc_html__('Country', 'houzez'),
    'city' => esc_html__('City', 'houzez'),
    'state' => esc_html__('State/county', 'houzez'),
    'area' => esc_html__('Area', 'houzez'),
    'zip' => esc_html__('Zip/Postal Code', 'houzez'),
);

$prop_details_showhide_options = array_merge($prop_details_showhide_options, $custom_fields_array);

$prop_details_showhide_default = array(
    'prop_id' => '0',
    'prop_type' => '0',
    'prop_status' => '0',
    'prop_label' => '0',
    'sale_rent_price' => '0',
    'bedrooms' => '0',
    'rooms' => '0',
    'bathrooms' => '0',
    'area_size' => '0',
    'land_area' => '0',
    'garages' => '0',
    'year_built' => '0',
    'updated_date' => '0',
    'additional_details' => '0',
);

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Show/Hide Data', 'houzez' ),
    'id'     => 'propertydetail-showhide',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'print_property_button',
            'type'     => 'switch',
            'title'    => esc_html__( 'Print Property', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__( 'Enable/Disable print property button', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'detail_featured_label',
            'type'     => 'switch',
            'title'    => esc_html__( 'Featured Label', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__( 'Enable/Disable featured label', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'detail_status',
            'type'     => 'switch',
            'title'    => esc_html__( 'Status', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__( 'Enable/Disable property status', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'detail_label',
            'type'     => 'switch',
            'title'    => esc_html__( 'Labels', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__( 'Enable/Disable property labels', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'prop_detail_favorite',
            'type'     => 'switch',
            'title'    => esc_html__( 'Favorite Property', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__( 'Enable/Disable favorite property button', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'prop_detail_share',
            'type'     => 'switch',
            'title'    => esc_html__( 'Share Property', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__( 'Enable/Disable share property button', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'documents_download',
            'type'     => 'switch',
            'title'    => esc_html__( 'Documents Download', 'houzez' ),
            'subtitle' => esc_html__( 'Enable/Disable documents download only for registers users.', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        
        array(
            'id'       => 'hide_detail_prop_fields',
            'type'     => 'checkbox',
            'title'    => esc_html__( 'Property Detail Information', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__('Select which information you want to hide from the property detail page', 'houzez'),
            'options'  => $prop_details_showhide_options,
            'default' => $prop_details_showhide_default
        ),
    )
));

/* Adsense Spaces
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Adsense Spaces', 'houzez' ),
    'id'     => 'adsense_spaces',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'adsense_space_1',
            'type'     => 'textarea',
            'title'    => esc_html__( 'Adsense Space 1', 'houzez' ),
            'subtitle' => esc_html__( 'Paste your banner JS or Google Adsense code, html banner also allowed.', 'houzez' ),
        ),
        array(
            'id'       => 'adsense_space_2',
            'type'     => 'textarea',
            'title'    => esc_html__( 'Adsense Space 2', 'houzez' ),
            'subtitle' => esc_html__( 'Paste your banner JS or Google Adsense code, html banner also allowed.', 'houzez' ),
        ),
        array(
            'id'       => 'adsense_space_3',
            'type'     => 'textarea',
            'title'    => esc_html__( 'Adsense Space 3', 'houzez' ),
            'subtitle' => esc_html__( 'Paste your banner JS or Google Adsense code, html banner also allowed.', 'houzez' ),
        ),
    )
));


/* WalkScore
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Walkscore', 'houzez' ),
    'id'     => 'walkscore',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'houzez_walkscore',
            'type'     => 'switch',
            'title'    => esc_html__( 'Walkscore', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the Walkscore section on property detail page.', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'houzez_walkscore_api',
            'type'     => 'text',
            'title'    => esc_html__( 'Walkscore API Key', 'houzez' ),
            'desc'     => wp_kses(__('Enter your Walkscore API key code. <a target="_blank" href="https://www.walkscore.com/professional/api.php">Get an API code</a>', 'houzez' ), $allowed_html_array),
            'required' => array('houzez_walkscore', '=', '1')
        ),
    )
));


Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Yelp Nearby Places', 'houzez' ),
    'id'     => 'yelp',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'houzez_yelp',
            'type'     => 'switch',
            'title'    => esc_html__( 'Yelp', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable Yelp on the property detail page.', 'houzez' ),
            'subtitle' => wp_kses(__( 'Please note that Yelp is not working for all countries. See here <a target="_blank" href="https://www.yelp.com/factsheet">https://www.yelp.com/factsheet</a> the list of countries where Yelp is available.', 'houzez' ), $allowed_html_array),
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'houzez_yelp_api_key',
            'type'     => 'text',
            'title'    => esc_html__( 'Yelp API Key', 'houzez' ),
            //'subtitle' => esc_html__( "Yelp info doesn't show if you don't add the API Key.", 'houzez' ),
            'desc'     => wp_kses(__('Enter your Yelp API key code. <a target="_blank" href="https://www.yelp.com/developers/v3/manage_app">Get an API code</a>', 'houzez'), $allowed_html_array),
            'required' => array('houzez_yelp', '=', '1')
        ),
        array(
            'id'       => 'houzez_yelp_term',
            'type'     => 'select',
            'multi'    => true,
            'title'    => esc_html__( 'Yelp Categories', 'houzez' ),
            'desc' => esc_html__( "Select the Yelp categories that you want to display.", 'houzez' ),
            'options'  => $yelp_categories = array (
                'active' => 'Active Life',
                'arts' => 'Arts & Entertainment',
                'auto' => 'Automotive',
                'beautysvc' => 'Beauty & Spas',
                'education' => 'Education',
                'eventservices' => 'Event Planning & Services',
                'financialservices' => 'Financial Services',
                'food' => 'Food',
                'health' => 'Health & Medical',
                'homeservices' => 'Home Services ',
                'hotelstravel' => 'Hotels & Travel',
                'localflavor' => 'Local Flavor',
                'localservices' => 'Local Services',
                'massmedia' => 'Mass Media',
                'nightlife' => 'Nightlife',
                'pets' => 'Pets',
                'professional' => 'Professional Services',
                'publicservicesgovt' => 'Public Services & Government',
                'realestate' => 'Real Estate',
                'religiousorgs' => 'Religious Organizations',
                'restaurants' => 'Restaurants',
                'shopping' => 'Shoppi',
                'transport' => 'Transportation'
            ),
            'default' => array('food', 'health', 'education', 'realestate'),
            'required' => array('houzez_yelp', '=', '1')
        ),
        array(
            'id'       => 'houzez_yelp_limit',
            'type'     => 'text',
            'title'    => esc_html__( 'Yelp Results Limit', 'houzez' ),
            'desc' => esc_html__( "Enter the number of result that you want to display", 'houzez' ),
            'required' => array('houzez_yelp', '=', '1'),
            'default' => 3
        ),
        array(
            'id'       => 'houzez_yelp_dist_unit',
            'type'     => 'select',
            'multi'    => false,
            'title'    => esc_html__( 'Yelp Distance Unit', 'houzez' ),
            'desc' => esc_html__( "Select the distance unit.", 'houzez' ),
            'options'  => array (
                'miles' => 'Miles',
                'kilometers' => 'Kilometers'
            ),
            'default' => 'miles',
            'required' => array('houzez_yelp', '=', '1')
        )
    )
));


/* Adsense Spaces
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Schedule a Tour', 'houzez' ),
    'id'     => 'schedule_a_tour',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'schedule_time_slots',
            'type'     => 'textarea',
            'title'    => esc_html__( 'Time Slots', 'houzez' ),
            'subtitle' => esc_html__( 'Use the comma to separate the time slots. (For example: 12:00 am, 12:15 am, 12:30 am)', 'houzez' ),
            'default'  => '10:00 am, 10:15 pm, 10:30 pm, 12:00 pm, 12:15 pm, 12:30 pm, 12:45 pm, 01:00 pm, 01:15 pm, 01:30 pm, 01:45 pm, 02:00 pm, 05:00 pm'
        )
    )
));

$custom_licon_fields = $builtin_icons = $default_fields = array();
$builtin_icons = houzez_listing_fields_for_icons_luxury();
$all_icons_fields = array_merge($builtin_icons, $custom_fields_array);
foreach ($all_icons_fields as $key => $icon_field) {

    $prefix = '';
    if( !array_key_exists($key, $builtin_icons)) {
        $prefix = 'c_';
    }

    $custom_licon_fields[] = array(
        'id'        => $prefix.$key,
        'type'      => 'media',
        'title'     => $icon_field,
        'read-only' => false,
        'subtitle'  => esc_html__( 'Upload jpg, png or svg icon', 'houzez' ),
    );
}

/* Icons
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Luxury Homes Icons', 'houzez' ),
    'id'     => 'luxury-homes',
    'desc'   => esc_html__( 'Icons for the Luxury Homes property detail page', 'houzez' ),
    'subsection' => true,
    'fields' => $custom_licon_fields
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Mortgage Calculator', 'houzez' ),
    'id'     => 'prop-details-mortgage-cal',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'          => 'cal_where',
            'type'        => 'select',
            'title'       => esc_html__( 'Select the Status', 'houzez' ),
            'subtitle'    => esc_html__( 'Select status where you want to hide mortgage calculator', 'houzez' ),
            'desc'        => '',
            'multi'    => true,
            'data'  => 'terms',
            'args'  => array(
                'taxonomy' => array( 'property_status' ),
                'hide_empty' => false,
            )
        ),
        array(
            'id'       => 'mcal_down_payment',
            'type'     => 'text',
            'title'    => esc_html__( 'Default Down Payment', 'houzez' ),
            'subtitle' => esc_html__( 'Enter default down payment percentage(%)', 'houzez' ),
            'default'  => '15',
            'validate' => 'numeric'
        ),
        array(
            'id'       => 'mcal_terms',
            'type'     => 'text',
            'title'    => esc_html__( 'Default Terms(years)', 'houzez' ),
            'subtitle' => '',
            'default'  => '12',
            'validate' => 'numeric'
        ),
        array(
            'id'       => 'mcal_interest_rate',
            'type'     => 'text',
            'title'    => esc_html__( 'Default Interest Rate(%)', 'houzez' ),
            'subtitle' => '',
            'default'  => '3.5',
            'validate' => 'numeric'
        ),
        array(
            'id'       => 'mcal_prop_tax_enable',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Tax', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable property tax', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'mcal_prop_tax',
            'type'     => 'text',
            'title'    => esc_html__( 'Default Property tax', 'houzez' ),
            'subtitle' => '',
            'default'  => '3000',
            'required' => array('mcal_prop_tax_enable', '=', '1'),
            'validate' => 'numeric'
        ),
        array(
            'id'       => 'mcal_hi_enable',
            'type'     => 'switch',
            'title'    => esc_html__( 'Homey Insurance', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable homey insurance', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'mcal_hi',
            'type'     => 'text',
            'title'    => esc_html__( 'Default Homey Insurance', 'houzez' ),
            'subtitle' => '',
            'default'  => '1000',
            'required' => array('mcal_hi_enable', '=', '1'),
            'validate' => 'numeric'
        ),
        array(
            'id'       => 'mcal_pmi_enable',
            'type'     => 'switch',
            'title'    => esc_html__( 'PMI', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable pmi', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'mcal_pmi',
            'type'     => 'text',
            'title'    => esc_html__( 'Default PMI', 'houzez' ),
            'subtitle' => '',
            'default'  => '1000',
            'required' => array('mcal_pmi_enable', '=', '1'),
            'validate' => 'numeric'
        ),

    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Similar Properties', 'houzez' ),
    'id'     => 'property-similar-showhide',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'houzez_similer_properties',
            'type'     => 'switch',
            'title'    => esc_html__( 'Similar Properties', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the similar properties on the property detail page.', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'houzez_similer_properties_type',
            'type'     => 'select',
            'multi'     => true,
            'title'    => esc_html__( 'Similar Properties Criteria', 'houzez' ),
            'desc' => esc_html__( "Choose which criteria you want to use to display similar properties.", 'houzez' ),
            'options'  => array(
                'property_type' => esc_html__('Property Type', 'houzez'),
                'property_status' => esc_html__('Property Status', 'houzez'),
                'property_label' => esc_html__('Property Label', 'houzez'),
                'property_feature' => esc_html__('Property Feature', 'houzez'),
                'property_country' => esc_html__('Property Country', 'houzez'),
                'property_state' => esc_html__('Property State', 'houzez'),
                'property_city' => esc_html__('Property City', 'houzez'),
                'property_area' => esc_html__('Property Area', 'houzez'),
            ),
            'default' => 'property_type'
        ),

        array(
            'id'       => 'similar_order',
            'type'     => 'select',
            'title'    => __('Default Order', 'houzez'),
            'desc' => '',
            'options'  => array(
                'd_date' => esc_html__( 'Date New to Old', 'houzez' ),
                'a_date' => esc_html__( 'Date Old to New', 'houzez' ),
                'd_price' => esc_html__( 'Price (High to Low)', 'houzez' ),
                'a_price' => esc_html__( 'Price (Low to High)', 'houzez' ),
                'featured_first' => esc_html__( 'Show Featured Listings on Top', 'houzez' ),
                'random' => esc_html__( 'Random', 'houzez' ),
            ),
            'default' => 'd_date'
        ),

        array(
            'id'       => 'houzez_similer_properties_view',
            'type'     => 'select',
            'title'    => esc_html__( 'Similar Properties View', 'houzez' ),
            'desc' => esc_html__( "Select the view to display for similar properties.", 'houzez' ),
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

        array(
            'id'       => 'houzez_similer_properties_count',
            'type'     => 'select',
            'title'    => esc_html__( 'Similar Properties Number', 'houzez' ),
            'desc' => esc_html__( "Select how many similar properties to display", 'houzez' ),
            'options'  => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10,
            ),
            'default' => 4
        )
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Reviews & Ratings', 'houzez' ),
    'id'     => 'property-reviews',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(

        array(
            'id'       => 'property_reviews',
            'type'     => 'switch',
            'title'    => esc_html__( 'Reviews & Ratings', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the reviews & ratings on the property detail page.', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'property_reviews_approved_by_admin',
            'type'     => 'switch',
            'title'    => esc_html__( 'New Ratings Approved By Admin', 'houzez' ),
            'desc' => esc_html__( 'New reviews & ratings must be approved by the administrator', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),
        array(
            'id'       => 'update_review_approved',
            'type'     => 'switch',
            'title'    => esc_html__( 'Updated Ratings Approved by Admin', 'houzez' ),
            'desc' => esc_html__( 'Updated reviews & ratings must be approved by the administrator', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),
        array(
            'id'       => 'num_of_review',
            'type'     => 'text',
            'title'    => esc_html__( 'Number of Reviews', 'houzez' ),
            'desc' => esc_html__( 'Enter the number of reviews to display on the property detail page', 'houzez' ),
            'default'  => 5,
        )
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Breadcrumbs', 'houzez' ),
    'id'     => 'property-breadcrumbs',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(

        array(
            'id'       => 'single_prop_breadcrumb',
            'type'     => 'radio',
            'title'    => '',
            'subtitle' => esc_html__('Choose breadcrumb type for single propety page', 'houzez'),
            'default'  => 'property_type',
            'options'  => array(
                'property_type' => esc_html__('Property Type', 'houzez'),
                'property_status' => esc_html__('Property Status', 'houzez'),
                'property_status_type' => esc_html__('Property Status and Type', 'houzez'),
                'property_city' => esc_html__('Property City', 'houzez'),
                'property_area' => esc_html__('Property Area', 'houzez'),
                'property_city_area' => esc_html__('Property City and Area', 'houzez'),
            )
        )
    )
));


Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Next/Prev Property', 'houzez' ),
    'id'     => 'property-next-prev',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(

        array(
            'id'       => 'enable_next_prev_prop',
            'type'     => 'switch',
            'title'    => esc_html__( 'Next/Prev Property Navigation', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the next/prev property navigation at the end of the property detail page', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        )
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Disclaimer', 'houzez' ),
    'id'     => 'property-disclaimer',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(

        array(
            'id'       => 'enable_disclaimer',
            'type'     => 'switch',
            'title'    => esc_html__( 'Show Disclaimer', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable disclaimer', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'property_disclaimer',
            'type'     => 'textarea',
            'title'    => esc_html__( 'Disclaimer Text', 'houzez' ),
            'desc' => esc_html__( 'Add disclaimer text globally for all properties, this can be also set on single property level when add/edit property', 'houzez' ),
        )
    )
));