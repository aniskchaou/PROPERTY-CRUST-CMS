<div class="form-group">
	<select name="rooms" data-size="5" class="selectpicker <?php houzez_ajax_search(); ?> form-control bs-select-hidden" title="<?php echo houzez_option('srh_rooms', 'Rooms'); ?>" data-live-search="false">
		<option value=""><?php echo houzez_option('srh_rooms', 'Rooms'); ?></option>
        <?php houzez_number_list('rooms'); ?>
	</select><!-- selectpicker -->
</div>