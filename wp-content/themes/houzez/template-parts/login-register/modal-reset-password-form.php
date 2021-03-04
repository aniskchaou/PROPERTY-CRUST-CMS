<div class="modal fade reset-password-form" id="reset-password-form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php esc_html_e( 'Reset Password', 'houzez' ); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div><!-- modal-header -->
            <div class="modal-body">
                <div id="reset_pass_msg"></div>
                <p><?php esc_html_e( 'Please enter your username or email address. You will receive a link to create a new password via email.', 'houzez' ); ?></p>
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control forgot-password" name="user_login_forgot" id="user_login_forgot" placeholder="<?php esc_html_e( 'Enter your username or email', 'houzez' ); ?>" class="form-control">
                    </div>
                    <?php wp_nonce_field( 'fave_resetpassword_nonce', 'fave_resetpassword_security' ); ?>
                    <button type="button" id="houzez_forgetpass" class="btn btn-primary btn-block">
                        <?php get_template_part('template-parts/loader'); ?>
                        <?php esc_html_e( 'Get new password', 'houzez' ); ?>
                    </button>
                </form>
            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- login-register-form -->