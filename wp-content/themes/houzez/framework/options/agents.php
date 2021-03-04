<?php
global $houzez_opt_name, $allowed_html_array;
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Agents', 'houzez' ),
    'id'     => 'houzez-agents',
    'desc'   => '',
    'icon'   => 'el-icon-user el-icon-small',
    'fields'        => array(
        array(
            'id'       => 'num_of_agents',
            'type'     => 'text',
            'title'    => esc_html__( 'Number of Agents', 'houzez' ),
            'subtitle'    => esc_html__( 'Number of agents to display on the All Agents page template', 'houzez' ),
            'desc'    => esc_html__( 'Enter the number of agents', 'houzez' ),
            'default'  => '9'
        ),
        array(
            'id'       => 'agent_tabs',
            'type'     => 'switch',
            'title'    => esc_html__( 'Tabs', 'houzez' ),
            'subtitle' => esc_html__('Property status tabs displayed in the agent detail page', 'houzez'),
            'desc' => esc_html__( 'Enable or disable the tabs on agent detail page', 'houzez' ),
            'default'  => 0,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),
        array(
            'id'       => 'agent_detail_tab_1',
            'type'     => 'select',
            'title'    => esc_html__('Tab 1', 'houzez'),
            'subtitle' => esc_html__('Property status tab in the agent detail page', 'houzez'),
            'desc'     => esc_html__('Select the status', 'houzez'),
            'data'     => 'terms',
            'required' => array('agent_tabs', '=', '1'),
            'args'        =>  array('taxonomy'=>'property_status'),
            'default' => ''
        ),
        array(
            'id'       => 'agent_detail_tab_2',
            'type'     => 'select',
            'title'    => esc_html__('Tab 2', 'houzez'),
            'subtitle' => esc_html__('Property status tab in the agent detail page', 'houzez'),
            'desc'     => esc_html__('Select the status', 'houzez'),
            'required' => array('agent_tabs', '=', '1'),
            'data'        => 'terms',
            'args'        =>  array('taxonomy'=>'property_status'),
            'default' => ''
        ),

        array(
            'id'       => 'agent_listings_layout',
            'type'     => 'select',
            'title'    => __('Listings Layout', 'houzez'),
            'subtitle' => __('Select the listings layout for the agent detail page', 'houzez'),
            'desc'     => esc_html__('Select the layout', 'houzez'),
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
            'id'       => 'num_of_agent_listings',
            'type'     => 'text',
            'title'    => esc_html__( 'Number of Listings', 'houzez' ),
            'subtitle'    => esc_html__( 'Number of listings to display on the agent detail page', 'houzez' ),
            'desc'    => esc_html__( 'Enter the number of listings', 'houzez' ),
            'default'  => '10'
        ),
        array(
            'id'       => 'agent_listings_order',
            'type'     => 'select',
            'title'    => __('Default Order', 'houzez'),
            'subtitle' => __('Listings order on the agent detail page', 'houzez'),
            'desc' => __('Select the listings order.', 'houzez'),
            'options'  => array(
                'default' => esc_html__( 'Default', 'houzez' ),
                'd_date' => esc_html__( 'Date New to Old', 'houzez' ),
                'a_date' => esc_html__( 'Date Old to New', 'houzez' ),
                'd_price' => esc_html__( 'Price (High to Low)', 'houzez' ),
                'a_price' => esc_html__( 'Price (Low to High)', 'houzez' ),
                'featured_first' => esc_html__( 'Show Featured Listings on Top', 'houzez' ),
            ),
            'default' => 'default'
        ),

        array(
            'id'       => 'agent_mobile',
            'type'     => 'switch',
            'title'    => esc_html__( 'Mobile', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),
        array(
            'id'       => 'agent_phone',
            'type'     => 'switch',
            'title'    => esc_html__( 'Office Phone', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),

         array(
            'id'       => 'agent_fax',
            'type'     => 'switch',
            'title'    => esc_html__( 'Fax', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),

         array(
            'id'       => 'agent_email',
            'type'     => 'switch',
            'title'    => esc_html__( 'Email', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),

         array(
            'id'       => 'agent_website',
            'type'     => 'switch',
            'title'    => esc_html__( 'Website', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),

         array(
            'id'       => 'agent_social',
            'type'     => 'switch',
            'title'    => esc_html__( 'Social', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),

        array(
            'id'       => 'agent_stats',
            'type'     => 'switch',
            'title'    => esc_html__( 'Stats', 'houzez' ),
            'subtitle' => esc_html__('Enable or disable the stats on agent detail page', 'houzez'),
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),
        array(
            'id'       => 'agent_review',
            'type'     => 'switch',
            'title'    => esc_html__( 'Review & Rating', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),
        array(
            'id'       => 'agent_listings',
            'type'     => 'switch',
            'title'    => esc_html__( 'Listings', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),
        array(
            'id'       => 'agent_bio',
            'type'     => 'switch',
            'title'    => esc_html__( 'About Agent', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),
        array(
            'id'       => 'agent_sidebar',
            'type'     => 'switch',
            'title'    => esc_html__( 'Agent Sidebar', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),
    ),
    
));