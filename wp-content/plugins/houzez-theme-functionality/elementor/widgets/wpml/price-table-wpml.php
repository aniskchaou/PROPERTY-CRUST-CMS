<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Price_Table_Translate {
    
    public function __construct() {
       add_filter( 'wpml_elementor_widgets_to_translate', [
            $this,
            'houzez_PriceTable_to_translate'
        ] );
    }

    public function houzez_PriceTable_to_translate( $widgets ) {

        $widgets['houzez_elementor_price_table'] = [
            'conditions' => [ 'widgetType' => 'houzez_elementor_price_table' ],
            'fields'     => [
                [
                    'field'       => 'package_name',
                    'type'        => esc_html__( 'Price Table: Package Name', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'package_price',
                    'type'        => esc_html__( 'Price Table: Package Price', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'package_currency',
                    'type'        => esc_html__( 'Price Table: Package Currency', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'content',
                    'type'        => esc_html__( 'Price Table: Package Content', 'houzez-theme-functionality' ),
                    'editor_type' => 'AREA'
                ],
                [
                    'field'       => 'package_btn_text',
                    'type'        => esc_html__( 'Price Table: Package Button Text', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],

            ],
        ];

        return $widgets;

    }
}

new Houzez_Price_Table_Translate();