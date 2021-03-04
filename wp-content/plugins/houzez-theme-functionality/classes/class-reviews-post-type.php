<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Post_Type_Reviews {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'save_post_houzez_reviews', array( __CLASS__, 'save_reviews_meta' ), 10, 3 );
        /*add_filter( 'manage_edit-houzez_agent_columns', array( __CLASS__, 'custom_columns' ) );
        add_action( 'manage_houzez_agent_posts_custom_column', array( __CLASS__, 'custom_columns_manage' ) );*/
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name' => __( 'Reviews','houzez-theme-functionality'),
            'singular_name' => __( 'Review','houzez-theme-functionality' ),
            'add_new' => __('Add New','houzez-theme-functionality'),
            'add_new_item' => __('Add New Review','houzez-theme-functionality'),
            'edit_item' => __('Edit Review','houzez-theme-functionality'),
            'new_item' => __('New Review','houzez-theme-functionality'),
            'view_item' => __('View Review','houzez-theme-functionality'),
            'search_items' => __('Search Review','houzez-theme-functionality'),
            'not_found' =>  __('No Review found','houzez-theme-functionality'),
            'not_found_in_trash' => __('No Review found in Trash','houzez-theme-functionality'),
            'parent_item_colon' => ''
        );

        $labels = apply_filters( 'houzez_post_type_review_labels', $labels );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'show_in_menu'        => false,
            'show_in_admin_bar'   => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'query_var' => false,
            'has_archive' => false,
            'capability_type' => 'post',
            'hierarchical' => true,
            'can_export' => true,
            'menu_position' => 15,
            'supports' => array('title','editor','revisions', 'author'),
            'show_in_rest'       => true,
            'rest_base'          => 'houzez_reviews',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'rewrite' => array( 'slug' => 'reviews' )
        );

        $args = apply_filters( 'houzez_post_type_review_args', $args );

        register_post_type('houzez_reviews',$args);
    }

    /**
     * Custom admin columns for post type
     *
     * @access public
     * @return array
     */
    public static function custom_columns() {
        $fields = array(
            'cb'                => '<input type="checkbox" />',
            'agent_id'          => esc_html__( 'Agent ID', 'houzez-theme-functionality' ),
            'title'             => esc_html__( 'Agent Name', 'houzez-theme-functionality' ),
            'agent_thumbnail'       => esc_html__( 'Picture', 'houzez-theme-functionality' ),
            'category'          => esc_html__( 'Category', 'houzez-theme-functionality' ),
            'email'             => esc_html__( 'E-mail', 'houzez-theme-functionality' ),
            'web'               => esc_html__( 'Web', 'houzez-theme-functionality' ),
            'mobile'            => esc_html__( 'Mobile', 'houzez-theme-functionality' ),
        );

        return $fields;
    }

    /**
     * Update post meta associated info when post updated
     *
     * @access public
     * @return
     */
    public static function save_reviews_meta($post_id, $post, $update) {

        if (!is_object($post) || !isset($post->post_type)) {
            return;
        }

        if (isset($post->post_status) && 'auto-draft' == $post->post_status) return;

        if ( wp_is_post_revision( $post_id ) ) return;

        $post_type = get_post_type($post_id);

        if ( "houzez_reviews" != $post_type ) return;
        
        $review_id = isset($_POST['post_ID']) ? $_POST['post_ID'] : '';
        
        if(!empty($review_id)) {
            houzez_admin_review_meta_on_save($review_id, $_POST);
        }

        return;
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
            /*case 'agents':
                $agents_count = Houzez_Query::get_agency_agents( $post_id = get_the_ID() )->post_count;
                echo esc_attr( $agents_count );
                break;*/
        }
    }

}
?>