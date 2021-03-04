<?php global $top_area; ?>
<div class="page-title-wrap">
    <div class="container">
        <div class="d-flex align-items-center">
            <?php get_template_part('template-parts/page/breadcrumb'); ?>
            <?php get_template_part('property-details/partials/tools'); ?> 
        </div><!-- d-flex -->
        <div class="d-flex align-items-center property-title-price-wrap">
            <?php get_template_part('property-details/partials/title'); ?>
            <?php get_template_part('property-details/partials/item-price'); ?>
        </div><!-- d-flex -->
        <div class="property-labels-wrap">
        <?php 
        if( $top_area != 'v2' ) {
            get_template_part('property-details/partials/item-labels'); 
        }
        ?>
        </div>
        <?php get_template_part('property-details/partials/item-address'); ?>
    </div><!-- container -->
</div><!-- page-title-wrap -->