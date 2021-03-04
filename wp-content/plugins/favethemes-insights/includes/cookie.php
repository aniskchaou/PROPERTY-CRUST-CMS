<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists('FTI_Cookies') ) {
	class FTI_Cookies {

		private $path, $domain;

		public function __construct() {
			$this->path = COOKIEPATH ?: '/';
			$this->domain = COOKIE_DOMAIN;

			add_action( 'init', array( $this, 'set' ) );
			add_action( 'init', array( $this, 'get' ) );
		}

		public function set( $cookie_name, $value = '', $expires = 0, $secure = false, $httponly = false ) {
			if ( headers_sent() ) {
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			        headers_sent( $file, $line );
			        trigger_error( "{$cookie_name} cookie cannot be set - headers already sent by {$file} on line {$line}", E_USER_NOTICE );
			    }

			    return false;
			}

			setcookie( $cookie_name, $value, $expires, $this->path, $this->domain, $secure, $httponly );
		}

		public function get( $cookie_name ) {
			if ( ! isset( $_COOKIE[ $cookie_name ] ) ) {
				return false;
			}

			return $_COOKIE[ $cookie_name ];
		}

		public function delete( $cookie_name ) {
			if ( ! isset( $_COOKIE[ $cookie_name ] ) ) {
				return false;
			}

			unset( $_COOKIE[ $cookie_name ] );
			$this->set( $cookie_name, '', 1 );
		}
	}
}