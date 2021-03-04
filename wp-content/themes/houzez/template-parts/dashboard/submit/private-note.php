<?php global $is_multi_steps; ?>
<div id="private-note" class="dashboard-content-block-wrap <?php echo esc_attr($is_multi_steps);?>">
	<h2><?php echo houzez_option('cls_private_notes', 'Private Note'); ?></h2>
	<div class="dashboard-content-block">
		<?php get_template_part('template-parts/dashboard/submit/form-fields/private-note'); ?>
	</div><!-- dashboard-content-block -->
</div><!-- dashboard-content-block-wrap -->
