<div class="form-group">
	<label for="prop_rooms">
		<?php echo houzez_option('cl_rooms', 'Rooms').houzez_required_field('rooms'); ?>
	</label>
	<input class="form-control" name="prop_rooms" <?php houzez_required_field_2('rooms'); ?> id="prop_rooms" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_rooms');
    }
    ?>" placeholder="<?php echo houzez_option('cl_rooms_plac', 'Enter number of rooms'); ?>" <?php houzez_input_attr_for_bbr(); ?>>
    <?php if( !houzez_is_bedsbaths_range() ) { ?>
	<small class="form-text text-muted"><?php echo houzez_option('cl_only_digits', 'Only digits'); ?></small>
	<?php } ?>
</div>