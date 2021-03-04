<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Section_FloorPlan extends Widget_Base {


	public function get_name() {
		return 'houzez-property-section-floorplan';
	}

	public function get_title() {
		return __( 'Section Floor Plan', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-featured-image';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return ['property', 'Floor Plan', 'houzez' ];
	}

	protected function _register_controls() {
		parent::_register_controls();


		$this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
            'section_header',
            [
                'label' => esc_html__( 'Section Header', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => esc_html__( 'Section Title', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => '',
                'condition' => [
                	'section_header' => 'true'
                ],
            ]
        );

        $this->add_control(
            'show_open',
            [
                'label' => esc_html__( 'Default Open', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'hide_size',
            [
                'label' => esc_html__( 'Hide Size', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .fp-size' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_beds',
            [
                'label' => esc_html__( 'Hide Beds', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .fp-room' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_bath',
            [
                'label' => esc_html__( 'Hide Bath', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .fp-bath' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_price',
            [
                'label' => esc_html__( 'Hide Price', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .fp-price' => 'display: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

	
		$this->start_controls_section(
            'box_style',
            [
                'label' => __( 'Section Style', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'label' => __( 'Background', 'houzez-theme-functionality' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .block-wrap',
            ]
        );

		$this->add_control(
            'section_title_border',
            [
                'label' => esc_html__( 'Hide Title Border', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-title-wrap' => 'border-bottom: {{VALUE}};',
                    '{{WRAPPER}} .block-wrap' => 'border-top: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'     => esc_html__( 'Border Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-title-wrap' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                	'section_title_border!' => 'none'
                ]
            ]
        );

        $this->add_responsive_control(
            'section_margin_top',
            [
                'label' => esc_html__( 'Margin Top', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-wrap' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding_bottom',
            [
                'label' => esc_html__( 'Title Padding Bottom', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-title-wrap' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin_bottom',
            [
                'label' => esc_html__( 'Title Margin Bottom', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-title-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


		$this->add_control(
			'padding',
			[
				'label' => __( 'Box Padding', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .block-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'radius',
			[
				'label' => __( 'Box Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .block-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

        // Section title
		$this->start_controls_section(
            'content_style',
            [
                'label' => __( 'Section Title', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
            'sec_title_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-title-wrap h2' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-title-wrap h2',
            ]
        );
      

		$this->end_controls_section();


        // Section content
        $this->start_controls_section(
            'section_content_style',
            [
                'label' => __( 'Icon', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'fp_icon',
            [
                'label' => esc_html__( 'Hide Icon', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .accordion-title:before' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .accordion-title:before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .accordion-title:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
      
        $this->end_controls_section();

        // Section title
        $this->start_controls_section(
            'floorplan_style',
            [
                'label' => __( 'Floor Plan Title', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'fp_title_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .accordion-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'fp_title_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .accordion-title',
            ]
        );
      

        $this->end_controls_section();

        // Meta
        $this->start_controls_section(
            'floorplanmeta_style',
            [
                'label' => __( 'Meta', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'fp_meta_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .list-inline-item' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'fp_meta_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .list-inline-item',
            ]
        );
      

        $this->end_controls_section();

	}

	protected function render() {
		
		global $ele_settings, $post;

		$settings = $this->get_settings_for_display();

		$ele_settings = $settings;

		
        get_template_part('property-details/floor-plans');
         

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Section_FloorPlan );