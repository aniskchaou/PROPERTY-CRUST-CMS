<?php
$all_enquires = Houzez_Enquiry::get_enquires();

$is_not_lead_detail = true;
if(isset($_GET['tab']) && $_GET['tab'] == 'enquires') {
    $is_not_lead_detail = false;
}

$colspan = 6;
if($is_not_lead_detail) {
    $colspan = 9;
} 

$dashboard_crm = houzez_get_template_link_2('template/user_dashboard_crm.php');

if(!empty($all_enquires['data']['results'])) {
?>
<div class="d-flex justify-content-between mb-3">
    <div><?php echo esc_attr($all_enquires['data']['total_records']); ?> <?php esc_html_e('Inquiries found', 'houzez'); ?></div> 
    <div>
        
        <button id="enquiry_delete_multiple" class="btn btn-danger btn-slim ">
            <i class="houzez-icon icon-remove-circle mr-1"></i> 
            <?php esc_html_e('Delete', 'houzez'); ?>
        </button>
    </div>    
</div>
<table class="dashboard-table table-lined table-hover responsive-table">
    <thead>
        <tr>
            <th>
                <label class="control control--checkbox">
                    <input type="checkbox" id="enquiry_select_all" name="enquiry_multicheck">
                    <span class="control__indicator"></span>
                </label>
            </th>
            <th><?php esc_html_e('ID', 'houzez'); ?></th>

            <?php if($is_not_lead_detail) { ?>
            <th><?php esc_html_e('Contact', 'houzez'); ?></th>
            <?php } ?>

            <th><?php esc_html_e('Inquiry Type', 'houzez'); ?></th>
            <th><?php esc_html_e('Listing Type', 'houzez'); ?></th>
            <th><?php esc_html_e('Price', 'houzez'); ?></th>
            <th><?php esc_html_e('Bedrooms', 'houzez'); ?></th>

            <?php if($is_not_lead_detail) { ?>
            <th><?php esc_html_e('Bathrooms', 'houzez'); ?></th>
            <th><?php esc_html_e('Built-up Area', 'houzez'); ?></th>
            <?php } ?>

            <th></th>
        </tr>
    </thead>

    <tbody>
        
        <?php 
        foreach ($all_enquires['data']['results'] as $enquiry) { 

            $lead = Houzez_Leads::get_lead($enquiry->lead_id);
            $meta = maybe_unserialize($enquiry->enquiry_meta);

            $detail_enquiry = add_query_arg(
                array(
                    'hpage' => 'enquiries',
                    'enquiry' => $enquiry->enquiry_id,
                ), $dashboard_crm
            );

        ?>
        <tr>
            <td>
                <label class="control control--checkbox">
                    <input type="checkbox" class="enquiry_multi_delete" name="enquiry_multi_delete[]" value="<?php echo intval($enquiry->enquiry_id); ?>">
                    <span class="control__indicator"></span>
                </label>
            </td>
            <td data-label="<?php esc_html_e('ID', 'houzez'); ?>">
                <?php echo esc_attr($enquiry->enquiry_id); ?>
            </td>

            <?php if($is_not_lead_detail) { ?>
            <td data-label="<?php esc_html_e('Contact', 'houzez'); ?>">
                <?php 
                if(isset($lead->display_name)) {
                    echo esc_attr($lead->display_name); 
                }?>
            </td>
            <?php } ?>

            <td data-label="<?php esc_html_e('Inquiry Type', 'houzez'); ?>">
                <?php echo esc_attr($enquiry->enquiry_type); ?>
            </td>
            <td data-label="<?php esc_html_e('Listing Type', 'houzez'); ?>">
                <?php 
                if(isset($meta['property_type']['name'])) {
                    echo esc_attr($meta['property_type']['name']); 
                }?>
            </td>

            <td data-label="<?php esc_html_e('Price', 'houzez'); ?>">
                <?php 
                if(isset($meta['min_price'])) {
                    echo esc_attr($meta['min_price']); 
                }

                if(isset($meta['max_price'])) {
                    echo ' - '.esc_attr($meta['max_price']); 
                }?>
            </td>

            <td data-label="<?php esc_html_e('Bedrooms', 'houzez'); ?>">
                <?php 
                if(isset($meta['min_beds'])) {
                    echo esc_attr($meta['min_beds']); 
                }

                if(isset($meta['max_beds'])) {
                    echo ' - '.esc_attr($meta['max_beds']); 
                }?>
            </td>

            <?php if($is_not_lead_detail) { ?>
            <td data-label="<?php esc_html_e('Bathrooms', 'houzez'); ?>">
                <?php 
                if(isset($meta['min_baths'])) {
                    echo esc_attr($meta['min_baths']); 
                }

                if(isset($meta['max_baths'])) {
                    echo ' - '.esc_attr($meta['max_baths']); 
                }?>
            </td>

            <td data-label="<?php esc_html_e('Built-up Area', 'houzez'); ?>">
                <?php 
                if(isset($meta['min_area'])) {
                    echo esc_attr($meta['min_area']); 
                }

                if(isset($meta['max_area'])) {
                    echo ' - '.esc_attr($meta['max_area']); 
                }?>
            </td>
            <?php } ?>

            <td class="text-right">
                <a href="<?php echo esc_url($detail_enquiry); ?>"><?php esc_html_e('View', 'houzez'); ?></a>
            </td>
        </tr>
        <?php
        } ?>

    </tbody>

    <tfoot>
        <tr>
            <td colspan="<?php echo esc_attr($colspan); ?>">
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
                        'total' => ceil($all_enquires['data']['total_records'] / $all_enquires['data']['items_per_page']),
                        'current' => $all_enquires['data']['page']
                    ));
                    ?>
                </div>
            </td>
        </tr>
    </tfoot>
</table><!-- dashboard-table -->
<?php
} else { ?>
    <div class="dashboard-content-block">
        <?php esc_html_e("Don't have any inquiry at this moment.", 'houzez'); ?>
    </div><!-- dashboard-content-block -->
<?php } ?>