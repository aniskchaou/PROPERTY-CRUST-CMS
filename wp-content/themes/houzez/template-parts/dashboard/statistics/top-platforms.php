<?php
global $insights_stats, $houzez_local;

$count_label = $houzez_local['views_label'];
$chart_data = array();
$other_data = array();
$platforms = $insights_stats['others']['platforms'];

$total_platforms = count($platforms);

$j = 0;
foreach ($platforms as $b) {
	$j++;

	if( $total_platforms > 4 ) {
		if( $j <= 3 ) {
			$chart_data[] = $b['count'];
		} else {
			$other_data[] = $b['count'];
		}
	} else {

		$chart_data[] = $b['count'];
	}
	
	
}

$total_other_data = array_sum($other_data);

$num_other_records = count($other_data);
if($num_other_records > 0) {

	$chart_data[] = $total_other_data;
}
?>
<div class="dashboard-content-block dashboard-statistic-block">
	<h3><i class="houzez-icon icon-sign-badge-circle mr-2 primary-text"></i> <?php esc_html_e('Top Platforms', 'houzez'); ?></h3>
	<?php if( !empty($platforms)) { ?>
	<div class="d-flex align-items-center sm-column">
		<div class="statistic-doughnut-chart">
			<canvas id="top-platforms-doughnut-chart" data-chart='<?php echo json_encode($chart_data); ?>' width="100" height="100"></canvas>
		</div><!-- mortgage-calculator-chart -->
		<div class="doughnut-chart-data flex-fill">
			<ul class="list-unstyled">
				<?php 
				$i = 0;
				foreach( $platforms as $platform ) { $i++; 

					if($num_other_records > 0) {
						if($i == 4) break;
					}

					$platform_name = $platform['name'];
					$platform_count = $platform['count'];

					if(empty($platform_name)) {
						$platform_name = esc_html__('Unknown', 'houzez');
					}

					if($platform_count == 1)
						$count_label = $houzez_local['view_label'];
				
					echo '<li class="stats-data-'.$i.'">
						<i class="houzez-icon icon-sign-badge-circle mr-1"></i> 
						<strong>'.esc_attr($platform_name).'</strong> 
						<span>'.number_format_i18n($platform_count).' <small>'.$count_label.'</small></span>
						</li>';
				} 
				?>

				<?php 
				if(!empty($num_other_records)) { 

					$num = '4';
					if($j <= 2) {
						$num = '3';
					}
					if($total_other_data == 1)
						$count_label = $houzez_local['view_label'];

					echo '<li class="stats-data-'.$num.'">
						<i class="houzez-icon icon-sign-badge-circle mr-1"></i> 
						<strong>'.esc_html__('Other', 'houzez').'</strong> 
						<span>'.number_format_i18n($total_other_data).' <small>'.$count_label.'</small></span>
						</li>';
				} 
				?>
			</ul>
		</div><!-- mortgage-calculator-data -->
	</div><!-- d-flex -->
	<?php } ?>
</div><!-- dashboard-statistic-block -->
