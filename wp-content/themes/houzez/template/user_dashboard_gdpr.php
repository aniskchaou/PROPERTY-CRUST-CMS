<?php
/**
 * Template Name: User Dashboard GDPR Request
 */
if ( !is_user_logged_in() ) {
    wp_redirect(  home_url() );
}
get_header(); ?>

<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">
                <h1><?php the_title(); ?></h1>         
            </div><!-- dashboard-header-left -->

            <div class="dashboard-header-right">
                
            </div><!-- dashboard-header-right -->
        </div><!-- d-flex -->
    </div><!-- dashboard-header-wrap -->
</header><!-- .header-main-wrap -->

<section class="dashboard-content-wrap">
    <div class="dashboard-content-inner-wrap">
        <div id="gdpr-msg"></div>
        <form action="" method="post" id="houzez_gdpr_form">
            <div class="dashboard-content-block-wrap">
                <div class="dashboard-content-block activities-list-wrap">
                    
                    <p><?php esc_html_e('An email will be sent to the user at this email address asking them to verify the request.', 'houzez');?></p>

                    <p><strong><?php esc_html_e( 'Select your request*', 'houzez' ); ?></strong></p>
                    <div class="form-group">
                        <label class="control control--radio">
                            <input id="gdrf_data_export" type="radio" name="gdrf_data_type" value="export_personal_data"> <?php esc_html_e( 'Export Personal Data', 'houzez' ); ?>
                            <span class="control__indicator"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="control control--radio">
                            <input id="gdrf_data_remove" type="radio" name="gdrf_data_type" value="remove_personal_data"> <?php esc_html_e( 'Remove Personal Data', 'houzez' ); ?>
                            <span class="control__indicator"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label><?php esc_html_e( 'Your email address*', 'houzez' ); ?></label>
                        <input class="form-control" type="email" id="gdrf_data_email" name="gdrf_data_email" placeholder="<?php esc_html_e('Enter your email address', 'houzez'); ?>"/>
                    </div>
                </div>
            </div><!-- dashboard-content-block-wrap -->
            <div class="add-new-listing-bottom-nav-wrap">
                <input type="hidden" name="houzez_gdrf_data_nonce" id="houzez_gdrf_data_nonce" value="<?php echo wp_create_nonce( 'houzez_gdrf_nonce' ); ?>" />
                <button class="btn btn-success" id="houzez_gdpr_data">
                    <?php get_template_part('template-parts/loader'); ?>
                    <?php esc_html_e('Send Request','houzez'); ?>
                </button>
            </div>
        </form>
    </div><!-- dashboard-content-inner-wrap -->
</section><!-- dashboard-content-wrap -->

<section class="dashboard-side-wrap">
    <?php get_template_part('template-parts/dashboard/side-wrap'); ?>
</section>

<?php get_footer(); ?>