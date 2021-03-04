<?php
global $insights_stats, $houzez_local;

$lastmonth = $insights_stats['charts']['lastmonth'];

$views = $unique_views = $labels = array();

foreach ($lastmonth as $value) {
	$views[] = $value['views'];
	$unique_views[] = $value['unique_views'];
	$labels[] = $value['label'];
}
?>
<canvas id="visits-chart-30d" data-labels='<?php echo json_encode($labels); ?>' data-views='<?php echo json_encode($views); ?>' data-unique='<?php echo json_encode($unique_views); ?>' data-visit-label="<?php echo esc_attr($houzez_local['visits_label']); ?>" data-unique-label="<?php echo esc_attr($houzez_local['unique_label']); ?>" width="500" height="150"></canvas>