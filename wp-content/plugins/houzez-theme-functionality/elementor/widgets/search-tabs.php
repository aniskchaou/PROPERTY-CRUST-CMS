<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Properties Widget.
 * @since 2.0
 */
class Houzez_Elementor_Search_Tabs extends Widget_Base {

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
        return 'houzez_elementor_search_tabs';
    }

    /**
     * Get widget title.
     * @since 2.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Search Tabs', 'houzez-theme-functionality' );
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
        return 'eicon-tabs';
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
            'tabs_field',
            [
                'label'     => esc_html__( 'Tab Type', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => array(
                    'property_status' => esc_html__('Status', 'houzez-theme-functionality'),
                    'property_type' => esc_html__('Type', 'houzez-theme-functionality'),
                    'property_city' => esc_html__('City', 'houzez-theme-functionality'),
                ),
                'description' => '',
                'default' => 'property_status',
            ]
        );

        $this->add_control(
            'show_all',
            [
                'label' => __( 'Show All Tab', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'houzez-theme-functionality' ),
                'label_off' => __( 'Hide', 'houzez-theme-functionality' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'tabs_limit',
            [
                'label'     => esc_html__('Tabs Limit', 'houzez-theme-functionality'),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
                'default' => '3',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'homey_section_typography',
            [
                'label' => esc_html__( 'Settings', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'search_tabs_color',
            [
                'label'     => esc_html__( 'Tabs Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} #houzez-search-tabs-wrap .nav-link' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'search_tabs_active_color',
            [
                'label'     => esc_html__( 'Tabs Active Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} #houzez-search-tabs-wrap .nav-link.active' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'search_tabs_bg_color',
            [
                'label'     => esc_html__( 'Tabs Background Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#00aeff',
                'selectors' => [
                    '{{WRAPPER}} #houzez-search-tabs-wrap .nav-link' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'search_active_tabs_bg_color',
            [
                'label'     => esc_html__( 'Active Tabs Background Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} #houzez-search-tabs-wrap .nav-link.active' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'padding',
            [
                'label' => __( 'Padding', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} #houzez-search-tabs-wrap .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'margin',
            [
                'label' => __( 'Margin', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} #houzez-search-tabs-wrap .nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'radius',
            [
                'label' => __( 'Radius', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} #houzez-search-tabs-wrap .nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'houzez_search_tabs_align',
            [
                'label' => esc_html__( 'Alignment', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    ''    => [
                        'title' => esc_html__( 'Left', 'houzez-theme-functionality' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'justify-content-center' => [
                        'title' => esc_html__( 'Center', 'houzez-theme-functionality' ),
                        'icon' => 'fa fa-align-center',
                    ]
                ],
                'default' => 'justify-content-center',
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
        $tabs_field =  $settings['tabs_field'];
        $show_all =  $settings['show_all'];
        $tabs_limit =  $settings['tabs_limit'];

        if($tabs_field == 'property_status') {
            $tabs_field = 'property_status';
            $field_name = 'status[]';
            $all = esc_html__('All Status', 'houzez');

        } else if($tabs_field == 'property_type') {
            $tabs_field = 'property_type';
            $field_name = 'type[]';
            $all = esc_html__('All Types', 'houzez');
            
        } else if($tabs_field == 'property_city') {
            $tabs_field = 'property_city';
            $field_name = 'location[]';
            $all = esc_html__('All Cities', 'houzez');

        } else {
            $tabs_field = 'property_status';
            $field_name = 'status[]';
            $all = esc_html__('All Status', 'houzez');
        }
        ?>

        <ul id="houzez-search-tabs-wrap" class="houzez-status-tabs nav nav-pills <?php echo esc_attr($settings['houzez_search_tabs_align']); ?>" role="tablist" data-toggle="buttons">
            
            <?php if($show_all == 'yes') { ?>
            <li class="nav-item">
                <a class="nav-link active" data-val="" data-toggle="pill" href="#" role="tab" aria-selected="true">
                    <?php echo $all; ?>
                </a>
            </li>
            <?php } ?>

            <?php
            $terms = get_terms(
                array(
                    $tabs_field
                ),
                array(
                    'orderby'       => 'name',
                    'order'         => 'ASC',
                    'hide_empty'    => true,
                    /*'parent' => 0*/
                )
            );
            if (!empty($terms)) {
                $i = 0;      
                foreach ($terms as $term) { 

                    if($i == $tabs_limit) {
                        break;
                    }
                    echo '<li class="nav-item">
                            <a class="nav-link" data-val="'.esc_attr($term->slug).'" data-toggle="pill" href="#" role="tab" aria-selected="true">
                                '.esc_attr($term->name).'
                            </a>
                        </li>';
                    $i++;
                }
            }
            ?>
            <input type="hidden" name="<?php echo esc_attr($field_name); ?>" id="search-tabs">
        </ul>

       
    <?php
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Search_Tabs );