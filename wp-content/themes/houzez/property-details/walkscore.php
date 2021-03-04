<?php
$houzez_walkscore = houzez_option('houzez_walkscore');
$houzez_walkscore_api = houzez_option('houzez_walkscore_api');

if( $houzez_walkscore != 0 && $houzez_walkscore_api != '' ) {
?>
<div class="property-walkscore-wrap property-section-wrap" id="property-walkscore-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo houzez_option('sps_walkscore', 'WalkScore'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">

			<?php houzez_walkscore($post->ID); ?>

		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-walkscore-wrap -->
<?php } ?>