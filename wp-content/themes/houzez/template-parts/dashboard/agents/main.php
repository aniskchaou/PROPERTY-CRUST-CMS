<?php
$userID       = get_current_user_id();
$dash_profile_link = houzez_get_template_link_2('template/user_dashboard_profile.php');

$agency_agent_add = add_query_arg( 'agent', 'add_new', $dash_profile_link );

$wp_user_query = new WP_User_Query( array(
    array( 'role' => 'houzez_agent' ),
    'meta_key' => 'fave_agent_agency',
    'meta_value' => $userID
));
$agents = $wp_user_query->get_results();
?>
<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">
                <h1><?php echo esc_html__('All Agents', 'houzez');?></h1>         
            </div><!-- dashboard-header-left -->
            <div class="dashboard-header-right">
                <a class="btn btn-primary" href="<?php echo esc_url($agency_agent_add); ?>"><?php esc_html_e('Add New', 'houzez'); ?></a>
            </div><!-- dashboard-header-right -->
        </div><!-- d-flex -->
    </div><!-- dashboard-header-wrap -->
</header><!-- .header-main-wrap -->
<section class="dashboard-content-wrap">
    <div class="dashboard-content-inner-wrap">
        <div class="dashboard-content-block-wrap">
            
            <?php if( !empty($agents) ) { ?>
            <div class="dashboard-property-search-wrap">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <div class="dashboard-property-search">
                            
                        </div>
                    </div>
                </div>
            </div><!-- dashboard-property-search -->

            <table class="dashboard-table table-lined responsive-table">
                <thead>
                    <tr>
                        <th><?php echo esc_html__('Agent Name', 'houzez');?></th>
                        <th><?php echo esc_html__('Email', 'houzez');?></th>
                        <th><?php echo esc_html__('Listings', 'houzez');?></th>
                        <th><?php echo esc_html__('Phone', 'houzez');?></th>
                        <th><?php echo esc_html__('Mobile', 'houzez');?></th>
                        <th class="action-col"><?php echo esc_html__('Actions', 'houzez');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($agents as $agent) {
                        $agent_info = get_userdata($agent->ID);
                        $agency_agent_edit = add_query_arg(
                            array(
                                'agent' => 'add_new',
                                'id' => $agent->ID,
                            ),$dash_profile_link
                        );

                        $first_name = $agent_info->first_name;
                        $last_name = $agent_info->last_name;

                        if( !empty($first_name) && !empty($last_name) ) {
                            $agent_name = $first_name.' '.$last_name;
                        } else {
                            $agent_name = $agent_info->display_name;
                        }
                        $user_agent_id = get_user_meta( $agent->ID, 'fave_author_agent_id', true );

                        if( !empty( $user_agent_id ) ) {
                            if( 'publish' == get_post_status ( $user_agent_id ) ) {
                                $agent_permalink = get_permalink($user_agent_id);
                            } else {
                                $agent_permalink = get_author_posts_url( $agent->ID );
                            }

                        } else {
                            $agent_permalink = get_author_posts_url( $agent->ID );
                        }
                        ?>

                        <tr>
                            <td data-label="<?php echo esc_html__('Agent Name', 'houzez');?>">
                                <strong><?php echo esc_attr($agent_name); ?></strong>
                            </td>
                            <td class="property-table-type" data-label="<?php echo esc_html__('Email', 'houzez');?>">
                                <a href="#"><?php echo $agent_info->user_email; ?></a>
                            </td>
                            <td class="property-table-status" data-label="<?php echo esc_html__('Listings', 'houzez');?>">
                                <?php echo count_user_posts( $agent->ID , 'property' );?>
                            </td>
                            <td class="property-table-price" data-label="<?php echo esc_html__('Phone', 'houzez');?>">
                                <?php echo get_user_meta( $agent->ID, 'fave_author_phone', true); ?>
                            </td>
                            <td class="property-table-featured" data-label="<?php echo esc_html__('Mobile', 'houzez');?>">
                                <?php echo get_user_meta( $agent->ID, 'fave_author_mobile', true); ?>
                            </td>
                            <td class="property-table-actions" data-label="<?php echo esc_html__('Actions', 'houzez');?>">
                                <div class="dropdown property-action-menu">
                                    <button class="btn btn-primary-outlined dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo esc_html__('Actions', 'houzez');?>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="<?php echo esc_url($agent_permalink); ?>"><?php echo esc_html__('View', 'houzez');?></a>
                                        <a class="dropdown-item" href="<?php echo esc_url($agency_agent_edit); ?>"><?php echo esc_html__('Edit', 'houzez');?></a>
                                        <a data-agentid="<?php echo intval($agent->ID); ?>" class="houzez_delete_agency_agent dropdown-item" href="#"><?php echo esc_html__('Delete', 'houzez');?></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        wp_nonce_field( 'agent_delete_nonce', 'agent_delete_security' );
                    }
                    
                    ?>
                </tbody>
            </table><!-- dashboard-table -->
            <?php } else { ?>
            <div class="dashboard-content-block">
                <?php esc_html_e("You don't have any agent listed.", 'houzez'); ?> <a href="<?php echo esc_url($agency_agent_add); ?>"><strong><?php esc_html_e('Add a new agent', 'houzez'); ?></strong></a>
            </div><!-- dashboard-content-block -->
            <?php } ?>

        </div><!-- dashboard-content-block-wrap -->
    </div><!-- dashboard-content-inner-wrap -->
</section><!-- dashboard-content-wrap -->