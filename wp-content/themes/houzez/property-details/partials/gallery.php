<?php
global $post;
$size = 'houzez-gallery';
$properties_images = rwmb_meta( 'fave_property_images', 'type=plupload_image&size='.$size, $post->ID );
$gallery_caption = houzez_option('gallery_caption', 0); 
if( !empty($properties_images) && count($properties_images)) {
?>
<div class="top-gallery-section">
    <div id="property-gallery-js" class="listing-slider cS-hidden">
        <?php
        $i = 0;
        foreach( $properties_images as $prop_image_id => $prop_image_meta ) { $i++;
            $output = '';
            $thumb = houzez_get_image_by_id($prop_image_id, 'houzez-item-image-1');
            
            $output .= '<div data-thumb="'.esc_url( $thumb[0] ).'">';
                    $output .= '<a rel="gallery-1" data-slider-no="'.esc_attr($i).'" href="#" class="houzez-trigger-popup-slider-js swipebox" data-toggle="modal" data-target="#property-lightbox">
                        <img class="img-fluid" src="'.esc_url( $prop_image_meta['url'] ).'" alt="'.esc_attr($prop_image_meta['alt']).'" title="'.esc_attr($prop_image_meta['title']).'">
                    </a>';

            if( !empty($prop_image_meta['caption']) && $gallery_caption != 0 ) {
               $output .= '<span class="hz-image-caption">'.esc_attr($prop_image_meta['caption']).'</span>';
            }

            $output .= '</div>';

            echo $output;   
        }
        ?>

        
    </div>
</div><!-- top-gallery-section -->
<?php }