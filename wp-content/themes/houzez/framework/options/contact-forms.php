<?php
global $houzez_opt_name;
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Contact Forms', 'houzez' ),
    'id'     => 'contact-form-7',
    'desc'   => '',
    'icon'   => 'el-icon-envelope el-icon-small',
    'fields'        => array(
        array(
            'id'       => 'form_type',
            'type'     => 'select',
            'title'    => esc_html__('Agent Form Type', 'houzez'),
            'desc' => esc_html__('Select which forms you want to use.', 'houzez'),
            'options'  => array(
                'custom_form' => 'Houzez Custom Forms',
                'contact_form_7_gravity_form' => 'Contact Form 7 or Gravity Form',
            ),
            'default' => 'custom_form',
        ),

        array(
            'id'       => 'terms_condition',
            'type'     => 'select',
            'data'     => 'pages',
            'title'    => esc_html__( 'Terms & Conditions Page', 'houzez' ),
            'subtitle' => '',
            'desc'     => esc_html__( 'Select which page to use for Terms & Conditions', 'houzez' ),
        ),
       
        array(
            'id'       => 'contact_form_agent_above_image',
            'type'     => 'text',
            'title'    => esc_html__( 'Agent Contact Form', 'houzez' ),
            //'desc'     => '',
            'desc' => esc_html__( 'Enter the contact form shortcode for the agent form above image, sidebar and property gallery lightbox.', 'houzez' ),
            'default'  => '',
            'required' => array( 'form_type', '!=', 'custom_form' ),
        ),

        array(
            'id'       => 'contact_form_agent_bottom',
            'type'     => 'text',
            'required' => array( 'form_type', '!=', 'custom_form' ),
            'title'    => esc_html__( 'Agent Contact Form Bottom', 'houzez' ),
            //'desc'     => '',
            'desc' => esc_html__( 'Enter the contact form shortcode for the agent form at the bottom of the property detail page.', 'houzez' ),
            'default'  => ''
        ),

        array(
            'id'       => 'schedule_tour_shortcode',
            'type'     => 'text',
            'required' => array( 'form_type', '!=', 'custom_form' ),
            'title'    => esc_html__( 'Schedule Tour Form', 'houzez' ),
            //'desc'     => '',
            'desc' => esc_html__( 'Enter the contact form shortcode for the schedule tour form on property detail page.', 'houzez' ),
            'default'  => ''
        ),

        array(
            'id'       => 'contact_form_agent_detail',
            'type'     => 'text',
            'required' => array( 'form_type', '!=', 'custom_form' ),
            'title'    => esc_html__( 'Agent Profile Page From', 'houzez' ),
            //'desc'     => '',
            'desc' => esc_html__( 'Enter the contact form shortcode for the agent detail page.', 'houzez' ),
            'default'  => ''
        ),

        array(
            'id'       => 'contact_form_agency_detail',
            'type'     => 'text',
            'required' => array( 'form_type', '!=', 'custom_form' ),
            'title'    => esc_html__( 'Agency Profile Page Form', 'houzez' ),
            //'desc'     => '',
            'desc' => esc_html__( 'Enter the contact form shortcode for the agency detail page.', 'houzez' ),
            'default'  => ''
        ),

        array(
            'id'       => 'agent_form_above_image',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Page', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the agent contact form on property featured image for property detail v.1', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),

        array(
            'id'       => 'agent_form_sidebar',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Page Sidebar Form', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the agent contact form on the property detail page sidebar', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),

        array(
            'id'       => 'agent_form_gallery',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Page Popup Gallery Form', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the agent contact form on the property detail popup gallery', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),

        array(
            'id'       => 'agent_form_agent_page',
            'type'     => 'switch',
            'title'    => esc_html__( 'Agent Profile Page Form', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the agent contact form on the agent detail page', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'agency_form_agency_page',
            'type'     => 'switch',
            'title'    => esc_html__( 'Agency Profile Page Form', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the agent contact form on the agency detail page', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),

        array(
            'id'       => 'agent_view_listing',
            'type'     => 'switch',
            'title'    => esc_html__( 'View Listings Button', 'houzez' ),
            //'desc'     => '',
            'desc' => esc_html__( 'Enable or disable the view listings on the agent form.', 'houzez' ),
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),
        array(
            'id'       => 'agent_phone_num',
            'type'     => 'switch',
            'title'    => esc_html__( 'Phone Number', 'houzez' ),
            'desc' => esc_html__( 'Do you want to display the agent phone number?', 'houzez' ),
            'default'  => 1,
            'on'       => 'Yes',
            'off'      => 'No',
        ),
        array(
            'id'       => 'agent_mobile_num',
            'type'     => 'switch',
            'title'    => esc_html__( 'Mobile Number', 'houzez' ),
            'desc' => esc_html__( 'Do you want to display the agent mobile number?', 'houzez' ),
            'default'  => 1,
            'on'       => 'Yes',
            'off'      => 'No',
        ),
        array(
            'id'       => 'agent_whatsapp_num',
            'type'     => 'switch',
            'title'    => esc_html__( 'WhatsApp', 'houzez' ),
            'desc' => esc_html__( 'Do you want to display the agent WhatsApp?', 'houzez' ),
            'default'  => 1,
            'on'       => 'Yes',
            'off'      => 'No',
        ),

        array(
            'id'       => 'agent_direct_messages',
            'type'     => 'switch',
            'title'    => esc_html__( 'Direct Message Button', 'houzez' ),
            'subtitle'    => esc_html__( 'Do you want to display direct message button for agent contact forms?', 'houzez' ),
            'desc' => esc_html__( 'Please make sure you have create message page using User Dashboard Messages template.', 'houzez' ),
            'default'  => 0,
            'on'       => 'Yes',
            'off'      => 'No',
        ),

        array(
            'id'       => 'agent_skype_con',
            'type'     => 'switch',
            'title'    => esc_html__( 'Skype', 'houzez' ),
            'desc' => esc_html__( 'Do you want to display the agent Skype?', 'houzez' ),
            'default'  => 1,
            'on'       => 'Yes',
            'off'      => 'No',
        ),
        array(
            'id'       => 'agent_con_social',
            'type'     => 'switch',
            'title'    => esc_html__( 'Social Icons', 'houzez' ),
            'desc' => esc_html__( 'Do you want to display the agent social icons?', 'houzez' ),
            'default'  => 1,
            'on'       => 'Yes',
            'off'      => 'No',
        ),
    ),
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Show/Hide Form Fields', 'houzez' ),
    'id'     => 'contactforms-showhide',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'prop_detail_agent_form_fields_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Property Detail Agent Form', 'houzez'),
            'subtitle' => '',
            'indent'   => true,
        ),
        array(
            'id'       => 'hide_prop_contact_form_fields',
            'type'     => 'checkbox',
            'title'    => esc_html__( 'Contact form Fields', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__('Select which fields you want to disable from the property detail page agent contact form', 'houzez'),
            'options'  => array(
                'name' => esc_html__('Name', 'houzez'),
                'phone' => esc_html__('Phone', 'houzez'),
                'message' => esc_html__('Message', 'houzez'),
                'usertype' => esc_html__('User Type', 'houzez'),
            ),
            'default' => array(
                'name' => '0',
                'phone' => '0',
                'message' => '0',
                'usertype' => '0',
            )
        ),
        array(
            'id'       => 'prop_detail_agent_form_fields_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),

        array(
            'id'       => 'agency_agent_form_fields_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Agency & Agent Page Contact Form', 'houzez'),
            'subtitle' => '',
            'indent'   => true,
        ),
        array(
            'id'       => 'hide_agency_agent_contact_form_fields',
            'type'     => 'checkbox',
            'title'    => esc_html__( 'Contact form Fields', 'houzez' ),
            'desc'     => '',
            'subtitle' => esc_html__('Select which fields you want to disable from the agency & agent page contact form', 'houzez'),
            'options'  => array(
                'name' => esc_html__('Name', 'houzez'),
                'phone' => esc_html__('Phone', 'houzez'),
                'message' => esc_html__('Message', 'houzez'),
                'usertype' => esc_html__('User Type', 'houzez'),
            ),
            'default' => array(
                'name' => '0',
                'phone' => '0',
                'message' => '0',
                'usertype' => '0',
            )
        ),
        array(
            'id'       => 'agency_agent_form_fields_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),

        array(
            'id'       => 'show_gdpr_section-start',
            'type'     => 'section',
            'title'    => esc_html__('Terms & Condition and GDPR checkbox', 'houzez'),
            'subtitle' => '',
            'indent'   => true,
        ),

        array(
            'id'       => 'gdpr_and_terms_checkbox',
            'type'     => 'switch',
            'title'    => '',
            'subtitle' => esc_html__( 'GDPR/Terms & Condition checkbox for forms', 'houzez' ),
            'default'  => 1,
            'on'       => 'Yes',
            'off'      => 'No',
        ),


        array(
            'id'       => 'show_gdpr_section-end',
            'type'     => 'section',
            'indent'   => false,
        ),
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Redirection', 'houzez' ),
    'id'     => 'contactforms-redirection',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        
        array(
            'id'       => 'agent_form_redirect',
            'type'     => 'select',
            'title'    => esc_html__('Select Page For Redirection', 'houzez'),
            'subtitle' => esc_html__('User will be redirected to selected page after agent form submission', 'houzez'),
            'data'      => 'pages',
        ),
        
    )
));