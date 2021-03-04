<?php
global $post;
$hide_yelp = houzez_option('houzez_yelp');

if( $hide_yelp ) { ?>
<div class="fw-property-nearby-wrap fw-property-section-wrap" id="property-nearby-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo houzez_option('sps_nearby', "What's Nearby?"); ?></h2>
			<div class="small-text nearby-logo"><?php echo esc_html__("Powered by", "houzez"); ?> <i class="houzez-icon icon-social-media-yelp"></i> <strong><?php echo esc_html__("Yelp", "houzez"); ?></strong></div>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<?php get_template_part('property-details/partials/yelp'); ?>
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- fw-property-walkscore-wrap -->
<?php } ?>