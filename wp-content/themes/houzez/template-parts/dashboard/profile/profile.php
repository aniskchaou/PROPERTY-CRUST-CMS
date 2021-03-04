<?php
$userID = get_current_user_id();
$user_agent_id = get_user_meta( $userID, 'fave_author_agent_id', true );
$user_agency_id = get_user_meta( $userID, 'fave_author_agency_id', true );
if(houzez_is_agency()){
    $id_for_permalink = $user_agency_id;
} elseif(houzez_is_agent()) {
    $id_for_permalink = $user_agent_id;
}

if( !empty( $id_for_permalink ) ) {
    if( 'publish' == get_post_status ( $id_for_permalink ) ) {
        $agent_permalink = get_permalink($id_for_permalink);
    } else {
        $agent_permalink = get_author_posts_url( $userID );
    }

} else {
    $agent_permalink = get_author_posts_url( $userID );
}
?>
<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">
                <h1><?php echo houzez_option('dsh_profile', 'My profile'); ?></h1>         
            </div><!-- dashboard-header-left -->
            <div class="dashboard-header-right">
                <?php if(houzez_not_buyer()) { ?>
                    <a href="<?php echo esc_url($agent_permalink); ?>" target="_blank" class="btn btn-primary">
                        <?php esc_html_e('View Public Profile','houzez');?>
                    </a>
                <?php } ?>
            </div><!-- dashboard-header-right -->
        </div><!-- d-flex -->
    </div><!-- dashboard-header-wrap -->
</header><!-- .header-main-wrap -->
<section class="dashboard-content-wrap">
    <div class="dashboard-content-inner-wrap">
        <div class="dashboard-content-block-wrap">
            
            <form method="post">
                <?php get_template_part('template-parts/dashboard/profile/information'); ?>

                <?php get_template_part('template-parts/dashboard/profile/social'); ?>
                <?php wp_nonce_field( 'houzez_profile_ajax_nonce', 'houzez-security-profile' ); ?>
                <input type="hidden" name="action" value="houzez_ajax_update_profile">
            </form>

            <?php

            get_template_part('template-parts/dashboard/profile/role');

            get_template_part('template-parts/dashboard/profile/currency');

            get_template_part('template-parts/dashboard/profile/password');

            get_template_part('template-parts/dashboard/profile/delete-account');

            ?>
        </div><!-- dashboard-content-block-wrap -->
    </div><!-- dashboard-content-inner-wrap -->
</section><!-- dashboard-content-wrap -->