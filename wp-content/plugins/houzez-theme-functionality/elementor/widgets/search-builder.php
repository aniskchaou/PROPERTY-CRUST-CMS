<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Properties Widget.
 * @since 2.0
 */
class Houzez_Elementor_Search_Builder extends Widget_Base {

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
        return 'houzez_elementor_search_builder';
    }

    /**
     * Get widget title.
     * @since 2.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Search Builder', 'houzez-theme-functionality' );
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

        $repeater = new Repeater();
        $field_types = array();

        $field_types = [
            'keyword' => esc_html__( 'Keyword', 'houzez-theme-functionality' ), //input
            'type[]' => esc_html__( 'Type', 'houzez-theme-functionality' ), //select
            'status[]' => esc_html__( 'Status', 'houzez-theme-functionality' ), //select
            'label[]' => esc_html__( 'Label', 'houzez-theme-functionality' ), //select
            'bedrooms' => esc_html__( 'Bedrooms', 'houzez-theme-functionality' ), //select
            'rooms' => esc_html__( 'Rooms', 'houzez-theme-functionality' ), //select
            'bathrooms' => esc_html__( 'Bathrooms', 'houzez-theme-functionality' ), //select
            'feature[]' => esc_html__( 'Features', 'houzez-theme-functionality' ), // select
            'country[]' => esc_html__( 'Country', 'houzez-theme-functionality' ), // select
            'location[]' => esc_html__( 'City', 'houzez-theme-functionality' ), // select
            'areas[]' => esc_html__( 'Area', 'houzez-theme-functionality' ), // select
            'states[]' => esc_html__( 'State', 'houzez-theme-functionality' ), // select
            'min-area' => esc_html__( 'Min Area', 'houzez-theme-functionality' ), // number
            'max-area' => esc_html__( 'Max Area', 'houzez-theme-functionality' ), // number
            'min-land-area' => esc_html__( 'Min Land Area', 'houzez-theme-functionality' ), // number
            'max-land-area' => esc_html__( 'Max Land Area', 'houzez-theme-functionality' ), // number
            'min-price' => esc_html__( 'Min Price', 'houzez-theme-functionality' ), // select
            'max-price' => esc_html__( 'Max Price', 'houzez-theme-functionality' ), // select
            'price-range' => esc_html__( 'Price Range Slider', 'houzez-theme-functionality' ), // range slider
            'property_id' => esc_html__( 'Property ID', 'houzez-theme-functionality' ), // input
            'garage' => esc_html__( 'Garage', 'houzez-theme-functionality' ), // number
            'year-built' => esc_html__( 'Year Built', 'houzez-theme-functionality' ), // number
            'search_location' => esc_html__( 'Geo Location', 'houzez-theme-functionality' ), // input
            'radius' => esc_html__( 'Radius', 'houzez-theme-functionality' ), // select
        ];

        $field_types = array_merge($field_types, houzez_search_builder_custom_field_elementor());

        /**
         * Forms field types.
         */
        $field_types = apply_filters( 'houzez/search_composer/fields', $field_types );

        $field_types['search-button'] = esc_html__( 'Search Button', 'houzez-theme-functionality' ); // button


        $repeater->add_control(
            'important_note',
            [
                'label' => '',
                'type' => Controls_Manager::RAW_HTML,
                'raw' => esc_html__( 'Search button settings are below under "Search Button" section', 'houzez-theme-functionality' ),
                'content_classes' => 'elementor-descriptor',
                'condition' => [
                    'field_type' => 'search-button'
                ],
            ]
        );

        $repeater->add_control(
            'field_type',
            [
                'label' => esc_html__( 'Field', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'options' => $field_types,
                'default' => 'text',
            ]
        );

        $repeater->add_control(
            'field_label',
            [
                'label' => esc_html__( 'Label', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'placeholder',
            [
                'label' => esc_html__( 'Placeholder', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'field_type',
                            'operator' => '!in',
                            'value' => [
                                'price-range',
                            ],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'radius_from',
            [
                'label' => esc_html__( 'From', 'houzez' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '1',
                'condition' => [
                    'field_type' => 'radius'
                ],
            ]
        );

        $repeater->add_control(
            'radius_to',
            [
                'label' => esc_html__( 'To', 'houzez' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '100',
                'condition' => [
                    'field_type' => 'radius'
                ],
            ]
        );

        $repeater->add_control(
            'radius_default',
            [
                'label' => esc_html__( 'Default Radius', 'houzez' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '32',
                'condition' => [
                    'field_type' => 'radius'
                ],
            ]
        );

        $repeater->add_control(
            'price_from_text',
            [
                'label' => esc_html__( 'From', 'houzez' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'From',
                'condition' => [
                    'field_type' => 'price-range'
                ],
            ]
        );

        $repeater->add_control(
            'price_to_text',
            [
                'label' => esc_html__( 'To', 'houzez' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'To',
                'condition' => [
                    'field_type' => 'price-range'
                ],
            ]
        );

        $repeater->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Column Width', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Default', 'houzez-theme-functionality' ),
                    '100' => '100%',
                    '90' => '90%',
                    '83' => '83%',
                    '80' => '80%',
                    '75' => '75%',
                    '70' => '70%',
                    '66' => '66%',
                    '65' => '65%',
                    '60' => '60%',
                    '55' => '55%',
                    '50' => '50%',
                    '45' => '45%',
                    '40' => '40%',
                    '33' => '33%',
                    '35' => '35%',
                    '30' => '30%',
                    '25' => '25%',
                    '20' => '20%',
                    '16' => '16%',
                    '15' => '15%',
                    '14' => '14%',
                    '12' => '12%',
                    '11' => '11%',
                    '10' => '10%',
                ],
                'default' => '100',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'field_type',
                            'operator' => '!in',
                            'value' => [
                                ''
                            ],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'price_field_type',
            [
                'label' => esc_html__( 'Field Type', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'select',
                'options' => array(
                    'select' => esc_html__('Select', 'houzez-theme-functionality'), 
                    'input' => esc_html__('Input', 'houzez-theme-functionality'), 
                ),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'field_type',
                            'operator' => 'in',
                            'value' => [
                                'min-price',
                                'max-price',
                            ],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'data_live_search',
            [
                'label' => esc_html__( 'Data Live Search', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => '',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'field_type',
                            'operator' => 'in',
                            'value' => [
                                'type[]',
                                'status[]',
                                'label[]',
                                'areas[]',
                                'feature[]',
                                'country[]',
                                'location[]',
                                'states[]',
                                'min-price',
                                'max-price',
                            ],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_responsive_control(
            'slider_width',
            [
                'label' => esc_html__( 'Slider Width(%)', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .price-range-wrap' => 'width: {{SIZE}}%;',
                ],
                'condition' => [
                    'field_type' => 'price-range'
                ],
            ]
        );

        $repeater->add_control(
            'is_multiple',
            [
                'label' => esc_html__( 'Multi Selection', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => '',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'field_type',
                            'operator' => 'in',
                            'value' => [
                                'type[]',
                                'status[]',
                                'label[]',
                                'areas[]',
                                'feature[]',
                            ],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'select_all_btns',
            [
                'label' => esc_html__( 'Select/Deselect All', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => 'false',
                'condition' => [
                    'is_multiple' => 'true'
                ],
            ]
        );

        $repeater->add_control(
            'selected_count_text',
            [
                'label' => esc_html__( 'Selected Items Text', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'items selected',
                'condition' => [
                    'is_multiple' => 'true'
                ],
            ]
        );

        $repeater->add_control(
            'responsvice_label',
            [
                'label' => esc_html__( 'Responsive', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::HEADING,
                'description' => esc_html__('', 'houzez-theme-functionality'),
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            'responsvice_note',
            [
                'label' => '',
                'type' => Controls_Manager::RAW_HTML,
                'raw' => esc_html__( 'Responsive visibility will take effect only on preview or live page, and not while editing in Elementor.', 'houzez-theme-functionality' ),
                'content_classes' => 'elementor-descriptor'
            ]
        );
        
        $repeater->add_control(
            'hidden_desktop',
            [
                'label' => esc_html__( 'Hide On Desktop', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'hidden-desktop',
                'default' => '',
            ]
        );

        $repeater->add_control(
            'hidden_tablet',
            [
                'label' => esc_html__( 'Hide On Tablet', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'hidden-tablet',
                'default' => '',
            ]
        );

        $repeater->add_control(
            'hidden_phone',
            [
                'label' => esc_html__( 'Hide On Mobile', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'hidden-phone',
                'default' => '',
            ]
        );

        $this->start_controls_section(
            'section_form_fields',
            [
                'label' => esc_html__( 'Form Fields', 'houzez-theme-functionality' ),
            ]
        );

        $this->add_control(
            'form_fields',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        '_id' => 'field-cities',
                        'field_type' => 'location[]',
                        'field_label' => esc_html__( 'Cities', 'houzez-theme-functionality' ),
                        'placeholder' => esc_html__( 'All Cities', 'houzez-theme-functionality' ),
                        'width' => '20',
                    ],
                    [
                        '_id' => 'field-types',
                        'field_type' => 'type[]',
                        'field_label' => esc_html__( 'Property Type', 'houzez-theme-functionality' ),
                        'placeholder' => esc_html__( 'All Types', 'houzez-theme-functionality' ),
                        'is_multiple' => 'true',
                        'select_all_btns' => 'true',
                        'selected_count_text' => 'types selected',
                        'width' => '20',
                        'width_mobile' => '50',
                    ],
                    [
                        '_id' => 'field-status',
                        'field_type' => 'status[]',
                        'field_label' => esc_html__( 'Property Status', 'houzez-theme-functionality' ),
                        'placeholder' => esc_html__( 'All Status', 'houzez-theme-functionality' ),
                        'is_multiple' => 'true',
                        'select_all_btns' => 'true',
                        'selected_count_text' => 'status selected',
                        'width' => '20',
                        'width_mobile' => '50',
                    ],
                    [
                        '_id' => 'field-beds',
                        'field_type' => 'bedrooms',
                        'field_label' => esc_html__( 'Bedrooms', 'houzez-theme-functionality' ),
                        'placeholder' => esc_html__( 'Bedrooms', 'houzez-theme-functionality' ),
                        'width' => '20',
                        'width_mobile' => '50',
                    ],
                    [
                        '_id' => 'field-baths',
                        'field_type' => 'bedrooms',
                        'field_label' => esc_html__( 'Bathrooms', 'houzez-theme-functionality' ),
                        'placeholder' => esc_html__( 'Bathrooms', 'houzez-theme-functionality' ),
                        'width' => '20',
                        'width_mobile' => '50',
                    ],
                    [
                        '_id' => 'field-min-price',
                        'field_type' => 'min-price',
                        'field_label' => esc_html__( 'Min. Price', 'houzez-theme-functionality' ),
                        'placeholder' => esc_html__( 'Min. Price', 'houzez-theme-functionality' ),
                        'width' => '16',
                        'width_mobile' => '50',
                    ],
                    [
                        '_id' => 'field-max-price',
                        'field_type' => 'max-price',
                        'field_label' => esc_html__( 'Max. Price', 'houzez-theme-functionality' ),
                        'placeholder' => esc_html__( 'Max. Price', 'houzez-theme-functionality' ),
                        'width' => '16',
                        'width_mobile' => '50',
                    ],
                    [
                        '_id' => 'field-min-area',
                        'field_type' => 'min-area',
                        'field_label' => esc_html__( 'Min. Area', 'houzez-theme-functionality' ),
                        'placeholder' => esc_html__( 'Min. Area', 'houzez-theme-functionality' ),
                        'width' => '16',
                        'width_mobile' => '50',
                    ],
                    [
                        '_id' => 'field-max-area',
                        'field_type' => 'max-area',
                        'field_label' => esc_html__( 'Max. Area', 'houzez-theme-functionality' ),
                        'placeholder' => esc_html__( 'Max. Area', 'houzez-theme-functionality' ),
                        'width' => '16',
                        'width_mobile' => '50',
                    ],
                    [
                        '_id' => 'field-property_id',
                        'field_type' => 'property_id',
                        'field_label' => esc_html__( 'Property ID', 'houzez-theme-functionality' ),
                        'placeholder' => esc_html__( 'Property ID', 'houzez-theme-functionality' ),
                        'width' => '16',
                    ],
                    [
                        '_id' => 'field-search-btn',
                        'field_type' => 'search-button',
                        'field_label' => esc_html__( 'Search Button', 'houzez-theme-functionality' ),
                        'placeholder' => esc_html__( 'Search', 'houzez-theme-functionality' ),
                        'width' => '16',
                    ],
                ],
                'title_field' => '{{{ field_label }}}',
            ]
        );

        $this->add_control(
            'input_size',
            [
                'label' => esc_html__( 'Input Size', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'xs' => esc_html__( 'Extra Small', 'houzez-theme-functionality' ),
                    'sm' => esc_html__( 'Small', 'houzez-theme-functionality' ),
                    'md' => esc_html__( 'Medium', 'houzez-theme-functionality' ),
                    'lg' => esc_html__( 'Large', 'houzez-theme-functionality' ),
                    'xl' => esc_html__( 'Extra Large', 'houzez-theme-functionality' ),
                ],
                'default' => 'sm',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => esc_html__( 'Button Size', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'sm',
                'separator' => 'before',
                'options' => array(
                    'xs' => esc_html__( 'Extra Small', 'houzez-theme-functionality' ),
                    'sm' => esc_html__( 'Small', 'houzez-theme-functionality' ),
                    'md' => esc_html__( 'Medium', 'houzez-theme-functionality' ),
                    'lg' => esc_html__( 'Large', 'houzez-theme-functionality' ),
                    'xl' => esc_html__( 'Extra Large', 'houzez-theme-functionality' ),
                )
            ]
        );

        $this->add_responsive_control(
            'button_align',
            [
                'label' => esc_html__( 'Button Alignment', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__( 'Left', 'houzez-theme-functionality' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'houzez-theme-functionality' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__( 'Right', 'houzez-theme-functionality' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Justified', 'houzez-theme-functionality' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => 'stretch',
                'prefix_class' => 'elementor%s-button-align-',
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label' => esc_html__( 'Labels', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'Hide', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => '',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /*------------------------------ Tabs ---------------------------*/
        $prop_cities = array();
        $prop_types = array();
        $prop_status = array();
        
        houzez_get_terms_array( 'property_status', $prop_status );
        houzez_get_terms_array( 'property_type', $prop_types );
        houzez_get_terms_array( 'property_city', $prop_cities );

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Tabs', 'houzez-theme-functionality' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_tabs',
            [
                'label' => __( 'Show Tabs', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'houzez-theme-functionality' ),
                'label_off' => __( 'Hide', 'houzez-theme-functionality' ),
                'return_value' => 'yes',
                'default' => 'no',
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
                'condition' => [
                    'show_tabs' => 'yes'
                ]
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
                'label_block' => true,
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
                'label_block' => true,
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
                'label_block' => true,
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

        $this->add_control(
            'tabs_all_text',
            [
                'label' => __( 'Show All Text', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'show_all' => 'yes'
                ],
                'default' => 'All',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_form_style',
            [
                'label' => esc_html__( 'Form', 'houzez-theme-functionality' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label' => esc_html__( 'Columns Gap', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-field-group' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    '{{WRAPPER}} .elementor-form-fields-wrapper' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label' => esc_html__( 'Rows Gap', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-field-group' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-form-fields-wrapper' => 'margin-bottom: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_label',
            [
                'label' => esc_html__( 'Label', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'label_spacing',
            [
                'label' => esc_html__( 'Spacing', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    'body.rtl {{WRAPPER}} .elementor-labels-inline .elementor-field-group > label' => 'padding-left: {{SIZE}}{{UNIT}};',
                    'body:not(.rtl) {{WRAPPER}} .elementor-labels-inline .elementor-field-group > label' => 'padding-right: {{SIZE}}{{UNIT}};',
                    'body {{WRAPPER}} .elementor-labels-above .elementor-field-group > label' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-field-group > label, {{WRAPPER}} .elementor-field-subgroup label' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .elementor-field-group > label',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        /*---------------------------- Form Background -------------------------*/
        $this->add_control(
            'backgroud_label',
            [
                'label' => esc_html__( 'Background', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'form_background_color',
            [
                'label' => esc_html__( 'Background Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .houzez-ele-search-form-wrapper' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'form_padding',
            [
                'label' => __( 'Padding', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .houzez-ele-search-form-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => esc_html__( 'Border', 'houzez-theme-functionality' ),
                'selector' => '{{WRAPPER}} .houzez-ele-search-form-wrapper',
            ]
        );

        $this->add_responsive_control(
            'form_radius',
            [
                'label' => esc_html__( 'Radius', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .houzez-ele-search-form-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__( 'Box Shadow', 'houzez-theme-functionality' ),
                'selector' => '{{WRAPPER}} .houzez-ele-search-form-wrapper',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_field_style',
            [
                'label' => esc_html__( 'Fields', 'houzez-theme-functionality' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'field_text_color',
            [
                'label' => esc_html__( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-field-group .elementor-field, {{WRAPPER}} .location-trigger' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper button:not(.actions-btn)' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper button:not(.bs-placeholder) .filter-option-inner-inner' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'selector' => '{{WRAPPER}} .elementor-field-group .elementor-field, {{WRAPPER}} .elementor-field-subgroup label, {{WRAPPER}} .elementor-field-group .elementor-select-wrapper button:not(.actions-btn) , {{WRAPPER}} .elementor-field-group .elementor-select-wrapper .dropdown-menu .text',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_control(
            'field_background_color',
            [
                'label' => esc_html__( 'Background Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)' => 'background-color: {{VALUE}};',
                    
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper button:not(.actions-btn)' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'field_border_color',
            [
                'label' => esc_html__( 'Border Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#dce0e0',
                'selectors' => [
                    '{{WRAPPER}} .elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper button:not(.actions-btn)' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper button::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .location-trigger' => 'border-color: {{VALUE}};'
                ],
                'separator' => 'before',
            ]
        );


        $this->add_responsive_control(
            'field_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper .form-control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper button:not(.actions-btn)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_price_slider_style',
            [
                'label' => esc_html__( 'Price Slider', 'houzez-theme-functionality' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_range_color',
            [
                'label' => esc_html__( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .range-text' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_range_typography',
                'selector' => '{{WRAPPER}} .range-text',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_responsive_control(
            'price_range_top_margin',
            [
                'label' => esc_html__( 'Margin Top', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .houzez-ele-price-slider' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'price_range_bottom_margin',
            [
                'label' => esc_html__( 'Margin Bottom', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .houzez-ele-price-slider' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'houzez_section_tabs',
            [
                'label' => esc_html__( 'Tabs Style', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'search_tabs_typography',
                'selector' => '{{WRAPPER}} .nav-item .nav-link',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
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

        $this->add_responsive_control(
            'tabs_padding',
            [
                'label' => __( 'Padding', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} #houzez-search-tabs-wrap .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'tabs_margin',
            [
                'label' => __( 'Margin', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} #houzez-search-tabs-wrap .nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_radius',
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


        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__( 'Button', 'houzez-theme-functionality' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__( 'Normal', 'houzez-theme-functionality' ),
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__( 'Background Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'default' => '#00aeff',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_text_padding',
            [
                'label' => esc_html__( 'Text Padding', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__( 'Hover', 'houzez-theme-functionality' ),
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => esc_html__( 'Background Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#33beff',
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => esc_html__( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'button_border_border!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_hover_animation',
            [
                'label' => esc_html__( 'Animation', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

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

        $this->add_render_attribute(
            [
                'wrapper' => [
                    'class' => [
                        'houzez-ele-search-form-wrapper',
                        'elementor-form-fields-wrapper',
                        'elementor-labels-above',
                    ],
                ],
            ]
        );
        
        $tabs_field =  $settings['tabs_field'];
        $show_all =  $settings['show_all'];
        
        if( $tabs_field == 'property_type') {
            $tab_taxonomies = $settings['type_data'];
            $field_name = 'type[]';

        } else if( $tabs_field == 'property_status') {
            $tab_taxonomies = $settings['status_data'];
            $field_name = 'status[]';

        } else if( $tabs_field == 'property_city') {
            $tab_taxonomies = $settings['city_data'];
            $field_name = 'location[]';
        }

        $current_tab = $all_tab = '';
        if(isset($_GET['tab']) && $_GET['tab'] != '') {
            $current_tab = $_GET['tab'];
        } else {
            $all_tab = 'active';
        }

        $listing_page_link = get_permalink( $post->ID );

        if ( ! empty( $settings['form_id'] ) ) {
            $this->add_render_attribute( 'form', 'id', $settings['form_id'] );
        }
        ?>

        <form class="houzez-search-form-js" id="houzez-search-<?php echo $this->get_id(); ?>" method="get" action="<?php echo esc_url( houzez_get_search_template_link() ); ?>" <?php echo $this->get_render_attribute_string( 'form' ); ?>>

            <?php if( $settings['show_tabs'] == 'yes' ) { ?>

            <ul id="houzez-search-tabs-wrap" class="houzez-status-tabs nav nav-pills <?php echo esc_attr($settings['houzez_search_tabs_align']); ?>" role="tablist" data-toggle="buttons">
            
                <?php if($show_all == 'yes') { ?>
                <li class="nav-item">
                    <a class="nav-link active" data-val="" data-toggle="pill" href="#" role="tab" aria-selected="true">
                        <?php echo esc_attr($settings['tabs_all_text']); ?>
                    </a>
                </li>
                <?php } ?>

                <?php
                $default_tab = '';
                if (!empty($tab_taxonomies)) {
                    $jj = 0;
                    foreach ($tab_taxonomies as $slug) { $jj++;
                        $active_class = '';
                        if($show_all != 'yes' && $jj == 1) {
                            $active_class = 'active';
                            $default_tab = esc_attr($slug);
                        }
                        $tabname = houzez_get_term_by( 'slug', $slug, $tabs_field );
                        if( $tabname ) {
                         echo '<li class="nav-item">
                                <a class="status-tab-js nav-link '.esc_attr($active_class).'" data-val="'.esc_attr($slug).'" data-toggle="pill" href="#" role="tab" aria-selected="true">
                                    '.esc_attr($tabname->name).'
                                </a>
                            </li>';
                        }
                    }
                }
                ?>
                <input type="hidden" name="<?php echo esc_attr($field_name); ?>" id="search-tabs" value="<?php echo esc_attr($default_tab); ?>">
            </ul>
            <?php } ?>

            <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>

                <?php
                foreach ( $settings['form_fields'] as $item_index => $item ) :
                    $item['input_size'] = $settings['input_size'];
                    $item['button_size'] = $settings['button_size'];
                    $field_name = $item['field_type'];

                    $this->houzez_form_fields_render_attributes( $item_index, $settings, $item );

                    if( $field_name == 'search_location' ) {
                        $this->add_render_attribute( 'field-group' . $item_index, 'class', 'hz-map-field-js' );
                        $this->add_render_attribute( 'field-group' . $item_index, 'data-address-field', $this->houzez_get_attribute_id( $item ) );
                    }

                    if( $field_name == 'price-range' ) {
                        $this->add_render_attribute( 'field-group' . $item_index, 'class', 'houzez-ele-price-slider' );
                    }

                    if( $field_name != "search-button" ) {
                    ?>
                        <div <?php echo $this->get_render_attribute_string( 'field-group' . $item_index ); ?>>
                    <?php
                    }

                    if ( $item['field_label'] && 'html' !== $item['field_type'] && 'search-button' !== $item['field_type'] && 'price-range' !== $item['field_type'] ) {
                        echo '<label ' . $this->get_render_attribute_string( 'label' . $item_index ) . '>' . $item['field_label'] . '</label>';
                    }


                    switch ( $item['field_type'] ) :
                    

                        case 'type[]':
                            echo $this->houzez_taxonomy_field( $item, $item_index, 'property_type', 'type' );
                            break;

                        case 'status[]':
                            echo $this->houzez_taxonomy_field( $item, $item_index, 'property_status', 'status', 'status-js' );
                            break;

                        case 'label[]':
                            echo $this->houzez_taxonomy_field( $item, $item_index, 'property_label', 'label' );
                            break;

                        case 'country[]':
                            echo $this->houzez_taxonomy_field( $item, $item_index, 'property_country', 'country', 'houzezSelectFilter houzezCountryFilter houzezFirstList houzez-country-js', 'houzezSecondList' );
                            break;

                        case 'states[]':
                            echo $this->houzez_taxonomy_field( $item, $item_index, 'property_state', 'states', 'houzezSelectFilter houzezStateFilter houzezSecondList houzez-state-js', 'houzezThirdList' );
                            break;

                        case 'location[]':
                            echo $this->houzez_taxonomy_field( $item, $item_index, 'property_city', 'location', 'houzezSelectFilter houzezCityFilter houzezThirdList houzez-city-js', 'houzezFourthList' );
                            break;

                        case 'areas[]':
                            echo $this->houzez_taxonomy_field( $item, $item_index, 'property_area', 'areas', 'houzezSelectFilter houzezFourthList' );
                            break;

                        case 'feature[]':
                            echo $this->houzez_taxonomy_field( $item, $item_index, 'property_feature', 'feature', '' );
                            break;

                        case 'bedrooms':
                            echo $this->houzez_beds_baths_field( $item, $item_index, 'bedrooms');
                            break;

                        case 'rooms':
                            echo $this->houzez_beds_baths_field( $item, $item_index, 'rooms');
                            break;

                        case 'bathrooms':
                            echo $this->houzez_beds_baths_field( $item, $item_index, 'bathrooms');
                            break;

                        case 'min-price':
                            echo $this->houzez_min_price( $item, $item_index );
                            break;

                        case 'max-price':
                            echo $this->houzez_max_price( $item, $item_index );
                            break;

                        case 'price-range':
                            echo $this->houzez_price_range( $item, $item_index );
                            break;

                        case 'search_location':
                            echo $this->houzez_geolocation( $item, $item_index, $settings );
                            break;

                        case 'radius':
                            echo $this->houzez_radius( $item, $item_index );
                            break;

                        case 'garage':
                        case 'year-built':
                        case 'min-area':
                        case 'max-area':
                        case 'min-land-area':
                        case 'max-land-area':
                            $this->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual' );
                            echo '<input type="number" size="1" ' . $this->get_render_attribute_string( 'input' . $item_index ) . '>';
                            break;

                        case 'property_id':
                            $this->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual' );
                            echo '<input type="text" size="1" ' . $this->get_render_attribute_string( 'input' . $item_index ) . '>';
                            break;

                        case 'keyword':
                            echo $this->houzez_keyword( $item, $item_index );
                            break;

                        case 'search-button':
                            if ( $settings['button_hover_animation'] ) {
                                $this->add_render_attribute( 'button'. $item_index, 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
                            }
                            ?>
                            <div <?php echo $this->get_render_attribute_string( 'submit-group'. $item_index ); ?>>
                                <button type="submit" <?php echo $this->get_render_attribute_string( 'button'. $item_index ); ?>>
                                    <?php if ( ! empty( $item['placeholder'] ) ) : ?>
                                        <?php echo esc_attr($item['placeholder']); ?>
                                    <?php endif; ?>
                                </button>
                            </div>
                            <?php
                            break;
                           
                        default:
                            $custom_field = houzez_custom_field_by_id_elementor($item['field_type']);

                            if($custom_field) {
                                $c_field_type = $custom_field['type'];

                                if( $c_field_type == 'text' or $c_field_type == 'textarea' ) {
                                    $this->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual' );
                                    echo '<input type="text" size="1" ' . $this->get_render_attribute_string( 'input' . $item_index ) . '>';

                                } else if( $c_field_type == 'number' ) {
                                    $this->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual' );
                                    echo '<input type="number" size="1" ' . $this->get_render_attribute_string( 'input' . $item_index ) . '>';

                                } else if( $c_field_type == "select" ) {
                                    $c_field_options = $custom_field['fvalues'];
                                    echo $this->houzez_c_select_field( $item, $item_index, $c_field_options);
                                    break;

                                } else if( $c_field_type == "radio" ) {
                                    $c_field_options = $custom_field['fvalues'];
                                    echo $this->houzez_c_radio_select_field( $item, $item_index, $c_field_options);
                                    break;

                                } else if( $c_field_type == "checkbox_list" ) {
                                    $c_field_options = $custom_field['fvalues'];
                                    echo $this->houzez_c_multi_select_field( $item, $item_index, $c_field_options, true);
                                    break;

                                } else if( $c_field_type == "multiselect" ) {
                                    $c_field_options = $custom_field['fvalues'];
                                    echo $this->houzez_c_multi_select_field( $item, $item_index, $c_field_options);
                                    break;
                                }
                            }
                            break;
                             
                    endswitch;

                    if( $field_name != "search-button" ) { ?>
                    </div>
                    <?php } ?>

                    <?php endforeach; ?>

            </div><!-- End wrapper-->

        </form>

        <?php
        if ( Plugin::$instance->editor->is_edit_mode() ) :     
        $min_price_range = houzez_option('advanced_search_widget_min_price', 0);
        $max_price_range = houzez_option('advanced_search_widget_max_price', 2500000); 
        ?>
        <script>
            jQuery('.selectpicker').selectpicker('refresh');

            function addCommasEle(nStr) {
                nStr += '';
                var x = nStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }
            function price_range() {

                var min_price = <?php echo $min_price_range; ?>;
                var max_price = <?php echo $max_price_range; ?>;

                jQuery(".price-range").slider({
                    range: true,
                    min: min_price,
                    max: max_price,
                    values: [min_price, max_price],
                    slide: function (event, ui) {
                    },
                    stop: function( event, ui ) {
                    }
                });
                jQuery(".min-price-range").text(addCommasEle(jQuery(".price-range").slider("values", 0)));
                jQuery(".max-price-range").text(addCommasEle(jQuery(".price-range").slider("values", 1)));
                
            }
            price_range();
        </script>

        <style type="text/css">
            [data-elementor-device-mode=desktop] .elementor-hidden-desktop .elementor-field, 
            [data-elementor-device-mode=desktop] .elementor-hidden-desktop .elementor-field-label,
            [data-elementor-device-mode=tablet] .elementor-hidden-tablet .elementor-field, 
            [data-elementor-device-mode=tablet] .elementor-hidden-tablet .elementor-field-label,
            [data-elementor-device-mode=mobile] .elementor-hidden-phone .elementor-field, 
            [data-elementor-device-mode=mobile] .elementor-hidden-phone .elementor-field-label, 
            [data-elementor-device-mode=desktop] .elementor-hidden-desktop .houzez-search-button,
            [data-elementor-device-mode=tablet] .elementor-hidden-tablet .houzez-search-button,
            [data-elementor-device-mode=mobile] .elementor-hidden-phone .houzez-search-button { 
                filter: opacity(.4) saturate(0); 
            }
        </style>
    
        <?php 
        endif;
    }


    public function houzez_get_attribute_name( $item ) {
        return "{$item['field_type']}";
    }

    public function houzez_get_attribute_id( $item ) {
        return 'form-field-' . $item['_id'];
    }

    private function houzez_add_multiple_attribute( $element ) {
        $this->add_render_attribute( $element, 'multiple', 'multiple' );
    }

    protected function houzez_form_fields_render_attributes( $i, $instance, $item ) {
        $this->add_render_attribute(
            [
                'field-group' . $i => [
                    'class' => [
                        'elementor-field-group',
                        'elementor-column',
                        'form-group',
                        'elementor-field-group-' . $item['_id'],
                    ],
                ],
                'input' . $i => [
                    'name' => $this->houzez_get_attribute_name( $item ),
                    'id' => $this->houzez_get_attribute_id( $item ),
                    'class' => [
                        'elementor-field',
                        'form-control',
                        'elementor-size-' . $item['input_size'],
                    ],
                ],
                'submit-group' . $i => [
                    'class' => [
                        'elementor-field-group',
                        'elementor-column',
                        'elementor-field-type-submit',
                    ],
                ],
                'button' . $i => [
                    'class' => [
                        'btn',
                        'houzez-search-button',
                        'elementor-button',
                        'elementor-size-' . $item['button_size'],
                    ]
                ],
                'price-range' . $i => [
                    'class' => [
                        'elementor-field',
                        'form-control',
                        'elementor-size-' . $item['input_size'],
                    ],
                ],
                'geo-location' . $i => [
                    'name' => $this->houzez_get_attribute_name( $item ),
                    'id' => $this->houzez_get_attribute_id( $item ),
                    'class' => [
                        'elementor-field',
                        'form-control',
                        'search_location_js',
                        'elementor-size-' . $item['input_size'],
                    ],
                ],
                'label' . $i => [
                    'for' => $this->houzez_get_attribute_id( $item ),
                    'class' => 'elementor-field-label',
                ],
            ]
        );
        
        if ( empty( $item['width'] ) ) {
            $item['width'] = '100';
        }

        if ( $item['is_multiple'] ) {
            $this->houzez_add_multiple_attribute( 'select' . $i );
            $this->add_render_attribute( 'select' . $i, 'title', $item['placeholder'] );
            $this->add_render_attribute( 'select' . $i, 'data-selected-text-format', 'count > 1' );

            if($item['select_all_btns']) {
                $this->add_render_attribute( 'select' . $i, 'data-select-all-text', houzez_option('cl_select_all', 'Select All') );
                $this->add_render_attribute( 'select' . $i, 'data-deselect-all-text', houzez_option('cl_deselect_all', 'Deselect All') );
                $this->add_render_attribute( 'select' . $i, 'data-actions-box', 'true' );
            }

            if( $item['selected_count_text'] ) {
                $this->add_render_attribute( 'select' . $i, 'data-count-selected-text', '{0} '.$item['selected_count_text'] );
            }
        }

        if( $item['data_live_search'] ) {
            $this->add_render_attribute( 'select' . $i, 'data-live-search', 'true');
        }

        $this->add_render_attribute( 'select' . $i, 'data-size', 5);

        $this->add_render_attribute( 'field-group' . $i, 'class', 'elementor-col-' . $item['width'] );
        $this->add_render_attribute( 'submit-group' . $i, 'class', 'elementor-col-' . $item['width'] );

        if ( ! empty( $item['width_tablet'] ) ) {
            $this->add_render_attribute( 'field-group' . $i, 'class', 'elementor-md-' . $item['width_tablet'] );
            $this->add_render_attribute( 'submit-group' . $i, 'class', 'elementor-md-' . $item['width_tablet'] );
        }

        if ( ! empty( $item['width_mobile'] ) ) {
            $this->add_render_attribute( 'field-group' . $i, 'class', 'elementor-sm-' . $item['width_mobile'] );
            $this->add_render_attribute( 'submit-group' . $i, 'class', 'elementor-sm-' . $item['width_mobile'] );
        }

        if ( ! empty( $item['hidden_desktop'] ) ) {
            $this->add_render_attribute( 'field-group' . $i, 'class', 'elementor-' . $item['hidden_desktop'] );
            $this->add_render_attribute( 'submit-group' . $i, 'class', 'elementor-' . $item['hidden_desktop'] );
        }

        if ( ! empty( $item['hidden_tablet'] ) ) {
            $this->add_render_attribute( 'field-group' . $i, 'class', 'elementor-' . $item['hidden_tablet'] );
            $this->add_render_attribute( 'submit-group' . $i, 'class', 'elementor-' . $item['hidden_tablet'] );
        }

        if ( ! empty( $item['hidden_phone'] ) ) {
            $this->add_render_attribute( 'field-group' . $i, 'class', 'elementor-' . $item['hidden_phone'] );
            $this->add_render_attribute( 'submit-group' . $i, 'class', 'elementor-' . $item['hidden_phone'] );
        }

        if ( ! empty( $item['placeholder'] ) ) {
            $this->add_render_attribute( 'input' . $i, 'placeholder', $item['placeholder'] );
        }

        if ( ! empty( $item['placeholder'] ) ) {
            $this->add_render_attribute( 'geo-location' . $i, 'placeholder', $item['placeholder'] );
        }

        if ( ! empty( $item['field_value'] ) ) {
            $this->add_render_attribute( 'input' . $i, 'value', $item['field_value'] );
        }

        if ( ! $instance['show_labels'] ) {
            $this->add_render_attribute( 'label' . $i, 'class', 'elementor-screen-only' );
        }
    }

    protected function houzez_taxonomy_field( $item, $i, $tax_name, $selected, $classes = null, $dataField = null ) {
        $this->add_render_attribute(
            [
                'select-wrapper' . $i => [
                    'class' => [
                        'elementor-field',
                        'elementor-select-wrapper',
                    ],
                ],
                'select' . $i => [
                    'name' => $this->houzez_get_attribute_name( $item ),
                    'id' => $this->houzez_get_attribute_id( $item ),
                    'class' => [
                        'selectpicker',
                        'bs-select-hidden',
                        'houzez-field-textual',
                        'form-control',
                        'elementor-size-' . $item['input_size'],
                        $classes
                    ],
                    'data-none-results-text' => houzez_option('cl_no_results_matched', 'No results matched')." {0}"

                ],
            ]
        );

        if( $tax_name == 'property_country' || $tax_name == 'property_state' || $tax_name == 'property_city' ) {
            $this->add_render_attribute(
                [
                    'select' . $i => [
                        'data-target' => $dataField,
                    ],
                ]
            );
        }

        ob_start();
        ?>
        <div <?php echo $this->get_render_attribute_string( 'select-wrapper' . $i ); ?>>
            <select <?php echo $this->get_render_attribute_string( 'select' . $i ); ?>>
                <?php
                if ( !$item['is_multiple'] ) {
                    if( isset($item['placeholder']) && !empty($item['placeholder']) ) {
                        echo '<option value="">'.esc_attr($item['placeholder']).'</option>';
                    }
                }

                $args = '';
                if( $selected == 'status' ) {
                    $args = array(
                        'exclude' => houzez_option('search_exclude_status')
                    );
                }

                $selected = isset($_GET[$selected]) ? $_GET[$selected] : '';
                houzez_get_search_taxonomies($tax_name, $selected, $args);
                ?>
            </select>
        </div>
        <?php

        $select = ob_get_clean();
        return $select;
    }

    protected function houzez_c_select_field( $item, $i, $options) {
        $this->add_render_attribute(
            [
                'select-wrapper' . $i => [
                    'class' => [
                        'elementor-field',
                        'elementor-select-wrapper',
                    ],
                ],
                'select' . $i => [
                    'name' => $this->houzez_get_attribute_name( $item ),
                    'id' => $this->houzez_get_attribute_id( $item ),
                    'class' => [
                        'selectpicker',
                        'bs-select-hidden',
                        'houzez-field-textual',
                        'form-control',
                        'elementor-size-' . $item['input_size'],
                    ],
                    'data-none-results-text' => houzez_option('cl_no_results_matched', 'No results matched')." {0}"
                ],
            ]
        );

        $options = unserialize($options);

        if ( empty($options) ) {
            return '';
        }

        ob_start();
        ?>
        <div <?php echo $this->get_render_attribute_string( 'select-wrapper' . $i ); ?>>
            <select <?php echo $this->get_render_attribute_string( 'select' . $i ); ?>>
                <?php

                if( isset($item['placeholder']) && !empty($item['placeholder']) ) {
                    echo '<option value="">'.esc_attr($item['placeholder']).'</option>';
                }

                foreach ( $options as $key => $option ) {

                    if(!empty($key)) {
                        $option = houzez_wpml_translate_single_string($option);
                        echo '<option value="'.esc_attr($key).'">'.esc_html($option).'</option>';
                    }

                }
                
                ?>
            </select>
        </div>
        <?php

        $select = ob_get_clean();
        return $select;
    }

    protected function houzez_c_radio_select_field( $item, $i, $options) {
        $this->add_render_attribute(
            [
                'select-wrapper' . $i => [
                    'class' => [
                        'elementor-field',
                        'elementor-select-wrapper',
                    ],
                ],
                'select' . $i => [
                    'name' => $this->houzez_get_attribute_name( $item ),
                    'id' => $this->houzez_get_attribute_id( $item ),
                    'data-live-search' => 'true',
                    'class' => [
                        'selectpicker',
                        'bs-select-hidden',
                        'houzez-field-textual',
                        'form-control',
                        'elementor-size-' . $item['input_size'],
                    ],
                ],
            ]
        );

        $options = unserialize($options);
        $options = explode( ',', $options );
        $options = array_filter( array_map( 'trim', $options ) );
        $options = array_combine( $options, $options );

        if ( empty($options) ) {
            return '';
        }

        ob_start();
        ?>
        <div <?php echo $this->get_render_attribute_string( 'select-wrapper' . $i ); ?>>
            <select <?php echo $this->get_render_attribute_string( 'select' . $i ); ?>>
                <?php

                if( isset($item['placeholder']) && !empty($item['placeholder']) ) {
                    echo '<option value="">'.esc_attr($item['placeholder']).'</option>';
                }

                foreach ($options as $option) {

                    if(!empty($option)) {
                        $option = houzez_wpml_translate_single_string($option);
                        echo '<option value="'.esc_attr($option).'">'.esc_html($option).'</option>';
                    }
                }    
                ?>
            </select>
        </div>
        <?php

        $select = ob_get_clean();
        return $select;
    }

    protected function houzez_c_multi_select_field( $item, $i, $options, $is_checkbox = false ) {
        $this->add_render_attribute(
            [
                'select-wrapper' . $i => [
                    'class' => [
                        'elementor-field',
                        'elementor-select-wrapper',
                    ],
                ],
                'select' . $i => [
                    'name' => $this->houzez_get_attribute_name( $item ).'[]',
                    'id' => $this->houzez_get_attribute_id( $item ),
                    'data-live-search' => 'true',
                    'data-actions-box' => 'true',
                    'title' => $item['placeholder'],
                    'data-selected-text-format' => 'count > 1',
                    'data-select-all-text' => houzez_option('cl_select_all', 'Select All'),
                    'data-deselect-all-text' => houzez_option('cl_deselect_all', 'Deselect All'),
                    'data-count-selected-text' => '{0} '.houzez_option('srh_item_selected', 'items selected'),
                    'class' => [
                        'selectpicker',
                        'bs-select-hidden',
                        'houzez-field-textual',
                        'form-control',
                        'elementor-size-' . $item['input_size'],
                    ],
                    'data-none-results-text' => houzez_option('cl_no_results_matched', 'No results matched')." {0}"
                ],
            ]
        );
    
        $this->houzez_add_multiple_attribute( 'select' . $i );

        if( $is_checkbox ) {
            $options = unserialize($options);
            $options = explode( ',', $options );
            $options = array_filter( array_map( 'trim', $options ) );
            $options = array_combine( $options, $options );
        } else {
            $options = unserialize($options);
        }

        if ( empty($options) ) {
            return '';
        }

        ob_start();
        ?>
        <div <?php echo $this->get_render_attribute_string( 'select-wrapper' . $i ); ?>>
            <select <?php echo $this->get_render_attribute_string( 'select' . $i ); ?>>
                <?php
                foreach ($options as $key => $option) {

                    if(!empty($key)) {
                        $option = houzez_wpml_translate_single_string($option);
                        echo '<option value="'.esc_attr($key).'">'.esc_html($option).'</option>';
                    }
                }    
                ?>
            </select>
        </div>
        <?php

        $select = ob_get_clean();
        return $select;
    }

    protected function houzez_beds_baths_field( $item, $i, $beds_baths) {
        $this->add_render_attribute(
            [
                'select-wrapper' . $i => [
                    'class' => [
                        'elementor-field',
                        'elementor-select-wrapper',
                    ],
                ],
                'select' . $i => [
                    'name' => $this->houzez_get_attribute_name( $item ),
                    'id' => $this->houzez_get_attribute_id( $item ),
                    'class' => [
                        'selectpicker',
                        'bs-select-hidden',
                        'houzez-field-textual',
                        'form-control',
                        'elementor-size-' . $item['input_size'],
                    ],
                ],
            ]
        );

        ob_start();
        ?>
        <div <?php echo $this->get_render_attribute_string( 'select-wrapper' . $i ); ?>>
            <select <?php echo $this->get_render_attribute_string( 'select' . $i ); ?>>
                <?php

                if( isset($item['placeholder']) && !empty($item['placeholder']) ) {
                    echo '<option value="">'.esc_attr($item['placeholder']).'</option>';
                }

                houzez_number_list($beds_baths);
                
                ?>
            </select>
        </div>
        <?php

        $select = ob_get_clean();
        return $select;
    }

    protected function houzez_radius( $item, $i) {
        $this->add_render_attribute(
            [
                'select-wrapper' . $i => [
                    'class' => [
                        'elementor-field',
                        'elementor-select-wrapper',
                    ],
                ],
                'select' . $i => [
                    'name' => $this->houzez_get_attribute_name( $item ),
                    'id' => $this->houzez_get_attribute_id( $item ),
                    'class' => [
                        'selectpicker',
                        'bs-select-hidden',
                        'houzez-field-textual',
                        'form-control',
                        'elementor-size-' . $item['input_size'],
                    ],
                ],
            ]
        );

        ob_start();
        ?>
        <div <?php echo $this->get_render_attribute_string( 'select-wrapper' . $i ); ?>>
            <select <?php echo $this->get_render_attribute_string( 'select' . $i ); ?>>
                <?php

                if( isset($item['placeholder']) && !empty($item['placeholder']) ) {
                    echo '<option value="">'.esc_attr($item['placeholder']).'</option>';
                }

                $radius_unit = houzez_option('radius_unit');
                $selected_radius = isset($item['radius_default']) ? $item['radius_default'] : '';
                if( isset( $_GET['radius'] ) ) {
                    $selected_radius = $_GET['radius'];
                }

                $radius_from = 1;
                if( isset($item['radius_from']) && !empty($item['radius_from']) ) {
                    $radius_from = $item['radius_from'];
                }

                $radius_to = 100;
                if( isset($item['radius_to']) && !empty($item['radius_to']) ) {
                    $radius_to = $item['radius_to'];
                }


                $i = 0;
                for( $i = $radius_from; $i <= $radius_to; $i++ ) {
                    echo '<option '.selected( $selected_radius, $i, false).' value="'.esc_attr($i).'">'.esc_attr($i).' '.esc_attr($radius_unit).'</option>';
                }
                ?>
            </select>
        </div>
        <?php

        $select = ob_get_clean();
        return $select;
    }

    protected function houzez_min_price( $item, $i ) {

        $this->add_render_attribute(
            [
                'select' . $i => [
                    'name' => $this->houzez_get_attribute_name( $item ),
                    'id' => $this->houzez_get_attribute_id( $item ),
                    'class' => [
                        'selectpicker',
                        'bs-select-hidden',
                        'houzez-field-textual',
                        'form-control',
                        'elementor-size-' . $item['input_size'],
                    ],

                ],
            ]
        );

        ob_start();

        if( $item['price_field_type'] == 'input' ) { 

            $this->add_render_attribute( 'input' . $i, 'class', 'elementor-field-textual' );
            ?>

            <input name="min-price" type="text" <?php echo $this->get_render_attribute_string( 'input' . $i ); ?>>

        <?php
        } else {
        ?>
            <div class="prices-for-all elementor-field elementor-select-wrapper">
                <select <?php echo $this->get_render_attribute_string( 'select' . $i ); ?>>
                    <?php 
                    if( isset($item['placeholder']) && !empty($item['placeholder']) ) {
                        echo '<option value="">'.esc_attr($item['placeholder']).'</option>';
                    } 
                    houzez_adv_searches_min_price(); ?>

                </select><!-- selectpicker -->
            </div><!-- form-group -->

            <div class="hide prices-only-for-rent elementor-field elementor-select-wrapper">
                <select <?php echo $this->get_render_attribute_string( 'select' . $i ); ?>>
                    <?php 
                    if( isset($item['placeholder']) && !empty($item['placeholder']) ) {
                        echo '<option value="">'.esc_attr($item['placeholder']).'</option>';
                    } houzez_adv_searches_min_price_rent_only(); ?>

                </select><!-- selectpicker -->
            </div><!-- form-group -->

        <?php
        }
        $field = ob_get_clean();
        return $field;

    }

    protected function houzez_max_price( $item, $i ) {

        $this->add_render_attribute(
            [
                'select' . $i => [
                    'name' => $this->houzez_get_attribute_name( $item ),
                    'id' => $this->houzez_get_attribute_id( $item ),
                    "data-live-search" => "true",
                    'class' => [
                        'selectpicker',
                        'bs-select-hidden',
                        'houzez-field-textual',
                        'form-control',
                        'elementor-size-' . $item['input_size'],
                    ],

                ],
            ]
        );

        ob_start();
        
        if( $item['price_field_type'] == 'input' ) { 

            $this->add_render_attribute( 'input' . $i, 'class', 'elementor-field-textual' );
            ?>

            <input name="max-price" type="text" <?php echo $this->get_render_attribute_string( 'input' . $i ); ?>>

        <?php
        } else {
        ?>
        <div class="prices-for-all elementor-field elementor-select-wrapper">
            <select <?php echo $this->get_render_attribute_string( 'select' . $i ); ?>>
                <?php 
                if( isset($item['placeholder']) && !empty($item['placeholder']) ) {
                    echo '<option value="">'.esc_attr($item['placeholder']).'</option>';
                } 
                houzez_adv_searches_max_price(); ?>

            </select><!-- selectpicker -->
        </div><!-- form-group -->

        <div class="hide prices-only-for-rent elementor-field elementor-select-wrapper">
            <select <?php echo $this->get_render_attribute_string( 'select' . $i ); ?>>
                <?php 
                if( isset($item['placeholder']) && !empty($item['placeholder']) ) {
                    echo '<option value="">'.esc_attr($item['placeholder']).'</option>';
                } houzez_adv_searches_max_price_rent_only(); ?>

            </select><!-- selectpicker -->
        </div><!-- form-group -->
        <?php
        }

        $field = ob_get_clean();
        return $field;
    }

    protected function houzez_price_range( $item, $i ) {
        ob_start();
        ?>
        <div class="range-text">
            <input type="hidden" name="min-price" class="min-price-range-hidden range-input" readonly >
            <input type="hidden" name="max-price" class="max-price-range-hidden range-input" readonly >
            <span class="range-title"><?php echo esc_attr($item['field_label']); ?></span> <?php echo esc_attr($item['price_from_text']); ?> <span class="min-price-range"></span> <?php echo esc_attr($item['price_to_text']); ?> <span class="max-price-range"></span>
        </div><!-- range-text -->
        <div class="price-range-wrap">
            <div class="price-range"></div>
        </div>
    
        <?php
        $return = ob_get_clean();
        return $return;
    }

    protected function houzez_geolocation( $item, $i, $settings ) {
        $checked = true;

        $trigger_class = '';
        if( $settings['show_labels'] ) {
            $trigger_class = "with-labels";
        }
        $this->add_render_attribute( 'geo-location' . $i, 'class', 'elementor-field-textual' );
        $search_location = isset ( $_GET['search_location'] ) ? esc_attr($_GET['search_location']) : ''; ?>

        <input type="text" <?php echo $this->get_render_attribute_string( 'geo-location' . $i ); ?> value="<?php echo esc_attr($search_location); ?>">
        <a class="btn location-trigger <?php echo esc_attr($trigger_class); ?> elementor-size-<?php echo $item['input_size']; ?>" href="#">
            <i class="houzez-icon icon-location-target"></i>
        </a>
        <input type="hidden" name="lat" value="<?php echo isset ( $_GET['lat'] ) ? esc_attr($_GET['lat']) : ''; ?>" >
        <input type="hidden" name="lng" value="<?php echo isset ( $_GET['lng'] ) ? esc_attr($_GET['lng']) : ''; ?>">
        <input type="checkbox" name="use_radius" class="hide_search_checkbox" <?php checked( true, $checked ); ?>>
        
        <?php houzez_enqueue_maps_api();
    }

    protected function houzez_keyword( $item, $i ) {
        $this->add_render_attribute( 'input' . $i, 'class', 'elementor-field-textual' );
        $this->add_render_attribute( 'input' . $i, 'class', 'houzez-keyword-autocomplete' );
        echo '<input type="text" size="1" ' . $this->get_render_attribute_string( 'input' . $i ) . '>';
        echo '<div id="auto_complete_ajax" class="auto-complete"></div>';
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Search_Builder );