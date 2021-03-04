<?php
global $houzez_opt_name, $allowed_html_array;
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Translation', 'houzez' ),
    'id'     => 'labels-management',
    'desc'   => '',
    'icon'   => 'el-icon-home el-icon-small',
    'fields'        => array(
        
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Common', 'houzez' ),
    'id'     => 'common-labels',
    'desc'   => '',
    'subsection'   => true,
    'fields'        => array(
        array(
            'id'       => 'cl_common_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Common', 'houzez'),
            'subtitle' => esc_html__('Manage common strings accross site', 'houzez'),
            'indent'   => true,
        ),
        array(
            'id'       => 'cl_featured_label',
            'type'     => 'text',
            'title'    => esc_html__('Featured Label', 'houzez'),
            'desc'     => '',
            'subtitle' => '',
            'default' => 'Featured',
        ),
        array(
            'id'       => 'cl_property',
            'type'     => 'text',
            'title'    => esc_html__('Property', 'houzez'),
            'desc'     => '',
            'subtitle' => '',
            'default' => 'Property',
        ),
        array(
            'id'       => 'cl_properties',
            'type'     => 'text',
            'title'    => esc_html__('Properties', 'houzez'),
            'desc'     => '',
            'subtitle' => '',
            'default' => 'Properties',
        ),
        array(
            'id'       => 'cl_favorite',
            'type'     => 'text',
            'title'    => esc_html__('Favourite', 'houzez'),
            'desc'     => '',
            'subtitle' => '',
            'default' => 'Favourite',
        ),
        array(
            'id'       => 'cl_preview',
            'type'     => 'text',
            'title'    => esc_html__('Preview', 'houzez'),
            'desc'     => '',
            'subtitle' => '',
            'default' => 'Preview',
        ),
        array(
            'id'       => 'cl_add_compare',
            'type'     => 'text',
            'title'    => esc_html__('Add Compare', 'houzez'),
            'desc'     => '',
            'subtitle' => '',
            'default' => 'Add to Compare',
        ),
        array(
            'id'       => 'cl_remove_compare',
            'type'     => 'text',
            'title'    => esc_html__('Remove Compare', 'houzez'),
            'desc'     => '',
            'subtitle' => '',
            'default' => 'Remove from Compare',
        ),
        array(
            'id'       => 'cl_none',
            'type'     => 'text',
            'title'    => esc_html__('None Label', 'houzez'),
            'default' => 'None',
        ),
        array(
            'id'       => 'cl_select',
            'type'     => 'text',
            'title'    => esc_html__('Select Label', 'houzez'),
            'default' => 'Select',
        ),
        array(
            'id'       => 'cl_only_digits',
            'type'     => 'text',
            'title'    => esc_html__('Only digits Label', 'houzez'),
            'default' => 'Only digits',
        ),
        array(
            'id'       => 'cl_example',
            'type'     => 'text',
            'title'    => esc_html__('For Example Label', 'houzez'),
            'default' => 'For example',
        ),
        array(
            'id'       => 'cl_hide',
            'type'     => 'text',
            'title'    => esc_html__('Hide Label', 'houzez'),
            'default' => 'Hide',
        ),
        array(
            'id'       => 'cl_show',
            'type'     => 'text',
            'title'    => esc_html__('Show Label', 'houzez'),
            'default' => 'Show',
        ),
        array(
            'id'       => 'cl_yes',
            'type'     => 'text',
            'title'    => esc_html__('Yes Label', 'houzez'),
            'default' => 'Yes',
        ),
        array(
            'id'       => 'cl_no',
            'type'     => 'text',
            'title'    => esc_html__('No Label', 'houzez'),
            'default' => 'No',
        ),
        array(
            'id'       => 'cl_or',
            'type'     => 'text',
            'title'    => esc_html__('OR Label', 'houzez'),
            'default' => 'OR',
        ),
        array(
            'id'       => 'cl_select_all',
            'type'     => 'text',
            'title'    => esc_html__('Select All', 'houzez'),
            'default' => 'Select All',
        ),
        array(
            'id'       => 'cl_deselect_all',
            'type'     => 'text',
            'title'    => esc_html__('Deselect All', 'houzez'),
            'default' => 'Deselect All',
        ),
        array(
            'id'       => 'cl_no_results_matched',
            'type'     => 'text',
            'title'    => esc_html__('No results matched', 'houzez'),
            'default' => 'No results matched',
        ),
        array(
            'id'       => 'cl_common_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Searches', 'houzez' ),
    'id'     => 'searches-labels',
    'desc'   => '',
    'subsection'   => true,
    'fields'        => array(
        array(
            'id'       => 'srh_labels_section-start',
            'type'     => 'section',
            'title'    => '',
            'subtitle' => esc_html__('Manage labels for searches accross the site', 'houzez'),
            'indent'   => true,
        ),

        array(
            'id'       => 'srh_item_selected',
            'type'     => 'text',
            'title'    => esc_html__('items selected', 'houzez'),
            'default' => 'items selected',
        ),
        array(
            'id'       => 'srh_any',
            'type'     => 'text',
            'title'    => esc_html__('Any', 'houzez'),
            'default' => 'Any',
        ),
        array(
            'id'       => 'srh_keyword',
            'type'     => 'text',
            'title'    => esc_html__('Keyword', 'houzez'),
            'default' => 'Enter Keyword...',
        ),
        array(
            'id'       => 'srh_address',
            'type'     => 'text',
            'title'    => esc_html__('Address, town, street, zip or property ID', 'houzez'),
            'default' => 'Enter an address, town, street, zip or property ID',
        ),

        array(
            'id'       => 'srh_csa',
            'type'     => 'text',
            'title'    => esc_html__('City, State or Area', 'houzez'),
            'default' => 'Search City, State or Area',
        ),
        array(
            'id'       => 'srh_location',
            'type'     => 'text',
            'title'    => esc_html__('Location', 'houzez'),
            'default' => 'Location',
        ),
        array(
            'id'       => 'srh_radius',
            'type'     => 'text',
            'title'    => esc_html__('Radius', 'houzez'),
            'default' => 'Radius',
        ),
        array(
            'id'       => 'srh_type',
            'type'     => 'text',
            'title'    => esc_html__('Type', 'houzez'),
            'default' => 'Type',
        ),
        array(
            'id'       => 'srh_types',
            'type'     => 'text',
            'title'    => esc_html__('types selected', 'houzez'),
            'default' => 'types selected',
        ),
        array(
            'id'       => 'srh_status',
            'type'     => 'text',
            'title'    => esc_html__('Status', 'houzez'),
            'default' => 'Status',
        ),
        array(
            'id'       => 'srh_statuses',
            'type'     => 'text',
            'title'    => esc_html__('statuses selected', 'houzez'),
            'default' => 'status selected',
        ),
        array(
            'id'       => 'srh_label',
            'type'     => 'text',
            'title'    => esc_html__('Label', 'houzez'),
            'default' => 'Label',
        ),
        array(
            'id'       => 'srh_labels',
            'type'     => 'text',
            'title'    => esc_html__('Labels', 'houzez'),
            'default' => 'Labels',
        ),

        array(
            'id'       => 'srh_all_status',
            'type'     => 'text',
            'title'    => esc_html__('All Status', 'houzez'),
            'default' => 'All Status',
        ),
        array(
            'id'       => 'srh_bedrooms',
            'type'     => 'text',
            'title'    => esc_html__('Bedrooms', 'houzez'),
            'default' => 'Bedrooms',
        ),
        array(
            'id'       => 'srh_studio',
            'type'     => 'text',
            'title'    => esc_html__('Studio', 'houzez'),
            'default' => 'Studio',
        ),
        array(
            'id'       => 'srh_rooms',
            'type'     => 'text',
            'title'    => esc_html__('Rooms', 'houzez'),
            'default' => 'Rooms',
        ),
        array(
            'id'       => 'srh_bathrooms',
            'type'     => 'text',
            'title'    => esc_html__('Bathrooms', 'houzez'),
            'default' => 'Bathrooms',
        ),
        array(
            'id'       => 'srh_beds',
            'type'     => 'text',
            'title'    => esc_html__('Beds', 'houzez'),
            'default' => 'Beds',
        ),
        array(
            'id'       => 'srh_baths',
            'type'     => 'text',
            'title'    => esc_html__('Baths', 'houzez'),
            'default' => 'Baths',
        ),
        array(
            'id'       => 'srh_min_area',
            'type'     => 'text',
            'title'    => esc_html__('Min Area', 'houzez'),
            'default' => 'Min. Area',
        ),
        array(
            'id'       => 'srh_max_area',
            'type'     => 'text',
            'title'    => esc_html__('Max Area', 'houzez'),
            'default' => 'Max. Area',
        ),
        array(
            'id'       => 'srh_min_land_area',
            'type'     => 'text',
            'title'    => esc_html__('Min Land Area', 'houzez'),
            'default' => 'Min. Land Area',
        ),
        array(
            'id'       => 'srh_max_land_area',
            'type'     => 'text',
            'title'    => esc_html__('Max Land Area', 'houzez'),
            'default' => 'Max. Land Area',
        ),
        array(
            'id'       => 'srh_min_price',
            'type'     => 'text',
            'title'    => esc_html__('Min Price', 'houzez'),
            'default' => 'Min. Price',
        ),
        array(
            'id'       => 'srh_max_price',
            'type'     => 'text',
            'title'    => esc_html__('Max Price', 'houzez'),
            'default' => 'Max. Price',
        ),
        array(
            'id'       => 'srh_price',
            'type'     => 'text',
            'title'    => esc_html__('Price', 'houzez'),
            'default' => 'Price',
        ),
        array(
            'id'       => 'srh_price_range',
            'type'     => 'text',
            'title'    => esc_html__('Price Range', 'houzez'),
            'default' => 'Price Range',
        ),
        array(
            'id'       => 'srh_from',
            'type'     => 'text',
            'title'    => esc_html__('From', 'houzez'),
            'default' => 'From',
        ),
        array(
            'id'       => 'srh_to',
            'type'     => 'text',
            'title'    => esc_html__('To', 'houzez'),
            'default' => 'To',
        ),
        array(
            'id'       => 'srh_prop_id',
            'type'     => 'text',
            'title'    => esc_html__('Property ID', 'houzez'),
            'default' => 'Property ID',
        ),
        array(
            'id'       => 'srh_countries',
            'type'     => 'text',
            'title'    => esc_html__('All Countries', 'houzez'),
            'default' => 'All Countries',
        ),
        array(
            'id'       => 'srh_states',
            'type'     => 'text',
            'title'    => esc_html__('All States', 'houzez'),
            'default' => 'All States',
        ),
        array(
            'id'       => 'srh_cities',
            'type'     => 'text',
            'title'    => esc_html__('All Cities', 'houzez'),
            'default' => 'All Cities',
        ),
        array(
            'id'       => 'srh_areas',
            'type'     => 'text',
            'title'    => esc_html__('All Areas', 'houzez'),
            'default' => 'All Areas',
        ),
        array(
            'id'       => 'srh_areass',
            'type'     => 'text',
            'title'    => esc_html__('Areas Selected', 'houzez'),
            'default' => 'areas selected',
        ),

        array(
            'id'       => 'srh_garage',
            'type'     => 'text',
            'title'    => esc_html__('Garage', 'houzez'),
            'default' => 'Garage',
        ),

        array(
            'id'       => 'srh_year_built',
            'type'     => 'text',
            'title'    => esc_html__('Year Built', 'houzez'),
            'default' => 'Year Built',
        ),

        array(
            'id'       => 'srh_currency',
            'type'     => 'text',
            'title'    => esc_html__('Currency', 'houzez'),
            'default' => 'Currency',
        ),

        array(
            'id'       => 'srh_other_features',
            'type'     => 'text',
            'title'    => esc_html__('Other Features', 'houzez'),
            'default' => 'Other Features',
        ),

        array(
            'id'       => 'srh_btn_adv',
            'type'     => 'text',
            'title'    => esc_html__('Advanced Button', 'houzez'),
            'default' => 'Advanced',
        ),
        array(
            'id'       => 'srh_btn_search',
            'type'     => 'text',
            'title'    => esc_html__('Search Button', 'houzez'),
            'default' => 'Search',
        ),
        array(
            'id'       => 'srh_btn_go',
            'type'     => 'text',
            'title'    => esc_html__('Go Button', 'houzez'),
            'default' => 'Go',
        ),
        array(
            'id'       => 'srh_btn_save_search',
            'type'     => 'text',
            'title'    => esc_html__('Save Search Button', 'houzez'),
            'default' => 'Save Search',
        ),

        array(
            'id'       => 'srh_dock_title',
            'type'     => 'text',
            'title'    => esc_html__('Dock Search Main Title', 'houzez'),
            'default' => 'Advanced Search',
        ),

        array(
            'id'       => 'srh_mobile_title',
            'type'     => 'text',
            'title'    => esc_html__('Mobile Search Placeholder', 'houzez'),
            'default' => 'Search',
        ),

        array(
            'id'       => 'srh_btn_more',
            'type'     => 'text',
            'title'    => esc_html__('More Options Button', 'houzez'),
            'default' => 'More Options',
        ),
        array(
            'id'       => 'srh_clear',
            'type'     => 'text',
            'title'    => esc_html__('Clear', 'houzez'),
            'default' => 'Clear',
        ),
        array(
            'id'       => 'srh_apply',
            'type'     => 'text',
            'title'    => esc_html__('Apply', 'houzez'),
            'default' => 'Apply',
        ),

        array(
            'id'       => 'srh_labels_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Grid, List, Card & Preview', 'houzez' ),
    'id'     => 'glcp-translation',
    'desc'   => esc_html__( 'Manage titles for listings Grid, List, Card and Preview views', 'houzez' ),
    'subsection'   => true,
    'fields'        => array(
        
        /*--------------------------------------------------------------
        * Grid, list, card and preview
        **------------------------------------------------------------*/
        array(
            'id'       => 'cl_glcp_section-start',
            'type'     => 'section',
            'indent'   => true,
        ),

        array(
            'id'       => 'glc_bedroom',
            'type'     => 'text',
            'title'    => esc_html__('Bedroom Label', 'houzez'),
            'default' => 'Bedroom',
        ),
        array(
            'id'       => 'glc_bedrooms',
            'type'     => 'text',
            'title'    => esc_html__('Bedrooms Label', 'houzez'),
            'default' => 'Bedrooms',
        ),
        array(
            'id'       => 'glc_bathroom',
            'type'     => 'text',
            'title'    => esc_html__('Bathroom Label', 'houzez'),
            'default' => 'Bathroom',
        ),
        array(
            'id'       => 'glc_bathrooms',
            'type'     => 'text',
            'title'    => esc_html__('Bathrooms Label', 'houzez'),
            'default' => 'Bathrooms',
        ),
        array(
            'id'       => 'glc_bed',
            'type'     => 'text',
            'title'    => esc_html__('Bed Label', 'houzez'),
            'default' => 'Bed',
        ),
        array(
            'id'       => 'glc_beds',
            'type'     => 'text',
            'title'    => esc_html__('Beds Label', 'houzez'),
            'default' => 'Beds',
        ),
        array(
            'id'       => 'glc_room',
            'type'     => 'text',
            'title'    => esc_html__('Room Label', 'houzez'),
            'default' => 'Room',
        ),
        array(
            'id'       => 'glc_rooms',
            'type'     => 'text',
            'title'    => esc_html__('Rooms Label', 'houzez'),
            'default' => 'Rooms',
        ),
        array(
            'id'       => 'glc_bath',
            'type'     => 'text',
            'title'    => esc_html__('Bath Label', 'houzez'),
            'default' => 'Bath',
        ),
        array(
            'id'       => 'glc_baths',
            'type'     => 'text',
            'title'    => esc_html__('Baths Label', 'houzez'),
            'default' => 'Baths',
        ),
        array(
            'id'       => 'glc_garage',
            'type'     => 'text',
            'title'    => esc_html__('Garage Label', 'houzez'),
            'default' => 'Garage',
        ),
        array(
            'id'       => 'glc_garages',
            'type'     => 'text',
            'title'    => esc_html__('Garages Label', 'houzez'),
            'default' => 'Garages',
        ),
        array(
            'id'       => 'glc_year_built',
            'type'     => 'text',
            'title'    => esc_html__('Year Built Label', 'houzez'),
            'default' => 'Year Built',
        ),
        array(
            'id'       => 'glc_id',
            'type'     => 'text',
            'title'    => esc_html__('ID Label', 'houzez'),
            'default' => 'ID',
        ),
        array(
            'id'       => 'glc_listing_id',
            'type'     => 'text',
            'title'    => esc_html__('Listing ID Label', 'houzez'),
            'default' => 'Listing ID',
        ),
        array(
            'id'       => 'glc_detail_btn',
            'type'     => 'text',
            'title'    => esc_html__('Details Button Label', 'houzez'),
            'default' => 'Details',
        ),
        array(
            'id'       => 'cl_glcp_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),
        
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Property Detail Page', 'houzez' ),
    'id'     => 'property-details-labels',
    'desc'   => esc_html__( 'Manage titles for property detail page.', 'houzez' ),
    'subsection'   => true,
    'fields'        => array(
        
        /*--------------------------------------------------------------
        * Property detail and create listing section titles
        **------------------------------------------------------------*/
        array(
            'id'       => 'sp_sections_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Sections Titles', 'houzez'),
            'subtitle' => esc_html__('Manage Single Property page section titles', 'houzez'),
            'indent'   => true,
        ),

        array(
            'id'       => 'sps_overview',
            'type'     => 'text',
            'title'    => esc_html__('Overview title', 'houzez'),
            'default' => 'Overview',
        ),

        array(
            'id'       => 'sps_description',
            'type'     => 'text',
            'title'    => esc_html__('Description title', 'houzez'),
            'default' => 'Description',
        ),

        array(
            'id'       => 'sps_documents',
            'type'     => 'text',
            'title'    => esc_html__('Property Documents title', 'houzez'),
            'default' => 'Property Documents',
        ),

        array(
            'id'       => 'sps_details',
            'type'     => 'text',
            'title'    => esc_html__('Details title', 'houzez'),
            'default' => 'Details',
        ),
        array(
            'id'       => 'sps_additional_details',
            'type'     => 'text',
            'title'    => esc_html__('Additional details title', 'houzez'),
            'default' => 'Additional details',
        ),
        array(
            'id'       => 'sps_address',
            'type'     => 'text',
            'title'    => esc_html__('Address title', 'houzez'),
            'default' => 'Address',
        ),
        array(
            'id'       => 'sps_features',
            'type'     => 'text',
            'title'    => esc_html__('Features title', 'houzez'),
            'default' => 'Features',
        ),
        array(
            'id'       => 'sps_video',
            'type'     => 'text',
            'title'    => esc_html__('Video title', 'houzez'),
            'default' => 'Video',
        ),
        array(
            'id'       => 'sps_virtual_tour',
            'type'     => 'text',
            'title'    => esc_html__('360° Virtual Tour title', 'houzez'),
            'default' => '360° Virtual Tour',
        ),

        array(
            'id'       => 'sps_sub_listings',
            'type'     => 'text',
            'title'    => esc_html__('Sub listings title', 'houzez'),
            'default' => 'Sub listings',
        ),
        array(
            'id'       => 'sps_energy_class',
            'type'     => 'text',
            'title'    => esc_html__('Energy Class title', 'houzez'),
            'default' => 'Energy Class',
        ),
        array(
            'id'       => 'sps_floor_plans',
            'type'     => 'text',
            'title'    => esc_html__('Floor Plans title', 'houzez'),
            'default' => 'Floor Plans',
        ),
        array(
            'id'       => 'sps_calculator',
            'type'     => 'text',
            'title'    => esc_html__('Mortgage Calculator title', 'houzez'),
            'default' => 'Mortgage Calculator',
        ),
        array(
            'id'       => 'sps_walkscore',
            'type'     => 'text',
            'title'    => esc_html__('Walkscore title', 'houzez'),
            'default' => 'Walkscore',
        ),
        array(
            'id'       => 'sps_nearby',
            'type'     => 'text',
            'title'    => esc_html__("What's Nearby? title", 'houzez'),
            'default' => "What's Nearby?",
        ),
        array(
            'id'       => 'sps_schedule_tour',
            'type'     => 'text',
            'title'    => esc_html__("Schedule a Tour title", 'houzez'),
            'default' => "Schedule a Tour",
        ),

        array(
            'id'       => 'sps_contact',
            'type'     => 'text',
            'title'    => esc_html__("Contact title", 'houzez'),
            'default' => "Contact",
        ),

        array(
            'id'       => 'sps_contact_info',
            'type'     => 'text',
            'title'    => esc_html__("Contact Information title", 'houzez'),
            'default' => "Contact Information",
        ),

        array(
            'id'       => 'sps_your_info',
            'type'     => 'text',
            'title'    => esc_html__("Your information title", 'houzez'),
            'default' => "Your information",
        ),

        array(
            'id'       => 'sps_propperty_enqry',
            'type'     => 'text',
            'title'    => esc_html__("Enquire About This Property title", 'houzez'),
            'default' => "Enquire About This Property",
        ),

        array(
            'id'       => 'sps_reviews',
            'type'     => 'text',
            'title'    => esc_html__("Reviews title", 'houzez'),
            'default' => "Reviews",
        ),
        array(
            'id'       => 'sps_similar_listings',
            'type'     => 'text',
            'title'    => esc_html__("Similar Listings title", 'houzez'),
            'default' => "Similar Listings",
        ),

        array(
            'id'       => 'sp_sections_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),
        /*------------------------------- Detail page labels ---------------------------------------*/
        array(
            'id'       => 'sp_labels_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Property Detail Labels', 'houzez'),
            'subtitle' => esc_html__('Manage property detail page labels', 'houzez'),
            'indent'   => true,
        ),

        array(
            'id'       => 'spl_prop_id',
            'type'     => 'text',
            'title'    => esc_html__("Property ID", 'houzez'),
            'default' => "Property ID",
        ),
        array(
            'id'       => 'spl_price',
            'type'     => 'text',
            'title'    => esc_html__('Price', 'houzez'),
            'default' => "Price",
        ),

        array(
            'id'       => 'spl_prop_type',
            'type'     => 'text',
            'title'    => esc_html__("Property Type", 'houzez'),
            'default' => "Property Type",
        ),
        array(
            'id'       => 'spl_prop_status',
            'type'     => 'text',
            'title'    => esc_html__("Property Status", 'houzez'),
            'default' => "Property Status",
        ),
        array(
            'id'       => 'spl_prop_size',
            'type'     => 'text',
            'title'    => esc_html__("Property Size", 'houzez'),
            'default' => "Property Size",
        ),
        array(
            'id'       => 'spl_land',
            'type'     => 'text',
            'title'    => esc_html__("Land Area", 'houzez'),
            'default' => "Land Area",
        ),
        array(
            'id'       => 'spl_room',
            'type'     => 'text',
            'title'    => esc_html__('Room Label', 'houzez'),
            'default' => 'Room',
        ),
        array(
            'id'       => 'spl_rooms',
            'type'     => 'text',
            'title'    => esc_html__('Rooms Label', 'houzez'),
            'default' => 'Rooms',
        ),
        array(
            'id'       => 'spl_bedroom',
            'type'     => 'text',
            'title'    => esc_html__('Bedroom Label', 'houzez'),
            'default' => 'Bedroom',
        ),
        array(
            'id'       => 'spl_bedrooms',
            'type'     => 'text',
            'title'    => esc_html__('Bedrooms Label', 'houzez'),
            'default' => 'Bedrooms',
        ),
        array(
            'id'       => 'spl_bathroom',
            'type'     => 'text',
            'title'    => esc_html__('Bathroom Label', 'houzez'),
            'default' => 'Bathroom',
        ),
        array(
            'id'       => 'spl_bathrooms',
            'type'     => 'text',
            'title'    => esc_html__('Bathrooms Label', 'houzez'),
            'default' => 'Bathrooms',
        ),
        array(
            'id'       => 'spl_garage',
            'type'     => 'text',
            'title'    => esc_html__('Garage Label', 'houzez'),
            'default' => 'Garage',
        ),
        array(
            'id'       => 'spl_garages',
            'type'     => 'text',
            'title'    => esc_html__('Garages Label', 'houzez'),
            'default' => 'Garages',
        ),
        array(
            'id'       => 'spl_garage_size',
            'type'     => 'text',
            'title'    => esc_html__('Garage Size Label', 'houzez'),
            'default' => 'Garage Size',
        ),
        array(
            'id'       => 'spl_year_built',
            'type'     => 'text',
            'title'    => esc_html__('Year Built Label', 'houzez'),
            'default' => 'Year Built',
        ),
        array(
            'id'       => 'spl_lot',
            'type'     => 'text',
            'title'    => esc_html__('Lot', 'houzez'),
            'default' => 'Lot',
        ),
        array(
            'id'       => 'spl_ogm',
            'type'     => 'text',
            'title'    => esc_html__('Open on Google Maps', 'houzez'),
            'default' => 'Open on Google Maps',
        ),

        array(
            'id'       => 'spl_address',
            'type'     => 'text',
            'title'    => esc_html__('Address Label', 'houzez'),
            'default' => 'Address',
        ),
        array(
            'id'       => 'spl_zip',
            'type'     => 'text',
            'title'    => esc_html__('Zip/Postal Code Label', 'houzez'),
            'default' => 'Zip/Postal Code',
        ),
        array(
            'id'       => 'spl_country',
            'type'     => 'text',
            'title'    => esc_html__('Country Label', 'houzez'),
            'default' => 'Country',
        ),
        array(
            'id'       => 'spl_state',
            'type'     => 'text',
            'title'    => esc_html__('State/county Label', 'houzez'),
            'default' => 'State/county',
        ),
        array(
            'id'       => 'spl_city',
            'type'     => 'text',
            'title'    => esc_html__('City Label', 'houzez'),
            'default' => 'City',
        ),
        array(
            'id'       => 'spl_area',
            'type'     => 'text',
            'title'    => esc_html__('Area Label', 'houzez'),
            'default' => 'Area',
        ),

        array(
            'id'       => 'sp_labels_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),

        array(
            'id'       => 'sp_agent_forms_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Contact Forms', 'houzez'),
            'subtitle' => esc_html__('Manage labels for agent contact forms and schedule tour', 'houzez'),
            'indent'   => true,
        ),

        array(
            'id'       => 'spl_con_name',
            'type'     => 'text',
            'title'    => esc_html__("Name", 'houzez'),
            'default' => "Name",
        ),
        array(
            'id'       => 'spl_con_name_plac',
            'type'     => 'text',
            'title'    => esc_html__("Name Placeholder", 'houzez'),
            'default' => "Enter your name",
        ),

        array(
            'id'       => 'spl_con_phone',
            'type'     => 'text',
            'title'    => esc_html__("Phone", 'houzez'),
            'default' => "Phone",
        ),
        array(
            'id'       => 'spl_con_phone_plac',
            'type'     => 'text',
            'title'    => esc_html__("Phone Placeholder", 'houzez'),
            'default' => "Enter your Phone",
        ),

        array(
            'id'       => 'spl_con_email',
            'type'     => 'text',
            'title'    => esc_html__("Email", 'houzez'),
            'default' => "Email",
        ),
        array(
            'id'       => 'spl_con_email_plac',
            'type'     => 'text',
            'title'    => esc_html__("Email Placeholder", 'houzez'),
            'default' => "Enter your email",
        ),

        array(
            'id'       => 'spl_con_message',
            'type'     => 'text',
            'title'    => esc_html__("Message", 'houzez'),
            'default' => "Message",
        ),
        array(
            'id'       => 'spl_con_message_plac',
            'type'     => 'text',
            'title'    => esc_html__("Message Placeholder", 'houzez'),
            'default' => "Enter your Message",
        ),

        array(
            'id'       => 'spl_con_interested',
            'type'     => 'text',
            'title'    => esc_html__("Message Default Prefix", 'houzez'),
            'default' => "Hello, I am interested in",
        ),

        array(
            'id'       => 'spl_con_usertype',
            'type'     => 'text',
            'title'    => esc_html__("I'm a", 'houzez'),
            'default' => "I'm a",
        ),
        
        array(
            'id'       => 'spl_con_select',
            'type'     => 'text',
            'title'    => esc_html__("Select", 'houzez'),
            'default' => "Select",
        ),

        array(
            'id'       => 'spl_con_buyer',
            'type'     => 'text',
            'title'    => esc_html__("I'm a buyer", 'houzez'),
            'default' => "I'm a buyer",
        ),

        array(
            'id'       => 'spl_con_tennant',
            'type'     => 'text',
            'title'    => esc_html__("I'm a tennant", 'houzez'),
            'default' => "I'm a tennant",
        ),

        array(
            'id'       => 'spl_con_agent',
            'type'     => 'text',
            'title'    => esc_html__("I'm an agent", 'houzez'),
            'default' => "I'm an agent",
        ),

        array(
            'id'       => 'spl_con_other',
            'type'     => 'text',
            'title'    => esc_html__("Other", 'houzez'),
            'default' => "Other",
        ),

        array(
            'id'       => 'spl_con_view_listings',
            'type'     => 'text',
            'title'    => esc_html__("View Listings link", 'houzez'),
            'default' => "View Listings",
        ),

        array(
            'id'       => 'spl_con_tour_type',
            'type'     => 'text',
            'title'    => esc_html__("Tour Type", 'houzez'),
            'default' => "Tour Type",
        ),
        array(
            'id'       => 'spl_con_in_person',
            'type'     => 'text',
            'title'    => esc_html__("In Person", 'houzez'),
            'default' => "In Person",
        ),
        array(
            'id'       => 'spl_con_video_chat',
            'type'     => 'text',
            'title'    => esc_html__("Video Chat", 'houzez'),
            'default' => "Video Chat",
        ),
        array(
            'id'       => 'spl_con_date',
            'type'     => 'text',
            'title'    => esc_html__("Date", 'houzez'),
            'default' => "Date",
        ),
        array(
            'id'       => 'spl_con_date_plac',
            'type'     => 'text',
            'title'    => esc_html__("Date Placeholder", 'houzez'),
            'default' => "Select tour date",
        ),

        array(
            'id'       => 'spl_con_time',
            'type'     => 'text',
            'title'    => esc_html__("Time", 'houzez'),
            'default' => "Time",
        ),

        array(
            'id'       => 'spl_btn_send',
            'type'     => 'text',
            'title'    => esc_html__("Send Email Button", 'houzez'),
            'default' => "Send Email",
        ),
        array(
            'id'       => 'spl_btn_call',
            'type'     => 'text',
            'title'    => esc_html__("Call Button", 'houzez'),
            'default' => "Call",
        ),

        array(
            'id'       => 'spl_btn_message',
            'type'     => 'text',
            'title'    => esc_html__("Send Message Button", 'houzez'),
            'default' => "Send Message",
        ),

        array(
            'id'       => 'spl_btn_request_info',
            'type'     => 'text',
            'title'    => esc_html__("Request Information Button", 'houzez'),
            'default' => "Request Information",
        ),
        array(
            'id'       => 'spl_btn_tour_sch',
            'type'     => 'text',
            'title'    => esc_html__("Submit a Tour Request Button", 'houzez'),
            'default' => "Submit a Tour Request",
        ),

        array(
            'id'       => 'spl_sub_agree',
            'type'     => 'text',
            'title'    => esc_html__("By submitting this form I agree to", 'houzez'),
            'default' => "By submitting this form I agree to",
        ),

        array(
            'id'       => 'spl_term',
            'type'     => 'text',
            'title'    => esc_html__("Terms of Use", 'houzez'),
            'default' => "Terms of Use",
        ),

        array(
            'id'       => 'agent_forms_terms_validation',
            'type'     => 'text',
            'title'    => esc_html__( 'Terms of Use Checkbox Validation Message', 'houzez' ),
            'subtitle' => '',
            'default'  => 'Please accept terms of use'
        ),

        array(
            'id'       => 'sp_agent_forms_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),

        /*------------------------------------------- Energy Detail page -------------------------*/
        array(
            'id'       => 'sp_energy_labels_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Energy Class', 'houzez'),
            'subtitle' => esc_html__('Manage labels for energy class section', 'houzez'),
            'indent'   => true,
        ),

        array(
            'id'       => 'spl_energetic_cls',
            'type'     => 'text',
            'title'    => esc_html__("Energetic class", 'houzez'),
            'default' => "Energetic class",
        ),
        
        array(
            'id'       => 'spl_energy_index',
            'type'     => 'text',
            'title'    => esc_html__("Global Energy Performance Index", 'houzez'),
            'default' => "Global Energy Performance Index",
        ),
       
        array(
            'id'       => 'spl_energy_renew_index',
            'type'     => 'text',
            'title'    => esc_html__("Renewable energy performance index", 'houzez'),
            'default' => "Renewable energy performance index",
        ),
        

        array(
            'id'       => 'spl_energy_build_performance',
            'type'     => 'text',
            'title'    => esc_html__("Energy performance of the building", 'houzez'),
            'default' => "Energy performance of the building",
        ),
        

        array(
            'id'       => 'spl_energy_ecp_rating',
            'type'     => 'text',
            'title'    => esc_html__("EPC Current Rating", 'houzez'),
            'default' => "EPC Current Rating",
        ),
    
        array(
            'id'       => 'spl_energy_ecp_p',
            'type'     => 'text',
            'title'    => esc_html__("EPC Potential Rating", 'houzez'),
            'default' => "EPC Potential Rating",
        ),
        array(
            'id'       => 'spl_energy_cls',
            'type'     => 'text',
            'title'    => esc_html__("Energy class", 'houzez'),
            'default' => "Energy class",
        ),
        
        array(
            'id'       => 'sp_energy_labels_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),

        /*------------------------------------------- Mortgage Calculator -------------------------*/
        array(
            'id'       => 'sp_mortgage_cal_labels_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Mortgage Calculator', 'houzez'),
            'subtitle' => esc_html__('Manage labels for mortgage calculator section', 'houzez'),
            'indent'   => true,
        ),

        array(
            'id'       => 'spc_principal_ints',
            'type'     => 'text',
            'title'    => esc_html__("Principal & Interest", 'houzez'),
            'default' => "Principal & Interest",
        ),

        array(
            'id'       => 'spc_prop_tax',
            'type'     => 'text',
            'title'    => esc_html__("Property Tax", 'houzez'),
            'default' => "Property Tax",
        ),
        array(
            'id'       => 'spc_hi',
            'type'     => 'text',
            'title'    => esc_html__("Home Insurance", 'houzez'),
            'default' => "Home Insurance",
        ),
        array(
            'id'       => 'spc_pmi',
            'type'     => 'text',
            'title'    => esc_html__("PMI", 'houzez'),
            'default' => "PMI",
        ),
        array(
            'id'       => 'spc_total_amt',
            'type'     => 'text',
            'title'    => esc_html__("Total Amount", 'houzez'),
            'default' => "Total Amount",
        ),
        array(
            'id'       => 'spc_down_payment',
            'type'     => 'text',
            'title'    => esc_html__("Down Payment", 'houzez'),
            'default' => "Down Payment",
        ),
        array(
            'id'       => 'spc_ir',
            'type'     => 'text',
            'title'    => esc_html__("Interest Rate", 'houzez'),
            'default' => "Interest Rate",
        ),

        array(
            'id'       => 'spc_load_term',
            'type'     => 'text',
            'title'    => esc_html__("Loan Term", 'houzez'),
            'default' => "Loan Terms (Years)",
        ),

        array(
            'id'       => 'spc_monthly',
            'type'     => 'text',
            'title'    => esc_html__("Monthly", 'houzez'),
            'default' => "Monthly",
        ),
        array(
            'id'       => 'spc_btn_cal',
            'type'     => 'text',
            'title'    => esc_html__("Calculate Button", 'houzez'),
            'default' => "Calculate",
        ),
        
        
        array(
            'id'       => 'sp_mortgage_cal_labels_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),
        
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Add New Property', 'houzez' ),
    'id'     => 'createlisting-translation',
    'desc'   => '',
    'subsection'   => true,
    'fields'        => array(
        
        array(
            'id'       => 'cl_buttons_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Buttons and links', 'houzez'),
            'subtitle' => esc_html__('Manage buttons and links titles front-end', 'houzez'),
            'indent'   => true,
        ),

        array(
            'id'       => 'fal_submit_property',
            'type'     => 'text',
            'title'    => esc_html__('Submit Property', 'houzez'),
            'default' => 'Submit Property',
        ),

        array(
            'id'       => 'fal_save_draft',
            'type'     => 'text',
            'title'    => esc_html__('Save as Draft', 'houzez'),
            'default' => 'Save as Draft',
        ),

        array(
            'id'       => 'fal_save_changes',
            'type'     => 'text',
            'title'    => esc_html__('Save Changes', 'houzez'),
            'default' => 'Save Changes',
        ),

        array(
            'id'       => 'fal_view_property',
            'type'     => 'text',
            'title'    => esc_html__('View Property', 'houzez'),
            'default' => 'View Property',
        ),

        array(
            'id'       => 'fal_cancel',
            'type'     => 'text',
            'title'    => esc_html__('Cancel', 'houzez'),
            'default' => 'Cancel',
        ),
        array(
            'id'       => 'fal_back',
            'type'     => 'text',
            'title'    => esc_html__('Back', 'houzez'),
            'default' => 'Back',
        ),

        array(
            'id'       => 'fal_next',
            'type'     => 'text',
            'title'    => esc_html__('Next', 'houzez'),
            'default' => 'Next',
        ),

        array(
            'id'       => 'cl_buttons_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),

        array(
            'id'       => 'cl_sections_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Sections Titles', 'houzez'),
            'subtitle' => esc_html__('Manage create listing page section titles front-end and admin', 'houzez'),
            'indent'   => true,
        ),

        array(
            'id'       => 'cls_description',
            'type'     => 'text',
            'title'    => esc_html__('Description', 'houzez'),
            'default' => 'Description',
        ),

        array(
            'id'       => 'cls_description_price',
            'type'     => 'text',
            'title'    => esc_html__('Description & Price', 'houzez'),
            'default' => 'Description & Price',
        ),

        array(
            'id'       => 'cls_price',
            'type'     => 'text',
            'title'    => esc_html__('Price', 'houzez'),
            'default' => 'Price',
        ),

        array(
            'id'       => 'cls_media',
            'type'     => 'text',
            'title'    => esc_html__('Media', 'houzez'),
            'default' => 'Media',
        ),

        array(
            'id'       => 'cls_documents',
            'type'     => 'text',
            'title'    => esc_html__('Property Documents', 'houzez'),
            'default' => 'Property Documents',
        ),

        array(
            'id'       => 'cls_details',
            'type'     => 'text',
            'title'    => esc_html__('Details', 'houzez'),
            'default' => 'Details',
        ),
        array(
            'id'       => 'cls_private_notes',
            'type'     => 'text',
            'title'    => esc_html__('Private Note', 'houzez'),
            'default' => 'Private Note',
        ),
        array(
            'id'       => 'cls_additional_details',
            'type'     => 'text',
            'title'    => esc_html__('Additional details', 'houzez'),
            'default' => 'Additional details',
        ),
        array(
            'id'       => 'cls_address',
            'type'     => 'text',
            'title'    => esc_html__('Address', 'houzez'),
            'default' => 'Address',
        ),
        array(
            'id'       => 'cls_location',
            'type'     => 'text',
            'title'    => esc_html__('Location', 'houzez'),
            'default' => 'Location',
        ),
        array(
            'id'       => 'cls_map',
            'type'     => 'text',
            'title'    => esc_html__('Map', 'houzez'),
            'default' => 'Map',
        ),
        array(
            'id'       => 'cls_features',
            'type'     => 'text',
            'title'    => esc_html__('Features', 'houzez'),
            'default' => 'Features',
        ),
        array(
            'id'       => 'cls_video',
            'type'     => 'text',
            'title'    => esc_html__('Video', 'houzez'),
            'default' => 'Video',
        ),
        array(
            'id'       => 'cls_virtual_tour',
            'type'     => 'text',
            'title'    => esc_html__('360° Virtual Tour', 'houzez'),
            'default' => '360° Virtual Tour',
        ),

        array(
            'id'       => 'cls_sub_listings',
            'type'     => 'text',
            'title'    => esc_html__('Sub listings', 'houzez'),
            'default' => 'Sub listings',
        ),
        array(
            'id'       => 'cls_energy_class',
            'type'     => 'text',
            'title'    => esc_html__('Energy Class', 'houzez'),
            'default' => 'Energy Class',
        ),
        array(
            'id'       => 'cls_floor_plans',
            'type'     => 'text',
            'title'    => esc_html__('Floor Plans', 'houzez'),
            'default' => 'Floor Plans',
        ),
        
        array(
            'id'       => 'cls_walkscore',
            'type'     => 'text',
            'title'    => esc_html__('Walkscore', 'houzez'),
            'default' => 'Walkscore',
        ),

        array(
            'id'       => 'cls_contact_info',
            'type'     => 'text',
            'title'    => esc_html__("Contact Information", 'houzez'),
            'default' => "Contact Information",
        ),

        array(
            'id'       => 'cls_information',
            'type'     => 'text',
            'title'    => esc_html__("Information", 'houzez'),
            'default' => "Information",
        ),

        array(
            'id'       => 'cls_settings',
            'type'     => 'text',
            'title'    => esc_html__("Property Settings", 'houzez'),
            'default' => "Property Settings",
        ),

        array(
            'id'       => 'cls_slider',
            'type'     => 'text',
            'title'    => esc_html__("Slider", 'houzez'),
            'default' => "Slider",
        ),

        array(
            'id'       => 'cls_layout',
            'type'     => 'text',
            'title'    => esc_html__("Layout", 'houzez'),
            'default' => "Layout",
        ),

        array(
            'id'       => 'cls_rental',
            'type'     => 'text',
            'title'    => esc_html__("Rental Details", 'houzez'),
            'default' => "Rental Details",
        ),
       
        array(
            'id'       => 'cls_gdpr',
            'type'     => 'text',
            'title'    => esc_html__("GDPR Agreement", 'houzez'),
            'default' => "GDPR Agreement *",
        ),

        array(
            'id'       => 'cl_sections_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),

        /*--------------------------------------------------------------
        * Location labels
        **------------------------------------------------------------*/
        array(
            'id'       => 'cl_location_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Fields Labels and Placeholders', 'houzez'),
            'subtitle' => '',
            'indent'   => true,
        ),

        array(
            'id'       => 'cl_prop_title',
            'type'     => 'text',
            'title'    => esc_html__("Property Title", 'houzez'),
            'default' => "Property Title",
        ),
        array(
            'id'       => 'cl_prop_title_plac',
            'type'     => 'text',
            'title'    => esc_html__("Property Title Placeholder", 'houzez'),
            'default' => "Enter your property title",
        ),
        array(
            'id'       => 'cl_content',
            'type'     => 'text',
            'title'    => esc_html__("Content", 'houzez'),
            'default' => "Content",
        ),
        
        array(
            'id'       => 'cl_prop_type',
            'type'     => 'text',
            'title'    => esc_html__("Type", 'houzez'),
            'default' => "Type",
        ),
        array(
            'id'       => 'cl_prop_types',
            'type'     => 'text',
            'title'    => esc_html__("Types", 'houzez'),
            'default' => "Types",
        ),
        array(
            'id'       => 'cl_prop_status',
            'type'     => 'text',
            'title'    => esc_html__("Status", 'houzez'),
            'default' => "Status",
        ),
        array(
            'id'       => 'cl_prop_statuses',
            'type'     => 'text',
            'title'    => esc_html__("Statuses", 'houzez'),
            'default' => "Statuses",
        ),
        array(
            'id'       => 'cl_prop_label',
            'type'     => 'text',
            'title'    => esc_html__("Label", 'houzez'),
            'default' => "Label",
        ),
        array(
            'id'       => 'cl_prop_labels',
            'type'     => 'text',
            'title'    => esc_html__("Labels", 'houzez'),
            'default' => "Labels",
        ),
        array(
            'id'       => 'cl_sale_price',
            'type'     => 'text',
            'title'    => esc_html__("Sale or Rent Price", 'houzez'),
            'default' => "Sale or Rent Price",
        ),
        array(
            'id'       => 'cl_sale_price_plac',
            'type'     => 'text',
            'title'    => esc_html__("Sale or Rent Price Placeholder", 'houzez'),
            'default' => "Enter the price",
        ),

        array(
            'id'       => 'cl_second_price',
            'type'     => 'text',
            'title'    => esc_html__("Second Price", 'houzez'),
            'default' => "Second Price (Optional)",
        ),
        array(
            'id'       => 'cl_second_price_plac',
            'type'     => 'text',
            'title'    => esc_html__("Second Price Placeholder", 'houzez'),
            'default' => "Enter the second price",
        ),
        array(
            'id'       => 'cl_price_postfix',
            'type'     => 'text',
            'title'    => esc_html__("Price Postfix", 'houzez'),
            'default' => "After The Price",
        ),
        array(
            'id'       => 'cl_price_postfix_plac',
            'type'     => 'text',
            'title'    => esc_html__("Price Postfix Placeholder", 'houzez'),
            'default' => "Enter the after price",
        ),
        array(
            'id'       => 'cl_price_postfix_tooltip',
            'type'     => 'text',
            'title'    => esc_html__("Price Postfix Tooltip", 'houzez'),
            'default' => "For example: Monthly",
        ),

        array(
            'id'       => 'cl_price_prefix',
            'type'     => 'text',
            'title'    => esc_html__("Price Prefix", 'houzez'),
            'default' => "Price Prefix",
        ),
        array(
            'id'       => 'cl_price_prefix_plac',
            'type'     => 'text',
            'title'    => esc_html__("Price Prefix Placeholder", 'houzez'),
            'default' => "Enter the price prefix",
        ),
        array(
            'id'       => 'cl_price_prefix_tooltip',
            'type'     => 'text',
            'title'    => esc_html__("Price Postfix Tooltip", 'houzez'),
            'default' => "For example: Start from",
        ),

        array(
            'id'       => 'cl_bedrooms',
            'type'     => 'text',
            'title'    => esc_html__('Bedrooms', 'houzez'),
            'default' => 'Bedrooms',
        ),
        array(
            'id'       => 'cl_bedrooms_plac',
            'type'     => 'text',
            'title'    => esc_html__('Bedrooms Placeholder', 'houzez'),
            'default' => 'Enter number of bedrooms',
        ),

        array(
            'id'       => 'cl_rooms',
            'type'     => 'text',
            'title'    => esc_html__('Rooms', 'houzez'),
            'default' => 'Rooms',
        ),
        array(
            'id'       => 'cl_rooms_plac',
            'type'     => 'text',
            'title'    => esc_html__('Rooms Placeholder', 'houzez'),
            'default' => 'Enter number of rooms',
        ),

        array(
            'id'       => 'cl_bathrooms',
            'type'     => 'text',
            'title'    => esc_html__('Bathrooms', 'houzez'),
            'default' => 'Bathrooms',
        ),

        array(
            'id'       => 'cl_bathrooms_plac',
            'type'     => 'text',
            'title'    => esc_html__('Bathrooms Placeholder', 'houzez'),
            'default' => 'Enter number of bathrooms',
        ),

        array(
            'id'       => 'cl_area_size',
            'type'     => 'text',
            'title'    => esc_html__('Area Size', 'houzez'),
            'default' => 'Area Size',
        ),

        array(
            'id'       => 'cl_area_size_plac',
            'type'     => 'text',
            'title'    => esc_html__('Area Size Placeholder', 'houzez'),
            'default' => 'Enter property area size',
        ),

        array(
            'id'       => 'cl_area_size_postfix',
            'type'     => 'text',
            'title'    => esc_html__('Size Postfix', 'houzez'),
            'default' => 'Size Postfix',
        ),

        array(
            'id'       => 'cl_area_size_postfix_plac',
            'type'     => 'text',
            'title'    => esc_html__('Size Postfix Placeholder', 'houzez'),
            'default' => 'Enter property area size postfix',
        ),

        array(
            'id'       => 'cl_area_size_postfix_tooltip',
            'type'     => 'text',
            'title'    => esc_html__('Size Postfix Tooltip', 'houzez'),
            'default' => 'For example: Sq Ft',
        ),

        array(
            'id'       => 'cl_land_size',
            'type'     => 'text',
            'title'    => esc_html__('Land Area', 'houzez'),
            'default' => 'Land Area',
        ),

        array(
            'id'       => 'cl_land_size_plac',
            'type'     => 'text',
            'title'    => esc_html__('Land Area Placeholder', 'houzez'),
            'default' => 'Enter property Land Area',
        ),

        array(
            'id'       => 'cl_land_size_postfix',
            'type'     => 'text',
            'title'    => esc_html__('Land Area Size Postfix', 'houzez'),
            'default' => 'Land Area Size Postfix',
        ),

        array(
            'id'       => 'cl_land_size_postfix_plac',
            'type'     => 'text',
            'title'    => esc_html__('Land Area Size Postfix Placeholder', 'houzez'),
            'default' => 'Enter property Land Area postfix',
        ),

        array(
            'id'       => 'cl_land_size_postfix_tooltip',
            'type'     => 'text',
            'title'    => esc_html__('Land Area Size Postfix Tooltip', 'houzez'),
            'default' => 'For example: Sq Ft',
        ),

        array(
            'id'       => 'cl_garage',
            'type'     => 'text',
            'title'    => esc_html__('Garages', 'houzez'),
            'default' => 'Garages',
        ),

        array(
            'id'       => 'cl_garage_plac',
            'type'     => 'text',
            'title'    => esc_html__('Garages Placeholder', 'houzez'),
            'default' => 'Enter number of garages',
        ),

        array(
            'id'       => 'cl_garage_size',
            'type'     => 'text',
            'title'    => esc_html__('Garage Size', 'houzez'),
            'default' => 'Garage Size',
        ),

        array(
            'id'       => 'cl_garage_size_plac',
            'type'     => 'text',
            'title'    => esc_html__('Garage Size Placeholder', 'houzez'),
            'default' => 'Enter the garage size',
        ),

        array(
            'id'       => 'cl_garage_size_tooltip',
            'type'     => 'text',
            'title'    => esc_html__('Garage Size Tooltip', 'houzez'),
            'default' => 'For example: 200 Sq Ft',
        ),

        array(
            'id'       => 'cl_year_built',
            'type'     => 'text',
            'title'    => esc_html__('Year Built', 'houzez'),
            'default' => 'Year Built',
        ),

        array(
            'id'       => 'cl_year_built_plac',
            'type'     => 'text',
            'title'    => esc_html__('Year Built Placeholder', 'houzez'),
            'default' => 'Enter year built',
        ),

        array(
            'id'       => 'cl_prop_id',
            'type'     => 'text',
            'title'    => esc_html__("Property ID", 'houzez'),
            'default' => "Property ID",
        ),
        array(
            'id'       => 'cl_prop_id_plac',
            'type'     => 'text',
            'title'    => esc_html__("Property ID Placeholder", 'houzez'),
            'default' => "Enter property ID",
        ),

        array(
            'id'       => 'cl_prop_id_tooltip',
            'type'     => 'text',
            'title'    => esc_html__("Property ID Tooltip", 'houzez'),
            'default' => "For example: HZ-01",
        ),

        array(
            'id'       => 'cl_additional_title',
            'type'     => 'text',
            'title'    => esc_html__("Additional Details Title", 'houzez'),
            'default' => "Title",
        ),
        array(
            'id'       => 'cl_additional_title_plac',
            'type'     => 'text',
            'title'    => esc_html__("Additional Details Title Placeholder", 'houzez'),
            'default' => "Eg: Equipment",
        ),

        array(
            'id'       => 'cl_additional_value',
            'type'     => 'text',
            'title'    => esc_html__("Additional Details Value", 'houzez'),
            'default' => "Value",
        ),
        array(
            'id'       => 'cl_additional_value_plac',
            'type'     => 'text',
            'title'    => esc_html__("Additional Details Value Placeholder", 'houzez'),
            'default' => "Grill - Gas",
        ),

        array(
            'id'       => 'cl_drag_drop_text_image',
            'type'     => 'text',
            'title'    => esc_html__("Drag & Drop Text", 'houzez'),
            'default' => "Drag and drop the images to customize the image gallery order.",
        ),

        array(
            'id'       => 'cl_drag_drop_title',
            'type'     => 'text',
            'title'    => esc_html__("Drag & Drop Title", 'houzez'),
            'default' => "Drag and drop the gallery images here",
        ),

        array(
            'id'       => 'cl_image_size',
            'type'     => 'text',
            'title'    => esc_html__("Image Size", 'houzez'),
            'default' => "(Minimum size 1440x900)",
        ),

        array(
            'id'       => 'cl_image_btn',
            'type'     => 'text',
            'title'    => esc_html__("Select Image Button", 'houzez'),
            'default' => "Select and Upload",
        ),

        array(
            'id'       => 'cl_image_featured',
            'type'     => 'text',
            'title'    => esc_html__("Make Featured text", 'houzez'),
            'default' => "Click on the star icon to select the cover image.",
        ),

        array(
            'id'       => 'cl_video_url',
            'type'     => 'text',
            'title'    => esc_html__("Video Url", 'houzez'),
            'default' => "Video URL",
        ),
        array(
            'id'       => 'cl_video_url_plac',
            'type'     => 'text',
            'title'    => esc_html__("Video Url Placeholder", 'houzez'),
            'default' => "YouTube, Vimeo, SWF File and MOV File are supported",
        ),

        array(
            'id'       => 'cl_energy_cls',
            'type'     => 'text',
            'title'    => esc_html__("Energy Class", 'houzez'),
            'default' => "Energy Class",
        ),
        array(
            'id'       => 'cl_energy_cls_plac',
            'type'     => 'text',
            'title'    => esc_html__("Energy Class Placeholder", 'houzez'),
            'default' => "Select Energy Class",
        ),

        array(
            'id'       => 'cl_energy_index',
            'type'     => 'text',
            'title'    => esc_html__("Global Energy Performance Index", 'houzez'),
            'default' => "Global Energy Performance Index",
        ),
        array(
            'id'       => 'cl_energy_index_plac',
            'type'     => 'text',
            'title'    => esc_html__("Global Energy Performance Index Placeholder", 'houzez'),
            'default' => "For example: 92.42 kWh / m²a",
        ),

        array(
            'id'       => 'cl_energy_renew_index',
            'type'     => 'text',
            'title'    => esc_html__("Renewable energy performance index", 'houzez'),
            'default' => "Renewable energy performance index",
        ),
        array(
            'id'       => 'cl_energy_renew_index_plac',
            'type'     => 'text',
            'title'    => esc_html__("Renewable energy performance index Placeholder", 'houzez'),
            'default' => "For example: 00.00 kWh / m²a",
        ),

        array(
            'id'       => 'cl_energy_build_performance',
            'type'     => 'text',
            'title'    => esc_html__("Energy performance of the building", 'houzez'),
            'default' => "Energy performance of the building",
        ),
        array(
            'id'       => 'cl_energy_build_performance_plac',
            'type'     => 'text',
            'title'    => esc_html__("Energy performance of the building Placeholder", 'houzez'),
            'default' => "",
        ),

        array(
            'id'       => 'cl_energy_ecp_rating',
            'type'     => 'text',
            'title'    => esc_html__("EPC Current Rating", 'houzez'),
            'default' => "EPC Current Rating",
        ),
        array(
            'id'       => 'cl_energy_ecp_rating_plac',
            'type'     => 'text',
            'title'    => esc_html__("EPC Current Rating Placeholder", 'houzez'),
            'default' => "",
        ),

        array(
            'id'       => 'cl_energy_ecp_p',
            'type'     => 'text',
            'title'    => esc_html__("EPC Potential Rating", 'houzez'),
            'default' => "EPC Potential Rating",
        ),
        array(
            'id'       => 'cl_energy_ecp_p_plac',
            'type'     => 'text',
            'title'    => esc_html__("EPC Potential Rating Placeholder", 'houzez'),
            'default' => "",
        ),

        array(
            'id'       => 'cl_virtual_plac',
            'type'     => 'text',
            'title'    => esc_html__("Virtual Tour Placeholder", 'houzez'),
            'default' => "Enter virtual tour iframe/embeded code",
        ),

        array(
            'id'       => 'cl_private_note',
            'type'     => 'text',
            'title'    => esc_html__("Private Note Label", 'houzez'),
            'default' => "Write private note for this property, it will not display for public.",
        ),

        array(
            'id'       => 'cl_private_note_plac',
            'type'     => 'text',
            'title'    => esc_html__("Private Note Placeholder", 'houzez'),
            'default' => "Enter the note here",
        ),

        array(
            'id'       => 'cl_address',
            'type'     => 'text',
            'title'    => esc_html__('Address', 'houzez'),
            'default' => 'Address',
        ),
        array(
            'id'       => 'cl_address_plac',
            'type'     => 'text',
            'title'    => esc_html__('Address Placeholder', 'houzez'),
            'default' => 'Enter your property address',
        ),
        array(
            'id'       => 'cl_zip',
            'type'     => 'text',
            'title'    => esc_html__('Zip/Postal Code', 'houzez'),
            'default' => 'Zip/Postal Code',
        ),
        array(
            'id'       => 'cl_zip_plac',
            'type'     => 'text',
            'title'    => esc_html__('Zip/Postal Code Placeholder', 'houzez'),
            'default' => 'Enter zip/postal code',
        ),
        array(
            'id'       => 'cl_country',
            'type'     => 'text',
            'title'    => esc_html__('Country', 'houzez'),
            'default' => 'Country',
        ),
        array(
            'id'       => 'cl_country_plac',
            'type'     => 'text',
            'title'    => esc_html__('Country Placeholder', 'houzez'),
            'default' => 'Enter the country',
        ),
        array(
            'id'       => 'cl_state',
            'type'     => 'text',
            'title'    => esc_html__('State/county', 'houzez'),
            'default' => 'State/county',
        ),
        array(
            'id'       => 'cl_state_plac',
            'type'     => 'text',
            'title'    => esc_html__('State/county Placeholder', 'houzez'),
            'default' => 'Enter the State/county',
        ),
        array(
            'id'       => 'cl_city',
            'type'     => 'text',
            'title'    => esc_html__('City', 'houzez'),
            'default' => 'City',
        ),
        array(
            'id'       => 'cl_city_plac',
            'type'     => 'text',
            'title'    => esc_html__('City Placeholder', 'houzez'),
            'default' => 'Enter the city',
        ),
        array(
            'id'       => 'cl_area',
            'type'     => 'text',
            'title'    => esc_html__('Area', 'houzez'),
            'default' => 'Area',
        ),
        array(
            'id'       => 'cl_area_plac',
            'type'     => 'text',
            'title'    => esc_html__('Area Placeholder', 'houzez'),
            'default' => 'Enter the area',
        ),

        array(
            'id'       => 'cl_drag_drop_text',
            'type'     => 'text',
            'title'    => esc_html__('Drag & Drop Text', 'houzez'),
            'default' => 'Drag and drop the pin on map to find exact location',
        ),

        array(
            'id'       => 'cl_latitude',
            'type'     => 'text',
            'title'    => esc_html__('Latitude', 'houzez'),
            'default' => 'Latitude',
        ),
        array(
            'id'       => 'cl_latitude_plac',
            'type'     => 'text',
            'title'    => esc_html__('Latitude Placeholder', 'houzez'),
            'default' => 'Enter address latitude',
        ),

        array(
            'id'       => 'cl_longitude',
            'type'     => 'text',
            'title'    => esc_html__('Longitude', 'houzez'),
            'default' => 'Longitude',
        ),
        array(
            'id'       => 'cl_longitude_plac',
            'type'     => 'text',
            'title'    => esc_html__('Longitude Placeholder', 'houzez'),
            'default' => 'Enter address Longitude',
        ),

        array(
            'id'       => 'cl_street_view',
            'type'     => 'text',
            'title'    => esc_html__('Street View', 'houzez'),
            'default' => 'Street View',
        ),

        array(
            'id'       => 'cl_ppbtn',
            'type'     => 'text',
            'title'    => esc_html__('Place pin buttton', 'houzez'),
            'default' => 'Place the pin in address above',
        ),

        array(
            'id'       => 'cl_streat_address',
            'type'     => 'text',
            'title'    => esc_html__("Streat Address", 'houzez'),
            'default' => "Streat Address",
        ),
        array(
            'id'       => 'cl_streat_address_plac',
            'type'     => 'text',
            'title'    => esc_html__("Streat Address Placeholder", 'houzez'),
            'default' => "Enter only the street name and the building number",
        ),

        array(
            'id'       => 'cl_make_featured',
            'type'     => 'text',
            'title'    => esc_html__("Make Featured Text", 'houzez'),
            'default' => "Do you want to mark this property as featured?",
        ),

        array(
            'id'       => 'cl_login_view',
            'type'     => 'text',
            'title'    => esc_html__("Login to view title", 'houzez'),
            'default' => "The user must be logged in to view this property?",
        ),

        array(
            'id'       => 'cl_login_view_plac',
            'type'     => 'text',
            'title'    => esc_html__("Login to view description", 'houzez'),
            'default' => 'If "Yes" then only logged in user can view property details.',
        ),

        array(
            'id'       => 'cl_disclaimer',
            'type'     => 'text',
            'title'    => esc_html__("Disclaimer", 'houzez'),
            'default' => "Disclaimer",
        ),

        array(
            'id'       => 'cl_mortgage',
            'type'     => 'text',
            'title'    => esc_html__("Mortgage Calculator", 'houzez'),
            'default' => "Mortgage Calulator",
        ),

        array(
            'id'       => 'cl_mortgage_plac',
            'type'     => 'text',
            'title'    => esc_html__("Mortgage Calulator Placeholder", 'houzez'),
            'default' => 'Show/Hide mortgage calculator for this listing?',
        ),

        array(
            'id'       => 'cl_decuments_text',
            'type'     => 'text',
            'title'    => esc_html__("Documents Text", 'houzez'),
            'default' => "You can attach PDF files, Map images OR other documents.",
        ),

        array(
            'id'       => 'cl_attachment_btn',
            'type'     => 'text',
            'title'    => esc_html__("Attachment button", 'houzez'),
            'default' => "Select Attachment.",
        ),

        array(
            'id'       => 'cl_uploaded_attachments',
            'type'     => 'text',
            'title'    => esc_html__("Uploaded Attachments", 'houzez'),
            'default' => "Uploaded Attachments",
        ),

        array(
            'id'       => 'cl_contact_info_text',
            'type'     => 'text',
            'title'    => esc_html__("Contact Info Text", 'houzez'),
            'default' => "What information do you want to display in agent data container?",
        ),
        array(
            'id'       => 'cl_author_info',
            'type'     => 'text',
            'title'    => esc_html__("Author Info", 'houzez'),
            'default' => "Author Info",
        ),

        array(
            'id'       => 'cl_agent_info',
            'type'     => 'text',
            'title'    => esc_html__("Agent Info", 'houzez'),
            'default' => "Agent Info (Choose agent from the list below)",
        ),

        array(
            'id'       => 'cl_agent_info_plac',
            'type'     => 'text',
            'title'    => esc_html__("Agent Info Placeholder", 'houzez'),
            'default' => "Select an Agent",
        ),

        array(
            'id'       => 'cl_agency_info',
            'type'     => 'text',
            'title'    => esc_html__("Agency Info", 'houzez'),
            'default' => "Agency Info (Choose agency from the list below)",
        ),

        array(
            'id'       => 'cl_agency_info2',
            'type'     => 'text',
            'title'    => esc_html__("Agency Info", 'houzez'),
            'default' => "Agency Info",
        ),

        array(
            'id'       => 'cl_agency_info_plac',
            'type'     => 'text',
            'title'    => esc_html__("Agency Info Placeholder", 'houzez'),
            'default' => "Select an Agency",
        ),

        array(
            'id'       => 'cl_not_display',
            'type'     => 'text',
            'title'    => esc_html__("Do not display", 'houzez'),
            'default' => "Do not display",
        ),

        array(
            'id'       => 'cl_add_slider',
            'type'     => 'text',
            'title'    => esc_html__("Add to Slider", 'houzez'),
            'default' => "Do you want to display this property on the custom property slider?",
        ),
        array(
            'id'       => 'cl_add_slider_plac',
            'type'     => 'text',
            'title'    => esc_html__("Add to Slider Placeholder", 'houzez'),
            'default' => "Upload an image below if you selected yes.",
        ),
        array(
            'id'       => 'cl_slider_img',
            'type'     => 'text',
            'title'    => esc_html__("Slider Image", 'houzez'),
            'default' => "Slider Image",
        ),

        array(
            'id'       => 'cl_slider_img_size',
            'type'     => 'text',
            'title'    => esc_html__("Slider Image Size", 'houzez'),
            'default' => "Suggested size 2000px x 700px",
        ),
        array(
            'id'       => 'cl_plan_title',
            'type'     => 'text',
            'title'    => esc_html__("Plan Title", 'houzez'),
            'default' => "Plan Title",
        ),

        array(
            'id'       => 'cl_plan_title_plac',
            'type'     => 'text',
            'title'    => esc_html__("Plan Title Placeholder", 'houzez'),
            'default' => "Enter the plan title",
        ),

        array(
            'id'       => 'cl_plan_bedrooms',
            'type'     => 'text',
            'title'    => esc_html__("Plan Bedrooms", 'houzez'),
            'default' => "Bedrooms",
        ),

        array(
            'id'       => 'cl_plan_bedrooms_plac',
            'type'     => 'text',
            'title'    => esc_html__("Plan Bedrooms Placeholder", 'houzez'),
            'default' => "Enter the number of bedrooms",
        ),

        array(
            'id'       => 'cl_plan_bathrooms',
            'type'     => 'text',
            'title'    => esc_html__("Plan Bathrooms", 'houzez'),
            'default' => "Bathrooms",
        ),
        array(
            'id'       => 'cl_plan_bathrooms_plac',
            'type'     => 'text',
            'title'    => esc_html__("Plan Bedrooms Placeholder", 'houzez'),
            'default' => "Enter the number of bathrooms",
        ),

        array(
            'id'       => 'cl_plan_price',
            'type'     => 'text',
            'title'    => esc_html__("Plan Price", 'houzez'),
            'default' => "Price",
        ),
        array(
            'id'       => 'cl_plan_price_plac',
            'type'     => 'text',
            'title'    => esc_html__("Plan Price Placeholder", 'houzez'),
            'default' => "Enter the price",
        ),

        array(
            'id'       => 'cl_plan_price_postfix',
            'type'     => 'text',
            'title'    => esc_html__("Plan Price Postfix", 'houzez'),
            'default' => "Price Postfix",
        ),
        array(
            'id'       => 'cl_plan_price_postfix_plac',
            'type'     => 'text',
            'title'    => esc_html__("Plan Price Postfix Placeholder", 'houzez'),
            'default' => "Enter the price postfix",
        ),

        array(
            'id'       => 'cl_plan_size',
            'type'     => 'text',
            'title'    => esc_html__("Plan Size", 'houzez'),
            'default' => "Plan Size",
        ),
        array(
            'id'       => 'cl_plan_size_plac',
            'type'     => 'text',
            'title'    => esc_html__("Plan Size Placeholder", 'houzez'),
            'default' => "Enter the plan size",
        ),

        array(
            'id'       => 'cl_plan_img',
            'type'     => 'text',
            'title'    => esc_html__("Plan Image", 'houzez'),
            'default' => "Plan Image",
        ),
        array(
            'id'       => 'cl_plan_img_plac',
            'type'     => 'text',
            'title'    => esc_html__("Plan Image Placeholder", 'houzez'),
            'default' => "Upload the plan image",
        ),
        array(
            'id'       => 'cl_plan_img_btn',
            'type'     => 'text',
            'title'    => esc_html__("Plan Image Button", 'houzez'),
            'default' => "Select Image",
        ),
        array(
            'id'       => 'cl_plan_img_size',
            'type'     => 'text',
            'title'    => esc_html__("Plan Image Size", 'houzez'),
            'default' => "Minimum size 800 x 600 px",
        ),

        array(
            'id'       => 'cl_plan_des',
            'type'     => 'text',
            'title'    => esc_html__("Plan Description", 'houzez'),
            'default' => "Description",
        ),
        array(
            'id'       => 'cl_plan_des_plac',
            'type'     => 'text',
            'title'    => esc_html__("Plan Description Placeholder", 'houzez'),
            'default' => "Enter the plan description",
        ),

        array(
            'id'       => 'cl_subl_title',
            'type'     => 'text',
            'title'    => esc_html__("Title", 'houzez'),
            'default' => "Title",
        ),

        array(
            'id'       => 'cl_subl_title_plac',
            'type'     => 'text',
            'title'    => esc_html__("Title Placeholder", 'houzez'),
            'default' => "Enter the  title",
        ),

        array(
            'id'       => 'cl_subl_bedrooms',
            'type'     => 'text',
            'title'    => esc_html__("Bedrooms", 'houzez'),
            'default' => "Bedrooms",
        ),

        array(
            'id'       => 'cl_subl_bedrooms_plac',
            'type'     => 'text',
            'title'    => esc_html__("Bedrooms Placeholder", 'houzez'),
            'default' => "Enter the number of bedrooms",
        ),

        array(
            'id'       => 'cl_subl_bathrooms',
            'type'     => 'text',
            'title'    => esc_html__("Bathrooms", 'houzez'),
            'default' => "Bathrooms",
        ),
        array(
            'id'       => 'cl_subl_bathrooms_plac',
            'type'     => 'text',
            'title'    => esc_html__("Bedrooms Placeholder", 'houzez'),
            'default' => "Enter the number of bathrooms",
        ),

        array(
            'id'       => 'cl_subl_price',
            'type'     => 'text',
            'title'    => esc_html__("Price", 'houzez'),
            'default' => "Price",
        ),
        array(
            'id'       => 'cl_subl_price_plac',
            'type'     => 'text',
            'title'    => esc_html__("Price Placeholder", 'houzez'),
            'default' => "Enter the price",
        ),

        array(
            'id'       => 'cl_subl_price_postfix',
            'type'     => 'text',
            'title'    => esc_html__("Price Postfix", 'houzez'),
            'default' => "Price",
        ),
        array(
            'id'       => 'cl_subl_price_postfix_plac',
            'type'     => 'text',
            'title'    => esc_html__("Price Postfix Placeholder", 'houzez'),
            'default' => "Enter the price postfix",
        ),

        array(
            'id'       => 'cl_subl_size',
            'type'     => 'text',
            'title'    => esc_html__("Property Size", 'houzez'),
            'default' => "Property Size",
        ),
        array(
            'id'       => 'cl_subl_size_plac',
            'type'     => 'text',
            'title'    => esc_html__("Property Size Placeholder", 'houzez'),
            'default' => "Enter the property size",
        ),

        array(
            'id'       => 'cl_subl_size_postfix',
            'type'     => 'text',
            'title'    => esc_html__("Size Postfix", 'houzez'),
            'default' => "Size Postfix",
        ),
        array(
            'id'       => 'cl_subl_size_postfix_plac',
            'type'     => 'text',
            'title'    => esc_html__("Size Postfix Placeholder", 'houzez'),
            'default' => "Enter the property size postfix",
        ),

        array(
            'id'       => 'cl_subl_type',
            'type'     => 'text',
            'title'    => esc_html__("Property Type", 'houzez'),
            'default' => "Property Type",
        ),
        array(
            'id'       => 'cl_subl_type_plac',
            'type'     => 'text',
            'title'    => esc_html__("Property Type Placeholder", 'houzez'),
            'default' => "Enter the property type",
        ),

        array(
            'id'       => 'cl_subl_date',
            'type'     => 'text',
            'title'    => esc_html__("Availability Date", 'houzez'),
            'default' => "Availability Date",
        ),
        array(
            'id'       => 'cl_subl_date_plac',
            'type'     => 'text',
            'title'    => esc_html__("Availability Date Placeholder", 'houzez'),
            'default' => "Enter the availability date",
        ),

        array(
            'id'       => 'cl_subl_ids',
            'type'     => 'text',
            'title'    => esc_html__("Listing IDs", 'houzez'),
            'default' => "Listing IDs",
        ),
        array(
            'id'       => 'cl_subl_ids_plac',
            'type'     => 'text',
            'title'    => esc_html__("Listing IDs Placeholder", 'houzez'),
            'default' => "Enter the listing IDs comma separated",
        ),
        array(
            'id'       => 'cl_subl_ids_tooltip',
            'type'     => 'text',
            'title'    => esc_html__("Listing IDs Tooltp", 'houzez'),
            'default' => "If the sub-properties are separated listings, use the box above to enter the listing IDs (Example: 4,5,6)",
        ),

        array(
            'id'       => 'cl_location_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),
        
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Dashboard Menu', 'houzez' ),
    'id'     => 'dashboard-menu',
    'desc'   => '',
    'subsection'   => true,
    'fields'        => array(
        array(
            'id'       => 'dsh_labels_section-start',
            'type'     => 'section',
            'title'    => '',
            'subtitle' => esc_html__('Manage labels for dashboard menu', 'houzez'),
            'indent'   => true,
        ),

        array(
            'id'       => 'dsh_board',
            'type'     => 'text',
            'title'    => esc_html__("Board", 'houzez'),
            'default' => "Board",
        ),
        array(
            'id'       => 'dsh_activities',
            'type'     => 'text',
            'title'    => esc_html__("Activities", 'houzez'),
            'default' => "Activities",
        ),
        array(
            'id'       => 'dsh_deals',
            'type'     => 'text',
            'title'    => esc_html__("Deals", 'houzez'),
            'default' => "Deals",
        ),
        array(
            'id'       => 'dsh_leads',
            'type'     => 'text',
            'title'    => esc_html__("Leads", 'houzez'),
            'default' => "Leads",
        ),
        array(
            'id'       => 'dsh_inquiries',
            'type'     => 'text',
            'title'    => esc_html__("Inquiries", 'houzez'),
            'default' => "Inquiries",
        ),
        array(
            'id'       => 'dsh_insight',
            'type'     => 'text',
            'title'    => esc_html__("Insight", 'houzez'),
            'default' => "Insight",
        ),
        array(
            'id'       => 'dsh_props',
            'type'     => 'text',
            'title'    => esc_html__("Properties", 'houzez'),
            'default' => "Properties",
        ),
        array(
            'id'       => 'dsh_all',
            'type'     => 'text',
            'title'    => esc_html__("All", 'houzez'),
            'default' => "All",
        ),
        array(
            'id'       => 'dsh_published',
            'type'     => 'text',
            'title'    => esc_html__("Published", 'houzez'),
            'default' => "Published",
        ),
        array(
            'id'       => 'dsh_pending',
            'type'     => 'text',
            'title'    => esc_html__("Pending", 'houzez'),
            'default' => "Pending",
        ),
        array(
            'id'       => 'dsh_expired',
            'type'     => 'text',
            'title'    => esc_html__("Expired", 'houzez'),
            'default' => "Expired",
        ),
        array(
            'id'       => 'dsh_draft',
            'type'     => 'text',
            'title'    => esc_html__("Draft", 'houzez'),
            'default' => "Draft",
        ),
        array(
            'id'       => 'dsh_hold',
            'type'     => 'text',
            'title'    => esc_html__("On Hold", 'houzez'),
            'default' => "On Hold",
        ),
        array(
            'id'       => 'dsh_create_listing',
            'type'     => 'text',
            'title'    => esc_html__("Create a Listing", 'houzez'),
            'default' => "Create a Listing",
        ),
        array(
            'id'       => 'dsh_favorite',
            'type'     => 'text',
            'title'    => esc_html__("Favorites", 'houzez'),
            'default' => "Favorites",
        ),
        array(
            'id'       => 'dsh_messages',
            'type'     => 'text',
            'title'    => esc_html__("Messages", 'houzez'),
            'default' => "Messages",
        ),
        array(
            'id'       => 'dsh_saved_searches',
            'type'     => 'text',
            'title'    => esc_html__("Saved Searches", 'houzez'),
            'default' => "Saved Searches",
        ),
        array(
            'id'       => 'dsh_membership',
            'type'     => 'text',
            'title'    => esc_html__("Membership", 'houzez'),
            'default' => "Membership",
        ),
        array(
            'id'       => 'dsh_invoices',
            'type'     => 'text',
            'title'    => esc_html__("Invoices", 'houzez'),
            'default' => "Invoices",
        ),
        array(
            'id'       => 'dsh_profile',
            'type'     => 'text',
            'title'    => esc_html__("My Profile", 'houzez'),
            'default' => "My Profile",
        ),
        array(
            'id'       => 'dsh_gdpr',
            'type'     => 'text',
            'title'    => esc_html__("GDPR Request", 'houzez'),
            'default' => "GDPR Request",
        ),
        array(
            'id'       => 'dsh_agents',
            'type'     => 'text',
            'title'    => esc_html__("Agents", 'houzez'),
            'default' => "Agents",
        ),
        array(
            'id'       => 'dsh_addnew',
            'type'     => 'text',
            'title'    => esc_html__("Add New", 'houzez'),
            'default' => "Add New",
        ),
        array(
            'id'       => 'dsh_logout',
            'type'     => 'text',
            'title'    => esc_html__("Log Out", 'houzez'),
            'default' => "Log Out",
        ),
    

        array(
            'id'       => 'dsh_labels_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),
    )
));