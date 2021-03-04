<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Section_Open_Street_Map extends \Elementor\Widget_Base {

    public function __construct( array $data = [], array $args = null ) {
        parent::__construct( $data, $args );

        $js_path = 'assets/frontend/js/';
        
        wp_register_script('leaflet', 'https://unpkg.com/leaflet@1.3.4/dist/leaflet.js', array(), '1.3.4');
        wp_register_style('leaflet', 'https://unpkg.com/leaflet@1.3.4/dist/leaflet.css', array(), '1.3.4');

        wp_register_style('leafletMarkerCluster', HOUZEZ_JS_DIR_URI . '/vendors/leafletCluster/MarkerCluster.css', array(), '1.4.0');
        wp_register_style('leafletMarkerClusterDefault', HOUZEZ_JS_DIR_URI . '/vendors/leafletCluster/MarkerCluster.Default.css', array(), '1.4.0');
        wp_register_script('leafletMarkerCluster', HOUZEZ_JS_DIR_URI . 'vendors/leafletCluster/leaflet.markercluster.js', array('leaflet'), '1.4.0', false);


        wp_register_script( 'houzez-elementor-single-osm-scripts', HOUZEZ_PLUGIN_URL . $js_path . 'property-single-osm.js', array( 'jquery' ), '1.0.0' );

    }

    public function get_script_depends() {
        return [ 'leaflet', 'leafletMarkerCluster', 'houzez-elementor-single-osm-scripts' ];
    }

    public function get_style_depends() {
        return [ 'leaflet', 'leafletMarkerCluster', 'leafletMarkerClusterDefault' ];
    }

	public function get_name() {
		return 'houzez-property-section-open-street-map';
	}

	public function get_title() {
		return __( 'Section Open Street Map', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-map-pin';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return ['property', 'open street map', 'houzez' ];
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
            'mapbox_api_key',
            [
                'label'     => esc_html__('MapBox API Key', 'houzez-theme-functionality'),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'description' => __( 'Please enter the Mapbox API key, you can get from <a target="_blank" href="https://account.mapbox.com/">here</a>.', 'houzez' ),
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
            'zoom_level',
            [
                'label' => esc_html__( 'Zoom', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '15',
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
        $map_options['map_pin_type'] = $settings['marker_type'];
        $map_options['closeIcon'] = HOUZEZ_IMAGE . 'map/close.png';
        $map_options['infoWindowPlac'] = HOUZEZ_IMAGE. 'pixel.gif';
        $map_options['mapbox_api_key'] = $settings['mapbox_api_key'];

        ?>

        <div class="houzez-elementor-map-wrap">
            <div id="houzez-single-osm-<?php echo $this->get_id(); ?>" class="h-properties-map-for-elementor"></div>
        </div>

        <?php
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>

            <script type="application/javascript">
                houzezSingleOsMapElementor("<?php echo 'houzez-single-osm-' . esc_attr($this->get_id()); ?>", <?php echo json_encode( $property_data );?> , <?php echo json_encode($map_options);?> );
            </script>

        <?php    
        } else { ?> 
            <script type="application/javascript">
                jQuery(document).bind("ready", function () {
                    houzezSingleOsMapElementor("<?php echo 'houzez-single-osm-' . esc_attr($this->get_id()); ?>", <?php echo json_encode( $property_data );?> , <?php echo json_encode($map_options);?> );
                });
            </script>

        <?php }
        

	}

}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Property_Section_Open_Street_Map() );