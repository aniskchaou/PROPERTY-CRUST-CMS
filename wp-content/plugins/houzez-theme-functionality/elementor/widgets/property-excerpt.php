<?php
namespace Elementor;
use Elementor\Core\Schemes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Excerpt extends Widget_Base {


	public function get_name() {
		return 'houzez-property-excerpt';
	}

	public function get_title() {
		return __( 'Property Excerpt', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return [ 'property', 'excerpt', 'description', 'houzez' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'houzez-theme-functionality' ),
			]
		);

		$this->add_control(
			'excerpt',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [
					'active' => true,
					'default' => \Elementor\Plugin::$instance->dynamic_tags->tag_data_to_tag_text( null, 'houzez-property-excerpt-tag' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'houzez-theme-functionality' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .elementor-widget-container',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		echo $this->get_settings_for_display( 'excerpt' );
	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Excerpt );