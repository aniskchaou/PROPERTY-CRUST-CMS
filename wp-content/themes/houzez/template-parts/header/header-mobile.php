<div id="header-mobile" class="header-mobile d-flex align-items-center" data-sticky="<?php echo houzez_option('mobile-menu-sticky', 0); ?>">
	<div class="header-mobile-left">
		<button class="btn toggle-button-left">
			<i class="houzez-icon icon-navigation-menu"></i>
		</button><!-- toggle-button-left -->	
	</div><!-- .header-mobile-left -->
	<div class="header-mobile-center flex-grow-1">
		<?php get_template_part('template-parts/header/partials/logo-mobile'); ?>
	</div>

	<div class="header-mobile-right">
		<?php if( houzez_option('header_login') || houzez_option('header_register') || houzez_option('create_lisiting_enable') ) { ?>
		<button class="btn toggle-button-right">
			<i class="houzez-icon icon-single-neutral-circle ml-1"></i>
		</button><!-- toggle-button-right -->	
		<?php } ?>
	</div><!-- .header-mobile-right -->
	
</div><!-- header-mobile -->