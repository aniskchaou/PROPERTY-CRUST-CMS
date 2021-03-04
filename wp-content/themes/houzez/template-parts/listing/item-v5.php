<?php
global $ele_thumbnail_size;
$property_type = houzez_taxonomy_simple('property_type');
?>
<div class="item-listing-wrap hz-item-gallery-js item-listing-wrap-v5 card" <?php houzez_property_gallery('houzez-item-image-1'); ?>>
	<div class="item-wrap item-wrap-v5 h-100">
		<div class="d-flex align-items-center h-100">
			<div class="item-header">
				<?php get_template_part('template-parts/listing/partials/item-featured-label'); ?>
				<?php get_template_part('template-parts/listing/partials/item-labels'); ?>
				<?php get_template_part('template-parts/listing/partials/item-tools'); ?>
				<?php get_template_part('template-parts/listing/partials/item-image'); ?>
				<div class="preview_loader"></div>
			</div><!-- item-header -->	
			<div class="item-body flex-grow-1">
				<?php get_template_part('template-parts/listing/partials/item-title'); ?>
				
				<div class="item-v5-price">
					<?php echo houzez_listing_price_v5(); ?>
				</div>

				<?php if(!empty($property_type) && houzez_option('disable_type', 1)) { ?>
				<div class="item-v5-type">
					<?php echo esc_attr($property_type); ?>
				</div>
				<?php } ?>

				<?php get_template_part('template-parts/listing/partials/item-features-v5'); ?>
			</div><!-- item-body -->
		</div><!-- d-flex -->
	</div><!-- item-wrap -->
</div><!-- item-listing-wrap -->