<?php
$top_bar_left = houzez_option('top_bar_left');
$top_bar_right = houzez_option('top_bar_right');
$top_bar_mobile = houzez_option('top_bar_mobile');
$hide_top_bar_mobile = '';
if( $top_bar_mobile != 0 ) {
    $hide_top_bar_mobile = 'hide-top-bar-mobile';
}
?>
<div class="top-bar-wrap <?php echo esc_attr($hide_top_bar_mobile); ?>">
	<div class="<?php echo esc_attr(houzez_option('top_bar_width')); ?>">
		<div class="d-flex justify-content-between">
			<div class="top-bar-left-wrap">
				<?php 
				if( $top_bar_left != 'none' ) {
					if( $top_bar_left == 'contact_info' ) {
                        get_template_part( 'template-parts/topbar/partials/contact' );

                    } elseif ( $top_bar_left == 'social_icons' ) {
                        get_template_part( 'template-parts/header/partials/social-icons' );

                    } elseif ( $top_bar_left == 'slogan' ) {
                        get_template_part( 'template-parts/topbar/partials/slogan' );

                    } elseif ( $top_bar_left == 'houzez_switchers' ) {
                        get_template_part( 'template-parts/topbar/partials/currency-switcher' );
                        get_template_part( 'template-parts/topbar/partials/area-switcher' );

                    } elseif ( $top_bar_left == 'menu_bar' ) {
                        get_template_part( 'template-parts/topbar/partials/nav' );
                    }
				}?>
			</div><!-- top-bar-left-wrap -->

			<div class="top-bar-right-wrap">
				<?php 
				if( $top_bar_right != 'none' ) {
					if( $top_bar_right == 'contact_info' ) {
                        get_template_part( 'template-parts/topbar/partials/contact' );

                    } elseif ( $top_bar_right == 'social_icons' ) {
                        get_template_part( 'template-parts/header/partials/social-icons' );

                    } elseif ( $top_bar_right == 'slogan' ) {
                        get_template_part( 'template-parts/topbar/partials/slogan' );

                    } elseif ( $top_bar_right == 'houzez_switchers' ) {
                        get_template_part( 'template-parts/topbar/partials/currency-switcher' );
                        get_template_part( 'template-parts/topbar/partials/area-switcher' );
                    } elseif ( $top_bar_right == 'menu_bar' ) {
                        get_template_part( 'template-parts/topbar/partials/nav' );
                    }
				}?>
			</div><!-- top-bar-right-wrap -->
		</div><!-- d-flex -->
	</div><!-- container -->
</div><!-- top-bar-wrap -->