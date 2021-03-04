<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Breadcrumbs extends Widget_Base {

	public function get_name() {
		return 'houzez-property-breadcrumb';
	}

	public function get_title() {
		return __( 'Breadcrumbs', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-product-breadcrumbs';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return [ 'houzez', 'breadcrumbs', 'property' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_product_rating_style',
			[
				'label' => __( 'Style', 'houzez-theme-functionality' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .breadcrumb-wrap li.breadcrumb-item.active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'link_color',
			[
				'label' => __( 'Link Color', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .breadcrumb-wrap li.breadcrumb-item a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .breadcrumb-wrap li.breadcrumb-item',
			]
		);


		$this->end_controls_section();
	}

	protected function render() {
		
		echo '<div class="breadcrumb-wrap">';
			
				houzez_breadcrumbs();
			
		echo '</div>';
	}

	public function render_plain_content() {}
}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Breadcrumbs );
