</main><!-- .main-wrap start in header.php-->

<?php 
if( ! houzez_is_half_map() && ! houzez_is_splash() ) {
	if(houzez_is_dashboard()) { 
		get_template_part('template-parts/dashboard/dashboard-footer'); 
	} else {
		
		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
			get_template_part('template-parts/footer/main'); 
		}

		get_template_part('template-parts/listing/compare-properties'); 
	}
}

if( houzez_is_half_map() ) {
	get_template_part('template-parts/listing/compare-properties');
	get_template_part('template-parts/listing/partials/mobile-map-switch');
}

if( wp_is_mobile() ) {
	get_template_part('template-parts/search/mobile-search'); 
}

if( !houzez_is_login_page() ) { 
	get_template_part('template-parts/login-register/modal-login-register'); 
}
get_template_part('template-parts/login-register/modal-reset-password-form'); 

get_template_part('template-parts/listing/listing-lightbox'); 

if(is_singular('property')) {
	get_template_part( 'property-details/mobile-property-contact');
	get_template_part( 'property-details/lightbox');
}

if( ( is_singular('houzez_agency') && houzez_option('agency_form_agency_page', 1) ) || ( is_singular('houzez_agent') && houzez_option('agent_form_agent_page', 1) ) ) {
    get_template_part('template-parts/realtors/contact', 'form'); 
}

if(houzez_is_dashboard()) { 
	if( isset($_GET['hpage']) && $_GET['hpage'] == 'leads' ) {
		get_template_part('template-parts/dashboard/board/leads/new-lead-panel');

	} elseif( isset($_GET['hpage']) && $_GET['hpage'] == 'deals' ) {
		get_template_part('template-parts/dashboard/board/deals/new-deal-panel');

	} elseif( (isset($_GET['hpage']) && $_GET['hpage'] == 'enquiries') || (isset($_GET['hpage']) && ($_GET['hpage'] == 'lead-detail' && $_GET['tab']== 'enquires'))  ) {
		get_template_part('template-parts/dashboard/board/enquires/add-new-enquiry');
	}
}


wp_footer(); ?>

</body>
</html>
