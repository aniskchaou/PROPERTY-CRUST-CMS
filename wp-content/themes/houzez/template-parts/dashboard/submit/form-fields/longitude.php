<?php global $houzez_local; ?>
<div class="form-group">
	<label for="lng"><?php echo houzez_option( 'cl_longitude', 'Longitude' ); ?></label>
	<input class="form-control" id="longitude" name="lng" value="<?php
    if (houzez_edit_property()) {
        $lng = houzez_get_field_meta('property_location');
        $lng = explode(",", $lng);
        if(!empty($lng[1])) {
        	echo sanitize_text_field($lng[1]);
        }
    }
    ?>" placeholder="<?php echo houzez_option('cl_longitude_plac', 'Enter address longitude'); ?>" type="text">
</div>