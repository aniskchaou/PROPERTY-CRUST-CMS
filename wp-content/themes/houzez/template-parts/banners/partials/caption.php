<?php
global $post;
$header_title = get_post_meta($post->ID, 'fave_page_header_title', true);
$header_subtitle = get_post_meta($post->ID, 'fave_page_header_subtitle', true);

if(!empty($header_title)) {
	echo '<h2 class="banner-title">'.esc_attr($header_title).'</h2>';
}

if(!empty($header_subtitle)) {
	echo '<p class="banner-subtitle">'.esc_attr($header_subtitle).'</p>';
} 
?>