<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Advanced_Search_Translate {
    
    public function __construct() {
       add_filter( 'wpml_elementor_widgets_to_translate', [
            $this,
            'houzez_advanced_search_to_translate'
        ] );
    }

    public function houzez_advanced_search_to_translate( $widgets ) {

        $widgets['houzez_elementor_advanced_search'] = [
            'conditions' => [ 'widgetType' => 'houzez_elementor_advanced_search' ],
            'fields'     => [
                [
                    'field'       => 'search_title',
                    'type'        => esc_html__( 'Advanced Search: Search Title', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],

            ],
        ];

        return $widgets;

    }
}

new Houzez_Advanced_Search_Translate();