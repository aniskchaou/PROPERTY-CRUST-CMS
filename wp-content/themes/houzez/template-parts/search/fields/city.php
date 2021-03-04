<div class="form-group">
	<select name="location[]" data-target="houzezFourthList" data-size="5" class="houzezSelectFilter houzezCityFilter houzezThirdList selectpicker <?php houzez_ajax_search(); ?> houzez-city-js form-control bs-select-hidden" title="<?php echo houzez_option('srh_cities', 'All Cities'); ?>" data-selected-text-format="count > 1" data-live-search="true" data-actions-box="true" <?php houzez_multiselect(houzez_option('ms_city', 0)); ?> data-none-results-text="<?php echo houzez_option('cl_no_results_matched', 'No results matched');?> {0}" data-container="body">
		
		<?php
		global $post;
		if( !houzez_is_multiselect(houzez_option('ms_city', 0)) ) {
			echo '<option value="">'.houzez_option('srh_cities', 'All Cities').'</option>';
		}

		$fave_locations = get_post_meta($post->ID, 'fave_locations', false);
        $default_locations = isset($fave_locations) && is_array($fave_locations) ? $fave_locations : array();

		$city = isset($_GET['location']) ? $_GET['location'] : $default_locations;
        houzez_get_search_taxonomies('property_city', $city );

		?>
	</select><!-- selectpicker -->
</div><!-- form-group -->