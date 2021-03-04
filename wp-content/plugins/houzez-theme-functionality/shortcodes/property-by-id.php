<?php
if( !function_exists('houzez_property_by_id') ) {
    function houzez_property_by_id($atts, $content = null)
    {

        extract(shortcode_atts(array(
            'prop_grid_style' => '',
            'property_id' => ''
        ), $atts));

        ob_start();

        $cards_class = 'property-cards-module-v1';
        $cards_version = 'v1';

        if( $prop_grid_style == "v_1" ) {
            $cards_version = 'v1';

        } elseif( $prop_grid_style == "v_2" ) {
            $cards_class = 'property-cards-module-v2';
            $cards_version = 'v2';

        } elseif( $prop_grid_style == "v_3" ) {
            $cards_class = 'property-cards-module-v3';
            $cards_version = 'v3';
            
        } elseif( $prop_grid_style == "v_4" ) {
            $cards_version = 'v4';
            
        } elseif( $prop_grid_style == "v_5" ) {
            $cards_version = 'v5';
            
        } elseif( $prop_grid_style == "v_6" ) {
            $cards_version = 'v6';
            
        } 

        $args = array(
            'post_type' => 'property',
            'post__in' => array($property_id),
            'post_status' => 'publish'
        );
        //do the query
        $the_query = New WP_Query($args);
        ?>

        <div class="property-by-id-module <?php echo esc_attr($cards_class); ?>">
            <div class="listing-view grid-view card-deck">
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

    add_shortcode('houzez-prop-by-id', 'houzez_property_by_id');
}
?>
