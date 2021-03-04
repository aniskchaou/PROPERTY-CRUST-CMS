<?php
#-----------------------------------------------------------------#
# Woocommerce
#-----------------------------------------------------------------#
add_theme_support( 'woocommerce' );
//add_filter( 'woocommerce_enqueue_styles', '__return_false' );

function houzez_enqueue_woocommerce_style(){
	wp_register_style( 'houzez-woocommerce', HOUZEZ_CSS_DIR_URI . 'woocommerce.css' );
	wp_enqueue_style( 'houzez-woocommerce' );
}
add_action( 'wp_enqueue_scripts', 'houzez_enqueue_woocommerce_style' );


// Change WooCommerce wrappers.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// This theme doesn't have a traditional sidebar.
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

?>