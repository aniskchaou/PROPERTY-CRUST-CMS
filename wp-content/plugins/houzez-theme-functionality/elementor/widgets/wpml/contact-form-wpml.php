<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Contact_Form_Translate {
    
    public function __construct() {
       add_filter( 'wpml_elementor_widgets_to_translate', [
            $this,
            'houzez_contact_form_to_translate'
        ] );
    }

    public function houzez_contact_form_to_translate( $widgets ) {

        $widgets['houzez_elementor_contact_form'] = [
            'conditions' => [ 'widgetType' => 'houzez_elementor_contact_form' ],
            'fields'     => [
                [
                    'field'       => 'gdpr_label',
                    'type'        => esc_html__( 'Contact Form: GDPR Label', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'gdpr_validate',
                    'type'        => esc_html__( 'Contact Form: GDPR Validation Message', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'gdpr_text',
                    'type'        => esc_html__( 'Contact Form: GDPR Agreement Text', 'houzez-theme-functionality' ),
                    'editor_type' => 'AREA'
                ],
                [
                    'field'       => 'redirect_to',
                    'type'        => esc_html__( 'Contact Form: Redirect Link', 'houzez-theme-functionality' ),
                    'editor_type' => 'LINK'
                ],
            ],
            'integration-class' => 'Houzez_Contact_Form_Repeater_Translate',
        ];

        return $widgets;

    }
}


class Houzez_Contact_Form_Repeater_Translate extends WPML_Elementor_Module_With_Items {

    public function get_items_field() {
        return 'form_fields';
    }

    public function get_fields() {
        return array( 'field_label', 'placeholder', 'validation_message' );
    }

    protected function get_title( $field ) {
        switch ( $field ) {
            case 'field_label':
                return esc_html__( 'Contact Form: Field Label', 'houzez-theme-functionality' );

            case 'placeholder':
                return esc_html__( 'Contact Form: Field Placeholder', 'houzez-theme-functionality' );

            case 'validation_message':
                return esc_html__( 'Contact Form: Field Validation Message', 'houzez-theme-functionality' );


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

            case 'validation_message':
                return 'LINE';

            default:
                return '';
        }
    }

}

new Houzez_Contact_Form_Translate();