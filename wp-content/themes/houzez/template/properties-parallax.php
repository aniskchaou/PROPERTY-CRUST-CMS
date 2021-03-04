<?php
/**
 * Template Name: Template Listings Parallax
 */
get_header(); ?>


<?php
global $post;
$page_content_position = houzez_get_listing_data('listing_page_content_area');

$latest_listing_args = array(
    'post_type' => 'property',
    'post_status' => 'publish'
);

$latest_listing_args = apply_filters( 'houzez20_property_filter', $latest_listing_args );

$latest_listing_args = houzez_prop_sort ( $latest_listing_args );

$listings_query = new WP_Query( $latest_listing_args );
?>

<?php
if ( $page_content_position !== '1' ) {
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            ?>
            <article <?php post_class(); ?>>
                <?php the_content(); ?>
            </article>
            <?php
        }
    } 
}?> 

<section class="listing-wrap">
<?php	
$i = 1;
if ( $listings_query->have_posts() ) :
    while ( $listings_query->have_posts() ) : $listings_query->the_post(); 

    $post_meta_data     = get_post_custom(get_the_ID());
	$prop_images        = get_post_meta( get_the_ID(), 'fave_property_images', false );
	$prop_address       = get_post_meta( get_the_ID(), 'fave_property_map_address', true );
	$prop_featured      = get_post_meta( get_the_ID(), 'fave_featured', true );

	$thumb_id = get_post_thumbnail_id( $post->ID );
	$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', false);
	$thumb_url = $thumb_url_array[0];
	
	$feat_class = '';
	if( $prop_featured == 1 ) {
	    $feat_class = "featured_prop";
	}

	if($i % 2 == 1 ) {
		$class_pos = 'left';
	} else {
		$class_pos = 'right';
	}
	$i++;
    ?>

    <div class="item-listing-parallax" style="height: 600px;">
    	<a class="item-listing-parallax-link" href="<?php echo esc_url(get_permalink()); ?>"></a>
		<div class="item-parallax-inner parallax" data-parallax-bg-image="<?php echo esc_url($thumb_url); ?>">
			<div class="item-parallax-wrap" data-aos="fade">
				<?php get_template_part('template-parts/listing/partials/item-featured-label'); ?>
				<?php get_template_part('template-parts/listing/partials/item-labels'); ?>
				<?php get_template_part('template-parts/listing/partials/item-title'); ?>
				<?php get_template_part('template-parts/listing/partials/item-address'); ?>
				<?php get_template_part('template-parts/listing/partials/item-price'); ?>
				<?php get_template_part('template-parts/listing/partials/item-features-v1'); ?>
			</div><!-- item-parallax-wrap -->
		</div><!-- parallax -->
	</div><!-- item-listing-parallax -->

<?php
    endwhile;
else:
    get_template_part('template-parts/listing/item', 'none');
endif;
?>

<?php houzez_pagination( $listings_query->max_num_pages, $range = 2 ); ?>

</section>

<?php
if ('1' === $page_content_position ) {
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            ?>
            <section class="content-wrap">
                <?php the_content(); ?>
            </section>
            <?php
        }
    }
}
?>

<?php get_footer(); ?>