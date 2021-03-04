<div class="form-group">
	<label for="property_id">
		<?php echo houzez_option('cl_prop_id', 'Property ID').houzez_required_field( 'prop_id' ); ?>
	</label>

	<input class="form-control" id="property_id" <?php houzez_required_field_2('prop_id'); ?> name="property_id" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_id');
    }
    ?>" placeholder="<?php echo houzez_option('cl_prop_id_plac', 'Enter property ID'); ?>" type="text">
	<small class="form-text text-muted"><?php echo houzez_option('cl_prop_id_tooltip', 'For example: HZ-01'); ?></small>
</div>