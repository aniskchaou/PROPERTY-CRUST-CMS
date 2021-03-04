<?php global $is_multi_steps; ?>
<div id="contact-info" class="dashboard-content-block-wrap <?php echo esc_attr($is_multi_steps);?>">
	<h2><?php echo houzez_option('cls_contact_info', 'Contact Information'); ?></h2>
	<div class="dashboard-content-block">
		<p><?php echo houzez_option('cl_contact_info_text', 'What information do you want to display in agent data container?'); ?></p>

		<?php get_template_part('template-parts/dashboard/submit/form-fields/contact-info'); ?>

	</div><!-- dashboard-content-block -->
</div><!-- dashboard-content-block-wrap -->

