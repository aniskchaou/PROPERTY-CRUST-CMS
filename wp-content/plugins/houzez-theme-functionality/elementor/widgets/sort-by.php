<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Section Title Widget.
 * @since 2.0
 */
class Houzez_Elementor_Sort_By extends Widget_Base {

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
        return 'houzez_elementor_sort_by';
    }

    /**
     * Get widget title.
     * @since 2.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Listings Sort By', 'houzez-theme-functionality' );
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
        return 'eicon-post-title';
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

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'sortby_title',
            [
                'label'     => esc_html__( 'Title', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => '',
                'default' => esc_html__('Sort By:', 'houzez-theme-functionality'),
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

        $sortby = '';
        if( isset( $_GET['sortby'] ) ) {
            $sortby = $_GET['sortby'];
        }
        $sort_id = 'sort_properties';
        ?>
        <div class="sort-by">
            <div class="d-flex align-items-center">
                <div class="sort-by-title">
                    <?php echo esc_attr($settings['sortby_title']); ?>
                </div><!-- sort-by-title -->  
                <select id="<?php echo esc_attr($sort_id); ?>" class="selectpicker form-control bs-select-hidden" title="<?php esc_html_e( 'Default Order', 'houzez' ); ?>" data-live-search="false" data-dropdown-align-right="auto">
                    <option value=""><?php esc_html_e( 'Default Order', 'houzez' ); ?></option>
                    <option <?php selected($sortby, 'a_price'); ?> value="a_price"><?php esc_html_e('Price - Low to High', 'houzez'); ?></option>
                    <option <?php selected($sortby, 'd_price'); ?> value="d_price"><?php esc_html_e('Price - High to Low', 'houzez'); ?></option>
                    
                    <option <?php selected($sortby, 'featured_first'); ?> value="featured_first"><?php esc_html_e('Featured Listings First', 'houzez'); ?></option>
                    
                    <option <?php selected($sortby, 'a_date'); ?> value="a_date"><?php esc_html_e('Date - Old to New', 'houzez' ); ?></option>
                    <option <?php selected($sortby, 'd_date'); ?> value="d_date"><?php esc_html_e('Date - New to Old', 'houzez' ); ?></option>
                </select><!-- selectpicker -->
            </div><!-- d-flex -->
        </div><!-- sort-by -->
        <?php
        if ( Plugin::$instance->editor->is_edit_mode() ) : 
        ?>
            <script>
                jQuery('.selectpicker').selectpicker('refresh');
            </script>
        
        <?php endif;
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Sort_By );