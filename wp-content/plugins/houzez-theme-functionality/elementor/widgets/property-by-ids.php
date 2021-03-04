<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Property by ID Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Property_By_IDs extends Widget_Base {

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
        return 'houzez_elementor_property_by_ids';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Property by IDs', 'houzez-theme-functionality' );
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
            'prop_grid_style',
            [
                'label'     => esc_html__( 'Grid Style', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'v_1'  => esc_html__( 'Property Card v1', 'houzez-theme-functionality'),
                    'v_2'    => esc_html__( 'Property Card v2', 'houzez-theme-functionality'),
                    'v_3'    => esc_html__( 'Property Card v3', 'houzez-theme-functionality'),
                    'v_5'    => esc_html__( 'Property Card v5', 'houzez-theme-functionality'),
                    'v_6'    => esc_html__( 'Property Card v6', 'houzez-theme-functionality')
                ],
                'description' => esc_html__('Choose grid style, default will be propety card v1', 'homey'),
                'default' => 'v_1',
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
            'columns',
            [
                'label'     => esc_html__( 'Columns', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    '3cols'  => esc_html__( '3 Columns', 'houzez-theme-functionality'),
                    '2cols'    => esc_html__( '2 Columns', 'houzez-theme-functionality')
                ],
                'description' => esc_html__('Note: Property card v4 will show only 2 columns', 'homey'),
                'default' => '3cols',
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
                    '{{WRAPPER}} .property-by-ids-module .item-tools .item-compare' => 'display: {{VALUE}};',
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
                    '{{WRAPPER}} .property-by-ids-module .item-tools .item-favorite' => 'display: {{VALUE}};',
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
                    '{{WRAPPER}} .property-by-ids-module .item-tools .item-preview' => 'display: {{VALUE}};',
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
                    '{{WRAPPER}} .property-by-ids-module .label-featured' => 'display: {{VALUE}};',
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
                    '{{WRAPPER}} .property-by-ids-module .labels-wrap .label-status' => 'display: {{VALUE}};',
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
                    '{{WRAPPER}} .property-by-ids-module .labels-wrap .hz-label' => 'display: {{VALUE}};',
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
                    '{{WRAPPER}} .property-by-ids-module .item-body .btn-item' => 'display: {{VALUE}};',
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
                    '{{WRAPPER}} .property-by-ids-module .item-footer' => 'display: {{VALUE}};',
                    '{{WRAPPER}} .property-by-ids-module .item-author' => 'display: {{VALUE}};',
                    '{{WRAPPER}} .property-by-ids-module .item-date' => 'display: {{VALUE}};',
                    '{{WRAPPER}} .property-by-ids-module .btn-item' => 'bottom: 20px;',
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
                'selector' => '{{WRAPPER}} .item-price, .item-v5-price',
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
                'selector' => '{{WRAPPER}} .h-type span, .item-v5-type',
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
                    '{{WRAPPER}} .item-v5-price' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .item-v5-type' => 'color: {{VALUE}}',
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
                
        $args['prop_grid_style'] =  $settings['prop_grid_style'];
        $args['property_ids']     =  $settings['property_ids'];
        $args['columns']     =  $settings['columns'];
       
        if( function_exists( 'houzez_property_by_ids' ) ) {
            echo houzez_property_by_ids( $args );
        }

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Property_By_IDs );