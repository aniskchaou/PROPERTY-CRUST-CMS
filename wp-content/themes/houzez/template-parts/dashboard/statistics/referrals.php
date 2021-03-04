<?php
global $insights_stats, $houzez_local;

$referrers = $insights_stats['others']['referrers'];

?>

<div class="dashboard-content-block dashboard-statistic-block">
	<h3><i class="houzez-icon icon-sign-badge-circle mr-2 primary-text"></i> <?php esc_html_e('Referrals', 'houzez'); ?></h3>
	<ul class="list-unstyled statistic-referrals-list">
		
		<?php 
		$i = 0;
		$output = '';
		if(!empty($referrers)) { 

			foreach ($referrers as $ref) {
				
				$i++;
				$domain = $ref['domain'];
				$visit_counts = $ref['count'];
				$subrefs = $ref['subrefs'];

				$view_text = $houzez_local['view_label'];
				if($visit_counts > 1) {
					$view_text = $houzez_local['views_label'];
				}

				$output .= '<li>';

					$output .= '<div>';
						$output .= '<a data-toggle="collapse" href="#refCollapse'.$i.'" role="button" aria-expanded="false" aria-controls="collapseExample">';
							$output .= esc_attr($domain).' ('.$visit_counts.' '.$view_text.')';
						$output .= '</a>';
					$output .= '</div>';

					$output .= '<div class="collapse" id="refCollapse'.$i.'">';

						$output_inner = '';

						if(!empty($subrefs)) {
							foreach ($subrefs as $sub) {
								$url = $sub['url'];
								$counts = $sub['count'];

								$view_text = $houzez_local['view_label'];
								if($counts > 1) {
									$view_text = $houzez_local['views_label'];
								}

								$output_inner .= esc_attr($url).' ('.$counts.' '.$view_text.')<br/>';
							}
						}

						$output .= $output_inner;
						
					$output .= '</div>';

				$output .= '</li>';
				
			}
		} 
		echo $output;
		?>
		
	</ul>
</div><!-- dashboard-statistic-block -->
