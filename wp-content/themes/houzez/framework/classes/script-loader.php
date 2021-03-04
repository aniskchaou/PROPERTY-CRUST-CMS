<?php
/**
 * Javascript Loader Class
 *
 * Allow `async` and `defer` while enqueuing Javascript.
 *
 * Based on a solution in WP Rig.
 * @since 2.0
 */

if ( ! class_exists( 'Houzez_Script_Loader' ) ) {
	
	class Houzez_Script_Loader {

		/**
		 * Adds async/defer attributes to enqueued / registered scripts.
		 *
		 * @param string $tag    The script tag.
		 * @param string $handle The script handle.
		 * @return string Script HTML string.
		 */
		public function filter_script_loader_tag( $tag, $handle ) {
			foreach ( [ 'async', 'defer' ] as $attr ) {
				if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
					continue;
				}
				if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
					$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
				}
				break;
			}
			return $tag;
		}

	}
}
