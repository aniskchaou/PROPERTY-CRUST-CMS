<?php
if( !function_exists('houzez_recent_viewed_properties') ) {
    function houzez_recent_viewed_properties($atts, $content = null)
    {

        extract(shortcode_atts(array(
            'prop_grid_style' => '',
            'posts_limit' => '',
            'columns' => '',
        ), $atts));

        ob_start();

        $cards_class = 'property-by-ids-module-1';
        $columns_class = 'property-by-ids-module-3-cols';
        $cols_class = "grid-view-3-cols";
        $cards_version = 'v1';

        if( $prop_grid_style == "v_1" ) {
            $cards_version = 'v1';

        } elseif( $prop_grid_style == "v_2" ) {
            $cards_class = 'property-by-ids-module-2';
            $cards_version = 'v2';

        } elseif( $prop_grid_style == "v_3" ) {
            $cards_class = 'property-by-ids-module-3';
            $cards_version = 'v3';
            
        } elseif( $prop_grid_style == "v_4" ) {
            $cards_version = 'v4';
            
        } elseif( $prop_grid_style == "v_5" ) {
            $cards_version = 'v5';
            
        } elseif( $prop_grid_style == "v_6" ) {
            $cards_version = 'v6';
            
        } 

        if($columns == '2cols') {
            $columns_class = 'property-by-ids-module-2-cols';
            $cols_class = "grid-view-2-cols";
        }

        if($columns == '3cols' && $prop_grid_style == "v_4") {
            $columns_class = 'property-by-ids-module-2-cols';
        }
        
        $args = array(
            'post_type' => 'property',
            'posts_per_page' => $posts_limit,
            'orderby' => 'meta_value',
            
            'meta_key' => 'houzez_recently_viewed',
            'ignore_sticky_posts' => 1,
            'post_status' => 'publish',
            
        );

        //do the query
        $the_query = New WP_Query($args);
        ?>

        <div class="recent-viewed-properties-module <?php echo esc_attr($columns_class); ?> <?php echo esc_attr($cards_class); ?>">
            <div class="listing-view grid-view <?php echo esc_attr($cols_class); ?> card-deck">
                <?php
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post();

                        get_template_part('template-parts/listing/item', $cards_version);

                    endwhile;
                else:
                    get_template_part('template-parts/listing/item', 'none');
                endif;
                wp_reset_postdata();
                ?>
            </div><!-- listing-view -->
        </div><!-- property-by-is-module -->

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    add_shortcode('houzez-recent-viewed-properties', 'houzez_recent_viewed_properties');
}
?>
