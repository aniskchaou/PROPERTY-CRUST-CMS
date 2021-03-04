<?php
global $current_user, $houzez_local, $hide_prop_fields, $required_fields, $is_multi_steps;
$is_multi_currency = houzez_option('multi_currency');
$default_multi_currency = get_the_author_meta( 'fave_author_currency' , $current_user->ID );
if(empty($default_multi_currency)) {
    $default_multi_currency = houzez_option('default_multi_currency');
}
?>
<div id="description-price" class="dashboard-content-block-wrap <?php echo esc_attr($is_multi_steps);?>">
	<h2><?php echo houzez_option('cls_description', 'Description'); ?></h2>

	<div class="dashboard-content-block">
		<?php get_template_part('template-parts/dashboard/submit/form-fields/title'); ?>
		
		<?php get_template_part('template-parts/dashboard/submit/form-fields/description'); ?>

		<div class="row">
			<?php if( $hide_prop_fields['prop_type'] != 1 ) { ?>
			<div class="col-md-4 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/type'); ?>
			</div>
			<?php } ?>

			<?php if( $hide_prop_fields['prop_status'] != 1 ) { ?>
			<div class="col-md-4 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/status'); ?>
			</div>
			<?php } ?>

			<?php if( $hide_prop_fields['prop_label'] != 1 ) { ?>
			<div class="col-md-4 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/label'); ?>
			</div>
			<?php } ?>
		</div>
	</div><!-- dashboard-content-block -->

	<h2><?php echo houzez_option('cls_price', 'Price'); ?></h2>
	<div class="dashboard-content-block">
		<div class="row">
			
			<?php get_template_part('template-parts/dashboard/submit/form-fields/currency'); ?>

			<?php if( $hide_prop_fields['sale_rent_price'] != 1 ) { ?>
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/sale-price'); ?>
			</div><!-- col-md-6 col-sm-12 -->
			<?php } ?>

			<?php if( $hide_prop_fields['second_price'] != 1 ) { ?>
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/second-price'); ?>
			</div><!-- col-md-6 col-sm-12 -->
			<?php } ?>

			<?php if( $hide_prop_fields['price_postfix'] != 1 ) { ?>
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/after-price-label'); ?>
			</div><!-- col-md-6 col-sm-12 -->
			<?php } ?>

			<?php if( $hide_prop_fields['price_prefix'] != 1 ) { ?>
			<div class="col-md-6 col-sm-12">
				<?php get_template_part('template-parts/dashboard/submit/form-fields/price-prefix'); ?>
			</div><!-- col-md-6 col-sm-12 -->
			<?php } ?>
			
		</div><!-- row -->
	</div><!-- dashboard-content-block -->
</div><!-- dashboard-content-block-wrap -->

