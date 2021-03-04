<?php
if ( has_nav_menu( 'main-menu' ) ) :
	wp_nav_menu( array (
		'theme_location' => 'main-menu',
		'container' => '',
		'container_class' => '',
		'menu_class' => 'navbar-nav mobile-navbar-nav',
		'menu_id' => 'mobile-main-nav',
		'depth' => 4,
		'walker' => new houzez_mobile_nav_walker()
	));
endif;
?>	