<?php
global $post;
$booking_shortcode = get_post_meta($post->ID, 'fave_booking_shortcode', true);

if(!empty($booking_shortcode)) {

	echo do_shortcode($booking_shortcode);
}