<div class="form-group">
	<label for="prop_status">
		<?php echo houzez_option('cl_prop_status', 'Property Status').houzez_required_field('prop_status'); ?>
	</label>

	<select name="prop_status[]" data-size="5" <?php houzez_required_field_2('prop_status'); ?> id="prop_status" class="selectpicker form-control bs-select-hidden" title="<?php echo houzez_option('cl_select', 'Select'); ?>" data-selected-text-format="count > 2" data-none-results-text="<?php echo houzez_option('cl_no_results_matched', 'No results matched');?> {0}" data-live-search="true"  data-actions-box="true" <?php houzez_multiselect(houzez_option('ams_status', 0)); ?> data-select-all-text="<?php echo houzez_option('cl_select_all', 'Select All'); ?>" data-deselect-all-text="<?php echo houzez_option('cl_deselect_all', 'Deselect All'); ?>" data-count-selected-text="{0} <?php echo houzez_option('cl_prop_statuses', 'Statuses'); ?>">
		<?php
        if( !houzez_is_multiselect(houzez_option('ams_status', 0)) ) {
            echo '<option value="">'.houzez_option('cl_select', 'Select').'</option>';
        }
        if (houzez_edit_property()) {
            global $property_data;
            houzez_get_taxonomies_for_edit_listing_multivalue( $property_data->ID, 'property_status');

        } else {
                            
        $property_status_terms = get_terms (
            array(
                "property_status"
            ),
            array(
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => false,
                'parent' => 0
            )
        );

        houzez_get_taxonomies_with_id_value( 'property_status', $property_status_terms, -1);
        }
        ?>
	</select><!-- selectpicker -->
</div><!-- form-group -->