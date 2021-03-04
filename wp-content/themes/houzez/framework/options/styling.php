<?php
global $houzez_opt_name;
Redux::setSection( $houzez_opt_name, array(
    'title'            => esc_html__( 'Styling', 'houzez' ),
    'id'               => 'houzez-styling',
    'desc'             => '',
    'customizer_width' => '',
    'icon'             => 'el-icon-brush el-icon-small'
) );

/* Body
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Body', 'houzez' ),
    'id'     => 'styling-body',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'body_text_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Text Color', 'houzez' ),
            'desc' => esc_html__('Select the body text color', 'houzez'),
            'default'  => '#222222',
            'transparent' => false,
        ),

        array(
            'id'       => 'body_bg_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'desc' => esc_html__('Select body background color', 'houzez'),
            'default'  => '#f8f8f8',
            'transparent' => false,
        ),

        array(
            'id'       => 'houzez_primary_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Primary Color', 'houzez' ),
            'desc' => esc_html__( 'Select the primary color.', 'houzez' ),
            'default'  => '#00aeff',
            'transparent' => false
        ),
        array(
            'id'       => 'houzez_primary_color_hover',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Primary Hover Color', 'houzez' ),
            'desc' => esc_html__( 'Select the primary hover color.', 'houzez' ),
            'default'  => array(
                'color' => '#33beff',
                'alpha' => '.65',
                'rgba'  => 'rgba(0, 174, 255, 0.65)'
            )
        ),

        array(
            'id'       => 'houzez_secondary_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Secondary Color', 'houzez' ),
            'desc' => esc_html__( 'Select the secondary color.', 'houzez' ),
            'default'  => '#28a745',
            'transparent' => false
        ),
        array(
            'id'       => 'houzez_secondary_color_hover',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Secondary Hover Color', 'houzez' ),
            'desc' => esc_html__( 'Select the secondary hover color.', 'houzez' ),
            'default'  => array(
                'color' => '#34ce57',
                'alpha' => '.75',
                'rgba'  => ''
            )
        ),
    )
));


/* Navigation bars
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Navigation Bar', 'houzez' ),
    'id'     => 'styling-headers',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(


        // Header 1
        array(
            'id'       => 'header_1_bg',
            'type'     => 'color',
            'required' => array('header_style', '=', '1'),
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the navigation background color', 'houzez' ),
            'subtitle' => '',
            'default'  =>'#004274',
            'mode'     => 'background',
            'transparent' => false
        ),
        array(
            'id'       => 'header_1_links_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs', 'houzez' ),
            'required' => array('header_style', '=', '1'),
            'subtitle' => '',
            'default'  => '#FFFFFF',
            'transparent' => false
        ),
        array(
            'id'       => 'header_1_links_hover_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs on hover', 'houzez' ),
            'required' => array('header_style', '=', '1'),
            'subtitle' => '',
            'default'  => '#00aeff',
            'transparent' => false
        ),
        array(
            'id'       => 'header_1_links_hover_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Menu Tabs Background Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the background color of the menu tabs on hover', 'houzez' ),
            'required' => array('header_style', '=', '1'),
            'subtitle' => '',
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '.1',
                'rgba'  => 'rgba(0, 174, 255, 0.1)'
            )
        ),

        // Header 2
        array(
            'id'       => 'header_2_section-start',
            'type'     => 'section',
            'required' => array(
                array('header_style', '!=', '1'),
                array('header_style', '!=', '3'),
                array('header_style', '!=', '4'),
                array('header_style', '!=', '6'),
            ),
            'title'    => esc_html__( 'Top Area', 'houzez' ),
            'indent'   => true,
        ),
        array(
            'id'       => 'header_2_top_bg',
            'type'     => 'color',
            'required' => array(
                array('header_style', '!=', '1'),
                array('header_style', '!=', '3'),
                array('header_style', '!=', '4'),
                array('header_style', '!=', '6'),
            ),
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'desc' => esc_html__('Select the top area background color', 'houzez'),
            'default'  => '#ffffff',
            'transparent' => false
        ),
        array(
            'id'       => 'header_2_top_text',
            'type'     => 'color',
            'required' => array(
                array('header_style', '!=', '1'),
                array('header_style', '!=', '3'),
                array('header_style', '!=', '4'),
                array('header_style', '!=', '6'),
            ),
            'title'    => esc_html__( 'Text Color', 'houzez' ),
            'desc' => esc_html__('Select the top area text color', 'houzez'),
            'default'  => '#004274',
            'transparent' => false
        ),
        array(
            'id'       => 'header_2_section-end',
            'type'     => 'section',
            'required' => array(
                array('header_style', '!=', '1'),
                array('header_style', '!=', '3'),
                array('header_style', '!=', '4'),
                array('header_style', '!=', '6'),
            ),
            'indent'   => false,
        ),

        array(
            'id'       => 'header_2_bg',
            'type'     => 'color',
            'required' => array(
                array('header_style', '!=', '1'),
                array('header_style', '!=', '3'),
                array('header_style', '!=', '4'),
                array('header_style', '!=', '6'),
            ),
            'title'    => esc_html__( 'Menu Background Color', 'houzez' ),
            'desc' => esc_html__( 'Select the menu background color', 'houzez' ),
            'default'  => '#004274',
            'transparent' => false
        ),
        array(
            'id'       => 'header_2_links_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color', 'houzez' ),
            'desc' => esc_html__( 'Select the text color of the menu tabs', 'houzez' ),
            'required' => array(
                array('header_style', '!=', '1'),
                array('header_style', '!=', '3'),
                array('header_style', '!=', '4'),
                array('header_style', '!=', '6'),
            ),
            'subtitle' => '',
            'default'  => '#ffffff',
            'transparent' => false
        ),
        array(
            'id'       => 'header_2_links_hover_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color On Hover', 'houzez' ),
            'desc' => esc_html__( 'Select the text color of the menu tabs on hover', 'houzez' ),
            'required' => array(
                array('header_style', '!=', '1'),
                array('header_style', '!=', '3'),
                array('header_style', '!=', '4'),
                array('header_style', '!=', '6'),
            ),
            'subtitle' => '',
            'default'  => '#00aeff',
            'transparent' => false
        ),
        array(
            'id'       => 'header_2_links_hover_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Menu Tabs Background Color On Hover', 'houzez' ),
            'desc' => esc_html__( 'Select the background color of the menu tabs on hover', 'houzez' ),
            'required' => array(
                array('header_style', '!=', '1'),
                array('header_style', '!=', '3'),
                array('header_style', '!=', '4'),
                array('header_style', '!=', '6'),
            ),
            'subtitle' => '',
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '.1',
                'rgba'  => 'rgba(0, 174, 255, 0.1)'
            )
        ),
        array(
            'id'       => 'header_2_border',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Menu Tabs Border Color', 'houzez' ),
            'desc' => esc_html__( 'Select the border color of the menu tabs', 'houzez' ),
            'required' => array(
                array('header_style', '!=', '1'),
                array('header_style', '!=', '3'),
                array('header_style', '!=', '4'),
                array('header_style', '!=', '6'),
            ),
            'subtitle' => '',
            'default'  => array(
                'color'  => '#004274',
                'alpha'  => '.2',
                'rgba'  => 'rgba(0, 174, 255, 0.2)'
            )
        ),

        // Header 3
        array(
            'id'       => 'header_3_bg',
            'type'     => 'color',
            'required' => array('header_style', '=', '3'),
            'title'    => esc_html__( 'Top Area Background Color', 'houzez' ),
            'desc' => esc_html__( 'Select the top area background color', 'houzez' ),
            'default'  => '#004274',
            'transparent' => false
        ),
        array(
            'id'       => 'header_3_callus_color',
            'type'     => 'color',
            'required' => array('header_style', '=', '3'),
            'title'    => esc_html__( 'Call Us Color', 'houzez' ),
            'desc' => esc_html__( 'Select the call us text color', 'houzez' ),
            'default'  => '#ffffff',
            'transparent' => false
        ),
        array(
            'id'       => 'header_3_callus_bg_color',
            'type'     => 'color',
            'required' => array('header_style', '=', '3'),
            'title'    => esc_html__( 'Call Us Background Color', 'houzez' ),
            'desc' => esc_html__( 'Select the call us background color', 'houzez' ),
            'default'  => '#00aeff',
            'transparent' => false
        ),
        array(
            'id'       => 'header_3_bg_menu',
            'type'     => 'color',
            'required' => array('header_style', '=', '3'),
            'title'    => esc_html__( 'Menu Background Color', 'houzez' ),
            'desc' => esc_html__( 'Select the menu background color', 'houzez' ),
            'default'  => '#004274',
            'transparent' => false
        ),

        
        
        array(
            'id'       => 'header_3_links_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color', 'houzez' ),
            'desc' => esc_html__( 'Select the text color of the menu tabs', 'houzez' ),
            'required' => array('header_style', '=', '3'),
            'subtitle' => '',
            'default'  => '#FFFFFF',
            'transparent' => false
        ),

        array(
            'id'       => 'header_3_links_hover_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color On Hover', 'houzez' ),
            'desc' => esc_html__( 'Select the text color of the menu tabs on hover', 'houzez' ),
            'required' => array('header_style', '=', '3'),
            'subtitle' => '',
            'default'  => '#00aeff',
            'transparent' => false
        ),
        array(
            'id'       => 'header_3_links_hover_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Menu Tabs Background Color', 'houzez' ),
            'desc' => esc_html__( 'Select the background color of the menu tabs', 'houzez' ),
            'required' => array('header_style', '=', '3'),
            'subtitle' => '',
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '.1',
                'rgba'  => 'rgba(0, 174, 255, 0.1)'
            )
        ),
        array(
            'id'       => 'header_3_border',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Menu Tabs Border Color', 'houzez' ),
            'desc' => esc_html__( 'Select the border color of the menu tabs', 'houzez' ),
            'required' => array('header_style', '=', '3'),
            'subtitle' => '',
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '.2',
                'rgba'  => 'rgba(0, 174, 239, 0.2)'
            )
        ),
        array(
            'id'       => 'header_3_social_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Social Icons color', 'houzez' ),
            'desc' => esc_html__( 'Select the social icons color', 'houzez' ),
            'required' => array('header_style', '=', '3'),
            'subtitle' => '',
            'default'  => '#004274',
            'transparent' => false
        ),

        //Header 4
        array(
            'id'       => 'header_4_bg',
            'type'     => 'color',
            'required' => array('header_style', '=', '4'),
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'desc' => esc_html__( 'Select the background color', 'houzez' ),
            'subtitle' => '',
            'default'  => '#ffffff',
            'transparent' => false

        ),
        array(
            'id'       => 'header_4_links_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color', 'houzez' ),
            'desc' => esc_html__( 'Select the text color of the menu tabs', 'houzez' ),
            'required' => array('header_style', '=', '4'),
            'subtitle' => '',
            'default'  => '#004274',
            'transparent' => false
        ),
        array(
            'id'       => 'header_4_links_hover_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color On Hover', 'houzez' ),
            'desc' => esc_html__( 'Select the text color of the menu tabs on hover', 'houzez' ),
            'required' => array('header_style', '=', '4'),
            'subtitle' => '',
            'default'  => '#00aeef'
        ),

        array(
            'id'       => 'header_4_links_hover_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Menu Tabs Background Color On Hover', 'houzez' ),
            'desc' => esc_html__( 'Select the background color of the menu tabs on hover', 'houzez' ),
            'required' => array('header_style', '=', '4'),
            'subtitle' => '',
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '.1',
                'rgba'  => 'rgba(0, 174, 255, 0.1)'
            )
        ),

        // Header 6
        array(
            'id'       => 'header_6_bg',
            'type'     => 'color',
            'required' => array('header_style', '=', '6'),
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the background color', 'houzez' ),
            'subtitle' => '',
            'default'  =>'#004274',
            'mode'     => 'background',
            'transparent' => false
        ),
        array(
            'id'       => 'header_6_links_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs', 'houzez' ),
            'required' => array('header_style', '=', '6'),
            'subtitle' => '',
            'default'  => '#FFFFFF',
            'transparent' => false
        ),
        array(
            'id'       => 'header_6_links_hover_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs on hover', 'houzez' ),
            'required' => array('header_style', '=', '6'),
            'subtitle' => '',
            'default'  => '#00aeff',
            'transparent' => false
        ),
        array(
            'id'       => 'header_6_links_hover_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Menu Tabs Background Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the background color of the menu tabs on hover', 'houzez' ),
            'required' => array('header_style', '=', '6'),
            'subtitle' => '',
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '.1',
                'rgba'  => 'rgba(0, 174, 255, 0.1)'
            )
        ),

        array(
            'id'       => 'header_6_social_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Social Icons Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the color of the social icons', 'houzez' ),
            'required' => array('header_style', '=', '6'),
            'subtitle' => '',
            'default'  => '#FFFFFF',
            'transparent' => false
        ),

        /*
         * Header Transparent
         * --------------------------------------------------------------------- */
        array(
            'id'     => 'info-header-4-transparent',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
            'title'  => esc_html__( 'Transparent Menu Options (The transparent navigation is displayed on the splash page and when you select the trasparent header)', 'houzez' ),
            'desc'   => ''
        ),

        array(
            'id'       => 'header_4_transparent_links_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs', 'houzez' ),
            'subtitle' => '',
            'default'  => '#ffffff',
            'transparent' => false
        ),
        array(
            'id'       => 'header_4_transparent_links_hover_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs on hover', 'houzez' ),
            'subtitle' => '',
            'default'  => '#00aeef',
            'transparent' => false
        ),

        array(
            'id'       => 'header_4_transparent_border_bottom1',
            'type'     => 'border',
            'title'    => esc_html__( 'Border Bottom', 'houzez' ),
            'desc'    => esc_html__( 'Select the border dimention and style', 'houzez' ),
            'subtitle' => '',
            'color' => false,
            'default'  => array(
                'border-style'  => 'solid',
                'border-top'    => '1px',
                'border-right'  => '1px',
                'border-bottom' => '1px',
                'border-left'   => '1px'
            )
        ),
        array(
            'id'       => 'header_4_transparent_border_bottom_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Border Bottom Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the border color', 'houzez' ),
            'subtitle' => '',
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '.30',
                'rgba'  => 'rgba(255, 255, 255, 0.3)'
            )
        ),

    )
));

/* Sub Menu
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Sub Menu', 'houzez' ),
    'id'     => 'styling-submenu',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'header_submenu_bg',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the background color', 'houzez' ),
            'subtitle' => '',
            'default'  => array(
                'color' => '#FFFFFF',
                'alpha' => '.95',
                'rgba'  => 'rgba(255, 255, 255, 0.95)'
            )

        ),
        array(
            'id'       => 'header_submenu_links_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs', 'houzez' ),
            'subtitle' => '',
            'default'  => '#004274',
            'transparent' => false
        ),
        array(
            'id'       => 'header_submenu_links_hover_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs on hover', 'houzez' ),
            'subtitle' => '',
            'default'  => '#00aeff'
        ),
        array(
            'id'       => 'header_submenu_border_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Border color', 'houzez' ),
            'desc'    => esc_html__( 'Select the border color', 'houzez' ),
            'subtitle' => '',
            'default'  => '#dce0e0',
            'transparent' => true
        ),
    )
));

/* Create Listing
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Create Listing Button', 'houzez' ),
    'id'     => 'styling-create-listing',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'header_4_btn_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Button Text Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color', 'houzez' ),
            'subtitle' => '',
            'default'  => '#ffffff',
            'transparent' => true
        ),
        array(
            'id'       => 'header_4_btn_hover_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Button Text Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color on hover', 'houzez' ),
            'subtitle' => '',
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '.99',
                'rgba'  => 'rgba(255, 255, 255, 0.99)'
            )
        ),
        array(
            'id'       => 'header_4_btn_bg_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Button Background Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the button background color', 'houzez' ),
            'default'  => '#00aeff',
            'transparent' => true
        ),
        array(
            'id'       => 'header_4_btn_bg_hover_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Button Background Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the button background color on hover', 'houzez' ),
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '.65',
                'rgba'  => 'rgba(0, 174, 255, 0.65)'
            )
        ),
        array(
            'id'       => 'header_4_btn_border',
            'type'     => 'border',
            'title'    => esc_html__( 'Button Border', 'houzez' ),
            'desc'    => esc_html__( 'Select the button border options', 'houzez' ),
            'subtitle' => '',
            'default'  => array(
                'border-color'  => '#00aeff',
                'border-style'  => 'solid',
                'border-top'    => '1px',
                'border-right'  => '1px',
                'border-bottom' => '1px',
                'border-left'   => '1px'
            )
        ),
        array(
            'id'       => 'header_4_btn_border_hover_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Button Border On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the button border color on hover', 'houzez' ),
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '.99',
                'rgba'  => 'rgba(0, 174, 255, 0.99)'
            )
        ),

        /*
         * Transparent
         * --------------------------------------------------------------------- */
        array(
            'id'     => 'info-create-listingtransparent',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
            'title'  => esc_html__( 'Transparent Header - Create Listing Button', 'houzez' ),
            'desc'   => ''
        ),

        array(
            'id'       => 'header_4_transparent_btn_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Button Text Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color', 'houzez' ),
            'subtitle' => '',
            'default'  => '#ffffff',
            'transparent' => false
        ),
        array(
            'id'       => 'header_4_transparent_btn_hover_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Button Text Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color on hover', 'houzez' ),
            'subtitle' => '',
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '1',
                'rgba'  => ''
            )
        ),
        array(
            'id'       => 'header_4_transparent_btn_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Button Background Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the button background color', 'houzez' ),
            'default'  => array(
                'color' => '#ffffff',
                'alpha' => '.2',
                'rgba'  => 'rgba(255, 255, 255, 0.2)'
            )
        ),
        array(
            'id'       => 'header_4_transparent_btn_bg_hover_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Button Background Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the button background color on hover', 'houzez' ),
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '.65',
                'rgba'  => 'rgba(0, 174, 255, 0.65)'
            )
        ),
        array(
            'id'       => 'header_4_transparent_btn_border',
            'type'     => 'border',
            'title'    => esc_html__( 'Button Border', 'houzez' ),
            'desc'    => esc_html__( 'Select the button border options', 'houzez' ),
            'subtitle' => '',
            'default'  => array(
                'border-color'  => '#ffffff',
                'border-style'  => 'solid',
                'border-top'    => '1px',
                'border-right'  => '1px',
                'border-bottom' => '1px',
                'border-left'   => '1px'
            )
        ),
        array(
            'id'       => 'header_4_transparent_btn_border_hover_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Button Border On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the button border color on hover', 'houzez' ),
            'default'  => array(
                'color' => '#00AEEF',
                'alpha' => '1',
                'rgba'  => ''
            )
        ),

    )
));

/* Mobile Navigation
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Mobile Menu', 'houzez' ),
    'id'     => 'styling-mobile-menu',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'mob_menu_bg_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Mobile Header Background Color', 'houzez' ),
            'desc' => esc_html__('Select the background color of the mobile header', 'houzez'),
            'default'  => '#004274',
            'transparent' => false
        ),
        array(
            'id'       => 'mob_menu_btn_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Mobile Header Icon Color', 'houzez' ),
            'subtitle'    => esc_html__( 'Navicon and User-menu icon color', 'houzez' ),
            'desc'    => esc_html__( 'Select the color of the incons in the mobile header', 'houzez' ),
            'default'  => '#FFFFFF'
        ),
        array(
            'id'       => 'mob_nav_bg_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Background Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the background color of the menu tabs', 'houzez' ),
            'default'  => '#ffffff',
            'transparent' => false
        ),
        array(
            'id'       => 'mob_link_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs', 'houzez' ),
            'default'  => '#004274'
        ),
        array(
            'id'       => 'mobile_nav_border',
            'type'     => 'border',
            'title'    => esc_html__( 'Border', 'houzez' ),
            'desc'    => esc_html__( 'Select the button border options', 'houzez' ),
            'desc'     => '',
            'default'  => array(
                'border-color'  => '#dce0e0',
                'border-style'  => 'solid',
                'border-top'    => '1px',
                'border-right'  => '0px',
                'border-bottom' => '0px',
                'border-left'   => '0px'
            )
        ),
    )
));

/* Advance Search
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Advanced Search', 'houzez' ),
    'id'     => 'styling-advanced-search',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'adv_background',
            'type'     => 'color',
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'subtitle' => esc_html__( 'Select the advanced search background color', 'houzez' ),
            'default'  => '#ffffff',
            'validate' => 'color',
        ),
        array(
            'id'       => 'side_search_background',
            'type'     => 'color',
            'title'    => esc_html__( 'Half Map Search Background Color', 'houzez' ),
            'subtitle' => esc_html__( 'Select the background color for half map side search', 'houzez' ),
            'default'  => '#ffffff',
            'validate' => 'color',
        ),
        array(
            'id'       => 'adv_textfields_borders',
            'type'     => 'color',
            'title'    => esc_html__( 'Fields Border Color ', 'houzez' ),
            'subtitle' => esc_html__( 'Select the border color of the search fields', 'houzez' ),
            'subtitle' => '',
            'default'  => '#dce0e0',
        ),
        array(
            'id'       => 'adv_text_color20',
            'type'     => 'color',
            'title'    => esc_html__( 'Fields Placeholder Color', 'houzez' ),
            'subtitle' => esc_html__('Select placeholder text color', 'houzez'),
            'default'  => '#a1a7a8',
        ),
        array(
            'id'       => 'adv_other_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Text Color', 'houzez' ),
            'subtitle' => esc_html__( 'Text color for price range slider and other features', 'houzez' ),
            'default'  => '#222222',
            'validate' => 'color',
        ),
        array(
            'id'       => 'adv_halfmap_other_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Half Map Text Color', 'houzez' ),
            'subtitle' => esc_html__( 'Text color for price range slider and other features for half map side search', 'houzez' ),
            'default'  => '#222222',
            'validate' => 'color',
        ),
        array(
            'id'       => 'adv_search_btn_bg',
            'type'     => 'link_color',
            'title'    => esc_html__( 'Search Button Background Color', 'houzez' ),
            'subtitle'     => esc_html__( 'Select the search button background color', 'houzez' ),
            'active'    => false,
            'default'  => array(
                'regular' => '#28a745',
                'hover'   => '#34ce57',
            )
        ),
        array(
            'id'       => 'adv_search_btn_text',
            'type'     => 'link_color',
            'title'    => esc_html__( 'Search Button Text Color', 'houzez' ),
            'subtitle'     => esc_html__( 'Select the search button text color', 'houzez' ),
            'active'    => false,
            'default'  => array(
                'regular' => '#ffffff',
                'hover'   => '#ffffff',
            )
        ),
        array(
            'id'       => 'adv_search_border',
            'type'     => 'link_color',
            'title'    => esc_html__( 'Search Button Border Color', 'houzez' ),
            'subtitle'     => esc_html__( 'Select the search button border color', 'houzez' ),
            'active'    => false,
            'default'  => array(
                'regular' => '#28a745',
                'hover'   => '#34ce57',
            )
        ),
        array(
            'id'       => 'adv_button_color',
            'type'     => 'link_color',
            'title'    => esc_html__( 'Advanced Button Text Color', 'houzez' ),
            'subtitle'     => esc_html__( 'Select the advanced button text color', 'houzez' ),
            'active'    => false,
            'default'  => array(
                'regular' => '#00aeff',
                'hover'   => '#ffffff'
            )
        ),
        array(
            'id'       => 'adv_button_bg_color',
            'type'     => 'link_color',
            'title'    => esc_html__( 'Advanced Button Background Color', 'houzez' ),
            'subtitle'     => esc_html__( 'Select the advanced button background color', 'houzez' ),
            'active'    => false,
            'default'  => array(
                'regular' => '#ffffff',
                'hover'   => '#00aeff'
            )
        ),
        array(
            'id'       => 'adv_button_border_color',
            'type'     => 'link_color',
            'title'    => esc_html__( 'Advanced Button Border Color', 'houzez' ),
            'subtitle'     => esc_html__( 'Select the advanced button border color', 'houzez' ),
            'active'    => false,
            'default'  => array(
                'regular' => '#dce0e0',
                'hover'   => '#00aeff'
            )
        ),

        array(
            'id'             => 'header_search_padding',
            'type'           => 'spacing',
            'mode'           => 'padding',
            'units'          => array('em', 'px'),
            'units_extended' => 'false',
            'left' => 'false',
            'right' => 'false',
            'title'          => esc_html__('Padding', 'houzez'),
            'subtitle'       => esc_html__('Add top and bottom padding for header search', 'houzez'),
            'default'            => array(
                'padding-top'     => '10px', 
                'padding-bottom'  => '10px', 
                'units'          => 'px', 
            )
        ),

        array(
            'id'       => 'adv_overlay_open_close_bg_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Open/Close Button Background Color', 'houzez' ),
            'subtitle' => esc_html__('This setting works for the advanced search over headers map, video, image, etc.', 'houzez'),
            'desc'     => esc_html__( 'Select the open/close button background color', 'houzez' ),
            'default'  => '#00aeff',
            'transparent' => false
        ),
        array(
            'id'       => 'adv_overlay_open_close_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Open/Close Button Color', 'houzez' ),
            'subtitle' => esc_html__('This setting works for the advanced search over headers map, video, image, etc.', 'houzez'),
            'desc'     => esc_html__( 'Select the open/close button text color', 'houzez' ),
            'default'  => '#ffffff',
            'transparent' => false
        ),
    )
));

/* Saved Search Button
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Saved Search Button', 'houzez' ),
    'id'     => 'styling-saved-search',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'ssb_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Text Color', 'houzez' ),
            'desc'    => '',
            'subtitle' => '',
            'default'  => '#ffffff'

        ),
        array(
            'id'       => 'ssb_color_hover',
            'type'     => 'color',
            'title'    => esc_html__( 'Text Color Hover', 'houzez' ),
            'desc'    => '',
            'subtitle' => '',
            'default'  => '#ffffff'

        ),
        array(
            'id'       => 'ssb_bg_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'desc'    => '',
            'subtitle' => '',
            'default'  => '#28a745'

        ),
        array(
            'id'       => 'ssb_bg_color_hover',
            'type'     => 'color',
            'title'    => esc_html__( 'Background Color Hover', 'houzez' ),
            'desc'    => '',
            'subtitle' => '',
            'default'  => '#28a745'

        ),
        array(
            'id'       => 'ssb_border_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Border Color', 'houzez' ),
            'desc'    => '',
            'subtitle' => '',
            'default'  => '#28a745'

        ),
        array(
            'id'       => 'ssb_border_color_hover',
            'type'     => 'color',
            'title'    => esc_html__( 'Border Color Hover', 'houzez' ),
            'desc'    => '',
            'subtitle' => '',
            'default'  => '#28a745'

        ),
        
    )
));

/* Header Account Navigation
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'User Account Menu', 'houzez' ),
    'id'     => 'styling-user-account-menu',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'ua_menu_bg',
            'type'     => 'color',
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the menu background color', 'houzez' ),
            'subtitle' => '',
            'default'  => '#FFFFFF'

        ),
        array(
            'id'       => 'ua_menu_links_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs', 'houzez' ),
            'subtitle' => '',
            'default'  => '#004274',
            'transparent' => false
        ),
        array(
            'id'       => 'ua_menu_links_hover_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs on hover', 'houzez' ),
            'subtitle' => '',
            'default'  => '#00aeff',
            'transparent' => false
        ),
        array(
            'id'       => 'ua_menu_links_hover_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Menu Tabs Background Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the background color of the menu tabs on hover', 'houzez' ),
            'subtitle' => '',
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '0.11',
                'rgba'  => 'rgba(0, 174, 255, 0.1)'
            )
        ),
        array(
            'id'       => 'ua_menu_border_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Border Color', 'houzez' ),
            'desc' => esc_html__( 'Select the border color of the menu tabs', 'houzez' ),
            'subtitle' => '',
            'default'  => '#dce0e0',
            'transparent' => true
        ),
    )
));

/* Dashboard Menu
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Dashboard Menu', 'houzez' ),
    'id'     => 'styling-dashboardmenu',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'dm_background',
            'type'     => 'color',
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the menu background color', 'houzez' ),
            'subtitle' => '',
            'default'  => '#002B4B',
            'transparent' => true
        ),
        array(
            'id'       => 'dm_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs', 'houzez' ),
            'subtitle' => '',
            'default'  => '#839EB2',
            'transparent' => true
        ),
        array(
            'id'       => 'dm_hover_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Menu Tabs Text Color On Hover', 'houzez' ),
            'desc'    => esc_html__( 'Select the text color of the menu tabs on hover', 'houzez' ),            'subtitle' => '',
            'default'  => '#ffffff',
            'transparent' => true
        ),
        array(
            'id'       => 'dm_submenu_active_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Sub Menu Active Color', 'houzez' ),
            'desc'    => esc_html__( 'Select submenu active color', 'houzez' ),
            'subtitle' => '',
            'default'  => '#00aeff'
        ),
    )
));

/* Property Details
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Property Details', 'houzez' ),
    'id'     => 'styling-property-detail',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'houzez_prop_details_bg',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Property Details Module Background Color', 'houzez' ),
            'desc' => esc_html__( 'Select property details module background color.', 'houzez' ),
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '.1',
                'rgba'  => '',
                'rgba'  => ''
            )
        ),
        array(
            'id'       => 'prop_details_border_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Property Details Border Color', 'houzez' ),
            'desc' => esc_html__( 'Select property details module border color.', 'houzez' ),
            'subtitle' => '',
            'default'  => '#00aeff',
            'transparent' => false
        ),
    )
));

/* Featured Label
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Featured Label', 'houzez' ),
    'id'     => 'styling-featured-label',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'featured_label_bg_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the label background color', 'houzez' ),
            'subtitle' => '',
            'default'  => '#77c720',
            'transparent' => true
        ),
        array(
            'id'       => 'featured_label_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Text Color', 'houzez' ),
            'desc'    => esc_html__( 'Select the label text color', 'houzez' ),
            'subtitle' => '',
            'default'  => '#ffffff',
            'transparent' => false
        )
    )
));

/* Top Bar
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Top Bar', 'houzez' ),
    'id'     => 'styling-top-bar',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'top_bar_bg',
            'type'     => 'color',
            'title'    => esc_html__( 'Background Color', 'houzez' ),
            'subtitle' => '',
            'default'  => '#000000',
            'transparent' => true
        ),
        array(
            'id'       => 'top_bar_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Color', 'houzez' ),
            'subtitle' => '',
            'default'  => '#ffffff',
            'transparent' => false
        ),
        array(
            'id'       => 'top_bar_color_hover',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Hover Color', 'houzez' ),
            'subtitle' => '',
            'default'  => array(
                'color' => '#00AEEF',
                'alpha' => '.75',
                'rgba'  => ''
            )
        ),
    )
));


/* Footer
----------------------------------------------------------------*/
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Footer', 'houzez' ),
    'id'     => 'styling-footer',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'footer_bg_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Footer Top Background Color', 'houzez' ),
            'desc' => esc_html__('Select the footer top background color', 'houzez'),
            'default'  => '#004274',
            'transparent' => false,
        ),
        array(
            'id'       => 'footer_bottom_bg_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Footer Bottom Background Color', 'houzez' ),
            'desc' => esc_html__('Select the footer bottom background color', 'houzez'),
            'default'  => '#00335A',
            'transparent' => false,
        ),
        array(
            'id'       => 'footer_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Text Color', 'houzez' ),
            'desc' => esc_html__('Select the footer text color', 'houzez'),
            'default'  => '#ffffff'
        ),
        array(
            'id'       => 'footer_hover_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__( 'Links Hover Color', 'houzez' ),
            'desc' => esc_html__('Select the footer links hover color', 'houzez'),
            'default'  => array(
                'color' => '#00aeff',
                'alpha' => '1',
                'rgba'  => ''
            )
        ),

    )
));