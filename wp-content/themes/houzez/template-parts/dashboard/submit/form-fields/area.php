<?php
$area = '';
if (houzez_edit_property()) {
	global $property_data;

	$area = houzez_get_post_term_slug($property_data->ID, 'property_area');
}
?>
<div class="form-group">
	<label for="neighborhood"><?php echo houzez_option( 'cl_area', 'Area' ).houzez_required_field('area'); ?></label>

	<?php
	if(houzez_option('location_dropdowns') == 'yes') { ?>
		<select name="neighborhood" data-area="<?php echo esc_attr($area); ?>" data-size="5" id="neighborhood" <?php houzez_required_field_2('area'); ?> class=" houzezSelectFilter houzezFourthList selectpicker form-control bs-select-hidden" data-live-search="true" data-none-results-text="<?php echo houzez_option('cl_no_results_matched', 'No results matched');?> {0}">
            <?php
	        if (houzez_edit_property()) {
	            global $property_data;
	            houzez_taxonomy_edit_hirarchical_options_for_search( $property_data->ID, 'property_area');

	        } else {
	         
	        echo '<option value="">'.houzez_option('cl_none', 'None').'</option>';                  
	        $property_area_terms = get_terms (
	            array(
	                "property_area"
	            ),
	            array(
	                'orderby' => 'name',
	                'order' => 'ASC',
	                'hide_empty' => false,
	                'parent' => 0
	            )
	        );

	        houzez_hirarchical_options( 'property_area', $property_area_terms, -1);
	        }
	        ?>
        </select>

	<?php
	} else {
	?>
		<input class="form-control" id="neighborhood" <?php houzez_required_field_2('area'); ?> name="neighborhood" value="<?php
	    if (houzez_edit_property()) {
	        global $property_data;
		    echo houzez_taxonomy_by_postID( $property_data->ID, 'property_area' );
	    }
	    ?>" placeholder="<?php echo houzez_option( 'cl_area_plac', 'Enter the area' ); ?>" type="text">
    <?php } ?>
</div>