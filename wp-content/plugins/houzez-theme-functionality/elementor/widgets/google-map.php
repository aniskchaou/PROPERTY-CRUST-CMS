<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor Section Title Widget.
 * @since 1.5.6
 */
class Houzez_Elementor_Properties_Google_Map extends \Elementor\Widget_Base {

    public function __construct( array $data = [], array $args = null ) {
        parent::__construct( $data, $args );

        $js_path = 'assets/frontend/js/';
        
        $googlemap_api_key = houzez_option('googlemap_api_key');
        wp_register_script( 'houzez-google-map-api', 'https://maps.google.com/maps/api/js?libraries=places&language=' . get_locale() . '&key=' . esc_html($googlemap_api_key), array(), '2.0', false );

        wp_register_script('richmarker', HOUZEZ_JS_DIR_URI. 'vendors/richmarker-compiled.js', array('houzez-google-map-api'), HOUZEZ_THEME_VERSION);

         wp_register_script('googlemap-marker-spiderfier', HOUZEZ_JS_DIR_URI. 'vendors/oms.min.js', array('houzez-google-map-api'), '1.12.2');

         wp_register_script('googlemap-marker-clusterer', HOUZEZ_JS_DIR_URI. 'vendors/markerclusterer.min.js', array('houzez-google-map-api'), '2.1.1');

         wp_register_script( 'houzez-elementor-scripts', HOUZEZ_PLUGIN_URL . $js_path . 'maps.min.js', array( 'jquery' ), '1.0.0' );

    }

    public function get_script_depends() {
        return [ 'houzez-google-map-api', 'richmarker', 'googlemap-marker-spiderfier', 'googlemap-marker-clusterer', 'houzez-elementor-scripts' ];
    }


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
        return 'houzez_properties_google_map';
    }

    /**
     * Get widget title.
     * @since 1.5.6
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Properties Google Map', 'houzez-theme-functionality' );
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
        return 'eicon-google-maps';
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

        $allowed_html = array(
            'a'      => array(
                'href'  => array(),
                'title' => array()
            ),
            'br'     => array(),
            'em'     => array(),
            'strong' => array(),
        );

        $this->start_controls_section(
            'content_section',
            [
                'label'     => esc_html__( 'Properties', 'houzez-theme-functionality' ),
                'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_limit',
            [
                'label'     => esc_html__('Number of properties', 'houzez-theme-functionality'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'min'     => 1,
                'max'     => 5000,
                'step'    => 1,
                'default' => 9,
            ]
        );

        $this->add_control(
            'offset',
            [
                'label'     => 'Offset',
                'type'      => \Elementor\Controls_Manager::TEXT,
                'description' => '',
            ]
        );

        // Property taxonomies controls
        $prop_taxonomies = get_object_taxonomies( 'property', 'objects' );

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
                        'type'     => \Elementor\Controls_Manager::SELECT2,
                        'multiple' => true,
                        'label_block' => true,
                        'options'  => $options_array,
                    ]
                );
            }
        }

        $this->add_control(
            'featured_prop',
            [
                'label'     => esc_html__( 'Featured Properties', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                "description" => esc_html__("You can make a property featured by clicking featured properties checkbox while add/edit property", "houzez-theme-functionality"),
                'label_on'     => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off'    => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'yes',
                'default'      => 'no',
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
                    'size' => 600,
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

        $this->start_controls_section(
            'map_options_section',
            [
                'label'     => esc_html__( 'Map Options', 'houzez-theme-functionality' ),
                'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'map_type',
            [
                'label'   => esc_html__( 'Map Type', 'houzez-theme-functionality' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'roadmap'   => esc_html__( 'RoadMap', 'houzez-theme-functionality' ),
                    'satellite' => esc_html__( 'Satellite', 'houzez-theme-functionality' ),
                    'hybrid'    => esc_html__( 'Hybrid', 'houzez-theme-functionality' ),
                    'terrain'   => esc_html__( 'Terrain', 'houzez-theme-functionality' ),
                ],
                'default' => 'roadmap',
            ]
        );


        $this->add_control(
            'map_style',
            [
                'label'   => esc_html__( 'Map Style', 'houzez-theme-functionality' ),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'rows'    => 10,
                'description'  => wp_kses( __( 'Create Google Map style JSON using <a href="https://snazzymaps.com/" target="_blank">Snazzy Maps</a> or <a href="https://mapstyle.withgoogle.com" target="_blank">Google Styling Wizard</a>', 'houzez-theme-functionality' ), $allowed_html ),

            ]
        );

        $this->add_control(
            'mapCluster',
            [
                'label'     => esc_html__( 'Map Cluster', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                "description" => '',
                'label_on'     => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off'    => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'mapClusterZoom',
            [
                'label'     => esc_html__('Cluster Zoom Level', 'houzez-theme-functionality'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'min'     => 1,
                'max'     => 50,
                'step'    => 1,
                'default' => 12,
                'condition' => [
                    'mapCluster' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'zoomControl',
            [
                'label'     => esc_html__( 'Zoom Control', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                "description" => '',
                'label_on'     => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off'    => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        $this->add_control(
            'mapTypeControl',
            [
                'label'     => esc_html__( 'Map Type Control', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                "description" => '',
                'label_on'     => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off'    => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        $this->add_control(
            'streetViewControl',
            [
                'label'     => esc_html__( 'Street View Control', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                "description" => '',
                'label_on'     => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off'    => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );
        $this->add_control(
            'fullscreenControl',
            [
                'label'     => esc_html__( 'Fullscreen Control', 'houzez-theme-functionality' ),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                "description" => '',
                'label_on'     => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off'    => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'yes',
                'default'      => 'yes',
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

        if ( get_query_var( 'paged' ) ) {
            $paged = get_query_var( 'paged' );
        } elseif ( get_query_var( 'page' ) ) { // if is static front page
            $paged = get_query_var( 'page' );
        } else {
            $paged = 1;
        }

        if ( $settings['offset'] ) {
            $offset = $settings['offset'] + ( $paged - 1 ) * $settings['posts_per_page'];
        } else {
            $offset = '';
        }
        $wp_query_args = array(
            'post_type'      => 'property',
            'posts_per_page' => $settings['posts_limit'],
            'offset'         => $offset,
            'paged'          => $paged,
            'post_status'    => 'publish'
        );

        $taxonomies = get_object_taxonomies( 'property', 'objects' );
        if ( ! empty( $taxonomies ) && ! is_wp_error( $taxonomies ) ) {
            foreach ( $taxonomies as $single_tax ) {
                $setting_key = $single_tax->name;
                if ( ! empty( $settings[ $setting_key ] ) ) {
                    $wp_query_args['tax_query'][] = [
                        'taxonomy' => $setting_key,
                        'field'    => 'slug',
                        'terms'    => $settings[ $setting_key ],
                    ];
                }
            }

            if ( isset( $wp_query_args['tax_query'] ) && count( $wp_query_args['tax_query'] ) > 1 ) {
                $wp_query_args['tax_query']['relation'] = 'AND';
            }
        }

        if (!empty($settings['featured_prop'])) {
                
            if( $settings['featured_prop'] == "yes" ) {
                $wp_query_args['meta_key'] = 'fave_featured';
                $wp_query_args['meta_value'] = '1';
            }
        }

        $map_options = array();
        $properties_data = array();
        $prop_map_query = new WP_Query( $wp_query_args );
        
        if ( $prop_map_query->have_posts() ) :
            while ( $prop_map_query->have_posts() ) : $prop_map_query->the_post();

                $property_array_temp = array();

                $property_array_temp[ 'title' ] = get_the_title();
                $property_array_temp[ 'url' ] = get_permalink();
                $property_array_temp['price'] = houzez_listing_price_v5();
                $property_array_temp['property_id'] = get_the_ID();
                $property_array_temp['pricePin'] = houzez_listing_price_map_pins();

                $address = houzez_get_listing_data('property_map_address');
                if(!empty($address)) {
                    $property_array_temp['address'] = $address;
                }

                //Property type
                $property_array_temp['property_type'] = houzez_taxonomy_simple('property_type');

                $property_location = houzez_get_listing_data('property_location');
                if(!empty($property_location)){
                    $lat_lng = explode(',',$property_location);
                    $property_array_temp['lat'] = $lat_lng[0];
                    $property_array_temp['lng'] = $lat_lng[1];
                }

                //Get marker 
                $property_type = get_the_terms( get_the_ID(), 'property_type' );
                if ( $property_type && ! is_wp_error( $property_type ) ) {
                    foreach ( $property_type as $p_type ) {

                        $marker_id = get_term_meta( $p_type->term_id, 'fave_marker_icon', true );
                        $property_array_temp[ 'term_id' ] = $p_type->term_id;

                        if ( ! empty ( $marker_id ) ) {
                            $marker_url = wp_get_attachment_url( $marker_id );

                            if ( $marker_url ) {
                                $property_array_temp[ 'marker' ] = esc_url( $marker_url );

                                $retina_marker_id = get_term_meta( $p_type->term_id, 'fave_marker_retina_icon', true );
                                if ( ! empty ( $retina_marker_id ) ) {
                                    $retina_marker_url = wp_get_attachment_url( $retina_marker_id );
                                    if ( $retina_marker_url ) {
                                        $property_array_temp[ 'retinaMarker' ] = esc_url( $retina_marker_url );
                                    }
                                }
                                break;
                            }
                        }
                    }
                }

                //Se default markers if property type has no marker uploaded
                if ( ! isset( $property_array_temp[ 'marker' ] ) ) {
                    $property_array_temp[ 'marker' ]       = get_template_directory_uri() . '/img/map/pin-single-family.png';           
                    $property_array_temp[ 'retinaMarker' ] = get_template_directory_uri() . '/img/map/pin-single-family.png';  
                }

                //Featured image
                if ( has_post_thumbnail() ) {
                    $thumbnail_id         = get_post_thumbnail_id();
                    $thumbnail_array = wp_get_attachment_image_src( $thumbnail_id, 'houzez-item-image-1' );
                    if ( ! empty( $thumbnail_array[ 0 ] ) ) {
                        $property_array_temp[ 'thumbnail' ] = $thumbnail_array[ 0 ];
                    }
                }

                $properties_data[] = $property_array_temp;
            endwhile;
        endif;
        wp_reset_postdata();

        $map_cluster = houzez_option( 'map_cluster', false, 'url' );
        if($map_cluster != '') {
            $map_options['clusterIcon'] = $map_cluster;
        } else {
            $map_options['clusterIcon'] = get_template_directory_uri() . '/img/map/cluster-icon.png';
        }
        $map_options['zoomControl'] = $settings['zoomControl'];
        $map_options['mapTypeControl'] = $settings['mapTypeControl'];
        $map_options['streetViewControl'] = $settings['streetViewControl'];
        $map_options['fullscreenControl'] = $settings['fullscreenControl'];
        $map_options['mapCluster'] = $settings['mapCluster'];
        $map_options['map_type'] = $settings['map_type'];
        $map_options['map_style'] = $settings['map_style'];
        $map_options['clusterer_zoom'] = $settings['mapClusterZoom'];
        $map_options['markerPricePins'] = houzez_option('markerPricePins');
        $map_options['marker_spiderfier'] = houzez_option('marker_spiderfier');
        $map_options['closeIcon'] = get_template_directory_uri() . '/img/map/close.png';
        $map_options['infoWindowPlac'] = get_template_directory_uri() . '/img/pixel.gif';
        ?>

        <div class="houzez-elementor-map-wrap">
            <div id="houzez-map-<?php echo $this->get_id(); ?>" class="h-properties-map-for-elementor"></div>
        </div>

        <?php
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>

            <script type="application/javascript">
                houzezGoogleMapElementor("<?php echo 'houzez-map-' . esc_attr($this->get_id()); ?>", <?php echo json_encode( $properties_data );?> , <?php echo json_encode($map_options);?> );
            </script>

        <?php    
        } else { ?> 
            <script type="application/javascript">
                jQuery(document).bind("ready", function () {
                    houzezGoogleMapElementor("<?php echo 'houzez-map-' . esc_attr($this->get_id()); ?>", <?php echo json_encode( $properties_data );?> , <?php echo json_encode($map_options);?> );
                });
            </script>

        <?php }

        
    } // End render

}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Elementor_Properties_Google_Map() );