<?php
/**
 * User: waqasriaz
 * Date: 5 Sep 2019
 */
$virtual_tour = houzez_get_listing_data('virtual_tour');

if( !empty( $virtual_tour ) ) { ?>
<div class="fw-property-virtual-tour-wrap fw-property-section-wrap" id="property-virtual-tour-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap">
			<h2><?php echo houzez_option('sps_virtual_tour', '360° Virtual Tour'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<div class="block-virtual-video-wrap">
				<!-- Copy & Pasted from YouTube -->
				<?php echo $virtual_tour; ?>
			</div>
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- fw-property-virtual-tour-wrap -->
<?php } ?>