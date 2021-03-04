<?php
global $houzez_opt_name, $allowed_html_array;
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Splash Page', 'houzez' ),
    'id'     => 'splash-page',
    'desc'   => '',
    'icon'   => 'el-icon-website el-icon-small',
    'fields'        => array(
        array(
            'id'       => 'splash_layout',
            'type'     => 'select',
            'title'    => esc_html__( 'Header Layout', 'houzez' ),
            'subtitle' => '',
            'options'   => array(
                'container-fluid' => 'Full Width',
                'container' => 'Boxed'
            ),
            'desc'     => esc_html__( 'Select the spash page header Layout', 'houzez' ),
            'default'  => 'container-fluid'
        ),
        array(
            'id'       => 'backgroud_type',
            'type'     => 'select',
            'title'    => esc_html__( 'Page Background Type', 'houzez' ),
            'subtitle' => '',
            'options'   => array(
                'image' => 'Background Image',
                'slider' => 'Background Slider',
                'video' => 'Background Video'
            ),
            'desc'     => esc_html__( 'Select the page background type', 'houzez' ),
            'default'  => 'image'
        ),

        array(
            'id'       => 'splash_page_nav',
            'type'     => 'switch',
            'title'    => esc_html__( 'Navigation', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the splash page navigation', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),

        array(
            'id'       => 'splash_menu_align',
            'type'     => 'select',
            'title'    => esc_html__( 'Navigation Align', 'houzez' ),
            'desc' => esc_html__( 'Select the navigation align', 'houzez' ),
            'options'   => array(
                'nav-left'  => esc_html__( 'Left Align', 'houzez' ),
                'nav-right' => esc_html__( 'Right Align', 'houzez' )
            ),
            'default'  => 'nav-right'// 1 = on | 0 = off
        ),

        array(
            'id'       => 'splash_search',
            'type'     => 'switch',
            'title'    => esc_html__( 'Search', 'houzez' ),
            'desc' => esc_html__( 'Enable or disable the search on the splash page', 'houzez' ),
            'default'  => 1,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),

        // Section background image
        array(
            'id'       => 'splash_image_section-start',
            'type'     => 'section',
            'required' => array('backgroud_type', '=', 'image'),
            'title'    => esc_html__( 'Background Image Options', 'houzez' ),
            'subtitle' => '',
            'indent'   => true,
        ),
        array(
            'id'        => 'splash_image',
            'url'       => true,
            'type'      => 'media',
            'title'     => esc_html__('Upload image', 'houzez'),
            'default'   => '',
            'desc'      => esc_html__('Recommended image size 2000px x 1000px.', 'houzez'),
            'subtitle'  => '',
        ),

        array(
            'id'     => 'splash_image_section_end',
            'type'   => 'section',
            'indent' => false,
        ),

        // Section background slider
        array(
            'id'       => 'splash_slider_section-start',
            'type'     => 'section',
            'required' => array('backgroud_type', '=', 'slider'),
            'title'    => esc_html__( 'Background Slider Options', 'houzez' ),
            'subtitle' => '',
            'indent'   => true,
        ),
        array(
            'id'        => 'splash_slider',
            'url'       => true,
            'type'      => 'gallery',
            'title'     => esc_html__('Add/Edit Images', 'houzez'),
            'default'   => '',
            'desc'      => esc_html__('Recommended image size 2000px x 1000px.', 'houzez'),
            'subtitle'  => '',
        ),
        array(
            'id'     => 'splash_slider_section_end',
            'type'   => 'section',
            'indent' => false,
        ),

        // Section background video
        array(
            'id'       => 'splash_video_section-start',
            'type'     => 'section',
            'required' => array('backgroud_type', '=', 'video'),
            'title'    => esc_html__( 'Background Video Options', 'houzez' ),
            'subtitle' => '',
            'indent'   => true,
        ),
        array(
            'id'        => 'splash_bg_mp4',
            'url'       => true,
            'type'      => 'media',
            'mode'       => false,
            'title'     => esc_html__('MP4', 'houzez'),
            'default'   => '',
            'desc'      => esc_html__('Upload the mp4 file', 'houzez'),
            'subtitle'  => 'This file is required',
        ),
        array(
            'id'        => 'splash_bg_webm',
            'url'       => true,
            'type'      => 'media',
            'mode'       => false,
            'title'     => esc_html__('WEBM', 'houzez'),
            'default'   => '',
            'desc'      => esc_html__('Upload the webm file', 'houzez'),
            'subtitle'  => 'This file is required',
        ),
        array(
            'id'        => 'splash_bg_ogv',
            'url'       => true,
            'type'      => 'media',
            'mode'       => false,
            'title'     => esc_html__('OGV', 'houzez'),
            'default'   => '',
            'desc'      => esc_html__('Upload the ogv file', 'houzez'),
            'subtitle'  => 'This file is required',
        ),
        array(
            'id'        => 'splash_video_image',
            'url'       => true,
            'type'      => 'media',
            'title'     => esc_html__('Video Cover Image', 'houzez'),
            'default'   => '',
            'desc'      => esc_html__('Upload the cover image file', 'houzez'),
            'subtitle'  => 'This file is required',
        ),
        array(
            'id'     => 'splash_video_section_end',
            'type'   => 'section',
            'indent' => false,
        ),

    ),
));

Redux::setSection( $houzez_opt_name, array(
    'title'            => esc_html__( 'Welcome Title', 'houzez' ),
    'id'               => 'splash-welcome',
    'subsection'       => true,
    'desc'             => '',
    'fields'           => array(
        array(
            'id'       => 'splash_welcome_text',
            'type'     => 'text',
            'title'    => esc_html__( 'Page Title', 'houzez' ),
            'desc' => esc_html__( 'Enter the title', 'houzez' ),
            'default'  => 'Welcome, Make Yourself At Home',
        ),
        array(
            'id'       => 'splash_welcome_sub',
            'type'     => 'text',
            'title'    => esc_html__( 'Splash Page Subtitle', 'houzez' ),
            'desc' => esc_html__( 'Enter the sub-title', 'houzez' ),
            'default'  => '',
        )
    )
) );

Redux::setSection( $houzez_opt_name, array(
    'title'            => esc_html__( 'Call Us', 'houzez' ),
    'id'               => 'splash-callus',
    'subsection'       => true,
    'desc'             => '',
    'fields'           => array(
        array(
            'id'        => 'splash_callus_text',
            'type'      => 'text',
            'title'     => esc_html__('Text', 'houzez'),
            'default'   => 'Call Us',
            'desc'      => esc_html__( 'Enter the text', 'houzez' ),
            'subtitle'  => '',
        ),
        array(
            'id'        => 'splash_callus_phone',
            'type'      => 'text',
            'title'     => esc_html__('Phone Number', 'houzez'),
            'default'   => '(800) 897 6543',
            'desc'      => esc_html__( 'Enter the phone number', 'houzez' ),
            'subtitle'  => '',
        ),
    )
) );

Redux::setSection( $houzez_opt_name, array(
    'title'            => esc_html__( 'Social Media', 'houzez' ),
    'id'               => 'splash-social',
    'subsection'       => true,
    'desc'             => '',
    'fields'           => array(
        array(
            'id'       => 'social-splash',
            'type'     => 'switch',
            'title'    => esc_html__( 'Social Media Icons', 'houzez' ),
            'desc'     => esc_html__( 'Enable or disable the social media icons', 'houzez' ),
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'sp-facebook',
            'type'     => 'text',
            'required' => array( 'social-splash', '=', '1' ),
            'title'    => esc_html__( 'Facebook', 'houzez' ),
            'desc' => esc_html__( 'Enter the Facebook profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'sp-twitter',
            'type'     => 'text',
            'required' => array( 'social-splash', '=', '1' ),
            'title'    => esc_html__( 'Twitter', 'houzez' ),
            'desc' => esc_html__( 'Enter the Twitter profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'sp-googleplus',
            'type'     => 'text',
            'required' => array( 'social-splash', '=', '1' ),
            'title'    => esc_html__( 'Google Plus', 'houzez' ),
            'desc' => esc_html__( 'Enter the Google Plus profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'sp-linkedin',
            'type'     => 'text',
            'required' => array( 'social-splash', '=', '1' ),
            'title'    => esc_html__( 'Linked In', 'houzez' ),
            'desc' => esc_html__( 'Enter the Linkedin profile URL', 'houzez' ),
            'default'  => false,
        ),
        array(
            'id'       => 'sp-instagram',
            'type'     => 'text',
            'required' => array( 'social-splash', '=', '1' ),
            'title'    => esc_html__( 'Instagram', 'houzez' ),
            'desc' => esc_html__( 'Enter the Instagram profile URL', 'houzez' ),
            'default'  => false,
        )
    )
) );

Redux::setSection( $houzez_opt_name, array(
    'title'            => esc_html__( 'Logo Link', 'houzez' ),
    'id'               => 'splash-logo-link',
    'subsection'       => true,
    'desc'             => '',
    'fields'           => array(
        array(
            'id'       => 'splash-logolink-type',
            'type'     => 'select',
            'title'    => esc_html__( 'Splash Page Logo Link', 'houzez' ),
            'desc'     => esc_html__( 'Select a page from the list or custom', 'houzez' ),
            'subtitle' => '',
            'options' => array(
                'home_page' => 'Home Page',
                'custom' => 'Custom'
            ),
            'default'  => 'home_page'
        ),

        array(
            'id'       => 'splash-logolink',
            'type'     => 'text',
            'required' => array('splash-logolink-type', '=', 'custom'),
            'title'    => esc_html__( 'Custom Link', 'houzez' ),
            'desc'     => esc_html__( 'Enter the URL', 'houzez' ),
            'subtitle' => '',
            'default'  => ''
        )
    )
) );