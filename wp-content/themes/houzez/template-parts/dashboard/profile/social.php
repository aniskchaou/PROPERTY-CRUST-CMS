<?php
global $current_user, $houzez_local;
$userID = get_current_user_id();

$facebook               =   get_the_author_meta( 'fave_author_facebook' , $userID );
$twitter                =   get_the_author_meta( 'fave_author_twitter' , $userID );
$linkedin               =   get_the_author_meta( 'fave_author_linkedin' , $userID );
$pinterest              =   get_the_author_meta( 'fave_author_pinterest' , $userID );
$instagram              =   get_the_author_meta( 'fave_author_instagram' , $userID );
$googleplus             =   get_the_author_meta( 'fave_author_googleplus' , $userID );
$youtube                =   get_the_author_meta( 'fave_author_youtube' , $userID );
$vimeo                  =   get_the_author_meta( 'fave_author_vimeo' , $userID );
$user_skype             =   get_the_author_meta( 'fave_author_skype' , $userID );
$website_url            =   get_the_author_meta( 'user_url' , $userID );
?>
<div class="dashboard-content-block">
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <h2><?php esc_html_e('Social Media','houzez');?></h2>
        </div><!-- col-md-3 col-sm-12 -->

        <div class="col-md-9 col-sm-12">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="facebook"><?php esc_html_e( 'Facebook', 'houzez' ); ?></label>
                        <input class="form-control" name="facebook" value="<?php echo esc_url( $facebook );?>" placeholder="<?php esc_html_e( 'Enter the Facebook URL', 'houzez' ); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Twitter', 'houzez' ); ?></label>
                        <input class="form-control" name="twitter" value="<?php echo esc_url( $twitter );?>" placeholder="<?php esc_html_e( 'Enter the Twitter URL', 'houzez' ); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Linkedin', 'houzez' ); ?></label>
                        <input class="form-control" name="linkedin" value="<?php echo esc_url( $linkedin );?>" placeholder="<?php esc_html_e( 'Enter the Linkedin URL', 'houzez' ); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Instagram', 'houzez' ); ?></label>
                        <input class="form-control" name="instagram" value="<?php echo esc_url( $instagram );?>" placeholder="<?php esc_html_e( 'Enter the Instagram URL', 'houzez' ); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Google Plus', 'houzez' ); ?></label>
                        <input class="form-control" name="googleplus" value="<?php echo esc_url( $googleplus );?>" placeholder="<?php esc_html_e( 'Enter the Google Plus URL', 'houzez' ); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Youtube', 'houzez' ); ?></label>
                        <input class="form-control" name="youtube" value="<?php echo esc_url( $youtube );?>" placeholder="<?php esc_html_e( 'Enter the Youtube URL', 'houzez' ); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Pinterest', 'houzez' ); ?></label>
                        <input class="form-control" name="pinterest" value="<?php echo esc_url( $pinterest );?>" placeholder="<?php esc_html_e( 'Enter the Pinterest URL', 'houzez' ); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Vimeo', 'houzez' ); ?></label>
                        <input class="form-control" name="vimeo" value="<?php echo esc_url( $vimeo );?>" placeholder="<?php esc_html_e( 'Enter the Vimeo URL', 'houzez' ); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Skype', 'houzez' ); ?></label>
                        <input class="form-control" name="userskype" value="<?php echo esc_attr( $user_skype );?>" placeholder="<?php esc_html_e( 'Enter your Skype ID', 'houzez' ); ?>" type="text">
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label><?php esc_html_e( 'Website', 'houzez' ); ?></label>
                        <input class="form-control" name="website" value="<?php echo esc_url($website_url); ?>" placeholder="<?php esc_html_e( 'Enter your website URL', 'houzez' ); ?>" type="text">
                    </div>
                </div>

            </div><!-- row -->

            <button class="houzez_update_profile btn btn-success">
                <?php get_template_part('template-parts/loader'); ?>
                <?php esc_html_e('Update Profile', 'houzez'); ?>
            </button><br/>
            <div class="notify"></div>
        </div><!-- col-md-9 col-sm-12 -->
    </div><!-- row -->
</div><!-- dashboard-content-block -->