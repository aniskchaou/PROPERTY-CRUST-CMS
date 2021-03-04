<?php
/**
 * Class Houzez_Post_Type_Agency
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 28/09/16
 * Time: 10:16 PM
 * Since v1.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Post_Type_Agency {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'save_post_houzez_agency', array( __CLASS__, 'save_agency_meta' ), 10, 3 );
        add_filter( 'manage_edit-houzez_agency_columns', array( __CLASS__, 'custom_columns' ) );
        add_action( 'manage_houzez_agency_posts_custom_column', array( __CLASS__, 'custom_columns_manage' ) );
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'               => __( 'Agencies', 'houzez-theme-functionality' ),
            'singular_name'      => __( 'Agency', 'houzez-theme-functionality' ),
            'add_new'            => __( 'Add New Agency', 'houzez-theme-functionality' ),
            'add_new_item'       => __( 'Add New Agency', 'houzez-theme-functionality' ),
            'edit_item'          => __( 'Edit Agency', 'houzez-theme-functionality' ),
            'new_item'           => __( 'New Agency', 'houzez-theme-functionality' ),
            'all_items'          => __( 'Agencies', 'houzez-theme-functionality' ),
            'view_item'          => __( 'View Agency', 'houzez-theme-functionality' ),
            'search_items'       => __( 'Search Agency', 'houzez-theme-functionality' ),
            'not_found'          => __( 'No agencies found', 'houzez-theme-functionality' ),
            'not_found_in_trash' => __( 'No agencies found in Trash', 'houzez-theme-functionality' ),
            'parent_item_colon'  => '',
            'menu_name'          => __( 'Agencies', 'houzez-theme-functionality' ),
        );

        $labels = apply_filters( 'houzez_post_type_agency_labels', $labels );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'supports'        => array( 'title', 'editor', 'thumbnail' ),
            'public'          => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'show_in_menu'        => false,
            'show_in_admin_bar'   => true,
            'capability_type' => 'post',
            'show_ui'         => true,
            'menu_position' => 15,
            'has_archive'     => true,
            'rewrite'         => array( 'slug' => houzez_get_agency_rewrite_slug() ),
            'categories'      => array(),
            'show_in_rest'       => true,
            'rest_base'          => 'agencies',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        );

        $args = apply_filters( 'houzez_post_type_agency_args', $args );

        register_post_type('houzez_agency',$args);
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
            'agency_id' 			=> esc_html__( 'Agency ID', 'houzez-theme-functionality' ),
            'title' 			=> esc_html__( 'Title', 'houzez-theme-functionality' ),
            'license' 		    => esc_html__( 'License', 'houzez-theme-functionality' ),
            'thumbnail' 		=> esc_html__( 'Thumbnail', 'houzez-theme-functionality' ),
            'email'      		=> esc_html__( 'E-mail', 'houzez-theme-functionality' ),
            'web'      		    => esc_html__( 'Web', 'houzez-theme-functionality' ),
            'phone'      		=> esc_html__( 'Phone', 'houzez-theme-functionality' ),
            'agents'         	=> esc_html__( 'Agents', 'houzez-theme-functionality' ),
            'author' 			=> esc_html__( 'Author', 'houzez-theme-functionality' ),
        );

        return $fields;
    }

    /**
     * Custom admin columns implementation
     *
     * @access public
     * @param string $column
     * @return array
     */
    public static function custom_columns_manage( $column ) {
        switch ( $column ) {
            case 'thumbnail':
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail( array(75,75), array(
                        'class'     => 'attachment-thumbnail attachment-thumbnail-small',
                    ) );
                } else {
                    echo '-';
                }
                break;
            case 'agency_id':
                echo get_the_ID();
                break;
            case 'license':
                $agency_licenses = get_post_meta( get_the_ID(),  'fave_agency_licenses', true );

                if ( ! empty( $agency_licenses ) ) {
                    echo esc_attr( $agency_licenses );
                } else {
                    echo '-';
                }
                break;
            case 'email':
                $email = get_post_meta( get_the_ID(),  'fave_agency_email', true );

                if ( ! empty( $email ) ) {
                    echo esc_attr( $email );
                } else {
                    echo '-';
                }
                break;
            case 'web':
                $web = get_post_meta( get_the_ID(), 'fave_agency_web', true );

                if ( ! empty( $web ) ) {
                    echo esc_attr( $web );
                } else {
                    echo '-';
                }
                break;
            case 'phone':
                $phone = get_post_meta( get_the_ID(), 'fave_agency_phone', true );

                if ( ! empty( $phone ) ) {
                    echo esc_attr( $phone );
                } else {
                    echo '-';
                }
                break;
            case 'agents':

                if( class_exists('Houzez_Query')) {
                    $agencys_count = Houzez_Query::get_agency_agents( $post_id = get_the_ID() )->post_count;
                    echo esc_attr( $agencys_count );
                }
                break;
        }
    }

    /**
     * Update agency user associated info when agency updated
     *
     * @access public
     * @return
     */
    public static function save_agency_meta($post_id, $post, $update) {

        if (!is_object($post) || !isset($post->post_type)) {
            return;
        }

        $slug = 'houzez_agency';
        // If this isn't a 'book' post, don't update it.
        if ($slug != $post->post_type) {
            return;
        }

        if (!isset($_POST['fave_agency_email'])) {
            return;
        }

        $allowed_html = array();
        $user_id = get_post_meta( $post_id, 'houzez_user_meta_id', true );
        $email = wp_kses($_POST['fave_agency_email'], $allowed_html);
        $fave_agency_mobile = wp_kses($_POST['fave_agency_mobile'], $allowed_html);
        $fave_agency_whatsapp = wp_kses($_POST['fave_agency_whatsapp'], $allowed_html);
        $fave_agency_phone = wp_kses($_POST['fave_agency_phone'], $allowed_html);
        $fave_agency_fax = wp_kses($_POST['fave_agency_fax'], $allowed_html);
        $fave_agency_language = wp_kses($_POST['fave_agency_language'], $allowed_html);
        $fave_agency_license = wp_kses($_POST['fave_agency_licenses'], $allowed_html);
        $fave_agency_tax_no = wp_kses($_POST['fave_agency_tax_no'], $allowed_html);
        $fave_agency_website = wp_kses($_POST['fave_agency_web'], $allowed_html);
        $fave_agency_facebook = wp_kses($_POST['fave_agency_facebook'], $allowed_html);
        $fave_agency_twitter = wp_kses($_POST['fave_agency_twitter'], $allowed_html);
        $fave_agency_linkedin = wp_kses($_POST['fave_agency_linkedin'], $allowed_html);
        $fave_agency_googleplus = wp_kses($_POST['fave_agency_googleplus'], $allowed_html);
        $fave_agency_youtube = wp_kses($_POST['fave_agency_youtube'], $allowed_html);
        $fave_agency_instagram = wp_kses($_POST['fave_agency_instagram'], $allowed_html);
        $fave_agency_pinterest = wp_kses($_POST['fave_agency_pinterest'], $allowed_html);
        $fave_agency_vimeo = wp_kses($_POST['fave_agency_vimeo'], $allowed_html);
        $fave_agency_address = wp_kses($_POST['fave_agency_address'], $allowed_html);
        $fave_agency_map_address = wp_kses($_POST['fave_agency_map_address'], $allowed_html);
        $fave_agency_location = wp_kses($_POST['fave_agency_location'], $allowed_html);

        $lat_lng = explode(',', $fave_agency_location);

        $image_id = get_post_thumbnail_id($post_id);
        $full_img = wp_get_attachment_image_src($image_id, 'houzez-image350_350');

        update_user_meta( $user_id, 'aim', '/'.$full_img[0].'/');
        update_user_meta( $user_id, 'fave_author_title' , $post->post_title);
        update_user_meta( $user_id, 'fave_author_phone' , $fave_agency_phone);
        update_user_meta( $user_id, 'fave_author_language' , $fave_agency_language);
        update_user_meta( $user_id, 'fave_author_license' , $fave_agency_license);
        update_user_meta( $user_id, 'fave_author_tax_no' , $fave_agency_tax_no);
        update_user_meta( $user_id, 'fave_author_fax' , $fave_agency_fax);
        update_user_meta( $user_id, 'fave_author_mobile' , $fave_agency_mobile);
        update_user_meta( $user_id, 'fave_author_whatsapp' , $fave_agency_whatsapp) ;
        update_user_meta( $user_id, 'description' , $post->post_content);
        update_user_meta( $user_id, 'fave_author_custom_picture', $full_img[0]);
        update_user_meta( $user_id, 'fave_author_facebook', $fave_agency_facebook);
        update_user_meta( $user_id, 'fave_author_twitter', $fave_agency_twitter);
        update_user_meta( $user_id, 'fave_author_linkedin', $fave_agency_linkedin);
        update_user_meta( $user_id, 'fave_author_vimeo', $fave_agency_vimeo);
        update_user_meta( $user_id, 'fave_author_googleplus', $fave_agency_googleplus);
        update_user_meta( $user_id, 'fave_author_youtube', $fave_agency_youtube);
        update_user_meta( $user_id, 'fave_author_pinterest', $fave_agency_pinterest);
        update_user_meta( $user_id, 'fave_author_instagram', $fave_agency_instagram);
        update_user_meta( $user_id, 'fave_author_address', $fave_agency_address);
        update_user_meta( $user_id, 'fave_author_google_location', $fave_agency_map_address);
        update_user_meta( $user_id, 'fave_author_google_latitude', $lat_lng[0]);
        update_user_meta( $user_id, 'fave_author_google_longitude', $lat_lng[1]);
        update_user_meta( $user_id, 'url', $fave_agency_website);

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