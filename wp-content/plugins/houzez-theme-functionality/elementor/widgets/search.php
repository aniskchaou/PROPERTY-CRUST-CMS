<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Properties Widget.
 * @since 2.0
 */
class Houzez_Elementor_Search extends Widget_Base {

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
        return 'houzez_elementor_search';
    }

    /**
     * Get widget title.
     * @since 2.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Search Composer', 'houzez-theme-functionality' );
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
        return 'eicon-site-search';
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

        $builtIn_fields = array_merge(houzez_search_builtIn_fields_elementor(), houzez_custom_search_fields());
       
        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'search_field',
            [
                'label'     => esc_html__( 'Search Field', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => $builtIn_fields,
                'description' => '',
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
        $args['search_field'] =  $settings['search_field'];

       
        if( function_exists( 'houzez_advanced_search' ) ) {
            echo houzez_advanced_search( $args );
        }

        if ( Plugin::$instance->editor->is_edit_mode() ) : 
        ?>
            <script>
                jQuery('.selectpicker').selectpicker('refresh');
            </script>
        
        <?php endif;

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Search );