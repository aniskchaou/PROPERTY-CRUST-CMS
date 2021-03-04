<?php
$viewed = Houzez_Leads::get_lead_viewed_listings();

if(!empty($viewed['data']['results'])) { ?>

<div class="d-flex justify-content-between mb-3">
    <div><?php echo esc_attr($viewed['data']['total_records']); ?> <?php esc_html_e('Listings Viewed', 'houzez'); ?></div> 
    <div>
        <button id="listing_viewed_delete" class="btn btn-primary btn-slim">
            <i class="houzez-icon icon-remove-circle mr-1"></i> <?php esc_html_e('Delete', 'houzez'); ?>
        </button>
    </div>    
</div>
<table class="dashboard-table table-lined table-hover responsive-table">
    <thead>
        <tr>
            <th>
                <label class="control control--checkbox">
                    <input type="checkbox" id="listing_viewed_select_all" name="listing_viewed_select_all">
                    <span class="control__indicator"></span>
                </label>
            </th>
            <th><?php esc_html_e('Property', 'houzez'); ?></th>
            <th></th>
            <th><?php esc_html_e('Date', 'houzez'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($viewed['data']['results'] as $view) { 
            $listing_id = $view->listing_id; 
            $datetime = $view->time; 

            $datetime_unix = strtotime($datetime);
            $get_date = houzez_return_formatted_date($datetime_unix);
            $get_time = houzez_get_formatted_time($datetime_unix);

            $thumbnail = get_the_post_thumbnail_url($listing_id, 'thumbnail');
            if(empty($thumbnail)) {
                $thumbnail = 'https://placehold.it/50x50';
            }
        ?>

            <tr>
                <td>
                    <label class="control control--checkbox">
                        <input type="checkbox" class="listing_viewed_multi_delete" value="<?php echo intval($view->id); ?>">
                        <span class="control__indicator"></span>
                    </label>
                </td>
                <td data-label="<?php esc_html_e('Property', 'houzez'); ?>">
                    <img src="<?php echo esc_url($thumbnail); ?>" width="50" height="50">
                </td>
                <td>
                    <a target="_blank" href="<?php echo get_permalink($listing_id); ?>">
                        <strong><?php echo get_the_title($listing_id); ?></strong>
                    </a><br>
                    <?php echo get_post_meta($listing_id, 'fave_property_map_address', true); ?>
                </td>
                <td class="table-nowrap" data-label="<?php esc_html_e('Date', 'houzez'); ?>">
                    <?php echo esc_attr($get_date); ?><br>
                    <?php echo esc_html__('at', 'houzez'); ?> <?php echo esc_attr($get_time); ?>
                </td>
            </tr>
        
        <?php 
        }?>
        
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">
                <?php get_template_part('template-parts/dashboard/board/records-html'); ?>
            </td>
            <td class="text-right no-wrap">
                <div class="crm-pagination">
                    <?php
                    echo paginate_links( array(
                        'base' => add_query_arg( 'cpage', '%#%' ),
                        'format' => '',
                        'prev_text' => __('&laquo;'),
                        'next_text' => __('&raquo;'),
                        'total' => ceil($viewed['data']['total_records'] / $viewed['data']['items_per_page']),
                        'current' => $viewed['data']['page']
                    ));
                    ?>
                </div>
            </td>
        </tr>
    </tfoot>
</table><!-- dashboard-table -->
<?php
} else {?>
    <div class="d-flex justify-content-between">
        <div><?php esc_html_e('No record found.', 'houzez'); ?></div>    
    </div>
<?php } ?>