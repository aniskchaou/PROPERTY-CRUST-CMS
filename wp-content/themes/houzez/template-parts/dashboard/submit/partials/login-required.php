<div class="dashboard-content-block-wrap">
	
	<div class="submit-login-required" style="padding-bottom: 9rem;">
		<?php echo wp_kses( __( '<strong>Login Required:</strong> Please login to submit property!.', 'houzez' ), houzez_allowed_html() ); ?>
			
			<?php if( houzez_option('header_login') != 0 ) { ?>
			<span class="login-link"><a href="#" data-toggle="modal" data-target="#login-register-form"><?php esc_html_e('Login', 'houzez'); ?></a></span> 
			<?php } ?>

			<?php if( houzez_option('header_register') != 0 ) { ?>
			- 
			<span class="register-link"><a href="#" data-toggle="modal" data-target="#login-register-form"><?php esc_html_e('Register', 'houzez'); ?></a></span> 
			<?php } ?>
			
			
	</div>

</div><!-- dashboard-content-block-wrap -->