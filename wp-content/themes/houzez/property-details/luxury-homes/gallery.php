<?php
$size = 'houzez-item-image-1';
$properties_images = rwmb_meta( 'fave_property_images', 'type=plupload_image&size='.$size, $post->ID );

if( !empty($properties_images) ) {?>

<div class="fw-property-gallery-wrap fw-property-section-wrap" id="property-gallery-wrap">
	<div class="row row-no-padding">

		<?php 
		$i = 0;
		foreach( $properties_images as $prop_image_id => $prop_image_meta ) { $i++;
            $full_image = houzez_get_image_by_id( $prop_image_id, 'full' ); ?>

	        <div class="col-md-3 col-sm-6">
				<a href="#" data-slider-no="<?php echo esc_attr($i); ?>" class="houzez-trigger-popup-slider-js swipebox hover-effect" data-toggle="modal" data-target="#property-lightbox">
					<img class="img-fluid" src="<?php echo esc_url( $prop_image_meta['url'] ); ?>" width="<?php echo esc_attr( $prop_image_meta['width'] ); ?>" height="<?php echo esc_attr( $prop_image_meta['height'] ); ?>" alt="<?php echo esc_attr( $prop_image_meta['title'] ); ?>">
				</a>
			</div>

	    <?php } ?>
	</div><!-- row -->
</div><!-- fw-property-gallery-wrap -->
<?php } ?>