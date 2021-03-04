<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Status_Label extends Widget_Base {


	public function get_name() {
		return 'houzez-property-status';
	}

	public function get_title() {
		return __( 'Property Status', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-featured-image';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return ['status', 'property status', 'houzez' ];
	}

	protected function _register_controls() {
		parent::_register_controls();


		$this->start_controls_section(
            'status_style',
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
					'{{WRAPPER}} .ele-labels-wrap .label-status' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .ele-labels-wrap .label-status' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .label-status' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .ele-labels-wrap .label-status',
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'status_styling' );

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
					'{{WRAPPER}} .label-status' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .label-status' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .label-status:hover' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .label-status:hover' => 'background-color: {{VALUE}}',
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
		$term_status = wp_get_post_terms( get_the_ID(), 'property_status', array("fields" => "all"));

		if( !empty($term_status) ) {
			echo '<div class="ele-labels-wrap">';
			foreach( $term_status as $status ) {
		        $status_id = $status->term_id;
		        $status_name = $status->name;
		        echo '<a href="'.get_term_link($status_id).'" class="label-status label status-color-'.intval($status_id).'"">
						'.esc_attr($status_name).'
					</a>';
		    }
		    echo '</div>';
		}

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Status_Label );