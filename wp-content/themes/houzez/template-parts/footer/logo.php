<?php $footer_logo = houzez_option( 'footer_logo', false, 'url' ); ?>
<?php if(!empty($footer_logo)) { ?>
<div class="footer_logo logo">
	<img src="<?php echo esc_url($footer_logo); ?>" alt="logo">
</div><!-- .logo -->
<?php } ?>