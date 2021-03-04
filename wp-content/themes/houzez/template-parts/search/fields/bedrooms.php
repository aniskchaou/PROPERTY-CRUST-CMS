<div class="form-group">
	<select name="bedrooms" data-size="5" class="selectpicker <?php houzez_ajax_search(); ?> form-control bs-select-hidden" title="<?php echo houzez_option('srh_bedrooms', 'Bedrooms'); ?>" data-live-search="false">
		<option value=""><?php echo houzez_option('srh_bedrooms', 'Bedrooms'); ?></option>
        <?php houzez_number_list('bedrooms'); ?>
	</select><!-- selectpicker -->
</div>