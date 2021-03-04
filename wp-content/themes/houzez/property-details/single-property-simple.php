<?php 
global $post, $top_area, $map_street_view;

$layout = houzez_option('property_blocks');
$layout = $layout['enabled'];

if ($layout): foreach ($layout as $key=>$value) {

    switch($key) {

        case 'overview':
            if($top_area != 'v6') {
			    get_template_part('property-details/overview'); 
			}
            break;

        case 'unit':
            get_template_part('property-details/sub-listing-main');
            break;

        case 'description':
            get_template_part('property-details/description'); 
            break;

        case 'energy_class':
            get_template_part('property-details/energy');
            break;

        case 'address':
            get_template_part('property-details/address');
            break;

        case 'details':
            get_template_part('property-details/detail');
            break;

        case 'features':
            get_template_part('property-details/features');
            break;

        case 'floor_plans':
            get_template_part('property-details/floor-plans');
            break;

        case 'video':
            get_template_part('property-details/video');
            break;

        case 'virtual_tour':
            get_template_part('property-details/virtual-tour');
            break;

        case 'walkscore':
            get_template_part('property-details/walkscore');
            break;

        case 'block_gallery':
            get_template_part('property-details/block', 'gallery');
            break;

        case 'yelp_nearby':
            get_template_part('property-details/yelp-nearby');
            break;

        case 'agent_bottom':
            get_template_part('property-details/agent-form-bottom');
            break;

        case 'schedule_tour':
            get_template_part('property-details/schedule-a-tour');
            break;

        case 'booking_calendar':
            get_template_part('property-details/availability-calendar');
            break;

        case 'mortgage_calculator':

            if( houzez_hide_calculator() ) {
                get_template_part('property-details/mortgage-calculator');
            }
            break;

        case 'similar_properties':
            get_template_part('property-details/similar-properties');
            break;

        case 'review':
            get_template_part('property-details/reviews');
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