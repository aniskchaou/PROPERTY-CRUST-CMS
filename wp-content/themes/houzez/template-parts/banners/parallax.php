<?php 
global $post;
$image_id = get_post_meta($post->ID, 'fave_page_header_image', true);
$img_url = wp_get_attachment_image_src( $image_id, 'full' );
$is_dock_search = '';
if(houzez_option('adv_search_which_header_show')['header_image'] != 0) {
	$is_dock_search = houzez_dock_search_class();
}
?>
<section class="top-banner-wrap <?php echo esc_attr($is_dock_search); ?> <?php houzez_banner_fullscreen(); ?> <?php houzez_banner_search_type(); ?>">
	
	<?php houzez_banner_search_autocomplete_html(); ?>
	
	<div class="banner-inner parallax d-flex" data-parallax-bg-image="<?php echo esc_url($img_url[0]); ?>">
		<div class="align-self-center flex-fill">
			<div class="banner-caption">
				
				<?php get_template_part('template-parts/banners/partials/caption'); ?>

				<?php get_template_part('template-parts/search/search-for-banners'); ?>

			</div><!-- banner-caption -->
		</div><!-- align-self-center -->
	</div><!-- banner-inner parallax -->

	<?php 
	if(houzez_option('adv_search_which_header_show')['header_image'] != 0) {
		get_template_part('template-parts/search/dock-search-main');
	}
	?>

</section><!-- top-banner-wrap -->