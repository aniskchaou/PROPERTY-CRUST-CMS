<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Section_Map extends \Elementor\Widget_Base {

    public function __construct( array $data = [], array $args = null ) {
        parent::__construct( $data, $args );

        $js_path = 'assets/frontend/js/';
        $googlemap_api_key = houzez_option('googlemap_api_key');
        wp_register_script( 'houzez-google-map-api', 'https://maps.google.com/maps/api/js?libraries=places&language=' . get_locale() . '&key=' . esc_html($googlemap_api_key), array(), '2.0', false );

        wp_register_script( 'houzez-elementor-single-map-scripts', HOUZEZ_PLUGIN_URL . $js_path . 'property-single-google-map.min.js', array( 'jquery' ), '1.0.0' );

    }

    public function get_script_depends() {
        return [ 'houzez-google-map-api', 'houzez-elementor-single-map-scripts' ];
    }

	public function get_name() {
		return 'houzez-property-section-google-map';
	}

	public function get_title() {
		return __( 'Section Google Map', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return ['property', 'google map', 'houzez' ];
	}

	protected function _register_controls() {
		parent::_register_controls();


		$this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'houzez-theme-functionality' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        
        $this->add_control(
            'marker_type',
            [
                'label' => esc_html__( 'Pin or Circle', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'marker',
                'options' => array(
                    'marker' => esc_html__('Marker Pin', 'houzez-theme-functionality'),
                    'circle' => esc_html__('Circle', 'houzez-theme-functionality'),
                ),
            ]
        );

        $this->add_control(
            'map_type',
            [
                'label' => esc_html__( 'Map Type', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'roadmap',
                'options' => array(
                    'roadmap' => esc_html__('Road Map', 'houzez-theme-functionality'),
                    'satellite' => esc_html__('Satellite', 'houzez-theme-functionality'),
                    'hybrid' => esc_html__('Hybrid', 'houzez-theme-functionality'),
                    'terrain' => esc_html__('Terrain', 'houzez-theme-functionality'),
                ),
            ]
        );

        $this->add_control(
            'zoom_level',
            [
                'label' => esc_html__( 'Zoom', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '15',
            ]
        );

        $this->add_control(
            'googlemap_stype',
            [
                'label' => esc_html__( 'Style for Google Map', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'description' => esc_html__('Use https://snazzymaps.com/ to create styles', 'houzez-theme-functionality'),
                'default' => '',
            ]
        );

        $this->add_responsive_control(
            'map_height',
            [
                'label'           => esc_html__( 'Map Height (px)', 'houzez-theme-functionality' ),
                'type'            => \Elementor\Controls_Manager::SLIDER,
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'devices'         => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'size' => 500,
                    'unit' => 'px',
                ],
                'tablet_default'  => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'mobile_default'  => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'selectors'       => [
                    '{{WRAPPER}} .h-properties-map-for-elementor' => 'height: {{SIZE}}{{UNIT}};',

                ],
            ]
        );

        $this->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();

        $map_options = array();
        $property_data = array();

        $address  = houzez_get_listing_data('property_map_address');
        $location = houzez_get_listing_data('property_location');
        $show_map = houzez_get_listing_data('property_map');

        if( !empty($location) && $show_map != 0 ) {

            $property_data[ 'title' ] = get_the_title();
            $property_data['price']   = houzez_listing_price_v5();
            $property_data['property_id'] = get_the_ID();
            $property_data['pricePin'] = houzez_listing_price_map_pins();
            $property_data['property_type'] = houzez_taxonomy_simple('property_type');
            $property_data['address'] = $address;

            $lat_lng = explode(',', $location);
            $property_data['lat'] = $lat_lng[0];
            $property_data['lng'] = $lat_lng[1];

            //Get marker 
            $property_type = get_the_terms( get_the_ID(), 'property_type' );
            if ( $property_type && ! is_wp_error( $property_type ) ) {
                foreach ( $property_type as $p_type ) {

                    $marker_id = get_term_meta( $p_type->term_id, 'fave_marker_icon', true );
                    $property_data[ 'term_id' ] = $p_type->term_id;

                    if ( ! empty ( $marker_id ) ) {
                        $marker_url = wp_get_attachment_url( $marker_id );

                        if ( $marker_url ) {
                            $property_data[ 'marker' ] = esc_url( $marker_url );

                            $retina_marker_id = get_term_meta( $p_type->term_id, 'fave_marker_retina_icon', true );
                            if ( ! empty ( $retina_marker_id ) ) {
                                $retina_marker_url = wp_get_attachment_url( $retina_marker_id );
                                if ( $retina_marker_url ) {
                                    $property_data[ 'retinaMarker' ] = esc_url( $retina_marker_url );
                                }
                            }
                            break;
                        }
                    }
                }
            }

            //Se default markers if property type has no marker uploaded
            if ( ! isset( $property_data[ 'marker' ] ) ) {
                $property_data[ 'marker' ]       = HOUZEZ_IMAGE . 'map/pin-single-family.png';           
                $property_data[ 'retinaMarker' ] = HOUZEZ_IMAGE . 'map/pin-single-family.png';  
            }

            //Featured image
            if ( has_post_thumbnail() ) {
                $thumbnail_id         = get_post_thumbnail_id();
                $thumbnail_array = wp_get_attachment_image_src( $thumbnail_id, 'houzez-item-image-1' );
                if ( ! empty( $thumbnail_array[ 0 ] ) ) {
                    $property_data[ 'thumbnail' ] = $thumbnail_array[ 0 ];
                }
            }
        }

        $map_options['markerPricePins'] = 'no';
        $map_options['single_map_zoom'] = $settings['zoom_level'];
        $map_options['map_type'] = $settings['map_type'];
        $map_options['map_pin_type'] = $settings['marker_type'];
        $map_options['googlemap_stype'] = $settings['googlemap_stype'];
        $map_options['closeIcon'] = HOUZEZ_IMAGE . 'map/close.png';
        $map_options['infoWindowPlac'] = HOUZEZ_IMAGE. 'pixel.gif';

        ?>

        <div class="houzez-elementor-map-wrap">
            <div id="houzez-single-map-<?php echo $this->get_id(); ?>" class="h-properties-map-for-elementor"></div>
        </div>

        <?php
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>

            <script type="application/javascript">
                houzezSingleGoogleMapElementor("<?php echo 'houzez-single-map-' . esc_attr($this->get_id()); ?>", <?php echo json_encode( $property_data );?> , <?php echo json_encode($map_options);?> );
            </script>

        <?php    
        } else { ?> 
            <script type="application/javascript">
                jQuery(document).bind("ready", function () {
                    houzezSingleGoogleMapElementor("<?php echo 'houzez-single-map-' . esc_attr($this->get_id()); ?>", <?php echo json_encode( $property_data );?> , <?php echo json_encode($map_options);?> );
                });
            </script>

        <?php }
        

	}

}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Property_Section_Map() );