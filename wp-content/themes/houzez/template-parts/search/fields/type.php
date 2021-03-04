<div class="form-group">
	<select name="type[]" data-size="5" class="selectpicker <?php houzez_ajax_search(); ?> form-control bs-select-hidden" title="<?php echo houzez_option('srh_type', 'Type'); ?>" data-live-search="true" data-selected-text-format="count > 1" data-actions-box="true"  <?php houzez_multiselect(houzez_option('ms_type', 1)); ?> data-select-all-text="<?php echo houzez_option('cl_select_all', 'Select All'); ?>" data-deselect-all-text="<?php echo houzez_option('cl_deselect_all', 'Deselect All'); ?>" data-count-selected-text="{0} <?php echo houzez_option('srh_types', 'Types'); ?>" data-none-results-text="<?php echo houzez_option('cl_no_results_matched', 'No results matched');?> {0}" data-container="body">

		<?php
		global $post;
		if( !houzez_is_multiselect(houzez_option('ms_type', 1)) ) {
			echo '<option value="">'.houzez_option('srh_type', 'Type').'</option>';
		}

		$fave_types = get_post_meta($post->ID, 'fave_types', false);
        $default_types = isset($fave_types) && is_array($fave_types) ? $fave_types : array();

		$type = isset($_GET['type']) ? $_GET['type'] : $default_types;
        houzez_get_search_taxonomies('property_type', $type );

		?>
	</select><!-- selectpicker -->
</div><!-- form-group -->