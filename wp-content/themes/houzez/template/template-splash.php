<?php
/**
 * Template Name: Splash Page Template
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 18/12/15
 * Time: 3:49 PM
 */
get_header();
global $houzez_local, $post;
$search_template = houzez_get_template_link('template/template-search.php');
$background_type = houzez_option('backgroud_type');
$splash_welcome_text = houzez_option( 'splash_welcome_text' );
$page_head_subtitle = houzez_option( 'splash_welcome_sub' );
$splash_callus_icon = houzez_option( 'splash_callus_icon' );
$splash_callus_text = houzez_option( 'splash_callus_text' );
$splash_callus_phone = houzez_option( 'splash_callus_phone' );
$splash_overlay = houzez_option( 'splash_overlay' );
$splash_layout = houzez_option('splash_layout');
$image_ids = $ogv = $mp4 = $webm = $video_image = '';

$allowed_html = array(
    'i' => array(
        'class' => array()
    )
);

if( $splash_overlay != 0 ) {
    $overlay = 'true';
} else {
    $overlay = 'false';
}

if( isset($_GET['splash_type'] ) ) {
    $background_type = $_GET['splash_type'];
}

$bg_img = '';
if( $background_type == 'image' ) {
    $image_url = houzez_option( 'splash_image', false, 'url' );
    if (!empty($image_url)) {
        $bg_img = esc_url ( $image_url );
    }
} else if ( $background_type == 'slider' ) {
    $image_ids = houzez_option( 'splash_slider' );
    $image_ids = explode(',', $image_ids );

} else if( $background_type == 'video' ) {
    $mp4 = houzez_option( 'splash_bg_mp4', false, 'url' );
    $webm = houzez_option( 'splash_bg_webm', false, 'url' );
    $ogv = houzez_option( 'splash_bg_ogv', false, 'url' );
    $splash_video_image = houzez_option('splash_video_image', false, 'url');

    $ogv = substr($ogv, 0, strrpos($ogv, "."));
    $mp4 = substr($mp4, 0, strrpos($mp4, "."));
    $webm = substr($webm, 0, strrpos($webm, "."));
    $video_image = substr($splash_video_image, 0, strrpos($splash_video_image, "."));

}
?>
<section class="top-banner-wrap top-banner-wrap-fullscreen horizontal-search-wrap">
    <div id="houzez-auto-complete-banner" class="auto-complete"></div>
    <?php 
    if ( $background_type == 'slider' ) {

        echo '<div class="splash-slider-wrap">';

        if(!empty($image_ids)) {
            foreach ( $image_ids as $id ) {
                $url = wp_get_attachment_image_src($id, array(2000, 1000));
                echo '<div class="splash-slider-item" style="background-image: url('.esc_url($url[0]).');"></div>';
                
            } 
        }

        echo '</div>';
    } else if($background_type == 'video') {

        echo '<div id="video-background" class="video-background splash-video-background" data-vide-bg="mp4: '.$mp4.', webm: '.$webm.', ogv: '.$ogv.', poster: '.$video_image.'" data-vide-options="position: 0% 50%">
            </div>';

    } ?>

    <?php if( $background_type == 'image' ) { ?>
    <div class="banner-inner parallax d-flex" data-parallax-bg-image="<?php echo esc_url($bg_img); ?>">
    <?php } else { ?>
    <div class="banner-inner d-flex">
    <?php } ?>
        <div class="align-self-center flex-fill">
            <div class="banner-caption">
                <h2 class="banner-title"><?php echo $splash_welcome_text; ?></h2>
                <p class="banner-subtitle"><?php echo $page_head_subtitle; ?></p>
                <?php get_template_part('template-parts/search/search-for-banners'); ?>
            </div><!-- banner-caption -->
        </div><!-- align-self-center -->
    </div><!-- banner-inner parallax -->
</section><!-- top-banner-wrap -->

<footer class="splash-page-footer">
    <div class="d-flex justify-content-between">
        <div class="splash-page-footer-left">
            <i class="houzez-icon icon-messaging-whatsapp"></i> <?php echo esc_attr( $splash_callus_text ); ?> <?php echo esc_attr( $splash_callus_phone ); ?>
        </div><!-- splash-page-footer-left -->

        <?php if( houzez_option('social-splash')): ?>
        <div class="splash-page-footer-right">
            <div class="footer-social">
                <span class="footer-social-title">
                    <?php echo $houzez_local['follow_us']; ?>
                </span>

                <?php if( houzez_option('sp-facebook') != '' ){ ?>
                    <span>
                        <a target="_blank" class="btn-facebook" href="<?php echo esc_url(houzez_option('sp-facebook')); ?>"><i class="houzez-icon icon-social-media-facebook mr-2"></i></a>
                    </span>
                <?php } ?>

                <?php if( houzez_option('sp-twitter') != '' ){ ?>
                    <span>
                        <a target="_blank" class="btn-twitter" href="<?php echo esc_url(houzez_option('sp-twitter')); ?>"><i class="houzez-icon icon-social-media-twitter mr-2"></i></a>
                    </span>
                <?php } ?>

                <?php if( houzez_option('sp-linkedin') != '' ){ ?>
                    <span>
                        <a target="_blank" class="btn-linkedin" href="<?php echo esc_url(houzez_option('sp-linkedin')); ?>"><i class="houzez-icon icon-professional-network-linkedin mr-2"></i></a>
                    </span>
                <?php } ?>

                <?php if( houzez_option('sp-googleplus') != '' ){ ?>
                    <span>
                        <a target="_blank" class="btn-google-plus" href="<?php echo esc_url(houzez_option('sp-googleplus')); ?>"><i class="houzez-icon icon-social-media-google-plus-1 mr-2"></i></a>
                    </span>
                <?php } ?>

                <?php if( houzez_option('sp-instagram') != '' ){ ?>
                    <span>
                        <a target="_blank" class="btn-instagram" href="<?php echo esc_url(houzez_option('sp-instagram')); ?>"><i class="houzez-icon icon-social-instagram mr-2"></i></a>
                    </span>
                <?php } ?>

            </div><!-- footer-social -->
        </div><!-- splash-page-footer-right -->
        <?php endif; ?>

    </div><!-- d-flex -->
</footer><!-- splash-page-footer -->

<?php get_footer(); ?>