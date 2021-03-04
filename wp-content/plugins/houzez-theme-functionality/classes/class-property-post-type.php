<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Post_Type_Property {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        

        // Add form.
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'init', array( __CLASS__, 'property_type' ) );
        add_action( 'init', array( __CLASS__, 'property_status' ) );
        add_action( 'init', array( __CLASS__, 'property_features' ) );
        add_action( 'init', array( __CLASS__, 'property_label' ) );
        
        if( houzez_check_taxonomy('property_country') ) {
            add_action( 'init', array( __CLASS__, 'property_country' ) );
        }

        if( houzez_check_taxonomy('property_state') ) {
            add_action( 'init', array( __CLASS__, 'property_state' ) );
        }

        if( houzez_check_taxonomy('property_city') ) {
            add_action( 'init', array( __CLASS__, 'property_city' ) );
        }
        
        if( houzez_check_taxonomy('property_area') ) {
            add_action( 'init', array( __CLASS__, 'property_area' ) );
        }

        add_action( 'created_term', array( __CLASS__, 'save_taxonomies_fields' ), 10, 3 );
        add_action( 'edit_term', array( __CLASS__, 'save_taxonomies_fields' ), 10, 3 );

        add_action('admin_init', array( __CLASS__, 'houzez_approve_listing' ));
        add_action('admin_init', array( __CLASS__, 'houzez_expire_listing' ));

        add_action('restrict_manage_posts', array( __CLASS__, 'houzez_admin_property_type_filter' ));
        add_filter('parse_query', array( __CLASS__, 'houzez_convert_property_type_to_term_in_query' ));

        add_action('restrict_manage_posts', array( __CLASS__, 'houzez_admin_property_status_filter' ));
        add_filter('parse_query', array( __CLASS__, 'houzez_convert_property_status_to_term_in_query' ));

        add_action('restrict_manage_posts', array( __CLASS__, 'houzez_admin_property_city_filter' ));
        add_filter('parse_query', array( __CLASS__, 'houzez_convert_property_city_to_term_in_query' ));

        //add_action( 'save_post_property', array( __CLASS__, 'save_property_post_type' ), 10, 3 );
        add_action( 'added_post_meta', array( __CLASS__, 'save_property_post_type' ), 10, 4 );
        add_action( 'updated_post_meta', array( __CLASS__, 'save_property_post_type' ), 10, 4 );

        add_filter( 'manage_edit-property_columns', array( __CLASS__, 'custom_columns' ) );
        add_action( 'manage_pages_custom_column', array( __CLASS__, 'custom_columns_manage' ) );

        add_filter('manage_edit-property_area_columns', array( __CLASS__, 'propertyArea_columns_head' ));
        add_filter('manage_property_area_custom_column',array( __CLASS__, 'propertyArea_columns_content_taxonomy' ), 10, 3);

        add_filter('manage_edit-property_city_columns', array( __CLASS__, 'propertyCity_columns_head' ));
        add_filter('manage_property_city_custom_column',array( __CLASS__, 'propertyCity_columns_content_taxonomy' ), 10, 3);

        add_filter('manage_edit-property_state_columns', array( __CLASS__, 'propertyState_columns_head' ));
        add_filter('manage_property_state_custom_column',array( __CLASS__, 'propertyState_columns_content_taxonomy' ), 10, 3);

        if(is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == 'property') {
            add_filter( 'manage_edit-property_sortable_columns', array( __CLASS__, 'houzez_sortable_columns' ) );

            add_action('restrict_manage_posts', array( __CLASS__, 'houzez_admin_property_id_field' ));
            add_filter('pre_get_posts', array( __CLASS__, 'houzez_property_admin_custom_query' ));

        }
    }


    
    /**
     * Save category fields
     *
     * @param mixed  $term_id Term ID being saved.
     * @param mixed  $tt_id Term taxonomy ID.
     * @param string $taxonomy Taxonomy slug.
     */
    public static function save_taxonomies_fields( $term_id, $tt_id = '', $taxonomy = '' ) {

        
        if ( isset( $_POST['fave'] ) && 'property_city' === $taxonomy ) { // WPCS: CSRF ok, input var ok.
    
            $houzez_meta = array();
            $houzez_meta['parent_state'] = isset( $_POST['fave']['parent_state'] ) ? esc_attr($_POST['fave']['parent_state']) : '';
            update_option( '_houzez_property_city_'.$term_id, $houzez_meta );
        }

        if ( isset( $_POST['fave'] ) && 'property_state' === $taxonomy ) {

            $houzez_meta = array();
            $houzez_meta['parent_country'] = isset( $_POST['fave']['parent_country'] ) ? $_POST['fave']['parent_country'] : '';

            update_option( '_houzez_property_state_'.$term_id, $houzez_meta );
        }

        if ( isset( $_POST['fave'] ) && 'property_area' === $taxonomy ) {

            $houzez_meta = array();

            $houzez_meta['parent_city'] = isset( $_POST['fave']['parent_city'] ) ? $_POST['fave']['parent_city'] : '';

            update_option( '_houzez_property_area_'.$term_id, $houzez_meta );
        }

        if ( isset( $_POST['fave'] ) && 'property_type' === $taxonomy ) {

            $houzez_meta = array();

            $houzez_meta['color'] = isset( $_POST['fave']['color'] ) ? $_POST['fave']['color'] : 0;
            $houzez_meta['color_type'] = isset( $_POST['fave']['color_type'] ) ? $_POST['fave']['color_type'] : 0;

            update_option( '_houzez_property_type_'.$term_id, $houzez_meta );

            if ( $houzez_meta['color_type'] == 'custom' ) {
                houzez_update_recent_colors20( $houzez_meta['color'] );
            }

            houzez_update_property_type_colors20( $term_id, $houzez_meta['color'], $houzez_meta['color_type'] );

            if( isset($_POST['fave_marker_icon']) && !empty($_POST['fave_marker_icon'][0]) ) {
                update_term_meta($term_id, 'fave_marker_icon', intval($_POST['fave_marker_icon'][0]) ); 
            }

            if( isset($_POST['fave_marker_retina_icon']) && !empty($_POST['fave_marker_retina_icon'][0]) ) {
                update_term_meta($term_id, 'fave_marker_retina_icon', intval($_POST['fave_marker_retina_icon'][0]) ); 
            }
            


        }

        if ( isset( $_POST['fave'] ) && 'property_status' === $taxonomy ) {

            $houzez_meta = array();

            $houzez_meta['color'] = isset( $_POST['fave']['color'] ) ? $_POST['fave']['color'] : 0;
            $houzez_meta['color_type'] = isset( $_POST['fave']['color_type'] ) ? $_POST['fave']['color_type'] : 0;

            update_option( '_houzez_property_status_'.$term_id, $houzez_meta );

            if ( $houzez_meta['color_type'] == 'custom' ) {
                houzez_update_recent_colors20( $houzez_meta['color'] );
            }

            houzez_update_property_status_colors20( $term_id, $houzez_meta['color'], $houzez_meta['color_type'] );
        }

        if ( isset( $_POST['fave'] ) && 'property_label' === $taxonomy ) {

            $houzez_meta = array();

            $houzez_meta['color'] = isset( $_POST['fave']['color'] ) ? $_POST['fave']['color'] : 0;
            $houzez_meta['color_type'] = isset( $_POST['fave']['color_type'] ) ? $_POST['fave']['color_type'] : 0;

            update_option( '_houzez_property_label_'.$term_id, $houzez_meta );

            if ( $houzez_meta['color_type'] == 'custom' ) {
                houzez_update_recent_colors20( $houzez_meta['color'] );
            }

            houzez_update_property_label_colors20( $term_id, $houzez_meta['color'], $houzez_meta['color_type'] );
        }

        if( isset($_POST['fave_taxonomy_img']) && !empty($_POST['fave_taxonomy_img'][0]) ) {
            update_term_meta($term_id, 'fave_taxonomy_img', intval($_POST['fave_taxonomy_img'][0]) ); 
        }

        if( isset($_POST['fave_prop_taxonomy_custom_link']) && !empty($_POST['fave_prop_taxonomy_custom_link']) ) {
            update_term_meta($term_id, 'fave_prop_taxonomy_custom_link', esc_url($_POST['fave_prop_taxonomy_custom_link']) ); 
        }

        if ( isset( $_POST['fave_prop_features_icon'] ) && 'property_feature' === $taxonomy ) {
            update_term_meta($term_id, 'fave_prop_features_icon', esc_attr($_POST['fave_prop_features_icon']) );
        }

        if ( isset( $_POST['fave_feature_icon_type'] ) && 'property_feature' === $taxonomy ) {
            update_term_meta($term_id, 'fave_feature_icon_type', esc_attr($_POST['fave_feature_icon_type']) );
        }

        if ( isset( $_POST['fave_feature_img_icon'] ) && !empty($_POST['fave_feature_img_icon'][0]) ) {
            update_term_meta($term_id, 'fave_feature_img_icon', esc_url($_POST['fave_feature_img_icon'][0]) );
        }
        

    }

    

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name' => __( 'Properties','houzez-theme-functionality'),
            'singular_name' => __( 'Property','houzez-theme-functionality' ),
            'add_new' => __('Add New Property','houzez-theme-functionality'),
            'add_new_item' => __('Add New','houzez-theme-functionality'),
            'edit_item' => __('Edit Property','houzez-theme-functionality'),
            'new_item' => __('New Property','houzez-theme-functionality'),
            'view_item' => __('View Property','houzez-theme-functionality'),
            'search_items' => __('Search Property','houzez-theme-functionality'),
            'not_found' =>  __('No Property found','houzez-theme-functionality'),
            'not_found_in_trash' => __('No Property found in Trash','houzez-theme-functionality'),
            'parent_item_colon' => ''
          );

        $labels = apply_filters( 'houzez_post_type_labels_property', $labels );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => 'houzez-real-estate',
            'query_var' => true,
            'has_archive' => true,
            'capability_type' => 'post',
            'map_meta_cap'    => true,
            'capabilities'    => self::houzez_get_property_capabilities(),
            'hierarchical' => true,
            'menu_icon' => 'dashicons-location',
            'menu_position' => 6,
            'can_export' => true,
            'show_in_rest'       => true,
            'rest_base'          => apply_filters( 'houzez_property_rest_base', __( 'properties', 'houzez-theme-functionality' ) ),
            'supports' => array('title','editor','thumbnail','revisions','author','page-attributes','excerpt'),

             // The rewrite handles the URL structure.
            'rewrite' => array(
                  'slug'       => houzez_get_property_rewrite_slug(),
                  'with_front' => false,
                  'pages'      => true,
                  'feeds'      => true,
                  'ep_mask'    => EP_PERMALINK,
            ),
        );

        $args = apply_filters( 'houzez_post_type_args_property', $args );

        register_post_type('property',$args);
    }


    public static function property_type() {

        $type_labels = array(
                    'name'              => __('Type','houzez-theme-functionality'),
                    'add_new_item'      => __('Add New Type','houzez-theme-functionality'),
                    'new_item_name'     => __('New Type','houzez-theme-functionality')
        );
        $type_labels = apply_filters( 'houzez_type_labels', $type_labels );

        $post_type = apply_filters('houzez_property_type_post_type_filter', array('property'));

        register_taxonomy('property_type', $post_type, array(
                'labels' => $type_labels,
                'hierarchical'  => true,
                'query_var'     => true,
                'show_in_rest'          => true,
                'rest_base'             => 'property_type',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
                'rewrite'       => array( 'slug' => houzez_get_property_type_rewrite_slug() )
            )
        );
    }

    public static function property_status() {

        $status_labels = array(
                    'name'              => __('Status','houzez-theme-functionality'),
                    'add_new_item'      => __('Add New Status','houzez-theme-functionality'),
                    'new_item_name'     => __('New Status','houzez-theme-functionality')
        );
        $status_labels = apply_filters( 'houzez_status_labels', $status_labels );

        $post_type = apply_filters('houzez_property_status_post_type_filter', array('property'));

        register_taxonomy('property_status', $post_type, array(
                'labels' => $status_labels,
                'hierarchical'  => true,
                'query_var'     => true,
                'show_in_rest'          => true,
                'rest_base'             => 'property_status',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
                'rewrite'       => array( 'slug' => houzez_get_property_status_rewrite_slug() )
            )
        );
        
    }

    public static function property_features() {

        $features_labels = array(
                    'name'              => __('Features','houzez-theme-functionality'),
                    'add_new_item'      => __('Add New Feature','houzez-theme-functionality'),
                    'new_item_name'     => __('New Feature','houzez-theme-functionality')
        );
        $features_labels = apply_filters( 'houzez_features_labels', $features_labels );

        $post_type = apply_filters('houzez_property_features_post_type_filter', array('property'));

        register_taxonomy('property_feature', $post_type, array(
                'labels' => $features_labels,
                'hierarchical'  => true,
                'query_var'     => true,
                'show_in_rest'          => true,
                'rest_base'             => 'property_feature',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
                'rewrite'       => array( 'slug' => houzez_get_property_feature_rewrite_slug() )
            )
        );
    }

    public static function property_label() {

        $label_labels = array(
                    'name'              => __('Labels', 'houzez-theme-functionality'),
                    'add_new_item'      => __('Add New Label','houzez-theme-functionality'),
                    'new_item_name'     => __('New Label','houzez-theme-functionality')
        );
        $label_labels = apply_filters( 'houzez_label_labels', $label_labels );

        $post_type = apply_filters('houzez_property_label_post_type_filter', array('property'));

        register_taxonomy('property_label', $post_type, array(
                'labels' => $label_labels,
                'hierarchical'  => true,
                'query_var'     => true,
                'show_in_rest'          => true,
                'rest_base'             => 'property_label',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
                'rewrite'       => array( 'slug' => houzez_get_property_label_rewrite_slug() )
            )
        );
        
    }

    public static function property_city() {

        $city_labels = array(
                    'name'              => __('City','houzez-theme-functionality'),
                    'add_new_item'      => __('Add New City','houzez-theme-functionality'),
                    'new_item_name'     => __('New City','houzez-theme-functionality')
        );
        $city_labels = apply_filters( 'houzez_city_labels', $city_labels );

        $post_type = apply_filters('houzez_property_city_post_type_filter', array('property'));

        register_taxonomy('property_city', $post_type, array(
                'labels' => $city_labels,
                'hierarchical'  => true,
                'query_var'     => true,
                'show_in_rest'          => true,
                'rest_base'             => 'property_city',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
                'rewrite'       => array( 'slug' => houzez_get_property_city_rewrite_slug() )
            )
        );


    }

    public static function property_area() {

        $area_labels = array(
                    'name'              => __('Area','houzez-theme-functionality'),
                    'add_new_item'      => __('Add New Area','houzez-theme-functionality'),
                    'new_item_name'     => __('New Area','houzez-theme-functionality')
        );
        $area_labels = apply_filters( 'houzez_area_labels', $area_labels );

        $post_type = apply_filters('houzez_property_area_post_type_filter', array('property'));

        register_taxonomy('property_area', $post_type, array(
                'labels' => $area_labels,
                'hierarchical'  => true,
                'query_var'     => true,
                'show_in_rest'          => true,
                'rest_base'             => 'property_area',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
                'rewrite'       => array( 'slug' => houzez_get_property_area_rewrite_slug() )
            )
        );
    }


    public static function property_country() {

        $property_country_labels = array(
                    'name'              => __('Country','houzez-theme-functionality'),
                    'add_new_item'      => __('Add New Country','houzez-theme-functionality'),
                    'new_item_name'     => __('New Country','houzez-theme-functionality')
        );
        $property_country_labels = apply_filters( 'houzez_country_labels', $property_country_labels );

        $post_type = apply_filters('houzez_property_country_post_type_filter', array('property'));

        register_taxonomy('property_country', $post_type, array(
                'labels' => $property_country_labels,
                'hierarchical'  => true,
                'query_var'     => true,
                'show_in_rest'          => true,
                'rest_base'             => 'property_country',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
                'rewrite'       => array( 'slug' => houzez_get_property_country_rewrite_slug() )
            )
        );
    }

    public static function property_state() {

        $property_state_labels = array(
                    'name'              => __('State','houzez-theme-functionality'),
                    'add_new_item'      => __('Add New State','houzez-theme-functionality'),
                    'new_item_name'     => __('New State','houzez-theme-functionality')
        );
        $property_state_labels = apply_filters( 'houzez_state_labels', $property_state_labels );

        $post_type = apply_filters('houzez_property_state_post_type_filter', array('property'));

        register_taxonomy('property_state', $post_type, array(
                'labels' => $property_state_labels,
                'hierarchical'  => true,
                'query_var'     => true,
                'show_in_rest'          => true,
                'rest_base'             => 'property_state',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
                'rewrite'       => array( 'slug' => houzez_get_property_state_rewrite_slug() )
            )
        );
    }

    public static function houzez_get_property_capabilities() {

        $caps = array(
            // meta caps (don't assign these to roles)
            'edit_post'              => 'edit_property',
            'read_post'              => 'read_property',
            'delete_post'            => 'delete_property',

            // primitive/meta caps
            'create_posts'           => 'create_properties',

            // primitive caps used outside of map_meta_cap()
            'edit_posts'             => 'edit_properties',
            'edit_others_posts'      => 'edit_others_properties',
            'publish_post'           => 'publish_properties',
            'read_private_posts'     => 'read_private_properties',

            // primitive caps used inside of map_meta_cap()
            'read'                   => 'read',
            'delete_posts'           => 'delete_properties',
            'delete_private_posts'   => 'delete_private_properties',
            'delete_published_posts' => 'delete_published_properties',
            'delete_others_posts'    => 'delete_others_properties',
            'edit_private_posts'     => 'edit_private_properties',
            'edit_published_posts'   => 'edit_published_properties'
        );

        return apply_filters( 'houzez_get_property_capabilities', $caps );
    }


    /**
     * Custom admin columns for post type
     *
     * @access public
     * @return array
     */
    public static function custom_columns() {

        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __( 'Title','houzez-theme-functionality' ),
            "thumbnail" => __( 'Thumbnail','houzez-theme-functionality' ),
            'city' => __( 'City','houzez-theme-functionality' ),
            "type" => __('Type','houzez-theme-functionality'),
            "status" => __('Status','houzez-theme-functionality'),
            "price" => __('Price','houzez-theme-functionality'),
            "id" => __( 'Property ID','houzez-theme-functionality' ),
            "featured" => __( 'Featured','houzez-theme-functionality' ),
            "listing_posted" => __( 'Posted','houzez-theme-functionality' ),
            "listing_expiry" => __( 'Expires','houzez-theme-functionality' ),
            "houzez_actions" => __( 'Actions','houzez-theme-functionality' ),
            //"prop_id" => __( 'ID','houzez-theme-functionality' ),
        );

        $columns = apply_filters( 'houzez_custom_post_property_columns', $columns );

        if ( is_rtl() ) {
            $columns = array_reverse( $columns );
        }

        return $columns;
        
    }

    /**
     * Custom admin columns implementation
     *
     * @access public
     * @param string $column
     * @return array
     */
    public static function custom_columns_manage( $column ) {
        global $post;
        $houzez_prefix = 'fave_';
        switch ($column)
        {
            case 'thumbnail':
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail( array(75, 75), array(
                        'class' => 'attachment-thumbnail attachment-thumbnail-small',
                    ) );
                } else {
                    echo '-';
                }
                break;
            case 'id':
                $Prop_id = get_post_meta($post->ID, $houzez_prefix.'property_id',true);
                if(!empty($Prop_id)){
                    echo esc_attr( $Prop_id );
                }
                else{
                    _e('NA','houzez-theme-functionality');
                }
                break;

            case 'prop_id':
                echo get_the_ID();
                break;
            case 'featured':
                $featured = get_post_meta($post->ID, $houzez_prefix.'featured',true);
                if($featured != 1 ) {
                    _e( 'No', 'houzez-theme-functionality' );
                } else {
                    _e( 'Yes', 'houzez-theme-functionality' );
                }
                break;
            case 'city':
                echo Houzez::admin_taxonomy_terms ( $post->ID, 'property_city', 'property' );
                break;
            case 'address':
                $address = get_post_meta($post->ID, $houzez_prefix.'property_address',true);
                if(!empty($address)){
                    echo esc_attr( $address );
                }
                else{
                    _e('No Address Provided!','houzez-theme-functionality');
                }
                break;
            case 'type':
                echo Houzez::admin_taxonomy_terms ( $post->ID, 'property_type', 'property' );
                break;
            case 'status':
                echo Houzez::admin_taxonomy_terms ( $post->ID, 'property_status', 'property' );
                break;
            case 'price':
                if( function_exists('houzez_property_price_admin')) {
                    houzez_property_price_admin();
                }
                break;
            case 'bed':
                $bed = get_post_meta($post->ID, $houzez_prefix.'property_bedrooms',true);
                if(!empty($bed)){
                    echo esc_attr( $bed );
                }
                else{
                    _e('NA','houzez-theme-functionality');
                }
                break;
            case 'bath':
                $bath = get_post_meta($post->ID, $houzez_prefix.'property_bathrooms',true);
                if(!empty($bath)){
                    echo esc_attr( $bath );
                }
                else{
                    _e('NA','houzez-theme-functionality');
                }
                break;
            case 'garage':
                $garage = get_post_meta($post->ID, $houzez_prefix.'property_garage',true);
                if(!empty($garage)){
                    echo esc_attr( $garage );
                }
                else{
                    _e('NA','houzez-theme-functionality');
                }
                break;
            case 'features':
                echo get_the_term_list($post->ID,'property-feature', '', ', ','');
                break;
            case 'houzez_actions':
                echo '<div class="actions">';

                $admin_actions = apply_filters( 'post_row_actions', array(), $post );

                $user = wp_get_current_user();

                if ( in_array( $post->post_status, array( 'pending' ) ) && in_array( 'administrator', (array) $user->roles ) ) {
                    $admin_actions['approve']   = array(
                        'action'  => 'approve',
                        'name'    => __( 'Approve', 'houzez-theme-functionality' ),
                        'url'     =>  wp_nonce_url( add_query_arg( 'approve_listing', $post->ID ), 'approve_listing' )
                    );
                }
                if ( in_array( $post->post_status, array( 'publish', 'pending' ) ) && in_array( 'administrator', (array) $user->roles ) ) {
                    $admin_actions['expire']   = array(
                        'action'  => 'expire',
                        'name'    => __( 'Expire', 'houzez-theme-functionality' ),
                        'url'     =>  wp_nonce_url( add_query_arg( 'expire_listing', $post->ID ), 'expire_listing' )
                    );
                }
                
                $admin_actions = apply_filters( 'houzez_admin_actions', $admin_actions, $post );

                foreach ( $admin_actions as $action ) {
                    if ( is_array( $action ) ) {
                        printf( '<a class="button button-icon tips icon-%1$s" href="%2$s" data-tip="%3$s">%4$s</a>', $action['action'], esc_url( $action['url'] ), esc_attr( $action['name'] ), esc_html( $action['name'] ) );
                    } else {
                        
                    }
                }

                echo '</div>';

                break;
                case "listing_posted" :
                    echo '<p>' . date_i18n( get_option('date_format').' '.get_option('time_format'), strtotime( $post->post_date ) ) . '</p>';
                    echo '<p>'.( empty( $post->post_author ) ? __( 'by a guest', 'houzez-theme-functionality' ) : sprintf( __( 'by %s', 'houzez-theme-functionality' ), '<a href="' . esc_url( add_query_arg( 'author', $post->post_author ) ) . '">' . get_the_author() . '</a>' ) ) . '</p>';
                    break;
            case "listing_expiry" :

                if( function_exists('houzez_user_role_by_post_id')) {
                    if( houzez_user_role_by_post_id($post->ID) != 'administrator' && get_post_status ( $post->ID ) == 'publish' ) {
                        if( function_exists('houzez_listing_expire')) {
                            houzez_listing_expire();
                        }

                    } else {

                        if( get_post_status($post->ID) == 'expired' ) {
                            echo '<span style="color:red;">'.get_post_status($post->ID).'</span>';
                        }
                    }
                }
                break;
        }
    }



    /**
     * Custom admin columns for area taxonomy
     *
     * @access public
     * @return array
     */
    
    public static function propertyArea_columns_head() {

        $new_columns = array(
            'cb'            => '<input type="checkbox" />',
            'name'          => __('Name','houzez-theme-functionality'),
            'city'          => __('City','houzez-theme-functionality'),
            'header_icon'   => '',
            'slug'          => __('Slug','houzez-theme-functionality'),
            'posts'         => __('Posts','houzez-theme-functionality')
        );

        if ( is_rtl() ) {
            $new_columns = array_reverse( $new_columns );
        }

        return $new_columns;
    }


    public static function propertyArea_columns_content_taxonomy($out, $column_name, $term_id) {
        if ($column_name == 'city') {
            $term_meta= get_option( "_houzez_property_area_$term_id");
            $term = get_term_by('slug', $term_meta['parent_city'], 'property_city'); 
            if(!empty($term)) {
                print stripslashes( $term->name );
            }
            return;
        }
    }

    /**
     * Custom admin columns for city taxonomy
     *
     * @access public
     * @return array
     */
    public static function propertyCity_columns_head() {

        $new_columns = array(
            'cb'            => '<input type="checkbox" />',
            'name'          => __('Name','houzez-theme-functionality'),
            'county_state'          => __('County/State','houzez-theme-functionality'),
            'header_icon'   => '',
            'slug'          => __('Slug','houzez-theme-functionality'),
            'posts'         => __('Posts','houzez-theme-functionality')
        );

        if ( is_rtl() ) {
            $new_columns = array_reverse( $new_columns );
        }

        return $new_columns;
    }


    public static function propertyCity_columns_content_taxonomy($out, $column_name, $term_id) {
        if ($column_name == 'county_state') {
            $term_meta= get_option( "_houzez_property_city_$term_id");
            $term = get_term_by('slug', $term_meta['parent_state'], 'property_state'); 
            if(!empty($term)) {
                print stripslashes( $term->name );
            }
            return;
        }
    }



    /**
     * Custom admin columns for state taxonomy
     *
     * @access public
     * @return array
     */
    public static function propertyState_columns_head() {

        $new_columns = array(
            'cb'            => '<input type="checkbox" />',
            'name'          => __('Name','houzez-theme-functionality'),
            'country'       => __('Country','houzez-theme-functionality'),
            'header_icon'   => '',
            'slug'          => __('Slug','houzez-theme-functionality'),
            'posts'         => __('Posts','houzez-theme-functionality')
        );

        if ( is_rtl() ) {
            $new_columns = array_reverse( $new_columns );
        }
        return $new_columns;
    }


    public static function propertyState_columns_content_taxonomy($out, $column_name, $term_id) {
        if ($column_name == 'country') {
            $term_meta= get_option( "_houzez_property_state_$term_id");
            $term = get_term_by('slug', $term_meta['parent_country'], 'property_country'); 
            if(!empty($term)) {
                print stripslashes( $term->name );
            }
        }
    }


    /**
     * Update post meta associated info when post updated
     *
     * @access public
     * @return
     */
    public static function save_property_post_type($meta_id, $property_id, $meta_key, $meta_value) {

        if ( empty( $meta_id ) || empty( $property_id ) || empty( $meta_key ) ) {
            return;
        }

        if ( 'fave_property_id' === $meta_key ) {
            if( houzez_option('auto_property_id', 0) != 0 ) {
                $existing_id     = get_post_meta( $property_id, 'fave_property_id', true );
                $pattern = houzez_option( 'property_id_pattern' );
                $new_id   = preg_replace( '/{ID}/', $property_id, $pattern );
                
                if ( $existing_id !== $new_id ) {
                    update_post_meta($property_id, 'fave_property_id', $new_id);
                }
            }
        }

        

        if ( 'houzez_geolocation_lat' !== $meta_key || 'houzez_geolocation_long' !== $meta_key ) {
            $lat_long = get_post_meta( $property_id, 'fave_property_location', true );
            if( isset($lat_long) && !empty($lat_long)) {
                $lat_long = explode(',', $lat_long);
                $lat = $lat_long[0];
                $long = $lat_long[1];

                update_post_meta($property_id, 'houzez_geolocation_lat', $lat);
                update_post_meta($property_id, 'houzez_geolocation_long', $long);
            }
        }

        if(class_exists('Houzez_Currencies')) {

            if ( 'fave_currency' === $meta_key ) {
                $currency_code = get_post_meta($property_id, 'fave_currency', true);
                $currencies = Houzez_Currencies::get_property_currency_2($property_id, $currency_code);

                update_post_meta( $property_id, 'fave_currency_info', $currencies );
            }
            
        }

    }

    public static function houzez_approve_listing()
    {
        if (!empty($_GET['approve_listing']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'approve_listing') && current_user_can('publish_post', $_GET['approve_listing'])) {
            $post_id = absint($_GET['approve_listing']);
            $listing_data = array(
                'ID' => $post_id,
                'post_status' => 'publish'
            );
            wp_update_post($listing_data);

            $author_id = get_post_field ('post_author', $post_id);
            $user           =   get_user_by('id', $author_id );
            $user_email     =   $user->user_email;

            $args = array(
                'listing_title' => get_the_title($post_id),
                'listing_url' => get_permalink($post_id)
            );
            houzez_email_type( $user_email,'listing_approved', $args );

            wp_redirect(remove_query_arg('approve_listing', add_query_arg('approve_listing', $post_id, admin_url('edit.php?post_type=property'))));
            exit;
        }
    }

    public static function houzez_expire_listing() {

        if (!empty($_GET['expire_listing']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'expire_listing') && current_user_can('publish_post', $_GET['expire_listing'])) {
            $post_id = absint($_GET['expire_listing']);
            $listing_data = array(
                'ID' => $post_id,
                'post_status' => 'expired'
            );
            wp_update_post($listing_data);

            update_post_meta($post_id, 'fave_featured', '0');

            $author_id = get_post_field ('post_author', $post_id);
            $user           =   get_user_by('id', $author_id );
            $user_email     =   $user->user_email;

            $args = array(
                'listing_title' => get_the_title($post_id),
                'listing_url' => get_permalink($post_id)
            );
            houzez_email_type( $user_email,'listing_expired', $args );

            wp_redirect(remove_query_arg('expire_listing', add_query_arg('expire_listing', $post_id, admin_url('edit.php?post_type=property'))));
            exit;
        }
    }


    /*------------------------------------------------
     * Types filter
     *----------------------------------------------- */
    public static function houzez_admin_property_type_filter() {
        global $typenow;
        $post_type = 'property';
        $taxonomy = 'property_type';
        if ($typenow == $post_type) {
            $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $info_taxonomy = get_taxonomy($taxonomy);
            wp_dropdown_categories(array(
                'show_option_all' => esc_html__("All Types", 'houzez-theme-functionality'),
                'taxonomy' => $taxonomy,
                'name' => $taxonomy,
                'orderby' => 'name',
                'selected' => $selected,
                'show_count' => false,
                'hide_empty' => false,
            ));
        };
    }

    public static function houzez_convert_property_type_to_term_in_query($query) {
        global $pagenow;
        $post_type = 'property';
        $taxonomy = 'property_type';
        $q_vars = &$query->query_vars;
        if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }
    }

    /*------------------------------------------------
     * Status filter
     *----------------------------------------------- */
    public static function houzez_admin_property_status_filter() {
        global $typenow;
        $post_type = 'property';
        $taxonomy = 'property_status';
        if ($typenow == $post_type) {
            $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $info_taxonomy = get_taxonomy($taxonomy);
            wp_dropdown_categories(array(
                'show_option_all' => esc_html__("All Status", 'houzez-theme-functionality'),
                'taxonomy' => $taxonomy,
                'name' => $taxonomy,
                'orderby' => 'name',
                'selected' => $selected,
                'show_count' => false,
                'hide_empty' => false,
            ));
        };
    }

    public static function houzez_convert_property_status_to_term_in_query($query) {
        global $pagenow;
        $post_type = 'property';
        $taxonomy = 'property_status';
        $q_vars = &$query->query_vars;
        if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }
    }

    /*------------------------------------------------
     * Labels filter
     *----------------------------------------------- */
    public static function houzez_admin_property_label_filter() {
        global $typenow;
        $post_type = 'property';
        $taxonomy = 'property_label';
        if ($typenow == $post_type) {
            $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $info_taxonomy = get_taxonomy($taxonomy);
            wp_dropdown_categories(array(
                'show_option_all' => esc_html__("All Labels", 'houzez-theme-functionality'),
                'taxonomy' => $taxonomy,
                'name' => $taxonomy,
                'orderby' => 'name',
                'selected' => $selected,
                'show_count' => false,
                'hide_empty' => false,
            ));
        };
    }

    public static function houzez_convert_property_label_to_term_in_query($query) {
        global $pagenow;
        $post_type = 'property';
        $taxonomy = 'property_label';
        $q_vars = &$query->query_vars;
        if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }
    }

    /*------------------------------------------------
     * Cities filter
     *----------------------------------------------- */
    public static function houzez_admin_property_city_filter() {
        global $typenow;
        $post_type = 'property';
        $taxonomy = 'property_city';
        if ($typenow == $post_type) {
            $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $info_taxonomy = get_taxonomy($taxonomy);
            wp_dropdown_categories(array(
                'show_option_all' => esc_html__("All Cities", 'houzez-theme-functionality'),
                'taxonomy' => $taxonomy,
                'name' => $taxonomy,
                'orderby' => 'name',
                'selected' => $selected,
                'show_count' => false,
                'hide_empty' => false,
            ));
        };
    }

    public static function houzez_convert_property_city_to_term_in_query($query) {
        global $pagenow;
        $post_type = 'property';
        $taxonomy = 'property_city';
        $q_vars = &$query->query_vars;
        if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }
    }

    /*------------------------------------------------
     * Admin filters UI
     *----------------------------------------------- */
    public static function houzez_admin_property_id_field() {
        global $post_type;

        if ( $post_type == 'property' ) {

            // Property ID filter
            $property_id = '';
            if ( isset( $_GET['property_id'] ) && ! empty( $_GET['property_id'] ) ) {
                $property_id = esc_attr( $_GET['property_id'] );
            }
            ?>
            <input style="width: 110px;" id="property_id" type="text" name="property_id" placeholder="<?php esc_html_e( 'Property ID', 'houzez-theme-functionality' ); ?>" value="<?php echo esc_attr($property_id); ?>">
            <?php

        }
    }

    public static function houzez_sortable_columns($columns) {
        $columns['price'] = 'price';
        $columns['listing_posted'] = 'listing_posted';

        return $columns;
    }

    /*------------------------------------------------
     * Properties admin filter query
     *----------------------------------------------- */
    public static function houzez_property_admin_custom_query($query) {

        global $post_type, $pagenow;

        if ( $pagenow == 'edit.php' && $post_type == 'property' ) {

            $meta_query = array();

            if ( isset( $_GET['property_id'] ) && ! empty( $_GET['property_id'] ) ) {

                $meta_query[] = array(
                    'key'     => 'fave_property_id',
                    'value'   => sanitize_text_field( $_GET['property_id'] ),
                    'compare' => 'LIKE',
                );

            }
            if ( ! empty( $meta_query ) ) {
                $query->query_vars['meta_query'] = $meta_query;

            }
            
            $orderby = $query->get( 'orderby' );

            if ( 'price' == $orderby ) {
                $query->set( 'meta_key', 'fave_property_price' );
                $query->set( 'orderby', 'meta_value_num' );

            } elseif( 'title' == $orderby || 'listing_posted' == $orderby ) {

                $query->set('orderby', $_GET['orderby']);
                $query->set('order', $_GET['order']);

            } else {
                $query->set('orderby', 'date');
                $query->set('order', 'DESC');
            }

        } // $pagenow
    }
}