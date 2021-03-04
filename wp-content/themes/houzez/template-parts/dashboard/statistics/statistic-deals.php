<?php
$active_deals = Houzez_Deals::get_total_deals_by_group('active');
$won_deals = Houzez_Deals::get_total_deals_by_group('won');
$lost_deals = Houzez_Deals::get_total_deals_by_group('lost');
?>
<div class="dashboard-content-block dashboard-statistic-block">
	<h3><i class="houzez-icon icon-sign-badge-circle mr-2 primary-text"></i> <?php esc_html_e('Deals', 'houzez'); ?></h3>
	<div class="d-flex align-items-center sm-column">
		<div class="statistic-doughnut-chart">
			<canvas id="deals-doughnut-chart" data-active="<?php echo intval($active_deals); ?>" data-won="<?php echo intval($won_deals); ?>" data-lost="<?php echo intval($lost_deals); ?>" width="100" height="100"></canvas>
		</div><!-- mortgage-calculator-chart -->
		<div class="doughnut-chart-data flex-fill">
			<ul class="list-unstyled">
				<li class="stats-data-3">
					<i class="houzez-icon icon-sign-badge-circle mr-1"></i> 
					<strong><?php esc_html_e('Active', 'houzez'); ?></strong> 
					<span><?php echo number_format_i18n($active_deals); ?> <small><?php esc_html_e('Deals', 'houzez'); ?></small></span>
				</li>
				<li class="stats-data-4">
					<i class="houzez-icon icon-sign-badge-circle mr-1"></i> 
					<strong><?php esc_html_e('Won', 'houzez'); ?></strong> 
					<span><?php echo number_format_i18n($won_deals); ?> <small><?php esc_html_e('Deals', 'houzez'); ?></small></span>
				</li>
				<li class="stats-data-1">
					<i class="houzez-icon icon-sign-badge-circle mr-1"></i> 
					<strong><?php esc_html_e('Lost', 'houzez'); ?></strong> 
					<span><?php echo number_format_i18n($lost_deals); ?> <small><?php esc_html_e('Deals', 'houzez'); ?></small></span>
				</li>
			</ul>
		</div><!-- mortgage-calculator-data -->
	</div><!-- d-flex -->
</div><!-- dashboard-statistic-block -->
