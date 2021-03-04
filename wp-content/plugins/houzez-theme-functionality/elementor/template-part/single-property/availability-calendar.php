<?php 
global $settings; 
$section_title = isset($settings['section_title']) && !empty($settings['section_title']) ? $settings['section_title'] : '';
?>
<div class="property-availability-calendar-wrap property-section-wrap" id="property-availability-calendar-wrap">
	<div class="block-wrap">
		<?php if( $settings['section_header'] ) { ?>
		<div class="block-title-wrap">
			<h2><?php echo $section_title;; ?></h2>
		</div><!-- block-title-wrap -->
		<?php } ?>
		<div class="block-content-wrap">

			<?php get_template_part('property-details/partials/calendar'); ?> 
			
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-availability-calendar-wrap -->