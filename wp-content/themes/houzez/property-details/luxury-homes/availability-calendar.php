<?php
$booking_shortcode = get_post_meta($post->ID, 'fave_booking_shortcode', true);

if( !empty($booking_shortcode) ) {
?>
<div class="fw-property-availability-calendar-wrap fw-property-section-wrap" id="property-availability-calendar-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap">
			<h2><?php esc_html_e( 'Availability Calendar', 'houzez' ); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">

			<?php get_template_part('property-details/partials/calendar'); ?> 
			
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- fw-property-availability-calendar-wrap -->
<?php } ?>