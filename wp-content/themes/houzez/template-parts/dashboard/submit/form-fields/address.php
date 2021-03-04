<?php global $houzez_local; ?>
<div class="form-group">
	<label for="property_map_address">
		<?php echo houzez_option('cl_address', 'Address').houzez_required_field('property_map_address'); ?>		
	</label>

	<input class="form-control" id="geocomplete" <?php houzez_required_field_2('property_map_address'); ?> name="property_map_address" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_map_address');
    }
    ?>" autocomplete="off" placeholder="<?php echo houzez_option('cl_address_plac', 'Enter your property address'); ?>" type="text">
</div>