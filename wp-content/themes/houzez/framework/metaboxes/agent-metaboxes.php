<?php
if( !function_exists('houzez_agent_metaboxes') ) {

    function houzez_agent_metaboxes( $meta_boxes ) {
        $houzez_prefix = 'fave_';

        $agent_categories = array();
        $agent_cities = array();

        $agencies_2_array = array(-1 => houzez_option('cl_none', 'None'));
        $agencies_array = array('' => houzez_option('cl_none', 'None'));
        $agencies_posts = get_posts(array('post_type' => 'houzez_agency', 'posts_per_page' => -1));
        if (!empty($agencies_posts)) {
            foreach ($agencies_posts as $agency_post) {
                $agencies_array[$agency_post->ID] = $agency_post->post_title;
                $agencies_2_array[$agency_post->ID] = $agency_post->post_title;
            }
        }

        houzez_get_terms_array( 'agent_category', $agent_categories );
        houzez_get_terms_array( 'agent_city', $agent_cities );
        
        $meta_boxes[] = array(
            'id'        => 'fave_agents_template',
            'title'     => esc_html__('Agents Options', 'houzez'),
            'post_types'     => array( 'page' ),
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
                    'options'   => array('none' => 'None', 'ID' => 'ID', 'title' => 'Title', 'date' => 'Date', 'rand' => 'Random', 'menu_order' => 'Menu Order' ),
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
            'post_types'  => array('houzez_agent'),
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
                    'id' => "{$houzez_prefix}agent_whatsapp",
                    'name' => esc_html__("WhatsApp", 'houzez'),
                    'placeholder'      => esc_html__('Enter the WhatsApp number with country code', 'houzez'),
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
            'post_types'  => array('houzez_agent'),
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

        return apply_filters('houzez_agent_meta', $meta_boxes);

    }

    add_filter( 'rwmb_meta_boxes', 'houzez_agent_metaboxes' );
}