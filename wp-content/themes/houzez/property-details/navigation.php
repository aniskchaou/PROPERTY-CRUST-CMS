<?php
global $post, $top_area, $property_layout;
$prop_video_url = houzez_get_listing_data('video_url');
$virtual_tour = houzez_get_listing_data('virtual_tour');
$layout = houzez_option('property_blocks');
$houzez_walkscore = houzez_option('houzez_walkscore');
$houzez_walkscore_api = houzez_option('houzez_walkscore_api');
$hide_yelp = houzez_option('houzez_yelp');
$agent_display_option = get_post_meta( $post->ID, 'fave_agent_display_option', true );
$enableDisable_agent_forms = houzez_option('agent_forms');
$prop_detail_nav = houzez_option('prop-detail-nav');
$similer_properties = houzez_option('houzez_similer_properties', 1);
$floor_plans = get_post_meta( $post->ID, 'floor_plans', true );

if( $property_layout == 'v2') {
    $layout = houzez_option('property_blocks_luxuryhomes');
}

$layout = $layout['enabled'];
if( isset( $_GET['prop_nav'] ) ) {
    $prop_detail_nav = $_GET['prop_nav'];
}

if( $prop_detail_nav != 'no' && ( $property_layout == "simple" || $property_layout == 'v2' ) ) {
?>
<div class="property-navigation-wrap">
	<div class="container-fluid">
		<ul class="property-navigation list-unstyled d-flex justify-content-between">
			<li class="property-navigation-item">
				<a class="back-top" href="#main-wrap">
					<i class="houzez-icon icon-arrow-button-circle-up"></i>
				</a>
			</li>
			<?php
            if ($layout): foreach ($layout as $key=>$value) {

                switch($key) {

                    case 'unit':

                        $multi_units  = houzez_get_listing_data('multi_units');
                        if( isset($multi_units[0]['fave_mu_title']) && !empty( $multi_units[0]['fave_mu_title'] ) ) {
                        echo '<li class="property-navigation-item">
							<a class="target" href="#property-sub-listings-wrap">' . houzez_option('sps_sub_listings', 'Sub Listings') . '</a>
						</li>';
                        }
                        break;

                    case 'description':
                        
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-description-wrap">' . houzez_option('sps_description', 'Description') . '</a>
							</li>';
                        break;


                    case 'address':
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-address-wrap">'.houzez_option('sps_address', 'Address').'</a>
							</li>';
                        break;

                    case 'details':
                        
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-detail-wrap">' . houzez_option('sps_details', 'Details') . '</a>
							</li>';
                        break;

                    case 'energy_class':
                        
                        $energy_class = houzez_get_listing_data('energy_class');
                        if(!empty($energy_class)) {
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-energy-class-wrap">' . houzez_option('sps_energy_class', 'Energy Class') . '</a>
							</li>';
                        }
                        break;

                    case 'features':
                        
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-features-wrap">' . houzez_option('sps_features', 'Features') . '</a>
							</li>';
                        break;

                    case 'floor_plans':
                        
                        if( isset($floor_plans[0]['fave_plan_title']) && !empty( $floor_plans[0]['fave_plan_title'] ) ) {
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-floor-plans-wrap">'.houzez_option('sps_floor_plans', 'Floor Plans').'</a>
							</li>';
                        }
                        break;

                    case 'video':
                        if( !empty( $prop_video_url )) {
                        	echo '<li class="property-navigation-item">
								<a class="target" href="#property-video-wrap">' . houzez_option('sps_video', 'Video') . '</a>
							</li>';
                        }
                        
                        break;

                    case 'virtual_tour':
                        if(!empty($virtual_tour)) {
                            echo '<li class="property-navigation-item">
								<a class="target" href="#property-virtual-tour-wrap">' . houzez_option('sps_virtual_tour', '360° Virtual Tour') . '</a>
							</li>';
                        }
                        
                        break;

                    case 'walkscore':
                        if( $houzez_walkscore != 0 && $houzez_walkscore_api != '' ) {
                            echo '<li class="property-navigation-item">
								<a class="target" href="#property-walkscore-wrap">' . houzez_option('sps_walkscore', 'WalkScore') . '</a>
							</li>';
                        }
                        break;

                    case 'yelp_nearby':
                        if( $hide_yelp ) {
                            echo "<li class='property-navigation-item'>
								<a class='target' href='#property-nearby-wrap'>".houzez_option('sps_nearby', "What's Nearby?")."</a>
							</li>";
                        }
                        break;

                    case 'schedule_tour':
                        
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-schedule-tour-wrap">' . houzez_option('sps_schedule_tour', 'Schedule a Tour') . '</a>
							</li>';
                        break;

                    case 'mortgage_calculator':
                        
                        if( houzez_hide_calculator() ) {
                        echo '<li class="property-navigation-item">
                                <a class="target" href="#property-mortgage-calculator-wrap">' . houzez_option('sps_calculator', 'Mortgage Calculator') . '</a>
                            </li>';
                        }
                        break;

                    case 'agent_bottom':
                        if( $enableDisable_agent_forms != 0 && $agent_display_option != 'none') {
                            echo '<li class="property-navigation-item">
								<a class="target" href="#property-contact-agent-wrap">' . houzez_option('sps_contact', 'Contact') . '</a>
							</li>';
                        }
                        
                        break;

                    case 'review':
                        
                        echo '<li class="property-navigation-item">
								<a class="target" href="#property-review-wrap">' . houzez_option('sps_reviews', 'Reviews') . '</a>
							</li>';
                        break;

                    case 'similar_properties':
                        
                        if( $similer_properties ) {
                        echo '<li class="property-navigation-item">
                                <a class="target" href="#similar-listings-wrap">' . houzez_option('sps_similar_listings', 'Similar Listings') . '</a>
                            </li>';
                        }
                        break;

                }

            }

            endif;
            ?>
			
		</ul>
	</div><!-- container -->
</div><!-- property-navigation-wrap -->
<?php } ?>