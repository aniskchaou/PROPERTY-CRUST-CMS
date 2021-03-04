<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Property_Toparea_v3 extends Widget_Base {


    public function __construct( array $data = [], array $args = null ) {
        parent::__construct( $data, $args );

        $js_path = 'assets/frontend/js/';
        
        
        wp_register_script('lightslider', HOUZEZ_PLUGIN_URL . $js_path . 'lightslider.min.js', array('jquery'), '1.1.3', false);


        wp_register_script( 'houzez-elementor-single-gallery-top', HOUZEZ_PLUGIN_URL . $js_path . 'property-single-gallery.js', array( 'jquery' ), '1.0.0' );

    }

    public function get_script_depends() {
        return [ 'lightslider', 'houzez-elementor-single-gallery-top' ];
    }


    public function get_name() {
        return 'houzez-property-toparea-v3';
    }

    public function get_title() {
        return __( 'Section Top Area v3 and v4', 'houzez-theme-functionality' );
    }

    public function get_icon() {
        return 'eicon-featured-image';
    }

    public function get_categories() {
        return [ 'houzez-single-property' ];
    }

    public function get_keywords() {
        return ['property', 'toparea 3, 4', 'houzez', 'gallery' ];
    }

    protected function _register_controls() {
        parent::_register_controls();


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
        $field_types = apply_filters( 'houzez/address_title', $field_types );

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
            'section_content',
            [
                'label' => __( 'Content', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'gallery_note',
            [
                'label' => __( 'To view gallery visit property front-end.', 'houzez-theme-functionality' ),
                'type' => 'houzez-info-note',
                
            ]
        );

        $this->end_controls_section();


    
        //Breadcrumb
        $this->start_controls_section(
            'section_breadcrumb',
            [
                'label' => __( 'Breadcrumb', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_breadcrumb',
            [
                'label' => esc_html__( 'Show Breadcrumb', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb-wrap li.breadcrumb-item.active' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => __( 'Link Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb-wrap li.breadcrumb-item a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label' => __( 'Separator Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumb-item+.breadcrumb-item::before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .breadcrumb-wrap li.breadcrumb-item',
            ]
        );


        $this->end_controls_section();

        // Property Title
        $this->start_controls_section(
            'section_prop_title',
            [
                'label' => __( 'Property Title', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__( 'Show Title', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'prop_title_color',
            [
                'label' => __( 'Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .page-title h1' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'prop_title_typography',
                'scheme' => Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .page-title h1',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'prop_title_text_shadow',
                'label' => __( 'Text Shadow', 'houzez-theme-functionality' ),
                'selector' => '{{WRAPPER}} .page-title h1',
            ]
        );
        
        $this->end_controls_section();

        // Property labels
        $this->start_controls_section(
            'section_prop_labels',
            [
                'label' => __( 'Property Labels', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label' => esc_html__( 'Show Labels', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->end_controls_section();

        // Property Address
        $this->start_controls_section(
            'section_prop_address',
            [
                'label' => __( 'Property Address', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_address',
            [
                'label' => esc_html__( 'Show Address', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
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


        // Property Price
        $this->start_controls_section(
            'section_prop_price',
            [
                'label' => __( 'Property Price', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_price',
            [
                'label' => esc_html__( 'Show Price', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'item_price_color',
            [
                'label' => __( 'Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_price_top',
            [
                'label' => __( 'Margin Top', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-price' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_price_bottom',
            [
                'label' => __( 'Margin Bottom', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-price' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'scheme' => Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .item-price',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'item_price_text_shadow',
                'label' => __( 'Text Shadow', 'houzez-theme-functionality' ),
                'selector' => '{{WRAPPER}} .item-price',
            ]
        );

        $this->add_control(
            'item_sub_price_heading',
            [
                'label' => __( 'Second Price', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'item_sub_price_color',
            [
                'label' => __( 'Color', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-sub-price' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_sub_price_typography',
                'scheme' => Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .item-sub-price',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'item_sub_price_text_shadow',
                'label' => __( 'Text Shadow', 'houzez-theme-functionality' ),
                'selector' => '{{WRAPPER}} .item-sub-price',
            ]
        );

        $this->end_controls_section();

        // Tools
        $this->start_controls_section(
            'section_Tools',
            [
                'label' => __( 'Tools', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hide_favorite',
            [
                'label' => esc_html__( 'Hide Favorite', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-tools .item-tool.houzez-favorite' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_social',
            [
                'label' => esc_html__( 'Hide Social Share', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-tools .item-tool.houzez-share' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hide_print',
            [
                'label' => esc_html__( 'Hide Print', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'none',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-tools .item-tool.houzez-print' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'buttons_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'houzez-theme-functionality' ),
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
                'label'     => esc_html__( 'Background Color Hover', 'houzez-theme-functionality' ),
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
                'label'     => esc_html__( 'Color', 'houzez-theme-functionality' ),
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
                'label'     => esc_html__( 'Color Hover', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-tool > span:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'buttons_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-tool > span' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'buttons_border_color_hover',
            [
                'label'     => esc_html__( 'Border Color Hover', 'houzez-theme-functionality' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .item-tool > span:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Media Buttons
        $this->start_controls_section(
            'section_media',
            [
                'label' => __( 'Media Buttons', 'houzez-theme-functionality' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'btn_gallery',
            [
                'label' => esc_html__( 'Gallery Button', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'btn_map',
            [
                'label' => esc_html__( 'Map Button', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'map_note',
            [
                'label' => __( 'Map will only show if you have enabled when add/edit property', 'houzez-theme-functionality' ),
                'type' => 'houzez-warning-note',
                'condition' => [
                    'btn_map' => 'true'
                ]
            ]
        );

        $this->add_control(
            'btn_street',
            [
                'label' => esc_html__( 'Street View Button', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'true',
                'default' => 'true',
            ]
        );

        $this->add_control(
            'street_note',
            [
                'label' => __( 'Street view will only show if you have enabled when add/edit property and map type set to Google', 'houzez-theme-functionality' ),
                'type' => 'houzez-warning-note',
                'condition' => [
                    'btn_street' => 'true'
                ]
            ]
        );

        $this->end_controls_section();
        

    }

    protected function render() {
        global $settings, $map_street_view, $post;

        $size = 'houzez-gallery';
        $settings = $this->get_settings_for_display();
        $featured_image_url = houzez_get_image_url('full', $post->ID);
        $map_street_view = get_post_meta( $post->ID, 'fave_property_map_street_view', true );

        $properties_images = rwmb_meta( 'fave_property_images', 'type=plupload_image&size='.$size, $post->ID );
        $gallery_caption = houzez_option('gallery_caption', 0); 
        ?>

        <div class="property-wrap property-detail-v4">
            <?php 
            if( $settings['show_breadcrumb'] || $settings['show_title'] || $settings['show_price'] || $settings['show_address'] || $settings['show_labels'] ) {
                htf_get_template_part('elementor/template-part/single-property/property-title'); 
            }?>
    
            <div class="property-top-wrap">
                <div class="property-banner">
                    <div class="container hidden-on-mobile">
                        <?php htf_get_template_part('elementor/template-part/single-property/media-btns'); ?>
                    </div><!-- container -->
                    <div class="tab-content" id="pills-tabContent">
                        
                        <div class="tab-pane show active" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
                            <?php 

                            if ( Plugin::$instance->editor->is_edit_mode() ) { ?>

                                <div class="top-gallery-section">
                                    <div class="listing-slider">
                                        <div>
                                            <a href="#">
                                                <img src="<?php echo esc_url($featured_image_url[0]); ?>">
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- top-gallery-section -->
                            <?php
                            } else {
                                if( !empty($properties_images) && count($properties_images)) { ?>

                                    <style type="text/css">
                                        .listing-slider-ele {
                                            max-height: 751px !important;
                                        }
                                    </style>

                                    <script type="application/javascript">
                                        jQuery(document).bind("ready", function () {
                                            houzezSingleTopGalleryElementor("<?php echo 'property-gallery-js-' . esc_attr($this->get_id()); ?>" );
                                        });
                                    </script>
                                    <div class="top-gallery-section">
                                        <div id="property-gallery-js-<?php echo $this->get_id(); ?>" class="listing-slider listing-slider-ele cS-hidden">
                                            <?php
                                            foreach( $properties_images as $prop_image_id => $prop_image_meta ) {
                                                $output = '';
                                                $thumb = houzez_get_image_by_id($prop_image_id, 'houzez-item-image-1');
                                                
                                                $output .= '<div data-thumb="'.esc_url( $thumb[0] ).'">';
                                                        $output .= '<a rel="gallery-1" href="#" class="swipebox" data-toggle="modal" data-target="#property-lightbox">
                                                            <img class="img-fluid" src="'.esc_url( $prop_image_meta['url'] ).'" alt="'.esc_attr($prop_image_meta['alt']).'" title="'.esc_attr($prop_image_meta['title']).'">
                                                        </a>';

                                                if( !empty($prop_image_meta['caption']) && $gallery_caption != 0 ) {
                                                   $output .= '<span class="hz-image-caption">'.esc_attr($prop_image_meta['caption']).'</span>';
                                                }

                                                $output .= '</div>';

                                                echo $output;
                                            }
                                            ?>

                                            
                                        </div>
                                    </div><!-- top-gallery-section -->

                                <?php    
                                } 
                            }
                            ?>
                        </div>

                        <?php 
                        if( houzez_get_listing_data('property_map') ) {
                        if( $settings['btn_map'] ) { ?>
                        <div class="tab-pane" id="pills-map" role="tabpanel" aria-labelledby="pills-map-tab">
                            <?php get_template_part('property-details/partials/map'); ?>
                        </div>
                        <?php } ?>

                        <?php if(houzez_get_map_system() == 'google' && $map_street_view != 'hide' && $settings['btn_street'] ) { ?>
                            <div class="tab-pane" id="pills-street-view" role="tabpanel" aria-labelledby="pills-street-view-tab">
                            </div>
                            <?php } ?>
                        <?php } ?>

                    </div><!-- tab-content -->
                </div><!-- property-banner -->
            </div><!-- property-top-wrap -->
        </div> <!-- property-detail-wrap -->
        
        <?php htf_get_template_part('elementor/template-part/single-property/mobile', 'view'); ?>

    <?php

    }


}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Toparea_v3 );