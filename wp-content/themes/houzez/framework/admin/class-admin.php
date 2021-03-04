<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Admin {

    public static $instance;
    private $template_path = HOUZEZ_FRAMEWORK . 'admin/';

    public function __construct() {

        add_action( 'admin_menu', array( $this, 'houzez_register_admin_pages' ) );
        add_action( 'admin_menu', array( $this, 'remove_parent_menu' ) );
        add_action('wp_ajax_houzez_plugin_installation', array( __CLASS__, 'houzez_plugin_installation'));
        add_action('wp_ajax_houzez_plugin_activate', array( __CLASS__, 'houzez_plugin_activate'));
        add_action('wp_ajax_houzez_feedback', array( $this, 'houzez_feedback'));

        // https://github.com/elementor/elementor/issues/6022
		add_action( 'admin_init', function() {
			if ( did_action( 'elementor/loaded' ) ) {
				remove_action( 'admin_init', [ \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ] );
			}
		}, 1 );
    }

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

	public function houzez_register_admin_pages() {
    	$sub_menus = array();

        add_menu_page(
            esc_html__( 'Houzez', 'houzez' ),
            esc_html__( 'Houzez', 'houzez' ),
            'manage_options',
            'houzez_dashboard',
            '',
            HOUZEZ_IMAGE.'houzez-icon.svg',
            '5'
        );

        $sub_menus['plugins'] = array(
            'houzez_dashboard',
            esc_html__( 'Plugins', 'houzez' ),
            esc_html__( 'Plugins', 'houzez' ),
            'manage_options',
            'houzez_plugins',
            array( $this, 'plugins' ),
        );

        if( class_exists('Houzez') ) {
	        $sub_menus['houzez_fbuilder'] = array( 
	            'houzez_dashboard', 
	            esc_html__( 'Fields builder', 'houzez' ),
	            esc_html__( 'Fields builder', 'houzez' ),
	            'manage_options', 
	            'houzez_fbuilder', 
	            array( 'Houzez_Fields_Builder', 'render' )
	        );

	        $sub_menus['houzez_currencies'] = array(
	            'houzez_dashboard',
	            esc_html__( 'Currencies', 'houzez' ),
	            esc_html__( 'Currencies', 'houzez' ),
	            'manage_options',
	            'houzez_currencies',
	            array( 'Houzez_Currencies', 'render' )
	        );

	        $sub_menus['fcc_api_settings'] = array(
	            'houzez_dashboard',
	            esc_html__( 'Currency Switcher', 'houzez' ),
	            esc_html__( 'Currency Switcher', 'houzez' ),
	            'manage_options',
	            'fcc_api_settings',
	            array( 'FCC_API_Settings', 'render' )
	        );

	        $sub_menus['houzez_post_types'] = array(
	            'houzez_dashboard',
	            esc_html__( 'Post Types', 'houzez' ),
	            esc_html__( 'Post Types', 'houzez' ),
	            'manage_options',
	            'houzez_post_types',
	            array( 'Houzez_Post_Type', 'render' )
	        );

	        $sub_menus['houzez_taxonomies'] = array(
	            'houzez_dashboard',
	            esc_html__( 'Taxonomies', 'houzez' ),
	            esc_html__( 'Taxonomies', 'houzez' ),
	            'manage_options',
	            'houzez_taxonomies',
	            array( 'Houzez_Taxonomies', 'render' )
	        );

	        $sub_menus['houzez_permalinks'] = array(
	            'houzez_dashboard',
	            esc_html__( 'Permalinks', 'houzez' ),
	            esc_html__( 'Permalinks', 'houzez' ),
	            'manage_options',
	            'houzez_permalinks',
	            array( 'Houzez_Permalinks', 'render' )
	        );
	    }

	    // Add filter for third party uses
        $sub_menus = apply_filters( 'houzez_admin_sub_menus', $sub_menus, 20 );


        $sub_menus['documentation'] = array(
            'houzez_dashboard',
            esc_html__( 'Documentation', 'houzez' ),
            esc_html__( 'Documentation', 'houzez' ),
            'manage_options',
            'houzez_help',
            array( $this, 'documentation' ),
        );

        $sub_menus['feedback'] = array(
            'houzez_dashboard',
            esc_html__( 'Feedback', 'houzez' ),
            esc_html__( 'Feedback', 'houzez' ),
            'manage_options',
            'houzez_feedback',
            array( $this, 'feedback' ),
        );

		if ( class_exists( 'OCDI_Plugin' ) && class_exists('Houzez') && houzez_theme_verified() ) {
			$sub_menus['demo_import'] = array(
				'houzez_dashboard',
				esc_html__( 'Demo Import', 'houzez' ),
				esc_html__( 'Demo Import', 'houzez' ),
				'manage_options',
				'admin.php?page=houzez-one-click-demo-import',
			);
		}

        if ( $sub_menus ) {
            foreach ( $sub_menus as $sub_menu ) {
                call_user_func_array( 'add_submenu_page', $sub_menu );
            }
        }
	}

	public static function houzez_plugin_installation() {
		check_ajax_referer( 'houzez-admin-nonce' );

		$status = array();
		$download_link = null;
		$plugin_source = isset( $_POST['plugin_source'] ) ? $_POST['plugin_source'] : '';
		$plugin_slug = isset( $_POST['plugin_slug'] ) ? $_POST['plugin_slug'] : '';

		include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );

		// Check if current user have permission to install plugin or not
		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error();
		}

		if( empty($plugin_slug) ) {
			wp_send_json_error();
		}

		// Retrieves plugin installer pages from the WordPress.org Plugins API.
		$plugin_api = plugins_api(
			'plugin_information',
			array(
				'slug' => sanitize_key( wp_unslash( $plugin_slug ) ),
			)
		);
		
		if ( ! empty( $plugin_source ) ) {

			$download_link = esc_url( $plugin_source );

		} else {
			if ( is_wp_error( $plugin_api ) ) {
				wp_send_json_error();
			}
			$download_link        = $plugin_api->download_link;
		}

		$skin     = new WP_Ajax_Upgrader_Skin();
		$upgrader = new Plugin_Upgrader( $skin );
		$response = $upgrader->install( $download_link );

		if ( is_wp_error( $response ) ) {
			$status['errorCode']    = $response->get_error_code();
			$status['errorMessage'] = $response->get_error_message();
			wp_send_json_error( $status );
		} else {
			wp_send_json_success();
		}
		
		
	}

	public static function houzez_plugin_activate() {
	    check_ajax_referer( 'houzez-admin-nonce' );

	    $error = array();
	    $plugin_file = isset( $_POST['plugin_file'] ) ? $_POST['plugin_file'] : '';

	    if( empty($plugin_file) ) {
	    	wp_send_json_error();
	    }

		$response  = activate_plugin( $plugin_file );
		if ( is_wp_error( $response ) ) {
			$error['errorMessage'] = $response->get_error_message();
			wp_send_json_error( $error );
		} else {
			wp_send_json_success();
		}
	}

	public function houzez_feedback() {

		$headers   = array();
		$current_user = wp_get_current_user();

		$target_email   = is_email("houzez@favethemes.com");
		$website        = get_bloginfo( 'name' );
		$site_url       = network_site_url( '/' );
		$sender_name    = $current_user->display_name;
		$sender_email   = sanitize_email( $_POST['email'] );
		$sender_email   = is_email( $sender_email ); 
		$sender_subject = sanitize_text_field( $_POST['subject'] );
		$message        = stripslashes( $_POST['message'] );

		$nonce = $_POST['feedback_nonce'];
        if (!wp_verify_nonce( $nonce, 'houzez_feedback_security') ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Invalid Nonce!', 'houzez')
            ));
            wp_die();
        }

		if (!$sender_email) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Email address is Invalid!', 'houzez')
            ));
            wp_die();
        }

        if ( empty($message) ) {
            echo json_encode(array(
                'success' => false,
                'msg' => esc_html__('Your message is empty!', 'houzez')
            ));
            wp_die();
        }

        $subject = sprintf( esc_html__('New Feedback by %s from %s', 'houzez'), $sender_name, $website );

        $body = esc_html__("You have received new message from: ", 'houzez') . $sender_name . " <br/>";

        if ( ! empty( $website ) ) {
            $body .= esc_html__( "Website : ", 'houzez' ) . '<a href="' . esc_url( $site_url ) . '" target="_blank">' . $website . "</a><br/><br/>";
        }

        if ( ! empty( $sender_subject ) ) {
            $body .= esc_html__( "Subject : ", 'houzez' ) .$sender_subject. "<br/>";
        }

        $body .= "<br/>" . esc_html__("Message:", 'houzez') . " <br/>";
        $body .= wpautop( $message ) . " <br/>";
        $body .= sprintf( esc_html__( 'You can contact %s via email %s', 'houzez'), $sender_name, $sender_email );

		$headers[] = "Reply-To: $sender_name <$sender_email>";
		$headers[] = "Content-Type: text/html; charset=UTF-8";
		$headers   = apply_filters( "houzez_feedback_mail_header", $headers ); 

		if ( wp_mail( $target_email, $subject, $body, $headers ) ) {
            echo json_encode( array(
                'success' => true,
                'msg' => esc_html__("Thank you for your feedback!", 'houzez')
            ));
        } else {
            echo json_encode(array(
                    'success' => false,
                    'msg' => esc_html__("Server Error: Make sure Email function working on your server!", 'houzez')
                )
            );
        }
        wp_die();
	}


	public function documentation() {
		require_once $this->template_path . 'documentation.php';
	}

	public function plugins() {
		require_once $this->template_path . 'plugins.php';
	}

	public function feedback() {
		require_once $this->template_path . 'feedback.php';
	}

	public function remove_parent_menu() {
		global $submenu;
		unset( $submenu['houzez_dashboard'][0] );
	}

}

return Houzez_Admin::instance();