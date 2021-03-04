<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Section_Details extends Widget_Base {


	public function get_name() {
		return 'houzez-property-section-details';
	}

	public function get_title() {
		return __( 'Section Details', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-featured-image';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return ['property', 'details', 'houzez' ];
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
                    '{{WRAPPER}} .block-content-wrap .detail-wrap ul li' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'houzez_details_fields_section',
            [
                'label' => esc_html__( 'Details Data', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'houzez_details_sort',
            [
                'label' => __( 'Control Name', 'houzez-theme-functionality' ),
                'type'  => 'houzez-details-sort-control',
            ]
        );


        $this->end_controls_section();

        //Additional Details
        $this->start_controls_section(
            'section_additional_content',
            [
                'label' => __( 'Additional Details', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_additional_details',
            [
                'label' => esc_html__( 'Show Additional Details', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'additional_section_header',
            [
                'label' => esc_html__( 'Addtional Section Header', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'additional_section_title',
            [
                'label' => esc_html__( 'Additional Section Title', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => '',
                'condition' => [
                    'additional_section_header' => 'true'
                ],
            ]
        );

        $this->add_control(
            'additional_data_columns',
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
            'additional_meta_line_height',
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
                    '{{WRAPPER}} .block-content-wrap ul.additional-details-ul li' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
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
            'id_title',
            [
                'label' => esc_html__( 'Property ID', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Property ID',
            ]
        );
        $this->add_control(
            'price_title',
            [
                'label' => esc_html__( 'Price', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Price',
            ]
        );

        $this->add_control(
            'size_title',
            [
                'label' => esc_html__( 'Property Size', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Property Size',
            ]
        );

        $this->add_control(
            'land_title',
            [
                'label' => esc_html__( 'Land Area', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Land Area',
            ]
        );

        $this->add_control(
            'bedroom_title',
            [
                'label' => esc_html__( 'Bedroom', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Bedroom',
            ]
        );
        $this->add_control(
            'bedrooms_title',
            [
                'label' => esc_html__( 'Bedrooms', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Bedrooms',
            ]
        );

        $this->add_control(
            'bathroom_title',
            [
                'label' => esc_html__( 'Bathroom', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Bathroom',
            ]
        );
        $this->add_control(
            'bathrooms_title',
            [
                'label' => esc_html__( 'Bathrooms', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Bathrooms',
            ]
        );

        $this->add_control(
            'garage_title',
            [
                'label' => esc_html__( 'Garage', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Garage',
            ]
        );
        $this->add_control(
            'garages_title',
            [
                'label' => esc_html__( 'Garages', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Garages',
            ]
        );

        $this->add_control(
            'garage_size_title',
            [
                'label' => esc_html__( 'Garage Size', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Garage Size',
            ]
        );

        $this->add_control(
            'year_title',
            [
                'label' => esc_html__( 'Year Built', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Year Built',
            ]
        );

        $this->add_control(
            'type_title',
            [
                'label' => esc_html__( 'Property Type', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Property Type',
            ]
        );

        $this->add_control(
            'status_title',
            [
                'label' => esc_html__( 'Property Status', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Property Status',
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


        // Details Box Style
        $this->start_controls_section(
            'box_details_style',
            [
                'label' => __( 'Details Box Style', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'detail_box_background',
                'label' => __( 'Background', 'houzez-theme-functionality' ),
                'types' => [ 'classic' ],
                'selector' => '{{WRAPPER}} .block-wrap .detail-wrap',
            ]
        );

        $this->add_responsive_control(
            'details_box_padding',
            [
                'label' => __( 'Padding', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .detail-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'details_box_border',
            [
                'label' => esc_html__( 'Hide Box Border', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .detail-wrap' => 'border: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'box_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .detail-wrap, .block-content-wrap li' => 'border-color: {{VALUE}}',
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
                    '{{WRAPPER}} .block-title-wrap h2, .block-title-wrap h3' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-title-wrap h2, .block-title-wrap h3',
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
            'details_meta_border',
            [
                'label' => esc_html__( 'Hide Meta Border', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-content-wrap li' => 'border-bottom: {{VALUE}};',
                ],
            ]
        );

       $this->add_control(
            'box_meta_border_color',
            [
                'label'     => esc_html__( 'Meta Border Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-content-wrap .detail-wrap li' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'add_meta_border_color',
            [
                'label'     => esc_html__( 'Additional Meta Border Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .additional-details-ul li' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

	}

	protected function render() {
		
		global $sorting_settings, $settings, $post;

        $sorting_settings = '';
		$settings = $this->get_settings_for_display();
        if ( isset( $settings['houzez_details_sort'] ) && ! empty( $settings['houzez_details_sort'] ) ) {
            $sorting_settings = $settings['houzez_details_sort'];
        }

        htf_get_template_part('elementor/template-part/single-property/detail');

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Section_Details );