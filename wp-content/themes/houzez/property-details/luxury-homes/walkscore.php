<?php
$houzez_walkscore = houzez_option('houzez_walkscore');
$houzez_walkscore_api = houzez_option('houzez_walkscore_api');

if( $houzez_walkscore != 0 && $houzez_walkscore_api != '' ) {
?>
<div class="fw-property-walkscore-wrap fw-property-section-wrap" id="property-walkscore-wrap">
	<div class="block-wrap">
		<div class="block-content-wrap">

			<?php houzez_walkscore($post->ID); ?>

		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- fw-property-walkscore-wrap -->
<?php } ?>