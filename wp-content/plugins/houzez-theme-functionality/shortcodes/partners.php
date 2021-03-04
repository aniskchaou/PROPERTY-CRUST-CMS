<?php
/**
 * Partners
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 07/01/16
 * Time: 7:00 PM
 */
if( !function_exists('houzez_partners') ) {
    function houzez_partners($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'posts_limit' => '',
            'offset' => '',
            'orderby' => '',
            'order' => ''
        ), $atts));

        ob_start();

        $args = array(
            'post_type' => 'houzez_partner',
            'posts_per_page' => $posts_limit,
            'orderby' => $orderby,
            'order' => $order,
            'offset' => $offset
        );
        $wp_qry = new WP_Query($args);
        ?>


        <div class="partners-module partners-module-slider">

            <div class="property-carousel-buttons-wrap">
                <button type="button" class="partner-prev-js slick-prev btn-primary-outlined"><?php esc_html_e('Prev', 'houzez'); ?></button>
                <button type="button" class="partner-next-js slick-next btn-primary-outlined"><?php esc_html_e('Next', 'houzez'); ?></button>
            </div><!-- property-carousel-buttons-wrap -->

            <div class="partners-slider-wrap houzez-all-slider-wrap">
                <?php
                if ($wp_qry->have_posts()): 
                    while ($wp_qry->have_posts()): $wp_qry->the_post();
                        $website = get_post_meta(get_the_ID(), 'fave_partner_website', true); ?>

                        <div class="partner-item">
                            <a target="_blank" href="<?php echo esc_url($website); ?>">
                                <?php the_post_thumbnail('full'); ?>
                            </a>
                        </div>
                
                <?php endwhile; 
                endif; ?>
                <?php wp_reset_postdata(); ?>

            </div><!-- testimonials-slider -->
        </div><!-- testimonials-module -->


        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    add_shortcode('houzez-partners', 'houzez_partners');
}