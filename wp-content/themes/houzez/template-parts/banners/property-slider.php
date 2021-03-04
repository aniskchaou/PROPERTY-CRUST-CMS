<?php
$args = array(
    'post_type' => 'property',
    'meta_key' => 'fave_prop_homeslider',
    'meta_value' => 'yes',
    'posts_per_page' => '-1'
);
$slider = new WP_Query( $args );
$is_dock_search = '';
if(houzez_option('adv_search_which_header_show')['header_ps'] != 0) {
	$is_dock_search = houzez_dock_search_class();
}
?>
<section class="top-banner-wrap <?php echo esc_attr($is_dock_search); ?> <?php houzez_banner_fullscreen(); ?> property-slider-wrap">
	<div class="property-slider houzez-all-slider-wrap" data-autoplay="<?php echo esc_attr(houzez_option('banner_slider_autoplay', 1)); ?>" data-loop="<?php echo esc_attr(houzez_option('banner_slider_loop', 1)); ?>" data-speed="<?php echo esc_attr(houzez_option('banner_slider_autoplayspeed', '4000')); ?>">
		<?php 
		if( $slider->have_posts() ): 
			while( $slider->have_posts() ): $slider->the_post();
				get_template_part('template-parts/banners/partials/slider-item');
			endwhile;
		endif;
		wp_reset_postdata();
		?>
	</div><!-- property-slider -->

	<?php 
	if(houzez_option('adv_search_which_header_show')['header_ps'] != 0) {
		get_template_part('template-parts/search/dock-search-main');
	}
	?>
</section><!-- property-slider-wrap -->