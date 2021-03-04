<?php
$multi_units  = houzez_get_listing_data('multi_units');

if (!empty($multi_units)) {
?>
<div class="fw-property-sub-listings-wrap fw-property-section-wrap" id="property-sub-listings-wrap">
	<div class="block-wrap">
		<div class="block-title-wrap">
			<h2><?php echo houzez_option('sps_sub_listings', 'Sub Listings'); ?></h2>
		</div><!-- block-title-wrap -->
		<div class="block-content-wrap">
			<table class="sub-listings-table table-lined responsive-table">
				<thead>
					<tr>
						<th><?php esc_html_e('Title', 'houzez'); ?></th>
                        <th><?php esc_html_e('Property Type', 'houzez'); ?></th>
                        <th><?php esc_html_e('Price', 'houzez'); ?></th>
                        <th><?php esc_html_e('Beds', 'houzez'); ?></th>
                        <th><?php esc_html_e('Baths', 'houzez'); ?></th>
                        <th><?php esc_html_e('Property Size', 'houzez'); ?></th>
                        <th><?php esc_html_e('Availability Date', 'houzez'); ?></th>
					</tr>
				</thead>
				<tbody>

					<?php 
					$mu_price_postfix = '';
					foreach( $multi_units as $mu ):

                        if( !empty( $mu['fave_mu_price_postfix'] ) ) {
                            $mu_price_postfix = ' / '.$mu['fave_mu_price_postfix'];
                        }
                        ?>
						<tr>
							<td data-label="<?php esc_html_e('Title', 'houzez'); ?>">
								<strong><?php echo esc_attr( $mu['fave_mu_title'] ); ?></strong>
							</td>
							<td data-label="<?php esc_html_e('Property Type', 'houzez'); ?>"><?php echo esc_attr( $mu['fave_mu_type'] ); ?></td>
							<td data-label="<?php esc_html_e('Price', 'houzez'); ?>">
								<strong><?php echo houzez_get_property_price( $mu['fave_mu_price'] ).$mu_price_postfix; ?></strong>
							</td>
							<td data-label="<?php esc_html_e('Beds', 'houzez'); ?>"><?php echo esc_attr( $mu['fave_mu_beds'] ); ?> </td>
							<td data-label="<?php esc_html_e('Baths', 'houzez'); ?>"><?php echo esc_attr( $mu['fave_mu_baths'] ); ?> </td>
							<td data-label="<?php esc_html_e('Property Size', 'houzez'); ?>"><?php echo houzez_get_area_size($mu['fave_mu_size']).' '.houzez_get_size_unit( $mu['fave_mu_size_postfix'] ); ?></td>
							<td data-label="<?php esc_html_e('Availability Date', 'houzez'); ?>"><?php echo esc_attr( $mu['fave_mu_availability_date'] ); ?></td>
						</tr>
					<?php endforeach; ?>
					
				</tbody>
			</table>
		</div><!-- block-content-wrap -->
	</div><!-- block-wrap -->
</div><!-- property-address-wrap -->
<?php } ?>