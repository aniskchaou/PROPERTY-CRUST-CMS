<div class="form-group">
	<select name="bathrooms" data-size="5" class="selectpicker <?php houzez_ajax_search(); ?> form-control bs-select-hidden" title="<?php echo houzez_option('srh_bathrooms', 'Bathrooms'); ?>" data-live-search="false">
		<option value=""><?php echo houzez_option('srh_bathrooms', 'Bathrooms'); ?></option>
        <?php houzez_number_list('bathrooms'); ?>
	</select><!-- selectpicker -->
</div>