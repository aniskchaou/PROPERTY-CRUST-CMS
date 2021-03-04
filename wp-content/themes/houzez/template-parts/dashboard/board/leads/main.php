<header class="header-main-wrap dashboard-header-main-wrap">
    <div class="dashboard-header-wrap">
        <div class="d-flex align-items-center">
            <div class="dashboard-header-left flex-grow-1">
                <h1><?php echo houzez_option('dsh_leads', 'Leads'); ?></h1>         
            </div><!-- dashboard-header-left -->
            <div class="dashboard-header-right">
                <a class="btn btn-primary open-close-slide-panel" href="#"><?php esc_html_e('Add New Lead', 'houzez'); ?></a>
            </div><!-- dashboard-header-right -->
        </div><!-- d-flex -->
    </div><!-- dashboard-header-wrap -->
</header><!-- .header-main-wrap -->
<section class="dashboard-content-wrap">
    <div class="dashboard-content-inner-wrap">
        <div class="dashboard-content-block-wrap">

            <?php
            $dashboard_crm = houzez_get_template_link_2('template/user_dashboard_crm.php');
        
            $leads = Houzez_leads::get_leads();
        
            if(!empty($leads['data']['results'])) { ?>

                <table class="dashboard-table table-lined responsive-table">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Name', 'houzez'); ?></th>
                            <th><?php esc_html_e('Email', 'houzez'); ?></th>
                            <th><?php esc_html_e('Phone', 'houzez'); ?></th>
                            <th><?php esc_html_e('Type', 'houzez'); ?></th>
                            <th><?php esc_html_e('Date', 'houzez'); ?></th>
                            <th class="action-col"><?php esc_html_e('Actions', 'houzez'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($leads['data']['results'] as $result) { 
                            $detail_link = add_query_arg(
                                array(
                                    'hpage' => 'lead-detail',
                                    'lead-id' => $result->lead_id,
                                    'tab' => 'enquires',
                                ), $dashboard_crm
                            );

                            $datetime = $result->time;

                            $datetime_unix = strtotime($datetime);
                            $get_date = houzez_return_formatted_date($datetime_unix);
                            $get_time = houzez_get_formatted_time($datetime_unix);
                        ?>

                            <tr>
                                <td class="table-nowrap" data-label="<?php esc_html_e('Name', 'houzez'); ?>">
                                    <?php echo esc_attr($result->display_name); ?>
                                </td>
                                <td data-label="<?php esc_html_e('Email', 'houzez'); ?>">
                                    <a href="mailto:<?php echo esc_attr($result->email); ?>">
                                        <strong><?php echo esc_attr($result->email); ?></strong>
                                    </a>
                                </td>
                                <td data-label="<?php esc_html_e('Phone', 'houzez'); ?>">
                                    <?php echo esc_attr($result->mobile); ?>
                                </td>
                                <td data-label="<?php esc_html_e('Type', 'houzez'); ?>">
                                    <?php 
                                    $type = stripslashes($result->type);
                                    $type = htmlentities($type);
                                    echo esc_attr($type); ?>
                                </td>
                                <td class="table-nowrap" data-label="<?php esc_html_e('Date', 'houzez'); ?>">
                                    <?php echo esc_attr($get_date); ?><br>
                                    <?php echo esc_html__('at', 'houzez'); ?> <?php echo esc_attr($get_time); ?>
                                </td>
                                <td>
                                    <div class="dropdown property-action-menu">
                                        <button class="btn btn-primary-outlined dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php esc_html_e('Actions', 'houzez'); ?>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?php echo esc_url($detail_link); ?>"><?php esc_html_e('Details', 'houzez'); ?></a>

                                            <a class="edit-lead dropdown-item open-close-slide-panel" data-id="<?php echo intval($result->lead_id)?>" href="#"><?php esc_html_e('Edit', 'houzez'); ?></a>

                                            <a href="" class="delete-lead dropdown-item" data-id="<?php echo intval($result->lead_id); ?>" data-nonce="<?php echo wp_create_nonce('delete_lead_nonce') ?>"><?php esc_html_e('Delete', 'houzez'); ?></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <?php get_template_part('template-parts/dashboard/board/records-html'); ?>
                            </td>
                            <td class="text-right">
                                <div class="crm-pagination">
                                    <?php
                                    echo paginate_links( array(
                                        'base' => add_query_arg( 'cpage', '%#%' ),
                                        'format' => '',
                                        'prev_text' => __('&laquo;'),
                                        'next_text' => __('&raquo;'),
                                        'total' => ceil($leads['data']['total_records'] / $leads['data']['items_per_page']),
                                        'current' => $leads['data']['page']
                                    ));
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            <?php
            } else { ?>
                <div class="dashboard-content-block">
                    <?php esc_html_e("You don't have any contact at this moment.", 'houzez'); ?> <a class="open-close-slide-panel" href="#"><strong><?php esc_html_e('Add New Lead', 'houzez'); ?></strong></a>
                </div><!-- dashboard-content-block -->
            <?php } ?>
        

        </div><!-- dashboard-content-block-wrap -->
    </div><!-- dashboard-content-inner-wrap -->
</section><!-- dashboard-content-wrap -->
<section class="dashboard-side-wrap">
    <?php get_template_part('template-parts/dashboard/side-wrap'); ?>
</section>