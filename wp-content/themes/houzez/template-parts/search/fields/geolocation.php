<?php 
$checked = true;
$search_location = isset ( $_GET['search_location'] ) ? esc_attr($_GET['search_location']) : ''; ?>
<div class="form-group">
	<div class="location-search hz-map-field-js" data-address-field="search_location">
		<input name="search_location" id="search_location" type="text" class="search_location_js form-control" value="<?php echo esc_attr($search_location); ?>" placeholder="<?php echo houzez_option('srh_location', 'Location'); ?>">
		<a class="btn location-trigger" href="#">
			<i class="houzez-icon icon-location-target"></i>
		</a>
		<input type="hidden" name="lat" value="<?php echo isset ( $_GET['lat'] ) ? esc_attr($_GET['lat']) : ''; ?>" >
        <input type="hidden" name="lng" value="<?php echo isset ( $_GET['lng'] ) ? esc_attr($_GET['lng']) : ''; ?>">

        <?php if( !houzez_is_half_map()) { ?>
        <input type="checkbox" name="use_radius" class="hide_search_checkbox" <?php checked( true, $checked ); ?>>
    	<?php } elseif( houzez_is_half_map() && houzez_option('halfmap_search_layout', 'v4') != 'v4' ) { ?>

    		<input type="checkbox" name="use_radius" class="hide_search_checkbox" <?php checked( true, $checked ); ?>>

    	<?php } ?>
	</div><!-- location-search -->
</div><!-- form-group -->
<?php houzez_enqueue_maps_api(); ?>