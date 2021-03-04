<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Price Table Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Price_Table extends Widget_Base {

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
        return 'houzez_elementor_price_table';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Price Table', 'houzez-theme-functionality' );
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
        return 'fa fa-usd';
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

        $packages_array = array( esc_html__('None', 'houzez') => '');
        $packages_posts = get_posts(array('post_type' => 'houzez_packages', 'posts_per_page' => -1));
        if (!empty($packages_posts)) {
            foreach ($packages_posts as $package_post) {
                $packages_array[$package_post->ID] = $package_post->post_title;
            }
        }

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Content', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'package_id',
            [
                'label'     => esc_html__( 'Select Package', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => $packages_array,
                'description' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'package_data',
            [
                'label'     => esc_html__( 'Data Type', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'dynamic'  => 'Get Data From Package',
                    'custom'    => 'Add Custom Data'
                ],
                "description" => '',
                'default' => 'dynamic',
            ]
        );

        $this->add_control(
            'package_popular',
            [
                'label'     => esc_html__( 'Popular?', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'yes'  => 'Yes',
                    'no'    => 'No'
                ],
                "description" => '',
                'default' => 'no',
                'condition' => [
                    'package_data' => 'custom',
                ],
            ]
        );

        

        $this->add_control(
            'package_name',
            [
                'label'     => esc_html__('Package Name', 'houzez-theme-functionality'),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
                'condition' => [
                    'package_data' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'package_price',
            [
                'label'     => esc_html__('Package Price', 'houzez-theme-functionality'),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
                'condition' => [
                    'package_data' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'package_currency',
            [
                'label'     => esc_html__('Package Currency', 'houzez-theme-functionality'),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
                'default' => '$',
                'condition' => [
                    'package_data' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'content',
            [
                'label'     => esc_html__('Content', 'houzez-theme-functionality'),
                'type'      => Controls_Manager::WYSIWYG,
                'description' => '',
                'condition' => [
                    'package_data' => 'custom',
                ],
                'default' => '<ul class="list-unstyled">
    <li><i class="houzez-icon icon-check-circle-1 primary-text mr-1"></i> Time Period: <strong>10 days</strong></li>
    <li><i class="houzez-icon icon-check-circle-1 primary-text mr-1"></i> Properties: <strong>2</strong></li>
    <li><i class="houzez-icon icon-check-circle-1 primary-text mr-1"></i> Featured Listings: <strong>2</strong></li>
</ul>',
            ]
            
        );
        $this->add_control(
            'package_btn_text',
            [
                'label'     => esc_html__('Button Text', 'houzez-theme-functionality'),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
                'default' => 'Get Started',
                'condition' => [
                    'package_data' => 'custom'
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

        $args['package_id'] =  $settings['package_id'];
        $args['package_data'] =  $settings['package_data'];
        $args['package_popular'] =  $settings['package_popular'];
        $args['package_name'] =  $settings['package_name'];
        $args['package_price'] =  $settings['package_price'];
        $args['package_currency'] = $settings['package_currency'];
        $args['price_table_content'] = $settings['content'];
        $args['package_btn_text'] = $settings['package_btn_text'];
       
        if( function_exists( 'houzez_price_table' ) ) {
            echo houzez_price_table( $args );
        }

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Price_Table );