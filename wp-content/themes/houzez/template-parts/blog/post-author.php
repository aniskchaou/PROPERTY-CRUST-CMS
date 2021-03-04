<?php
$author_image = get_the_author_meta('fave_author_custom_picture');
$facebook = get_the_author_meta('fave_author_facebook');
$twitter = get_the_author_meta('fave_author_twitter');
$linkedin = get_the_author_meta('fave_author_linkedin');
$googleplus = get_the_author_meta('fave_author_googleplus');
$youtube = get_the_author_meta('fave_author_youtube');
$vimeo = get_the_author_meta('fave_author_vimeo');
$instagram = get_the_author_meta('fave_author_instagram');
$pinterest = get_the_author_meta('fave_author_pinterest');

if( empty($author_image) ) {
    $author_image = houzez_get_avatar_url(get_avatar( get_the_author_meta( 'ID' ), 60 ));
}

if(houzez_option('blog_author_box')) {
?>
<div class="author-detail-wrap">
    <div class="d-flex">
        <div class="post-author-thumb">
            <a><img src="<?php echo esc_url( $author_image ); ?>" alt="img" class="rounded-circle img-fluid"></a>
        </div><!-- post-author-thumb -->

        <div class="post-author-bio">
            <h4><?php esc_attr( the_author_meta( 'display_name' )); ?></h4>
            <p><?php esc_attr( the_author_meta( 'description' )); ?> </p>

            <div class="agent-social-media">
                
                <?php if( !empty( $facebook ) ) { ?>
                <span>
                    <a class="btn-facebook" target="_blank" href="<?php echo esc_url( $facebook ); ?>">
                        <i class="houzez-icon icon-social-media-facebook mr-2"></i>
                    </a>
                </span>
                <?php } ?>

                <?php if( !empty( $instagram ) ) { ?>
                <span>
                    <a class="btn-instagram" target="_blank" href="<?php echo esc_url( $instagram ); ?>">
                        <i class="houzez-icon icon-social-instagram mr-2"></i>
                    </a>
                </span>
                <?php } ?>
                
                <?php if( !empty( $twitter ) ) { ?>
                <span>
                    <a class="btn-twitter" target="_blank" href="<?php echo esc_url( $twitter ); ?>">
                        <i class="houzez-icon icon-social-media-twitter mr-2"></i>
                    </a>
                </span>
                <?php } ?>
                
                <?php if( !empty( $linkedin ) ) { ?>
                <span>
                    <a class="btn-linkedin" target="_blank" href="<?php echo esc_url( $linkedin ); ?>">
                        <i class="houzez-icon icon-professional-network-linkedin mr-2"></i>
                    </a>
                </span>
                <?php } ?>
                
                <?php if( !empty( $googleplus ) ) { ?>
                <span>
                    <a class="btn-googleplus" target="_blank" href="<?php echo esc_url( $googleplus ); ?>">
                        <i class="houzez-icon icon-social-media-google-plus-1 mr-2"></i>
                    </a>
                </span>
                <?php } ?>
                
                <?php if( !empty( $youtube ) ) { ?>
                <span>
                    <a class="btn-youtube" target="_blank" href="<?php echo esc_url( $youtube ); ?>">
                        <i class="houzez-icon icon-social-video-youtube-clip mr-2"></i>
                    </a>
                </span>
                <?php } ?>
                
                <?php if( !empty( $pinterest ) ) { ?>
                <span>
                    <a class="btn-pinterest" target="_blank" href="<?php echo esc_url( $pinterest ); ?>">
                        <i class="houzez-icon icon-social-pinterest mr-2"></i>
                    </a>
                </span>
                <?php } ?>
                
                <?php if( !empty( $vimeo ) ) { ?>
                <span>
                    <a class="btn-vimeo" target="_blank" href="<?php echo esc_url( $vimeo ); ?>">
                        <i class="houzez-icon icon-social-video-vimeo mr-2"></i>
                    </a>
                </span>
                <?php } ?>
            </div><!-- agent-social-media -->
        </div><!-- post-author-bio -->
    </div><!-- d-flex -->
</div><!-- author-detail-wrap -->
<?php } ?>