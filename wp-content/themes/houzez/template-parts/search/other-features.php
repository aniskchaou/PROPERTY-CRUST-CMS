<div class="features-list-wrap">
	<a class="btn-features-list" data-toggle="collapse" href="#features-list">
		<i class="houzez-icon icon-add-square"></i> <?php echo houzez_option('srh_other_features', 'Other Features'); ?>
	</a><!-- btn-features-list -->
	<div id="features-list" class="collapse">
		<div class="features-list">
			<?php get_template_part('template-parts/search/fields/feature-field'); ?>
		</div><!-- features-list -->
	</div><!-- collapse -->
</div><!-- features-list-wrap -->