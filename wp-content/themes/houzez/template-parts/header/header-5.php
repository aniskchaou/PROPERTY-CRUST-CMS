<?php $sticky_header = houzez_option('main-menu-sticky', 0); ?>
<div class="header-desktop header-v5">
    <div class="header-top">
        <div class="container-fluid">
            <div class="header-inner-wrap">
                <div class="d-flex align-items-center">
                    <?php 
                    if( houzez_option('social-header') != 1 ) {
                        echo '<div class="header-social-icons"></div>';
                    } 
                    ?>
                    <?php get_template_part('template-parts/header/partials/social-icons'); ?>

                    <?php get_template_part('template-parts/header/partials/logo'); ?>

                    <?php get_template_part('template-parts/header/user-nav'); ?>
                </div><!-- d-flex -->
            </div>
        </div>
    </div><!-- .header-top -->
    <div id="header-section" class="header-bottom" data-sticky="<?php echo intval($sticky_header); ?>">
        <div class="container">
            <div class="header-inner-wrap">
                <div class="d-flex flex-fill navbar-expand-lg align-items-center justify-content-center">
                    <nav class="main-nav on-hover-menu">
                        <?php get_template_part('template-parts/header/partials/nav'); ?>
                    </nav><!-- main-nav -->
                </div><!-- d-flex -->
            </div>
        </div>
    </div><!-- .header-bottom -->
</div><!-- .header-v5 -->