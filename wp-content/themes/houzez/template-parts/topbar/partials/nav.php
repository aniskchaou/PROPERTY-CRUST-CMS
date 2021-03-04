<nav class="top-bar-nav navbar-expand-lg">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#top-bar-nav" aria-controls="top-bar-nav" aria-expanded="false" aria-label="<?php esc_html_e('Toggle navigation', 'houzez'); ?>">
		<i class="houzez-icon icon-navigation-menu"></i>
	</button>
	<?php
	// Pages Menu
	if ( has_nav_menu( 'top-menu' ) ) :
	    wp_nav_menu( array (
	        'theme_location' => 'top-menu',
	        'container' => 'div',
	        'container_class' => 'collapse navbar-collapse',
	        'container_id' => 'top-bar-nav',
	        'menu_class' => 'navbar-nav',
	        'menu_id' => '',
	        'walker' => new houzez_nav_walker(),
	        'depth' => 2
	    ));
	endif;
	?>
</nav><!-- main-nav -->