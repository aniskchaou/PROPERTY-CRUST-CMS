<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Section_Review extends Widget_Base {


	public function get_name() {
		return 'houzez-property-section-review';
	}

	public function get_title() {
		return __( 'Section Reviews', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-featured-image';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return ['property', 'reviews', 'houzez' ];
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
		
		global $ele_settings, $post;

		$settings = $this->get_settings_for_display();
        $ele_settings = $settings;

		get_template_part('template-parts/reviews/main');

        if ( Plugin::$instance->editor->is_edit_mode() ) :  ?>
            <script>
                jQuery('.selectpicker').selectpicker('refresh');
            </script
        <?php
        endif;
        

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Section_Review );