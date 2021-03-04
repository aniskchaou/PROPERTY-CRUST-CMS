<?php global $matched_query, $enquiry; ?>
<table class="dashboard-table table-lined table-hover responsive-table">
    <thead>
        <tr>
            <th>
                <label class="control control--checkbox">
                    <input type="checkbox" id="listings_select_all" name="listings_multicheck">
                    <span class="control__indicator"></span>
                </label>
            </th>
            <th><?php esc_html_e('ID', 'houzez'); ?></th>
            <th><?php esc_html_e('Type', 'houzez'); ?></th>
            <th><?php esc_html_e('Price', 'houzez'); ?></th>
            <th><?php esc_html_e('Bedrooms', 'houzez'); ?></th>
            <th><?php esc_html_e('Bathrooms', 'houzez'); ?></th>
            <th><?php esc_html_e('Area', 'houzez'); ?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <?php 
        if(!empty($matched_query)) {

            if($matched_query->have_posts()):
                while ($matched_query->have_posts()): $matched_query->the_post(); 
                    $prop_id = houzez_get_listing_data('property_id');
                ?>

                    <tr>
                        <td>
                            <label class="control control--checkbox">
                                <input type="checkbox" class="listing_multi_id" name="listing_multi_id[]" value="<?php echo intval(get_the_ID()); ?>">
                                <span class="control__indicator"></span>
                            </label>
                        </td>
                        <td data-label="<?php esc_html_e('ID', 'houzez'); ?>">
                            <?php echo houzez_propperty_id_prefix($prop_id); ?>
                        </td>
                        <td class="" data-label="<?php esc_html_e('Type', 'houzez'); ?>">
                            <?php echo houzez_taxonomy_simple('property_type'); ?>
                        </td>
                        <td data-label="<?php esc_html_e('Price', 'houzez'); ?>">
                            <?php echo houzez_property_price_crm(); ?>
                        </td>
                        <td data-label="<?php esc_html_e('Bedrooms', 'houzez'); ?>">
                            <?php echo houzez_get_listing_data('property_bedrooms'); ?>
                        </td>
                        <td data-label="<?php esc_html_e('Bathrooms', 'houzez'); ?>">
                            <?php echo houzez_get_listing_data('property_bathrooms'); ?>
                        </td>
                        <td class="table-nowrap" data-label="<?php esc_html_e('Area', 'houzez'); ?>">
                            <?php echo houzez_get_listing_data('property_size'); ?>
                        </td>
                        <td data-label="">
                            <a target="_blank" href="<?php echo get_permalink(get_the_ID()); ?>"><?php esc_html_e('View', 'houzez'); ?></a>
                        </td>
                    </tr>
        

        <?php
                endwhile;
            endif;

        }
        ?>
    </tbody>
</table><!-- dashboard-table -->
<?php houzez_pagination( $matched_query->max_num_pages, $range = 2 ); ?>