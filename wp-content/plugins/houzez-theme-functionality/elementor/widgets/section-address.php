<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Section_Address extends Widget_Base {


	public function get_name() {
		return 'houzez-property-section-address';
	}

	public function get_title() {
		return __( 'Section Address', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-featured-image';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return ['property', 'address', 'houzez' ];
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
            'data_columns',
            [
                'label' => esc_html__( 'Data Columns', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'list-2-cols',
                'options' => array(
                    'list-1-cols' => esc_html__('1 Column', 'houzez-theme-functionality'),
                    'list-2-cols' => esc_html__('2 Columns', 'houzez-theme-functionality'),
                    'list-3-cols' => esc_html__('3 Columns', 'houzez-theme-functionality'),
                ),
            ]
        );

        $this->add_responsive_control(
            'meta_line_height',
            [
                'label' => esc_html__( 'Line Height', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-content-wrap li' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'houzez_address_fields_section',
            [
                'label' => esc_html__( 'Address Data', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'houzez_address_sort',
            [
                'label' => __( 'Control Name', 'houzez-theme-functionality' ),
                'type'  => 'houzez-address-sort-control',
            ]
        );


        $this->end_controls_section();


        //Titles
        $this->start_controls_section(
            'section_titles',
            [
                'label' => __( 'Titles', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'address_title',
            [
                'label' => esc_html__( 'Address', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Address',
            ]
        );
        $this->add_control(
            'country_title',
            [
                'label' => esc_html__( 'Country', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Country',
            ]
        );

        $this->add_control(
            'state_title',
            [
                'label' => esc_html__( 'State', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'State',
            ]
        );

        $this->add_control(
            'city_title',
            [
                'label' => esc_html__( 'City', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'City',
            ]
        );

        $this->add_control(
            'area_title',
            [
                'label' => esc_html__( 'Area', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Area',
            ]
        );

        $this->add_control(
            'zip_title',
            [
                'label' => esc_html__( 'Zip/Postal Code', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Zip/Postal Code',
            ]
        );

        $this->end_controls_section();

	   
        //Style
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

        //Section title
		$this->start_controls_section(
            'sec_title_style',
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


        // Meta Titles
        $this->start_controls_section(
            'meta_titles_style',
            [
                'label' => __( 'Meta Titles', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'meta_title_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-content-wrap li strong' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'meta_title_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-content-wrap li strong',
            ]
        );

        $this->end_controls_section();

        // Meta Values
        $this->start_controls_section(
            'meta_values_style',
            [
                'label' => __( 'Meta Values', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'meta_value_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-content-wrap li span' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'meta_value_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-content-wrap li span',
            ]
        );

        $this->end_controls_section();

        //Border
        $this->start_controls_section(
            'border_style',
            [
                'label' => __( 'Border', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'meta_border',
            [
                'label' => esc_html__( 'Hide Meta Border', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-content-wrap ul li' => 'border-bottom: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'meta_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-content-wrap ul li' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'meta_border!' => 'none'
                ]
            ]
        );

        $this->end_controls_section();

	}

	protected function render() {
		
		global $sorting_settings, $settings, $post;

        $sorting_settings = '';
		$settings = $this->get_settings_for_display();
        if ( isset( $settings['houzez_address_sort'] ) && ! empty( $settings['houzez_address_sort'] ) ) {
            $sorting_settings = $settings['houzez_address_sort'];
        }

        htf_get_template_part('elementor/template-part/single-property/section', 'address');

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Section_Address );