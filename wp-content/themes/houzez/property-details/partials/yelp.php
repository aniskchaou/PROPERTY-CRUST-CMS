<?php
global $post;

$post_id = $post->ID;

$houzez_yelp_api_key = houzez_option('houzez_yelp_api_key');

$allowed_html_array = array(
    'i' => array(
        'class' => array()
    ),
    'span' => array(
        'class' => array()
    ),
    'a' => array(
        'href' => array(),
        'title' => array(),
        'target' => array()
    )
);

$yelp_categories = array (
    'active' => array( 'name' => esc_html__( 'Active Life', 'houzez' ), 'icon' => 'fa fa-bicycle' ),
    'arts' => array( 'name' => esc_html__( 'Arts & Entertainment', 'houzez' ), 'icon' => 'fas fa-image' ),
    'auto' => array( 'name' => esc_html__( 'Automotive', 'houzez' ), 'icon' => 'fa fa-car' ),
    'beautysvc' => array( 'name' => esc_html__( 'Beauty & Spas', 'houzez' ), 'icon' => 'fa fa-cutlery' ),
    'education' => array( 'name' => esc_html__( 'Education', 'houzez' ), 'icon' => 'fa fa-graduation-cap' ),
    'eventservices' => array( 'name' => esc_html__( 'Event Planning & Services', 'houzez' ), 'icon' => 'fa fa-birthday-cake' ),
    'financialservices' => array( 'name' => esc_html__( 'Financial Services', 'houzez' ), 'icon' => 'far fa-money-bill-alt' ),
    'food' => array( 'name' => esc_html__( 'Food', 'houzez' ), 'icon' => 'fa fa-shopping-basket' ),
    'health' => array( 'name' => esc_html__( 'Health & Medical', 'houzez' ), 'icon' => 'fa fa-medkit' ),
    'homeservices' => array( 'name' => esc_html__( 'Home Services ', 'houzez' ), 'icon' => 'fa fa-wrench' ),
    'hotelstravel' => array( 'name' => esc_html__( 'Hotels & Travel', 'houzez' ), 'icon' => 'fa fa-bed' ),
    'localflavor' => array( 'name' => esc_html__( 'Local Flavor', 'houzez' ), 'icon' => 'fa fa-coffee' ),
    'localservices' => array( 'name' => esc_html__( 'Local Services', 'houzez' ), 'icon' => 'fa fa-dot-circle-o' ),
    'massmedia' => array( 'name' => esc_html__( 'Mass Media', 'houzez' ), 'icon' => 'fa fa-television' ),
    'nightlife' => array( 'name' => esc_html__( 'Nightlife', 'houzez' ), 'icon' => 'fas fa-glass-martini-alt' ),
    'pets' => array( 'name' => esc_html__( 'Pets', 'houzez' ), 'icon' => 'fa fa-paw' ),
    'professional' => array( 'name' => esc_html__( 'Professional Services', 'houzez' ), 'icon' => 'fa fa-suitcase' ),
    'publicservicesgovt' => array( 'name' => esc_html__( 'Public Services & Government', 'houzez' ), 'icon' => 'fa fa-university' ),
    'realestate' => array( 'name' => esc_html__( 'Real Estate', 'houzez' ), 'icon' => 'fa fa-building' ),
    'religiousorgs' => array( 'name' => esc_html__( 'Religious Organizations', 'houzez' ), 'icon' => 'fa fa-universal-access' ),
    'restaurants' => array( 'name' => esc_html__( 'Restaurants', 'houzez' ), 'icon' => 'fas fa-utensils' ),
    'shopping' => array( 'name' => esc_html__( 'Shopping', 'houzez' ), 'icon' => 'fa fa-shopping-bag' ),
    'transport' =>  array( 'name' => esc_html__( 'Transportation', 'houzez' ), 'icon' => 'fa fa-bus' )
);

$yelp_data = houzez_option( 'houzez_yelp_term' );
$yelp_dist_unit = houzez_option( 'houzez_yelp_dist_unit' );
$prop_location = get_post_meta( get_the_ID(), 'fave_property_location', true );
$prop_location = explode( ',', $prop_location );
$prop_location = $prop_location[0].','.$prop_location[1];


$dist_unit = 1.1515;
$unit_text = 'mi';
if ( $yelp_dist_unit == 'kilometers' ) {
    $dist_unit = 1.609344;
    $unit_text = 'km';
}
?>
<div class="what-nearby">
	<?php
    $link = site_url('wp-admin/admin.php?page=houzez_options&tab=30');
    if( empty( $houzez_yelp_api_key ) ) {
        echo '<div class="yelp-cat-block">';
        echo esc_html__('Please supply your API key', 'houzez').' ';
        echo '<a target="_blank" href="'.$link.'">'.esc_html__('Click Here', 'houzez').'</a>';
        echo '</div>';
    } else {

        foreach ( $yelp_data as $value ) :

            $term_id = $value;
            $term_name = $yelp_categories[ $term_id ]['name'];
            $term_icon = $yelp_categories[ $term_id ]['icon'];
            
            $response = houzez_yelp_query_api( $term_id, $prop_location );

            // Check for yelp api error
            if ( isset( $response->error ) ) {
                $output = '';
                $error = '';
                if ( ! empty( $response->error->code ) ) {
                    $error .= $response->error->code . ': ';
                }
                if ( ! empty( $response->error->description ) ) {
                    $error .= $response->error->description;
                }
                $output .= '<div class="yelp-api-error">' . esc_html( $error ) . '</div>';

            } else {

                if ( isset( $response->businesses ) ) {
                    $businesses = $response->businesses;
                } else {
                    $businesses = array( $response );
                }

                if ( ! count( $businesses ) ) {
                    continue;
                }

                $distance = false;
                $current_lat = '';
                $current_lng = '';

                if ( isset( $response->region->center ) ) {

                    $current_lat = $response->region->center->latitude;
                    $current_lng = $response->region->center->longitude;
                    $distance = true;

                }

                if ( sizeof( $businesses ) != 0 ) {
    			?>

    			<dl>
    				<dt><i class="<?php echo esc_attr($term_icon); ?>"></i> <?php echo esc_attr($term_name); ?></dt>

    				<?php
                    foreach ( $businesses as $data ) :

                    $location_distance = '';

                    if ( $distance && isset( $data->coordinates ) ) {

                        $location_lat = $data->coordinates->latitude;
                        $location_lng = $data->coordinates->longitude;
                        $theta = $current_lng - $location_lng;
                        $dist = sin( deg2rad( $current_lat ) ) * sin( deg2rad( $location_lat ) ) +  cos( deg2rad( $current_lat ) ) * cos( deg2rad( $location_lat ) ) * cos( deg2rad( $theta ) );
                        $dist = acos( $dist );
                        $dist = rad2deg( $dist );
                        $miles = $dist * 60 * $dist_unit;

                        $location_distance = '<span class="time-review"> (' . round( $miles, 2 ) . ' ' . $unit_text . ') </span>';

                    }
                    ?>
    				<dd>
    					<div class="what-nearby-left">
    						<?php echo esc_attr($data->name); ?> <?php echo $location_distance; ?>
    					</div>
    					<div class="what-nearby-right">
    						<div class="rating-wrap">
    							<div class="rating-container">
    								<div class="rating">                                            
    									<?php echo houzez_get_stars($data->rating); ?>

    									<span class="time-review"><?php echo $data->review_count; ?> <?php esc_html_e('reviews', 'houzez');?></span>
    								</div>
    							</div>
    						</div>
    					</div>
    				</dd>
    				<?php endforeach; ?>
    				
    			</dl>

    			<?php
                } //sizeof( $businesses )
            } // end error else

        endforeach;
    } //houzez_yelp_api_key
    ?>
</div>