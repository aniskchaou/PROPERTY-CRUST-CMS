<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 07/01/16
 * Time: 6:41 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Post_Type_Partner {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name' => __( 'Partners','houzez-theme-functionality'),
            'singular_name' => __( 'Partner','houzez-theme-functionality' ),
            'add_new' => __('Add New','houzez-theme-functionality'),
            'add_new_item' => __('Add New Partner','houzez-theme-functionality'),
            'edit_item' => __('Edit Partner','houzez-theme-functionality'),
            'new_item' => __('New Partner','houzez-theme-functionality'),
            'view_item' => __('View Partner','houzez-theme-functionality'),
            'search_items' => __('Search Partner','houzez-theme-functionality'),
            'not_found' =>  __('No Partner found','houzez-theme-functionality'),
            'not_found_in_trash' => __('No Partner found in Trash','houzez-theme-functionality'),
            'parent_item_colon' => ''
        );

        $labels = apply_filters( 'houzez_post_type_partners_labels', $labels );

        $args = array(
            'labels' => $labels,
            'public' => false,
            'has_archive' => false,
            'show_in_menu'        => false,
            'show_in_admin_bar'   => true,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_icon' => 'dashicons-awards',
            'menu_position' => 22,
            'supports' => array('title','page-attributes','thumbnail','revisions'),
            'rewrite' => array( 'slug' => 'partner' )
        );

        register_post_type('houzez_partner',$args);
    }

}