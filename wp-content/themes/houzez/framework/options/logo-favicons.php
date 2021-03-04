<?php
global $houzez_opt_name;
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Logos & Favicon', 'houzez' ),
    'id'     => 'logo-favicon',
    'desc'   => '',
    'icon'   => 'el-icon-picture el-icon-small',
    'fields'		=> array(
        array(
            'id'		=> 'custom_logo',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Logo', 'houzez' ),
            'read-only'	=> false,
            'default'	=> array( 'url'	=> HOUZEZ_IMAGE . 'logo-houzez-white.png' ),
            'desc'	=> esc_html__( 'Upload the logo', 'houzez' ),
        ),

        array(
            'id'		=> 'retina_logo',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Logo (For Retina Screens)', 'houzez' ),
            'default'	=> array( 'url'	=> HOUZEZ_IMAGE . 'logo-houzez-white@2x.png' ),
            'subtitle'	=> esc_html__( 'The retina logo have to be double size of the regular logo', 'houzez' ),
            'desc'  => esc_html__( 'Upload the logo for retina devices', 'houzez' ),
        ),

        array(
            'id'		=> 'mobile_logo',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Mobile Logo', 'houzez' ),
            'read-only'	=> false,
            'default'	=> array( 'url'	=> HOUZEZ_IMAGE . 'logo-houzez-white.png' ),
            'desc'	=> esc_html__( 'Upload the logo for mobile devices.', 'houzez' ),
        ),

        array(
            'id'		=> 'mobile_retina_logo',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Mobile Logo (For Retina Screens)', 'houzez' ),
            'default'	=> array( 'url'	=> HOUZEZ_IMAGE . 'logo-houzez-white@2x.png' ),
            'subtitle'  => esc_html__( 'The retina logo have to be double size of the regular logo', 'houzez' ),
            'desc'  => esc_html__( 'Upload the logo for retina devices', 'houzez' ),
        ),

        array(
            'id'		=> 'custom_logo_splash',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Splash Page & Transparent Header Logo', 'houzez' ),
            'read-only'	=> false,
            'default'	=> array( 'url'	=> HOUZEZ_IMAGE . 'logo-houzez-white.png' ),
            'desc'	=> esc_html__( 'Upload the logo for the splash page and the transparent header', 'houzez' ),
        ),

        array(
            'id'		=> 'retina_logo_splash',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Splash Page & Transparent Header Logo (For Retina Screens)', 'houzez' ),
            'default'	=> array( 'url'	=> HOUZEZ_IMAGE . 'logo-houzez-white@2x.png' ),
            'subtitle'	=> esc_html__( 'The retina logo have to be double size of the regular logo', 'houzez' ),
            'desc'  => esc_html__( 'Upload the retina logo for the splash page and the transparent header', 'houzez' ),
        ),


        array(
            'id'		=> 'custom_logo_mobile_splash',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Mobile Splash Page Logo', 'houzez' ),
            'read-only'	=> false,
            'default'	=> array( 'url'	=> HOUZEZ_IMAGE . 'logo-houzez-white.png' ),
            'desc'	=> esc_html__( 'Upload your custom logo for mobile splash page.', 'houzez' ),
        ),

        array(
            'id'		=> 'retina_logo_mobile_splash',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Mobile Splash Page Logo (For Retina Screens)', 'houzez' ),
            'default'	=> array( 'url'	=> HOUZEZ_IMAGE . 'logo-houzez-white@2x.png' ),
            'subtitle'	=> esc_html__( 'The retina logo have to be double size of the regular logo', 'houzez' ),
            'desc'  => esc_html__( 'Upload the retina logo for the mobile splash page', 'houzez' ),
        ),

        array(
            'id'		=> 'retina_logo_height',
            'type'		=> 'text',
            'default'	=> '',
            'title'		=> esc_html__( 'Standard Logo Height', 'houzez' ),
            'desc'	=> esc_html__( 'Enter the standard logo height', 'houzez' ),
        ),

        array(
            'id'		=> 'retina_logo_width',
            'type'		=> 'text',
            'default'	=> '',
            'title'		=> esc_html__( 'Standard Logo Width', 'houzez' ),
            'desc'	=> esc_html__( 'Enter the standard logo width', 'houzez' ),
        ),

        array(
            'id'        => 'retina_mobilelogo_height',
            'type'      => 'text',
            'default'   => '',
            'title'     => esc_html__( 'Mobile Logo Height', 'houzez' )
        ),

        array(
            'id'        => 'retina_mobilelogo_width',
            'type'      => 'text',
            'default'   => '',
            'title'     => esc_html__( 'Mobile Logo Width', 'houzez' )
        ),

        array(
            'id'	=> 'favicon',
            'url'			=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Favicon', 'houzez' ),
            'default'	=> array( 'url'	=> HOUZEZ_IMAGE . 'favicon.png' ),
            'subtitle'	=> esc_html__( 'Upload the favicon.', 'houzez' ),
        ),

        array(
            'id'		=> 'iphone_icon',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Apple iPhone Icon ', 'houzez' ),
            'default'	=> array(
                'url'	=> HOUZEZ_IMAGE . 'favicon-57x57.png'
            ),
            'subtitle'	=> esc_html__( 'Upload the iPhone icon (57px by 57px).', 'houzez' ),
        ),

        array(
            'id'		=> 'iphone_icon_retina',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Apple iPhone Retina Icon ', 'houzez' ),
            'default'	=> array(
                'url'	=> HOUZEZ_IMAGE . 'favicon-114x114.png'
            ),
            'subtitle'	=> esc_html__( 'Upload the iPhone retina icon (114px by 114px).', 'houzez' ),
        ),

        array(
            'id'		=> 'ipad_icon',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Apple iPad Icon ', 'houzez' ),
            'default'	=> array(
                'url'	=> HOUZEZ_IMAGE . 'favicon-72x72.png'
            ),
            'subtitle'	=> esc_html__( 'Upload the iPad icon (72px by 72px).', 'houzez' ),
        ),

        array(
            'id'		=> 'ipad_icon_retina',
            'url'		=> true,
            'type'		=> 'media',
            'title'		=> esc_html__( 'Apple iPad Retina Icon ', 'houzez' ),
            'default'	=> array(
                'url'	=> HOUZEZ_IMAGE . 'favicon-144x144.png'
            ),
            'subtitle'	=> esc_html__( 'Upload the iPad retina icon (144px by 144px).', 'houzez' ),
        )
    ),
) );

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Lightbox Logo', 'houzez' ),
    'id'     => 'lightbox-logo-options',
    'desc'   => '',
    'subsection'   => true,
    'fields'        => array(
        array(
            'id'        => 'lightbox_logo',
            'url'       => true,
            'type'      => 'media',
            'title'     => esc_html__( 'Lightbox Logo', 'houzez' ),
            'read-only' => false,
            'default'   => array( 'url' => '' ),
            'subtitle'  => esc_html__( 'Upload logo for lightbox.', 'houzez' ),
        )
    ),
) );

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Dashboard Logo', 'houzez' ),
    'id'     => 'dashboard-logo-options',
    'desc'   => '',
    'subsection'   => true,
    'fields'        => array(
        array(
            'id'        => 'dashboard_logo',
            'url'       => true,
            'type'      => 'media',
            'title'     => esc_html__( 'Logo', 'houzez' ),
            'read-only' => false,
            'default'   => array( 'url' => HOUZEZ_IMAGE . 'logo-houzez-white.png' ),
            'desc'  => esc_html__( 'Upload the logo for dashboard', 'houzez' ),
        )
    ),
) );