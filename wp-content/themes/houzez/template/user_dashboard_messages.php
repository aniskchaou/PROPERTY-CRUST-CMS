<?php
/**
 * Template Name: User Dashborad Messages
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 08/12/16
 * Time: 7:47 PM
 * Since v1.5.0
 */

if ( !is_user_logged_in() ) {
    wp_redirect(  home_url() );
}

global $wpdb;

$userID = get_current_user_id();


get_header(); ?>


<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">
                <h1><?php echo houzez_option('dsh_messages', 'Messages'); ?></h1>         
            </div><!-- dashboard-header-left -->
        </div><!-- d-flex -->
    </div><!-- dashboard-header-wrap -->
</header><!-- .header-main-wrap -->

<section class="dashboard-content-wrap">
    <div class="dashboard-content-inner-wrap">
        <div class="dashboard-content-block-wrap">
            
            <?php
            if ( isset( $_REQUEST['thread_id'] ) && !empty( $_REQUEST['thread_id'] ) ) {

                get_template_part('template-parts/dashboard/messages/message-detail');

            } else {

                get_template_part('template-parts/dashboard/messages/messages');

            }
            ?>

        </div><!-- dashboard-content-block-wrap -->
    </div><!-- dashboard-content-inner-wrap -->
</section><!-- dashboard-content-wrap -->

<section class="dashboard-side-wrap">
    <?php get_template_part('template-parts/dashboard/side-wrap'); ?>
</section>

<?php get_footer(); ?>