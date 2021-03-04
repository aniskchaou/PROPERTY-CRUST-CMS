<?php
$allowed_html_array = array(
    'a' => array(
        'href' => array(),
        'target' => array(),
        'title' => array()
    )
);
$user_show_roles = houzez_option('user_show_roles');
$show_hide_roles = houzez_option('show_hide_roles');
?>
<div id="hz-register-messages" class="hz-social-messages"></div>
<?php if( get_option('users_can_register') ) { ?>
<form>
<div class="register-form-wrap">
    
    <?php if( houzez_option('register_first_name', 0) == 1 ) { ?>
    <div class="form-group">
        <div class="form-group-field username-field">
            <input class="form-control" name="first_name" type="text" placeholder="<?php esc_html_e('First Name','houzez'); ?>" />
        </div><!-- input-group -->
    </div><!-- form-group -->
    <?php } ?>

    <?php if( houzez_option('register_last_name', 0) == 1 ) { ?>
    <div class="form-group">
        <div class="form-group-field username-field">
            <input class="form-control" name="last_name" type="text" placeholder="<?php esc_html_e('Last Name','houzez'); ?>" />
        </div><!-- input-group -->
    </div><!-- form-group -->
    <?php } ?>

    <div class="form-group">
        <div class="form-group-field username-field">
            <input class="form-control" name="username" type="text" placeholder="<?php esc_html_e('Username','houzez'); ?>" />
        </div><!-- input-group -->
    </div><!-- form-group -->
    

    <div class="form-group">
        <div class="form-group-field email-field">
            <input class="form-control" name="useremail" type="email" placeholder="<?php esc_html_e('Email','houzez'); ?>" />
        </div><!-- input-group -->
    </div><!-- form-group -->

    <?php if( houzez_option('register_mobile', 0) == 1 ) { ?>
    <div class="form-group">
        <div class="form-group-field phone-field">
            <input class="form-control" name="phone_number" type="number" placeholder="<?php esc_html_e('Phone','houzez'); ?>" />
        </div><!-- input-group -->
    </div><!-- form-group -->
    <?php } ?>

    <?php if( houzez_option('enable_password') == 'yes' ) { ?>
        <div class="form-group">
            <div class="form-group-field password-field">
                <input class="form-control" name="register_pass" placeholder="<?php esc_html_e('Password','houzez'); ?>" type="password" />
            </div><!-- input-group -->
        </div><!-- form-group -->
        <div class="form-group">
            <div class="form-group-field password-field">
                <input class="form-control" name="register_pass_retype" placeholder="<?php esc_html_e('Retype Password','houzez'); ?>" type="password" />
            </div><!-- input-group -->
        </div><!-- form-group -->
    <?php } ?>
    
</div><!-- login-form-wrap -->

<?php if($user_show_roles != 0) { ?>
<div class="form-group mt-10">
    <select required="required" name="role" class="selectpicker form-control bs-select-hidden" data-live-search="false" data-live-search-style="begins">
        <option value=""> <?php esc_html_e('Select your account type', 'houzez'); ?> </option>
        <?php
        if( $show_hide_roles['agent'] != 1 ) {
            echo '<option value="houzez_agent"> '.houzez_option('agent_role').' </option>';
        }
        if( $show_hide_roles['agency'] != 1 ) {
            echo '<option value="houzez_agency"> ' . houzez_option('agency_role') . ' </option>';
        }
        if( $show_hide_roles['owner'] != 1 ) {
            echo '<option value="houzez_owner"> ' . houzez_option('owner_role') . '  </option>';
        }
        if( $show_hide_roles['buyer'] != 1 ) {
            echo '<option value="houzez_buyer"> ' . houzez_option('buyer_role') . '  </option>';
        }
        if( $show_hide_roles['seller'] != 1 ) {
            echo '<option value="houzez_seller"> ' . houzez_option('seller_role') . '  </option>';
        }
        if( $show_hide_roles['manager'] != 1 ) {
            echo '<option value="houzez_manager"> ' . houzez_option('manager_role') . ' </option>';
        }
        ?>
    </select>
</div><!-- form-group -->
<?php } ?>

<div class="form-tools">
    <label class="control control--checkbox">
        <input name="term_condition" type="checkbox">
        <?php echo sprintf( __( 'I agree with your <a target="_blank" href="%s">Terms & Conditions</a>', 'houzez' ), 
            get_permalink(houzez_option('login_terms_condition') )); ?>
        <span class="control__indicator"></span>


    </label>
</div><!-- form-tools -->

<?php if(houzez_option('agent_forms_terms')) { ?>
<div class="form-tools">
    <label class="control control--checkbox">
        <input name="privacy_policy" type="checkbox"> <?php echo houzez_option('agent_forms_terms_text'); ?>
        <span class="control__indicator"></span>
    </label>
</div><!-- form-tools -->
<?php } ?>


<?php get_template_part('template-parts/google', 'reCaptcha'); ?>

<?php wp_nonce_field( 'houzez_register_nonce', 'houzez_register_security' ); ?>
<input type="hidden" name="action" value="houzez_register" id="register_action">
<button id="houzez-register-btn" type="submit" class="btn btn-primary btn-full-width">
    <?php get_template_part('template-parts/loader'); ?>
    <?php esc_html_e('Register','houzez');?>
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

<?php } else {
    esc_html_e('User registration is disabled for demo purpose.', 'houzez');
} ?>