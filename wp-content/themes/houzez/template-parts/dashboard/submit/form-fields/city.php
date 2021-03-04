<?php 
global $required_fields; 
$city = '';
if (houzez_edit_property()) {
	global $property_data;

	$city = houzez_get_post_term_slug($property_data->ID, 'property_city');
}
?>
<div class="form-group">
	<label for="locality"><?php echo houzez_option( 'cl_city', 'City' ).houzez_required_field('city'); ?></label>
	
	<?php
	if(houzez_option('location_dropdowns') == 'yes') { ?>
		<select name="locality" id="city" data-city="<?php echo esc_attr($city); ?>" data-target="houzezFourthList" <?php houzez_required_field_2('city'); ?> class="houzezSelectFilter houzezThirdList selectpicker form-control bs-select-hidden"  data-size="5" data-none-results-text="<?php echo houzez_option('cl_no_results_matched', 'No results matched');?> {0}" data-live-search="true">
            <?php
	        if (houzez_edit_property()) {
	            global $property_data;
	            houzez_taxonomy_edit_hirarchical_options_for_search( $property_data->ID, 'property_city');

	        } else {
	        
	        echo '<option value="">'.houzez_option('cl_none', 'None').'</option>';                
	        $property_city_terms = get_terms (
	            array(
	                "property_city"
	            ),
	            array(
	                'orderby' => 'name',
	                'order' => 'ASC',
	                'hide_empty' => false,
	                'parent' => 0
	            )
	        );

	        houzez_hirarchical_options( 'property_city', $property_city_terms, -1);
	        }
	        ?>
        </select>

	<?php
	} else {
	?>
		<input class="form-control" name="locality" id="city" <?php houzez_required_field_2('city'); ?> value="<?php
	    if (houzez_edit_property()) {
	    	global $property_data;
	        echo houzez_taxonomy_by_postID( $property_data->ID, 'property_city' );
	    }
	    ?>" placeholder="<?php echo houzez_option( 'cl_city_plac', 'Enter the city' ); ?>" type="text">
	<?php } ?>
</div>