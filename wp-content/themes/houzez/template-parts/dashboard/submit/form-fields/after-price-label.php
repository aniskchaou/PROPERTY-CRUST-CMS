<div class="form-group">
	<label for="prop_label">
		<?php echo houzez_option('cl_price_postfix', 'After The Price Label').houzez_required_field('price_label'); ?>
	</label>

	<input class="form-control" name="prop_label" <?php houzez_required_field_2('price_label'); ?> id="prop_label" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_price_postfix');
    }
    ?>" placeholder="<?php echo houzez_option('cl_price_postfix_plac', 'Enter the label after price'); ?>" type="text">

	<small class="form-text text-muted"><?php echo houzez_option('cl_price_postfix_tooltip', 'For example: Monthly'); ?></small>
</div>