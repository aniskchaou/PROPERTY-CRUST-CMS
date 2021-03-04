<?php
/*
Fix glaring security issue that allows an agency to edit any user
*/
$agency_user_id = isset($_GET['id']) ? $_GET['id'] : '';
$userID       = get_current_user_id();
$wp_user_query = new WP_User_Query( array(
    array( 'role' => 'houzez_agent' ),
    'meta_key' => 'fave_agent_agency',
    'meta_value' => $userID
));
$agents = $wp_user_query->get_results();
$user_agents = [];
foreach($agents as $agent){
    array_push($user_agents, $agent->ID);
}
if (!in_array($agency_user_id, $user_agents)){
    //echo 'You do not have access to this.';
    //exit();
    $_GET['id'] = null;
}
/*
END
*/


$userID       = get_current_user_id();
$dash_profile_link = houzez_get_template_link_2('template/user_dashboard_profile.php');
$agency_agent_add = add_query_arg( 'agents', 'list', $dash_profile_link );

$agency_id = get_user_meta($userID, 'fave_author_agency_id', true );
$agency_ids_cpt = get_post_meta($agency_id, 'fave_agency_cpt_agent', false );
$action = 'houzez_agency_agent';
$submit_id = 'houzez_agency_agent_register';

$username = $user_email = $first_name = $last_name = $agency_user_agent_id = $agency_user_agent_id = '';
$agency_user_id = isset($_GET['id']) ? $_GET['id'] : '';
if(!empty($agency_user_id)) {
    $first_name = get_user_meta($agency_user_id, 'first_name', true );
    $last_name = get_user_meta($agency_user_id, 'last_name', true );
    $agency_user_agent_id = get_user_meta($agency_user_id, 'fave_author_agent_id', true );
    $user_meta = get_userdata( $agency_user_id );

    $username = $user_meta->user_login;
    $user_email = $user_meta->user_email;
    $action = 'houzez_agency_agent_update';
    $submit_id = 'houzez_agency_agent_update';
}

?>
<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">
                <h1><?php esc_html_e('Add New Agent', 'houzez'); ?></h1>         
            </div><!-- dashboard-header-left -->
            <div class="dashboard-header-right">
                <a class="btn btn-primary" href="<?php echo esc_url($agency_agent_add); ?>"><?php esc_html_e('View All', 'houzez'); ?></a>
            </div><!-- dashboard-header-right -->
        </div><!-- d-flex -->
    </div><!-- dashboard-header-wrap -->
</header><!-- .header-main-wrap -->
<section class="dashboard-content-wrap">
    <div class="dashboard-content-inner-wrap">
        
        <div id="aa_register_message">
            <?php
            if(!isset($_GET['id'])){
                echo '<div class="alert alert-danger" role="alert"><i class="houzez-icon icon-check-circle-1 mr-1"></i>'.esc_html__('You do not have access to this.', 'houzez').'</div>';
            }
            ?>
        </div>

        <div class="dashboard-content-block-wrap">
            <div class="dashboard-content-block">
                <form method="" action="">
                    <div class="row align-items-center">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="aa_username"><?php esc_html_e('Username','houzez');?></label>
                                <input type="text" <?php if(!empty($agency_user_id)) { echo 'disabled'; } ?> name="aa_username" id="aa_username"  class="form-control" value="<?php echo esc_attr($username); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="aa_email"><?php esc_html_e('Email','houzez');?></label>
                                <input type="text" name="aa_email" id="aa_email"  class="form-control" value="<?php echo esc_attr($user_email); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="aa_firstname"><?php esc_html_e('First Name','houzez');?></label>
                                <input type="text" name="aa_firstname" id="aa_firstname" class="form-control" value="<?php echo esc_attr($first_name); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="aa_lastname"><?php esc_html_e('Last Name','houzez');?></label>
                                <input type="text" name="aa_lastname" id="aa_lastname" class="form-control" value="<?php echo esc_attr($last_name); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="aa_password"><?php esc_html_e('Password','houzez');?></label>
                                <input type="password" id="aa_password" name="aa_password" value="" class="form-control">
                            </div>
                        </div>

                        <?php if(empty($agency_user_id)) { ?>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group mb-0">
                                <label class="control control--checkbox mb-0">
                                    <input type="checkbox" id="aa_notification" name="aa_notification" value="">
                                    <?php echo esc_html__('Send the new user an email about their account.', 'houzez');?>
                                    <span class="control__indicator"></span>
                                </label>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <?php wp_nonce_field( 'houzez_agency_agent_ajax_nonce', 'houzez-security-agency-agent' );   ?>
                    <input type="hidden" name="action" value="<?php echo esc_attr($action); ?>" />
                    <input type="hidden" name="agency_id" value="<?php echo intval($userID); ?>" />
                    <?php if( !empty($agency_ids_cpt)) {
                        foreach( $agency_ids_cpt as $ag_id ): ?>
                        <input type="hidden" name="agency_ids_cpt[]" value="<?php echo esc_attr($ag_id); ?>" />
                    <?php
                        endforeach;
                        } else { ?>
                        <input type="hidden" name="agency_ids_cpt[]" value='' />
                   <?php } ?>
                    <input type="hidden" name="agency_id_cpt" value='<?php echo $agency_id; ?>' />
                    <input type="hidden" name="agency_user_agent_id" value="<?php echo intval($agency_user_agent_id); ?>" />
                    <input type="hidden" name="agency_user_id" value="<?php echo intval($agency_user_id); ?>" />
                    <button id="<?php echo esc_attr($submit_id); ?>" class="btn btn-success">
                        <?php get_template_part('template-parts/loader'); ?>
                        <?php esc_html_e('Save','houzez');?>        
                    </button>
                </form>
            </div><!-- dashboard-content-block -->
        </div><!-- dashboard-content-block-wrap -->
    </div><!-- dashboard-content-inner-wrap -->
</section><!-- dashboard-content-wrap -->