<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Properties_Carousel_v1_Translate {
    
    public function __construct() {
       add_filter( 'wpml_elementor_widgets_to_translate', [
            $this,
            'houzez_properties_carousel_v1_to_translate'
        ] );
    }

    public function houzez_properties_carousel_v1_to_translate( $widgets ) {

        $widgets['houzez_elementor_properties_carousel_v2'] = [
            'conditions' => [ 'widgetType' => 'houzez_elementor_properties_carousel_v2' ],
            'fields'     => [
                [
                    'field'       => 'all_btn',
                    'type'        => esc_html__( 'Properties Carousel v1: All - Button Text', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'all_url',
                    'type'        => esc_html__( 'Properties Carousel v1: All - Button URL', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINK'
                ],

            ],
        ];

        return $widgets;

    }
}

new Houzez_Properties_Carousel_v1_Translate();