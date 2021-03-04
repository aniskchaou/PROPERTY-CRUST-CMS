<?php
global $agency_total_listing, $properties_ids;

$taxnonomies = $tax_chart_data = $taxs_list_data = $total_count = $stats_array = array();

foreach ($properties_ids as $listing_id) {
	$term = get_the_terms( $listing_id, 'property_type' );
	
	if( $term && ! is_wp_error( $term ) ) {
		$taxnonomies[$term[0]->slug] = $term[0]->name;
	}
}

$taxnonomies = array_filter($taxnonomies);
foreach ($taxnonomies as $slug => $name) {
	$count = houzez_realtor_stats('property_type', 'fave_property_agency', get_the_ID(), $slug);
	if(!empty($count) && !empty($agency_total_listing)) {
		$total_count[] = $count;
		$stats_array[$name] = ($count / $agency_total_listing) * 100;
	}
}

arsort($stats_array);

$vl = array_values($stats_array);
$tax_chart_data = array_slice($vl, 0, 3);
$keys = array_keys($stats_array);
$taxs_list_data = array_slice($keys, 0, 3);

rsort($total_count);
$total_count = array_slice($total_count, 0, 3);
$total_records = count($total_count);
$total_count = array_sum($total_count);

if(!empty($total_count)) {
	$others = $agency_total_listing - $total_count;

	$other_percent = ($others / $agency_total_listing) * 100;
	if(!empty($other_percent)) {
		$tax_chart_data[] = $other_percent;
	}
}
if( !empty($taxnonomies) ) { ?>
<div class="agent-profile-chart-wrap">
	<h2><?php echo wp_kses(__( '<span>Property</span> Types', 'houzez' ), houzez_allowed_html() ); ?></h2>

	<div class="d-flex align-items-center">
		<div class="agent-profile-chart">
			<canvas id="stats-property-types" data-chart="<?php echo json_encode($tax_chart_data); ?>" width="100" height="100"></canvas>
		</div><!-- agent-profile-chart -->
		<div class="agent-profile-data">
			<ul class="list-unstyled">
				<?php
				$j = $k = 0;
				if(!empty($taxs_list_data) && !empty($total_count)) {
					foreach ($taxs_list_data as $taxnonomy) { $j++;

						if($j <= $total_records) {

							$percent = round($tax_chart_data[$k]);
							if(!empty($percent)) {
							echo '<li class="stats-data-'.$j.'">
									<i class="houzez-icon icon-sign-badge-circle mr-1"></i> <strong>'.esc_attr($percent).'%</strong> <span>'.esc_attr($taxnonomy).'</span>
								</li>';
							}
						}
						$k++;
					}

					if(!empty($others)) {
						$num = '4';
						if($j <= 2) {
							$num = '3';
						}
						echo '<li class="stats-data-'.$num.'">
								<i class="houzez-icon icon-sign-badge-circle mr-1"></i> <strong>'.round($other_percent).'%</strong> <span>'.esc_html__('Other', 'houzez').'</span>
							</li>';
					}
					
				}
				?>
			</ul>
		</div><!-- agent-profile-data -->
	</div><!-- d-flex -->
</div><!-- agent-profile-chart-wrap -->
<?php } ?>