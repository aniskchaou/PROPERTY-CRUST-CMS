<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Grid_Builder_Translate {
    
    public function __construct() {
       add_filter( 'wpml_elementor_widgets_to_translate', [
            $this,
            'houzez_grid_builder_to_translate'
        ] );
    }

    public function houzez_grid_builder_to_translate( $widgets ) {

        $widgets['Houzez_elementor_grid_builder'] = [
            'conditions' => [ 'widgetType' => 'Houzez_elementor_grid_builder' ],
            'fields'     => [
                [
                    'field'       => 'grid_title',
                    'type'        => esc_html__( 'Grid Builder: Title', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'grid_subtitle',
                    'type'        => esc_html__( 'Grid Builder: Sub Title', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'more_text',
                    'type'        => esc_html__( 'Grid Builder: More Details Text', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'property_text',
                    'type'        => esc_html__( 'Grid Builder: Property Text', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'properties_text',
                    'type'        => esc_html__( 'Grid Builder: Properties Text', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'more_link',
                    'type'        => esc_html__( 'Grid Builder: Link', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINK'
                ],

            ],
        ];

        return $widgets;

    }
}

new Houzez_Grid_Builder_Translate();