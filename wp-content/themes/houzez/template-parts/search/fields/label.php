<div class="form-group">
	<select name="label[]" data-size="5" class="selectpicker <?php houzez_ajax_search(); ?> form-control bs-select-hidden" title="<?php echo  houzez_option('srh_label','Label'); ?>" data-selected-text-format="count > 1" data-live-search="false" data-actions-box="true" <?php houzez_multiselect(houzez_option('ms_label', 0)); ?> data-select-all-text="<?php echo houzez_option('cl_select_all', 'Select All'); ?>" data-deselect-all-text="<?php echo houzez_option('cl_deselect_all', 'Deselect All'); ?>" data-none-results-text="<?php echo houzez_option('cl_no_results_matched', 'No results matched');?> {0}" data-count-selected-text="{0} <?php echo houzez_option('srh_labels', 'Labels'); ?>" data-container="body">
		<?php

		if( !houzez_is_multiselect(houzez_option('ms_label', 0)) ) {
			echo '<option value="">'.houzez_option('srh_label','Label').'</option>';
		}

		global $post;
        $fave_labels = get_post_meta($post->ID, 'fave_labels', false);
        $default_labels = isset($fave_labels) && is_array($fave_labels) ? $fave_labels : array();

		$label = isset($_GET['label']) ? $_GET['label'] : $default_labels;
        houzez_get_search_taxonomies('property_label', $label );

		?>
	</select><!-- selectpicker -->
</div><!-- form-group -->