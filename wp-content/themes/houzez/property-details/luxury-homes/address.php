<?php
$google_map_address = houzez_get_listing_data('property_map_address');
$google_map_address_url = "http://maps.google.com/?q=".$google_map_address;
?>
<div class="fw-property-address-wrap fw-property-section-wrap" id="property-address-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap">
			<h2><?php echo houzez_option('sps_address', 'Address'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<ul class="list-3-cols list-unstyled">
				<?php get_template_part('property-details/partials/address-data'); ?>
			</ul>	
		</div><!-- block-content-wrap -->
		<?php if(houzez_map_in_section() && houzez_get_listing_data('property_map')) { ?>
		<div id="houzez-single-listing-map" class="block-map-wrap">
			
		</div><!-- block-map-wrap -->
		<?php } ?>
	</div><!-- block-wrap -->
</div><!-- fw-property-address-wrap -->