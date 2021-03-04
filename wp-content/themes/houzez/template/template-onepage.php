<?php
/**
 * Template Name: One Page Template
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 24/06/16
 * Time: 4:28 AM
 */
get_header(); ?>

<?php
while ( have_posts() ): the_post();
    the_content();
endwhile;
?>

<?php get_footer(); ?>