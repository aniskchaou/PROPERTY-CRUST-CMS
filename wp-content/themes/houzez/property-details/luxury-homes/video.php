<?php
$prop_video_img = '';
$prop_video_url = houzez_get_listing_data('video_url');
if( !empty( $prop_video_url ) ) {

    if ( empty( $prop_video_img ) ) :

        $prop_video_img = wp_get_attachment_url( get_post_thumbnail_id( $post ) );

    endif;
?>
<div class="fw-property-video-wrap fw-property-section-wrap" id="property-video-wrap">
	<div class="block-video-wrap">
		<!-- Copy & Pasted from YouTube -->
		<?php $embed_code = wp_oembed_get($prop_video_url); echo $embed_code; ?>
	</div>
</div><!-- fw-property-video-wrap -->
<?php } ?>