<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Properties Carousel v2 Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Properties_Carousels_v2 extends Widget_Base {

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
        return 'houzez_elementor_properties_carousel_v2';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Property Cards Carousel v1', 'houzez-theme-functionality' );
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
        return 'eicon-posts-carousel';
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

        //Carousel Settings
        $this->start_controls_section(
            'filters_section',
            [
                'label'     => esc_html__( 'Carousel Settings', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'listing_thumb',
                'exclude' => [ 'custom', 'thumbnail', 'houzez-image_masonry', 'houzez-map-info', 'houzez-variable-gallery', 'houzez-gallery' ],
                'include' => [],
                'default' => 'houzez-item-image-1',
            ]
        );
        $this->add_control(
            'slides_to_show',
            [
                'label'     => esc_html__('Slides To Show', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    '3' => '3',
                    '2' => '2',
                    '1' => '1',
                ],
                "description" => '',
                'default' => '3',
            ]
        );
        $this->add_control(
            'slides_to_scroll',
            [
                'label'     => esc_html__('Slides To Scroll', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3'
                ],
                "description" => '',
                'default' => '1',
            ]
        );
        $this->add_control(
            'slide_infinite',
            [
                'label'     => esc_html__('Infinite Scroll', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'true' => esc_html__('Yes', 'houzez-theme-functionality' ),
                    'false' => esc_html__('No', 'houzez-theme-functionality' )
                ],
                "description" => '',
                'default' => 'true',
            ]
        );
        $this->add_control(
            'slide_auto',
            [
                'label'     => esc_html__('Auto Play', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'false' => esc_html__('No', 'houzez-theme-functionality' ),
                    'true' => esc_html__('Yes', 'houzez-theme-functionality' )
                    
                ],
                "description" => '',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'auto_speed',
            [
                'label'     => 'Auto Play Speed',
                'type'      => Controls_Manager::TEXT,
                'description' => esc_html__("Autoplay Speed in milliseconds. Default 3000", 'houzez-theme-functionality'),
                'default' => '3000'
            ]
        );
        $this->add_control(
            'navigation',
            [
                'label'     => esc_html__('Next/Prev Navigation', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'false' => esc_html__('No', 'houzez-theme-functionality' ),
                    'true' => esc_html__('Yes', 'houzez-theme-functionality' )
                    
                ],
                "description" => '',
                'default' => 'true',
            ]
        );
        $this->add_control(
            'slide_dots',
            [
                'label'     => esc_html__('Dots Nav', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'false' => esc_html__('No', 'houzez-theme-functionality' ),
                    'true' => esc_html__('Yes', 'houzez-theme-functionality' )
                    
                ],
                "description" => '',
                'default' => 'true',
            ]
        );
        
        $this->end_controls_section();

        /*--------------------------------------------------------------------------------
        * Filters
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'content_section',
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
            'property_ids',
            [
                'label'     => esc_html__( 'Properties IDs', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::TEXT,
                'description'   => esc_html__( 'Enter properties ids comma separated. Ex 12,305,34', 'houzez-theme-functionality' ),
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

        $this->add_control(
            'sort_by',
            [
                'label'     => esc_html__( 'Sort By', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => houzez_sorting_array(),
                'description' => '',
                'default' => '',
            ]
        );

        $this->add_control(
            'posts_limit',
            [
                'label'     => esc_html__('Number of properties', 'houzez-theme-functionality'),
                'type'      => Controls_Manager::NUMBER,
                'min'     => 1,
                'max'     => 50,
                'step'    => 1,
                'default' => 9,
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
            'all_btn',
            [
                'label'     => esc_html__("All - Button Text", "houzez-theme-functionality"),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
            ]
        );
        $this->add_control(
            'all_url',
            [
                'label'     => esc_html__("All - Button URL", "houzez-theme-functionality"),
                'type'      => Controls_Manager::TEXT,
                'description' => '',
            ]
        );
        
        $this->end_controls_section();

        /*--------------------------------------------------------------------------------
        * Show/Hide 
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'hide_show_section',
            [
                'label'     => esc_html__( 'Show/Hide Data', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hide_compare',
            [
                'label' => esc_html__( 'Hide Compare Button', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-module .item-tools .item-compare' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_favorite',
            [
                'label' => esc_html__( 'Hide Favorite Button', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-module .item-tools .item-favorite' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_preview',
            [
                'label' => esc_html__( 'Hide Preview Button', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-module .item-tools .item-preview' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_featured_label',
            [
                'label' => esc_html__( 'Hide Featured Label', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-module .label-featured' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_status',
            [
                'label' => esc_html__( 'Hide Status', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-module .labels-wrap .label-status' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_label',
            [
                'label' => esc_html__( 'Hide Labels', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-module .labels-wrap .hz-label' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_button',
            [
                'label' => esc_html__( 'Hide Details Button', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-module .item-body .btn-item' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_author_date',
            [
                'label' => esc_html__( 'Hide Date & Agent', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-module .item-footer' => 'display: {{VALUE}};',
                    '{{WRAPPER}} .property-carousel-module .btn-item' => 'bottom: 20px;',
                ],
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
                'name'     => 'hz_property_title',
                'label'    => esc_html__( 'Property Title', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .item-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_prop_address',
                'label'    => esc_html__( 'Address', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} address.item-address',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_meta_labels',
                'label'    => esc_html__( 'Meta Labels', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .item-amenities-text',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_meta_figure',
                'label'    => esc_html__( 'Meta Figure', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .hz-figure',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_item_price',
                'label'    => esc_html__( 'Price', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .item-price',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_item_subprice',
                'label'    => esc_html__( 'Sub Price', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .item-sub-price',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_item_types',
                'label'    => esc_html__( 'Property Type', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .h-type span',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_item_area-postfix',
                'label'    => esc_html__( 'Area Postfix', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .area_postfix',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_btn-item',
                'label'    => esc_html__( 'Detail Button', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .btn-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_item_agent',
                'label'    => esc_html__( 'Agent', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .item-author a',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'hz_item_date',
                'label'    => esc_html__( 'Date', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .item-date',
            ]
        );

    
        $this->end_controls_section();

        /*--------------------------------------------------------------------------------
        * Margin and Spacing
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'hz_spacing_margin_section',
            [
                'label'     => esc_html__( 'Spaces & Sizes', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'hz_title_margin_bottom',
            [
                'label' => esc_html__( 'Title Margin Bottom(px)', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'hz_address_margin_bottom',
            [
                'label' => esc_html__( 'Address Margin Bottom(px)', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-address' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'hz_meta_icons',
            [
                'label' => esc_html__( 'Meta Icons Size(px)', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-amenities i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'hz_content_padding',
            [
                'label'      => esc_html__( 'Content Area Padding', 'houzez-theme-functionality' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .item-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*--------------------------------------------------------------------------------
        * Box Shadow
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'hz_grid_box_shadow',
            [
                'label' => esc_html__( 'Box Shadow', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'label'    => esc_html__( 'Box Shadow', 'houzez-theme-functionality' ),
                'selector' => '{{WRAPPER}} .item-wrap',
            ]
        );

        $this->end_controls_section();

        /*--------------------------------------------------------------------------------
        * Colors
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'hz_grid_colors',
            [
                'label' => esc_html__( 'Colors', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'grid_bg_color',
            [
                'label'     => esc_html__( 'Grid Background', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-wrap' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .item-footer' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'grid_bg_border_color',
            [
                'label'     => esc_html__( 'Border', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-footer' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => esc_html__( 'Price', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-price-wrap' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'buttons_bg_color',
            [
                'label'     => esc_html__( 'Item Tools Background Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-tool > span' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'buttons_bg_color_hover',
            [
                'label'     => esc_html__( 'Item Tools Background Color Hover', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-tool > span:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'buttons_color',
            [
                'label'     => esc_html__( 'Item Tools Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-tool > span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'buttons_color_hover',
            [
                'label'     => esc_html__( 'Item Tools Color Hover', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-tool > span:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'address_color',
            [
                'label'     => esc_html__( 'Address Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-address' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icons_color',
            [
                'label'     => esc_html__( 'Icons', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-amenities i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'figure_color',
            [
                'label'     => esc_html__( 'Figure', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .hz-figure' => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'labels_color',
            [
                'label'     => esc_html__( 'Labels', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-amenities-text' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .h-type span' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'author_color',
            [
                'label'     => esc_html__( 'Agent & Date', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-author a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .item-author' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .item-date' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'detail_btn_bg_color',
            [
                'label'     => esc_html__( 'Details Button Background Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.btn-item' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'detail_button_bg_hover',
            [
                'label'     => esc_html__( 'Details Button Background Color Hover', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.btn-item:hover' => 'background-color: {{VALUE}};  border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'detail_btn_color',
            [
                'label'     => esc_html__( 'Detail Button Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.btn-item' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'detail_btn_hover',
            [
                'label'     => esc_html__( 'Detail Button Color Hover', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} a.btn-item:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();

        /*--------------------------------------------------------------------------------
        * Next Prev button
        * -------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'hz_next_prev',
            [
                'label' => esc_html__( 'Next/Prev buttons', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'np_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-buttons-wrap button' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .btn-view-all' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'np_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-buttons-wrap button' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn-view-all' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'np_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-buttons-wrap button' => 'border: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .btn-view-all' => 'border: 1px solid {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'np_bg_color_hover',
            [
                'label'     => esc_html__( 'Background Color Hover', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-buttons-wrap button:hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .btn-view-all:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'np_color_hover',
            [
                'label'     => esc_html__( 'Color Hover', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-buttons-wrap button:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn-view-all:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'np_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color Hover', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .property-carousel-buttons-wrap button:hover' => 'border: 1px solid {{VALUE}}',
                    '{{WRAPPER}} .btn-view-all:hover' => 'border: 1px solid {{VALUE}}',
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

        if(!empty($settings['property_city'])) {
            $property_city = implode (",", $settings['property_city']);
        }

        if(!empty($settings['property_area'])) {
            $property_area = implode (",", $settings['property_area']);
        }

        if( !empty($settings['properties_by_agents']) ) {
            $properties_by_agents = $settings['properties_by_agents'];
        }

        $args['property_type']   =  $property_type;
        $args['property_status']   =  $property_status;
        $args['property_label']   =  $property_label;
        $args['property_country']   =  $property_country;
        $args['property_state']   =  $property_state;
        $args['property_city']   =  $property_city;
        $args['property_area']   =  $property_area;

        $args['featured_prop'] =  $settings['featured_prop'];
        $args['property_ids'] =  $settings['property_ids'];
        $args['posts_limit'] =  $settings['posts_limit'];
        $args['sort_by'] =  $settings['sort_by'];
        $args['offset'] =  $settings['offset'];

        $args['all_btn'] = $settings['all_btn'];
        $args['all_url'] = $settings['all_url'];
        $args['slides_to_show'] = $settings['slides_to_show'];
        $args['slides_to_scroll'] = $settings['slides_to_scroll'];
        $args['slide_infinite'] = $settings['slide_infinite'];
        $args['slide_auto'] = $settings['slide_auto'];
        $args['auto_speed'] = $settings['auto_speed'];
        $args['navigation'] = $settings['navigation'];
        $args['slide_dots'] = $settings['slide_dots'];
        $args['thumb_size'] = $settings['listing_thumb_size'];
        $args['properties_by_agents'] = $properties_by_agents;
        $args['min_price'] = $settings['min_price'];
        $args['max_price'] = $settings['max_price'];

        
        if( function_exists( 'houzez_prop_carousel_v1' ) ) {
            echo houzez_prop_carousel_v1( $args );
        }

        if ( Plugin::$instance->editor->is_edit_mode() ) : 
            $token = wp_generate_password(5, false, false);
            ?>

            <script>
            jQuery('.houzez-properties-carousel-js[id^="houzez-properties-carousel-"]').each(function(){
                var $div = jQuery(this);
                var token = $div.data('token');
                var obj = window['houzez_prop_caoursel_' + token];

                var slides_to_scroll = <?php echo $settings['slides_to_scroll']; ?>,
                    slides_to_show = <?php echo $settings['slides_to_show']; ?>,
                    navigation = <?php echo $settings['navigation']; ?>,
                    auto_play = <?php echo $settings['slide_auto']; ?>,
                    auto_play_speed = parseInt(<?php echo $settings['auto_speed']; ?>),
                    dots = <?php echo $settings['slide_dots']; ?>,
                    slide_infinite =  <?php echo $settings['slide_infinite']; ?>;

                var houzez_rtl = houzez_vars.houzez_rtl;

                if( houzez_rtl == 'yes' ) {
                    houzez_rtl = true;
                } else {
                    houzez_rtl = false;
                }

                function parseBool(str) {
                    if( str == 'true' ) { return true; } else { return false; }
                }

                var houzezCarousel = jQuery('#houzez-properties-carousel-'+token);

                jQuery('.houzez-properties-carousel-js').not('.slick-initialized').slick({
                    lazyLoad: 'ondemand',
                    infinite: slide_infinite,
                    speed: 300,
                    slidesToShow: slides_to_show,
                    slidesToScroll: slides_to_scroll,
                    arrows: navigation,
                    autoplay: auto_play,
                    autoplaySpeed: auto_play_speed,
                    adaptiveHeight: true,
                    dots: dots,
                    appendArrows: '.houzez-carousel-arrows-'+token,
                    prevArrow: jQuery('.slick-prev-js-'+token),
                    nextArrow: jQuery('.slick-next-js-'+token),
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

            });
            
            </script>
        
        <?php endif; 

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Properties_Carousels_v2 );