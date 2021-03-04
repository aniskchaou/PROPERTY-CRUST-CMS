<?php
global $post, $banner_type;
$post_id = isset($post->ID) ? $post->ID : '';
if(empty($post_id) && !houzez_is_tax()) {
    return;
}

if(is_page_template(array('template/template-search.php')) && houzez_option('search_result_page') == 'half_map') {
    return;
}

if(houzez_is_tax()) {
    if(houzez_option('tax_show_map')) {
        $banner_type = 'property_map';
    }
} else {
    $banner_type = get_post_meta($post->ID, 'fave_header_type', true);
}

if( !empty( $banner_type ) && $banner_type != 'none' ) {

    if( $banner_type == 'property_slider' ) {
        get_template_part( 'template-parts/banners/property', 'slider' );

    } elseif( $banner_type == 'rev_slider' ) {
        get_template_part( 'template-parts/banners/revolution', 'slider' );

    } elseif( $banner_type == 'property_map' ) {
        get_template_part( 'template-parts/banners/map' );

    } elseif( $banner_type == 'static_image' ) {
        get_template_part( 'template-parts/banners/parallax' );

    } elseif( $banner_type == 'video' ) {
        get_template_part( 'template-parts/banners/video' );
    }
}

// Header Search Start 
if( houzez_search_needed() ) {

    $search_enable = houzez_option('main-search-enable');
    $search_position = houzez_option('search_position');
    $search_pages = houzez_option('search_pages');
    $search_selected_pages = houzez_option('header_search_selected_pages');

    $adv_search_enable = get_post_meta($post->ID, 'fave_adv_search_enable', true);
    $adv_search = get_post_meta($post->ID, 'fave_adv_search', true);
    $adv_search_pos = get_post_meta($post->ID, 'fave_adv_search_pos', true);

    if( isset( $_GET['search_pos'] ) ) {
        $search_enable = 1;
        $search_position = $_GET['search_pos'];
    }

    if( houzez_is_transparent_logo() ) {
        $adv_search_pos = $search_position = 'under_banner';
    }

    if ((!empty($adv_search_enable) && $adv_search_enable != 'global')) {
        if ($adv_search_pos == 'under_banner') {
            if ($adv_search == 'show' || $adv_search == 'hide_show') {
                if( wp_is_mobile() ) {
                    get_template_part('template-parts/search/mobile-search-main');
                } else {
                    get_template_part('template-parts/search/main'); 
                }
            }
        }
    } else {
        if (!is_home() && !is_singular('post')) {
            if ($search_enable != 0 && $search_position == 'under_banner') {

                if( wp_is_mobile() ) {
                    get_template_part('template-parts/search/mobile-search-main');
                } else {
                    if ($search_pages == 'only_home') {
                        if (is_front_page()) {
                            get_template_part('template-parts/search/main'); 
                        }
                    } elseif ($search_pages == 'all_pages') {
                        get_template_part('template-parts/search/main'); 

                    } elseif ($search_pages == 'only_innerpages') {
                        if (!is_front_page()) {
                            get_template_part('template-parts/search/main'); 
                        }
                    } else if( $search_pages == 'specific_pages' ) {
                        if( is_page( $search_selected_pages ) ) {
                            get_template_part('template-parts/search/main'); 
                        }
                    }
                }
            }
        }
    }
}
// Header search End