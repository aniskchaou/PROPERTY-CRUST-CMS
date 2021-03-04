<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Section Title Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Section_Title extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve widget name.
     *
     * @since 1.5.6
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'houzez_elementor_section_title';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Section Title', 'houzez-theme-functionality' );
    }

    /**
     * Get widget icon.
     *
     * @since 1.5.6
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-post-title';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the widget belongs to.
     *
     * @since 1.5.6
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'houzez-elements' ];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.5.6
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hz_section_title',
            [
                'label'     => esc_html__( 'Title', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXTAREA,
                'description'   => '',
            ]
        );

        $this->add_control(
            'hz_section_subtitle',
            [
                'label'     => esc_html__( 'Sub Title', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXTAREA,
                'description'   => '',
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'houzez_section_typography',
            [
                'label' => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'section_title_typography',
                'label'    => esc_html__( 'Section Title', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .houzez_section_title',
                'fields_options' => [
                    'font_weight' => [
                        
                        'default' => '500',
                    ],
                    'font_family' => [
                        'default' => 'Roboto',
                    ],
                    'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 24 ] ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'section_subtitle_typography',
                'label'    => esc_html__( 'Section Subtitle ', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .houzez_section_subtitle',
                'fields_options' => [
                    // Inner control name
                    'font_weight' => [
                        // Inner control settings
                        'default' => '300',
                    ],
                    'font_family' => [
                        'default' => 'Roboto',
                    ],
                    'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 16 ] ],
                ],
            ]
        );

        $this->add_responsive_control(
            'houzez_section_title_align',
            [
                'label' => esc_html__( 'Alignment', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => esc_html__( 'Left', 'houzez-theme-functionality' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'houzez-theme-functionality' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'houzez-theme-functionality' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .houzez_section_title_wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'houzez_section_title_color',
            [
                'label'     => esc_html__( 'Main Title', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .houzez_section_title_wrap .houzez_section_title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'houzez_section_subtitle_color',
            [
                'label'     => esc_html__( 'Subtitle', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .houzez_section_title_wrap .houzez_section_subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );


        $this->add_responsive_control(
            'homey_main_title_spacing',
            [
                'label' => esc_html__( 'Main Title Margin Bottom', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
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
                    '{{WRAPPER}} .houzez_section_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'homey_subtitle_spacing',
            [
                'label' => esc_html__( 'Subtitle Margin Bottom', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
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
                    '{{WRAPPER}} .houzez_section_subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'houzez_section_title_margin_bottom',
            [
                'label' => esc_html__( 'Section Margin Bottom', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .houzez_section_title_wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.5.6
     * @access protected
     */
    protected function render() {       
       
        $settings = $this->get_settings_for_display();
        if ( $settings['hz_section_title'] || $settings['hz_section_subtitle'] ) {
            ?>
            <div class="houzez_section_title_wrap section-title-module">
                <?php if(!empty($settings['hz_section_title'])) { ?>
                    <h2 class="houzez_section_title"><?php echo ($settings['hz_section_title']); ?></h2>
                <?php } ?>

                <?php if(!empty($settings['hz_section_subtitle'])) { ?>
                    <p class="houzez_section_subtitle"><?php echo ($settings['hz_section_subtitle']); ?></p>
                <?php } ?>
            </div>
            <?php
        }
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Section_Title );