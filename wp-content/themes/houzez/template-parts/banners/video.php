<?php
global $post, $homey_prefix;

$mp4 = get_post_meta($post->ID, 'fave_page_header_bg_mp4', true);
$webm = get_post_meta($post->ID, 'fave_page_header_bg_webm', true);
$ogv = get_post_meta($post->ID, 'fave_page_header_bg_ogv', true);

$video_image_id = get_post_meta($post->ID, 'fave_page_header_video_img', true);
$img_url = wp_get_attachment_image_src( $video_image_id, 'full' );

$ogv = substr($ogv, 0, strrpos($ogv, "."));
$mp4 = substr($mp4, 0, strrpos($mp4, "."));
$webm = substr($webm, 0, strrpos($webm, "."));
$video_image = substr($img_url[0], 0, strrpos($img_url[0], "."));
$is_dock_search = '';
if(houzez_option('adv_search_which_header_show')['header_video'] != 0) {
	$is_dock_search = houzez_dock_search_class();
}
?>
<section class="top-banner-wrap <?php echo esc_attr($is_dock_search); ?> <?php houzez_banner_fullscreen(); ?> <?php houzez_banner_search_type(); ?>">

	<?php houzez_banner_search_autocomplete_html(); ?>

	<div id="video-background" class="video-background" data-vide-bg="mp4: <?php echo esc_url($mp4); ?>, webm: <?php echo esc_url($webm); ?>, ogv: <?php echo esc_url($ogv); ?>, poster: <?php echo esc_url($video_image); ?>" data-vide-options="position: 0% 50%"></div>
	<div class="align-self-center flex-fill">
		<div class="banner-caption">
			
			<?php get_template_part('template-parts/banners/partials/caption'); ?>

			<?php get_template_part('template-parts/search/search-for-banners'); ?>

		</div><!-- banner-caption -->
	</div><!-- align-self-center -->

	<?php 
	if(houzez_option('adv_search_which_header_show')['header_video'] != 0) {
		get_template_part('template-parts/search/dock-search-main');
	}
	?>
</section><!-- top-banner-wrap -->