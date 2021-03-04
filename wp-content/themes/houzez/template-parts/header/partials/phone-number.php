<?php
$call_us_img = houzez_option( 'hd3_call_us_image', false, 'url' );
?>
<div class="header-contact-wrap">
	<div class="d-flex d-flex align-items-center justify-content-between">
		<?php get_template_part('template-parts/header/partials/social-icons'); ?>
		<div class="header-contact header-contact-1">
			<div class="d-flex align-items-center">
				<?php if(!empty($call_us_img)) { ?>
				<div class="header-contact-left">
					<img width="40" height="40" alt="author" src="<?php echo esc_url( $call_us_img ); ?>" class="rounded-circle img-responsive">
				</div><!-- header-contact-left -->
				<?php } ?>
				<div class="header-contact-right">
					<?php echo esc_attr( houzez_option('hd3_call_us_text') ); ?> <a href="tel://<?php echo esc_attr( houzez_option('hd3_phone') ); ?>"><?php echo esc_attr( houzez_option('hd3_phone') ); ?></a>
				</div><!-- .header-contact-right -->
			</div><!-- d-flex -->
		</div><!-- .header-contact -->
	</div><!-- d-flex -->
</div><!-- .header-contact-wrap -->