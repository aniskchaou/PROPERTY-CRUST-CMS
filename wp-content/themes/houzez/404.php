<?php 
/**
 * 404 error page
 *
 * @package Houzez
 * @since 	Houzez 1.0
**/
global $houzez_local;
$title_404 = houzez_option('404-title');
$title_des = houzez_option('404-des');
get_header(); ?>

<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>
<section class="page-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">                      
                <div class="article-wrap">
                    <article class="article-page-wrap">
                        

                    	<div class="error-404-page text-center">
							<h1><?php echo esc_attr( $title_404 ); ?></h1>

							<p><?php echo wp_kses_post( $title_des ); ?></p>
							
							<a class="btn btn-link" href="<?php echo esc_url( site_url() ); ?>"><?php echo $houzez_local['404_page'];?></a>
						</div>
                            
                       
                    </article><!-- article-page-wrap -->
                </div>
            </div><!-- bt-content-wrap -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- listing-wrap -->
<?php } ?>
	
<?php get_footer(); ?>