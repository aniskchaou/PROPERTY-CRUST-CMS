<?php
/*-----------------------------------------------------------------------------------*/
/*  Module 1
/*-----------------------------------------------------------------------------------*/
if( !function_exists('houzez_team') ) {
    function houzez_team($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'team_image' => '',
            'team_name' => '',
            'team_position' => '',
            'team_description' => '',
            'team_link' => '',
            'team_social_facebook' => '',
            'team_social_twitter' => '',
            'team_social_linkedin' => '',
            'team_social_pinterest' => '',
            'team_social_googleplus' => '',
            'team_social_facebook_target' => '',
            'team_social_twitter_target' => '',
            'team_social_linkedin_target' => '',
            'team_social_pinterest_target' => '',
            'team_social_googleplus_target' => ''
        ), $atts));

        ob_start();

    
        if( !empty($team_image) ) {

            $social = '';

            if( !empty($team_social_facebook) ) {
                $social .= '<li class="list-inline-item">
                        <a target="'.esc_attr($team_social_facebook_target).'" href="'.esc_url($team_social_facebook).'" class="btn-facebook"><i class="houzez-icon icon-social-media-facebook"></i></a>
                    </li>';
            }

            if( !empty($team_social_twitter) ) {
                $social .= '<li class="list-inline-item"><a target="'.esc_attr($team_social_twitter_target).'" href="'.esc_url($team_social_twitter).'" class="btn-twitter"><i class="houzez-icon icon-social-media-twitter"></i></a></li>';
            }

            if( !empty($team_social_linkedin) ) {
                $social .= '<li class="list-inline-item"><a target="'.esc_attr($team_social_linkedin_target).'" href="'.esc_url($team_social_linkedin).'" class="btn-linkedin"><i class="houzez-icon icon-professional-network-linkedin"></i></a></li>';
            }
            if( !empty($team_social_pinterest) ) {
                $social .= '<li class="list-inline-item"><a target="'.esc_attr($team_social_pinterest_target).'" href="'.esc_url($team_social_pinterest).'" class="btn-pinterest"><i class="houzez-icon icon-social-pinterest"></i></a></li>';
            }
            if( !empty($team_social_googleplus) ) {
                $social .= '<li class="list-inline-item"><a target="'.esc_attr($team_social_googleplus_target).'" href="'.esc_url($team_social_googleplus).'" class="btn-google-plus"><i class="houzez-icon icon-social-media-google-plus-1"></i></a></li>';
            }

        ?>

            <div class="team-module hover-effect">

                <?php if( !empty($team_link)) { ?>
                <a href="<?php echo esc_url($team_link); ?>" class="team-mobile-link"></a>
                <?php } ?>
                <?php echo wp_get_attachment_image( $team_image, 'full', array('class' => 'img-fluid') ); ?>

                <div class="team-content-wrap team-content-wrap-before">
                    <div class="team-content">
                        <div class="team-name">
                            <strong><?php echo esc_attr($team_name); ?></strong>
                        </div><!-- team-name -->
                        <div class="team-title">
                            <?php echo esc_attr($team_position); ?>
                        </div><!-- team-name -->
   
                    </div><!-- team-content -->
                </div><!-- team-content-wrap -->
                <div class="team-content-wrap team-content-wrap-after">
                    <div class="team-content">
                        <div class="team-name">
                            <strong><?php echo esc_attr($team_name); ?></strong>
                        </div><!-- team-name -->
                        <div class="team-title">
                            <?php echo esc_attr($team_position); ?>
                        </div><!-- team-name -->
                        <div class="team-description">
                            <?php echo ($team_description); ?>
                        </div><!-- team-description -->

                        <?php if( !empty($team_social_facebook) || !empty($team_social_twitter) || !empty($team_social_linkedin) || !empty($team_social_pinterest) || !empty($team_social_googleplus) ) { ?>
                            <div class="team-social-wrap">
                                <ul class="team-social list-unstyled list-inline">
                                    <?php echo $social; ?>
                                </ul>
                            </div><!-- team-social-wrap -->    
                        <?php } ?>    
                    </div><!-- team-content -->
                </div><!-- team-content-wrap -->
            </div><!-- taxonomy-grids-module -->
            <?php
        }
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    add_shortcode('houzez-team', 'houzez_team');
}
?>