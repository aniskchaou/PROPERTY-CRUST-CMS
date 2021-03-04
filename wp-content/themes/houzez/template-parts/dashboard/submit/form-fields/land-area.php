<div class="form-group">
	<label for="prop_land_area">
		<?php echo houzez_option('cl_land_size', 'Land Area').houzez_required_field( 'land_area' ); ?>
	</label>

	<input class="form-control" id="prop_land_area" <?php houzez_required_field_2('land_area'); ?> name="prop_land_area" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_land');
    }
    ?>" placeholder="<?php echo houzez_option('cl_land_size_plac', 'Enter property land area size'); ?>" type="text">
	<small class="form-text text-muted"><?php echo houzez_option('cl_only_digits', 'Only digits'); ?></small>
</div>