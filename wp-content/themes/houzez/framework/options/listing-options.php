<?php
global $houzez_opt_name, $custom_fields_array;

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Listings Options', 'houzez' ),
    'id'     => 'lisitngs-options',
    'desc'   => esc_html__( 'Manage list or grid view information on the listing pages', 'houzez' ),
    'icon'   => 'el-icon-th-list el-icon-small',
    'fields'		=> array(
        array(
            'id'       => 'template_sidebar_pos',
            'type'     => 'select',
            'title'    => esc_html__('Sidebar Position', 'houzez'),
            'subtitle' => esc_html__('Choose sidebar position for listing templates', 'houzez'),
            'desc' => '',
            'options'  => array(
                ''   => esc_html__( 'Sidebar on Right ', 'houzez' ),
                'wrap-order-first' => esc_html__( 'Sidebar on Left', 'houzez' ),
            ),
            'default'  => '',
        ),
        /*array(
            'id'       => 'disable_property_gallery',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Gallery', 'houzez' ),
            'subtitle' => esc_html__( 'Enable or disable images gallery for grid/list', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),*/
        array(
            'id'       => 'disable_compare',
            'type'     => 'switch',
            'title'    => esc_html__( 'Compare Buttom', 'houzez' ),
            'subtitle' => esc_html__( 'Enable or disable the compare button on the listing page', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'disable_favorite',
            'type'     => 'switch',
            'title'    => esc_html__( 'Add To Favorite Button', 'houzez' ),
            'subtitle' => esc_html__( 'Enable or disable the add to favorite button on the listing page', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'disable_preview',
            'type'     => 'switch',
            'title'    => esc_html__( 'Preview Button', 'houzez' ),
            'subtitle' => esc_html__( 'Enable or disable the preview button on the listing grid', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'disable_address',
            'type'     => 'switch',
            'title'    => esc_html__( 'Address', 'houzez' ),
            'subtitle' => esc_html__( 'Enable or disable address on listing grids and detail page', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'disable_agent',
            'type'     => 'switch',
            'title'    => esc_html__( 'Agent Name', 'houzez' ),
            'subtitle' => esc_html__( 'Enable or disable the agent name on the listing page', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'disable_date',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Date', 'houzez' ),
            'subtitle' => esc_html__( 'Enable or disable the property date on the listing page', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'disable_detail_btn',
            'type'     => 'switch',
            'title'    => esc_html__( 'Details Button', 'houzez' ),
            'subtitle' => esc_html__( 'Enable or disable the detail button on the listing page', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'disable_type',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Type', 'houzez' ),
            'subtitle' => esc_html__( 'It shows only for the listing page v1, v4 and v5', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the property type on the listing page (It shows only for the listing page v1, v4 and v5)', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'disable_status',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Status', 'houzez' ),
            'subtitle' => esc_html__( 'Enable or disable the property status for grids', 'houzez' ),
            'desc'     => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        array(
            'id'       => 'disable_label',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Label', 'houzez' ),
            'subtitle' => esc_html__( 'Enable or disable the property label for grids', 'houzez' ),
            'desc'     => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enable', 'houzez' ),
            'off'      => esc_html__( 'Disable', 'houzez' ),
        ),
        
    )
));

/*-------------------------------------------------------------------------------
* Builder v1, v2 and half map 
*------------------------------------------------------------------------------*/
$listing_composer = array(
    'bed' => esc_html__('Bedrooms', 'houzez'),
    'bath' => esc_html__('Bathrooms', 'houzez'),
    'area-size' => esc_html__('Area Size', 'houzez'),
);

$listing_composer_disabled = array(
    'room' => esc_html__('Rooms', 'houzez'),
    'land-area' => esc_html__('Land Area', 'houzez'),
    'garage' => esc_html__('Garage', 'houzez'),
    'property-id' => esc_html__('Property ID', 'houzez'),
);

$listing_composer_disabled = array_merge($listing_composer_disabled, $custom_fields_array);

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Composer', 'houzez' ),
    'id'     => 'lisitngs-composer',
    'desc'   => esc_html__( 'Manage list or grid view information on the listing pages', 'houzez' ),
    'subsection' => true,
    'fields'        => array(
        
        array(
            'id'      => 'listing_data_composer',
            'type'    => 'sorter',
            'title'   => 'Listing Meta Composer',
            'subtitle'    => esc_html__( 'Maximum 4 options allowed', 'houzez' ),
            'desc'    => esc_html__( 'Drag and drop layout manager, to quickly organize your grid and list meta.
', 'houzez' ),
            'options' => array(
                'enabled'  => $listing_composer,
                'disabled' => $listing_composer_disabled
            ),
        ),

        array(
            'id'      => 'listing_address_composer',
            'type'    => 'sorter',
            'title'   => 'Listing Address Composer',
            'subtitle'    => esc_html__( 'Manage address meta for list, grid and listing detail', 'houzez' ),
            'options' => array(
                'enabled'  => array(
                    'address' => esc_html__('Address', 'houzez') 
                ),
                'disabled' => array(
                    'country' => esc_html__('Country', 'houzez'),
                    'state' => esc_html__('State', 'houzez'),
                    'city' => esc_html__('City', 'houzez'),
                    'area' => esc_html__('Area', 'houzez'),
                    'streat-address' => esc_html__('Streat Address', 'houzez'),
                ),
            ),
        ),
        
        
    )
));

$custom_icon_fields = $builtin_fields = $default_fields = array();

$default_fields [] = array(
    'id'       => 'icons_type',
    'type'     => 'select',
    'title'    => esc_html__('Icons Type', 'houzez'),
    'subtitle' => '',
    'options'  => array(
        'houzez-default'   => esc_html__( 'Houzez Default Icons', 'houzez' ),
        'font-awesome'   => esc_html__( 'Fontawesome Icons v5', 'houzez' ),
        'custom'   => esc_html__( 'Custom Image Icons', 'houzez' ),
    ),
    'default'  => 'houzez-default',
);

$builtin_fields = houzez_listing_fields_for_icons();
$all_fields = array_merge($builtin_fields, $custom_fields_array);

foreach ($all_fields as $key => $icon_field) {
    $custom_icon_fields[] = array(
        'id'        => $key,
        'type'      => 'media',
        'title'     => $icon_field,
        'read-only' => false,
        'required'   => array('icons_type', '=', 'custom'),
        'subtitle'  => esc_html__( 'Upload jpg, png or svg icon', 'houzez' ),
    );
    $custom_icon_fields[] = array(
        'id'        => 'fa_'.$key,
        'type'      => 'text',
        'title'     => $icon_field,
        'required'   => array('icons_type', '=', 'font-awesome'),
        'subtitle'  => esc_html__( 'Add font awesome icon class', 'houzez' ),
    );
}


$custom_icon_fields = array_merge($default_fields, $custom_icon_fields);

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Icons', 'houzez' ),
    'id'     => 'lisitngs-composer-icons',
    'desc'   => esc_html__( 'Manage list or grid icons on the listing pages', 'houzez' ),
    'subsection' => true,
    'fields'  => $custom_icon_fields
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Meta v1 and v4', 'houzez' ),
    'id'     => 'lisitngs-meta-v1v4',
    'desc'   => esc_html__( 'Manage list or grid (grid v.1 and v.4) meta type on the listing pages', 'houzez' ),
    'subsection' => true,
    'fields'  => array(
        array(
            'id'       => 'v1_4_meta_type',
            'type'     => 'select',
            'title'    => esc_html__('Meta Type v1 and v4', 'houzez'),
            'subtitle' => esc_html__('This option only works on the list view and grid v.1 and v.4', 'houzez'),
            'desc' => esc_html__('Select meta type', 'houzez'),
            'options'  => array(
                'icons'   => esc_html__( 'Icons', 'houzez' ),
                'icons_text' => esc_html__( 'Icons + Text', 'houzez' ),
                'text'   => esc_html__( 'Text', 'houzez' ),
            ),
            'default'  => 'icons',
        )
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Meta v2', 'houzez' ),
    'id'     => 'lisitngs-meta-v2',
    'desc'   => esc_html__( 'Manage the meta type for the grid v2', 'houzez' ),
    'subsection' => true,
    'fields'  => array(
        array(
            'id'       => 'v2_meta_type',
            'type'     => 'select',
            'title'    => esc_html__('Meta Type v2', 'houzez'),
            'subtitle' => esc_html__('This option only works on the grid view v.2', 'houzez'),
            'desc' => esc_html__('Select meta type', 'houzez'),
            'options'  => array(
                'icons'   => esc_html__( 'With Icons', 'houzez' ),
                'without_icons' => esc_html__( 'Without Icons', 'houzez' ),
            ),
            'default'  => 'icons',
        )
    )
));


/*-------------------------------------------------------------------------------
* Listing Preview lightbox
*------------------------------------------------------------------------------*/
$preview_composer = array(
    'bed' => esc_html__('Bedrooms', 'houzez'),
    'bath' => esc_html__('Bathrooms', 'houzez'),
    'garage' => esc_html__('Garage', 'houzez'),
    'area-size' => esc_html__('Area Size', 'houzez'),
    'land-area' => esc_html__('Land Area', 'houzez'),
    'year-built' => esc_html__('Year Built', 'houzez')
);

$preview_composer_disabled = array('property-id' => esc_html__('Property ID', 'houzez'), 'room' => esc_html__('Rooms', 'houzez'));

$preview_composer_disabled = array_merge($preview_composer_disabled, $custom_fields_array);
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Listing Preview lightbox', 'houzez' ),
    'id'     => 'listing-preview-options',
    'desc'   => esc_html__( 'Manage listing preview information', 'houzez' ),
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'preview_meta_type',
            'type'     => 'select',
            'title'    => esc_html__('Meta Type', 'houzez'),
            'subtitle' => esc_html__('Select meta type for listing preview lightbox', 'houzez'),
            'desc' => esc_html__('Select meta type', 'houzez'),
            'options'  => array(
                'icons'   => esc_html__( 'Icons', 'houzez' ),
                'icons_text' => esc_html__( 'Icons + Text', 'houzez' ),
                'text'   => esc_html__( 'Text', 'houzez' ),
            ),
            'default'  => 'icons_text',
        ),
        array(
            'id'      => 'preview_data_composer',
            'type'    => 'sorter',
            'title'   => 'Meta Composer',
            'subtitle'    => esc_html__( 'Maximum 6 options allowed', 'houzez' ),
            'desc'    => esc_html__( 'Drag and drop layout manager, to quickly organize your preview meta.
', 'houzez' ),
            'options' => array(
                'enabled'  => $preview_composer,
                'disabled' => $preview_composer_disabled
            ),
        ),
        
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Placeholder', 'houzez' ),
    'id'     => 'lisitngs-placeholder',
    'desc'   => esc_html__( 'Manage listings default Placeholder', 'houzez' ),
    'subsection' => true,
    'fields'        => array(
        
        array(
            'id'        => 'houzez_placeholder',
            'url'       => false,
            'type'      => 'media',
            'title'     => esc_html__( 'Placeholder', 'houzez' ),
            'default'   => array( 'url' => '' ),
            'subtitle'  => esc_html__( 'Upload default placeholder. Recommended Size 1170 x 850 pixels', 'houzez' ),
            'desc'      => '',
        ),
        
        
    )
));