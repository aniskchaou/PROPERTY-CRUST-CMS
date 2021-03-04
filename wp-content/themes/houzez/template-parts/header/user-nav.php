<?php 
if( is_user_logged_in() && houzez_option('header_loggedIn', 0) != 1 ) {
	get_template_part('template-parts/header/partials/logged-in-nav');

} else {
	get_template_part('template-parts/header/partials/login-register');
}
?>