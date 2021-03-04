<?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
<div class="footer-nav">
	<?php
	// Pages Menu
	wp_nav_menu( array (
		'theme_location' => 'footer-menu',
		'container' => '',
		'container_class' => '',
		'menu_class' => 'nav',
		'menu_id' => 'footer-menu',
		'depth' => 1
	));
	?>
</div>
<?php endif; ?>