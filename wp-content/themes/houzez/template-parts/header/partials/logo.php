<?php
global $post;

$fave_main_menu_trans = '';
if( houzez_postid_needed() ) {
	$fave_main_menu_trans = get_post_meta($post->ID, 'fave_main_menu_trans', true);
}
$splash_logo = houzez_option( 'custom_logo_splash', false, 'url' );
$custom_logo = houzez_option( 'custom_logo', false, 'url' );
$splash_logolink_type = houzez_option('splash-logolink-type');
$splash_logolink = houzez_option('splash-logolink');

if( is_page_template( 'template/template-splash.php' ) ) {
	if($splash_logolink_type == 'custom') {
		$splash_logo_link = $splash_logolink;
	} else {
		$splash_logo_link = home_url( '/' );
	}
} else {
	$splash_logo_link = home_url( '/' );
}

$logo_height = houzez_option('retina_logo_height');
$logo_width = houzez_option('retina_logo_width');

?>

<?php if ( is_page_template( 'template/template-splash.php' ) || ($fave_main_menu_trans == 'yes' && houzez_option('header_style') == '4' ) && !wp_is_mobile() ) { ?>
	<div class="logo logo-splash">
		<a href="<?php echo esc_url( $splash_logo_link ); ?>">
			<?php if( !empty( $splash_logo ) ) { ?>
				<img src="<?php echo esc_url( $splash_logo ); ?>" height="<?php echo esc_attr($logo_height); ?>" width="<?php echo esc_attr($logo_width); ?>" alt="logo">
			<?php } ?>
		</a>
	</div>
<?php } else { ?>

	<div class="logo logo-desktop">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if( !empty( $custom_logo ) ) { ?>
				<img src="<?php echo esc_url( $custom_logo ); ?>" height="<?php echo esc_attr($logo_height); ?>" width="<?php echo esc_attr($logo_width); ?>" alt="logo">
			<?php } ?>
		</a>
	</div>
<?php } ?>