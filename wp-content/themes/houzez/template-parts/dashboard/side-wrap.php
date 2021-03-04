<?php
$dashboard_logo = houzez_option( 'dashboard_logo', false, 'url' );
?>
<div class="dashboard-logo-wrap">
	
	<div class="dash-logo logo">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img src="<?php echo esc_url($dashboard_logo); ?>" alt="logo">
		</a>
	</div><!-- .logo -->

	<!-- <div class="dashboard-notification-wrap">
		<i class="houzez-icon icon-alarm-bell"></i>		
		<span class="notification-circle"></span>
	</div> -->
</div><!-- dashboard-logo-wrap -->
<div class="dashboard-side-menu-wrap">
	<?php get_template_part('template-parts/dashboard/dashboard-menu'); ?>
</div><!-- dashboard-side-menu-wrap -->