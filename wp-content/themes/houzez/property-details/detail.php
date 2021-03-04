<?php global $hide_fields; ?>
<div class="property-detail-wrap property-section-wrap" id="property-detail-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap d-flex justify-content-between align-items-center">
			<h2><?php echo houzez_option('sps_details', 'Details'); ?></h2>
			<?php if( $hide_fields['updated_date'] != 1 ) { ?>
			<span class="small-text grey"><i class="houzez-icon icon-calendar-3 mr-1"></i> <?php esc_html_e( 'Updated on', 'houzez' ); ?> <?php the_modified_time('F j, Y'); ?> <?php esc_html_e( 'at', 'houzez' ); ?> <?php the_modified_time('g:i a'); ?></span>
			<?php } ?>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<?php get_template_part('property-details/partials/details'); ?> 
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-detail-wrap -->

