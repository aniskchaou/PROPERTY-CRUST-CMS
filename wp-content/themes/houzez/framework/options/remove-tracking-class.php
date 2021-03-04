<?php
/**
 * Overrides the default Redux Tracking Class
 *
 * @package	Houzez
 * @author Waqas Riaz
 * @copyright Copyright (c) 2016, Favethemes
 * @link http://www.favethemes.com
 * @since Houzez 1.0
*/


if ( class_exists( 'ReduxFramework' ) ) {
	return;
}
class Redux_Tracking {
	public $options = array();
	public $parent;
	private static $instance = null;
	public static function get_instance() {
		if ( null == self::$instance ) {self::$instance = new self;}
		return self::$instance;
	}
	function __construct() {}
	public function load( $parent ) {}
	function _enqueue_tracking() {}
	function _enqueue_newsletter() {}
	function tracking_request() {}
	function newsletter_request() {}
	function print_scripts( $selector, $options, $button1, $button2 = false, $button2_function = '', $button1_function = '' ) { ?>
	<?php
	}
	function tracking() { }
}
Redux_Tracking::get_instance();