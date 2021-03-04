<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 23/01/16
 * Time: 11:33 PM
 */
if( !function_exists('houzez_blog_posts') ) {
    function houzez_blog_posts($atts, $content = null)
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

        $the_query = New WP_Query($wp_query_args);
        ?>

        <?php if ($grid_style == 'style_1') { ?>

            <div class="blog-posts-module blog-posts-module-v1">
                <div class="row module-row">
                    <?php 
                    if ($the_query->have_posts()): 
                        while ($the_query->have_posts()): $the_query->the_post(); ?>
                        <div class="col-lg-3 col-md-6">
                            <?php get_template_part('content-grid-1'); ?>
                        </div>
                    <?php endwhile; 
                    endif;
                    wp_reset_postdata(); ?>
                </div><!-- row -->
            </div><!-- blog-posts-module -->

        <?php } 
        elseif ($grid_style == 'style_2') { ?>

            <div class="blog-posts-module blog-posts-module-v2">
                <div class="row module-row">
                    <?php 
                    if ($the_query->have_posts()): 
                        while ($the_query->have_posts()): $the_query->the_post(); ?>
                        <div class="col-lg-3 col-md-6">
                            <?php get_template_part('content-grid-2'); ?>
                        </div>
                    <?php endwhile; 
                    endif;
                    wp_reset_postdata(); ?>
                </div><!-- row -->
            </div><!-- blog-posts-module -->

        <?php } ?>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    add_shortcode('houzez-blog-posts', 'houzez_blog_posts');
}
?>