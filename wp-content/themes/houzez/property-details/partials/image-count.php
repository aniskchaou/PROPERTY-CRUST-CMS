<?php 
global $post;
$images_count = get_post_meta( $post->ID, 'fave_property_images',false ); 
$total_images = count($images_count);
 ?>
<div class="property-image-count visible-on-mobile"><i class="houzez-icon icon-picture-sun"></i> <?php echo esc_attr($total_images); ?></div>