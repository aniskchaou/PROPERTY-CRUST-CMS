<?php global $is_multi_steps; ?>
<div id="energy-class" class="dashboard-content-block-wrap <?php echo esc_attr($is_multi_steps);?>">
	<h2><?php echo houzez_option('cls_energy_class', 'Energy Class'); ?></h2>
	<div class="dashboard-content-block">
		
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/energy-class'); ?>
			</div>

			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/energy-global-index'); ?>
			</div>

			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/energy-renewable-index'); ?>
			</div>

			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/energy-building'); ?>
			</div>

			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/epc-current-rating'); ?>
			</div>

			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/epc-potential-rating'); ?>
			</div>
		</div><!-- row -->	

	</div><!-- dashboard-content-block -->
</div><!-- dashboard-content-block-wrap -->