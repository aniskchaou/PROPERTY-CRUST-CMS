<?php 
$header_width = houzez_option('header_4_width');
if( houzez_is_splash() ) {
	$header_width = houzez_option('splash_layout');
}
if(houzez_is_half_map()) {
    $header_width = 'container-fluid';
}
$sticky_header = houzez_option('main-menu-sticky', 0);
?>
<div id="header-section" class="header-desktop header-v4" data-sticky="<?php echo intval($sticky_header); ?>">
	<div class="<?php echo esc_attr($header_width); ?>">
		<div class="header-inner-wrap">
			<div class="navbar d-flex align-items-center">

				<?php get_template_part('template-parts/header/partials/logo'); ?>

				<nav class="main-nav on-hover-menu navbar-expand-lg flex-grow-1">
					<?php get_template_part('template-parts/header/partials/nav'); ?>
				</nav><!-- main-nav -->

				<?php get_template_part('template-parts/header/user-nav'); ?>

			</div><!-- navbar -->
		</div><!-- header-inner-wrap -->
	</div><!-- .container -->    
</div><!-- .header-v1 -->