<?php global $is_multi_steps; ?>
<div id="features" class="dashboard-content-block-wrap <?php echo esc_attr($is_multi_steps);?>">
	<h2><?php echo houzez_option('cls_features', 'Features'); ?></h2>
	<div class="dashboard-content-block">
		<div class="row">
			<?php get_template_part('template-parts/dashboard/submit/form-fields/features'); ?>
		</div><!-- row -->			
	</div><!-- dashboard-content-block -->
</div><!-- dashboard-content-block-wrap -->
