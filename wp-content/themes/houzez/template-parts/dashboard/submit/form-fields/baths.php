<div class="form-group">
	<label for="prop_baths">
		<?php echo houzez_option('cl_bathrooms', 'Bathrooms').houzez_required_field('bathrooms'); ?>
	</label>

	<input class="form-control" id="prop_baths" <?php houzez_required_field_2('bathrooms'); ?> name="prop_baths" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_bathrooms');
    }
    ?>" placeholder="<?php echo houzez_option('cl_bathrooms_plac', 'Enter number of bathrooms'); ?>" <?php houzez_input_attr_for_bbr(); ?>>

    <?php if( !houzez_is_bedsbaths_range() ) { ?>
	<small class="form-text text-muted"><?php echo houzez_option('cl_only_digits', 'Only digits'); ?></small>
	<?php } ?>
</div>