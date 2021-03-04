<?php
if( !function_exists('houzez_get_localization')) {
	function houzez_get_localization() {


		$localization = array(

			/*------------------------------------------------------
			* Theme
			*------------------------------------------------------*/
			'choose_currency' 			=> esc_html__( 'Choose Currency', 'houzez' ),
			'disable' 			=> esc_html__( 'Disable', 'houzez' ),
			'enable' 			=> esc_html__( 'Enable', 'houzez' ),
			'any' 				=> esc_html__( 'Any', 'houzez' ),
			'none'				=> esc_html__( 'None', 'houzez' ),
			'by_text' 			=> esc_html__( 'by', 'houzez' ),
			'at_text' 			=> esc_html__( 'at', 'houzez' ),
			'goto_dash' 		=> esc_html__( 'Go to Dashboard', 'houzez' ),
			'read_more' 		=> esc_html__( 'Read More', 'houzez' ),
			'continue_reading' 	=> esc_html__( 'Continue reading', 'houzez' ),
			'follow_us' 		=> esc_html__( 'Follow us', 'houzez' ),
			'property' 			=> esc_html__( 'Property', 'houzez' ),
			'properties' 		=> esc_html__( 'Properties', 'houzez' ),
			'404_page' 			=> esc_html__( 'Back to Homepage', 'houzez' ),
			'at' 				=> esc_html__( 'at', 'houzez' ),
			'licenses' 			=> esc_html__( 'License', 'houzez' ),
			'agent_license' 	=> esc_html__( 'Agent License', 'houzez' ),
			'tax_number' 		=> esc_html__( 'Tax Number', 'houzez' ),
			'languages' 		=> esc_html__( 'Language', 'houzez' ),
			'specialties_label' => esc_html__( 'Specialties', 'houzez' ),
			'service_area' 		=> esc_html__( 'Service Areas', 'houzez' ),
			'agency_agents' 	=> esc_html__( 'Agents:', 'houzez' ),
			'agency_properties' => esc_html__( 'Properties listed', 'houzez' ),
			'email' 			=> esc_html__( 'Email', 'houzez' ),
			'website' 			=> esc_html__( 'Website', 'houzez' ),
			'submit' 			=> esc_html__( 'Submit', 'houzez' ),
			'join_discussion' 	=> esc_html__( 'Join The Discussion', 'houzez' ),
			'your_name'	 		=> esc_html__( 'Your Name', 'houzez' ),
			'your_email'	 	=> esc_html__( 'Your Email', 'houzez' ),
			'blog_search'	 	=> esc_html__( 'Search', 'houzez' ),
			'featured'	 		=> esc_html__( 'Featured', 'houzez' ),
			'label_featured'	=> esc_html__( 'Featured', 'houzez' ),
			'view_my_prop'	 	=> esc_html__( 'View Listings', 'houzez' ),
			'office_colon'	 	=> esc_html__( 'Office', 'houzez' ),
			'mobile_colon'	 	=> esc_html__( 'Mobile', 'houzez' ),
			'fax_colon'	 	    => esc_html__( 'Fax', 'houzez' ),
			'email_colon'	 	=> esc_html__( 'Email', 'houzez' ),
			'follow_us'	 		=> esc_html__( 'Follow us', 'houzez' ),
			'type'		 		=> esc_html__( 'Type', 'houzez' ),
			'address'		 	=> esc_html__( 'Address', 'houzez' ),
			'city'		 		=> esc_html__( 'City', 'houzez' ),
			'state_county'      => esc_html__( 'State/County', 'houzez' ),
			'zip_post'		    => esc_html__( 'Zip/Post Code', 'houzez' ),
			'country'		    => esc_html__( 'Country', 'houzez' ),
			'prop_size'		    => esc_html__( 'Property Size', 'houzez' ),
			'prop_id'		    => esc_html__( 'Property ID', 'houzez' ),
			'garage'		    => esc_html__( 'Garage', 'houzez' ),
			'garage_size'		=> esc_html__( 'Garage Size', 'houzez' ),
			'year_built'		=> esc_html__( 'Year Built', 'houzez' ),
			'time_period'		=> esc_html__( 'Time Period', 'houzez' ),
			'unlimited_listings'=> esc_html__( 'Unlimited Listings', 'houzez' ),
			'featured_listings' => esc_html__( 'Featured Listings', 'houzez' ),
			'package_taxes' 	=> esc_html__( 'Tax', 'houzez' ),
			'get_started' 		=> esc_html__( 'Get Started', 'houzez' ),
			'save_search'	 	=> esc_html__( 'Save this Search?', 'houzez' ),
			'sort_by'		 	=> esc_html__( 'Sort by:', 'houzez' ),
			'default_order'	    => esc_html__( 'Default Order', 'houzez' ),
			'price_low_high'	=> esc_html__( 'Price (Low to High)', 'houzez' ),
			'price_high_low'	=> esc_html__( 'Price (High to Low)', 'houzez' ),
			'date_old_new'		=> esc_html__( 'Date Old to New', 'houzez' ),
			'date_new_old'		=> esc_html__( 'Date New to Old', 'houzez' ),
			'bank_transfer'		=> esc_html__( 'Direct Bank Transfer', 'houzez' ),
			'order_number'		=> esc_html__( 'Order Number', 'houzez' ),
			'payment_method' 	=> esc_html__( 'Payment Method', 'houzez' ),
			'date'				=> esc_html__( 'Date', 'houzez' ),
			'total'				=> esc_html__( 'Total', 'houzez' ),
			'submit'			=> esc_html__( 'Submit', 'houzez' ),
			'search_listing'	=> esc_html__( 'Search Listing', 'houzez' ),


			'view_all_results'	=> esc_html__( 'View All Results', 'houzez' ),
			'listins_found'		=> esc_html__( 'Listings found', 'houzez' ),
			'auto_result_not_found'		=> esc_html__( 'We didn’t find any results', 'houzez' ),
			'auto_view_lists'		=> esc_html__( 'View Listing', 'houzez' ),
			'auto_listings'		=> esc_html__( 'Listing', 'houzez' ),
			'auto_city'		=> esc_html__( 'City', 'houzez' ),
			'auto_area'		=> esc_html__( 'Area', 'houzez' ),
			'auto_state'		=> esc_html__( 'State', 'houzez' ),


			'search_invoices'	=> esc_html__( 'Search Invoices', 'houzez' ),
			'total_invoices'	=> esc_html__( 'Total Invoices:', 'houzez' ),
			'start_date'		=> esc_html__( 'Start date', 'houzez' ),
			'end_date'			=> esc_html__( 'End date', 'houzez' ),
			'invoice_type'		=> esc_html__( 'Type', 'houzez' ),
			'invoice_listing'	=> esc_html__( 'Listing', 'houzez' ),
			'invoice_package'	=> esc_html__( 'Package', 'houzez' ),
			'invoice_feat_list'		=> esc_html__( 'Listing with Featured', 'houzez' ),
			'invoice_upgrade_list'	=> esc_html__( 'Upgrade to Featured', 'houzez' ),
			'invoice_status'	=> esc_html__( 'Status', 'houzez' ),
			'paid'				=> esc_html__( 'Paid', 'houzez' ),
			'not_paid'			=> esc_html__( 'Not Paid', 'houzez' ),
			'order'				=> esc_html__( 'Order', 'houzez' ),
			'view_details'		=> esc_html__( 'View Details', 'houzez' ),
			'payment_details'	=> esc_html__( 'Payment details', 'houzez' ),
			'property_title'	=> esc_html__( 'Property Title', 'houzez' ),
			'billing_type'		=> esc_html__( 'Billing Type', 'houzez' ),
			'billing_for'		=> esc_html__( 'Billing For', 'houzez' ),
			'invoice_price'		=> esc_html__( 'Total Price:', 'houzez' ),
			'customer_details'	=> esc_html__( 'Customer details:', 'houzez' ),
			'customer_name'		=> esc_html__( 'Name:', 'houzez' ),
			'customer_email'	=> esc_html__( 'Email:', 'houzez' ),
			'search_agency_name'	=> esc_html__( 'Enter agency name', 'houzez' ),
			'search_agent_name'	=> esc_html__( 'Enter agent name', 'houzez' ),
			'search_agent_btn'	=> esc_html__( 'Search Agent', 'houzez' ),
			'search_agency_btn'	=> esc_html__( 'Search Agency', 'houzez' ),
			'all_agent_cats'	=> esc_html__( 'All Categories', 'houzez' ),
			'all_agent_cities'	=> esc_html__( 'All Cities', 'houzez' ),


			'saved_search_not_found'=> esc_html__( 'You don\'t have any saved search', 'houzez' ),
			'properties_not_found'=> esc_html__( 'You don\'t have any properties yet!', 'houzez' ),
			'favorite_not_found'=> esc_html__( 'You don\'t have any favorite properties yet!', 'houzez' ),
			'email_already_registerd' => esc_html__( 'This email address is already registered', 'houzez' ),
			'invalid_email' => esc_html__( 'Invalid email address.', 'houzez' ),
			'houzez_plugin_required' => esc_html__( 'Please install and activate Houzez theme functionality plugin', 'houzez' ),

			// Agents
			'view_profile' => esc_html__( 'View Profile', 'houzez' ),

			/*------------------------------------------------------
			* Common
			*------------------------------------------------------*/
			'next_text' => esc_html__('Next', 'houzez'),
			'prev_text' => esc_html__('Prev', 'houzez'),
			'view_label' => esc_html__('View', 'houzez'),
			'views_label' => esc_html__('Views', 'houzez'),
			'visits_label' => esc_html__('Visits', 'houzez'),
			'unique_label' => esc_html__('Unique', 'houzez'),

			/*------------------------------------------------------
			* Custom Post Types
			*------------------------------------------------------*/


		);

		return $localization;
	}
}
