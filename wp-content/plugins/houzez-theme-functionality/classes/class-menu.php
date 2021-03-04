<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Menu {

    public $slug = 'houzez-real-estate';
    public $capability = 'edit_posts';
    public static $instance;

    public function __construct() {

        add_action( 'admin_menu', array( $this, 'setup_menu' ) );
    }

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setup_menu() {

        $submenus = array();

        $menu_name = apply_filters('houzez_realestate_menu_label', esc_html__( 'Real Estate', 'houzez-theme-functionality' ));
        add_menu_page(
            $menu_name,
            $menu_name,
            $this->capability,
            $this->slug,
            '',
            HOUZEZ_PLUGIN_IMAGES_URL. 'houzez-icon.svg',
            '6'
        );

        $submenus['addnew'] = array(
            $this->slug,
            esc_html__( 'Add New Property', 'houzez-theme-functionality' ),
            esc_html__( 'New Property', 'houzez-theme-functionality' ),
            $this->capability,
            'post-new.php?post_type=property',
        );

        // Property post type taxonomies
        $taxonomies = get_object_taxonomies( 'property', 'objects' );
        foreach ( $taxonomies as $single_tax ) {
            $submenus[ $single_tax->name ] = array(
                $this->slug,
                $single_tax->labels->add_new_item,
                $single_tax->labels->name,
                $this->capability,
                'edit-tags.php?taxonomy=' . $single_tax->name . '&post_type=property',
            );
        }

        if(houzez_check_post_types_plugin('houzez_agencies_post')) {
            $submenus['houzez_agencies'] = array(
                $this->slug,
                esc_html__( 'Agencies', 'houzez-theme-functionality' ),
                esc_html__( 'Agencies', 'houzez-theme-functionality' ),
                $this->capability,
                'edit.php?post_type=houzez_agency',
            );
        }

        if(houzez_check_post_types_plugin('houzez_agents_post')) {
            $submenus['houzez_agents'] = array(
                $this->slug,
                esc_html__( 'Agents', 'houzez-theme-functionality' ),
                esc_html__( 'Agents', 'houzez-theme-functionality' ),
                $this->capability,
                'edit.php?post_type=houzez_agent',
            );
        }

        if(houzez_check_post_types_plugin('houzez_partners_post')) {
            $submenus['houzez_partners'] = array(
                $this->slug,
                esc_html__( 'Partners', 'houzez-theme-functionality' ),
                esc_html__( 'Partners', 'houzez-theme-functionality' ),
                $this->capability,
                'edit.php?post_type=houzez_partner',
            );
        }

        $submenus['houzez_reviews'] = array(
            $this->slug,
            esc_html__( 'Reviews', 'houzez-theme-functionality' ),
            esc_html__( 'Reviews', 'houzez-theme-functionality' ),
            $this->capability,
            'edit.php?post_type=houzez_reviews',
        );

        if(houzez_check_post_types_plugin('houzez_packages_post')) {
            $submenus['houzez_packages'] = array(
                $this->slug,
                esc_html__( 'Packages', 'houzez-theme-functionality' ),
                esc_html__( 'Packages', 'houzez-theme-functionality' ),
                $this->capability,
                'edit.php?post_type=houzez_packages',
            );
        }

        if(houzez_check_post_types_plugin('houzez_invoices_post')) {
            $submenus['houzez_invoice'] = array(
                $this->slug,
                esc_html__( 'Invoices', 'houzez-theme-functionality' ),
                esc_html__( 'Invoices', 'houzez-theme-functionality' ),
                $this->capability,
                'edit.php?post_type=houzez_invoice',
            );
        }


        if(houzez_check_post_types_plugin('houzez_packages_info_post')) {
            $submenus['user_packages'] = array(
                $this->slug,
                esc_html__( 'Packages Info', 'houzez-theme-functionality' ),
                esc_html__( 'Packages Info', 'houzez-theme-functionality' ),
                $this->capability,
                'edit.php?post_type=user_packages',
            );
        }

        // Add filter for third party scripts
        $submenus = apply_filters( 'houzez_admin_realestate_menu', $submenus );

        if ( $submenus ) {
            foreach ( $submenus as $sub_menu ) {
                call_user_func_array( 'add_submenu_page', $sub_menu );
            }
        } // end $submenus
    }

}