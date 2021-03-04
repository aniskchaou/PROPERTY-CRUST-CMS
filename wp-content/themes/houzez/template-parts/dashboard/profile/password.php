<div class="dashboard-content-block">
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <h2><?php esc_html_e('Change Password','houzez'); ?></h2>
        </div><!-- col-md-3 col-sm-12 -->

        <div class="col-md-9 col-sm-12">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label><?php esc_html_e('New Password','houzez'); ?></label>
                        <input class="form-control" id="newpass" placeholder="<?php esc_html_e('Enter your new password','houzez'); ?>" type="text">
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label><?php esc_html_e('Confirm New Password','houzez'); ?></label>
                        <input class="form-control" id="confirmpass" placeholder="<?php esc_html_e('Enter your new password again','houzez'); ?>" type="text">
                    </div>
                </div>
            </div><!-- row -->
            <?php wp_nonce_field( 'houzez_pass_ajax_nonce', 'houzez-security-pass' );   ?>
            <button id="houzez_change_pass" class="btn btn-success">
                <?php get_template_part('template-parts/loader'); ?>
                <?php esc_html_e('Update Password','houzez'); ?>
            </button>
            <div id="password_reset_msgs" class="notify"></div>
        </div><!-- col-md-9 col-sm-12 -->
    </div><!-- row -->
</div><!-- dashboard-content-block -->