<?php 
global $post, $sticky_hidden, $sticky_data, $hidden_data;
$sticky_hidden = $sticky_data = '';
$hidden_data = '0';
if( !is_404() && !is_search() ) {
    $adv_search_enable = get_post_meta($post->ID, 'fave_adv_search_enable', true);
    $adv_search = get_post_meta($post->ID, 'fave_adv_search', true);
}
if( wp_is_mobile() ) {
    $search_sticky = houzez_option('mobile-search-sticky');
} else {
    $search_sticky = houzez_option('main-search-sticky');
}

if ((!empty($adv_search_enable) && $adv_search_enable != 'global')) {
    if ($adv_search == 'hide_show') {
        $sticky_data = '1';
        $sticky_hidden = 'search-hidden';
        $hidden_data = '1';
    } else {
        $sticky_data = $search_sticky;
        $sticky_hidden = '';
        $hidden_data = '0';
    }
} else {
    $sticky_data = $search_sticky;
}

if( houzez_adv_search_visible() ) {
    $sticky_data = $hidden_data = '0';
    $sticky_hidden = '';
}
$search_style = houzez_option('search_style', 'style_1');

if(isset($_GET['search_style']) && !empty($_GET['search_style'])) {
    $search_style = $_GET['search_style'];
}

if( (!houzez_option('single_prop_search') && is_singular('property')) || (!houzez_option('single_agent_search') && is_singular('houzez_agent')) || (!houzez_option('single_agent_search') && is_singular('houzez_agency')) || ( !houzez_option('is_tax_page', 1) && is_tax() ) ) {
	return;
}

if( !wp_is_mobile() ) {
	
    if($search_style == 'style_1') {
        get_template_part('template-parts/search/search-v1'); 
    } elseif($search_style == 'style_2') {
        get_template_part('template-parts/search/search-v2'); 
    } elseif($search_style == 'style_3') {
        get_template_part('template-parts/search/search-v3'); 
    }
}