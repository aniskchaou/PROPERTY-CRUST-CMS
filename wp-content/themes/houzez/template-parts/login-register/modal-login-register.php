<div class="modal fade login-register-form" id="login-register-form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="login-register-tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="modal-toggle-1 nav-link" data-toggle="tab" href="#login-form-tab" role="tab"><?php esc_html_e('Login', 'houzez'); ?></a>
                        </li>

                        <?php if( houzez_option('header_register') ) { ?>
                        <li class="nav-item">
                            <a class="modal-toggle-2 nav-link" data-toggle="tab" href="#register-form-tab" role="tab"><?php esc_html_e('Register', 'houzez'); ?></a>
                        </li>
                        <?php } ?>
                    </ul>    
                </div><!-- login-register-tabs -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div><!-- modal-header -->
            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane fade login-form-tab" id="login-form-tab" role="tabpanel">
                        <?php get_template_part('template-parts/login-register/login-form'); ?>
                    </div><!-- login-form-tab -->
                    <div class="tab-pane fade register-form-tab" id="register-form-tab" role="tabpanel">
                         <?php get_template_part('template-parts/login-register/register-form'); ?>
                    </div><!-- register-form-tab -->
                </div><!-- tab-content -->
            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- login-register-form -->