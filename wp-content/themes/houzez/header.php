<?php
global $houzez_local;
$houzez_local = houzez_get_localization();
/**
 * @package Houzez
 * @since Houzez 1.0
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
    <meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php get_template_part('template-parts/header/nav-mobile'); ?>

<?php if(houzez_is_dashboard()) { ?>

	<main id="main-wrap" class="main-wrap dashboard-main-wrap">
	<?php get_template_part('template-parts/header/header-mobile'); ?>

<?php } else { ?>

	<main id="main-wrap" class="main-wrap <?php if(houzez_is_splash()) { echo 'splash-page-wrap'; }?>">

	<?php 
	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
		get_template_part('template-parts/header/main'); 
	}?>

	<?php 
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


		if ((!empty($adv_search_enable) && $adv_search_enable != 'global') && !houzez_is_transparent_logo()) {
			if ($adv_search_pos == 'under_menu') {
				if ($adv_search == 'show' || $adv_search == 'hide_show') {
					if( wp_is_mobile() ) {
						get_template_part('template-parts/search/mobile-search-main');
					} else {
						get_template_part('template-parts/search/main'); 
					}
				}
			}
		} else {
			if (!is_home() && !is_singular('post') && !houzez_is_transparent_logo()) {
				if ($search_enable != 0 && $search_position == 'under_nav') {
					
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
	} // Header search End

	get_template_part('template-parts/banners/main');
	
} ?>