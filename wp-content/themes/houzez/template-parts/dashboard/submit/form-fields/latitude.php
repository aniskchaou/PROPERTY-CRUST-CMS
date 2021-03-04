<?php global $houzez_local; ?>
<div class="form-group">
	<label for="lat"><?php echo houzez_option( 'cl_latitude', 'Latitude' ); ?></label>

	<input class="form-control" id="latitude" name="lat" value="<?php
    if (houzez_edit_property()) {
        $lat = houzez_get_field_meta('property_location');
        $lat = explode(",", $lat);
        if(!empty($lat[0])) {
        	echo sanitize_text_field($lat[0]);
        }
    }
    ?>" placeholder="<?php echo houzez_option('cl_latitude_plac', 'Enter address latitude'); ?>" type="text">
</div>