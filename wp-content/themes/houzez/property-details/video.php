<?php
$prop_video_img = '';
$prop_video_url = houzez_get_listing_data('video_url');
if( !empty( $prop_video_url ) ) {

    if ( empty( $prop_video_img ) ) :

        $prop_video_img = wp_get_attachment_url( get_post_thumbnail_id( $post ) );

    endif;
?>
<div class="property-video-wrap property-section-wrap" id="property-video-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo houzez_option('sps_video', 'Video'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<div class="block-video-wrap">
				<?php $embed_code = wp_oembed_get($prop_video_url); echo $embed_code; ?>
			</div>
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-video-wrap -->
<?php } ?>