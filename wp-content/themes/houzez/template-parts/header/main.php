<header class="header-main-wrap <?php houzez_transparent(); ?>">
    <?php
		if( houzez_option('top_bar') ) {
			get_template_part('template-parts/topbar/top', 'bar');
		}

    	$header = houzez_option('header_style'); 
    	if(empty($header) || houzez_is_splash()) {
    		$header = '4';
    	}
	    get_template_part('template-parts/header/header', $header); 
	    get_template_part('template-parts/header/header-mobile'); 
    ?>
</header><!-- .header-main-wrap -->