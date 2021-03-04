<?php
$header_style = houzez_option('header_style', 4);
$alignClass = '';

if( $header_style == '4' ) {
	$alignClass = houzez_option('header_4_menu_align', 'nav-right');
	if($alignClass == 'nav-right')
		$alignClass = 'justify-content-end';

} elseif($header_style == '1') {
	$alignClass = houzez_option('header_1_menu_align', 'nav-right');
	if($alignClass == 'nav-right')
		$alignClass = 'justify-content-end';
}

if(houzez_is_splash()) {
	$alignClass = houzez_option('splash_menu_align', 'nav-right');
	if($alignClass == 'nav-right')
		$alignClass = 'justify-content-end';
}

if ( has_nav_menu( 'main-menu' ) ) :
	wp_nav_menu( array (
		'theme_location' => 'main-menu',
		'container' => '',
		'container_class' => '',
		'menu_class' => 'navbar-nav '.$alignClass,
		'menu_id' => 'main-nav',
		'depth' => 4,
		'walker' => new houzez_nav_walker()
	));
endif;
?>	