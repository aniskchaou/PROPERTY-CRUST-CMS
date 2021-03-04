<div class="form-group">
	<label for="prop_year_built">
		<?php echo houzez_option('cl_year_built', 'Year Built').houzez_required_field( 'year_built' ); ?>
	</label>

	<input class="form-control" <?php houzez_required_field_2('year_built'); ?> name="prop_year_built" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_year');
    }
    ?>" placeholder="<?php echo houzez_option('cl_year_built_plac', 'Enter year built'); ?>" type="text">
	<small class="form-text text-muted"><?php echo houzez_option('cl_only_digits', 'Only digits'); ?></small>
</div><!-- form-group -->