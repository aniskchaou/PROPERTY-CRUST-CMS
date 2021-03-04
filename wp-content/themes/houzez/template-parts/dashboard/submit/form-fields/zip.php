<?php global $houzez_local; ?>
<div class="form-group">
	<label for="postal_code"><?php echo houzez_option('cl_zip', 'Postal Code / Zip'); ?></label>

	<input class="form-control" id="zip" name="postal_code" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_zip');
    }
    ?>" placeholder="<?php echo houzez_option('cl_zip_plac', 'Enter your property zip code'); ?>" type="text">
</div>