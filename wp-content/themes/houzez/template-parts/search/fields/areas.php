<div class="form-group">
	<select name="areas[]" data-size="5" class="houzezSelectFilter houzezFourthList selectpicker <?php houzez_ajax_search(); ?> form-control bs-select-hidden" title="<?php echo houzez_option('srh_areas', 'All Areas'); ?>" data-selected-text-format="count > 1" data-live-search="true" data-actions-box="false" <?php houzez_multiselect(houzez_option('ms_area', 1)); ?> data-select-all-text="<?php echo houzez_option('cl_select_all', 'Select All'); ?>" data-deselect-all-text="<?php echo houzez_option('cl_deselect_all', 'Deselect All'); ?>" data-none-results-text="<?php echo houzez_option('cl_no_results_matched', 'No results matched');?> {0}" data-count-selected-text="{0} <?php echo houzez_option('srh_areass', 'Areas'); ?>">
		<?php

		if( !houzez_is_multiselect(houzez_option('ms_area', 0)) ) {
			echo '<option value="">'.houzez_option('srh_areas', 'All Areas').'</option>';
		}
		global $post;
        $fave_area = get_post_meta($post->ID, 'fave_area', false);
        $default_area = isset($fave_area) && is_array($fave_area) ? $fave_area : array();

		$area = isset($_GET['areas']) ? $_GET['areas'] : $default_area;
        houzez_get_search_taxonomies('property_area', $area );

		?>

	</select><!-- selectpicker -->
</div><!-- form-group -->