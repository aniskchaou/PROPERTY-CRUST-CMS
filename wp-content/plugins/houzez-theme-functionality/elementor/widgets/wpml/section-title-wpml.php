<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Section_Title_Translate {
    
    public function __construct() {
       add_filter( 'wpml_elementor_widgets_to_translate', [
            $this,
            'houzez_section_title_to_translate'
        ] );
    }

    public function houzez_section_title_to_translate( $widgets ) {

        $widgets['houzez_elementor_section_title'] = [
            'conditions' => [ 'widgetType' => 'houzez_elementor_section_title' ],
            'fields'     => [
                [
                    'field'       => 'hz_section_title',
                    'type'        => esc_html__( 'Section Title: Main Title', 'houzez-theme-functionality' ),
                    'editor_type' => 'AREA'
                ],
                [
                    'field'       => 'hz_section_subtitle',
                    'type'        => esc_html__( 'Section Title: Sub Title', 'houzez-theme-functionality' ),
                    'editor_type' => 'AREA'
                ],

            ],
        ];

        return $widgets;

    }
}

new Houzez_Section_Title_Translate();