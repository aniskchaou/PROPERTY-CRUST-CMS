<?php
/*-----------------------------------------------------------------------------------*/
/*	Properties
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_properties_slider') ) {
	function houzez_properties_slider($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'property_type' => '',
			'property_status' => '',
			'posts_limit' => '',
		), $atts));

		ob_start();
		global $paged;
		if (is_front_page()) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		}

		//do the query
		$the_query = houzez_data_source::get_wp_query($atts, $paged); //by ref  do the query
		?>
		
		<section class="top-banner-wrap <?php houzez_banner_fullscreen(); ?> property-slider-wrap">
			<div class="property-slider houzez-all-slider-wrap">
				<?php 
				if( $the_query->have_posts() ): 
					while( $the_query->have_posts() ): $the_query->the_post();
						
						$slider_img = get_post_meta( get_the_ID(), 'fave_prop_slider_image', true );
						$img_url = wp_get_attachment_image_src( $slider_img, 'full', true );
						$img_url = $img_url[0];
						if(empty($slider_img)) {
							$img_url = wp_get_attachment_url( get_post_thumbnail_id() );
						}
						?>
						<div class="property-slider-item-wrap" style="background-image: url(<?php echo esc_url($img_url); ?>);"	>
							<a href="#" class="property-slider-link"></a>
							<div class="property-slider-item">
								<?php get_template_part('template-parts/listing/partials/item-featured-label'); ?>
								<?php get_template_part('template-parts/listing/partials/item-title'); ?>
								<?php get_template_part('template-parts/listing/partials/item-address'); ?>
								<?php get_template_part('template-parts/listing/partials/item-price'); ?>
								<?php get_template_part('template-parts/listing/partials/item-features-v1'); ?>
								<?php get_template_part('template-parts/listing/partials/item-author'); ?>
								<?php get_template_part('template-parts/listing/partials/item-date'); ?>
								<?php get_template_part('template-parts/listing/partials/item-btn'); ?>
							</div><!-- property-slider-item -->
						</div><!-- property-slider-item-wrap -->
				<?php
					endwhile;
				endif;
				wp_reset_postdata();
				?>
			</div><!-- property-slider -->

		</section><!-- property-slider-wrap -->

		<?php
		$result = ob_get_contents();
		ob_end_clean();
		return $result;

	}

	add_shortcode('houzez_properties_slider', 'houzez_properties_slider');
}
?>