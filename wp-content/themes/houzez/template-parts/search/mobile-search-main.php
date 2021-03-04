<?php
$search_enable = houzez_option('main-search-enable');
$search_position = houzez_option('search_position');
$search_pages = houzez_option('search_pages');
$search_selected_pages = houzez_option('header_search_selected_pages');

if (!is_home() && !is_singular('post')) {
	if ($search_enable != 0) {
		if ($search_pages == 'only_home') {
			if (is_front_page()) {
				get_template_part('template-parts/search/search-mobile-nav'); 
			}
		} elseif ($search_pages == 'all_pages') {
			get_template_part('template-parts/search/search-mobile-nav'); 

		} elseif ($search_pages == 'only_innerpages') {
			if (!is_front_page()) {
				get_template_part('template-parts/search/search-mobile-nav'); 
			}
		} else if( $search_pages == 'specific_pages' ) {
		    if( is_page( $search_selected_pages ) ) {
		        get_template_part('template-parts/search/search-mobile-nav');
		    }
		}
	}
}