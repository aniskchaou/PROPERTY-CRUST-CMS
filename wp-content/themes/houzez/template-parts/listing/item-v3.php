<?php global $ele_thumbnail_size; ?>
<div class="item-listing-wrap hz-item-gallery-js item-listing-wrap-v3 card" <?php houzez_property_gallery('houzez-item-image-1'); ?>>
	<div class="item-wrap item-wrap-v3 h-100">
		<?php get_template_part('template-parts/listing/partials/item-image'); ?>
		<?php get_template_part('template-parts/listing/partials/item-title'); ?>
		<?php get_template_part('template-parts/listing/partials/item-features-v3'); ?>
		<?php get_template_part('template-parts/listing/partials/item-price'); ?>
		<?php get_template_part('template-parts/listing/partials/item-labels'); ?>
		<?php get_template_part('template-parts/listing/partials/item-featured-label'); ?>
		<?php get_template_part('template-parts/listing/partials/item-tools'); ?>
		<div class="preview_loader"></div>
	</div><!-- item-wrap -->
</div><!-- item-listing-wrap -->