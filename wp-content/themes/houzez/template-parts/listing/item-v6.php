<?php global $post, $ele_thumbnail_size; ?>
<div class="item-listing-wrap hz-item-gallery-js item-listing-wrap-v6 card" <?php houzez_property_gallery('houzez-item-image-6'); ?>>
	<div class="item-wrap item-wrap-v6 h-100">
		<div class="d-flex align-items-center h-100">
			<div class="item-header">
				<?php get_template_part('template-parts/listing/partials/item-featured-label'); ?>

				<?php get_template_part('template-parts/listing/partials/item-labels'); ?>

				<div class="listing-image-wrap">
					<div class="listing-thumb">
						<a class="listing-featured-thumb" href="<?php echo esc_url(get_permalink()); ?>">
						<?php
						$thumbnail_size = !empty($ele_thumbnail_size) ? $ele_thumbnail_size : 'houzez-item-image-6';

					    if( has_post_thumbnail( $post->ID ) && get_the_post_thumbnail($post->ID) != '' ) {
					        the_post_thumbnail( $thumbnail_size, array('class' => 'img-fluid') );
					    }else{
					        houzez_image_placeholder( $thumbnail_size );
					    }
					    ?>
						</a>
					</div>
				</div>

				<?php get_template_part('template-parts/listing/partials/item-tools'); ?>
				<div class="preview_loader"></div>
			</div><!-- item-header -->	
			<div class="item-body flex-grow-1">
				<?php get_template_part('template-parts/listing/partials/item-title'); ?>

				<div class="d-flex justify-content-between align-items-center amenities-price-wrap">
					<ul class="item-price-wrap">
						<li class="item-price"><?php echo houzez_listing_price_v5(); ?></li>
					</ul>
					<?php get_template_part('template-parts/listing/partials/item-features-v6'); ?>
				</div><!-- d-flex -->
			</div><!-- item-body -->
		</div><!-- d-flex -->
	</div><!-- item-wrap -->
</div><!-- item-listing-wrap -->