<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Blog Posts Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Blog_Posts extends \Elementor\Widget_Base {

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
        return 'houzez_elementor_blog_posts';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Blog Posts Grid', 'houzez-theme-functionality' );
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
        return 'fa fa-pencil';
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

        $category = array();
        
        houzez_get_terms_id_array( 'category', $category );

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'houzez-theme-functionality' ),
                'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'post_thumb',
                'exclude' => [ 'custom', 'thumbnail', 'houzez-image_masonry', 'houzez-map-info', 'houzez-variable-gallery', 'houzez-gallery' ],
                'include' => [],
                'default' => 'houzez-item-image-1',
            ]
        );

        $this->add_control(
            'grid_style',
            [
                'label'     => esc_html__( 'Grid Version', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'options'   => [
                    'style_1'  => 'Version 1',
                    'style_2'    => 'Version 2'
                ],
                "description" => '',
                'default' => 'style_1',
            ]
        );

        $this->add_control(
            'category_id',
            [
                'label'     => esc_html__( 'Category', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::SELECT2,
                'options'   => $category,
                'multiple'   => true,
                'description' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'posts_row',
            [
                'label'     => esc_html__('Posts in Row', 'houzez-theme-functionality'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'description' => '',
                'options' => array(
                    'col-lg-12 col-md-12' => '1',
                    'col-lg-6 col-md-6' => '2',
                    'col-lg-4 col-md-6' => '3',
                    'col-lg-3 col-md-6' => '4',
                ),
                'default' => 'col-lg-3 col-md-6',
            ]
        );

        $this->add_control(
            'posts_limit',
            [
                'label'     => esc_html__('Number of posts to show', 'houzez-theme-functionality'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'description' => '',
                'default' => '9',
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'     => 'Offset',
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'description' => '',
            ]
        );

        
        $this->end_controls_section();


        $this->start_controls_section(
            'showhide_section',
            [
                'label'     => esc_html__( 'Show/Hide', 'houzez-theme-functionality' ),
                'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'show_author',
            [
                'label' => esc_html__( 'Post Author', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'houzez-theme-functionality' ),
                'label_off' => __( 'Hide', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );
        $this->add_control(
            'show_date',
            [
                'label' => esc_html__( 'Post Date', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'houzez-theme-functionality' ),
                'label_off' => __( 'Hide', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'show_cat',
            [
                'label' => esc_html__( 'Post Category', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'houzez-theme-functionality' ),
                'label_off' => __( 'Hide', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->end_controls_section();

        /*----------------------------- Style ------------------------*/
        $this->start_controls_section(
            'style_section',
            [
                'label'     => esc_html__( 'Style', 'houzez-theme-functionality' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'post_box',
            [
                'label' => esc_html__( 'Post Box', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_control(
            'box_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .blog-post-item-v1' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding_top',
            [
                'label' => esc_html__( 'Padding Top', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 8,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post-item-v1' => 'padding-top: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding_bottom',
            [
                'label' => esc_html__( 'Padding Bottom', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 8,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post-item-v1' => 'padding-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_responsive_control(
            'box_margin_bottom',
            [
                'label' => esc_html__( 'Margin Bottom', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 8,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post-item-v1' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_control(
            'post_image',
            [
                'label' => esc_html__( 'Image Style', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__( 'Margin left & right', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 8,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post-item-v1 .blog-post-thumb' => 'margin: 0px {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_control(
            'post_title',
            [
                'label' => esc_html__( 'Post Title', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .blog-post-title h3 a' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .blog-post-item .blog-post-title h3',
            ]
        );

        $this->add_responsive_control(
            'title_margin_top',
            [
                'label' => esc_html__( 'Margin Top', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post-title' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin_bottom',
            [
                'label' => esc_html__( 'Margin Bottom', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'post_content',
            [
                'label' => esc_html__( 'Post Content', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .blog-post-body' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .blog-post-body',
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin_top',
            [
                'label' => esc_html__( 'Margin Top', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post-body' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin_bottom',
            [
                'label' => esc_html__( 'Margin Bottom', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post-body' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_control(
            'post_meta',
            [
                'label' => esc_html__( 'Post Meta', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'postmeta_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .blog-post-item-v1 .blog-post-meta, .blog-post-item-v1 .blog-post-meta time' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .blog-post-item-v2 .blog-post-meta a, .blog-post-item-v2 .blog-post-meta time' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'postmeta_cat_color',
            [
                'label'     => esc_html__( 'Category Color', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .blog-post-meta a' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'postmeta_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .blog-post-item .blog-post-meta',
            ]
        );

        $this->add_responsive_control(
            'postmeta_margin_top',
            [
                'label' => esc_html__( 'Margin Top', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post-item .blog-post-meta' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_responsive_control(
            'postmeta_margin_bottom',
            [
                'label' => esc_html__( 'Margin Bottom', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post-item .blog-post-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'post_footer',
            [
                'label' => esc_html__( 'Footer', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'footer_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .blog-post-item-v1 .blog-post-author' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'grid_style' => 'style_1'
                ],
            ]
        );

        $this->add_control(
            'author_color',
            [
                'label'     => esc_html__( 'Author Text Color', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .blog-post-author' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'postauthor_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .blog-post-author',
            ]
        );

        $this->add_responsive_control(
            'author_padding',
            [
                'label' => __( 'Padding', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post-author' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'footer_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .blog-post-item-v2' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'grid_style' => 'style_2'
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
        global $ele_settings;
        $settings = $this->get_settings_for_display();
        $ele_settings = $settings;

        $grid_style  =  $settings['grid_style'];
        $category_id =  $settings['category_id'];
        $posts_limit =  $settings['posts_limit'];
        $offset      =  $settings['offset'];
        $posts_row   =  $settings['posts_row'];
        $thumb_size  = $settings['post_thumb_size'];

        $module_style = 'blog-posts-module-v1';
        $templ_part = 'content-grid-1';

        if(  $settings['grid_style'] == "style_2" ) {
            $module_style = 'blog-posts-module-v2';
            $templ_part = 'content-grid-2';
        }

        $wp_query_args = array(
            'ignore_sticky_posts' => 1,
            'post_type' => 'post'
        );
        if (!empty($category_id)) {
            $wp_query_args['cat'] = $category_id;
        }
        if (!empty($offset)) {
            $wp_query_args['offset'] = $offset;
        }
        $wp_query_args['post_status'] = 'publish';

        if (empty($posts_limit)) {
            $posts_limit = get_option('posts_per_page');
        }
        $wp_query_args['posts_per_page'] = $posts_limit;

        $the_query = New WP_Query($wp_query_args);
        ?>

        <div class="blog-posts-module <?php echo esc_attr($module_style); ?>">
            <div class="row module-row">
                <?php 
                if ($the_query->have_posts()): 
                    while ($the_query->have_posts()): $the_query->the_post(); ?>
                    <div class="<?php echo esc_attr($posts_row); ?>">
                        <?php get_template_part($templ_part); ?>
                    </div>
                <?php endwhile; 
                endif;
                wp_reset_postdata(); ?>
            </div>
        </div>

        <?php

    }

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Blog_Posts() );