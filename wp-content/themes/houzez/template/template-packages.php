<?php
/**
 * Template Name: Packages
 */
global $houzez_local;

$paid_submission_type = esc_html ( houzez_option('enable_paid_submission','') );
if( $paid_submission_type != 'membership' ) {
    wp_redirect( home_url() );
}

get_header();

if(houzez_check_is_elementor()) {

    if( have_posts() ):
        while( have_posts() ): the_post();
            $content = get_the_content();
        endwhile;
     endif;
    wp_reset_postdata();
    if( !empty($content) ) { 
        the_content();

    } else {
        the_content();
        ?>
        <section class="frontend-submission-page">
            <div class="container">
                <div class="dashboard-content-block-wrap">
                    <div class="row row-no-padding">
                        <?php get_template_part('template-parts/membership/package-item'); ?>
                    </div>
                </div><!-- dashboard-content-block-wrap -->
            </div><!-- container -->
        </section><!-- frontend-submission-page -->
        <?php
    }

} else { ?>

    <section class="frontend-submission-page">
        <div class="container">
            <div class="dashboard-content-block-wrap">
                <?php
                if( have_posts() ):
                    while( have_posts() ): the_post();
                        $content = get_the_content();
                    endwhile;
                 endif;
                wp_reset_postdata();
                if( !empty($content) ) { 
                    the_content();

                } else {
                    echo '<div class="row row-no-padding">';
                    get_template_part('template-parts/membership/package-item');
                    echo '<div>';
                }
                ?>
            </div><!-- dashboard-content-block-wrap -->
            
        </div><!-- container -->
    </section>

<?php
}
?>

<?php get_footer(); ?>