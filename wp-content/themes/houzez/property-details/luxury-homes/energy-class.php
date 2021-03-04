<?php
global $post, $energy_class;
$energy_class = houzez_get_listing_data('energy_class');

if(!empty($energy_class)) {
?>
<div class="fw-property-energy-class-wrap fw-property-section-wrap" id="property-energy-class-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap">
			<h2><?php echo houzez_option('sps_energy_class', 'Energy Class'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<?php get_template_part('property-details/partials/energy-class'); ?> 
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- fw-property-address-wrap -->
<?php } ?>