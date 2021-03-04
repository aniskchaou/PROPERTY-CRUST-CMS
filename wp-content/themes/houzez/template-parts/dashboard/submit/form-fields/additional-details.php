<table class="dashboard-table additional-details-table">
	<thead>
		<tr>
			<td>
				<label><?php echo houzez_option('cl_additional_title', 'Title'); ?></label>
			</td>
			<td>
				<label><?php echo houzez_option('cl_additional_value', 'Value'); ?></label>
			</td>
			<td></td>
			<td></td>
		</tr>
	</thead>
	<tbody id="houzez_additional_details_main">
		<?php
		$data_increment = 0;
		if(houzez_edit_property()) {
			global $property_data;
			$additional_features = get_post_meta( $property_data->ID, 'additional_features', true );
			$count = 0;

			if( !empty($additional_features) ) {
                foreach ($additional_features as $add_feature): 
                	$add_title = isset($add_feature['fave_additional_feature_title']) ? $add_feature['fave_additional_feature_title'] : '';
                	$add_value = isset($add_feature['fave_additional_feature_value']) ? $add_feature['fave_additional_feature_value'] : '';
                	?>

                	<tr>
						<td class="table-half-width">
							<input class="form-control" name="additional_features[<?php echo esc_attr( $count ); ?>][fave_additional_feature_title]" placeholder="<?php echo houzez_option('cl_additional_title_plac', 'Eg: Equipment' ); ?>" type="text" value="<?php echo esc_attr($add_title); ?>">
						</td>
						<td class="table-half-width">
							<input class="form-control" name="additional_features[<?php echo esc_attr( $count ); ?>][fave_additional_feature_value]" placeholder="<?php echo houzez_option( 'cl_additional_value', 'Grill - Gas' ); ?>" type="text" value="<?php echo esc_attr($add_value); ?>">
						</td>
						<td class="">
							<a class="sort-additional-row btn btn-light-grey-outlined"><i class="houzez-icon icon-navigation-menu"></i></a>
						</td>
						<td>
							<button data-remove="<?php echo esc_attr( $count ); ?>" class="remove-additional-row btn btn-light-grey-outlined"><i class="houzez-icon icon-close"></i></button>
						</td>
					</tr>
            <?php
                	$count++;
                endforeach;
            }

            $data_increment = $count - 1;
		} else {
		?>
		<tr>
			<td class="table-half-width">
				<input class="form-control" name="additional_features[0][fave_additional_feature_title]" placeholder="<?php echo houzez_option('cl_additional_title_plac', 'Eg: Equipment' ); ?>" type="text">
			</td>
			<td class="table-half-width">
				<input class="form-control" name="additional_features[0][fave_additional_feature_value]" placeholder="<?php echo houzez_option( 'cl_additional_value', 'Grill - Gas' ); ?>" type="text">
			</td>
			<td class="">
				<a class="sort-additional-row btn btn-light-grey-outlined"><i class="houzez-icon icon-navigation-menu"></i></a>
			</td>
			<td>
				<button data-remove="0" class="remove-additional-row btn btn-light-grey-outlined"><i class="houzez-icon icon-close"></i></button>
			</td>
		</tr>
	<?php } ?>
	</tbody>
    <tfoot>
		<tr >
			<td colspan="4">
				<button data-increment="<?php echo esc_attr($data_increment); ?>" class="add-additional-row btn btn-primary btn-left-icon mt-2"><i class="houzez-icon icon-add-circle"></i> <?php esc_html_e( 'Add New', 'houzez' ); ?></button>
			</td>
		</tr>
	</tfoot>
	</tbody>
</table>