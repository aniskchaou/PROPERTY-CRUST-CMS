<?php global $settings; ?>
<div class="page-title-wrap">
    <div class="d-flex align-items-center">
        
        <div class="breadcrumb-wrap">
            <?php if( $settings['show_breadcrumb'] ) { ?>
                <nav><?php houzez_breadcrumbs(); ?></nav>
            <?php } ?>
        </div>
        
        <?php 

        if( $settings['hide_favorite'] != 'none' || $settings['hide_social'] != 'none' || $settings['hide_print'] != 'none'  ) {
            get_template_part('property-details/partials/tools'); 
        }?> 
    </div><!-- d-flex -->
    <div class="d-flex align-items-center property-title-price-wrap">
        <?php 
        if( $settings['show_title'] ) {
            get_template_part('property-details/partials/title'); 
        }

        if( $settings['show_price'] ) {
            get_template_part('property-details/partials/item-price'); 
        }
        ?>
    </div><!-- d-flex -->

    <?php if( $settings['show_labels'] ) { ?>
    <div class="property-labels-wrap">
        <?php get_template_part('property-details/partials/item-labels'); ?>
    </div>
    <?php } ?>

    <?php 
    if( $settings['show_address'] ) {
        $temp_array = array();

            echo '<address class="item-address"><i class="houzez-icon icon-pin mr-1"></i>';
            foreach ( $settings['address_fields'] as $item_index => $item ) :
                
                $key = $item['field_type'];
                
                if( $key == 'address' ) {
                    $temp_array[] = houzez_get_listing_data('property_map_address');

                } else if( $key == 'streat-address' ) {
                    $temp_array[] = houzez_get_listing_data('property_address');

                } else if( $key == 'country' ) {
                    $temp_array[] = houzez_taxonomy_simple('property_country');

                } else if( $key == 'state' ) {
                    $temp_array[] = houzez_taxonomy_simple('property_state');

                } else if( $key == 'city' ) {
                    $temp_array[] = houzez_taxonomy_simple('property_city');

                } else if( $key == 'area' ) {
                    $temp_array[] = houzez_taxonomy_simple('property_area');

                }
                
            endforeach;

            if( !empty($temp_array)) {
                $result = join( ", ", $temp_array );
                echo $result;
            }

            echo '</address>'; 
    }?>
</div><!-- page-title-wrap -->