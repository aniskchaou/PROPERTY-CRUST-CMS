<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Blog Posts Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Blog_Posts_Carousel extends Widget_Base {

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
        return 'houzez_elementor_blog_posts_carousel';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Blog Posts Carousel', 'houzez-theme-functionality' );
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
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'grid_style',
            [
                'label'     => esc_html__( 'Grid Version', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
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
                'type'      => Controls_Manager::SELECT,
                'options'   => $category,
                'description' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'posts_limit',
            [
                'label'     => esc_html__('Number of posts to show', 'houzez-theme-functionality'),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
                'default' => '9',
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'     => 'Offset',
                'type'      => Controls_Manager::TEXT,
                'description' => '',
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'showhide_section',
            [
                'label'     => esc_html__( 'Show/Hide', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'show_author',
            [
                'label' => esc_html__( 'Post Author', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
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
                'type' => Controls_Manager::SWITCHER,
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
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'houzez-theme-functionality' ),
                'label_off' => __( 'Hide', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
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

        $args['grid_style'] =  $settings['grid_style'];
        $args['category_id'] =  $settings['category_id'];
        $args['posts_limit'] =  $settings['posts_limit'];
        $args['offset'] =  $settings['offset'];
       
        if( function_exists( 'houzez_blog_posts_carousel' ) ) {
            echo houzez_blog_posts_carousel( $args );
        }

        if ( Plugin::$instance->editor->is_edit_mode() ) : 
            $token = wp_generate_password(5, false, false);
            if (is_rtl()) {
                $houzez_rtl = "true";
            } else {
                $houzez_rtl = "false";
            }
            ?>

            <style>
                .slide-animated {
                    opacity: 1;
                }
            </style>
            <script>
                var owl_post_card = jQuery('#carousel-post-card-<?php echo esc_attr( $token ); ?>');

                owl_post_card.slick({
                    rtl: <?php echo esc_attr($houzez_rtl); ?>,
                    lazyLoad: 'ondemand',
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    arrows: true,
                    adaptiveHeight: true,
                    dots: true,
                    appendArrows: '.blog-posts-slider',
                    prevArrow: jQuery('.blog-prev-js'),
                    nextArrow: jQuery('.blog-next-js'),
                    responsive: [{
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 769,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            
            </script>
        
        <?php endif;
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Blog_Posts_Carousel );