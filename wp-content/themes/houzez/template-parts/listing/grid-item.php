<?php
global $ele_lazyloadbg, $post;
$thumb_id = get_post_thumbnail_id( $post->ID );
$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', false);
$thumb_url = $thumb_url_array[0];
?>
<div class="property-grid-item hover-effect <?php echo $ele_lazyloadbg; ?>" <?php if( !empty($thumb_url) ) { echo 'style="background-image: url('.esc_url( $thumb_url ).');"'; } ?>>
	<a class="property-grid-item-link" href="<?php echo esc_url(get_permalink()); ?>"></a>
	<div class="item-listing-wrap item-listing-wrap-v3">
		<div class="item-wrap item-wrap-v3">
			<div class="item-inner-wrap">
				<?php get_template_part('template-parts/listing/partials/item-labels'); ?>
				<h2 class="item-title">
					<?php the_title(); ?>
				</h2>
				<?php get_template_part('template-parts/listing/partials/item-features-listing-grids'); ?>

			</div>
			<?php get_template_part('template-parts/listing/partials/item-featured-label'); ?>
			<?php get_template_part('template-parts/listing/partials/item-tools'); ?>
			<div class="preview_loader"></div>
		</div><!-- item-wrap -->
	</div><!-- item-listing-wrap -->
</div><!-- property-grid-item -->
