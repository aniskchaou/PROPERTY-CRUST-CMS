<?php
$dock_search_enable = houzez_option('enable_advanced_search_over_headers');
$search_over_header_pages = houzez_option('adv_search_over_header_pages');
$search_selected_pages = houzez_option('adv_search_selected_pages');

if( $dock_search_enable != 0 ) {
	if( $search_over_header_pages == 'only_home' ) {
	    if (is_front_page()) {
	        get_template_part('template-parts/search/dock-search');
	    }
	} else if( $search_over_header_pages == 'all_pages' ) {
	    get_template_part('template-parts/search/dock-search');

	} else if ( $search_over_header_pages == 'only_innerpages' ){
	    if (!is_front_page()) {
	        get_template_part('template-parts/search/dock-search');
	    }
	} else if( $search_over_header_pages == 'specific_pages' ) {
	    if( is_page( $search_selected_pages ) ) {
	        get_template_part('template-parts/search/dock-search');
	    }
	}
}