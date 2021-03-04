<?php
/**
 * Testimonials
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 07/01/16
 * Time: 4:00 PM
 */
if( !function_exists('houzez_testimonials') ) {
    function houzez_testimonials($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'testimonials_type' => '',
            'posts_limit' => '',
            'offset' => '',
            'orderby' => '',
            'order' => ''
        ), $atts));

        ob_start();
        
        $args = array(
            'post_type' => 'houzez_testimonials',
            'posts_per_page' => $posts_limit,
            'orderby' => $orderby,
            'order' => $order,
            'offset' => $offset
        );
        $testi_qry = new WP_Query($args);

        $cols_class = "col-md-3";
        if ($testimonials_type == 'grid_3cols') {
            $cols_class = "col-md-4";
        }

        if ($testimonials_type == 'grid' || $testimonials_type == 'grid_3cols') { ?>

            <div class="testimonials-module testimonials-module-v1">
                <div class="row">
                    <?php
                    if ($testi_qry->have_posts()): 
                        while ($testi_qry->have_posts()): $testi_qry->the_post(); ?>

                            <div class="<?php echo esc_attr($cols_class); ?>">
                                <?php get_template_part('template-parts/testimonials/item-v1'); ?>
                            </div>
                    <?php
                        endwhile;
                    endif;
                    ?>
                </div>
            </div><!-- testimonials-module -->

        <?php } else { ?>

            <div class="testimonials-module testimonials-module-slider-v1 testimonials-module-v1">
                <div class="testimonials-slider-wrap-v1 houzez-all-slider-wrap">
                    <?php
                    if ($testi_qry->have_posts()): 
                        while ($testi_qry->have_posts()): $testi_qry->the_post(); 

                            get_template_part('template-parts/testimonials/item-v1'); 
                            
                        endwhile;
                    endif;
                    ?>
                </div><!-- testimonials-slider -->
            </div><!-- testimonials-module -->

        <?php } ?>


        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    add_shortcode('houzez-testimonials', 'houzez_testimonials');
}
?>