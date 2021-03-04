<?php
/**
 * Filters the image quality for thumbnails to be at the highest ratio possible.
 *
 * Supports the new 'wp_editor_set_quality' filter added in WP 3.5.
 *
 *
 * @package WordPress
 * @subpackage Houzez
 * @since Houzez 1.5.0
 */


if ( ! function_exists('houzez_image_full_quality') ) {
	function houzez_image_full_quality( $quality ) {
		if ( !houzez_option( 'jpeg_100' ) ) {
			$quality = 100;
		} else {
			$quality = 100;
		}
		return apply_filters( 'houzez_jpeg_quality', $quality );
	}
}
add_filter( 'jpeg_quality', 'houzez_image_full_quality' );
add_filter( 'wp_editor_set_quality', 'houzez_image_full_quality' );