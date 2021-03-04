<?php
/**
 * Agents Grid and Carousel
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 07/01/16
 * Time: 5:17 PM
 */
if( !function_exists('houzez_agents') ) {
    function houzez_agents($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'agents_type' => '',
            'agent_category' => '',
            'agent_city' => '',
            'posts_limit' => '',
            'offset' => '',
            'columns' => '',
            'orderby' => '',
            'order' => '',
        ), $atts));

        ob_start();

        if(empty($columns)) {
            $columns = 3;
        }
        
        $tax_query = array();

        $args = array(
            'post_type' => 'houzez_agent',
            'posts_per_page' => $posts_limit,
            'orderby' => $orderby,
            'order' => $order,
            'offset' => $offset,
            'meta_query' => array(
                'relation' => 'OR',
                    array(
                     'key' => 'fave_agent_visible',
                     'compare' => 'NOT EXISTS', // works!
                     'value' => '' // This is ignored, but is necessary...
                    ),
                    array(
                     'key' => 'fave_agent_visible',
                     'value' => 1,
                     'type' => 'NUMERIC',
                     'compare' => '!=',
                    )
            )
        );

        if (!empty($agent_category)) {
            $tax_query[] = array(
                'taxonomy' => 'agent_category',
                'field' => 'slug',
                'terms' => $agent_category
            );
        }
        if (!empty($agent_city)) {
            $tax_query[] = array(
                'taxonomy' => 'agent_city',
                'field' => 'slug',
                'terms' => $agent_city
            );
        }

        $tax_count = count( $tax_query );

        if( $tax_count > 1 ) {
            $tax_query['relation'] = 'AND';
        }
        if( $tax_count > 0 ){
            $args['tax_query'] = $tax_query;
        }

        $wp_qry = new WP_Query($args);

        $module_class = 'module-3cols';
        if($columns == "4") {
            $module_class = 'module-4cols';
        }
        ?>

        <!--start agents module-->
        <?php 
        if ($agents_type == 'grid') { ?>

            <div class="agent-module <?php echo esc_attr($module_class); ?> clearfix">

                <?php 
                if ($wp_qry->have_posts()): 
                    while ($wp_qry->have_posts()): $wp_qry->the_post();
                        get_template_part('template-parts/realtors/agent/agent-item');

                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div><!-- agent-module -->

        <?php 
        } elseif ($agents_type == 'Carousel') { ?>

            <?php
            $token = wp_generate_password(5, false, false);
            if (is_rtl()) {
                $houzez_rtl = "true";
            } else {
                $houzez_rtl = "false";
            }
            ?>

            <script type="text/javascript">
                jQuery(document).ready(function($){
                    if($("#agents-carousel-<?php echo esc_attr( $token ); ?>").length > 0){
                        var owlAgents = $('#agents-carousel-<?php echo esc_attr( $token ); ?>');
                        
                        owlAgents.slick({
                            rtl: <?php echo esc_attr( $houzez_rtl ); ?>,
                            lazyLoad: 'ondemand',
                            infinite: true,
                            speed: 300,
                            slidesToShow: <?php echo intval($columns); ?>,
                            arrows: true,
                            adaptiveHeight: true,
                            dots: true,
                            appendArrows: '.agents-module-slider',
                            prevArrow: $('.agents-prev-js'),
                            nextArrow: $('.agents-next-js'),
                            responsive: [{
                                    breakpoint: 992,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 2
                                    }
                                },
                                {
                                    breakpoint: 769,
                                    settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1
                                    }
                                }
                            ]
                        });

                    }
                });
            </script>

            <div class="agents-module agents-module-slider">
                <div class="property-carousel-buttons-wrap">
                    <button type="button" class="agents-prev-js slick-prev btn-primary-outlined"><?php esc_html_e('Prev', 'houzez'); ?></button>
                    <button type="button" class="agents-next-js slick-next btn-primary-outlined"><?php esc_html_e('Next', 'houzez'); ?></button>
                </div><!-- property-carousel-buttons-wrap -->
            
                <div id="agents-carousel-<?php echo esc_attr( $token ); ?>" class="agents-slider-wrap houzez-all-slider-wrap">
                    <?php 
                    if ($wp_qry->have_posts()): 
                        while ($wp_qry->have_posts()): $wp_qry->the_post();
                            get_template_part('template-parts/realtors/agent/agent-item');

                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>

        <?php 
        } ?>
        <!--end post agents module-->


        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }
    add_shortcode('houzez-agents', 'houzez_agents');
}
?>