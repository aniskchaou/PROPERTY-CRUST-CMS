<?php
// Pages Menu
if ( has_nav_menu( 'main-menu-right' ) ) :
	wp_nav_menu( array (
		'theme_location' => 'main-menu-right',
		'container' => '',
		'container_class' => '',
		'menu_class' => 'navbar-nav',
		'menu_id' => 'main-menu-right',
		'depth' => 4,
		'walker' => new houzez_nav_walker()
	));
endif;
?>