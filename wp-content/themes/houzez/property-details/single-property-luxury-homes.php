<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 27/09/16
 * Time: 4:49 PM
 * Since v1.4.0
 */
global $post, $top_area, $map_street_view;

$layout = houzez_option('property_blocks_luxuryhomes');
$layout = $layout['enabled'];

if ($layout): foreach ($layout as $key=>$value) {

    switch($key) {


        case 'unit':
            get_template_part('property-details/luxury-homes/sub-listing-main');
            break;

        case 'description':
            get_template_part('property-details/luxury-homes/description-detail'); 
            break;

        case 'features':
            get_template_part('property-details/luxury-homes/features');
            break;

        case 'address':
            get_template_part('property-details/luxury-homes/address');
            break;
            
        case 'gallery':
            get_template_part('property-details/luxury-homes/gallery');
            break; 

        case 'floor_plans':
            get_template_part('property-details/luxury-homes/floor-plans');
            break;

        case 'video':
            get_template_part('property-details/luxury-homes/video');
            break;   

        case 'mortgage_calculator':

            if( houzez_hide_calculator() ) {
                get_template_part('property-details/luxury-homes/mortgage-calculator');
            }
            break;

        case 'agent_form':
            get_template_part('property-details/luxury-homes/agent');
            break;

        case 'review':
            get_template_part('property-details/reviews');
            break;

        case 'similar_properties':
            get_template_part('property-details/similar-properties');
            break;

        case 'energy_class':
            get_template_part('property-details/luxury-homes/energy-class');
            break;

        case 'virtual_tour':
            get_template_part('property-details/luxury-homes/virtual-tour');
            break;

        case 'walkscore':
            get_template_part('property-details/luxury-homes/walkscore');
            break;

        case 'yelp_nearby':
            get_template_part('property-details/luxury-homes/yelp-nearby');
            break;

        case 'schedule_tour':
            get_template_part('property-details/luxury-homes/schedule-a-tour');
            break;

        case 'booking_calendar':
            get_template_part('property-details/luxury-homes/availability-calendar');
            break;
    
        case 'adsense_space_1':
            get_template_part( 'property-details/adsense-space-1' );
            break;
        case 'adsense_space_2':
            get_template_part( 'property-details/adsense-space-2' );
            break;
        case 'adsense_space_3':
            get_template_part( 'property-details/adsense-space-3' );
            break;
    }
}
endif;

?>
