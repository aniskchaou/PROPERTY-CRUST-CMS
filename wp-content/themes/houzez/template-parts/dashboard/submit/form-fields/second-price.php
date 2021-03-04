<div class="form-group">
	<label><?php echo houzez_option('cl_second_price', 'Second Price (Optional)').houzez_required_field('prop_second_price'); ?></label>

	<input class="form-control" name="prop_sec_price" <?php houzez_required_field_2('prop_second_price'); ?> id="prop_sec_price" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_sec_price');
    }
    ?>" placeholder="<?php echo houzez_option('cl_second_price_plac', 'Enter the second price'); ?>" type="text">
</div><!-- form-group -->