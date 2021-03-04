<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Properties Widget.
 * @since 2.0
 */
class Houzez_Elementor_Listings_Tabs extends Widget_Base {

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
        return 'houzez_elementor_listings_tabs';
    }

    /**
     * Get widget title.
     * @since 2.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Listings Tabs', 'houzez-theme-functionality' );
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

        $prop_cities = array();
        $prop_types = array();
        $prop_status = array();
        
        houzez_get_terms_array( 'property_status', $prop_status );
        houzez_get_terms_array( 'property_type', $prop_types );
        houzez_get_terms_array( 'property_city', $prop_cities );

       
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
            'type_data',
            [
                'label'     => esc_html__( 'Select Types', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $prop_types,
                'description' => '',
                'multiple' => true,
                'default' => '',
                'condition' => [
                    'tabs_field' => 'property_type',
                ],
            ]
        );

        $this->add_control(
            'status_data',
            [
                'label'     => esc_html__( 'Select Statuses', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $prop_status,
                'description' => '',
                'multiple' => true,
                'default' => '',
                'condition' => [
                    'tabs_field' => 'property_status',
                ],
            ]
        );

        $this->add_control(
            'city_data',
            [
                'label'     => esc_html__( 'Select Cities', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $prop_cities,
                'description' => '',
                'multiple' => true,
                'default' => '',
                'condition' => [
                    'tabs_field' => 'property_city',
                ],
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


        $this->end_controls_section();

        $this->start_controls_section(
            'homey_section_typography',
            [
                'label' => esc_html__( 'Tabs Style', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'listing_tabs_color',
            [
                'label'     => esc_html__( 'Tabs Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222222',
                'selectors' => [
                    '{{WRAPPER}} #houzez-listings-tabs-wrap .nav-link' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'search_tabs_active_color',
            [
                'label'     => esc_html__( 'Tabs Active Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222222',
                'selectors' => [
                    '{{WRAPPER}} #houzez-listings-tabs-wrap .nav-link.active' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'search_tabs_bg_color',
            [
                'label'     => esc_html__( 'Tabs Background Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ebebeb',
                'selectors' => [
                    '{{WRAPPER}} #houzez-listings-tabs-wrap .nav-link' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} #houzez-listings-tabs-wrap .nav-link.active' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} #houzez-listings-tabs-wrap .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} #houzez-listings-tabs-wrap .nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} #houzez-listings-tabs-wrap .nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_align',
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
        global $post;
        $settings = $this->get_settings_for_display();
        $tabs_field =  $settings['tabs_field'];
        $show_all =  $settings['show_all'];
        
        if( $tabs_field == 'property_type') {
            $taxonomies = $settings['type_data'];

        } else if( $tabs_field == 'property_status') {
            $taxonomies = $settings['status_data'];

        } else if( $tabs_field == 'property_city') {
            $taxonomies = $settings['city_data'];
        }

        $current_tab = $all_tab = '';
        if(isset($_GET['tab']) && $_GET['tab'] != '') {
            $current_tab = $_GET['tab'];
        } else {
            $all_tab = 'active';
        }

        $listing_page_link = get_permalink( $post->ID );
        ?>

        <div id="houzez-listings-tabs-wrap" class="listing-tabs flex-grow-1">
            
            <ul class="nav nav-tabs <?php echo esc_attr($settings['tabs_align']); ?>">
                
                <?php if($show_all == 'yes') { ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo esc_attr($all_tab); ?>" href="<?php echo esc_url($listing_page_link); ?>">
                        <?php echo esc_html__('All', 'houzez'); ?>
                    </a>
                </li>
                <?php } ?>

                
                <?php
                if (!empty($taxonomies)) {
             
                    foreach ($taxonomies as $slug) { 

                        $tab_link = add_query_arg( 
                            array(
                                'tab' => $slug, 
                                'tax' => $tabs_field, 
                            ), $listing_page_link 
                        );

                        $active_tab = '';
                        if( $current_tab == $slug ) {
                            $active_tab = 'active';
                        }

                        $tabname = houzez_get_term_by( 'slug', $slug, $tabs_field );
                        echo '<li class="nav-item">
                                <a class="nav-link '.$active_tab.'" href="'.esc_url($tab_link).'">
                                    '.esc_attr($tabname->name).'
                                </a>
                            </li>';
                    }
                }
                ?>
                

            </ul><!-- nav-tabs -->
                
        </div><!-- listing-tabs -->

    
    <?php
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Listings_Tabs );