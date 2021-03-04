<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 06/10/15
 * Time: 12:39 PM
 */

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
        add_action( 'init', array( __CLASS__, 'taxonomy' ) );
        add_action( 'save_post', array( __CLASS__, 'save_xyz_meta' ), 10, 3 );
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
        
    }

    public static function taxonomy() {

        
    }

    /**
     * Custom admin columns for post type
     *
     * @access public
     * @return array
     */
    public static function custom_columns() {
        
    }

    public static function houzez_get_agent_capabilities() {

    }

    /**
     * Custom admin columns implementation
     *
     * @access public
     * @param string $column
     * @return array
     */
    public static function custom_columns_manage( $column ) {
        
    }

    /**
     * Update agent user associated info when agent updated
     *
     * @access public
     * @return
     */
    public static function save_xyz_meta($post_id, $post, $update) {
    }

        
}
?>