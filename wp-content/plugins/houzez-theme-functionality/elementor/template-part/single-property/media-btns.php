<?php global $settings, $map_street_view; ?>
<ul class="nav nav-pills" id="pills-tab" role="tablist">
                        
    <?php if( $settings['btn_gallery'] ) { ?>
    <li class="nav-item">
        <a class="nav-link active" id="pills-gallery-tab" data-toggle="pill" href="#pills-gallery" role="tab" aria-controls="pills-gallery" aria-selected="true">
            <i class="houzez-icon icon-picture-sun"></i>
        </a>
    </li>
    <?php } ?>

    <?php if( houzez_get_listing_data('property_map') ) { ?>
        
        <?php if( $settings['btn_map'] ) { ?>
        <li class="nav-item">
            <a class="nav-link" id="pills-map-tab" data-toggle="pill" href="#pills-map" role="tab" aria-controls="pills-map" aria-selected="true">
                <i class="houzez-icon icon-maps"></i>
            </a>
        </li>
        <?php } ?>

        <?php if( houzez_get_map_system() == 'google' && $map_street_view != 'hide' && $settings['btn_street'] ) { ?>
        <li class="nav-item">
            <a class="nav-link" id="pills-street-view-tab" data-toggle="pill" href="#pills-street-view" role="tab" aria-controls="pills-street-view" aria-selected="false">
                <i class="houzez-icon icon-location-user"></i>
            </a>
        </li>
        <?php } ?>
    <?php } ?>
</ul>