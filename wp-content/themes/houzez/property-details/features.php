<?php
global $features;
$features = wp_get_post_terms( get_the_ID(), 'property_feature', array("fields" => "all"));

if (!empty($features)):
?>
<div class="property-features-wrap property-section-wrap" id="property-features-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo houzez_option('sps_features', 'Features'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<?php get_template_part('property-details/partials/features'); ?> 
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-features-wrap -->
<?php endif; ?>