<div class="form-group">
	<select name="country[]" data-target="houzezSecondList" data-size="5" class="houzezSelectFilter houzezCountryFilter houzezFirstList selectpicker <?php houzez_ajax_search(); ?> houzez-country-js form-control bs-select-hidden" title="<?php echo houzez_option('srh_countries', 'All Countries')?>" data-none-results-text="<?php echo houzez_option('cl_no_results_matched', 'No results matched');?> {0}" data-live-search="false" data-container="body">
		<?php
        $country = isset($_GET['country']) ? $_GET['country'] : array();
        
        echo '<option value="">'.houzez_option('srh_countries', 'All Countries').'</option>';

        houzez_get_search_taxonomies('property_country', $country );

		?>
	</select><!-- selectpicker -->
</div><!-- form-group -->