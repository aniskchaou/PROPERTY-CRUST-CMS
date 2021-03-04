<?php
// Pages Menu
if ( has_nav_menu( 'main-menu-left' ) ) :
	wp_nav_menu( array (
		'theme_location' => 'main-menu-left',
		'container' => '',
		'container_class' => '',
		'menu_class' => 'navbar-nav',
		'menu_id' => 'main-menu-left',
		'depth' => 4,
		'walker' => new houzez_nav_walker()
	));
endif;
?>


