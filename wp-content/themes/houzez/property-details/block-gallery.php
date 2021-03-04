<?php
global $post;

$visible_images = houzez_option('block_gallery_visible', 9);
$images_in_row = houzez_option('block_gallery_columns', 3);;

if( empty($visible_images) ) {
    $visible_images = 9;
}

$percentage = 100 / $images_in_row;

$size = 'houzez-item-image-1';
$properties_images = rwmb_meta( 'fave_property_images', 'type=plupload_image&size='.$size, $post->ID );

$i = 0;

if( !empty($properties_images) && count($properties_images)) {

    $total_images = count($properties_images);
    $remaining_images = $total_images - $visible_images;
    ?>
<div class="property-gallery-grid property-section-wrap" id="property-gallery-grid">        
    <div class="d-flex flex-wrap">

        <?php 
        foreach( $properties_images as $image ) { $i++; 
        ?>
        <a data-toggle="modal" data-slider-no="<?php echo esc_attr($i); ?>" data-target="#property-lightbox" class="houzez-trigger-popup-slider-js gallery-grid-item <?php if($i == $visible_images && $remaining_images > 0 ){ echo 'more-images'; } elseif($i > $visible_images) {echo 'gallery-hidden'; } ?>">
            <?php if( $i == $visible_images && $remaining_images > 0 ){ echo '<span>'.$remaining_images.'+</span>'; } ?>
            <img class="img-fluid" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
        </a>
        <?php } ?>
        
    </div>
</div><!-- property-gallery-grid -->
<style> 
    .property-gallery-grid .gallery-grid-item {
        max-width: calc(<?php echo $percentage; ?>% - 1px);
        margin-right: 1px;
        margin-bottom: 1px;
    }
</style>
<?php } ?>