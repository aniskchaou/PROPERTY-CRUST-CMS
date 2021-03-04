<?php 
global $sorting_settings, $settings; 
$section_title = isset($settings['section_title']) && !empty($settings['section_title']) ? $settings['section_title'] : houzez_option('sps_address', 'Address');
?>
<div class="property-address-wrap property-section-wrap" id="property-address-wrap">
    <div class="block-wrap">

        <?php if( $settings['section_header'] ) { ?>
        <div class="block-title-wrap d-flex justify-content-between align-items-center">
            <h2><?php echo $section_title; ?></h2>
        </div><!-- block-title-wrap -->
        <?php } ?>

        <div class="block-content-wrap">
            <?php

            if( !empty($sorting_settings) ) {
                $address_data = explode(',', $sorting_settings);        

                echo '<ul class="'.$settings['data_columns'].' list-unstyled">';

                foreach ($address_data as $key) {

                    if( $key == 'property_address' ) {
                        htf_get_template_part('elementor/template-part/single-property/partials/address');

                    } elseif( $key == 'property_zip' ) {
                        htf_get_template_part('elementor/template-part/single-property/partials/zip');

                    } elseif ( $key == 'property_country' ) {
                        htf_get_template_part('elementor/template-part/single-property/partials/country');

                    } elseif ( $key == 'property_state' ) {
                        htf_get_template_part('elementor/template-part/single-property/partials/state');

                    } elseif ( $key == 'property_city' ) {
                        htf_get_template_part('elementor/template-part/single-property/partials/city');

                    } elseif ( $key == 'property_area' ) {
                        htf_get_template_part('elementor/template-part/single-property/partials/area');
                    }
                    
                }

                echo '</ul>';

            } else {

                echo '<ul class="'.$settings['data_columns'].' list-unstyled">';

                htf_get_template_part('elementor/template-part/single-property/partials/address');
                htf_get_template_part('elementor/template-part/single-property/partials/zip');
                htf_get_template_part('elementor/template-part/single-property/partials/country');
                htf_get_template_part('elementor/template-part/single-property/partials/state');
                htf_get_template_part('elementor/template-part/single-property/partials/city');
                htf_get_template_part('elementor/template-part/single-property/partials/area');
                    
                echo '</ul>';

            }
            ?>
               
        </div><!-- block-content-wrap -->

    </div><!-- block-wrap -->
</div><!-- property-address-wrap -->