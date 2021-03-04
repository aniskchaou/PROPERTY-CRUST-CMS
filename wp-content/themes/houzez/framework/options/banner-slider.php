<?php
global $houzez_opt_name;
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Banner Slider', 'houzez' ),
    'id'     => 'property-banner-slider',
    'desc'   => '',
    'fields' => array(
        array(
            'id'       => 'banner_slider_autoplay',
            'type'     => 'switch',
            'title'    => esc_html__( 'Auto Play', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),
        array(
            'id'       => 'banner_slider_loop',
            'type'     => 'switch',
            'title'    => esc_html__( 'Loop', 'houzez' ),
            'subtitle' => '',
            'default'  => 1,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),
        array(
            'id'       => 'banner_slider_autoplayspeed',
            'type'     => 'text',
            'title'    => esc_html__( 'Auto Play Speed', 'houzez' ),
            'subtitle' => esc_html__( 'Enter auto play speed in milliseconds. Min value: 4000', 'houzez' ),
            'default'  => '4000',
            'validate' => 'numeric'
        ),
    )
));