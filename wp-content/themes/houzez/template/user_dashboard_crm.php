<?php
/**
 * Template Name: Houzez CRM
 * Author: Waqas Riaz.
 */
if ( !is_user_logged_in() ) {
    wp_redirect(  home_url() );
}
get_header(); 

if( !class_exists('Houzez_CRM')) {
    $msg = esc_html__('Please install and activate Houzez CRM plugin.', 'houzez');
    wp_die($msg);
}

if( (isset($_GET['hpage']) && $_GET['hpage'] == 'lead-detail') && ( isset($_GET['lead-id']) && $_GET['lead-id'] != '') ) {
    get_template_part('template-parts/dashboard/board/leads/lead-detail'); 

} elseif( isset($_GET['hpage']) && $_GET['hpage'] == 'leads' ) { 
    get_template_part('template-parts/dashboard/board/leads/main'); 

} elseif( isset($_GET['hpage']) && $_GET['hpage'] == 'deals' ) {
	get_template_part('template-parts/dashboard/board/deals/main'); 

} elseif( isset($_GET['hpage']) && $_GET['hpage'] == 'enquiries' && isset($_GET['enquiry']) && !empty($_GET['enquiry']) ) {
	get_template_part('template-parts/dashboard/board/enquires/enquiry-detail');
	
} elseif( isset($_GET['hpage']) && $_GET['hpage'] == 'enquiries' ) {
	get_template_part('template-parts/dashboard/board/enquires/main');

} elseif( isset($_GET['hpage']) && $_GET['hpage'] == 'activities' ) {
	get_template_part('template-parts/dashboard/board/activities');

} else {
	get_template_part('template-parts/dashboard/board/activities');
}

get_footer(); 
?>