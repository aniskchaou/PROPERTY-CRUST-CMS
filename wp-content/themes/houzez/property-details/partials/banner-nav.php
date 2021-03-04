<?php 
global $map_street_view; 
$gallery_active = $map_active = $street_active = "";
$active_tab = houzez_option('prop_default_active_tab', 'image_gallery');
if( $active_tab == 'map_view' ) {
	$map_active = 'active';

} elseif( $active_tab == 'street_view' ) {
	$street_active = 'active'; 
} else {
	$gallery_active = 'active';
}
?>
<ul class="nav nav-pills" id="pills-tab" role="tablist">
	<li class="nav-item">

		<?php if( !houzez_map_in_section() && houzez_get_listing_data('property_map') ) { ?>
		<a class="nav-link <?php echo esc_attr($gallery_active); ?>" id="pills-gallery-tab" data-toggle="pill" href="#pills-gallery" role="tab" aria-controls="pills-gallery" aria-selected="true">
		<?php } else { ?>
			<a class="nav-link <?php echo esc_attr($gallery_active); ?>" id="pills-gallery-tab" data-toggle="modal" href="#property-lightbox" aria-controls="property-lightbox" aria-selected="true">

			
		<?php } ?>
			<i class="houzez-icon icon-picture-sun"></i>
		</a>
	</li>

	

	<?php if( !houzez_map_in_section() && houzez_get_listing_data('property_map')) { ?>
		<li class="nav-item">
			<a class="nav-link <?php echo esc_attr($map_active); ?>" id="pills-map-tab" data-toggle="pill" href="#pills-map" role="tab" aria-controls="pills-map" aria-selected="true">
				<i class="houzez-icon icon-maps"></i>
			</a>
		</li>

		<?php if( houzez_get_map_system() == 'google' && $map_street_view != 'hide' ) { ?>
		<li class="nav-item">
			<a class="nav-link <?php echo esc_attr($street_active); ?>" id="pills-street-view-tab" data-toggle="pill" href="#pills-street-view" role="tab" aria-controls="pills-street-view" aria-selected="false">
				<i class="houzez-icon icon-location-user"></i>
			</a>
		</li>
		<?php } ?>
	<?php } ?>
</ul><!-- nav -->	