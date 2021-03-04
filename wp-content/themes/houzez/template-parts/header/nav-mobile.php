<div class="nav-mobile">
    <div class="main-nav navbar slideout-menu slideout-menu-left" id="nav-mobile">
        <?php get_template_part('template-parts/header/partials/mobile-nav'); ?>
    </div><!-- main-nav -->
    <?php 
	if( is_user_logged_in() ) {

		if( wp_is_mobile() ) {
			get_template_part('template-parts/header/partials/mobile-user-nav');

		} else {
			get_template_part('template-parts/header/partials/logged-in-nav');
		}
		

	} else {
		get_template_part('template-parts/header/partials/login-register-mobile');
	}
	?>  
</div><!-- nav-mobile -->