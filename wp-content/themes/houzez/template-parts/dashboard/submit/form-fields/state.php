<?php 
$state = '';
if (houzez_edit_property()) {
	global $property_data;

	$state = houzez_get_post_term_slug($property_data->ID, 'property_state');
}
?>
<div class="form-group">
	<label for="administrative_area_level_1"><?php echo houzez_option('cl_state', 'County/State').houzez_required_field('state'); ?></label>

	<?php
	if(houzez_option('location_dropdowns') == 'yes') { ?>
		<select name="administrative_area_level_1" data-state="<?php echo esc_attr($state); ?>" data-target="houzezThirdList" <?php houzez_required_field_2('state'); ?> id="countyState" class="houzezSelectFilter houzezSecondList selectpicker form-control bs-select-hidden" data-size="5" data-none-results-text="<?php echo houzez_option('cl_no_results_matched', 'No results matched');?> {0}" data-live-search="true">
            <?php
	        if (houzez_edit_property()) {
	            global $property_data;
	            houzez_taxonomy_edit_hirarchical_options_for_search( $property_data->ID, 'property_state');

	        } else {
	        
	        echo '<option value="">'.houzez_option('cl_none', 'None').'</option>';               
	        $property_state_terms = get_terms (
	            array(
	                "property_state"
	            ),
	            array(
	                'orderby' => 'name',
	                'order' => 'ASC',
	                'hide_empty' => false,
	                'parent' => 0
	            )
	        );

	        houzez_hirarchical_options( 'property_state', $property_state_terms, -1);
	        }
	        ?>
        </select>

	<?php
	} else {
	?>
		<input class="form-control" id="countyState" <?php houzez_required_field_2('state'); ?> name="administrative_area_level_1" value="<?php
	    if (houzez_edit_property()) {
	    	global $property_data;
	        echo houzez_taxonomy_by_postID( $property_data->ID, 'property_state' );
	    }
	    ?>" placeholder="<?php echo houzez_option('cl_state_plac', 'Enter your property county/state'); ?>" type="text">
    <?php } ?>
</div>