<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 23/01/16
 * Time: 11:33 PM
 */
if( !function_exists('houzez_blog_posts_carousel') ) {
    function houzez_blog_posts_carousel($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'grid_style' => '',
            'category_id' => '',
            'posts_limit' => '',
            'offset' => '',
        ), $atts));

        ob_start();

        $wp_query_args = array(
            'ignore_sticky_posts' => 1,
            'post_type' => 'post'
        );
        if (!empty($category_id)) {
            $wp_query_args['cat'] = $category_id;
        }
        if (!empty($offset)) {
            $wp_query_args['offset'] = $offset;
        }
        $wp_query_args['post_status'] = 'publish';

        if (empty($posts_limit)) {
            $posts_limit = get_option('posts_per_page');
        }
        $wp_query_args['posts_per_page'] = $posts_limit;

        $module_class = "blog-posts-module-v1";
        if($grid_style == "style_2") {
            $module_class = "blog-posts-module-v2";
        }

        $the_query = New WP_Query($wp_query_args);

        $token = wp_generate_password(5, false, false);
        if (is_rtl()) {
            $houzez_rtl = "true";
        } else {
            $houzez_rtl = "false";
        }
        ?>
        <script>
            jQuery(document).ready(function ($) {

                var owl_post_card = $('#carousel-post-card-<?php echo esc_attr( $token ); ?>');

                owl_post_card.slick({
                    rtl: <?php echo esc_attr($houzez_rtl); ?>,
                    lazyLoad: 'ondemand',
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    arrows: true,
                    adaptiveHeight: true,
                    dots: true,
                    appendArrows: '.blog-posts-slider',
                    prevArrow: $('.blog-prev-js'),
                    nextArrow: $('.blog-next-js'),
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
            });
        </script>

        <div class="blog-posts-module blog-posts-slider <?php echo esc_attr($module_class); ?>">

            <div class="property-carousel-buttons-wrap">
                <button type="button" class="blog-prev-js slick-prev btn-primary-outlined"><?php esc_html_e('Prev', 'houzez'); ?></button>
                <button type="button" class="blog-next-js slick-next btn-primary-outlined"><?php esc_html_e('Next', 'houzez'); ?></button>
            </div><!-- property-carousel-buttons-wrap -->

            <div class="blog-posts-slider-wrap">
                <div id="carousel-post-card-<?php echo esc_attr($token); ?>" class="blog-posts-slide-wrap blog-posts-slide-wrap-js houzez-all-slider-wrap">
                    <?php 
                    if ($the_query->have_posts()): 
                        while ($the_query->have_posts()): $the_query->the_post(); ?>
                        <div class="blog-posts-slide-wrap">
                            <?php 
                            if($grid_style == "style_1") {
                                get_template_part('content-grid-1'); 
                            } else {
                                get_template_part('content-grid-2');
                            }
                            ?>
                        </div>
                    <?php endwhile; 
                    endif;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        </div><!-- blog-posts-module -->

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    add_shortcode('houzez-blog-posts-carousel', 'houzez_blog_posts_carousel');
}
?>