<?php
global $listing_id;
?>
<div class="form-group insight-search">
    <label><?php esc_html_e('Filter by Listing', 'houzez'); ?></label>
    <select id="insights_filter" class="selectpicker form-control bs-select-hidden" title="<?php esc_html_e('Select', 'houzez'); ?>" data-live-search="true">
        <option value=""><?php esc_html_e('Select', 'houzez'); ?></option>

        <?php
        $args = array(
        	'post_type' => 'property',
        	'posts_per_page' => apply_filters('fave_stats_listing_num', -1),
        	'author' => get_current_user_id(),
        	'post_status' => 'publish',
        );

        $the_query = new WP_Query($args);

        if( $the_query->have_posts()):

        	while($the_query->have_posts()): $the_query->the_post();

        		echo '<option '.selected($listing_id, get_the_ID(), false).' value="'.intval(get_the_ID()).'">'.get_the_title().'</option>';

        	endwhile;

        endif;
        wp_reset_postdata();
        ?>
    </select><!-- selectpicker -->
</div><!-- form-group -->