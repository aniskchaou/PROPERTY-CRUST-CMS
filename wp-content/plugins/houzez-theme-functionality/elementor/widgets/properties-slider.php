<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Properties Widget.
 * @since 2.0
 */
class Houzez_Elementor_properties_slider extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve widget name.
     *
     * @since 2.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'houzez_elementor_properties_slider';
    }

    /**
     * Get widget title.
     * @since 2.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Properties Slider', 'houzez-theme-functionality' );
    }

    /**
     * Get widget icon.
     *
     * @since 2.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'fa fa-building-o';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the widget belongs to.
     *
     * @since 2.0
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
     * @since 2.0
     * @access protected
     */
    protected function _register_controls() {
        $prop_types = array();
        $prop_status = array();
        
        houzez_get_terms_array( 'property_status', $prop_status );
        houzez_get_terms_array( 'property_type', $prop_types );

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'posts_limit',
            [
                'label'     => esc_html__('Number of properties', 'houzez-theme-functionality'),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
                'default' => '9',
            ]
        );

        $this->add_control(
            'property_type',
            [
                'label'     => esc_html__( 'Property Type', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $prop_types,
                'description' => '',
                'multiple' => true,
                'default' => '',
            ]
        );

        $this->add_control(
            'property_status',
            [
                'label'     => esc_html__( 'Property Status', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $prop_status,
                'description' => '',
                'multiple' => true,
                'default' => '',
            ]
        );



        $this->end_controls_section();

    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 2.0
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings_for_display();
        $property_type = $property_status = '';

        if(!empty($settings['property_type'])) {
            $property_type = implode (",", $settings['property_type']);
        }

        if(!empty($settings['property_status'])) {
            $property_status = implode (",", $settings['property_status']);
        }

        $args['posts_limit'] =  $settings['posts_limit'];
        $args['property_type']   =  $property_type;
        $args['property_status']   =  $property_status;

       
        if( function_exists( 'houzez_properties_slider' ) ) {
            echo houzez_properties_slider( $args );
        }

        if ( Plugin::$instance->editor->is_edit_mode() ) : ?>
            <script>
                
                jQuery('.property-slider').slick({
                    lazyLoad: 'ondemand',
                    infinite: true,
                    speed: 300,
                    slidesToShow: 1,
                    arrows: true,
                    adaptiveHeight: true
                });
                
            </script>
        <?php
        endif;

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_properties_slider );