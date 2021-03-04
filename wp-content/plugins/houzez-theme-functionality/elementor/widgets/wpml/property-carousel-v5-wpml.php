<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Properties_Carousel_v5_Translate {
    
    public function __construct() {
       add_filter( 'wpml_elementor_widgets_to_translate', [
            $this,
            'houzez_properties_carousel_v5_to_translate'
        ] );
    }

    public function houzez_properties_carousel_v5_to_translate( $widgets ) {

        $widgets['houzez_elementor_properties_carousel_v5'] = [
            'conditions' => [ 'widgetType' => 'houzez_elementor_properties_carousel_v5' ],
            'fields'     => [
                [
                    'field'       => 'all_btn',
                    'type'        => esc_html__( 'Properties Carousel v5: All - Button Text', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'all_url',
                    'type'        => esc_html__( 'Properties Carousel v5: All - Button URL', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINK'
                ],

            ],
        ];

        return $widgets;

    }
}

new Houzez_Properties_Carousel_v5_Translate();