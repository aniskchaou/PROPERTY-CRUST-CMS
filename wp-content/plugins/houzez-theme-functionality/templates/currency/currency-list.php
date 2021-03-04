<?php $add_currency = Houzez_Currencies::currency_add_link(); ?>

<h2 class="houzez-heading-inline"><?php esc_html_e('Currencies', 'houzez-theme-functionality');?></h2>
<a href="<?php echo esc_url($add_currency);?>" class="page-title-action"><?php esc_html_e('Add New', 'houzez-theme-functionality');?></a>

<br/>
<table class="wp-list-table widefat fixed striped">
	<thead>
		<tr>
			<th scope="col" class="manage-column column-title column-primary desc"><span><?php esc_html_e('Name', 'houzez-theme-functionality');?></span></span></a></th>
			<th scope="col" class="manage-column column-title column-primary desc"><span><?php esc_html_e('Code', 'houzez-theme-functionality');?></span></span></a></th>
			<th scope="col" class="manage-column column-title column-primary desc"><span><?php esc_html_e('Symbol', 'houzez-theme-functionality');?></span></span></a></th>
			<th scope="col" class="manage-column column-title column-primary desc"><span><?php esc_html_e('Position', 'houzez-theme-functionality');?></span></span></a></th>
			<th scope="col" class="manage-column column-title column-primary desc"><span><?php esc_html_e('N. of Decimal Point', 'houzez-theme-functionality');?></span></span></a></th>
			<th scope="col" class="manage-column column-title column-primary desc"><span><?php esc_html_e('Decimal Point Separator', 'houzez-theme-functionality');?></span></span></a></th>
			<th scope="col" class="manage-column column-title column-primary desc"><span><?php esc_html_e('Thousands Separator', 'houzez-theme-functionality');?></span></span></a></th>
			<th scope="col" class="manage-column column-title column-primary desc"><span><?php esc_html_e('Edit', 'houzez-theme-functionality');?></span></span></a></th>
			<th scope="col" class="manage-column column-title column-primary desc"><span><?php esc_html_e('Delete', 'houzez-theme-functionality');?></span></span></a></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$form_fields = Houzez_Currencies::get_form_fields();

		if($form_fields) {
			foreach ( $form_fields as $data ) { 
				$edit_link = Houzez_Currencies::currency_edit_link( $data->id );
				$delete_link = Houzez_Currencies::currency_delete_link( $data->id );
				?>

				<tr>
					<td><?php echo $data->currency_name; ?></td>
					<td><?php echo $data->currency_code; ?></td>
					<td><?php echo $data->currency_symbol; ?></td>
					<td><?php echo $data->currency_position; ?></td>
					<td><?php echo $data->currency_decimal; ?></td>
					<td><?php echo $data->currency_decimal_separator; ?></td>
					<td><?php echo $data->currency_thousand_separator; ?></td>
					<td>
						<a href="<?php echo esc_url($edit_link); ?>" class=""
							title="<?php esc_html_e( 'Edit field', 'houzez-theme-functionality' ); ?>"><i class="dashicons dashicons-edit"></i>
						</a>
					</td>
					<td>
						<a href="<?php echo esc_url($delete_link); ?>" class=""
							title="<?php esc_html_e( 'Delete field', 'houzez-theme-functionality' ); ?>"><i class="dashicons dashicons-trash" ></i>
						</a>
					</td>
				</tr>
				<?php		
			}
		}
		?>

	</tbody>
</table>
