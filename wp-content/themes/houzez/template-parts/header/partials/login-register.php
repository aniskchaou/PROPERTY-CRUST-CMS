<?php
$create_lisiting_enable = houzez_option('create_lisiting_enable');
$header_create_listing_template = houzez_get_template_link_2('template/user_dashboard_submit.php');
$create_listing_button_required_login = houzez_option('create_listing_button');
$login_resgiter_type = houzez_option('login_register_type', 'as_icon');
?>
<div class="login-register">
	<ul class="login-register-nav">

		<?php get_template_part('template-parts/header/partials/phone-header-1-4'); ?>
		
		<?php if( class_exists('Houzez_login_register') ): ?>

			<?php 
			if( ( houzez_option('header_login') || houzez_option('header_register') ) && !is_user_logged_in() && !houzez_is_login_page() ) { 

				if( $login_resgiter_type == 'as_text' ) { ?>
					
					<?php if( houzez_option('header_login') ) { ?>
					<li class="login-link">
						<a href="#" data-toggle="modal" data-target="#login-register-form"><?php esc_html_e('Login', 'houzez'); ?></a>
					</li>
					<?php } ?>

					<?php if( houzez_option('header_register') ) { ?>
					<li class="register-link">
						<a href="#" data-toggle="modal" data-target="#login-register-form"><?php esc_html_e('Register', 'houzez'); ?></a>
					</li>
				<?php } 
				 
				} else { ?>
					<li class="login-link">
						<a class="btn btn-icon-login-register" href="#" data-toggle="modal" data-target="#login-register-form"><i class="houzez-icon icon-single-neutral-circle"></i></a>
					</li>
				<?php } 
			} ?>

		<?php endif; ?>

		<?php if( $create_lisiting_enable != 0 ): ?>
		<li>
			<?php
            if( !empty($header_create_listing_template) ) {
                echo '<a href="'.esc_url( $header_create_listing_template ).'" class="btn btn-create-listing hidden-xs hidden-sm">'.houzez_option('dsh_create_listing', 'Create a Listing').'</a>';
            }
            ?>
		</li>
		<?php endif; ?>

	</ul>
</div>