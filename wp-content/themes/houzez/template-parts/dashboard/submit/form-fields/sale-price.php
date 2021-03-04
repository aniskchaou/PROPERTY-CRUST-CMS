<div class="form-group">
	<label for="prop_price">
		<?php echo houzez_option('cl_sale_price', 'Sale or Rent Price').houzez_required_field('sale_rent_price'); ?>	
	</label>

	<input class="form-control" name="prop_price" <?php houzez_required_field_2('sale_rent_price'); ?> id="prop_price" value="<?php
    if (houzez_edit_property()) {
        houzez_field_meta('property_price');
    }
    ?>" placeholder="<?php echo houzez_option('cl_sale_price_plac', 'Enter the price'); ?>" type="text">
</div>