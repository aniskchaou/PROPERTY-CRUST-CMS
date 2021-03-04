<?php $sticky_header = houzez_option('main-menu-sticky', 0); ?>
<div id="header-section" class="header-desktop header-v6" data-sticky="<?php echo intval($sticky_header); ?>">
    <div class="header-top">
        <div class="container-fluid">
            <div class="header-inner-wrap">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="header-wrap-6 header-wrap-6-icons">
                        <?php get_template_part('template-parts/header/partials/social-icons'); ?> 
                    </div>
                    <div class="header-wrap-6 header-wrap-6-left-menu">
                        <nav class="main-nav on-hover-menu navbar-expand-lg">
                            <?php get_template_part('template-parts/header/partials/nav-left'); ?>    
                        </nav>
                    </div>
                    <div class="header-wrap-6 header-wrap-6-logo">
                        <?php get_template_part('template-parts/header/partials/logo'); ?>
                    </div>
                    <div class="header-wrap-6 header-wrap-6-right-menu">
                        <nav class="main-nav on-hover-menu navbar-expand-lg">
                            <?php get_template_part('template-parts/header/partials/nav-right'); ?>    
                        </nav>
                    </div>
                    <div class="header-wrap-6 header-wrap-6-login-register">
                        <?php get_template_part('template-parts/header/user-nav'); ?>
                    </div>
                </div><!-- d-flex -->
            </div><!-- header-inner-wrap -->
        </div><!-- container-fluid -->
    </div><!-- .header-top -->
</div><!-- .header-v6 -->