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

class Houzez_Post_Type_Membership {
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
            'name'          => __( 'Packages','houzez-theme-functionality'),
            'singular_name' => __( 'Packages','houzez-theme-functionality'),
            'add_new'       => __('Add New Package','houzez-theme-functionality'),
            'add_new_item'          =>  __('Add Packages','houzez-theme-functionality'),
            'edit'                  =>  __('Edit Packages' ,'houzez-theme-functionality'),
            'edit_item'             =>  __('Edit Package','houzez-theme-functionality'),
            'new_item'              =>  __('New Packages','houzez-theme-functionality'),
            'view'                  =>  __('View Packages','houzez-theme-functionality'),
            'view_item'             =>  __('View Packages','houzez-theme-functionality'),
            'search_items'          =>  __('Search Packages','houzez-theme-functionality'),
            'not_found'             =>  __('No Packages found','houzez-theme-functionality'),
            'not_found_in_trash'    =>  __('No Packages found','houzez-theme-functionality'),
            'parent'                =>  __('Parent Package','houzez-theme-functionality')
        );
        
        $labels = apply_filters( 'houzez_post_type_packages_labels', $labels );

        register_post_type( 'houzez_packages',
            array(
                'labels' => $labels,
                'public' => false,
                'has_archive' => false,
                'show_ui' => true,
                'show_in_menu'        => false,
                'show_in_admin_bar'   => false,
                'rewrite' => array('slug' => 'package'),
                'supports' => array('title', 'page-attributes' ),
                'capability_type'    => 'post',
                'exclude_from_search'   => true,
                'can_export' => true,
                'menu_position' => 16,
                'menu_icon'=> 'dashicons-money',
                'show_in_rest'       => true,
                'rest_base'          => 'houzez_packages',
            )
        );
    }

}