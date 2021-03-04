<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Post_Type_Agent {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'init', array( __CLASS__, 'agent_category' ) );
        add_action( 'init', array( __CLASS__, 'agent_city' ) );
        add_action( 'save_post_houzez_agent', array( __CLASS__, 'save_agent_meta' ), 10, 3 );
        add_filter( 'manage_edit-houzez_agent_columns', array( __CLASS__, 'custom_columns' ) );
        add_action( 'manage_houzez_agent_posts_custom_column', array( __CLASS__, 'custom_columns_manage' ) );
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name' => __( 'Agents','houzez-theme-functionality'),
            'singular_name' => __( 'Agent','houzez-theme-functionality' ),
            'add_new' => __('Add New','houzez-theme-functionality'),
            'add_new_item' => __('Add New Agent','houzez-theme-functionality'),
            'edit_item' => __('Edit Agent','houzez-theme-functionality'),
            'new_item' => __('New Agent','houzez-theme-functionality'),
            'view_item' => __('View Agent','houzez-theme-functionality'),
            'search_items' => __('Search Agent','houzez-theme-functionality'),
            'not_found' =>  __('No Agent found','houzez-theme-functionality'),
            'not_found_in_trash' => __('No Agent found in Trash','houzez-theme-functionality'),
            'parent_item_colon' => ''
        );

        $labels = apply_filters( 'houzez_post_type_agent_labels', $labels );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'show_in_menu'        => false,
            'show_in_admin_bar'   => true,
            'show_ui' => true,
            'query_var' => true,
            'has_archive' => true,
            'capability_type' => 'post',
            'hierarchical' => true,
            'can_export' => true,
            'capabilities'    => self::houzez_get_agent_capabilities(),
            'menu_icon' => 'dashicons-admin-users',
            'menu_position' => 15,
            'supports' => array('title','editor', 'thumbnail', 'page-attributes','revisions'),
            'show_in_rest'       => true,
            'rest_base'          => 'agents',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'rewrite' => array( 'slug' => houzez_get_agent_rewrite_slug() )
        );

        $args = apply_filters( 'houzez_post_type_agent_args', $args );

        register_post_type('houzez_agent',$args);
    }

    public static function agent_category() {

        $labels = array(
            'name'              => __('Categories','houzez-theme-functionality'),
            'add_new_item'      => __('Add New Category','houzez-theme-functionality'),
            'new_item_name'     => __('New Category','houzez-theme-functionality')
        );
        $labels = apply_filters( 'houzez_agent_category_labels', $labels );

        register_taxonomy('agent_category', 'houzez_agent', array(
                'labels' => $labels,
                'hierarchical'  => true,
                'query_var'     => true,
                'show_in_rest'          => true,
                'rest_base'             => 'agent_category',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
                'rewrite'       => array( 'slug' => 'agent_category' )
            )
        );
    }

    public static function agent_city() {


        $labels = array(
            'name'              => __('Cities','houzez-theme-functionality'),
            'add_new_item'      => __('Add New City','houzez-theme-functionality'),
            'new_item_name'     => __('New City','houzez-theme-functionality')
        );

        $labels = apply_filters( 'houzez_agent_city_labels', $labels );

        register_taxonomy('agent_city', 'houzez_agent', array(
                'labels' => $labels,
                'hierarchical'  => true,
                'query_var'     => true,
                'show_in_rest'          => true,
                'rest_base'             => 'agent_city',
                'rest_controller_class' => 'WP_REST_Terms_Controller',
                'rewrite'       => array( 'slug' => 'agent_city' )
            )
        );
    }

    /**
     * Custom admin columns for post type
     *
     * @access public
     * @return array
     */
    public static function custom_columns() {
        $fields = array(
            'cb' 				=> '<input type="checkbox" />',
            'agent_id' 			=> esc_html__( 'Agent ID', 'houzez-theme-functionality' ),
            'title' 			=> esc_html__( 'Agent Name', 'houzez-theme-functionality' ),
            'agent_thumbnail' 		=> esc_html__( 'Picture', 'houzez-theme-functionality' ),
            'category' 		    => esc_html__( 'Category', 'houzez-theme-functionality' ),
            'email'      		=> esc_html__( 'E-mail', 'houzez-theme-functionality' ),
            'web'      		    => esc_html__( 'Web', 'houzez-theme-functionality' ),
            'mobile'      		=> esc_html__( 'Mobile', 'houzez-theme-functionality' ),
        );

        return $fields;
    }

    public static function houzez_get_agent_capabilities() {

        $caps = array(
            // meta caps (don't assign these to roles)
            'edit_post'              => 'edit_agent',
            'read_post'              => 'read_agent',
            'delete_post'            => 'delete_agent',

            // primitive/meta caps
            'create_posts'           => 'create_agents',

            // primitive caps used outside of map_meta_cap()
            'edit_posts'             => 'edit_agents',
            'edit_others_posts'      => 'edit_others_agents',
            'publish_posts'          => 'publish_agents',
            'read_private_posts'     => 'read_private_agents',

            // primitive caps used inside of map_meta_cap()
            'read'                   => 'read',
            'delete_posts'           => 'delete_agents',
            'delete_private_posts'   => 'delete_private_agents',
            'delete_published_posts' => 'delete_published_agents',
            'delete_others_posts'    => 'delete_others_agents',
            'edit_private_posts'     => 'edit_private_agents',
            'edit_published_posts'   => 'edit_published_agents'
        );

        return apply_filters( 'houzez_get_agent_capabilities', $caps );
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
        switch ( $column ) {
            case 'agent_thumbnail':
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'thumbnail', array(
                        'class'     => 'attachment-thumbnail attachment-thumbnail-small',
                    ) );
                } else {
                    echo '-';
                }
                break;
            case 'agent_id':
                echo $post->ID;
                break;
            case 'category':
                echo Houzez::admin_taxonomy_terms ( $post->ID, 'agent_category', 'houzez_agent' );
                break;
            case 'email':
                $email = get_post_meta( get_the_ID(),  'fave_agent_email', true );

                if ( ! empty( $email ) ) {
                    echo esc_attr( $email );
                } else {
                    echo '-';
                }
                break;
            case 'web':
                $web = get_post_meta( get_the_ID(), 'fave_agent_website', true );

                if ( ! empty( $web ) ) {
                    echo '<a target="_blank" href="'.esc_url( $web ).'">'.esc_url( $web ).'</a>';
                } else {
                    echo '-';
                }
                break;
            case 'mobile':
                $phone = get_post_meta( get_the_ID(), 'fave_agent_mobile', true );

                if ( ! empty( $phone ) ) {
                    echo esc_attr( $phone );
                } else {
                    echo '-';
                }
                break;

        }
    }

    /**
     * Update agent user associated info when agent updated
     *
     * @access public
     * @return
     */
    public static function save_agent_meta($post_id, $post, $update) {

        if (!is_object($post) || !isset($post->post_type)) {
            return;
        }
        
        $slug = 'houzez_agent';
        // If this isn't a 'book' post, don't update it.
        if ($slug != $post->post_type) {
            return;
        }

        if (!isset($_POST['fave_agent_email'])) {
            return;
        }

        $user_as_agent = houzez_option('user_as_agent');

        $allowed_html = array();
        $user_id = get_post_meta( $post_id, 'houzez_user_meta_id', true );
        $email = wp_kses($_POST['fave_agent_email'], $allowed_html);
        $agent_agency = wp_kses($_POST['fave_agent_agencies'], $allowed_html);
        $fave_agent_des = wp_kses($_POST['fave_agent_des'], $allowed_html);
        $fave_agent_position = wp_kses($_POST['fave_agent_position'], $allowed_html);
        $fave_agent_company = wp_kses($_POST['fave_agent_company'], $allowed_html);
        $fave_agent_license = wp_kses($_POST['fave_agent_license'], $allowed_html);
        $fave_agent_tax_no = wp_kses($_POST['fave_agent_tax_no'], $allowed_html);
        $fave_agent_mobile = wp_kses($_POST['fave_agent_mobile'], $allowed_html);
        $fave_agent_whatsapp = wp_kses($_POST['fave_agent_whatsapp'], $allowed_html);
        $fave_agent_office_num = wp_kses($_POST['fave_agent_office_num'], $allowed_html);
        $fave_agent_fax = wp_kses($_POST['fave_agent_fax'], $allowed_html);
        $fave_agent_skype = wp_kses($_POST['fave_agent_skype'], $allowed_html);
        $fave_agent_website = wp_kses($_POST['fave_agent_website'], $allowed_html);
        $fave_agent_facebook = wp_kses($_POST['fave_agent_facebook'], $allowed_html);
        $fave_agent_twitter = wp_kses($_POST['fave_agent_twitter'], $allowed_html);
        $fave_agent_linkedin = wp_kses($_POST['fave_agent_linkedin'], $allowed_html);
        $fave_agent_googleplus = wp_kses($_POST['fave_agent_googleplus'], $allowed_html);
        $fave_agent_youtube = wp_kses($_POST['fave_agent_youtube'], $allowed_html);
        $fave_agent_instagram = wp_kses($_POST['fave_agent_instagram'], $allowed_html);
        $fave_agent_pinterest = wp_kses($_POST['fave_agent_pinterest'], $allowed_html);
        $fave_agent_vimeo = wp_kses($_POST['fave_agent_vimeo'], $allowed_html);
        $fave_agent_language = wp_kses($_POST['fave_agent_language'], $allowed_html);
        $fave_agent_address = wp_kses($_POST['fave_agent_address'], $allowed_html);
        $image_id = get_post_thumbnail_id($post_id);
        $full_img = wp_get_attachment_image_src($image_id, 'houzez-image350_350');

        update_user_meta( $user_id, 'aim', '/'.$full_img[0].'/') ;
        update_user_meta( $user_id, 'fave_author_phone' , $fave_agent_office_num) ;
        update_user_meta( $user_id, 'fave_author_language' , $fave_agent_language) ;
        update_user_meta( $user_id, 'fave_author_license' , $fave_agent_license) ;
        update_user_meta( $user_id, 'fave_author_tax_no' , $fave_agent_tax_no) ;
        update_user_meta( $user_id, 'fave_author_fax' , $fave_agent_fax) ;
        update_user_meta( $user_id, 'fave_author_mobile' , $fave_agent_mobile) ;
        update_user_meta( $user_id, 'fave_author_whatsapp' , $fave_agent_whatsapp) ;
        update_user_meta( $user_id, 'description' , $fave_agent_des) ;
        update_user_meta( $user_id, 'fave_author_skype' , $fave_agent_skype) ;
        update_user_meta( $user_id, 'fave_author_title', $fave_agent_position) ;

        update_user_meta( $user_id, 'fave_author_custom_picture', $full_img[0]) ;
        update_user_meta( $user_id, 'fave_author_facebook', $fave_agent_facebook) ;
        update_user_meta( $user_id, 'fave_author_twitter', $fave_agent_twitter) ;
        update_user_meta( $user_id, 'fave_author_linkedin', $fave_agent_linkedin) ;
        update_user_meta( $user_id, 'fave_author_vimeo', $fave_agent_vimeo) ;
        update_user_meta( $user_id, 'fave_author_googleplus', $fave_agent_googleplus) ;
        update_user_meta( $user_id, 'fave_author_youtube', $fave_agent_youtube) ;
        update_user_meta( $user_id, 'fave_author_pinterest', $fave_agent_pinterest) ;
        update_user_meta( $user_id, 'fave_author_instagram', $fave_agent_instagram) ;
        update_user_meta( $user_id, 'fave_author_address', $fave_agent_address);
        update_user_meta( $user_id, 'url', $fave_agent_website) ;

        if( !empty($agent_agency)) {
            $fave_agent_company = get_the_title($agent_agency);
            update_user_meta( $user_id, 'fave_author_agency_id', $agent_agency);
        } else {
            update_user_meta( $user_id, 'fave_author_agency_id', '');
        }
        update_user_meta( $user_id, 'fave_author_company', $fave_agent_company) ;
        update_post_meta( $post_id, 'fave_agent_company', $fave_agent_company) ;

        $new_user_id = email_exists($email);
        if ($new_user_id) {

        } else {
            $args = array(
                'ID' => $user_id,
                'user_email' => $email
            );
            wp_update_user($args);
        }
    }
}
?>