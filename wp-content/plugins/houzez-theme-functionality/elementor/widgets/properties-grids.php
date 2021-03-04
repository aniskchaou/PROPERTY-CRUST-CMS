<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Properties Grids Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Properties_Grids extends Widget_Base {

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
        return 'houzez_elementor_properties_grids';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Property Grids', 'houzez-theme-functionality' );
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
        return 'fa fa-building-o';
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
            'prop_grid_type',
            [
                'label'     => esc_html__( 'Grid Style', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'grid_1'  => 'Grid v1',
                    'grid_2'    => 'Grid v2',
                    'grid_3'    => 'Grid v3',
                    'grid_4'    => 'Grid v4',
                ],
                'description' => '',
                'default' => 'grid_1',
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
            'offset',
            [
                'label'     => 'Offset',
                'type'      => Controls_Manager::TEXT,
                'description' => '',
            ]
        );

        
        $this->end_controls_section();

        //Filters
        $this->start_controls_section(
            'filters_section',
            [
                'label'     => esc_html__( 'Filters', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Property taxonomies controls
        $prop_taxonomies = get_object_taxonomies( 'property', 'objects' );
        unset( $prop_taxonomies['property_feature'] );

        $page_filters = houzez_option('houzez_page_filters');

        if( isset($page_filters) && !empty($page_filters) ) {
            foreach ($page_filters as $filter) {
                unset( $prop_taxonomies[$filter] );
            }
        }

        if ( ! empty( $prop_taxonomies ) && ! is_wp_error( $prop_taxonomies ) ) {
            foreach ( $prop_taxonomies as $single_tax ) {

                $options_array = array();
                $terms   = get_terms( $single_tax->name );

                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                    foreach ( $terms as $term ) {
                        $options_array[ $term->slug ] = $term->name;
                    }
                }

                $this->add_control(
                    $single_tax->name,
                    [
                        'label'    => $single_tax->label,
                        'type'     => Controls_Manager::SELECT2,
                        'multiple' => true,
                        'label_block' => true,
                        'options'  => $options_array,
                    ]
                );
            }
        }

        $this->add_control(
            'properties_by_agents',
            [
                'label'    => esc_html__('Properties by Agents', 'houzez'),
                'type'     => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options'  => array_slice( houzez_get_agents_array(), 1, null, true ),
            ]
        );

        $this->add_control(
            'min_price',
            [
                'label'    => esc_html__('Minimum Price', 'houzez'),
                'type'     => Controls_Manager::NUMBER,
                'label_block' => false,
            ]
        );
        $this->add_control(
            'max_price',
            [
                'label'    => esc_html__('Maximum Price', 'houzez'),
                'type'     => Controls_Manager::NUMBER,
                'label_block' => false,
            ]
        );


        $this->add_control(
            'featured_prop',
            [
                'label'     => esc_html__( 'Featured Properties', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''  => esc_html__( '- Any -', 'houzez-theme-functionality'),
                    'no'    => esc_html__('Without Featured', 'houzez'),
                    'yes'  => esc_html__('Only Featured', 'houzez')
                ],
                "description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez-theme-functionality"),
                'default' => '',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'property_grids_settings',
            [
                'label' => esc_html__( 'Settings', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hide_tools',
            [
                'label' => esc_html__( 'Hide Tools', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .property-grids-module .item-tools' => 'display: {{VALUE}};',
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
        global $ele_lazyloadbg; 
        
        $settings = $this->get_settings_for_display();
        $property_type = $property_status = $property_label = $property_country = $property_state = $property_city = $property_area = $properties_by_agents = '';

        if(!empty($settings['property_type'])) {
            $property_type = implode (",", $settings['property_type']);
        }

        if(!empty($settings['property_status'])) {
            $property_status = implode (",", $settings['property_status']);
        }

        if(!empty($settings['property_label'])) {
            $property_label = implode (",", $settings['property_label']);
        }

        if(!empty($settings['property_state'])) {
            $property_state = implode (",", $settings['property_state']);
        }

        if(!empty($settings['property_country'])) {
            $property_country = implode (",", $settings['property_country']);
        }

        if(!empty($settings['property_city'])) {
            $property_city = implode (",", $settings['property_city']);
        }

        if(!empty($settings['property_area'])) {
            $property_area = implode (",", $settings['property_area']);
        }

        if( !empty($settings['properties_by_agents']) ) {
            $properties_by_agents = $settings['properties_by_agents'];
        }

        $args['prop_grid_type'] =  $settings['prop_grid_type'];
        $args['featured_prop'] =  $settings['featured_prop'];
        $args['posts_limit'] =  $settings['posts_limit'];
        $args['offset'] =  $settings['offset'];

        $args['property_type']    =  $property_type;
        $args['property_status']  =  $property_status;
        $args['property_label']   =  $property_label;
        $args['property_country'] =  $property_country;
        $args['property_state']   =  $property_state;
        $args['property_city']    =  $property_city;
        $args['property_area']    =  $property_area;
        $args['properties_by_agents'] = $properties_by_agents;
        $args['min_price'] = $settings['min_price'];
        $args['max_price'] = $settings['max_price'];

        $ele_lazyloadbg = '';
        if ( ! Plugin::$instance->editor->is_edit_mode() ) {
            $ele_lazyloadbg = houzez_get_lazyload_for_bg();
        }
        $args['ele_lazyloadbg']   =  $ele_lazyloadbg;
       
        if( function_exists( 'houzez_prop_grids' ) ) {
            echo houzez_prop_grids( $args );
        }

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Properties_Grids );