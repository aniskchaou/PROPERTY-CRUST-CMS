<?php
add_filter( 'rwmb_meta_boxes', 'houzez_register_metaboxes' );

if( !function_exists( 'houzez_register_metaboxes' ) ) {
    function houzez_register_metaboxes() {

        if (!class_exists('RW_Meta_Box')) {
            return;
        }

        global $meta_boxes, $wpdb;
        
        $houzez_prefix = "fave_";

        $page_filters = houzez_option('houzez_page_filters');

        $prop_states = array();
        $prop_locations = array();
        $prop_types = array();
        $prop_status = array();
        $prop_features = array();
        $prop_neighborhood = array();
        $agent_categories = array();
        $agent_cities = array();
        $prop_label = array();

        if( houzez_current_screen() == 'admin_page' ) {
            houzez_get_terms_array( 'property_feature', $prop_features );
            houzez_get_terms_array( 'property_status', $prop_status );
            houzez_get_terms_array( 'property_type', $prop_types );
            houzez_get_terms_array( 'property_city', $prop_locations );
            houzez_get_terms_array( 'property_state', $prop_states );
            houzez_get_terms_array( 'property_label', $prop_label );
            houzez_get_terms_array( 'property_area', $prop_neighborhood );
            houzez_get_terms_array( 'agent_category', $agent_categories );
            houzez_get_terms_array( 'agent_city', $agent_cities );
        }

        $agencies_2_array = array(-1 => houzez_option('cl_none', 'None'));
        $agencies_array = array('' => houzez_option('cl_none', 'None'));
        $agencies_posts = get_posts(array('post_type' => 'houzez_agency', 'posts_per_page' => -1));
        if (!empty($agencies_posts)) {
            foreach ($agencies_posts as $agency_post) {
                $agencies_array[$agency_post->ID] = $agency_post->post_title;
                $agencies_2_array[$agency_post->ID] = $agency_post->post_title;
            }
        }

        $countries_array = array();

        $is_multi_agents = false;
        $max_prop_images = houzez_option('max_prop_images', 40);
        $enable_multi_agents = houzez_option('enable_multi_agents');
        if( $enable_multi_agents != 0 ) {
            $is_multi_agents = true;
        }

        $agents_for_templates = array_slice( houzez_get_agents_array(), 1, null, true );
        
        $beds_hidden = $baths_hidden = $garages = $garage_size = $prop_id = $area_size = $land_area = '';

        $currency_hidden = 'multi_currency';
        $multi_currency = houzez_option('multi_currency');

        $id_pattern = '';
        if( houzez_option('auto_property_id', 0) ) {
            $id_pattern = houzez_option('property_id_pattern', '{0}');
        }

        $multi_currency_field = array();
        if($multi_currency == 1 ) {
            $multi_currency_field = array(
                    'id' => "{$houzez_prefix}currency",
                    'name' => esc_html__('Currency', 'houzez'),
                    'type' => 'select',
                    'options' => houzez_available_currencies(),
                    'std' => houzez_option('default_multi_currency'),
                    'columns' => 6,
                    'tab' => 'property_details',
                );
        } else {
            $multi_currency_field = array(
                    'id' => "hhh_divider",
                    'type' => 'divider',
                    'columns' => 12,
                    'class' => 'houzez_hidden',
                    'tab' => 'property_details',
                );
        }

        $meta_boxes[] = array(
            'id' => 'property-meta-box',
            'title' => esc_html__('Property', 'houzez'),
            'pages' => array('property'),
            'tabs' => array(
                'property_details' => array(
                    'label' => houzez_option('cls_information', 'Information'),
                    'icon' => 'dashicons-admin-home',
                ),
                'property_map' => array(
                    'label' => houzez_option('cls_map', 'Map'),
                    'icon' => 'dashicons-location',
                ),
                'property_settings' => array(
                    'label' => houzez_option('cls_settings', 'Property Setting'),
                    'icon' => 'dashicons-admin-generic',
                ),
                'gallery' => array(
                    'label' => houzez_option('cls_media', 'Property Media'),
                    'icon' => 'dashicons-format-gallery',
                ),
                'virtual_tour' => array(
                    'label' => houzez_option('cls_virtual_tour', '360° Virtual Tour'),
                    'icon' => 'dashicons-format-video',
                ),
                'agent' => array(
                    'label' => houzez_option('cls_contact_info', 'Contact Information'),
                    'icon' => 'dashicons-businessman',
                ),
                'home_slider' => array(
                    'label' => houzez_option('cls_slider', 'Slider'),
                    'icon' => 'dashicons-images-alt',
                ),
                'multi_units' => array(
                    'label' => houzez_option('cls_sub_listings', 'Sub Listings'),
                    'icon' => 'dashicons-layout',
                ),
                'floor_plans' => array(
                    'label' => houzez_option('cls_floor_plans', 'Floor Plans'),
                    'icon' => 'dashicons-layout',
                ),
                'attachments' => array(
                    'label' => houzez_option('cls_documents', 'Property Documents'),
                    'icon' => 'dashicons-book',
                ),
            
                'private_note' => array(
                    'label' => houzez_option('cls_private_notes', 'Private Note'),
                    'icon' => 'dashicons-lightbulb',
                ),
                'energy' => array(
                    'label' => houzez_option('cls_energy_class', 'Energy Class'),
                    'icon' => 'dashicons-lightbulb',
                ),
                'listing_layout' => array(
                    'label' => houzez_option('cls_layout', 'Layout'),
                    'icon' => 'dashicons-laptop',
                )

            ),
            'tab_style' => 'left',
            'fields' => array(

                // Property Details
                $multi_currency_field,
                array(
                    'id' => "{$houzez_prefix}property_price",
                    'name' => houzez_option('cl_sale_price', 'Sale or Rent Price'),
                    'desc' => '',
                    'placeholder' => houzez_option('cl_sale_price_plac', 'Enter the price'),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_sec_price",
                    'name' => houzez_option('cl_second_price', 'Second Price (Optional)'),
                    'desc' => '',
                    'placeholder' => houzez_option('cl_second_price_plac', 'Enter the second price'),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_price_prefix",
                    'name' => houzez_option('cl_price_prefix', 'Price Prefix'),
                    'desc' => houzez_option('cl_price_prefix_tooltip', 'For example: Start from'),
                    'placeholder' => houzez_option('cl_price_prefix_plac', 'Enter the price prefix'),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_price_postfix",
                    'name' => houzez_option('cl_price_postfix', 'After The Price Label'),
                    'desc' => houzez_option('cl_price_postfix_tooltip', 'For example: Monthly'),
                    'placeholder' => houzez_option('cl_price_postfix_plac', 'Enter the label after price'),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                    'tab' => 'property_details',
                ),

                array(
                    'id' => "{$houzez_prefix}property_size",
                    'name' => houzez_option('cl_area_size', 'Area Size'),
                    'desc' => houzez_option('cl_only_digits', 'Only digits'),
                    'placeholder' => houzez_option('cl_area_size_plac', 'Enter property area size'),
                    'type' => 'text',
                    'std' => "",
                    'class' => $area_size,
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_size_prefix",
                    'name' => houzez_option('cl_area_size_postfix', 'Size Postfix'),
                    'desc' => houzez_option('cl_area_size_postfix_tooltip', 'For example: Sq Ft'),
                    'placeholder' => houzez_option('cl_area_size_postfix_plac', 'Enter the size postfix'),
                    'type' => 'text',
                    'std' => "",
                    'class' => $area_size,
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_land",
                    'name' => houzez_option('cl_land_size', 'Land Area'),
                    'desc' => houzez_option('cl_only_digits', 'Only digits'),
                    'placeholder' => houzez_option('cl_land_size_plac', 'Enter property land area size'),
                    'type' => 'text',
                    'std' => "",
                    'class' => $land_area,
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_land_postfix",
                    'name' => houzez_option('cl_land_size_postfix', 'Land Area Size Postfix'),
                    'desc' => houzez_option('cl_land_size_postfix_tooltip', 'For example: Sq Ft'),
                    'placeholder' => houzez_option('cl_land_size_postfix_plac', 'Enter property land area postfix'),
                    'type' => 'text',
                    'std' => "",
                    'class' => $land_area,
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_bedrooms",
                    'name' => houzez_option('cl_bedrooms', 'Bedrooms'),
                    'placeholder' => houzez_option('cl_bedrooms_plac', 'Bedrooms'),
                    'desc' => houzez_option('cl_only_digits', 'Only digits'),
                    'type' => 'text',
                    'std' => "",
                    'class' => $beds_hidden,
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_rooms",
                    'name' => houzez_option('cl_rooms', 'Rooms'),
                    'placeholder' => houzez_option('cl_rooms_plac', 'Rooms'),
                    'desc' => houzez_option('cl_only_digits', 'Only digits'),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_bathrooms",
                    'name' => houzez_option('cl_bathrooms', 'Bathrooms'),
                    'placeholder' => houzez_option('cl_bathrooms_plac', 'Bathrooms'),
                    'desc' => houzez_option('cl_only_digits', 'Only digits'),
                    'type' => 'text',
                    'std' => "",
                    'class' => $baths_hidden,
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                
                array(
                    'id' => "{$houzez_prefix}property_garage",
                    'name' => houzez_option('cl_garage', 'Garages'),
                    'placeholder' => houzez_option('cl_garage_plac', 'Garages'),
                    'desc' => houzez_option('cl_only_digits', 'Only digits'),
                    'type' => 'text',
                    'std' => "",
                    'class' => $garages,
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_garage_size",
                    'name' => houzez_option('cl_garage_size', 'Garages Size'),
                    'placeholder' => houzez_option('cl_garage_size_plac', 'Garages Size'),
                    'desc' => houzez_option('cl_garage_size_tooltip', 'For example: 200 Sq Ft'),
                    'type' => 'text',
                    'std' => "",
                    'class' => $garage_size,
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_year",
                    'name' => houzez_option('cl_year_built', 'Year Built'),
                    'placeholder' => houzez_option('cl_year_built_plac', 'Year Built'),
                    'desc' => houzez_option('cl_only_digits', 'Only digits'),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                    'tab' => 'property_details',
                ),
                array(
                    'id' => "{$houzez_prefix}property_id",
                    'name' => houzez_option('cl_prop_id', 'Property ID'),
                    'desc' => houzez_option('cl_prop_id_tooltip', 'For example: HZ-01'),
                    'placeholder' => houzez_option('cl_prop_id_plac', 'Enter property ID'),
                    'type' => 'text',
                    'std' => $id_pattern,
                    'class' => $prop_id,
                    'columns' => 6,
                    'attributes' => array(
                        'readonly' => ( 1 == houzez_option( 'auto_property_id' ) ) ? true : false,
                    ),
                    'tab' => 'property_details',
                ),

                // Property Map
                array(
                    'type' => 'divider',
                    'columns' => 12,
                    'id' => 'google_map_divider',
                    'tab' => 'property_details',
                ),
                array(
                    'name' => houzez_option('cls_map', 'Map'),
                    'id' => "{$houzez_prefix}property_map",
                    'type' => 'radio',
                    'std' => 1,
                    'options' => array(
                        1 => houzez_option('cl_show', 'Show '),
                        0 => houzez_option('cl_hide', 'Hide')
                    ),
                    'columns' => 12,
                    'tab' => 'property_map',
                ),
                array(
                    'id' => "{$houzez_prefix}property_map_address",
                    'name' => houzez_option('cl_address', 'Address'),
                    'placeholder' => houzez_option('cl_address_plac', 'Enter your property address'),
                    'desc' => '',
                    'type' => 'text',
                    'std' => '',
                    'columns' => 12,
                    'tab' => 'property_map',
                ),
                array(
                    'id' => "{$houzez_prefix}property_location",
                    'name' => '',
                    'desc' => houzez_option('cl_drag_drop_text', 'Drag and drop the pin on map to find exact location'),
                    'type' => houzez_metabox_map_type(),
                    'std' => houzez_option('map_default_lat', 25.686540).','.houzez_option('map_default_long', -80.431345).',15',
                    'style' => 'width: 100%; height: 410px',
                    'address_field' => "{$houzez_prefix}property_map_address",
                    'api_key'       => houzez_map_api_key(),
                    'language' => get_locale(),
                    'columns' => 12,
                    'tab' => 'property_map',
                ),


                array(
                    'name' => houzez_option('cl_street_view', 'Street View'),
                    'id' => "{$houzez_prefix}property_map_street_view",
                    'type' => 'select',
                    'std' => 'hide',
                    'options' => array(
                        'hide' => houzez_option('cl_hide', 'Hide'),
                        'show' => houzez_option('cl_show', 'Show')
                    ),
                    'columns' => 12,
                    'tab' => 'property_map',
                ),

                // Property Settings
                array(
                    'id' => "{$houzez_prefix}property_address",
                    'name' => houzez_option('cl_streat_address', 'Street Address'),
                    'desc' => houzez_option('cl_streat_address_plac', 'Enter only the street name and the building number'),
                    'type' => 'text',
                    'columns' => 6,
                    'tab' => 'property_settings',
                ),
                array(
                    'id' => "{$houzez_prefix}property_zip",
                    'name' => houzez_option('cl_zip', 'Postal Code / Zip'),
                    'desc' => "",
                    'type' => 'text',
                    'columns' => 6,
                    'tab' => 'property_settings',
                ),
                array(
                    'name' => houzez_option('cl_make_featured', 'Do you want to mark this property as featured?'),
                    'id' => "{$houzez_prefix}featured",
                    'type' => 'radio',
                    'std' => 0,
                    'options' => array(
                        1 => houzez_option('cl_yes', 'Yes '),
                        0 => houzez_option('cl_no', 'No')
                    ),
                    'columns' => 6,
                    'tab' => 'property_settings',
                ),
                
                array(
                    'name' => houzez_option('cl_login_view', 'The user must be logged in to view this property'),
                    'id' => "{$houzez_prefix}loggedintoview",
                    'type' => 'radio',
                    'desc' => houzez_option('cl_login_view_plac', 'If "Yes" then only logged in user can view property details.'),
                    'std' => 0,
                    'options' => array(
                        1 => houzez_option('cl_yes', 'Yes '),
                        0 => houzez_option('cl_no', 'No')
                    ),
                    'columns' => 6,
                    'tab' => 'property_settings',
                ),
        
                array(
                    'id' => "{$houzez_prefix}property_disclaimer",
                    'name' => houzez_option('cl_disclaimer', 'Disclaimer'),
                    'desc' => "",
                    'type' => 'textarea',
                    'columns' => 12,
                    'tab' => 'property_settings',
                ),

                // Gallery
                array(
                    'name' => houzez_option('cl_image_btn', 'Select and Upload'),
                    'id' => "{$houzez_prefix}property_images",
                    'desc' => houzez_option('cl_image_size', '(Minimum size 1440x900)'),
                    'type' => 'image_advanced',
                    'max_file_uploads' => $max_prop_images,
                    'columns' => 12,
                    'tab' => 'gallery',
                ),

                // Property Video
                array(
                    'id' => "{$houzez_prefix}video_url",
                    'name' => houzez_option('cl_video_url', 'Video URL'),
                    'placeholder' => houzez_option('cl_video_url_plac', 'YouTube, Vimeo, SWF File and MOV File are supported'),
                    'desc' => houzez_option('cl_example', 'For example').' https://www.youtube.com/watch?v=49d3Gn41IaA',
                    'type' => 'text',
                    'columns' => 12,
                    'tab' => 'gallery',
                ),
                

                //Virtual Tour
                array(
                    'id' => "{$houzez_prefix}virtual_tour",
                    'name' => houzez_option('cls_virtual_tour', '360° Virtual Tour'),
                    'placeholder' => houzez_option('cl_virtual_plac', 'Enter virtual tour iframe/embeded code'),
                    'type' => 'textarea',
                    'columns' => 12,
                    'sanitize_callback' => 'none',
                    'tab' => 'virtual_tour',
                ),


                // Agents
                array(
                    'name' => houzez_option('cl_contact_info_text', 'What information do you want to display in agent data container?'),
                    'id' => "{$houzez_prefix}agent_display_option",
                    'type' => 'radio',
                    'std' => 'author_info',
                    'options' => array(
                        'author_info' => houzez_option('cl_author_info', 'Author Info'),
                        'agent_info' => houzez_option('cl_agent_info', 'Agent Info (Choose agent from the list below)'),
                        'agency_info' => houzez_option('cl_agency_info', 'Agency Info (Choose agency from the list below)'),
                        'none' => houzez_option('cl_not_display', 'Do not display'),
                    ),
                    'columns' => 12,
                    'inline' => false,
                    'tab' => 'agent',
                ),
                array(
                    'name' => houzez_option('cl_agent_info_plac', 'Select an Agent'),
                    'id' => "{$houzez_prefix}agents",
                    'type' => 'select',
                    'options' => houzez_get_agents_array(),
                    'columns' => 12,
                    'tab' => 'agent',
                    'visible' => array( $houzez_prefix.'agent_display_option', '=', 'agent_info' ),
                    'multiple' => $is_multi_agents
                ),
                array(
                    'name' => houzez_option('cl_agency_info_plac', 'Select an Agency'),
                    'id' => "{$houzez_prefix}property_agency",
                    'type' => 'select',
                    'options' => houzez_get_agency_array(),
                    'columns' => 12,
                    'tab' => 'agent',
                    'visible' => array( $houzez_prefix.'agent_display_option', '=', 'agency_info' ),
                    'multiple' => false
                ),

                // Homepage Slider
                array(
                    'name' => houzez_option('cl_add_slider', 'Do you want to display this property on the custom property slider?'),
                    'id' => "{$houzez_prefix}prop_homeslider",
                    'desc' => houzez_option('cl_add_slider_plac', 'Upload an image below if you selected yes.'),
                    'type' => 'radio',
                    'std' => 'no',
                    'options' => array(
                        'yes' => houzez_option('cl_yes', 'Yes '),
                        'no' => houzez_option('cl_no', 'No')
                    ),
                    'columns' => 12,
                    'tab' => 'home_slider',
                ),
                array(
                    'name' => houzez_option('cl_slider_img', 'Slider Image'),
                    'id' => "{$houzez_prefix}prop_slider_image",
                    'desc' => houzez_option('cl_slider_img_size', 'Suggested size 2000px x 700px'),
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                    'columns' => 12,
                    'tab' => 'home_slider',
                ),

                //Multi Units / Sub Properties
                array(
                    'id' => "{$houzez_prefix}multi_units_ids",
                    'name' => houzez_option('cl_subl_ids', 'Listing IDs'),
                    'placeholder' => houzez_option('cl_subl_ids_plac', 'Enter the listing IDs comma separated'),
                    'desc' => houzez_option('cl_subl_ids_tooltip', 'If the sub-properties are separated listings, use the box above to enter the listing IDs (Example: 4,5,6)'),
                    'type' => 'textarea',
                    'columns' => 12,
                    'tab' => 'multi_units',
                ),
                array(
                    'type' => 'heading',
                    'name' => houzez_option('cl_or', 'Or'),
                    'columns' => 12,
                    'desc' => "",
                    'tab' => 'multi_units',
                ),
                array(
                    'id'     => "{$houzez_prefix}multi_units",
                    // Gropu field
                    'type'   => 'group',
                    // Clone whole group?
                    'clone'  => true,
                    'sort_clone' => false,
                    'tab' => 'multi_units',
                    // Sub-fields
                    'fields' => array(
                        array(
                            'name' => houzez_option('cl_subl_title', 'Title' ),
                            'id'   => "{$houzez_prefix}mu_title",
                            'type' => 'text',
                            'placeholder' => houzez_option('cl_subl_title_plac', 'Enter the title'),
                            'columns' => 12,
                        ),
                        array(
                            'name' => houzez_option('cl_subl_price', 'Price' ),
                            'id'   => "{$houzez_prefix}mu_price",
                            'placeholder' => houzez_option('cl_subl_price_plac', 'Enter the price'),
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_subl_price_postfix', 'Price Postfix' ),
                            'id'   => "{$houzez_prefix}mu_price_postfix",
                            'placeholder' => houzez_option('cl_subl_price_postfix_plac', 'Enter the price postfix'),
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_subl_bedrooms', 'Bedrooms' ),
                            'id'   => "{$houzez_prefix}mu_beds",
                            'placeholder' => houzez_option('cl_subl_bedrooms', 'Enter the number of bedrooms'),
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_subl_bathrooms', 'Bathrooms' ),
                            'id'   => "{$houzez_prefix}mu_baths",
                            'placeholder' => houzez_option('cl_subl_bathrooms_plac', 'Enter the number of bathrooms'),
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_subl_size', 'Property Size' ),
                            'id'   => "{$houzez_prefix}mu_size",
                            'placeholder' => houzez_option('cl_subl_size', 'Enter the property size'),
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_subl_size_postfix', 'Size Postfix' ),
                            'id'   => "{$houzez_prefix}mu_size_postfix",
                            'placeholder' => houzez_option('cl_subl_size_postfix_plac', 'Enter the property size postfix'),
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_subl_type', 'Property Type' ),
                            'id'   => "{$houzez_prefix}mu_type",
                            'placeholder' => houzez_option('cl_subl_type_plac', 'Enter the property type'),
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_subl_date', 'Availability Date' ),
                            'id'   => "{$houzez_prefix}mu_availability_date",
                            'placeholder' => houzez_option('cl_subl_date_plac', 'Enter the availability date'),
                            'type' => 'text',
                            'columns' => 6,
                        ),

                    ),
                ),

                //Floor Plans
                array(
                    'id'     => 'floor_plans',
                    // Gropu field
                    'type'   => 'group',
                    // Clone whole group?
                    'clone'  => true,
                    'sort_clone' => false,
                    'tab' => 'floor_plans',
                    // Sub-fields
                    'fields' => array(
                        array(
                            'name' => houzez_option('cl_plan_title', 'Plan Title' ),
                            'placeholder' => houzez_option('cl_plan_title_plac', 'Enter the title'),
                            'id'   => "{$houzez_prefix}plan_title",
                            'type' => 'text',
                            'columns' => 12,
                        ),
                        array(
                            'name' => houzez_option('cl_plan_bedrooms', 'Bedrooms' ),
                            'placeholder' => houzez_option('cl_plan_bedrooms_plac', 'Enter the number of bedrooms'),
                            'id'   => "{$houzez_prefix}plan_rooms",
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_plan_bathrooms', 'Bathrooms' ),
                            'placeholder' => houzez_option('cl_plan_bathrooms_plac', 'Enter the number of bathrooms'),
                            'id'   => "{$houzez_prefix}plan_bathrooms",
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_plan_price', 'Price' ),
                            'id'   => "{$houzez_prefix}plan_price",
                            'placeholder' => houzez_option('cl_plan_price_plac', 'Enter the price'),
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_plan_price_postfix', 'Price Postfix' ),
                            'placeholder' => houzez_option('cl_plan_price_postfix_plac', 'Enter the price postfix'),
                            'id'   => "{$houzez_prefix}plan_price_postfix",
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_plan_size', 'Plan Size' ),
                            'placeholder' => houzez_option('cl_plan_size_plac', 'Enter the plan size' ),
                            'id'   => "{$houzez_prefix}plan_size",
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_plan_img', 'Plan Image'),
                            'id'   => "{$houzez_prefix}plan_image",
                            'placeholder' => houzez_option('cl_plan_img_plac', 'upload the plan image'),
                            'desc' => houzez_option('cl_plan_img_size', 'Minimum size 800 x 600 px'),
                            'type' => 'file_input',
                            'columns' => 6,
                        ),
                        array(
                            'name' => houzez_option('cl_plan_des', 'Description'),
                            'placeholder' => houzez_option('cl_plan_des_plac', 'Enter the plan description'),
                            'id'   => "{$houzez_prefix}plan_description",
                            'type' => 'textarea',
                            'columns' => 12,
                        ),

                    ),
                ),

                // Attachments
                array(
                    'id' => "{$houzez_prefix}attachments",
                    'name' => houzez_option('cls_documents', 'Property Documents'),
                    'desc' => houzez_option('cl_decuments_text', 'You can attach PDF files, Map images OR other documents.'),
                    'type' => 'file_advanced',
                    'mime_type' => '',
                    'columns' => 12,
                    'tab' => 'attachments',
                ),

                // Attachments
                array(
                    'id' => "{$houzez_prefix}private_note",
                    'name' => houzez_option('cls_private_notes', 'Private Note'),
                    'placeholder' => houzez_option('cl_private_note', 'Enter the note here'),
                    'desc' => houzez_option('cl_private_note', 'Write private note for this property, it will not display for public.'),
                    'type' => 'textarea',
                    'mime_type' => '',
                    'columns' => 12,
                    'tab' => 'private_note',
                ),

                //layout
                array(
                    'id' => "{$houzez_prefix}single_top_area",
                    'name' => esc_html__('Property Top Type', 'houzez'),
                    'desc' => esc_html__('Set the property top area type.', 'houzez'),
                    'type' => 'select',
                    'std' => "global",
                    'options' => array(
                        'global' => esc_html__( 'Global', 'houzez' ),
                        'v1' => esc_html__( 'Version 1', 'houzez' ),
                        'v2' => esc_html__( 'Version 2', 'houzez' ),
                        'v3' => esc_html__( 'Version 3', 'houzez' ),
                        'v4' => esc_html__( 'Version 4', 'houzez' ),
                        'v5' => esc_html__( 'Version 5', 'houzez' ),
                        'v6' => esc_html__( 'Version 6', 'houzez' )
                    ),
                    'columns' => 12,
                    'tab' => 'listing_layout'
                ),
                array(
                    'id' => "{$houzez_prefix}single_content_area",
                    'name' => esc_html__('Property Content Layout', 'houzez'),
                    'desc' => esc_html__('Set property content area type.', 'houzez'),
                    'type' => 'select',
                    'std' => "global",
                    'options' => array(
                        'global' => esc_html__( 'Global', 'houzez' ),
                        'simple' => esc_html__( 'Default', 'houzez' ),
                        'tabs'   => esc_html__( 'Tabs', 'houzez' ),
                        'tabs-vertical' => esc_html__( 'Tabs Vertical', 'houzez' ),
                        'v2' => esc_html__( 'Luxury Homes', 'houzez' )
                    ),
                    'columns' => 12,
                    'tab' => 'listing_layout'
                ),

                array(
                    'id' => "{$houzez_prefix}energy_class",
                    'name' => houzez_option('cl_energy_cls', 'Energy Class' ),
                    'desc' => '',
                    'type' => 'select',
                    'std' => "global",
                    'options' => array(
                        ''    => houzez_option('cl_energy_cls_plac', 'Select Energy Class'),
                        'A+' => 'A+',
                        'A'     => 'A',
                        'B'     => 'B',
                        'C'     => 'C',
                        'D'     => 'D',
                        'E'     => 'E',
                        'F'     => 'F',
                        'G'     => 'G',
                        'H'     => 'H',
                    ),
                    'columns' => 6,
                    'tab' => 'energy'
                ),
                array(
                    'id' => "{$houzez_prefix}energy_global_index",
                    'name' => houzez_option('cl_energy_index', 'Global Energy Performance Index'),
                    'placeholder' => houzez_option('cl_energy_index_plac', 'For example: 92.42 kWh / m²a'),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                    'tab' => 'energy'
                ),
                array(
                    'id' => "{$houzez_prefix}renewable_energy_global_index",
                    'name' => houzez_option('cl_energy_renew_index', 'Renewable energy performance index'),
                    'placeholder' => houzez_option('cl_energy_renew_index_plac', 'For example: 0.00 kWh / m²a'),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                    'tab' => 'energy'
                ),
                array(
                    'id' => "{$houzez_prefix}energy_performance",
                    'name' => houzez_option('cl_energy_build_performance', 'Energy performance of the building'),
                    'placeholder' => houzez_option('cl_energy_build_performance_plac'),
                    'desc' => '',
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                    'tab' => 'energy'
                ),
                array(
                    'id' => "{$houzez_prefix}epc_current_rating",
                    'name' => houzez_option('cl_energy_ecp_rating', 'EPC Current Rating'),
                    'placeholder' => houzez_option('cl_energy_ecp_rating_plac'),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                    'tab' => 'energy'
                ),
                array(
                    'id' => "{$houzez_prefix}epc_potential_rating",
                    'name' => houzez_option('cl_energy_ecp_p', 'EPC Potential Rating'),
                    'placeholder' => houzez_option('cl_energy_ecp_p_plac'),
                    'type' => 'text',
                    'std' => "",
                    'columns' => 6,
                    'tab' => 'energy'
                ),

            )
        );

        
        $meta_boxes[] = array(
            'title' => esc_html__('Additional Features', 'houzez'),
            'pages' => array('property'),
            'fields' => array(
                
                array(
                    'id' => 'additional_features',
                    'type' => 'group',
                    'clone' => true,
                    'sort_clone' => true,
                    'fields' => array(
                        array(
                            'name' => esc_html__('Title', 'houzez'),
                            'id' => "{$houzez_prefix}additional_feature_title",
                            'placeholder' => esc_html__('Enter the title', 'houzez'),
                            'type' => 'text',
                            'columns' => 6,
                        ),
                        array(
                            'name' => esc_html__('Value', 'houzez'),
                            'id' => "{$houzez_prefix}additional_feature_value",
                            'placeholder' => esc_html__('Enter the value', 'houzez'),
                            'type' => 'text',
                            'columns' => 6,
                        )
                    ),
                ),
            ),
        );

        /*------------------------------------------------------------------------
		* Agency
		*-----------------------------------------------------------------------*/
		$meta_boxes[] = array(
            'id'        => 'fave_agencies_template',
            'title'     => esc_html__('Agencies Options', 'houzez'),
            'pages'     => array( 'page' ),
            'priority'   => 'high',
            'context' => 'normal',
            'show'       => array(
                'template' => array(
                    'template/template-agencies.php'
                ),
            ),

            'fields'    => array(
                array(
                    'name'      => esc_html__('Order By', 'houzez'),
                    'id'        => $houzez_prefix . 'agency_orderby',
                    'type'      => 'select',
                    'options'   => array('None' => 'none', 'ID' => 'ID', 'title' => 'title', 'Date' => 'date', 'Random' => 'rand', 'Menu Order' => 'menu_order' ),
                    'desc'      => '',
                    'columns' => 6,
                    'multiple' => false
                ),
                array(
                    'name'      => esc_html__('Order', 'houzez'),
                    'id'        => $houzez_prefix . 'agency_order',
                    'type'      => 'select',
                    'options'   => array('ASC' => 'ASC', 'DESC' => 'DESC' ),
                    'desc'      => '',
                    'columns' => 6,
                    'multiple' => false
                ),
            )
        );

        $meta_boxes[] = array(
            'id'        => 'houzez_agencies',
            'title'     => esc_html__('Agency Information', 'houzez'),
            'pages'     => array( 'houzez_agency' ),
            'context' => 'normal',
            'priority'   => 'high',

            'fields'    => array(
                array(
                    'name'      => esc_html__('Email', 'houzez'),
                    'id'        => $houzez_prefix . 'agency_email',
                    'type'      => 'email',
                    'placeholder'      => esc_html__('Enter the email address','houzez'),
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agency_visible",
                    'name' => esc_html__( 'Visibility Hidden', 'houzez' ),
                    'desc' => esc_html__('Hide agency to show on front-end', 'houzez'),
                    'type' => 'checkbox',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('Mobile Number', 'houzez'),
                    'id'        => $houzez_prefix . 'agency_mobile',
                    'type'      => 'text',
                    'desc'      => '',
                    'placeholder'      => esc_html__('Enter the mobile number','houzez'),
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('Phone Number', 'houzez'),
                    'id'        => $houzez_prefix . 'agency_phone',
                    'type'      => 'text',
                    'desc'      => '',
                    'placeholder'      => esc_html__('Enter the phone number','houzez'),
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('Fax Number', 'houzez'),
                    'id'        => $houzez_prefix . 'agency_fax',
                    'type'      => 'text',
                    'desc'      => '',
                    'placeholder'      => esc_html__('Enter the fax number','houzez'),
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agency_language",
                    'name' => esc_html__( 'Language', 'houzez' ),
                    'placeholder'      => esc_html__('Enter the language you speak','houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('License', 'houzez'),
                    'id'        => $houzez_prefix . 'agency_licenses',
                    'type'      => 'text',
                    'desc'      => '',
                    'placeholder'      => esc_html__('Enter the license','houzez'),
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('Tax Number', 'houzez'),
                    'id'        => $houzez_prefix . 'agency_tax_no',
                    'type'      => 'text',
                    'desc'      => '',
                    'placeholder'      => esc_html__('Enter the tax number','houzez'),
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('Website Url', 'houzez'),
                    'id'        => $houzez_prefix . 'agency_web',
                    'type'      => 'text',
                    'placeholder'      => esc_html__('Enter the website URL','houzez'),
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agency_address",
                    'name' => esc_html__('Address', 'houzez'),
                    'placeholder'      => esc_html__('Enter the full address','houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agency_facebook",
                    'name' => "Facebook URL",
                    'type' => 'text',
                    'std' => "",
                    'placeholder'      => esc_html__('Enter your Facebook profile URL','houzez'),
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agency_twitter",
                    'name' => "Twitter URL",
                    'type' => 'text',
                    'std' => "",
                    'placeholder'      => esc_html__('Enter your Twitter profile URL','houzez'),
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agency_linkedin",
                    'name' => "Linkedin URL",
                    'type' => 'text',
                    'std' => "",
                    'placeholder'      => esc_html__('Enter your Linkedin profile URL','houzez'),
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agency_googleplus",
                    'name' => "Google Plus URL",
                    'type' => 'text',
                    'std' => "",
                    'placeholder'      => esc_html__('Enter your Google Plus profile URL','houzez'),
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agency_youtube",
                    'name' => "Youtube URL",
                    'type' => 'text',
                    'std' => "",
                    'placeholder'      => esc_html__('Enter your Youtube profile URL','houzez'),
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agency_instagram",
                    'name' => "Instagram URL",
                    'type' => 'text',
                    'std' => "",
                    'placeholder'      => esc_html__('Enter your instagram profile URL','houzez'),
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agency_pinterest",
                    'name' => "Pinterest URL",
                    'type' => 'text',
                    'std' => "",
                    'placeholder'      => esc_html__('Enter your Pinterest profile URL','houzez'),
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agency_vimeo",
                    'name' => "Vimeo URL",
                    'type' => 'text',
                    'std' => "",
                    'placeholder'      => esc_html__('Enter your Vimeo profile URL','houzez'),
                    'columns'   => 6
                ),

            )
        );

		/*------------------------------------------------------------------------
		* Agent
		*-----------------------------------------------------------------------*/
		$meta_boxes[] = array(
            'id'        => 'fave_agents_template',
            'title'     => esc_html__('Agents Options', 'houzez'),
            'pages'     => array( 'page' ),
            'context' => 'normal',
            'priority'   => 'high',
            'show'       => array(
                'template' => array(
                    'template/template-agents.php'
                ),
            ),

            'fields'    => array(
                array(
                    'name'      => esc_html__('Order By', 'houzez'),
                    'id'        => $houzez_prefix . 'agent_orderby',
                    'type'      => 'select',
                    'options'   => array('None' => 'none', 'ID' => 'ID', 'title' => 'title', 'Date' => 'date', 'Random' => 'rand', 'menu_order' => 'Menu Order' ),
                    'desc'      => '',
                    'columns' => 6,
                    'multiple' => false
                ),
                array(
                    'name'      => esc_html__('Order', 'houzez'),
                    'id'        => $houzez_prefix . 'agent_order',
                    'type'      => 'select',
                    'options'   => array('ASC' => 'ASC', 'DESC' => 'DESC' ),
                    'desc'      => '',
                    'columns' => 6,
                    'multiple' => false
                ),
                //Filters
                array(
                    'name'      => esc_html__('Agent Category', 'houzez'),
                    'id'        => $houzez_prefix . 'agent_category',
                    'type'      => 'select',
                    'options'   => $agent_categories,
                    'desc'      => '',
                    'columns' => 6,
                    'multiple' => true
                ),
                array(
                    'name'      => esc_html__('Agent City', 'houzez'),
                    'id'        => $houzez_prefix . 'agent_city',
                    'type'      => 'select',
                    'options'   => $agent_cities,
                    'desc'      => '',
                    'columns' => 6,
                    'multiple' => true
                )
            )
        );

        $meta_boxes[] = array(
            'title'  => esc_html__( 'Agent Information', 'houzez' ),
            'pages'  => array('houzez_agent'),
            'fields' => array(

                array(
                    'name'      => esc_html__('Short Description', 'houzez'),
                    'placeholder'      => esc_html__('Enter a short description', 'houzez'),
                    'id'        => $houzez_prefix . 'agent_des',
                    'type'      => 'textarea',
                    'desc'      => '',
                    'columns'   => 12
                ),
                array(
                    'id' => "{$houzez_prefix}agent_email",
                    'name' => esc_html__( 'Email Address', 'houzez' ),
                    'placeholder'      => esc_html__('Enter the email address', 'houzez'),
                    'desc' => esc_html__('All messages related to the agent from the contact form on property details page, will be sent on this email address. ', 'houzez'),
                    'type' => 'email',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_visible",
                    'name' => esc_html__( 'Visibility Hidden', 'houzez' ),
                    'desc' => esc_html__('Hide agent to show on front-end', 'houzez'),
                    'type' => 'checkbox',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('Service Areas', 'houzez'),
                    'id'        => $houzez_prefix . 'agent_service_area',
                    'placeholder'      => esc_html__('Enter your service area', 'houzez'),
                    'type'      => 'text',
                    'desc'      => '',
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('Specialties', 'houzez'),
                    'id'        => $houzez_prefix . 'agent_specialties',
                    'placeholder'      => esc_html__('Enter your speciaties', 'houzez'),
                    'type'      => 'text',
                    'desc'      => '',
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('Position', 'houzez'),
                    'id'        => $houzez_prefix . 'agent_position',
                    'type'      => 'text',
                    'placeholder'      => esc_html__('Enter your position. Example: CEO & Founder', 'houzez'),
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('Company Name', 'houzez'),
                    'placeholder'      => esc_html__('Enter the company name', 'houzez'),
                    'id'        => $houzez_prefix . 'agent_company',
                    'type'      => 'text',
                    'desc'      => '',
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('License', 'houzez'),
                    'placeholder'      => esc_html__('Enter the license', 'houzez'),
                    'id'        => $houzez_prefix . 'agent_license',
                    'type'      => 'text',
                    'desc'      => '',
                    'columns'   => 6
                ),
                array(
                    'name'      => esc_html__('Tax Number', 'houzez'),
                    'placeholder'      => esc_html__('Enter the tax number', 'houzez'),
                    'id'        => $houzez_prefix . 'agent_tax_no',
                    'type'      => 'text',
                    'desc'      => '',
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_mobile",
                    'name' => esc_html__("Mobile Number", 'houzez'),
                    'placeholder'      => esc_html__('Enter the mobile number', 'houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_office_num",
                    'name' => esc_html__("Office Number", 'houzez'),
                    'placeholder'      => esc_html__('Enter the office number', 'houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_fax",
                    'name' => esc_html__("Fax Number", 'houzez'),
                    'placeholder'      => esc_html__('Enter the fax number', 'houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_language",
                    'name' => esc_html__( 'Language', 'houzez' ),
                    'placeholder'      => esc_html__('Enter the language you speak', 'houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_address",
                    'name' => esc_html__( 'Address', 'houzez' ),
                    'placeholder'      => esc_html__('Enter your address', 'houzez'),
                    'desc' => esc_html__('It will be used for invoices ', 'houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_skype",
                    'name' => "Skype",
                    'placeholder'      => esc_html__('Enter your Skype account', 'houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_website",
                    'name' => esc_html__("Website", 'houzez'),
                    'placeholder'      => esc_html__('Enter your website URL', 'houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_facebook",
                    'name' => "Facebook URL",
                    'placeholder'      => esc_html__('Enter your Facebook profile URL','houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_twitter",
                    'name' => "Twitter URL",
                    'placeholder'      => esc_html__('Enter your Twitter profile URL','houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_linkedin",
                    'name' => "Linkedin URL",
                    'placeholder'      => esc_html__('Enter your Linkedin profile URL','houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_googleplus",
                    'name' => "Google Plus URL",
                    'placeholder'      => esc_html__('Enter your Google Plus profile URL','houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_youtube",
                    'name' => "Youtube URL",
                    'placeholder'      => esc_html__('Enter your Youtube profile URL','houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_instagram",
                    'name' => "Instagram URL",
                    'placeholder'      => esc_html__('Enter your instagram profile URL','houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_pinterest",
                    'name' => "Pinterest URL",
                    'placeholder'      => esc_html__('Enter your Pinterest profile URL','houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                array(
                    'id' => "{$houzez_prefix}agent_vimeo",
                    'name' => "Vimeo URL",
                    'placeholder'      => esc_html__('Enter your Vimeo profile URL','houzez'),
                    'type' => 'text',
                    'std' => "",
                    'columns'   => 6
                ),
                
                array(
                    'name'    => esc_html__('Company Logo', 'houzez'),
                    'id'      => $houzez_prefix . 'agent_logo',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                    'desc'      => '',
                    'columns'   => 12
                )
            ),
        );

        $meta_boxes[] = array(
            'title'  => esc_html__( 'Agencies', 'houzez' ),
            'pages'  => array('houzez_agent'),
            'context' => 'side',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id'        => $houzez_prefix . 'agent_agencies',
                    'type'      => 'select',
                    'options'   => $agencies_array,
                    'desc'      => '',
                    'columns' => 12,
                    'multiple' => false
                ),
            )
        );


		/*------------------------------------------------------------------------
		* Partners
		*-----------------------------------------------------------------------*/
		$meta_boxes[] = array(
            'id'        => 'fave_partners',
            'title'     => esc_html__('Partner Details', 'houzez'),
            'pages'     => array( 'houzez_partner' ),
            'context' => 'normal',

            'fields'    => array(
                array(
                    'name'      => esc_html__('Partner website address', 'houzez'),
                    'placeholder'      => esc_html__('Enter the website address','houzez'),
                    'id'        => $houzez_prefix . 'partner_website',
                    'type'      => 'url',
                    'desc'      => esc_html__('Example: https://houzez.co/','houzez'),
                )
            )
        );


		

        /*------------------------------------------------------------------------
        * Content Area
        *-----------------------------------------------------------------------*/
        $meta_boxes[] = array(
            'id'        => 'fave_page_content_area',
            'title'     => esc_html__('Content Area', 'houzez'),
            'pages'     => array( 'page' ),
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
            'pages'     => array( 'page' ),
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

		/*------------------------------------------------------------------------
		* testimonials
		*-----------------------------------------------------------------------*/
		$meta_boxes[] = array(
            'id'        => 'fave_testimonials',
            'title'     => esc_html__('Testimonial Details', 'houzez' ),
            'pages'     => array( 'houzez_testimonials' ),
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


		/*------------------------------------------------------------------------
		* Post
		*-----------------------------------------------------------------------*/
		$meta_boxes[] = array(
            'id' => 'fave_format_gallery',
            'title' => esc_html__('Gallery Format', 'houzez' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',

            'fields' => array(
                array(
                    'name' => esc_html__('Upload Gallery Images ', 'houzez' ),
                    'desc' => '',
                    'id' => $houzez_prefix . 'gallery_posts',
                    'type' => 'image_advanced',
                    'std' => ''
                )
            )
        );

        $meta_boxes[] = array(
            'id' => 'fave_format_video',
            'title' => esc_html__('Video Format', 'houzez' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',

            'fields' => array(
                array(
                    'name' => esc_html__('Add the video URL', 'houzez' ),
                    'desc' => '',
                    'id' => $houzez_prefix . 'video_post',
                    'type' => 'text',
                    'std' => '',
                    'desc'  => __('Exmaple https://vimeo.com/120596335', 'houzez' )
                )
            )
        );

        $meta_boxes[] = array(
            'id' => 'fave_format_audio',
            'title' => esc_html__('Audio Format', 'houzez' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',

            'fields' => array(
                array(
                    'name' => esc_html__('Add SoundCloud Audio', 'houzez' ),
                    'desc' => '',
                    'id' => $houzez_prefix . 'audio_post',
                    'type' => 'text',
                    'std' => '',
                    'desc'  => esc_html__('Paste the page URL from SoundCloud', 'houzez' )
                )
            )
        );


		
		/*------------------------------------------------------------------------
		* Packages
		*-----------------------------------------------------------------------*/
		$meta_boxes[] = array(
            'title'  => esc_html__( 'Package Details', 'houzez' ),
            'pages'  => array('houzez_packages'),
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

        /* ===========================================================================================
        *   Page Settings
        * ============================================================================================*/
        $meta_boxes[] = array(
            'id'        => 'fave_page_settings',
            'title'     => esc_html__('Page Header Options', 'houzez' ),
            'pages'     => array( 'page' ),
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
                    'name'      => esc_html__('Header Type', 'houzez' ),
                    'id'        => $houzez_prefix . 'header_type',
                    'type'      => 'select',
                    'options'   => array(
                        'none' => esc_html__('None', 'houzez' ),
                        'property_slider' => esc_html__('Properties Slider', 'houzez' ),
                        'rev_slider' => esc_html__('Revolution Slider', 'houzez' ),
                        'property_map' => esc_html__('Properties Map', 'houzez' ),
                        'static_image' => esc_html__('Image', 'houzez' ),
                        'video' => esc_html__('Video', 'houzez' ),
                        'elementor' => esc_html__('Elementor', 'houzez' ),
                    ),
                    'std'       => array( 'none' ),
                    'desc'      => esc_html__('Select the page header type','houzez')
                ),
                array(
                    'name'      => esc_html__('Title', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_title',
                    'placeholder' => esc_html__( 'Enter the title', 'houzez' ),
                    'type' => 'text',
                    'std' => '',
                    'desc' => '',
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),
                array(
                    'name'      => esc_html__('Subtitle', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_subtitle',
                    'placeholder' => esc_html__( 'Enter the subtitle', 'houzez' ),
                    'type' => 'text',
                    'std' => '',
                    'desc' => '',
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),
                array(
                    'name'      => esc_html__('Image', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_image',
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                    'desc'      => '',
                    'visible' => array( $houzez_prefix.'header_type', '=', 'static_image' )
                ),

                array(
                    'name' => esc_html__('MP4 File', 'houzez'),
                    'id' => "{$houzez_prefix}page_header_bg_mp4",
                    'placeholder' => esc_html__( 'Upload the video file', 'houzez' ),
                    'desc' => esc_html__( 'This file is mandatory', 'houzez' ),
                    'type' => 'file_input',
                    'visible' => array( $houzez_prefix.'header_type', '=', 'video' )
                ),
                array(
                    'name' => esc_html__('WEBM File', 'houzez'),
                    'id' => "{$houzez_prefix}page_header_bg_webm",
                    'placeholder' => esc_html__( 'Upload the video file', 'houzez' ),
                    'desc' => esc_html__( 'This file is mandatory', 'houzez' ),
                    'type' => 'file_input',
                    'visible' => array( $houzez_prefix.'header_type', '=', 'video' )
                ),
                array(
                    'name' => esc_html__('OGV File', 'houzez'),
                    'id' => "{$houzez_prefix}page_header_bg_ogv",
                    'placeholder' => esc_html__( 'Upload the video file', 'houzez' ),
                    'desc' => esc_html__( 'This file is mandatory', 'houzez' ),
                    'type' => 'file_input',
                    'visible' => array( $houzez_prefix.'header_type', '=', 'video' )
                ),

                array(
                    'name'      => esc_html__('Video Image', 'houzez'),
                    'id'        => $houzez_prefix . 'page_header_video_img',
                    'placeholder' => esc_html__( 'Upload a video cover image', 'houzez' ),
                    'desc' => esc_html__( 'This file is mandatory', 'houzez' ),
                    'type' => 'image_advanced',
                    'max_file_uploads' => 1,
                    'visible' => array( $houzez_prefix.'header_type', '=', 'video' )
                ),

                array(
                    'name'      => esc_html__('Height', 'houzez' ),
                    'placeholder' => esc_html__( 'Enter the banner height', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_image_height',
                    'type' => 'text',
                    'std' => '',
                    'desc' => esc_html__('Default is 600px', 'houzez'),
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),

                array(
                    'name'      => esc_html__('Height Mobile', 'houzez' ),
                    'placeholder' => esc_html__( 'Enter the banner height for mobile devices', 'houzez' ),
                    'id'        => $houzez_prefix . 'header_image_height_mobile',
                    'type' => 'text',
                    'std' => '',
                    'desc' => esc_html__('Default is 400px', 'houzez'),
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),

                array(
                    'name'      => esc_html__('Overlay Color Opacity', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_image_opacity',
                    'type' => 'select',
                    'options' => array(
                        '0' => '0',
                        '0.1' => '1',
                        '0.2' => '2',
                        '0.3' => '3',
                        '0.35' => '3.5',
                        '0.4' => '4',
                        '0.5' => '5',
                        '0.6' => '6',
                        '0.7' => '7',
                        '0.8' => '8',
                        '0.9' => '9',
                        '1' => '10',
                    ),
                    'std'       => array( '0.35' ),
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),

                array(
                    'name'      => esc_html__('Banner Search', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_search',
                    'type' => 'switch',
                    'style'     => 'rounded',
                    'on_label'  => esc_html__('Enable', 'houzez' ),
                    'off_label' => esc_html__('Disable', 'houzez' ),
                    'std'       => 0,
                    'desc' => '',
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video' ) )
                ),
                
                array(
                    'name'      => esc_html__('Full Screen', 'houzez' ),
                    'id'        => $houzez_prefix . 'header_full_screen',
                    'type' => 'switch',
                    'style'     => 'rounded',
                    'on_label'  => esc_html__('Enable', 'houzez' ),
                    'off_label' => esc_html__('Disable', 'houzez' ),
                    'std'       => 0,
                    'desc'      => esc_html__('If "Enable" it will fit according to screen size' ,'houzez'),
                    'visible' => array( $houzez_prefix.'header_type', 'in', array( 'static_image', 'video', 'property_map', 'property_slider' ) )
                ),
        
                /*------------------ Slider Revolution -------------*/
                array(
                    'name'      => esc_html__('Revolution Slider', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_header_revslider',
                    'type' => 'select_advanced',
                    'std' => '',
                    'options' => houzez_get_revolution_slider(),
                    'multiple'    => false,
                    'placeholder' => esc_html__( 'Select an Slider', 'houzez' ),
                    'desc' => '',
                    'hidden' => array( $houzez_prefix.'header_type', '!=', 'rev_slider' )
                ),

                /*----------------- Map Settings ----------------*/
                array(
                    'name'      => esc_html__('Select City', 'houzez'),
                    'id'        => $houzez_prefix . 'map_city',
                    'type'      => 'select',
                    'options'   => $prop_locations,
                    'desc'      => esc_html__('Select a city where to start the property map on header page. You can select multiple cities or keep all un-select to display properties from all the cities', 'houzez'),
                    'multiple' => true,
                    'class' => 'houzez-map-cities',
                    'hidden' => array( 'fave_header_type', '!=', 'property_map' )
                ),
            )
        );

        /* ===========================================================================================
        *   Page Settings
        * ============================================================================================*/
        $meta_boxes[] = array(
            'id'        => 'fave_default_template_settings',
            'title'     => esc_html__('Page Template Options', 'houzez' ),
            'pages'     => array( 'page' ),
            'context' => 'normal',
            'show'       => array(
                'template' => array(
                    'template/template-page.php'
                ),
            ),

            'fields'    => array(
                array(
                    'name'      => esc_html__('Page Title', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_title',
                    'type'      => 'select',
                    'options'   => array(
                        'show' => esc_html__('Show', 'houzez' ),
                        'hide' => esc_html__('Hide', 'houzez' )
                    ),
                    'std'       => array( 'show' ),
                    'desc'      => '',
                ),
                array(
                    'name'      => esc_html__('Page Breadcrumb', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_breadcrumb',
                    'type'      => 'select',
                    'options'   => array(
                        'show' => esc_html__('Show', 'houzez' ),
                        'hide' => esc_html__('Hide', 'houzez' )
                    ),
                    'std'       => array( 'show' ),
                    'desc'      => '',
                ),
                array(
                    'name'      => esc_html__('Page Sidebar', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_sidebar',
                    'type'      => 'select',
                    'options'   => array(
                        'none' => esc_html__('None', 'houzez' ),
                        'right_sidebar' => esc_html__('Right Sidebar', 'houzez' ),
                        'left_sidebar' => esc_html__('Left Sidebar', 'houzez' )
                    ),
                    'std'       => array( 'right_sidebar' ),
                    'desc'      => esc_html__('Choose page Sidebar','houzez'),
                ),
                array(
                    'name'      => esc_html__('Page Background', 'houzez' ),
                    'id'        => $houzez_prefix . 'page_background',
                    'type'      => 'select',
                    'options'   => array(
                        'none' => esc_html__('None', 'houzez' ),
                        'yes' => esc_html__('Yes', 'houzez' )
                    ),
                    'std'       => array( 'yes' ),
                    'desc'      => esc_html__('Select the page background (only for page template)','houzez'),
                    'hidden' => array( 'fave_page_sidebar', '!=', 'none' )
                )
            )
        );

        /* ===========================================================================================
        *   Transparent menu
        * ============================================================================================*/
        $meta_boxes[] = array(
            'id'        => 'fave_menu_settings',
            'title'     => esc_html__('Page Navigation Options', 'houzez' ),
            'pages'     => array( 'page' ),
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

        /* ===========================================================================================
        *   Advanced Search
        * ============================================================================================*/
        $meta_boxes[] = array(
            'id' => 'fave_advanced_search',
            'title' => esc_html__('Advanced Search', 'houzez' ),
            'pages' => array( 'page' ),
            'context' => 'side',
            'priority' => 'high',

            'fields' => array(

                array(
                    'name' => esc_html__('Advanced Search', 'houzez'),
                    'desc' => '',
                    'id' => $houzez_prefix . 'adv_search_enable',
                    'type' => 'select',
                    'options' => array(
                        'global' => esc_html__('Global ( As theme options settings )', 'houzez'),
                        'current_page' => esc_html__('Custom Settings for this Page', 'houzez')
                    ),
                    'std'   => array( 'global' ),
                    'desc'  => ''
                ),
                array(
                    'name' => esc_html__('Search Options ', 'houzez'),
                    'desc' => '',
                    'id' => $houzez_prefix . 'adv_search',
                    'type' => 'select',
                    'options' => array(
                        'hide' => esc_html__('Hide on this page', 'houzez'),
                        'show' => esc_html__('Show on this page', 'houzez'),
                        'hide_show' => esc_html__('Hide but show on scroll', 'houzez'),
                    ),
                    'std'   => array( 'hide' ),
                    'hidden' => array( 'fave_adv_search_enable', '!=', 'current_page' ),
                ),
                array(
                    'name' => esc_html__('Search Position ', 'houzez'),
                    'desc' => '',
                    'id' => $houzez_prefix . 'adv_search_pos',
                    'type' => 'select',
                    'options' => array(
                        'under_menu' => esc_html__('Under Navigation', 'houzez'),
                        'under_banner' => esc_html__('Under Banners (Sliders, Map, Video, etc)', 'houzez')
                    ),
                    'std'   => array( 'under_menu' ),
                    'hidden' => array( 'fave_adv_search_enable', '!=', 'current_page' ),
                )
            )
        );


		/*------------------------------------------------------------------------
		* Reviews
		*-----------------------------------------------------------------------*/
		$meta_boxes[] = array(
            'id'        => 'houzez_reviews',
            'title'     => esc_html__('Details', 'houzez'),
            'pages'     => array( 'houzez_reviews' ),
            'context' => 'normal',

            'fields'    => array(
                array(
                    'name'    => esc_html__('Where to display?', 'houzez'),
                    'id'      => 'review_post_type',
                    'type'    => 'radio',
                    'options' => array(
                        'property' => esc_html__('Property Detail Page', 'houzez'),
                        'houzez_agent' => esc_html__('Agent Profile', 'houzez'),
                        'houzez_agency' => esc_html__('Agency Profile', 'houzez'),
                    ),
                ),

                array(
                    'name'        => esc_html__('Select a property', 'houzez'),
                    'id'        => 'review_property_id',
                    'type'        => 'post',
                    'post_type'   => 'property',
                    'field_type'  => 'select_advanced',
                    'placeholder' => esc_html__('Select a Property', 'houzez'),
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                    ),
                    'hidden' => array( 'review_post_type', '!=', 'property' )
                ),

                array(
                    'name'        => esc_html__('Select an Agent', 'houzez'),
                    'id'          => 'review_agent_id',
                    'type'        => 'post',
                    'post_type'   => 'houzez_agent',
                    'field_type'  => 'select_advanced',
                    'placeholder' => esc_html__('Select an Agent', 'houzez'),
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                    ),
                    'hidden' => array( 'review_post_type', '!=', 'houzez_agent' )
                ),

                array(
                    'name'        => esc_html__('Select an Agency', 'houzez'),
                    'id'          => 'review_agency_id',
                    'type'        => 'post',
                    'post_type'   => 'houzez_agency',
                    'field_type'  => 'select_advanced',
                    'placeholder' => esc_html__('Select an Agency', 'houzez'),
                    'query_args'  => array(
                        'post_status'    => 'publish',
                        'posts_per_page' => - 1,
                    ),
                    'hidden' => array( 'review_post_type', '!=', 'houzez_agency' )
                ),

                array(
                    'name'            => esc_html__('Rating', 'houzez'),
                    'id'              => 'review_stars',
                    'type'            => 'select',
                    'options' => array(
                        '1' => esc_html__('1 Star - Poor', 'houzez'),
                        '2' => esc_html__('2 Star -  Fair', 'houzez'),
                        '3' => esc_html__('3 Star - Average', 'houzez'),
                        '4' => esc_html__('4 Star - Good', 'houzez'),
                        '5' => esc_html__('5 Star - Excellent', 'houzez'),
                    ),
                    'std'        => '1',
                ),
            )
        );

        /* ===========================================================================================
        *   Taxonomies
        * ============================================================================================*/
        $meta_boxes[] = array(
            'id'        => 'houzez_taxonomies',
            'title'     => esc_html__('Other Settings', 'houzez' ),
            'taxonomies' => array('property_status', 'property_type', 'property_label', 'property_country', 'property_state', 'property_city', 'property_area'),
            

            'fields'    => array(
                array(
                    'name'      => esc_html__('Image', 'houzez' ),
                    'desc'      => esc_html__('Recommended image size 770 x 700 px', 'houzez' ),
                    'id'        => $houzez_prefix . 'taxonomy_img',
                    'type'      => 'image_advanced',
                    'max_file_uploads' => 1,
                ),
                
            )
        );

        $meta_boxes[] = array(
            'id'        => 'houzez_taxonomies_marker',
            'title'     => '',
            'taxonomies' => array( 'property_type' ),
            

            'fields'    => array(
                array(
                    'name'      => esc_html__('Map Marker Icon', 'houzez' ),
                    'id'        => $houzez_prefix . 'marker_icon',
                    'desc'      => esc_html__('Recommended image size 44 x 56 px', 'houzez' ),
                    'type'      => 'image_advanced',
                    'class'      => 'houzez_full_width',
                    'max_file_uploads' => 1,
                ),
                array(
                    'name'      => esc_html__('Map Marker Retina Icon', 'houzez' ),
                    'id'        => $houzez_prefix . 'marker_retina_icon',
                    'desc'      => esc_html__('Recommended image size 88 x 112 px', 'houzez' ),
                    'type'      => 'image_advanced',
                    'class'      => 'houzez_full_width',
                    'max_file_uploads' => 1,
                )
            )
        );

        $meta_boxes[] = array(
            'id'        => 'houzez_taxonomies_custom_link',
            'title'     => '',
            'taxonomies' => array('property_status', 'property_type', 'property_label', 'property_country', 'property_state', 'property_city', 'property_area'),
            

            'fields'    => array(
                array(
                    'name'      => esc_html__('Custom Link', 'houzez' ),
                    'id'        => $houzez_prefix . 'prop_taxonomy_custom_link',
                    'type'      => 'text',
                    'desc' => esc_html__('Enter a custom link for this taxonomy if you want to link it with an external site', 'houzez'),
                ),
                
            )
        );

        $meta_boxes[] = array(
            'id'        => 'houzez_features_tax_meta',
            'title'     => '',
            'taxonomies' => array('property_feature'),
            
            'fields'    => array(
                array(
                    'name'      => esc_html__('Icon Type', 'houzez' ),
                    'id'        => $houzez_prefix . 'feature_icon_type',
                    'type'      => 'select',
                    'options'   => array(
                        'fontawesome' => esc_html__('Fontawesome v.4.7', 'houzez' ),
                        'custom' => esc_html__('Custom Image', 'houzez' ),
                    ),
                    'std'       => array( 'fontawesome' ),
                    'desc'      => '',
                ),
                array(
                    'name'      => esc_html__('Icon', 'houzez' ),
                    'id'        => $houzez_prefix . 'prop_features_icon',
                    'type'      => 'text',
                    'placeholder' => esc_html__('Enter the fontawesome icon class', 'houzez'),
                    'visible' => array( $houzez_prefix.'feature_icon_type', '=', 'fontawesome' ),
                ),
                array(
                    'name'      => esc_html__('Icon', 'houzez' ),
                    'id'        => $houzez_prefix . 'feature_img_icon',
                    'type'      => 'image_advanced',
                    'max_file_uploads' => 1,
                    'desc'      =>esc_html__('Upload icon', 'houzez' ),
                    'visible' => array( $houzez_prefix.'feature_icon_type', '=', 'custom' ),
                )
                
            )
        );

       
        $meta_boxes = apply_filters('houzez_theme_meta', $meta_boxes);

        return $meta_boxes;

    }
} // End Meta boxes

/*------------------------------------------------------------------------
* Meta for rental, wpbookingcalendar plugin required
*-----------------------------------------------------------------------*/

if( !function_exists('houzez_theme_meta_rental_filter')) {
    add_filter( 'houzez_theme_meta', 'houzez_theme_meta_rental_filter', 8, 1 );

    function houzez_theme_meta_rental_filter( $meta_boxes ) {

        $houzez_prefix = 'fave_';

        $meta_boxes[0]['tabs']['listing_rental'] = Array (
            'label' => houzez_option('cls_rental', 'Rental Details'),
            'icon' => 'dashicons-layout',
        );

        $meta_boxes[0]['fields'][450] = array(
                'id' => "{$houzez_prefix}booking_shortcode",
                'name' => esc_html__('Booking Shortcode', 'houzez'),
                'desc' => esc_html__('Enter the booking form shortcode. Example [booking]', 'houzez'),
                'type' => 'text',
                'placeholder' => '[booking]',
                'std' => "",
                'columns' => 12,
                'tab' => 'listing_rental',
            );

        $meta_boxes = apply_filters('houzez_theme_meta_rental', $meta_boxes);

        return $meta_boxes;

    }
}
// Get revolution sliders
if( !function_exists('houzez_get_revolution_slider') ) {
    function houzez_get_revolution_slider()
    {
        global $wpdb;
        $catList = array();
        //Revolution Slider
        if (is_plugin_active('revslider/revslider.php')) {
            $sliders = $wpdb->get_results($q = "SELECT * FROM " . $wpdb->prefix . "revslider_sliders ORDER BY id");

            // Iterate over the sliders
            $catList = array();
            foreach ($sliders as $key => $item) {
                $catList[$item->alias] = stripslashes($item->title);
            }
        }

        return $catList;
    }
}