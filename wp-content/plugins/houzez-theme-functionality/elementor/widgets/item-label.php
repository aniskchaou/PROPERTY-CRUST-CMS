<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Label extends Widget_Base {


	public function get_name() {
		return 'houzez-property-label';
	}

	public function get_title() {
		return __( 'Property Label', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-featured-image';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return ['label', 'property label', 'houzez' ];
	}

	protected function _register_controls() {
		parent::_register_controls();


		$this->start_controls_section(
            'label_style',
            [
                'label' => __( 'Style', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'align',
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .ele-labels-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
			'margin',
			[
				'label' => __( 'Margin', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ele-labels-wrap .item-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'padding',
			[
				'label' => __( 'Padding', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ele-labels-wrap .item-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'status_radius',
			[
				'label' => __( 'Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .item-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ele-labels-wrap .item-label',
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'label_styling' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'houzez-theme-functionality' ),
			]
		);

		$this->add_control(
			'status_color',
			[
				'label' => __( 'Color', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .item-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'status_bs_color',
			[
				'label' => __( 'Background Color', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .item-label' => 'background-color: {{VALUE}}',
				],
			]
		);
		

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => __( 'Hover', 'houzez-theme-functionality' ),
			]
		);

		$this->add_control(
			'status_color_hover',
			[
				'label' => __( 'Color', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .item-label:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'status_bs_color_hover',
			[
				'label' => __( 'Background Color', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .item-label:hover' => 'background-color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();

		
	}

	protected function render() {
		
		$settings = $this->get_settings();
		
		$term_id = '';
		$terms = wp_get_post_terms( get_the_ID(), 'property_label', array("fields" => "all"));

		if( !empty($terms) ) {
			echo '<div class="ele-labels-wrap">';
			foreach( $terms as $term ) {
		        $term_id = $term->term_id;
		        $term_name = $term->name;
		        echo '<a href="'.get_term_link($term_id).'" class="item-label label label-color-'.intval($term_id).'">
						'.esc_attr($term_name).'
					</a>';
		    }
		    echo '</div>';
		}

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Label );