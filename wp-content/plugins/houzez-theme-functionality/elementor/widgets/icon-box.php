<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Text with icon Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.1
 */
class Houzez_Elementor_Icon_Box extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve Features Block widget name.
     *
     * @since 1.0.1
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'houzez_elementor_icon_box';
    }

    /**
     * Get widget title.
     *
     * Retrieve Features Block widget title.
     *
     * @since 1.0.1
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Icon Box', 'houzez-theme-functionality' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve Features Block widget icon.
     *
     * @since 1.0.1
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-post-list';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Features Section widget belongs to.
     *
     * @since 1.0.1
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'houzez-elements' ];
    }

    /**
     * Register Features Block widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.1
     * @access protected
     */
    protected function _register_controls() {

        //Content
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'houzez-theme-functionality' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon_boxes',
            [
                'label'  => esc_html__( 'Icon Box', 'houzez-theme-functionality' ),
                'type'   => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name'  => 'icon_type',
                        'label' => esc_html__( 'Icon Type', 'houzez-theme-functionality' ),
                        'type'      => Controls_Manager::SELECT,
                        'options'   => [
                            'fontawesome_icon'  => 'FontAwesome',
                            'custom_icon'    => 'Custom Icon'
                        ],
                        'default' => 'fontawesome_icon'
                    ],
                    [
                        'name'  => 'icon',
                        'label' => esc_html__( 'Fontawesome Icon', 'houzez-theme-functionality' ),
                        'type'  => Controls_Manager::ICON,
                        'condition' => [
                            'icon_type' => 'fontawesome_icon',
                        ],
                    ],
                    [
                        'name'  => 'custom_icon',
                        'label' => esc_html__( 'Custom Icon', 'houzez-theme-functionality' ),
                        'type'  => Controls_Manager::MEDIA,
                        'condition' => [
                            'icon_type' => 'custom_icon',
                        ],
                    ],
                    [
                        'name'  => 'title',
                        'label' => esc_html__( 'Title', 'houzez-theme-functionality' ),
                        'type'  => Controls_Manager::TEXT,
                    ],
                    [
                        'name'  => 'text',
                        'label' => esc_html__( 'Text', 'houzez-theme-functionality' ),
                        'type'  => Controls_Manager::TEXTAREA,
                    ],
                    [
                        'name'  => 'read_more_text',
                        'label' => esc_html__( 'Read More Text', 'houzez-theme-functionality' ),
                        'type'  => Controls_Manager::TEXT,
                    ],
                    [
                        'name'  => 'read_more_link',
                        'label' => esc_html__( 'Read More Link', 'houzez-theme-functionality' ),
                        'type'  => Controls_Manager::URL,
                    ],
                ],
                'default' => [],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section_settings',
            [
                'label' => esc_html__( 'Icon Boxes Style', 'houzez-theme-functionality' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'icon_boxes_style',
            [
                'label'     => 'Style',
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'style_one'  => 'Version 1',
                    'style3'    => 'Version 2'
                ],
                'description' => '',
                'default' => 'style_one',
            ]
        );
        $this->add_control(
            'icon_boxes_columns',
            [
                'label'     => 'Columns',
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'three_columns'  => 'Three Columns',
                    'four_columns'    => 'Four Columns'
                ],
                'description' => '',
                'default' => 'three_columns',
            ]
        );

        $this->add_responsive_control(
            'padding_a',
            [
                'label' => __( 'Padding', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .text-with-icon-item-v1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_boxes_style' => 'style_one'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_a',
                'selector' => '{{WRAPPER}} .text-with-icon-item-v1',
                'separator' => 'before',
                'condition' => [
                    'icon_boxes_style' => 'style_one'
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .text-with-icon-item-v1' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'icon_boxes_style' => 'style_one'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_a',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .text-with-icon-item-v1',
                'condition' => [
                    'icon_boxes_style' => 'style_one'
                ],
            ]
        );

        $this->add_control(
            'background_overlay_a',
            [
                'label' => __( 'Background Overlay', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .text-with-icon-item-v1' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'background_a_image[id]!' => '',
                    'icon_boxes_style' => 'style_one'
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_iconbox_style',
            [
                'label' => __( 'Styling', 'houzez-theme-functionality' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_iconstyle_a',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Icon', 'houzez-theme-functionality' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'icon_primary_color',
            [
                'label' => __( 'Icon Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .text-with-icon-item .houzez-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .text-with-icon-item .houzez-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => __( 'Icon Padding', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .text-with-icon-item-v1 .icon-thumb' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'icon_boxes_style' => 'style_one'
                ],
            ]
        );

        $this->add_control(
            'icon_rotate',
            [
                'label' => __( 'Icon Rotate', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                    'unit' => 'deg',
                ],
                'selectors' => [
                    '{{WRAPPER}} .text-with-icon-item .houzez-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_control(
            'heading_title_style_a',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Title', 'houzez-theme-functionality' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_spacing_a',
            [
                'label' => __( 'Spacing', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .text-with-icon-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color_a',
            [
                'label' => __( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-with-icon-title strong' => 'color: {{VALUE}}',

                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography_a',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .text-with-icon-title strong',
            ]
        );

        $this->add_control(
            'heading_description_style_a',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Description', 'houzez-theme-functionality' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color_a',
            [
                'label' => __( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-with-icon-item .text-with-icon-body' => 'color: {{VALUE}}',

                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography_a',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .text-with-icon-item .text-with-icon-body',
            
            ]
        );

        $this->add_control(
            'heading_iconbox_link',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Read More', 'houzez-theme-functionality' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'readmore_text_color',
            [
                'label' => __( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-with-icon-item .text-with-icon-link a' => 'color: {{VALUE}}',

                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'readmore_text_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .text-with-icon-item .text-with-icon-link a',
            
            ]
        );



        $this->end_controls_section();

    }

    /**
     * Render Features Block widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.1
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        $icon_boxes_style = $settings['icon_boxes_style'];
        $icon_boxes_columns = $settings['icon_boxes_columns'];

        $columns_class = "module-3cols";
        if($icon_boxes_columns == 'four_columns') {
            $columns_class = "module-4cols";
        }

        if( $icon_boxes_style == 'style3' ) { $no_margin = ''; } else { $no_margin = 'no-margin'; }
        ?>

        <div class="text-with-icons-module <?php echo esc_attr($columns_class); ?> clearfix">
            <?php
            foreach (  $settings['icon_boxes'] as $icon_box ) { 
                $read_more_link = $icon_box['read_more_link']['url'];
                $readmore_text = $icon_box['read_more_text'];
                $is_external = $icon_box['read_more_link']['is_external'];
                $icon_type = $icon_box['icon_type'];
                $title = $icon_box['title'];
                $text = wp_kses_post($icon_box['text']);
                $icon_image = wp_get_attachment_image( $icon_box['custom_icon']['id'] );
                $icon_fontawesome = esc_attr($icon_box['icon']); 
            
                    if($icon_boxes_style == 'style_one') {
                    ?>

                        <div class="text-with-icon-item text-with-icon-item-v1">
                            <div class="icon-thumb">
            
                                <?php
                                if( $icon_type == "fontawesome_icon" ) { ?>
                                    <div class="houzez-icon">
                                        <i class="<?php echo esc_attr($icon_fontawesome); ?>"></i>
                                    </div>
                                <?php } else {
                                    echo $icon_image;
                                }
                                ?>
                            </div><!-- icon-thumb -->
                            <div class="text-with-icon-info">
                                <div class="text-with-icon-title">
                                    <strong><?php echo esc_attr($title); ?></strong>
                                </div><!-- text-with-icon-title -->
                                <div class="text-with-icon-body">
                                    <?php echo $text; ?>
                                </div><!-- text-with-icon-body -->
                            </div><!-- text-with-icon-info -->

                            <?php if( $read_more_link != '' ) { ?>
                                <div class="text-with-icon-link">
                                <a href="<?php echo esc_url($read_more_link); ?>"  <?php if($is_external == 'on') { echo 'target="_blank"'; } ?>><?php echo esc_attr( $readmore_text ); ?></a>
                                </div>
                            <?php } ?>

                        </div><!-- text-with-icon-item  -->
                    <?php
                } else {?>

                    <div class="text-with-icon-item text-with-icon-item-v2">
                        <div class="d-flex">
                            <div class="icon-thumb">
                                <?php
                                if( $icon_type == "fontawesome_icon" ) { ?>
                                    <div class="houzez-icon">
                                        <i class="<?php echo esc_attr($icon_fontawesome); ?>"></i>
                                    </div>
                                <?php } else {
                                    echo $icon_image;
                                }
                                ?>
                            </div><!-- icon-thumb -->
                            <div class="text-with-icon-content-wrap flex-grow-1">
                                <div class="text-with-icon-info">
                                    <div class="text-with-icon-title">
                                        <strong><?php echo esc_attr($title); ?></strong>
                                    </div><!-- text-with-icon-title -->
                                    <div class="text-with-icon-body">
                                        <?php echo $text; ?>
                                    </div><!-- text-with-icon-body -->
                                </div><!-- text-with-icon-info -->
                                
                                <?php if( $read_more_link != '' ) { ?>
                                    <div class="text-with-icon-link">
                                    <a href="<?php echo esc_url($read_more_link); ?>"  <?php if($is_external == 'on') { echo 'target="_blank"'; } ?>><?php echo esc_attr( $readmore_text ); ?></a>
                                    </div>
                                <?php } ?>

                            </div><!-- text-with-icon-content-wrap -->
                        </div><!-- d-flex -->
                    </div><!-- text-with-icon-item  -->

            <?php
                }
            }
            ?>
        </div>
    <?php

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Icon_Box); 