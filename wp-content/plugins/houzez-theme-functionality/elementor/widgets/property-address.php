<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Address extends Widget_Base {

	public function get_name() {
		return 'houzez-property-address';
	}

	public function get_title() {
		return __( 'Property Address', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return [ 'houzez', 'address', 'property' ];
	}

	protected function _register_controls() {

		$repeater = new Repeater();
		$field_types = array();

        $field_types = [
            'address' => esc_html__( 'Address', 'houzez-theme-functionality' ),
            'streat-address' => esc_html__( 'Streat Address', 'houzez-theme-functionality' ),
            'country' => esc_html__( 'Country', 'houzez-theme-functionality' ),
            'state' => esc_html__( 'State', 'houzez-theme-functionality' ),
            'city' => esc_html__( 'City', 'houzez-theme-functionality' ),
            'area' => esc_html__( 'area', 'houzez-theme-functionality' ),
            
        ];
        /**
         * field types.
         */
        $field_types = apply_filters( 'houzez/address_data', $field_types );

        $repeater->add_control(
            'field_type',
            [
                'label' => esc_html__( 'Field', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'options' => $field_types,
                'default' => 'text',
            ]
        );

		$this->start_controls_section(
			'address_content',
			[
				'label' => __( 'Content', 'houzez-theme-functionality' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'address_fields',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        '_id' => 'address',
                        'field_type' => 'address',
                    ],
                ],
                'title_field' => '{{{ field_type }}}',
            ]
        );

		$this->add_control(
            'hide_icon',
            [
                'label' => esc_html__( 'Hide Icon', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-address .icon-pin' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'address_margin',
			[
				'label' => __( 'Margin', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .item-address' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'address_align',
			[
				'label' => __( 'Alignment', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'houzez-theme-functionality' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'houzez-theme-functionality' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'houzez-theme-functionality' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .item-address' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'address_style',
			[
				'label' => __( 'Style', 'houzez-theme-functionality' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'address_color',
			[
				'label' => __( 'Color', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .item-address' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'address_typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .item-address',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'address_text_shadow',
				'label' => __( 'Text Shadow', 'houzez-theme-functionality' ),
				'selector' => '{{WRAPPER}} .item-address',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		global $post;

		$settings = $this->get_settings_for_display();
		$temp_array = array();

		echo '<address class="item-address"><i class="houzez-icon icon-pin mr-1"></i>';
		foreach ( $settings['address_fields'] as $item_index => $item ) :
            
            $key = $item['field_type'];
           	
           	if( $key == 'address' ) {
				$temp_array[] = houzez_get_listing_data('property_map_address');

			} else if( $key == 'streat-address' ) {
				$temp_array[] = houzez_get_listing_data('property_address');

			} else if( $key == 'country' ) {
				$temp_array[] = houzez_taxonomy_simple('property_country');

			} else if( $key == 'state' ) {
				$temp_array[] = houzez_taxonomy_simple('property_state');

			} else if( $key == 'city' ) {
				$temp_array[] = houzez_taxonomy_simple('property_city');

			} else if( $key == 'area' ) {
				$temp_array[] = houzez_taxonomy_simple('property_area');

			}
            
        endforeach;

        if( !empty($temp_array)) {
	        $result = join( ", ", $temp_array );
			echo $result;
		}

        echo '</address>';
	}

	public function render_plain_content() {}
}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Address );
