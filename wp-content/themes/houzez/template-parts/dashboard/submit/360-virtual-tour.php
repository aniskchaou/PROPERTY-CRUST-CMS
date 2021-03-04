<?php global $is_multi_steps; ?>
<div id="virtual-tour" class="dashboard-content-block-wrap <?php echo esc_attr($is_multi_steps);?>">
	<h2><?php echo houzez_option('cls_virtual_tour', '360° Virtual Tour'); ?></h2>
	<div class="dashboard-content-block">
		<?php get_template_part('template-parts/dashboard/submit/form-fields/virtual-tour'); ?>
	</div><!-- dashboard-content-block -->
</div><!-- dashboard-content-block-wrap -->

