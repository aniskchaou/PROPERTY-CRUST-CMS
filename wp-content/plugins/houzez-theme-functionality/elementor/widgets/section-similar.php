<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Section_Similar extends Widget_Base {


	public function get_name() {
		return 'houzez-property-section-similar';
	}

	public function get_title() {
		return __( 'Section Similar Listings', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-featured-image';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return ['property', 'similar listings', 'houzez' ];
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
            'listing_from',
            [
                'label' => esc_html__( 'Similar Properties Criteria', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT2,
                'options'  => array(
                    'property_type' => esc_html__('Property Type', 'houzez'),
                    'property_status' => esc_html__('Property Status', 'houzez'),
                    'property_label' => esc_html__('Property Label', 'houzez'),
                    'property_feature' => esc_html__('Property Feature', 'houzez'),
                    'property_country' => esc_html__('Property Country', 'houzez'),
                    'property_state' => esc_html__('Property State', 'houzez'),
                    'property_city' => esc_html__('Property City', 'houzez'),
                    'property_area' => esc_html__('Property Area', 'houzez'),
                ),
                'multiple' => true,
                'label_block' => true,
                'default' => 'property_type'
            ]
        );

        $this->add_control(
            'listing_layout',
            [
                'label' => esc_html__( 'Default Order', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'options'  => array(
                    'list-view-v1' => 'List View v1',
                    'grid-view-v1' => 'Grid View v1',
                    'list-view-v2' => 'List View v2',
                    'grid-view-v2' => 'Grid View v2',
                    'grid-view-v3' => 'Grid View v3',
                    'list-view-v5' => 'List View v5',
                    'grid-view-v5' => 'Grid View v5',
                    'grid-view-v6' => 'Grid View v6',
                ),
                'default' => 'list-view-v1'
            ]
        );

        $this->add_control(
            'layout_columns',
            [
                'label' => esc_html__( 'Columns', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'options'  => array(
                    'grid-view-2-cols' => '2 Columns',
                    'grid-view-3-cols' => '3 Columns',
                    'grid-view-4-cols' => '4 Columns',
                ),
                'default' => 'grid-view-2-cols',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'listing_layout',
                            'operator' => '!in',
                            'value' => [
                                'list-view-v1',
                                'list-view-v2',
                                'list-view-v5',
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Default Order', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'options'  => array(
                    'd_date' => esc_html__( 'Date New to Old', 'houzez' ),
                    'a_date' => esc_html__( 'Date Old to New', 'houzez' ),
                    'd_price' => esc_html__( 'Price (High to Low)', 'houzez' ),
                    'a_price' => esc_html__( 'Price (Low to High)', 'houzez' ),
                    'featured_first' => esc_html__( 'Show Featured Listings on Top', 'houzez' ),
                    'random' => esc_html__( 'Random', 'houzez' ),
                ),
                'default' => 'd_date'
            ]
        );

        $this->add_control(
            'no_of_posts',
            [
                'label' => esc_html__( 'Limit', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
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
                    'size' => 40,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} #similar-listings-wrap' => 'margin-top: {{SIZE}}{{UNIT}};'
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

		$this->end_controls_section();

	}

	protected function render() {
		
		global $settings, $post;

		$settings = $this->get_settings_for_display();

		htf_get_template_part('elementor/template-part/single-property/similar', 'properties');
        

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Section_Similar );