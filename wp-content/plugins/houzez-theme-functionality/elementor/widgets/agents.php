<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Agents Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Agents extends Widget_Base {

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
        return 'houzez_elementor_agents';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Agents', 'houzez-theme-functionality' );
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
        return 'fa fa-black-tie';
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

        $agent_category = array();
        $agent_city = array();
        
        houzez_get_terms_array( 'agent_category', $agent_category );
        houzez_get_terms_array( 'agent_city', $agent_city );

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'agents_type',
            [
                'label'     => esc_html__( 'Module Type', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'grid'  => esc_html__('Grid', 'houzez-theme-functionality'),
                    'Carousel'    => esc_html__('Carousel', 'houzez')
                ],
                "description" => '',
                'default' => 'grid',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'     => esc_html__( 'Columns', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    '4'  => esc_html__('4 Columns', 'houzez-theme-functionality'),
                    '3'  => esc_html__('3 Columns', 'houzez-theme-functionality')
                ],
                "description" => '',
                'default' => '3',
            ]
        );

        $this->add_control(
            'agent_category',
            [
                'label'     => esc_html__( 'Category', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => $agent_category,
                'description' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'agent_city',
            [
                'label'     => esc_html__('City', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => $agent_city,
                'description' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'posts_limit',
            [
                'label'     => esc_html__('Number of Agents', 'houzez-theme-functionality'),
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

        $agent_category = $agent_city = array();

        if(!empty($settings['agent_category'])) {
            $agent_category = $settings['agent_category'];
        }

        if(!empty($settings['agent_city'])) {
            $agent_city = $settings['agent_city'];
        }

        $args['agent_category']   =  $agent_category;
        $args['agent_city']   =  $agent_city;

        $args['agents_type'] =  $settings['agents_type'];
        $args['orderby'] =  $settings['orderby'];
        $args['posts_limit'] =  $settings['posts_limit'];
        $args['columns'] =  $settings['columns'];
        $args['order'] =  $settings['order'];
        $args['offset'] =  $settings['offset'];
        
        if( function_exists( 'houzez_agents' ) ) {
            echo houzez_agents( $args );
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
            if(jQuery("#agents-carousel-<?php echo esc_attr( $token ); ?>").length > 0){
                var slides_to_show = <?php echo $settings['columns']; ?>,

                var owlAgents = jQuery('#agents-carousel-<?php echo esc_attr( $token ); ?>');
                owlAgents.slick({
                rtl: <?php echo esc_attr( $houzez_rtl ); ?>,
                lazyLoad: 'ondemand',
                infinite: true,
                speed: 300,
                slidesToShow: slides_to_show,
                arrows: true,
                adaptiveHeight: true,
                dots: true,
                appendArrows: '.agents-module-slider',
                prevArrow: jQuery('.agents-prev-js'),
                nextArrow: jQuery('.agents-next-js'),
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

            }
            
            </script>
        
        <?php endif;
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Agents );