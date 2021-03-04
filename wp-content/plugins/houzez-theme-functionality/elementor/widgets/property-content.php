<?php
namespace Elementor;
use Elementor\Core\Schemes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Content extends Widget_Base {


	public function get_name() {
		return 'houzez-property-content';
	}

	public function get_title() {
		return __( 'Property Content', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-post-content';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return [ 'content', 'post', 'property', 'houzez' ];
	}

	protected function _register_controls() {
		parent::_register_controls();

		$this->start_controls_section(
            'prop_content_typo',
            [
                'label' => __( 'Style', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
            'prop_content_align',
            [
                'label' => __( 'Alignment', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'houzez-theme-functionality' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'houzez-theme-functionality' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'houzez-theme-functionality' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justified', 'houzez-theme-functionality' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'prop_text_color',
            [
                'label' => __( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'scheme' => Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        //https://developers.elementor.com/elementor-controls/icons-control/
        /*$this->add_control(
            'content_icon',
            [
                'label' => __( 'Icon', 'text-domain' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );*/


        $this->end_controls_section();

	}

	

	protected function render() {

		the_content();
	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Content );