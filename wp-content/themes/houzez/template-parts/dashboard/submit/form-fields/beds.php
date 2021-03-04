<div class="form-group">
	<label for="prop_beds">
		<?php echo houzez_option('cl_bedrooms', 'Bedrooms').houzez_required_field('bedrooms'); ?>
	</label>
	<input class="form-control" name="prop_beds" <?php houzez_required_field_2('bedrooms'); ?> id="prop_beds" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_bedrooms');
    }
    ?>" placeholder="<?php echo houzez_option('cl_bedrooms_plac', 'Enter number of bedrooms'); ?>" <?php houzez_input_attr_for_bbr(); ?>>

    <?php if( !houzez_is_bedsbaths_range() ) { ?>
	<small class="form-text text-muted"><?php echo houzez_option('cl_only_digits', 'Only digits'); ?></small>
	<?php } ?>
</div>