<div class="next-prev-block next-prev-blog blog-section clearfix">
    <div class="prev-box float-left text-left">
        <?php
        $prevPost = get_previous_post(true);
        if($prevPost) {
        $args = array(
            'posts_per_page' => 1,
            'include' => $prevPost->ID
        );
        $prevPost = get_posts($args);
        foreach ($prevPost as $post) {
            setup_postdata($post);
            ?>
            <div class="next-prev-block-content">
                <p><?php esc_html_e( 'Prev Post', 'houzez' ); ?></p>
                <a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong></a>
            </div>
            <?php
            wp_reset_postdata();
            } //end foreach
        } // end if
        ?>
        
    </div>
    <div class="next-box float-right text-right">
        <?php
        $nextPost = get_next_post(true);
        if($nextPost) {
        $args = array(
            'posts_per_page' => 1,
            'include' => $nextPost->ID
        );
        $nextPost = get_posts($args);
            foreach ($nextPost as $post) {
            setup_postdata($post);
            ?>
            <div class="next-prev-block-content">
                <p><?php esc_html_e( 'Next post', 'houzez' ); ?></p>
                <a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong></a>
            </div>
        <?php
        wp_reset_postdata();
            } //end foreach
        } // end if
        ?>
    </div>
</div>