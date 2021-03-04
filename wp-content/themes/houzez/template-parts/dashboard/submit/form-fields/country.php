<?php
$country = '';
if (houzez_edit_property()) {
	global $property_data;

	$country = houzez_get_post_term_slug($property_data->ID, 'property_country');
}
?>
<div class="form-group">
	<label><?php echo houzez_option('cl_country', 'Country').houzez_required_field('country'); ?></label>
	<?php
	if(houzez_option('location_dropdowns') == 'yes') { ?>
		<select name="country" id="country" data-country="<?php echo esc_attr($country); ?>" data-target="houzezSecondList" <?php houzez_required_field_2('country'); ?> class="houzezSelectFilter houzezFirstList selectpicker form-control bs-select-hidden" data-size="5" data-none-results-text="<?php echo houzez_option('cl_no_results_matched', 'No results matched');?> {0}" data-live-search="true">
            <?php
	        if (houzez_edit_property()) {
	            
	            houzez_taxonomy_edit_hirarchical_options_for_search( $property_data->ID, 'property_country');

	        } else {
	        
	        echo '<option value="">'.houzez_option('cl_none', 'None').'</option>';
	                      
	        $property_country_terms = get_terms (
	            array(
	                "property_country"
	            ),
	            array(
	                'orderby' => 'name',
	                'order' => 'ASC',
	                'hide_empty' => false,
	                'parent' => 0
	            )
	        );

	        houzez_hirarchical_options( 'property_country', $property_country_terms, -1);
	        }
	        ?>
        </select>

	<?php
	} else {
	?>
		<input class="form-control" name="country" <?php houzez_required_field_2('country'); ?> id="country" value="<?php
	    if (houzez_edit_property()) {
	    	global $property_data;
	        echo houzez_taxonomy_by_postID( $property_data->ID, 'property_country' );
	    }
	    ?>" placeholder="<?php echo houzez_option('cl_country_plac', 'Enter your property country'); ?>" type="text">
	<?php } ?>
</div>