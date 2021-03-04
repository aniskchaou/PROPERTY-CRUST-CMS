<div class="form-group">
	<select name="states[]" data-target="houzezThirdList" data-size="5" class="houzezSelectFilter houzezStateFilter houzezSecondList selectpicker <?php houzez_ajax_search(); ?> houzez-state-js form-control bs-select-hidden" title="<?php echo houzez_option('srh_states', 'All States'); ?>" data-none-results-text="<?php echo houzez_option('cl_no_results_matched', 'No results matched');?> {0}" data-live-search="true" data-container="body">
		<?php
		global $post;
        $fave_states = get_post_meta($post->ID, 'fave_states', false);
        $default_states = isset($fave_states) && is_array($fave_states) ? $fave_states : array();

        $state = isset($_GET['states']) ? $_GET['states'] : $default_states;

        echo '<option value="">'.houzez_option('srh_states', 'All States').'</option>';

        houzez_get_search_taxonomies('property_state', $state );

		?>
	</select><!-- selectpicker -->
</div><!-- form-group -->