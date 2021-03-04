<?php
$slider_img = get_post_meta( get_the_ID(), 'fave_prop_slider_image', true );
$img_url = wp_get_attachment_image_src( $slider_img, 'full', true );
$img_url = $img_url[0];
if(empty($slider_img)) {
	$img_url = wp_get_attachment_url( get_post_thumbnail_id() );
}
?>
<div class="property-slider-item-wrap" style="background-image: url(<?php echo esc_url($img_url); ?>);"	>
	<a href="#" class="property-slider-link"></a>
	<div class="property-slider-item">
		<?php get_template_part('template-parts/listing/partials/item-featured-label'); ?>
		<?php get_template_part('template-parts/listing/partials/item-title'); ?>
		<?php get_template_part('template-parts/listing/partials/item-address'); ?>
		<?php get_template_part('template-parts/listing/partials/item-price'); ?>
		<?php get_template_part('template-parts/listing/partials/item-features-v1'); ?>
		<?php get_template_part('template-parts/listing/partials/item-author'); ?>
		<?php get_template_part('template-parts/listing/partials/item-date'); ?>
		<?php get_template_part('template-parts/listing/partials/item-btn'); ?>
	</div><!-- property-slider-item -->
</div><!-- property-slider-item-wrap -->