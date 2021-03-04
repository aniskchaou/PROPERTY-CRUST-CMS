<?php
global $houzez_opt_name;
Redux::setSection( $houzez_opt_name, array(
    'title'            => esc_html__( 'Headers', 'houzez' ),
    'id'               => 'headers',
    'desc'             => '',
    'customizer_width' => '400px',
    'icon'             => 'el-icon-website el-icon-small',
) );
Redux::setSection( $houzez_opt_name, array(
    'title'            => esc_html__( 'Style', 'houzez' ),
    'id'               => 'header-styles',
    'subsection'       => true,
    'desc'             => '',
    'fields'           => array(
        array(
            'id'       => 'header_style',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Header Style', 'houzez' ),
            'subtitle' => '',
            'default'  => '1',// 1 = on | 0 = off
            'options'  => array(
                '1' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'header/header-style-1.jpg'
                ),
                '2' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'header/header-style-2.jpg'
                ),
                '3' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'header/header-style-3.jpg'
                ),
                '4' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'header/header-style-4.jpg'
                ),
                '5' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'header/header-style-5.jpg'
                ),
                '6' => array(
                    'alt' => '',
                    'img' => HOUZEZ_IMAGE . 'header/header-style-6.jpg'
                ),
                
            ),
            'desc'     => '',
        ),
        array(
            'id'       => 'header_1_width',
            'type'     => 'select',
            'title'    => esc_html__( 'Header Layout', 'houzez' ),
            'subtitle' => '',
            'required' => array('header_style', '=', '1'),
            'options'	=> array(
                'container'	=> esc_html__( 'Boxed', 'houzez' ),
                'container-fluid'	=> esc_html__( 'Full Width', 'houzez' )
            ),
            'desc'     => esc_html__( 'Select the header layout', 'houzez' ),
            'default'  => 'container'// 1 = on | 0 = off
        ),
        array(
            'id'       => 'header_1_menu_align',
            'type'     => 'select',
            'title'    => esc_html__( 'Navigation Align', 'houzez' ),
            'subtitle' => '',
            'required' => array('header_style', '=', '1' ),
            'options'	=> array(
                'nav-left'	=> esc_html__( 'Left Align', 'houzez' ),
                'nav-right'	=> esc_html__( 'Right Align', 'houzez' )
            ),
            'desc'     => esc_html__( 'Select the navigation align', 'houzez' ),
            'default'  => 'nav-right'// 1 = on | 0 = off
        ),

        array(
            'id'       => 'header_1_height',
            'type'     => 'text',
            'required' => array('header_style', '=', '1'),
            'title'    => esc_html__( 'Header Height', 'houzez' ),
            'subtitle' => '',
            'default'    => '60',
            'validate' => 'numeric',
        ),
        array(
            'id'       => 'header_2_height',
            'type'     => 'text',
            'required' => array('header_style', '=', '2'),
            'title'    => esc_html__( 'Header Height', 'houzez' ),
            'subtitle' => '',
            'default'    => '54',
            'validate' => 'numeric',
        ),
        array(
            'id'       => 'header_3_top_height',
            'type'     => 'text',
            'required' => array('header_style', '=', '3'),
            'title'    => esc_html__( 'Header Top Height', 'houzez' ),
            'subtitle' => '',
            'default'    => '80',
            'validate' => 'numeric',
        ),

        array(
            'id'       => 'header_3_bottom_height',
            'type'     => 'text',
            'required' => array('header_style', '=', '3'),
            'title'    => esc_html__( 'Header Bottom Height', 'houzez' ),
            'subtitle' => '',
            'default'    => '54',
            'validate' => 'numeric',
        ),

        array(
            'id'       => 'header_4_height',
            'type'     => 'text',
            'required' => array('header_style', '=', '4'),
            'title'    => esc_html__( 'Header Height', 'houzez' ),
            'subtitle' => '',
            'default'    => '90',
            'validate' => 'numeric',
        ),

        array(
            'id'       => 'header_5_top_height',
            'type'     => 'text',
            'required' => array('header_style', '=', '5'),
            'title'    => esc_html__( 'Header Top Height', 'houzez' ),
            'subtitle' => '',
            'default'    => '110',
            'validate' => 'numeric',
        ),

        array(
            'id'       => 'header_5_bottom_height',
            'type'     => 'text',
            'required' => array('header_style', '=', '5'),
            'title'    => esc_html__( 'Header Bottom Height', 'houzez' ),
            'subtitle' => '',
            'default'    => '54',
            'validate' => 'numeric',
        ),

        array(
            'id'       => 'header_6_height',
            'type'     => 'text',
            'required' => array('header_style', '=', '6'),
            'title'    => esc_html__( 'Header Height', 'houzez' ),
            'subtitle' => '',
            'default'    => '60',
            'validate' => 'numeric',
        ),

        array(
            'id'       => 'main-menu-sticky',
            'type'     => 'switch',
            'title'    => esc_html__( 'Sticky Menu - Desktop Devices', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the sticky menu on desktop devices', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'header_4_width',
            'type'     => 'select',
            'title'    => esc_html__( 'Layout', 'houzez' ),
            'subtitle' => '',
            'required' => array('header_style', '=', '4'),
            'options'   => array(
                'container' => esc_html__( 'Boxed', 'houzez' ),
                'container-fluid'   => esc_html__( 'Full Width', 'houzez' )
            ),
            'desc' => esc_html__( 'Select the header layout', 'houzez' ),
            'default'  => 'container'// 1 = on | 0 = off
        ),
        array(
            'id'       => 'header_4_menu_align',
            'type'     => 'select',
            'title'    => esc_html__( 'Navigation Align', 'houzez' ),
            'desc' => esc_html__( 'Select the navigation align', 'houzez' ),
            'required' => array('header_style', '=', '4' ),
            'options'	=> array(
                'nav-left'	=> esc_html__( 'Left Align', 'houzez' ),
                'nav-right'	=> esc_html__( 'Right Align', 'houzez' )
            ),
            'default'  => 'nav-left'// 1 = on | 0 = off
        ),

        array(
            'id'       => 'hd1_4_phone_enable',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable or disable phone numder for header 1 & 4', 'houzez' ),
            'required' => array( 
                array('header_style', '!=', '2'),
                array('header_style', '!=', '3'),
                array('header_style', '!=', '5'),
                array('header_style', '!=', '6')
            ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),

        array(
            'id'       => 'hd1_4_phone',
            'type'     => 'text',
            'required' => array('hd1_4_phone_enable', '=', '1'),
            'title'    => esc_html__( 'Phone Number', 'houzez' ),
            'default'    => '+1 (800) 987 6543',
            'subtitle' => '',
        ),

        array(
            'id'       => 'hd3_callus_section-start',
            'type'     => 'section',
            'required' => array('header_style', '=', '3'),
            'title'    => esc_html__( 'Call Us', 'houzez' ),
            'subtitle' => esc_html__( 'Call us number in header', 'houzez' ),
            'indent'   => true, // Indent all options below until the next 'section' option is set.
        ),
        array(
            'id'       => 'hd3_callus',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable or disable the call us box in the header', 'houzez' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'hd3_call_us_image',
            'type'     => 'media',
            'required' => array('hd3_callus', '=', '1'),
            'url'      => true,
            'title'    => esc_html__( 'Upload image', 'houzez' ),
            'subtitle' => esc_html__('Recommended size 85 x 85', 'houzez'),
            'default'	=> array(
                'url'	=> get_template_directory_uri() . '/img/call-image.png'
            ),
        ),
        array(
            'id'       => 'hd3_call_us_text',
            'type'     => 'text',
            'title'    => esc_html__( 'Text', 'houzez' ),
            'required' => array('hd3_callus', '=', '1'),
            'default'    => 'Call Us:',
            'subtitle' => '',
        ),
        array(
            'id'       => 'hd3_phone',
            'type'     => 'text',
            'required' => array('hd3_callus', '=', '1'),
            'title'    => esc_html__( 'Phone Number', 'houzez' ),
            'default'    => '1-800-987-6543',
            'subtitle' => '',
        ),
        array(
            'id'     => 'hd3_callus_section_end',
            'type'   => 'section',
            'indent' => false, // Indent all options below until the next 'section' option is set.
        ),

        /*
         *  Header 2 Contact Info
         * -----------------------------------------------------------------------*/
        array(
            'id'       => 'hd2_contact-start',
            'type'     => 'section',
            'required' => array('header_style', '=', '2'),
            'title'    => esc_html__( 'Contact Information', 'houzez' ),
            'subtitle' => '',
            'indent'   => true,
        ),
        array(
            'id'       => 'hd2_contact_info',
            'type'     => 'switch',
            'title'    => esc_html__( 'Contact Information', 'houzez' ),
            'desc'     => esc_html__( 'Enable or disable the contact information', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'hd2_contact_phone',
            'type'     => 'text',
            'required' => array('hd2_contact_info', '=', '1'),
            'title'    => esc_html__( 'Phone Number', 'houzez' ),
            'subtitle' => '',
            'default'	=> '1 800 987 6543',
            'desc'     => esc_html__( 'Enter the phone number', 'houzez' ),
        ),
        array(
            'id'       => 'hd2_contact_email',
            'type'     => 'text',
            'required' => array('hd2_contact_info', '=', '1'),
            'title'    => esc_html__( 'Email Address', 'houzez' ),
            'subtitle' => '',
            'default'	=> 'info@houzez.com',
            'desc'     => esc_html__( 'Enter the email address', 'houzez' ),
        ),
        array(
            'id'     => 'hd2_contact_section_end',
            'type'   => 'section',
            'indent' => false,
        ),

        /*
         *  Header 2 Address
         * -----------------------------------------------------------------------*/
        array(
            'id'       => 'hd2_address-start',
            'type'     => 'section',
            'required' => array('header_style', '=', '2'),
            'title'    => esc_html__( 'Address', 'houzez' ),
            'subtitle' => '',
            'indent'   => true,
        ),
        array(
            'id'       => 'hd2_address_info',
            'type'     => 'switch',
            'title'    => esc_html__( 'Address', 'houzez' ),
            'desc'     => esc_html__( 'Enable or disable the address', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'hd2_address_line1',
            'type'     => 'text',
            'required' => array('hd2_address_info', '=', '1'),
            'title'    => esc_html__( 'Line 1', 'houzez' ),
            'subtitle' => '',
            'default'	=> 'Oceanview Hall',
            'desc'     => esc_html__( 'Enter the address line 1', 'houzez' ),
        ),
        array(
            'id'       => 'hd2_address_line2',
            'type'     => 'text',
            'required' => array('hd2_address_info', '=', '1'),
            'title'    => esc_html__( 'Line 2', 'houzez' ),
            'subtitle' => '',
            'default'	=> 'Miami, FL 33141',
            'desc'     => esc_html__( 'Enter the address line 2', 'houzez' ),
        ),
        array(
            'id'     => 'hd2_address_section_end',
            'type'   => 'section',
            'indent' => false,
        ),


        /*
         *  Header 2 Timing
         * -----------------------------------------------------------------------*/
        array(
            'id'       => 'hd2_timing-start',
            'type'     => 'section',
            'required' => array('header_style', '=', '2'),
            'title'    => esc_html__( 'Office Timing', 'houzez' ),
            'subtitle' => '',
            'indent'   => true,
        ),
        array(
            'id'       => 'hd2_timing_info',
            'type'     => 'switch',
            'title'    => esc_html__( 'Office Timing', 'houzez' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
            'desc'     => esc_html__( 'Enable or disable the office time', 'houzez' ),
        ),
        array(
            'id'       => 'hd2_timing_hours',
            'type'     => 'text',
            'required' => array('hd2_timing_info', '=', '1'),
            'title'    => esc_html__( 'Opening Hours', 'houzez' ),
            'subtitle' => '',
            'default'	=> '9 am to 6 pm',
            'desc'     => esc_html__( 'Enter the opening hours', 'houzez' ),

        ),
        array(
            'id'       => 'hd2_timing_days',
            'type'     => 'text',
            'required' => array('hd2_timing_info', '=', '1'),
            'title'    => esc_html__( 'Opening Days', 'houzez' ),
            'subtitle' => '',
            'default'	=> 'Monday to Friday',
            'desc'     => esc_html__( 'Enter the opening days', 'houzez' ),
        ),
        array(
            'id'     => 'hd2_timing_section_end',
            'type'   => 'section',
            'indent' => false,
        )
    )
) );

Redux::setSection( $houzez_opt_name, array(
    'title'            => esc_html__( 'Social Media', 'houzez' ),
    'id'               => 'header-social',
    'subsection'       => true,
    'desc'             => '',
    'fields'           => array(
        array(
            'id'       => 'social-header',
            'type'     => 'switch',
            'title'    => esc_html__( 'Social Media Icons', 'houzez' ),
            'subtitle' => esc_html__('Only for header style 2, 3 and the top bar', 'houzez'),
            'desc'     => esc_html__( 'Enable or disable the social media in the header', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'hs-facebook',
            'type'     => 'text',
            'required' => array( 'social-header', '=', '1' ),
            'title'    => esc_html__( 'Facebook', 'houzez' ),
            'desc' => esc_html__( 'Enter the Facebook profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'hs-twitter',
            'type'     => 'text',
            'required' => array( 'social-header', '=', '1' ),
            'title'    => esc_html__( 'Twitter', 'houzez' ),
            'desc' => esc_html__( 'Enter the Twitter profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'hs-googleplus',
            'type'     => 'text',
            'required' => array( 'social-header', '=', '1' ),
            'title'    => esc_html__( 'Google Plus', 'houzez' ),
            'desc' => esc_html__( 'Enter Google Plus profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'hs-linkedin',
            'type'     => 'text',
            'required' => array( 'social-header', '=', '1' ),
            'title'    => esc_html__( 'Linked In', 'houzez' ),
            'desc' => esc_html__( 'Enter the Linkedin profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'hs-instagram',
            'type'     => 'text',
            'required' => array( 'social-header', '=', '1' ),
            'title'    => esc_html__( 'Instagram', 'houzez' ),
            'desc' => esc_html__( 'Enter the Instagram profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'hs-pinterest',
            'type'     => 'text',
            'required' => array( 'social-header', '=', '1' ),
            'title'    => esc_html__( 'Pinterest', 'houzez' ),
            'desc' => esc_html__( 'Enter the Pinterest profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'hs-youtube',
            'type'     => 'text',
            'required' => array( 'social-header', '=', '1' ),
            'title'    => esc_html__( 'Youtube', 'houzez' ),
            'desc' => esc_html__( 'Enter the Youtube profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'hs-yelp',
            'type'     => 'text',
            'required' => array( 'social-header', '=', '1' ),
            'title'    => esc_html__( 'Yelp', 'houzez' ),
            'desc' => esc_html__( 'Enter the Yelp profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'hs-behance',
            'type'     => 'text',
            'required' => array( 'social-header', '=', '1' ),
            'title'    => esc_html__( 'Behance', 'houzez' ),
            'desc' => esc_html__( 'Enter the Behance profile URL', 'houzez' ),
            'default'  => false,
        )
    )
) );

Redux::setSection( $houzez_opt_name, array(
    'title'            => esc_html__( 'Create Listing Button', 'houzez' ),
    'id'               => 'header-create-listings',
    'subsection'       => true,
    'desc'             => '',
    'fields'           => array(
        array(
            'id'       => 'create_lisiting_enable',
            'type'     => 'switch',
            'title'    => esc_html__( 'Create Listing Button', 'houzez' ),
            'desc' => esc_html__('Enable or disable the Create Listing button on the header', 'houzez'),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'create_listing_button',
            'type'     => 'select',
            'title'    => esc_html__( 'Button Behavior', 'houzez' ),
            'desc' => esc_html__('Is the login required to create a new listing?', 'houzez'),
            'default'  => 'no',
            'options'  => array(
                'no' => esc_html__('No', 'houzez'),
                'yes' => esc_html__('Yes', 'houzez'),
            )
        )
    )
) );