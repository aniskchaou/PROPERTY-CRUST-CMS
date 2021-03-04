<div id="hz-login-messages" class="hz-social-messages"></div>
<form>
    <div class="login-form-wrap">
        <div class="form-group">
            <div class="form-group-field username-field">
                <input class="form-control" name="username" placeholder="<?php esc_html_e('Username or Email','houzez'); ?>" type="text" />
            </div><!-- input-group -->
        </div><!-- form-group -->
        <div class="form-group">
            <div class="form-group-field password-field">
                <input class="form-control" name="password" placeholder="<?php esc_html_e('Password','houzez'); ?>" type="password" />
            </div><!-- input-group -->
        </div><!-- form-group -->
    </div><!-- login-form-wrap -->

    <div class="form-tools">
        <div class="d-flex">
            <label class="control control--checkbox flex-grow-1">
                <input name="remember" type="checkbox"><?php esc_html_e( 'Remember me', 'houzez' ); ?>
                <span class="control__indicator"></span>
            </label>
            <a href="#" data-toggle="modal" data-target="#reset-password-form" data-dismiss="modal"><?php esc_html_e( 'Lost your password?', 'houzez' ); ?></a>
        </div><!-- d-flex -->    
    </div><!-- form-tools -->

    <?php get_template_part('template-parts/google', 'reCaptcha'); ?>

    <?php wp_nonce_field( 'houzez_login_nonce', 'houzez_login_security' ); ?>
    <input type="hidden" name="action" id="login_action" value="houzez_login">
    <input type="hidden" name="redirect_to" value="<?php echo esc_url(houzez_after_login_redirect()); ?>">
    <button id="houzez-login-btn" type="submit" class="btn btn-primary btn-full-width">
        <?php get_template_part('template-parts/loader'); ?>
        <?php esc_html_e('Login', 'houzez'); ?>        
    </button>
</form>

<?php if( houzez_option('facebook_login') != 'no' || houzez_option('google_login') != 'no' ) { ?>
<div class="social-login-wrap">

    <?php if( houzez_option('facebook_login') != 'no' ) { ?>
    <button type="button" class="hz-facebook-login btn btn-facebook-login btn-full-width">
        <?php get_template_part('template-parts/loader'); ?>
        <?php esc_html_e( 'Continue with Facebook', 'houzez' ); ?>
    </button>
    <?php } ?>

    <?php if( houzez_option('google_login') != 'no' ) { ?>
    <button type="button" class="hz-google-login btn btn-google-plus-lined btn-full-width">
        <?php get_template_part('template-parts/loader'); ?>
        <img class="google-icon" src="<?php echo HOUZEZ_IMAGE; ?>Google__G__Logo.svg"/> <?php esc_html_e( 'Sign in with google', 'houzez' ); ?>
    </button>
    <?php } ?>

</div>
<?php } ?>
