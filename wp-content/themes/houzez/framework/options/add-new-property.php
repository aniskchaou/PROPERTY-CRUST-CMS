<?php
global $houzez_opt_name, $custom_fields_array;

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Add New Property', 'houzez' ),
    'id'     => 'add-property-page',
    'desc'   => '',
    'icon'   => 'el-icon-plus-sign el-icon-small',
    'fields' => array(
        array(
            'id'       => 'submit_form_type',
            'type'     => 'select',
            'title'    => esc_html__('Add New Property Mode', 'houzez'),
            'subtitle' => '',
            'desc'     => esc_html__('Select between multi-steps or one step', 'houzez'),
            'options'  => array(
                'mstep'   => esc_html__( 'Multi-steps', 'houzez' ),
                'one_step'   => esc_html__( 'One-step', 'houzez' )
            ),
            'default'  => 'mstep',
        ),
        array(
            'id'       => 'listings_admin_approved',
            'type'     => 'select',
            'title'    => esc_html__('New Submited Listings Approval', 'houzez'),
            'subtitle' => '',
            'desc'     => esc_html__('Select yes if all new submissions must be approved by the administrator', 'houzez'),
            'options'  => array(
                'yes'   => esc_html__( 'Yes', 'houzez' ),
                'no'   => esc_html__( 'No', 'houzez' )
            ),
            'default'  => 'yes',
        ),
        array(
            'id'       => 'edit_listings_admin_approved',
            'type'     => 'select',
            'title'    => esc_html__('Edited Listings Approval', 'houzez'),
            'subtitle' => '',
            'desc'     => esc_html__('Select yes if all updates must be approved by the administrator', 'houzez'),
            'options'  => array(
                'yes'   => esc_html__( 'Yes', 'houzez' ),
                'no'   => esc_html__( 'No', 'houzez' )
            ),
            'default'  => 'no',
        ),
        array(
            'id'       => 'enable_multi_agents',
            'type'     => 'switch',
            'title'    => esc_html__( 'Multi Agents Mode', 'houzez' ),
            'desc'     => esc_html__( 'Enable or Disable the multi agents mode', 'houzez' ),
            'subtitle' => esc_html__( 'Assign a property to several agents', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'range-bedsroomsbaths',
            'type'     => 'switch',
            'title'    => esc_html__( 'Range Values for Bedrooms, Bathrooms and Rooms', 'houzez' ),
            'desc'     => __( 'Note: Set search query Like for bedrooms, bathrooms and Rooms under <strong>Searches -> Settings</strong> to make it searchable.', 'houzez' ),
            'subtitle' => esc_html__( 'Enable range inputs for bedrooms, rooms and bathrooms fields. Example( 3 - 5, 2 - 4)', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'add_ms_section-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Multi Selection', 'houzez' ),
            'subtitle' => '',
            'indent'   => true,
        ),

        array(
            'id'       => 'ams_type',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Types', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__('Allow multiple selection of property types', 'houzez'),
            'default'  => 0,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),

        array(
            'id'       => 'ams_status',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Status', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__('Allow multiple selection of property status', 'houzez'),
            'default'  => 0,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),

        array(
            'id'       => 'ams_label',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Labels', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__('Allow multiple selection of property labels', 'houzez'),
            'default'  => 0,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),
        array(
            'id'     => 'add_ms_section_end',

            'type'   => 'section',
            'indent' => false,
        ),
        
        array(
            'id'       => 'location_dropdowns',
            'type'     => 'select',
            'title'    => esc_html__('Display Drop-down Menus', 'houzez'),
            'subtitle' => '',
            'desc'     => esc_html__('Select Yes to replace the Property Location text fields with drop-down menus in order to select the property City, Area, County/State and Country', 'houzez'),
            'options'  => array(
                'yes'   => esc_html__( 'Yes', 'houzez' ),
                'no'   => esc_html__( 'No', 'houzez' )
            ),
            'default'  => 'no',
        ),
        array(
            'id'		=> 'area_prefix_default',
            'type'		=> 'select',
            'title'		=> esc_html__( 'Default area prefix', 'houzez' ),
            'subtitle'	=> esc_html__( 'Default option for area prefix.', 'houzez' ),
            'options'	=> array(
                'SqFt' => 'Square Feet - ft²',
                'm²' => 'Square Meters - m²',
            ),
            'default' => 'SqFt'
        ),
        array(
            'id'       => 'area_prefix_changeable',
            'type'     => 'switch',
            'title'    => esc_html__( 'Allow user to change area prefix?', 'houzez' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),
        array(
            'id'       => 'auto_property_id',
            'type'     => 'switch',
            'title'    => esc_html__( 'Auto Generate Property ID ?', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__( 'Enable/Disable auto generate property id', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'        => 'property_id_pattern',
            'type'      => 'text',
            'title'     => esc_html__( 'Property ID Pattern', 'houzez' ),
            'subtitle'  => esc_html__( "Enter pattern for property id. Example HZ-{ID}", 'houzez' ),
            'default' => '{ID}',
            'required' => array('auto_property_id', '=', '1')
        ),
        array(
            'id'        => 'property_id_prefix',
            'type'      => 'text',
            'title'     => esc_html__( 'Property ID Prefix', 'houzez' ),
            'subtitle'  => esc_html__( "Enter prefix for property id, leave empty if you don't want to show prefix. Example HZ-", 'houzez' ),
            'default' => ''
        ),
        array(
            'id'       => 'max_prop_images',
            'type'     => 'text',
            'title'    => esc_html__( 'Maximum Images', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__('Maximum images allow for single property.', 'houzez'),
            'default' => '50'
        ),
        array(
            'id'       => 'image_max_file_size',
            'type'     => 'text',
            'title'    => esc_html__( 'Maximum File Size', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__('Maximum upload image size. For example 10kb, 500kb, 1mb, 10m, 100mb', 'houzez'),
            'default' => '12000kb'
        ),
        array(
            'id'       => 'max_prop_attachments',
            'type'     => 'text',
            'title'    => esc_html__( 'Maximum Attachments', 'houzez' ),
            'desc'     => '',
            'subtitle' => '',
            'default' => '3'
        ),
        array(
            'id'       => 'attachment_max_file_size',
            'type'     => 'text',
            'title'    => esc_html__( 'Maximum File Size for attachments', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__('Maximum upload attachment size. For example 10kb, 500kb, 1mb, 10m, 100mb', 'houzez'),
            'default' => '3000kb'
        ),
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Layout Manager', 'houzez' ),
    'id'     => 'Add-new-property-layout-manager',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'      => 'property_form_sections',
            'type'    => 'sorter',
            'title'   => 'Add New Property Form Layout Manager',
            'subtitle'    => 'Drag-and-drop each module to quickly organize your property submission form layout',
            'options' => array(
                'enabled'  => array(
                    'description-price'     => esc_html__('Description & Price', 'houzez'),
                    'media'                 => esc_html__('Property Media', 'houzez'),
                    'details'               => esc_html__('Property Details', 'houzez'),
                    'features'              => esc_html__('Property Features', 'houzez'),
                    'location'              => esc_html__('Property Location', 'houzez'),
                    'virtual_tour'          => esc_html__('360° Virtual Tour', 'houzez'),
                    'floorplans'            => esc_html__('Floor Plans', 'houzez'),
                    'multi-units'           => esc_html__('Multi Units / Sub Properties', 'houzez'),
                    'agent_info'            => esc_html__('Agent Information', 'houzez'),
                    'private_note'          => esc_html__('Private Notes', 'houzez')
                ),
                'disabled' => array(
                    'attachments'    => esc_html__('Attachments', 'houzez'),
                    'energy_class'    => esc_html__('Energy Class', 'houzez')
                )
            ),
        ),
    )
));



$submit_form_fields = array(
    'beds' => esc_html__('Bedrooms', 'houzez'),
    'rooms' => esc_html__('Rooms', 'houzez'),
    'baths' => esc_html__('Bathrooms', 'houzez'),
    'area-size' => esc_html__('Area Size', 'houzez'),
    'area-size-unit' => esc_html__('Area Size Unit', 'houzez'),
    'land-area' => esc_html__('Land Area', 'houzez'),
    'land-area-unit' => esc_html__('Land Area Unit', 'houzez'),
    'garage' => esc_html__('Garage', 'houzez'),
    'garage-size' => esc_html__('Garage Size', 'houzez'),
    'property-id' => esc_html__('Property ID', 'houzez'),
    'year' => esc_html__('Year Built', 'houzez'),
);
$submit_form_fields = array_merge($submit_form_fields, $custom_fields_array);

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Show/Hide Form Fields', 'houzez' ),
    'id'     => 'property-showhide',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'      => 'adp_details_fields',
            'type'    => 'sorter',
            'title'   => 'Property Detail Section',
            'subtitle'    => 'Drag-and-drop each module to quickly organize the form fields order of Property Details section.',
            'options' => array(
                'enabled'  => $submit_form_fields,
                'disabled' => array()
            ),
        ),
        array(
            'id'       => 'hide_add_prop_fields',
            'type'     => 'checkbox',
            'title'    => esc_html__( 'Add New Property Form Fields', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__('Select which fields you want to disable from the Add New Property form', 'houzez'),
            'options'  => array(
                'prop_type' => esc_html__('Property Type', 'houzez'),
                'prop_status' => esc_html__('Property Status', 'houzez'),
                'prop_label' => esc_html__('Property Label', 'houzez'),
                'sale_rent_price' => esc_html__('Sale or Rent Price', 'houzez'),
                'second_price' => esc_html__('Second Price', 'houzez'),
                'price_postfix' => esc_html__('After Price Label', 'houzez'),
                'price_prefix' => esc_html__('Price Prefix', 'houzez'),
                'video_url' => esc_html__('Property Video Url', 'houzez'),
                'neighborhood' => esc_html__('Neighborhood', 'houzez'),
                'city' => esc_html__('City', 'houzez'),
                'postal_code' => esc_html__('Postal Code/Zip', 'houzez'),
                'state' => esc_html__('County/State', 'houzez'),
                'country' => esc_html__('Country', 'houzez'),
                'map' => esc_html__('Map Section', 'houzez'),
                'map_address' => esc_html__('Map Address', 'houzez'),
                'additional_details' => esc_html__('Additional Details', 'houzez'),
            ),
            'default' => array(
                'prop_type' => '0',
                'prop_status' => '0',
                'prop_label' => '0',
                'sale_rent_price' => '0',
                'second_price' => '0',
                'price_postfix' => '0',
                'price_prefix' => '0',
                'video_url' => '0',
                'neighborhood' => '0',
                'city' => '0',
                'postal_code' => '0',
                'state' => '0',
                'country' => '0',
                'map' => '0',
                'map_address' => '0',
                'additional_details' => '0',
            )
        ),
    )
));


$submit_form_required_fields = array(
    'title' => esc_html__('Title', 'houzez'),
    
    'prop_type' => esc_html__('Type', 'houzez'),
    'prop_status' => esc_html__('Status', 'houzez'),
    'prop_labels' => esc_html__('Label', 'houzez'),
    'sale_rent_price' => esc_html__('Sale or Rent Price', 'houzez'),
    'prop_second_price' => esc_html__('Second Price ( Display optional price for rental or square feet )', 'houzez'),
    'price_label' => esc_html__('After Price Label', 'houzez'),
    'prop_id' => esc_html__('Property ID', 'houzez'),
    'bedrooms' => esc_html__('Bedrooms', 'houzez'),
    'rooms' => esc_html__('Rooms', 'houzez'),
    'bathrooms' => esc_html__('Bathrooms', 'houzez'),
    'area_size' => esc_html__('Area Size', 'houzez'),
    'land_area' => esc_html__('Land Area', 'houzez'),
    'garages' => esc_html__('Garages', 'houzez'),
    'year_built' => esc_html__('Year Built', 'houzez'),
    'energy_class' => esc_html__('Energy Class', 'houzez'),
    'property_map_address' => esc_html__('Map Address', 'houzez'),
    'country' => esc_html__('Country', 'houzez'),
    'state' => esc_html__('State', 'houzez'),
    'city' => esc_html__('City', 'houzez'),
    'area' => esc_html__('Area', 'houzez'),
    
    
);
$submit_form_required_fields = array_merge($submit_form_required_fields, $custom_fields_array);

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Required Form Fields', 'houzez' ),
    'id'     => 'property-required-fields',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'enable_title_limit',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Title Limit', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__( 'Limit Title length for add listing', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'property_title_limit',
            'type'     => 'text',
            'title'    => esc_html__( 'Number of Characters', 'houzez' ),
            'subtitle' => esc_html__( 'Enter number of allowed characters.ie 150', 'houzez' ),
            'default'  => '',
            'validate'  => 'numeric',
            'required'  => array('enable_title_limit', '=', '1'),
        ),
        array(
            'id'       => 'required_fields',
            'type'     => 'checkbox',
            'title'    => esc_html__( 'Required Fields', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__('Select which fields of the Add New Property form are mandatory', 'houzez'),
            'options'  => $submit_form_required_fields,
            'default' => array(
                'title' => '1',
                'prop_type' => '0',
                'prop_status' => '0',
                'prop_labels' => '0',
                'sale_rent_price' => '1',
                'prop_second_price' => '0',
                'price_label' => '0',
                'prop_id' => '0',
                'bedrooms' => '0',
                'rooms' => '0',
                'bathrooms' => '0',
                'area_size' => '1',
                'land_area' => '0',
                'garages' => '0',
                'year_built' => '0',
                'property_map_address' => '1',
                'energy_class' => '0',
                'area' => '0',
                'city' => '0',
                'state' => '0',
                'country' => '0',
                
            )
        ),
    )
));