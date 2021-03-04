<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Grids Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Grids extends Widget_Base {

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
        return 'houzez_elementor_grids';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Houzez Grids', 'houzez-theme-functionality' );
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
        return 'fa fa-th';
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
            'houzez_grid_type',
            [
                'label'     => esc_html__( 'Choose Grid', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'grid_v1'  => esc_html__( 'Grid v1', 'houzez-theme-functionality'),
                    'grid_v2'    => esc_html__( 'Grid v2', 'houzez-theme-functionality'),
                    'grid_v3'    => esc_html__( 'Grid v3', 'houzez-theme-functionality'),
                    'grid_v4'    => esc_html__( 'Grid v4', 'houzez-theme-functionality'),
                ],
                'description' => '',
                'default' => 'grid_v1',
            ]
        );

        $this->add_control(
            'houzez_grid_from',
            [
                'label'     => esc_html__( 'Choose Taxonomy', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'property_type' => 'Types',
                    'property_status' => 'Status',
                    'property_label' => 'Label',
                    'property_country' => 'Country',
                    'property_state' => 'State',
                    'property_city' => 'City',
                    'property_area' => 'Area',
                ],
                'description' => '',
                'default' => 'property_type',
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
                        'condition' => [
                            'houzez_grid_from' => $single_tax->name,
                        ],
                    ]
                );
            }
        }
        

        $this->add_control(
            'houzez_show_child',
            [
                'label'     => esc_html__( 'Show Child', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    '0'  => esc_html__( 'No', 'houzez-theme-functionality'),
                    '1'    => esc_html__( 'Yes', 'houzez-theme-functionality')
                ],
                'description' => '',
                'default' => '0',
            ]
        );

        $this->add_control(
            'houzez_hide_empty',
            [
                'label'     => esc_html__( 'Hide Empty', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    '0'  => esc_html__( 'No', 'houzez-theme-functionality'),
                    '1'    => esc_html__( 'Yes', 'houzez-theme-functionality')
                ],
                'description' => '',
                'default' => '1',
            ]
        );

        $this->add_control(
            'houzez_hide_count',
            [
                'label'     => esc_html__( 'Hide Count', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    '0'  => esc_html__( 'No', 'houzez-theme-functionality'),
                    '1'    => esc_html__( 'Yes', 'houzez-theme-functionality')
                ],
                'description' => '',
                'default' => '0',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'     => esc_html__( 'Order By', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'name'  => esc_html__( 'Name', 'houzez-theme-functionality'),
                    'count'    => esc_html__( 'Count', 'houzez-theme-functionality'),
                    'id'    => esc_html__( 'ID', 'houzez-theme-functionality')
                ],
                'description' => '',
                'default' => 'name',
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


        $this->add_control(
            'no_of_terms',
            [
                'label'     => esc_html__('Number of Items to Show', 'houzez-theme-functionality'),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
                'default' => '',
            ]
        );
        
        $this->end_controls_section();


        /*--------------------------------------------------------------------------------
        * Typography
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'typography_section',
            [
                'label'     => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'grid_title_typography',
                'label'    => esc_html__( 'Title Typography', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .taxonomy-title',
                'fields_options' => [
                    // Inner control name
                    'font_weight' => [
                        // Inner control settings
                        'default' => '500',
                    ],
                    'font_family' => [
                        'default' => 'Roboto',
                    ],
                    'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 24 ] ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'grid_subtitle_typography',
                'label'    => esc_html__( 'Subtitle Typography', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .taxonomy-subtitle',
                'fields_options' => [
                    // Inner control name
                    'font_weight' => [
                        // Inner control settings
                        'default' => '300',
                    ],
                    'font_family' => [
                        'default' => 'Roboto',
                    ],
                    'font_size' => [ 'default' => [ 'unit' => 'px', 'size' => 14 ] ],
                ],
            ]
        );

        $this->add_control(
            'grid_title_color',
            [
                'label'     => esc_html__( 'Title Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'grid_subtitle_color',
            [
                'label'     => esc_html__( 'Subtitle Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .taxonomy-subtitle' => 'color: {{VALUE}}',
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
        $property_type = $property_status = $property_label = $property_country = $property_state = $property_city = $property_area = array();

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

        $args['houzez_grid_type'] =  $settings['houzez_grid_type'];
        $args['houzez_grid_from'] =  $settings['houzez_grid_from'];
        $args['houzez_show_child'] =  $settings['houzez_show_child'];
        $args['houzez_hide_count'] =  $settings['houzez_hide_count'];
        $args['orderby'] =  $settings['orderby'];
        $args['order'] =  $settings['order'];
        $args['houzez_hide_empty'] =  $settings['houzez_hide_empty'];
        $args['no_of_terms'] =  $settings['no_of_terms'];

        $args['property_type']   =  $property_type;
        $args['property_status']   =  $property_status;
        $args['property_label']   =  $property_label;
        $args['property_country']   =  $property_country;
        $args['property_state']   =  $property_state;
        $args['property_city']   =  $property_city;
        $args['property_area']   =  $property_area;

        $lazyloadbg = '';
        if ( ! Plugin::$instance->editor->is_edit_mode() ) {
            $lazyloadbg = houzez_get_lazyload_for_bg();
        }

        $args['get_lazyload']   =  $lazyloadbg;
       
        if( function_exists( 'houzez_grids' ) ) {
            echo houzez_grids( $args );
        }

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Grids );