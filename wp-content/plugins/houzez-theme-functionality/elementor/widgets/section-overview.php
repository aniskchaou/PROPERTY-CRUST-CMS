<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Overview extends Widget_Base {


	public function get_name() {
		return 'houzez-property-overview';
	}

	public function get_title() {
		return __( 'Section Overview', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-featured-image';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return ['property', 'overview', 'houzez' ];
	}

	protected function _register_controls() {
		parent::_register_controls();


		$repeater = new Repeater();
		$field_types = array();

        $field_types = [
            'property_type' => esc_html__( 'Property Type', 'houzez-theme-functionality' ),
            'property_bedrooms' => esc_html__( 'Bedrooms', 'houzez-theme-functionality' ),
            'property_bathrooms' => esc_html__( 'Bathrooms', 'houzez-theme-functionality' ),
            'property_size' => esc_html__( 'Area Size', 'houzez-theme-functionality' ),
            'property_land' => esc_html__( 'Land Area', 'houzez-theme-functionality' ),
            'property_garage' => esc_html__( 'Garages', 'houzez-theme-functionality' ),
            'property_year' => esc_html__( 'Built Year', 'houzez-theme-functionality' ),
            'property_status' => esc_html__( 'Property Status', 'houzez-theme-functionality' ),
            'property_id' => esc_html__( 'Property ID', 'houzez-theme-functionality' ),
            
        ];

        $field_types = array_merge($field_types, houzez_get_custom_field_for_elementor());
        
        /**
         * field types.
         */
        $field_types = apply_filters( 'houzez/overview_data', $field_types );


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
            'label_singular',
            [
                'label' => esc_html__( 'Label', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'label_plural',
            [
                'label' => esc_html__( 'Label Plural', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'field_type',
                            'operator' => '!in',
                            'value' => [
                                'property_size',
                                'property_year',
                                'property_land',
                                'property_id',
                                'property_status',
                                'property_type',
                            ],
                        ],
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'icon_type',
            [
                'label' => esc_html__( 'Icons From', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'theme_options' => esc_html__( 'Theme Options ', 'houzez-theme-functionality' ),
                    'custom' => esc_html__('Custom Icon', 'houzez-theme-functionality'),
                    'none' => esc_html__('No Icon', 'houzez-theme-functionality'),
                ],
                'default' => 'theme_options',
            ]
        );

        $repeater->add_control(
			'meta_icon',
			[
				'label' => esc_html__( 'upload Icon', 'text-domain' ),
				'type' => Controls_Manager::ICONS,
				'condition' => [
                	'icon_type' => 'custom'
                ],
			]
		);
        

		$this->start_controls_section(
            'overview_content',
            [
                'label' => __( 'Content', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_header',
            [
                'label' => esc_html__( 'Section Header', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => esc_html__( 'Section Title', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => '',
                'condition' => [
                	'section_header' => 'true'
                ],
            ]
        );

        $this->add_control(
            'data_type',
            [
                'label' => esc_html__( 'Data Type', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Pre Defined', 'houzez-theme-functionality' ),
                    'custom' => esc_html__('Custom', 'houzez-theme-functionality'),
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'overview_fields',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        '_id' => 'property_type',
                        'field_type' => 'property_type',
                        'label_singular' => esc_html__( 'Property Type', 'houzez-theme-functionality' ),
                        'label_plural' => '',
                        'icon_type' => 'none',
                    ],
                    [
                        '_id' => 'property_bedrooms',
                        'field_type' => 'property_bedrooms',
                        'label_singular' => esc_html__( 'Bedroom', 'houzez-theme-functionality' ),
                        'label_plural' => esc_html__( 'Bedrooms', 'houzez-theme-functionality' ),
                        'icon_type' => 'theme_options',
                    ],
                    [
                        '_id' => 'property_bathrooms',
                        'field_type' => 'property_bathrooms',
                        'label_singular' => esc_html__( 'Bathroom', 'houzez-theme-functionality' ),
                        'label_plural' => esc_html__( 'Bathrooms', 'houzez-theme-functionality' ),
                        'icon_type' => 'theme_options',
                    ],
                    [
                        '_id' => 'property_garage',
                        'field_type' => 'property_garage',
                        'label_singular' => esc_html__( 'Garage', 'houzez-theme-functionality' ),
                        'label_plural' => esc_html__( 'Garages', 'houzez-theme-functionality' ),
                        'icon_type' => 'theme_options',
                    ],
                    [
                        '_id' => 'property_size',
                        'field_type' => 'property_size',
                        'label_singular' => esc_html__( 'Area Size', 'houzez-theme-functionality' ),
                        'label_plural' => '',
                        'icon_type' => 'theme_options',
                    ],
                    [
                        '_id' => 'property_year',
                        'field_type' => 'property_year',
                        'label_singular' => esc_html__( 'Year Built', 'houzez-theme-functionality' ),
                        'label_plural' => '',
                        'icon_type' => 'theme_options',
                    ],
                    
                ],
                'title_field' => '{{{ label_singular }}}',
                'condition' => [
                	'data_type' => 'custom'
                ],
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
            'overview_style',
            [
                'label' => __( 'Section Style', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'box_background',
                'label' => __( 'Background', 'houzez-theme-functionality' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .block-wrap',
            ]
        );

        $this->add_control(
            'section_title_border',
            [
                'label' => esc_html__( 'Hide Title Border', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .block-title-wrap' => 'border-bottom: {{VALUE}};',
                    '{{WRAPPER}} .block-wrap' => 'border-top: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'     => esc_html__( 'Border Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-title-wrap' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'section_title_border!' => 'none'
                ]
            ]
        );

        $this->add_responsive_control(
            'section_margin_top',
            [
                'label' => esc_html__( 'Margin Top', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .block-wrap' => 'margin-top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding_bottom',
            [
                'label' => esc_html__( 'Title Padding Bottom', 'houzez-theme-functionality' ),
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
                    '{{WRAPPER}} .block-title-wrap' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin_bottom',
            [
                'label' => esc_html__( 'Title Margin Bottom', 'houzez-theme-functionality' ),
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
                    '{{WRAPPER}} .block-title-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


		$this->add_control(
			'padding',
			[
				'label' => __( 'Box Padding', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .block-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'radius',
			[
				'label' => __( 'Box Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .block-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'content_style',
            [
                'label' => __( 'Content Style', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'heading_section_title',
			[
				'label' => esc_html__( 'Section Title', 'houzez-theme-functionality' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
            'sec_title_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .block-title-wrap h2' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .block-title-wrap h2',
            ]
        );

        $this->add_control(
			'heading_labels',
			[
				'label' => esc_html__( 'Meta Labels', 'houzez-theme-functionality' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'meta_label_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .property-overview-data li.hz-meta-label' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'meta_label_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .property-overview-data li.hz-meta-label',
            ]
        );

        $this->add_control(
			'heading_values',
			[
				'label' => esc_html__( 'Meta Data', 'houzez-theme-functionality' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'meta_data_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .property-overview-item strong' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'meta_data_typo',
                'label'    => esc_html__( 'Typography', 'houzez-theme-functionality' ),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .property-overview-item strong',
            ]
        );

        $this->add_control(
			'heading_icons',
			[
				'label' => esc_html__( 'Meta Icons', 'houzez-theme-functionality' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'meta_icon_color',
            [
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .property-overview-item i, .property-overview-item svg' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_icon_size',
            [
                'label' => esc_html__( 'Icons Size(px)', 'houzez-theme-functionality' ),
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
                    '{{WRAPPER}} .property-overview-item i, .property-overview-item svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
      

		$this->end_controls_section();

	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();


		$section_title = isset($settings['section_title']) && !empty($settings['section_title']) ? $settings['section_title'] : houzez_option('sps_overview', 'Overview');

		if( $settings['data_type'] != 'custom' ) {
			
			$prop_id 	= houzez_get_listing_data('property_id');
			?>
			<div class="property-overview-wrap property-section-wrap" id="property-overview-wrap">
				<div class="block-wrap">
					
					<?php if( $settings['section_header'] ) { ?>
					<div class="block-title-wrap d-flex justify-content-between align-items-center">
						<h2><?php echo esc_attr($section_title); ?></h2>

						<?php if( !empty( $prop_id )) { ?>
						<div><strong><?php echo houzez_option('spl_prop_id', 'Property ID'); ?>:</strong> <?php echo houzez_propperty_id_prefix($prop_id); ?></div>
						<?php } ?>
					</div><!-- block-title-wrap -->
					<?php } ?>

					<div class="d-flex property-overview-data">
						<?php get_template_part('property-details/partials/overview-data'); ?>
					</div><!-- d-flex -->
				</div><!-- block-wrap -->
			</div><!-- property-overview-wrap -->

		<?php
		} else { ?>

			<div class="property-overview-wrap property-section-wrap" id="property-overview-wrap">
				<div class="block-wrap">

					<?php if( $settings['section_header'] ) { ?>
					<div class="block-title-wrap d-flex justify-content-between align-items-center">
						<h2><?php echo esc_attr($section_title); ?></h2>
					</div><!-- block-title-wrap -->
					<?php } ?>

					<div class="d-flex property-overview-data">

					<?php
					foreach ( $settings['overview_fields'] as $item_index => $item ) :
		                    $field_name = $item['field_type'];

		                

		                switch ( $item['field_type'] ) :
		                    
		                    
		                    case 'property_bedrooms':
		                    case 'property_bathrooms':
		                    case 'property_garage':
		                    case 'property_size':
		                    case 'property_land':
		                    case 'property_year':
		                    case 'property_id':
		                        echo $this->houzez_meta_field( $item, $item_index );
		                        break;

		                    case 'property_type':
		                    case 'property_status':
		                        echo $this->houzez_taxonomy_field( $item, $item_index );
		                        break;
		                       
		                    default:
		                    	echo $this->houzez_meta_field( $item, $item_index );
		                    	break;
		                         
		                endswitch;
		                

		            endforeach;
		            ?>

	            	</div><!-- property-overview-data -->
	            </div><!-- block-wrap -->
			</div><!-- property-overview-wrap -->
		<?php

		}

	}


	protected function houzez_meta_field( $item, $i ) {

		global $post;
		$output = "";
		
		$icon_type = $item['icon_type'];
		$meta_field = $item['field_type'];
		$label_plural = $item['label_plural'];
		$label_singular = $item['label_singular'];

		$field_data = get_post_meta( $post->ID, 'fave_'.$meta_field, true );
		$field_label = ( $field_data > 1 && !empty($label_plural) ) ? $label_plural : $label_singular;

		if( $meta_field == 'property_size' ) {
			$field_data = houzez_get_listing_area_size( $post->ID );
			$field_label = houzez_get_listing_size_unit( $post->ID );

		} else if( $meta_field == 'property_land' ) {
			$field_data = houzez_get_land_area_size( $post->ID );
			$field_label = houzez_option('spl_lot', 'Lot').' '.houzez_get_land_size_unit( $post->ID );
		}

        if(!empty($field_data)) {

			$icon = self::houzez_render_icon($item['meta_icon'], [ 'aria-hidden' => 'true', 'class' => 'mr-1' ] );

			$output .='<ul class="list-unstyled flex-fill">';
					$output .='<li class="property-overview-item">';
						
						if( $icon_type == 'custom' ) {
							if( !empty($icon) ) {
								$output .= $icon.' ';
							}

						} elseif( $icon_type == 'theme_options' ) {

							//bedrooms
							if( $meta_field == 'property_bedrooms' ) {
								if(houzez_option('icons_type') == 'font-awesome') {
									$output .= '<i class="'.houzez_option('fa_bed').' mr-1"></i> ';

								} elseif (houzez_option('icons_type') == 'custom') {
									$cus_icon = houzez_option('bed');
									if(!empty($cus_icon['url'])) {
										$output .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'"> ';
									}
								} else {
									$output .= '<i class="houzez-icon icon-hotel-double-bed-1 mr-1"></i> ';
								}

							} elseif( $meta_field == 'property_bathrooms' ) {

								if(houzez_option('icons_type') == 'font-awesome') {
									$output .= '<i class="'.houzez_option('fa_bath').' mr-1"></i> ';

								} elseif (houzez_option('icons_type') == 'custom') {
									$cus_icon = houzez_option('bath');
									if(!empty($cus_icon['url'])) {
										$output .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'"> ';
									}
								} else {
									$output .= '<i class="houzez-icon icon-bathroom-shower-1 mr-1"></i> ';
								}

							} elseif( $meta_field == 'property_garage' ) {

								if(houzez_option('icons_type') == 'font-awesome') {
									$output .= '<i class="'.houzez_option('fa_garage').' mr-1"></i> ';

								} elseif (houzez_option('icons_type') == 'custom') {
									$cus_icon = houzez_option('garage');
									if(!empty($cus_icon['url'])) {
										$output .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'"> ';
									}
								} else {
									$output .= '<i class="houzez-icon icon-car-1 mr-1"></i> ';
								}

							} elseif ( $meta_field == 'property_size' ) {

								if(houzez_option('icons_type') == 'font-awesome') {
									$output .= '<i class="'.houzez_option('fa_area-size').' mr-1"></i> ';

								} elseif (houzez_option('icons_type') == 'custom') {
									$cus_icon = houzez_option('area-size');
									if(!empty($cus_icon['url'])) {
										$output .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'"> ';
									}
								} else {
									$output .= '<i class="houzez-icon icon-real-estate-dimensions-plan-1 mr-1"></i> ';
								}

							} elseif ( $meta_field == 'property_land' ) {

								if(houzez_option('icons_type') == 'font-awesome') {
									$output .= '<i class="'.houzez_option('fa_land-area').' mr-1"></i> ';

								} elseif (houzez_option('icons_type') == 'custom') {
									$cus_icon = houzez_option('land-area');
									if(!empty($cus_icon['url'])) {
										$output .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'"> ';
									}
								} else {
									$output .= '<i class="houzez-icon icon-real-estate-dimensions-map mr-1"></i> ';
								}

							} elseif ( $meta_field == 'property_year' ) {

								if(houzez_option('icons_type') == 'font-awesome') {
									$output .= '<i class="'.houzez_option('fa_year-built').' mr-1"></i> ';

								} elseif (houzez_option('icons_type') == 'custom') {
									$cus_icon = houzez_option('year-built');
									if(!empty($cus_icon['url'])) {
										$output .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'"> ';
									}
								} else {
									$output .= '<i class="houzez-icon icon-calendar-3 mr-1"></i> ';
								}

							} elseif ( $meta_field == 'property_id' ) {

								if(houzez_option('icons_type') == 'font-awesome') {
									$output .= '<i class="'.houzez_option('fa_property-id').' mr-1"></i>';

								} elseif (houzez_option('icons_type') == 'custom') {
									$cus_icon = houzez_option('property-id');
									if(!empty($cus_icon['url'])) {
										$output .= '<img class="img-fluid mr-1" src="'.esc_url($cus_icon['url']).'" width="16" height="16" alt="'.esc_attr($cus_icon['title']).'">';
									}
								} else {
									$output .= '<i class="houzez-icon icon-tags mr-1"></i>';
								}

							}

						}

						$output .='<strong>'.esc_attr( $field_data ).'</strong> ';
					$output .='</li>';
					$output .='<li class="hz-meta-label">'.esc_attr($field_label).'</li>';
			$output .='</ul>';
		}
        return $output;

	}

	protected function houzez_taxonomy_field( $item, $i ) {

		global $post;
		$output = "";

		$icon_type = $item['icon_type'];
		$meta_field = $item['field_type'];
		$label_plural = $item['label_plural'];
		$label_singular = $item['label_singular'];

		$field_data = houzez_taxonomy_simple_2( $meta_field, $post->ID );

		$field_label = $label_singular;

        if(!empty($field_data)) {

			$icon = self::houzez_render_icon($item['meta_icon'], [ 'aria-hidden' => 'true', 'class' => 'mr-1' ] );

			$output .='<ul class="list-unstyled flex-fill">';
					$output .='<li class="property-overview-item">';
						
						if( $icon_type == 'custom' ) {
							if( !empty($icon) ) {
								$output .= $icon.' ';
							}

						} 

						$output .='<strong>'.esc_attr( $field_data ).'</strong> ';
					$output .='</li>';
					$output .='<li class="hz-meta-label">'.esc_attr($field_label).'</li>';
			$output .='</ul>';
		}
        return $output;

	}

	public static function houzez_render_icon( $icon, $attributes = [], $tag = 'i' ) {

		if ( empty( $icon['library'] ) ) {
			return false;
		}

		$output = '';
		// handler SVG Icon
		if ( 'svg' === $icon['library'] ) {
			$output = self::houzez_render_svg_icon( $icon['value'] );
		} else {
			$output = self::houzez_render_icon_html( $icon, $attributes, $tag );
		}

		return $output;
	}

	private static function houzez_render_icon_html( $icon, $attributes = [], $tag = 'i' ) {
		$icon_types = \Elementor\Icons_Manager::get_icon_manager_tabs();
		if ( isset( $icon_types[ $icon['library'] ]['render_callback'] ) && is_callable( $icon_types[ $icon['library'] ]['render_callback'] ) ) {
			return call_user_func_array( $icon_types[ $icon['library'] ]['render_callback'], [ $icon, $attributes, $tag ] );
		}

		if ( empty( $attributes['class'] ) ) {
			$attributes['class'] = $icon['value'];
		} else {
			if ( is_array( $attributes['class'] ) ) {
				$attributes['class'][] = $icon['value'];
			} else {
				$attributes['class'] .= ' ' . $icon['value'];
			}
		}
		return '<' . $tag . ' ' . Utils::render_html_attributes( $attributes ) . '></' . $tag . '>';
	}

	private static function houzez_render_svg_icon( $value ) {
		if ( ! isset( $value['id'] ) ) {
			return '';
		}

		return Svg_Handler::get_inline_svg( $value['id'] );
	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Overview );