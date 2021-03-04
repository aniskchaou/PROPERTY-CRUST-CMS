<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Search_Builder_Translate {
    
    public function __construct() {
       add_filter( 'wpml_elementor_widgets_to_translate', [
            $this,
            'houzez_search_builder_to_translate'
        ] );
    }

    public function houzez_search_builder_to_translate( $widgets ) {

        $widgets['houzez_elementor_search_builder'] = [
            'conditions' => [ 'widgetType' => 'houzez_elementor_search_builder' ],
            'fields'     => [
                [
                    'field'       => 'tabs_all_text',
                    'type'        => esc_html__( 'Search Builder: All Tab Text', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
            ],
            'integration-class' => 'Houzez_Search_Builder_Repeater_Translate',
        ];

        return $widgets;

    }
}


class Houzez_Search_Builder_Repeater_Translate extends WPML_Elementor_Module_With_Items {

    public function get_items_field() {
        return 'form_fields';
    }

    public function get_fields() {
        return array( 'field_label', 'placeholder', 'selected_count_text' );
    }

    protected function get_title( $field ) {
        switch ( $field ) {
            case 'field_label':
                return esc_html__( 'Search Builder: Field Label', 'houzez-theme-functionality' );

            case 'placeholder':
                return esc_html__( 'Search Builder: Field Placeholder', 'houzez-theme-functionality' );

            case 'selected_count_text':
                return esc_html__( 'Search Builder: Selected Count Text', 'houzez-theme-functionality' );


            default:
                return '';
        }
    }

    protected function get_editor_type( $field ) {
        switch ( $field ) {
            case 'field_label':
                return 'LINE';

            case 'placeholder':
                return 'LINE';

            case 'selected_count_text':
                return 'LINE';

            default:
                return '';
        }
    }

}

new Houzez_Search_Builder_Translate();