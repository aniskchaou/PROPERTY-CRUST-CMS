<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Advanced Search Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Advanced_Search extends Widget_Base {

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
        return 'houzez_elementor_advanced_search';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Advanced Search', 'houzez-theme-functionality' );
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
        return 'fa fa-search';
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
            'search_title',
            [
                'label'     => esc_html__( 'Title', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => esc_html__( 'Enter search title', 'houzez-theme-functionality' ),
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
                
        $args['search_title'] = $settings['search_title'];
       
        if( function_exists( 'houzez_advance_search' ) ) {
            echo houzez_advance_search( $args );
        }

        if ( Plugin::$instance->editor->is_edit_mode() ) :             
        ?>

        <script>
            jQuery('.selectpicker').selectpicker('refresh');
        </script>
    
        <?php 
        endif;

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Advanced_Search );