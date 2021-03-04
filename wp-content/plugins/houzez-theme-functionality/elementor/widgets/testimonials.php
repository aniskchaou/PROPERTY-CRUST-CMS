<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Testimonials Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Testimonials extends Widget_Base {

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
        return 'houzez_elementor_testimonials';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Testimonials v1', 'houzez-theme-functionality' );
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
        return 'eicon-testimonial';
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
            'testimonials_type',
            [
                'label'     => esc_html__( 'Testimonials Type', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'grid'  => esc_html__( 'Grid 4 Columns', 'houzez-theme-functionality'),
                    'grid_3cols'  => esc_html__( 'Grid 3 Columns', 'houzez-theme-functionality'),
                    'slides'    => esc_html__( 'Slides', 'houzez-theme-functionality')
                ],
                'default' => 'grid',
            ]
        );

        $this->add_control(
            'posts_limit',
            [
                'label'     => esc_html__( 'Limit', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => esc_html__( 'Number of testimonials to show.', 'houzez-theme-functionality' ),
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'     => esc_html__( 'Offset posts', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => '',
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label'     => esc_html__( 'Order By', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'none'  => esc_html__( 'None', 'houzez-theme-functionality'),
                    'ID'  => esc_html__( 'ID', 'houzez-theme-functionality'),
                    'title'   => esc_html__( 'Title', 'houzez-theme-functionality'),
                    'date'   => esc_html__( 'Date', 'houzez-theme-functionality'),
                    'rand'   => esc_html__( 'Random', 'houzez-theme-functionality'),
                    'menu_order'   => esc_html__( 'Menu Order', 'houzez-theme-functionality'),
                ],
                'default' => 'none',
            ]
        );
        $this->add_control(
            'order',
            [
                'label'     => esc_html__( 'Order', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'ASC'  => esc_html__( 'ASC', 'houzez-theme-functionality'),
                    'DESC'  => esc_html__( 'DESC', 'houzez-theme-functionality')
                ],
                'default' => 'ASC',
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
                
        $args['testimonials_type']        =  $settings['testimonials_type'];
        $args['posts_limit']     =  $settings['posts_limit'];
        $args['offset']  =  $settings['offset'];
        $args['orderby']  =  $settings['orderby'];
        $args['order']  =  $settings['order'];
       
        if( function_exists( 'houzez_testimonials' ) ) {
            echo houzez_testimonials( $args );
        }

        if ( Plugin::$instance->editor->is_edit_mode() ) : 
            $token = wp_generate_password(5, false, false);
            ?>

            <style>
                .slide-animated {
                    opacity: 1;
                }
            </style>
            <script>
                var houzez_rtl = houzez_vars.houzez_rtl;

                if( houzez_rtl == 'yes' ) {
                    houzez_rtl = true;
                } else {
                    houzez_rtl = false;
                }
                jQuery('.testimonials-slider-wrap-v1').slick({
                    rtl: houzez_rtl,
                    lazyLoad: 'ondemand',
                    infinite: true,
                    speed: 300,
                    slidesToShow: 1,
                    arrows: true,
                    adaptiveHeight: true,
                    dots: true,
                    appendArrows: '.testimonials-module-slider-v1',
                    prevArrow: jQuery('.slick-prev'),
                    nextArrow: jQuery('.slick-next'),
                });
            
            </script>
        
        <?php endif;

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Testimonials );