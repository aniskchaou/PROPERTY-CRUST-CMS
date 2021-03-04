<?php
/*
Plugin Name: Houzez Login Register
Plugin URI:  http://themeforest.net/user/favethemes
Description: Adds login register functionality for houzez theme
Version:     2.3.1
Author:      Favethemes
Author URI:  http://themeforest.net/user/favethemes
License:     GPL2
*/

class Houzez_login_register {

	/**
     * Constructor
     *
     * @since 1.0
     *
    */
    public function __construct() {
        $this->houzez_login_constants();
    	$this->houzez_login_inc_files();
        $this->setup_actions();
    }

    /**
     * Define constants
     *
     * @since 1.0
     *
    */
    protected function houzez_login_constants() {

        /**
         * Plugin Path
         */
        define( 'HOUZEZ_LOGIN_FUNC_PATH', plugin_dir_path( __FILE__ ) );

    }

    /**
     * include files
     *
     * @since 1.0
     *
    */
    function houzez_login_inc_files() {

        //Login Register
        require_once( HOUZEZ_LOGIN_FUNC_PATH . 'functions/login_register.php');
        require_once( HOUZEZ_LOGIN_FUNC_PATH . 'functions/social_login.php');
        require_once( HOUZEZ_LOGIN_FUNC_PATH . 'functions/roles.php');
        require_once( HOUZEZ_LOGIN_FUNC_PATH . 'functions/roles-functions.php');

    }

    /**
     * Sets up initial actions.
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function setup_actions() {

        // Internationalize the text strings used.
        add_action( 'plugins_loaded', array( $this, 'houzez_i18n' ), 2 );

        // Register activation hook.
        register_deactivation_hook( __FILE__, array( &$this, 'role_delete' ) );
    }

    /**
     * Callback function WP plugin_loaded action hook. Loads lang
     *
     * @since  1.0
     * @access public
     */
    public function houzez_i18n() {
        load_plugin_textdomain( 'houzez-login-register', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    


    /**
     * Method that runs only when the plugin is activated.
     *
     * @since  1.0.0
     * @access public
     * @global $wpdb
     * @return void
     */
    public function role_delete() {
        remove_role( 'houzez_agent' );
        remove_role( 'houzez_buyer' );
        remove_role( 'houzez_agency' );
        remove_role( 'houzez_seller' );
        remove_role( 'houzez_manager' );
        remove_role( 'houzez_owner' );
    }

}

/**
 * Instantiate the Class
 *
 * @since     1.0
 * @global    object
 */
$Houzez_login_register = new Houzez_login_register();
?>