<?php if(houzez_show_google_reCaptcha()): ?>
<div class="form-group captcha_wrapper houzez-grecaptcha-<?php echo houzez_option( 'recaptha_type', 'v2' ); ?>">
    <div class="houzez_google_reCaptcha"></div>
</div>
<?php endif; ?>