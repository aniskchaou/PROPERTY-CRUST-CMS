<div class="form-group">
	<label for="prop_garage">
		<?php echo houzez_option('cl_garage', 'Garages').houzez_required_field('garages'); ?>
	</label>
	<input class="form-control" id="prop_garage" <?php houzez_required_field_2('garages'); ?> name="prop_garage" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_garage');
    }
    ?>" placeholder="<?php echo houzez_option('cl_garage_plac', 'Enter number of garages'); ?>" type="number" min="1" max="99">
	<small class="form-text text-muted"><?php echo houzez_option('cl_only_digits', 'Only digits'); ?></small>
</div>