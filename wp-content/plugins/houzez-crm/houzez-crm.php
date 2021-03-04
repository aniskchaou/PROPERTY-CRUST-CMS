<?php
/*
Plugin Name: Houzez CRM
Plugin URI:  http://themeforest.net/user/favethemes
Description: Add insights for favethemes themes
Version:     1.2.3
Author:      Favethemes
Author URI:  http://themeforest.net/user/favethemes
*/


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Houzez_CRM' ) ) :

    final class Houzez_CRM {

        /**
         * Plugin's current version
         *
         * @var string
         */
        public $version;

        /**
         * Plugin Name
         *
         * @var string
         */
        public $plugin_name;

        /**
         * Plugin's instance.
         *
         * @var Houzez_CRM
         */
        protected static $_instance;

        /**
         * Constructor function.
         */
        public function __construct() {

            $this->plugin_name = 'houzez-crm';
            $this->version     = '1.0.0';

            $this->define_constants();

            $this->initialize_admin_menu();

            $this->include_files();

            $this->init_hooks();

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

            do_action( 'houzez_crm_loaded' );  // Houzez CRM plugin action hook loaded
        }

        /**
         * Provides instance.
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Defines constants.
         */
        protected function define_constants() {

            if ( ! defined( 'HOUZEZ_CRM_VERSION' ) ) {
                define( 'HOUZEZ_CRM_VERSION', $this->version );
            }

            if ( ! defined( 'HOUZEZ_CRM_PLUGIN_FILE' ) ) {
                define( 'HOUZEZ_CRM_PLUGIN_FILE', __FILE__ );
            }

            if ( ! defined( 'HOUZEZ_CRM_DIR' ) ) {
                define( 'HOUZEZ_CRM_DIR', plugin_dir_path( __FILE__ ) );
            }

            if ( ! defined( 'HOUZEZ_CRM_URL' ) ) {
                define( 'HOUZEZ_CRM_URL', plugin_dir_url( __FILE__ ) );
            }

            if ( ! defined( 'HOUZEZ_CRM_BASENAME' ) ) {
                define( 'HOUZEZ_CRM_BASENAME', plugin_basename( __FILE__ ) );
            }

        }

        /**
         * Enqueue Scripts
         */
        public function enqueue_scripts() {

            if(self::houzez_is_crm_page()) {

                $houzez_date_language = houzez_option('houzez_date_language');
                $houzez_date_language = esc_html($houzez_date_language);

                if (function_exists('icl_translate')) {
                    $houzez_date_language = ICL_LANGUAGE_CODE;
                }
                wp_enqueue_script( 'houzez-crm-script', HOUZEZ_CRM_URL . 'js/script.js', 'jquery', $this->version, true );

                $locals = array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'processing_text' => esc_html__('Processing, Please wait...', 'houzez-crm'),
                    'are_you_sure_text' => esc_html__('Are you sure you want to do this?', 'houzez-crm'),
                    'delete_btn_text' => esc_html__('Delete', 'houzez-crm'),
                    'cancel_btn_text' => esc_html__('Cancel', 'houzez-crm'),
                    'confirm_btn_text' => esc_html__('Confirm', 'houzez-crm'),
                    'houzez_date_language' => $houzez_date_language,
                    'delete_confirmation' => esc_html__('Are you sure you want to delete?', 'houzez-crm'),
                    'email_confirmation' => esc_html__('Are you sure you want to send email?', 'houzez-crm'),
                );
                wp_localize_script( 'houzez-crm-script', 'Houzez_crm_vars', $locals ); 
            }
        }

        public static function houzez_is_crm_page() {
            if ( is_page_template( array(
                'template/user_dashboard_crm.php'
            ) ) ) {
                return true;
            }
            return false;
        }

        /**
         * Functions
         */
        public function include_files() {
            include_once( HOUZEZ_CRM_DIR . 'includes/settings/settings-init.php' ); 
            include_once( HOUZEZ_CRM_DIR . 'includes/class-activities.php' ); 
            include_once( HOUZEZ_CRM_DIR . 'includes/class-notes.php' ); 
            include_once( HOUZEZ_CRM_DIR . 'includes/class-leads.php' ); 
            include_once( HOUZEZ_CRM_DIR . 'includes/class-enquiry.php' ); 
            include_once( HOUZEZ_CRM_DIR . 'includes/class-collect-form-data.php' ); 
            include_once( HOUZEZ_CRM_DIR . 'includes/class-deals.php' ); 
            include_once( HOUZEZ_CRM_DIR . 'includes/class-viewed.php' ); 
            include_once( HOUZEZ_CRM_DIR . 'includes/functions.php' ); 
        }


        /**
         * Admin menu.
         */
        public function initialize_admin_menu() {
            
        }

        /**
         * Initialize hooks.
         */
        public function init_hooks() {
            add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
            register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
            register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivate' ) );
        }

        /**
         * Load text domain for translation.
         */
        public function load_plugin_textdomain() {
            load_plugin_textdomain( 'houzez-crm', false, dirname( HOUZEZ_CRM_BASENAME ) . '/languages' );
        }

        /**
         * plugin activation
         */
        public function plugin_activation() {

            global $wpdb;

            require_once ABSPATH . 'wp-admin/includes/upgrade.php';

            $charset_collate    = $wpdb->get_charset_collate();

            $table_name         = $wpdb->prefix . 'houzez_crm_leads';
            $sql = "CREATE TABLE $table_name (
                lead_id bigint(25) unsigned NOT NULL AUTO_INCREMENT,
                user_id bigint(25) unsigned NOT NULL DEFAULT '0',
                prefix varchar(20),
                display_name varchar(150),
                first_name varchar(150),
                last_name varchar(150),
                email varchar(200) NOT NULL,
                mobile varchar(200),
                home_phone varchar(200),
                work_phone varchar(200),
                address text,
                city varchar(100),
                state varchar(100),
                country varchar(255),
                zipcode varchar(150),
                type varchar(200),
                status varchar(200),
                source varchar(200),
                source_link varchar(200),
                enquiry_to bigint(200),
                enquiry_user_type varchar(150),
                twitter_url text,
                linkedin_url text,
                facebook_url text,
                private_note text,
                message text,
                time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                PRIMARY KEY  (lead_id)
            ) $charset_collate;";
            dbDelta( $sql );

            $table_name         = $wpdb->prefix . 'houzez_crm_enquiries';
            $sql = "CREATE TABLE $table_name (
                enquiry_id bigint(25) unsigned NOT NULL AUTO_INCREMENT,
                user_id bigint(25) unsigned NOT NULL DEFAULT '0',
                lead_id bigint(25) unsigned NOT NULL DEFAULT '0',
                listing_id bigint(25) unsigned NOT NULL DEFAULT '0',
                negotiator varchar(200),
                source varchar(200),
                status varchar(200),
                enquiry_to bigint(25),
                enquiry_user_type varchar(150),
                message text,
                enquiry_type varchar(200),
                enquiry_meta LONGTEXT,
                private_note text,
                time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                PRIMARY KEY  (enquiry_id)
            ) $charset_collate;";
            dbDelta( $sql );

            $table_name         = $wpdb->prefix . 'houzez_crm_deals';
            $sql = "CREATE TABLE $table_name (
                deal_id bigint(25) unsigned NOT NULL AUTO_INCREMENT,
                user_id bigint(25) unsigned NOT NULL DEFAULT '0',
                title varchar(200),
                listing_id bigint(25) unsigned NOT NULL DEFAULT '0',
                lead_id bigint(25) unsigned NOT NULL DEFAULT '0',
                agent_id bigint(25) unsigned NOT NULL DEFAULT '0',
                agent_type varchar(200),
                status varchar(200),
                next_action varchar(200),
                action_due_date datetime DEFAULT '0000-00-00 00:00' NOT NULL,
                deal_value varchar(200),
                last_contact_date datetime DEFAULT '0000-00-00 00:00' NOT NULL,
                private_note text,
                deal_group varchar(200),
                time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                PRIMARY KEY  (deal_id)
            ) $charset_collate;";
            dbDelta( $sql );

            $table_name         = $wpdb->prefix . 'houzez_crm_viewed_listings';
            $sql = "CREATE TABLE $table_name (
                id bigint(25) unsigned NOT NULL AUTO_INCREMENT,
                user_id bigint(25),
                listing_id bigint(25) unsigned NOT NULL DEFAULT '0',
                time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";
            dbDelta( $sql );

            $table_name         = $wpdb->prefix . 'houzez_crm_activities';
            $sql = "CREATE TABLE $table_name (
                activity_id bigint(25) unsigned NOT NULL AUTO_INCREMENT,
                user_id bigint(25) unsigned NOT NULL DEFAULT '0',
                meta text,
                time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                PRIMARY KEY  (activity_id)
            ) $charset_collate;";
            dbDelta( $sql );

            $table_name         = $wpdb->prefix . 'houzez_crm_notes';
            $sql = "CREATE TABLE $table_name (
                note_id bigint(25) unsigned NOT NULL AUTO_INCREMENT,
                user_id bigint(25) unsigned NOT NULL DEFAULT '0',
                belong_to bigint(25) unsigned NOT NULL DEFAULT '0',
                note text,
                type varchar(200),
                time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                PRIMARY KEY  (note_id)
            ) $charset_collate;";
            dbDelta( $sql );
            
        }


        /**
         * plugin de-activation
         */
        public function plugin_deactivate() {

        }

        /**
         * Unserializing is forbidden.
         */
        public function __wakeup() {
            _doing_it_wrong( __FUNCTION__, __( 'Not good; huh?', 'houzez-crm' ), HOUZEZ_CRM_VERSION );
        }


        /**
         * Cloning is forbidden.
         */
        public function __clone() {
            _doing_it_wrong( __FUNCTION__, __( 'Not good; huh?', 'houzez-crm' ), HOUZEZ_CRM_VERSION );
        }

    }

endif; // End class_exists check.


/**
 * Instance of Houzez_CRM.
 * @return Houzez_CRM
 */
function HCRM_I() {
    return Houzez_CRM::instance();
}
HCRM_I();