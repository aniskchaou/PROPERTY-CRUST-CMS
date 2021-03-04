<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Icon_Box_Translate {
    
    public function __construct() {
       add_filter( 'wpml_elementor_widgets_to_translate', [
            $this,
            'houzez_Icon_Box_to_translate'
        ] );
    }

    public function houzez_Icon_Box_to_translate( $widgets ) {

        $widgets['houzez_elementor_icon_box'] = [
            'conditions' => [ 'widgetType' => 'houzez_elementor_icon_box' ],
            'fields'     => array(),
            'integration-class' => 'Houzez_Icon_Box_Repeater_Translate',
        ];

        return $widgets;

    }
}


class Houzez_Icon_Box_Repeater_Translate extends WPML_Elementor_Module_With_Items {

    public function get_items_field() {
        return 'icon_boxes';
    }

    public function get_fields() {
        return array( 'title', 'text', 'read_more_text', 'read_more_link' );
    }

    protected function get_title( $field ) {
        switch ( $field ) {
            case 'title':
                return esc_html__( 'Icon Box: Title', 'houzez-theme-functionality' );

            case 'text':
                return esc_html__( 'Icon Box: Text', 'houzez-theme-functionality' );

            case 'read_more_text':
                return esc_html__( 'Icon Box: Read More Text', 'houzez-theme-functionality' );

            case 'read_more_link':
                return esc_html__( 'Icon Box: Read More Link', 'houzez-theme-functionality' );


            default:
                return '';
        }
    }

    protected function get_editor_type( $field ) {
        switch ( $field ) {
            case 'title':
                return 'LINE';

            case 'text':
                return 'LINE';

            case 'read_more_text':
                return 'AREA';

            case 'read_more_link':
                return 'LINK';

            default:
                return '';
        }
    }

}

new Houzez_Icon_Box_Translate();