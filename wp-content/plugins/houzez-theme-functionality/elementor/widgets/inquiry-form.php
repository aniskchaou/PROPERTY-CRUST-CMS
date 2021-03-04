<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Properties Widget.
 * @since 2.0
 */
class Houzez_Elementor_Inquiry_Form extends Widget_Base {

    public function __construct( array $data = [], array $args = null ) {
        parent::__construct( $data, $args );

        $js_path = 'assets/frontend/js/';
        wp_register_script( 'validate', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js', array('jquery'), '1.19.2', false );

        wp_register_script( 'houzez-validate-js', HOUZEZ_PLUGIN_URL . $js_path . 'houzez-validate.js', array( 'jquery' ), '1.0.0' );

    }

    public function get_script_depends() {
        return [ 'validate', 'houzez-validate-js', 'jquery-form' ];
    }

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
        return 'houzez_elementor_inquiry_form';
    }

    /**
     * Get widget title.
     * @since 2.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Inquiry Form', 'houzez-theme-functionality' );
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
        return 'eicon-form-horizontal';
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

        $field_types = [
            'enquiry_type' => esc_html__( 'Inquiry Type', 'houzez-theme-functionality' ), //select
            'e_meta[property_type]' => esc_html__( 'Property Type', 'houzez-theme-functionality' ), //select
            'e_meta[price]' => esc_html__( 'Minimum Price', 'houzez-theme-functionality' ), //number
            'e_meta[max-price]' => esc_html__( 'Maximum Price', 'houzez-theme-functionality' ), //number
            'e_meta[beds]' => esc_html__( 'Minimum Bedrooms', 'houzez-theme-functionality' ), //number
            'e_meta[max-beds]' => esc_html__( 'Maximum Bedrooms', 'houzez-theme-functionality' ), //number
            'e_meta[baths]' => esc_html__( 'Minimum Bathrooms', 'houzez-theme-functionality' ), //number
            'e_meta[max-baths]' => esc_html__( 'Maximum Bathrooms', 'houzez-theme-functionality' ), //number
            'e_meta[area-size]' => esc_html__( 'Minimum Area Size', 'houzez-theme-functionality' ), //number
            'e_meta[max-area-size]' => esc_html__( 'Maximum Area Size', 'houzez-theme-functionality' ), //number
            'e_meta[country]' => esc_html__( 'Country', 'houzez-theme-functionality' ), // select
            'e_meta[city]' => esc_html__( 'City', 'houzez-theme-functionality' ), // select
            'e_meta[area]' => esc_html__( 'Area', 'houzez-theme-functionality' ), // select
            'e_meta[state]' => esc_html__( 'State', 'houzez-theme-functionality' ), // select
            'e_meta[zipcode]' => esc_html__( 'Zip/Postal Code', 'houzez-theme-functionality' ), //input
            'name' => esc_html__( 'Full Name', 'houzez-theme-functionality' ), //input
            'first_name' => esc_html__( 'First Name', 'houzez-theme-functionality' ), //input
            'last_name' => esc_html__( 'Last Name', 'houzez-theme-functionality' ), //input
            'email' => esc_html__( 'Email', 'houzez-theme-functionality' ), //input
            'mobile' => esc_html__( 'Mobile', 'houzez-theme-functionality' ), //input
            'user_type' => esc_html__( 'User Type', 'houzez-theme-functionality' ), // Select Field
            'message' => esc_html__( 'Message', 'houzez-theme-functionality' ), //textarea
            
        ];

        /**
         * Forms field types.
         */
        $field_types = apply_filters( 'houzez/inquiry_form/fields', $field_types );


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
                            'value' => [],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'required',
            [
                'label' => esc_html__( 'Required', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => '',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'field_type',
                            'operator' => '!in',
                            'value' => [
                            ],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'validation_message',
            [
                'label' => esc_html__( 'Validation Message', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'required' => 'true'
                ],
            ]
        );

        $repeater->add_control(
            'field_options',
            [
                'label' => esc_html__( 'Options', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'description' => esc_html__( 'Enter each option in a separate line. To differentiate between label and value, separate them with a pipe char ("|"). For example: First Name|f_name', 'houzez-theme-functionality' ),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'field_type',
                            'operator' => 'in',
                            'value' => [
                                'select',
                                'user_type',
                            ],
                        ],
                    ],
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
                    '80' => '80%',
                    '75' => '75%',
                    '66' => '66%',
                    '60' => '60%',
                    '50' => '50%',
                    '40' => '40%',
                    '33' => '33%',
                    '25' => '25%',
                    '20' => '20%',
                ],
                'default' => '100',
            ]
        );

        $repeater->add_control(
            'rows',
            [
                'label' => esc_html__( 'Rows', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'field_type',
                            'operator' => 'in',
                            'value' => [
                                'message'
                            ],
                        ],
                    ],
                ],
            ]
        );

        

        $this->start_controls_section(
            'section_form_fields',
            [
                'label' => esc_html__( 'Form Fields', 'houzez-theme-functionality' ),
            ]
        );

        $this->add_control(
            'form_name',
            [
                'label' => esc_html__( 'Form Name', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'New Form', 'houzez-theme-functionality' ),
                'placeholder' => esc_html__( 'Form Name', 'houzez-theme-functionality' ),
            ]
        );

        $this->add_control(
            'form_fields',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
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
            'show_labels',
            [
                'label' => esc_html__( 'Labels', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'Hide', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mark_required',
            [
                'label' => esc_html__( 'Required Mark', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'Hide', 'houzez-theme-functionality' ),
                'default' => '',
                'condition' => [
                    'show_labels!' => '',
                ],
            ]
        );

        $this->add_control(
            'con_google_recaptcha',
            [
                'label' => esc_html__( 'Google reCaptcha', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'Hide', 'houzez-theme-functionality' ),
                'default' => 'false',
                'description' => esc_html__( 'Please make sure you have enabled google reCaptcha in Theme Options -> Google reCaptcha and have add reCaptcha API keys', 'houzez-theme-functionality' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'gdpr_agreement',
            [
                'label' => esc_html__( 'GDPR Agreement', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'Hide', 'houzez-theme-functionality' ),
                'default' => 'false',
            ]
        );

        $this->add_control(
            'gdpr_label',
            [
                'label' => esc_html__( 'Label', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'gdpr_agreement' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'gdpr_required',
            [
                'label' => esc_html__( 'Required', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => '',
                'condition' => [
                    'gdpr_agreement' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'gdpr_validate',
            [
                'label' => esc_html__( 'Validation Message', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'gdpr_required' => 'true'
                ],
            ]
        );

        $this->add_control(
            'gdpr_text',
            [
                'label' => esc_html__( 'GDPR Agreement Text', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'description' => '',
                'condition' => [
                    'gdpr_agreement' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_submit_button',
            [
                'label' => esc_html__( 'Submit Button', 'houzez-theme-functionality' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Text', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Submit', 'houzez-theme-functionality' ),
                'placeholder' => esc_html__( 'Submit', 'houzez-theme-functionality' ),
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => esc_html__( 'Size', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'sm',
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
            'button_width',
            [
                'label' => esc_html__( 'Column Width', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Default', 'houzez-theme-functionality' ),
                    '100' => '100%',
                    '80' => '80%',
                    '75' => '75%',
                    '66' => '66%',
                    '60' => '60%',
                    '50' => '50%',
                    '40' => '40%',
                    '33' => '33%',
                    '25' => '25%',
                    '20' => '20%',
                ],
                'default' => '100',
            ]
        );

        $this->add_responsive_control(
            'button_align',
            [
                'label' => esc_html__( 'Alignment', 'houzez-theme-functionality' ),
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
            'button_css_id',
            [
                'label' => esc_html__( 'Button ID', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'houzez-theme-functionality' ),
                'label_block' => false,
                'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'houzez-theme-functionality' ),
                'separator' => 'before',

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_email_settings',
            [
                'label' => esc_html__( 'Email', 'houzez-theme-functionality' ),
            ]
        );

        $this->add_control(
            'email_to',
            [
                'label' => esc_html__( 'To', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => get_option( 'admin_email' ),
                'placeholder' => get_option( 'admin_email' ),
                'label_block' => true,
                'title' => esc_html__( 'Separate emails with commas', 'houzez-theme-functionality' ),
                'render_type' => 'none',
            ]
        );

        $default_message = sprintf( esc_html__( 'New message from "%s"', 'houzez-theme-functionality' ), get_option( 'blogname' ) );

        $this->add_control(
            'email_subject',
            [
                'label' => esc_html__( 'Subject', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => $default_message,
                'placeholder' => $default_message,
                'label_block' => true,
                'render_type' => 'none',
            ]
        );

        $this->add_control(
            'email_to_cc',
            [
                'label' => esc_html__( 'Cc', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__( 'Separate emails with commas', 'houzez-theme-functionality' ),
                'render_type' => 'none',
            ]
        );

        $this->add_control(
            'email_to_bcc',
            [
                'label' => esc_html__( 'Bcc', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'title' => esc_html__( 'Separate emails with commas', 'houzez-theme-functionality' ),
                'render_type' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_redirect_settings',
            [
                'label' => esc_html__( 'Redirect', 'houzez-theme-functionality' ),
            ]
        );

        $this->add_control(
            'redirect_to',
            [
                'label' => __( 'Redirect To', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'https://your-link.com', 'houzez-theme-functionality' ),
                'dynamic' => [
                    'active' => false,
                ],
                'label_block' => true,
                'render_type' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_webhook',
            [
                'label' => esc_html__( 'Webhook', 'houzez-theme-functionality' ),
            ]
        );

        $this->add_control(
            'webhook',
            [
                'label' => esc_html__( 'Webhook', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'false',
            ]
        );

        $this->add_control(
            'webhook_url',
            [
                'label' => __( 'Webhook URL', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'https://your-webhook-url.com', 'houzez-theme-functionality' ),
                'dynamic' => [
                    'active' => false,
                ],
                'label_block' => true,
                'render_type' => 'none',
                'description' => esc_html__("Enter the integration URL (like Zapier) that will receive the form's submitted data.", 'houzez-theme-functionality'),
                'condition' => [
                    'webhook' => 'true',
                ],
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

        $this->add_control(
            'mark_required_color',
            [
                'label' => esc_html__( 'Mark Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-mark-required .elementor-field-label:after' => 'color: {{COLOR}};',
                ],
                'condition' => [
                    'mark_required' => 'yes',
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

        $this->end_controls_section();

        $this->start_controls_section(
            'section_field_style',
            [
                'label' => esc_html__( 'Field', 'houzez-theme-functionality' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'field_text_color',
            [
                'label' => esc_html__( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-field-group .elementor-field' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .elementor-field-group .elementor-field, {{WRAPPER}} .elementor-field-subgroup label',
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
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper::before' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'field_border_width',
            [
                'label' => esc_html__( 'Border Width', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::DIMENSIONS,
                'placeholder' => '1',
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper)' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_gdpr_style',
            [
                'label' => esc_html__( 'GDPR', 'houzez-theme-functionality' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'field_gdpr_color',
            [
                'label' => esc_html__( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gdpr-text' => 'color: {{VALUE}};',
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
                'name' => 'gdpr_typography',
                'selector' => '{{WRAPPER}} .gdpr-text',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'fields_options' => [
                    // Inner control name
                    'font_weight' => [
                        // Inner control settings
                        'default' => '300',
                    ],
                ],
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

        $this->add_control(
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

        $allowed_html = array(
            'a' => array(
                'href' => array(),
                'title' => array(),
                'target' => array()
            ),
            'strong' => array(),
            'th' => array(),
            'td' => array(),
            'span' => array(),
        );

        if( !class_exists('Houzez_CRM')) {
            echo esc_html__('Please install and activate Houzez CRM plugin.', 'houzez');
            return '';
        }

        $email_to = !empty($settings['email_to']) ? $settings['email_to'] : get_option( 'admin_email' );
        $email_subject = !empty($settings['email_subject']) ? $settings['email_subject'] : '';
        $email_to_cc = !empty($settings['email_to_cc']) ? $settings['email_to_cc'] : '';
        $email_to_bcc = !empty($settings['email_to_bcc']) ? $settings['email_to_bcc'] : '';

        $this->add_render_attribute(
            [
                'wrapper' => [
                    'class' => [
                        'elementor-form-fields-wrapper',
                        'elementor-labels-above',
                    ],
                ],
                'submit-group' => [
                    'class' => [
                        'elementor-field-group',
                        'elementor-column',
                        'elementor-field-type-submit',
                    ],
                ],
                'button' => [
                    'class' => [
                        'btn',
                        'houzez-submit-button',
                        'houzez-contact-form-js',
                        'elementor-button',
                    ]
                ],
            ]
        );
        
        if ( empty( $settings['button_width'] ) ) {
            $settings['button_width'] = '100';
        }


        $this->add_render_attribute( 'submit-group', 'class', 'elementor-col-' . $settings['button_width'] );

        if ( ! empty( $settings['button_width_tablet'] ) ) {
            $this->add_render_attribute( 'submit-group', 'class', 'elementor-md-' . $settings['button_width_tablet'] );
        }

        if ( ! empty( $settings['button_width_mobile'] ) ) {
            $this->add_render_attribute( 'submit-group', 'class', 'elementor-sm-' . $settings['button_width_mobile'] );
        }

        if ( ! empty( $settings['button_size'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['button_size'] );
        }

        if ( ! empty( $settings['button_type'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-button-' . $settings['button_type'] );
        }

        if ( $settings['button_hover_animation'] ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
        }

        if ( ! empty( $settings['form_id'] ) ) {
            $this->add_render_attribute( 'form', 'id', $settings['form_id'] );
        }

        if ( ! empty( $settings['form_name'] ) ) {
            $this->add_render_attribute( 'form', 'name', $settings['form_name'] );
        }

        if ( ! empty( $settings['button_css_id'] ) ) {
            $this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
        }
        ?>

        <script type="application/javascript">
            jQuery(document).bind("ready", function () {
                houzezValidateElementor("#houzez-form-<?php echo esc_attr($this->get_id()); ?>" );
            });
        </script>


        <form class="elementor-form" id="houzez-form-<?php echo $this->get_id(); ?>" method="post" <?php echo $this->get_render_attribute_string( 'form' ); ?> action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
            <input type="hidden" name="form_id" value="<?php echo $this->get_id(); ?>"/>
            <input type="hidden" name="action" value="houzez_ele_inquiry_form" />
            <input type="hidden" name="source_link" value="<?php echo esc_url(get_permalink($post->ID));?>" />
            <input type="hidden" name="lead_page_id" value="<?php echo intval($post->ID);?>" />
            <input type="hidden" name="is_estimation" value="yes" />
            <input type="hidden" name="email_to" value="<?php echo esc_attr($email_to); ?>" />
            <input type="hidden" name="email_subject" value="<?php echo esc_attr($email_subject); ?>" />
            <input type="hidden" name="email_to_cc" value="<?php echo esc_attr($email_to_cc); ?>" />
            <input type="hidden" name="email_to_bcc" value="<?php echo esc_attr($email_to_bcc); ?>" />
            <input type="hidden" name="webhook" value="<?php echo esc_attr($settings['webhook']); ?>" />
            <input type="hidden" name="webhook_url" value="<?php echo esc_url($settings['webhook_url']); ?>" />
            <input type="hidden" name="redirect_to" value="<?php echo esc_url($settings['redirect_to']); ?>" />

            <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>

                <?php
                foreach ( $settings['form_fields'] as $item_index => $item ) :
                    $item['input_size'] = $settings['input_size'];
                    $field_name = $item['field_type'];

                    $this->houzez_form_fields_render_attributes( $item_index, $settings, $item );

                    ?>
                    <div <?php echo $this->get_render_attribute_string( 'field-group' . $item_index ); ?>>
                    <?php

                    if ( $item['field_label'] && 'html' !== $item['field_type'] ) {
                        echo '<label ' . $this->get_render_attribute_string( 'label' . $item_index ) . '>' . $item['field_label'] . '</label>';
                    }


                    switch ( $item['field_type'] ) :
                    
                        case 'message':
                            echo $this->houzez_textarea_field( $item, $item_index );
                            break;

                        case 'e_meta[property_type]':
                        case 'e_meta[country]':
                        case 'e_meta[state]':
                        case 'e_meta[city]':
                        case 'e_meta[area]':
                        case 'user_type':
                        case 'enquiry_type':
                            echo $this->houzez_select_field( $item, $item_index );
                            break;

                        case 'email':
                            $this->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual' );
                            echo '<input type="email" ' . $this->get_render_attribute_string( 'input' . $item_index ) . '>';
                            break;

                        case 'e_meta[price]':
                        case 'e_meta[min-price]':
                        case 'e_meta[max-price]':
                        case 'e_meta[beds]':
                        case 'e_meta[min-beds]':
                        case 'e_meta[max-beds]':
                        case 'e_meta[baths]':
                        case 'e_meta[min-baths]':
                        case 'e_meta[max-baths]':
                        case 'e_meta[area-size]':
                        case 'e_meta[max-area-size]':
                        case 'e_meta[min-area]':
                        case 'e_meta[max-area]':
                            $this->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual' );
                            echo '<input type="number" ' . $this->get_render_attribute_string( 'input' . $item_index ) . '>';
                            break;

                        case 'e_meta[zipcode]':
                        case 'name':
                        case 'first_name':
                        case 'last_name':
                        case 'mobile':
                        case 'home_phone':
                        case 'work_phone':
                        case 'address':
                        case 'zip':
                            $this->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual' );
                            echo '<input type="text" ' . $this->get_render_attribute_string( 'input' . $item_index ) . '>';
                            break;
                           
                        default:
                             
                    endswitch;
                    ?>
                    </div>

                    <?php endforeach; ?>

                    <?php 
                    if( isset($settings['gdpr_agreement']) && $settings['gdpr_agreement'] == 'yes') { 
                        $gdpr_validate = isset($settings['gdpr_validate']) && ! empty($settings['gdpr_validate']) ? $settings['gdpr_validate'] : '* '.esc_attr($settings['gdpr_label']);
                        ?>
                    <div class="houzez-gdpr-agreement elementor-field-group elementor-col-100">
                        <label for="gdpr_agreement" class="elementor-field-label"><?php echo esc_attr($settings['gdpr_label']); ?></label>
                        <div class="gdpr-agreement-subgroup">
                            <span class="gdpr-field-option">
                                <label class="gdpr-text" for="gdpr_agreement">
                                    <input <?php if($settings['gdpr_required']){ echo 'required'; } ?> type="checkbox" title="<?php echo esc_attr($gdpr_validate); ?>" name="gdpr_agreement" id="gdpr_agreement">  <?php echo wp_kses($settings['gdpr_text'], $allowed_html); ?>
                                </label>
                            </span>
                        </div>             
                    </div>
                    <?php } ?>

                    <?php if( $settings['con_google_recaptcha'] == 'yes') { ?>
                    <div class="<?php if( houzez_option( 'recaptha_type', 'v2' ) == 'v2') { ?>elementor-field-group <?php } ?>">
                        <?php get_template_part('template-parts/google', 'reCaptcha'); ?>
                    </div>
                    <?php } ?>

                    <div <?php echo $this->get_render_attribute_string( 'submit-group' ); ?>>
                    <button type="submit" <?php echo $this->get_render_attribute_string( 'button' ); ?>>
                        <i class="btn-loader houzez-loader-js"></i>
                        <?php if ( ! empty( $settings['button_text'] ) ) : ?>
                            <?php echo $settings['button_text']; ?>
                        <?php endif; ?>
                    </button>
                </div>
            </div><!-- End wrapper-->
            <br/>
            <div class="ele-form-messages"></div>
            <div class="error-container"></div>

        </form>

    <?php
    }


    public function houzez_get_attribute_name( $item ) {
        return "{$item['field_type']}";
    }

    public function houzez_get_attribute_id( $item ) {
        return 'form-field-' . $item['_id'];
    }

    private function houzez_add_required_attribute( $element ) {
        $this->add_render_attribute( $element, 'required', 'required' );
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
                'label' . $i => [
                    'for' => $this->houzez_get_attribute_id( $item ),
                    'class' => 'elementor-field-label',
                ],
            ]
        );

        if ( empty( $item['width'] ) ) {
            $item['width'] = '100';
        }

        $this->add_render_attribute( 'field-group' . $i, 'class', 'elementor-col-' . $item['width'] );

        if ( ! empty( $item['width_tablet'] ) ) {
            $this->add_render_attribute( 'field-group' . $i, 'class', 'elementor-md-' . $item['width_tablet'] );
        }

        if ( ! empty( $item['width_mobile'] ) ) {
            $this->add_render_attribute( 'field-group' . $i, 'class', 'elementor-sm-' . $item['width_mobile'] );
        }

        if ( ! empty( $item['placeholder'] ) ) {
            $this->add_render_attribute( 'input' . $i, 'placeholder', $item['placeholder'] );
        }

        if ( ! empty( $item['field_value'] ) ) {
            $this->add_render_attribute( 'input' . $i, 'value', $item['field_value'] );
        }

        if ( ! $instance['show_labels'] ) {
            $this->add_render_attribute( 'label' . $i, 'class', 'elementor-screen-only' );
        }

        if ( isset($item['validation_message']) && ! empty( $item['validation_message'] ) ) {
            $this->add_render_attribute( 'input' . $i, 'title', $item['validation_message'] );
        } else {

            $input_title = $item['field_label'];
            if( empty($input_title) || $input_title == "&nbsp;" ) {
                $input_title = $item['placeholder'];
            }

            $this->add_render_attribute( 'input' . $i, 'title', '* '.$input_title );
        }

        if ( ! empty( $item['required'] ) ) {
            $class = 'elementor-field-required';
            if ( ! empty( $instance['mark_required'] ) ) {
                $class .= ' elementor-mark-required';
            }
            $this->add_render_attribute( 'field-group' . $i, 'class', $class );
            $this->houzez_add_required_attribute( 'input' . $i );
        }
    }

    protected function houzez_textarea_field( $item, $item_index ) {
        $this->add_render_attribute( 'textarea' . $item_index, [
            'class' => [
                'elementor-field-textual',
                'elementor-field',
                'elementor-size-' . $item['input_size'],
            ],
            'name' => $this->houzez_get_attribute_name( $item ),
            'id' => $this->houzez_get_attribute_id( $item ),
            'rows' => $item['rows'],
        ] );

        if ( $item['placeholder'] ) {
            $this->add_render_attribute( 'textarea' . $item_index, 'placeholder', $item['placeholder'] );
        }

        if ( $item['required'] ) {
            $this->houzez_add_required_attribute( 'textarea' . $item_index );

            if( isset($item['validation_message']) && ! empty($item['validation_message']) ) {
                $this->add_render_attribute( 'textarea' . $item_index, 'title', $item['validation_message'] );
            } else {

                $textarea_title = $item['field_label'];
                if( empty($textarea_title) || $textarea_title == "&nbsp;" ) {
                    $textarea_title = $item['placeholder'];
                }
                $this->add_render_attribute( 'textarea' . $item_index, 'title', '* '.$textarea_title );
            }
        }

        $value = empty( $item['field_value'] ) ? '' : $item['field_value'];

        return '<textarea ' . $this->get_render_attribute_string( 'textarea' . $item_index ) . '>' . $value . '</textarea>';
    }

    protected function houzez_select_field( $item, $i ) {
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
                        'elementor-field-textual',
                        'form-control',
                        'elementor-size-' . $item['input_size'],
                    ],
                ],
            ]
        );

        if ( $item['required'] ) {
            $this->houzez_add_required_attribute( 'select' . $i );

            if( isset($item['validation_message']) && ! empty($item['validation_message']) ) {
                $this->add_render_attribute( 'select' . $i, 'title', $item['validation_message'] );
            } else {

                $select_title = $item['field_label'];
                if( empty($select_title) || $select_title == "&nbsp;" ) {
                    $select_title = $item['placeholder'];
                }
                $this->add_render_attribute( 'select' . $i, 'title', '* '.$select_title );
            }
        }

        $options = preg_split( "/\\r\\n|\\r|\\n/", $item['field_options'] );

        if ( ! $options ) {
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

                if( $item['field_type'] == 'e_meta[property_type]' ) {
                    $prop_type = get_terms (
                        array(
                            "property_type"
                        ),
                        array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => false,
                            'parent' => 0
                        )
                    );
                    hcrm_get_taxonomy('property_type', $prop_type);

                } else if( $item['field_type'] == 'e_meta[country]' ) {
                    $term = get_terms (
                        array(
                            "property_country"
                        ),
                        array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => false,
                            'parent' => 0
                        )
                    );
                    hcrm_get_taxonomy('property_country', $term);

                } else if( $item['field_type'] == 'e_meta[city]' ) {
                    $term = get_terms (
                        array(
                            "property_city"
                        ),
                        array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => false,
                            'parent' => 0
                        )
                    );
                    hcrm_get_taxonomy('property_city', $term);

                } else if( $item['field_type'] == 'e_meta[state]' ) {
                    $term = get_terms (
                        array(
                            "property_state"
                        ),
                        array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => false,
                            'parent' => 0
                        )
                    );
                    hcrm_get_taxonomy('property_state', $term);

                } else if( $item['field_type'] == 'e_meta[area]' ) {
                    $term = get_terms (
                        array(
                            "property_area"
                        ),
                        array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => false,
                            'parent' => 0
                        )
                    );
                    hcrm_get_taxonomy('property_area', $term);

                } else if( $item['field_type'] == 'enquiry_type' ) {
                    $enquiry_type = hcrm_get_option('enquiry_type', 'hcrm_enquiry_settings', esc_html__('Purchase, Rent, Sell, Miss, Evaluation, Mortgage', 'houzez'));
                        if(!empty($enquiry_type)) {

                            $enquiry_type = explode(',', $enquiry_type);
                            foreach( $enquiry_type as $en_type ) {
                                echo '<option value="'.trim($en_type).'">'.esc_attr($en_type).'</value>';
                            }
                        }

                } else {

                    foreach ( $options as $key => $option ) {
                        $option_id = $item['_id'] . $key;
                        $option_value = esc_attr( $option );
                        $option_label = esc_html( $option );

                        if ( false !== strpos( $option, '|' ) ) {
                            list( $label, $value ) = explode( '|', $option );
                            $option_value = esc_attr( $value );
                            $option_label = esc_html( $label );
                        }

                        $this->add_render_attribute( $option_id, 'value', $option_value );

                        if ( ! empty( $item['field_value'] ) && $option_value === $item['field_value'] ) {
                            $this->add_render_attribute( $option_id, 'selected', 'selected' );
                        }
                        echo '<option ' . $this->get_render_attribute_string( $option_id ) . '>' . $option_label . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <?php

        $select = ob_get_clean();
        return $select;
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Inquiry_Form );