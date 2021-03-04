<?php
/*
  Plugin Name: Houzez Visual Composer Extensions
  Plugin URI: http://themeforest.net/user/favethemes
  Description: Extensions to Visual Composer for the Houzez theme.
  Version: 1.0
  Author: Favethemes
  Author URI: http://themeforest.net/user/favethemes
  License: GPLv2 or later
 */

// don't load directly
if ( !defined( 'ABSPATH' ) )
    die( '-1' );


if (class_exists('Vc_Manager')) {

	$allowed_html_array = array(
		'a' => array(
			'href' => array(),
			'title' => array(),
			'target' => array()
		)
	);

	/*** Remove unused parameters ***/
	if (function_exists('vc_remove_param')) {
		$houzez_grids_tax = array();
		vc_remove_param('vc_row', 'font_color');
			
		$houzez_grids_tax['Property Types'] = 'property_type';
		$houzez_grids_tax['Property Status'] = 'property_status';
		$houzez_grids_tax['Property Label'] = 'property_label';
		$houzez_grids_tax['Property State'] = 'property_state';
		$houzez_grids_tax['Property City'] = 'property_city';
		$houzez_grids_tax['Property Area'] = 'property_area';
	}

	$fontawesomeIcons = array(
		"fa-adn"                => "fa fa-adn",
		"fa-android"            => "fa-Android",
		"fa-apple"              => "fa-Apple",
		"fa-behance"            => "fa-Behance",
		"fa-bitbucket"          => "fa-Bitbucket",
		"fa-bitbucket-sign"     => "fa-Bitbucket-Sign",
		"fa-bitcoin"            => "fa-Bitcoin",
		"fa-btc"                => "fa-BTC",
		"fa-css3"               => "fa-CSS3",
		"fa-codepen"            => "fa-Codepen",
		"fa-digg"            	=> "fa-Digg",
		"fa-drupal"            	=> "fa-Drupal",
		"fa-dribbble"           => "fa-Dribbble",
		"fa-dropbox"            => "fa-Dropbox",
		"fa-envelope"           => "fa-E-mail",
		"fa-facebook"           => "fa-Facebook",
		"fa-facebook-sign"      => "fa-Facebook-Sign",
		"fa-flickr"             => "fa-Flickr",
		"fa-foursquare"         => "fa-Foursquare",
		"fa-github"             => "fa-GitHub",
		"fa-github-alt"         => "fa-GitHub-Alt",
		"fa-github-sign"        => "fa-GitHub-Sign",
		"fa-gittip"             => "fa-Gittip",
		"fa-google"             => "fa-Google",
		"fa-google-plus"        => "fa-Google Plus",
		"fa-google-plus-sign"   => "fa-Google Plus-Sign",
		"fa-html5"              => "fa-HTML5",
		"fa-instagram"          => "fa-Instagram",
		"fa-linkedin"           => "fa-LinkedIn",
		"fa-linkedin-sign"      => "fa-LinkedIn-Sign",
		"fa-linux"              => "fa-Linux",
		"fa-maxcdn"             => "fa-MaxCDN",
		"fa-paypal"             => "fa-Paypal",
		"fa-pinterest"          => "fa-Pinterest",
		"fa-pinterest-sign"     => "fa-Pinterest-Sign",
		"fa-reddit"     		=> "fa-Reddit",
		"fa-renren"             => "fa-Renren",
		"fa-skype"              => "fa-Skype",
		"fa-stackexchange"      => "fa-StackExchange",
		"fa-soundcloud"      	=> "fa-Soundcloud",
		"fa-spotify"      		=> "fa-Spotify",
		"fa-trello"             => "fa-Trello",
		"fa-tumblr"             => "fa-Tumblr",
		"fa-tumblr-sign"        => "fa-Tumblr-Sign",
		"fa-twitter"            => "fa-Twitter",
		"fa-twitter-sign"       => "fa-Twitter-Sign",
		"fa-vimeo-square"       => "fa-Vimeo-Square",
		"fa-vk"                 => "fa-VK",
		"fa-weibo"              => "fa-Weibo",
		"fa-windows"            => "fa-Windows",
		"fa-xing"               => "fa-Xing",
		"fa-xing-sign"          => "Xing-Sign",
		"fa-yahoo"          	=> "Yahoo",
		"fa-youtube"            => "YouTube",
		"fa-youtube-play"       => "YouTube Play",
		"fa-youtube-sign"       => "YouTube-Sign"
	);

	$of_categories 			= array();
	$of_categories_obj 		= get_categories( array( 'hide_empty' => 1, 'hierarchical' => true ) );

	foreach ( $of_categories_obj as $of_category ) {
	    $of_categories[$of_category->name] = $of_category->term_id; 
	}
	$categories_buffer['- All categories -'] = '';

	$of_categories = array_merge(
            $categories_buffer,
            $of_categories
        );
	//$of_categories_tmp 		= array_unshift($of_categories, "All");

	$of_tags 			= array();
	$of_tags_obj 		= get_tags( array( 'hide_empty' => 1 ) );

	foreach ( $of_tags_obj as $of_tag ) {
	    $of_tags[$of_tag->name] = $of_tag->term_id; 
	}

	$sort_by = array( 
		esc_html__('Default', 'houzez') => '', 
		esc_html__('Price (Low to High)', 'houzez') => 'a_price', 
		esc_html__('Price (High to Low)', 'houzez') => 'd_price',
		esc_html__('Date Old to New', 'houzez') => 'a_date',
		esc_html__('Date New to Old', 'houzez') => 'd_date',
		esc_html__('Featured on Top', 'houzez') => 'featured_top',
		esc_html__('Random', 'houzez') => 'random',
	);

	/*---------------------------------------------------------------------------------
		Section Title
	-----------------------------------------------------------------------------------*/
	vc_map( array(
		"name"	=>	esc_html__( "Section Title", "houzez" ),
		"description"			=> '',
		"base"					=> "hz-section-title",
		'category'				=> "By Favethemes",
		"class"					=> "",
		'admin_enqueue_js'		=> "",
		'admin_enqueue_css'		=> "",
		"icon" 					=> "icon-section-title",
		"params"				=> array(
			array(
				"param_name" => "hz_section_title",
				"type" => "textfield",
				"value" => '',
				"heading" => esc_html__("Title:", "houzez" ),
				"description" => esc_html__( "Enter section title", "houzez" ),
				"save_always" => true
			),
			array(
				"param_name" => "hz_section_subtitle",
				"type" => "textfield",
				"value" => '',
				"heading" => esc_html__("Sub Title:", "houzez" ),
				"description" => esc_html__( "Enter section sub title", "houzez" ),
				"save_always" => true
			),
			array(
				"param_name" => "hz_section_title_align",
				"type" => "dropdown",
				"value" => array( 'Center Align' => 'text-center', 'Left Align' => 'text-left', 'Right Align' => 'text-right' ),
				"heading" => esc_html__("Align:", "houzez" ),
				"save_always" => true
			),
		) // end params
	) );

	/*---------------------------------------------------------------------------------
		Space
	-----------------------------------------------------------------------------------*/
	vc_map( array(
		"name" => __("Empty Space", "houzez"),
		"icon" => "icon-wpb-ui-empty_space",
		"base" => "houzez-space",
		"description" => "Add space between elements, Also can be use for clear floating",
		"class" => "space_extended",
		"category" => __("By Favethemes", "houzez"),
		"params" => array(
			array(
				"type" => "textfield",
				"admin_label" => true,
				"heading" => __("Height of the space(px)", "houzez"),
				"param_name" => "height",
				"value" => 50,
				"description" => __("Set height of the space. You can add white space between elements to separate them beautifully.", "houzez")
			)
		)
	) );

	/*---------------------------------------------------------------------------------
		Section Search
	-----------------------------------------------------------------------------------*/
	vc_map( array(
		"name"	=>	esc_html__( "Advanced Search", "houzez" ),
		"description"			=> '',
		"base"					=> "hz-advance-search",
		'category'				=> "By Favethemes",
		"class"					=> "",
		'admin_enqueue_js'		=> "",
		'admin_enqueue_css'		=> "",
		"icon" 					=> "icon-advance-search",
		"params"				=> array(
			array(
				"param_name" => "search_title",
				"type" => "textfield",
				"value" => '',
				"heading" => esc_html__("Title:", "houzez" ),
				"description" => esc_html__( "Enter search title", "houzez" ),
				"save_always" => true
			)
		) // end params
	) );

	/*---------------------------------------------------------------------------------
	 Property cards v1
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Property Cards v1", "houzez"),
		"description" => '',
		"base" => "houzez_property_card_v1",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-properties",
		"params" => array(
			array(
				"param_name" => "module_type",
				"type" => "dropdown",
				"value" => array(' Grid 3 Columns ' => 'grid_3_cols', 'Grid 2 Columns' => 'grid_2_cols', 'list' => 'list'),
				"heading" => esc_html__("Layout:", "houzez"),
				"description" => '',
				"save_always" => true,
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				"param_name" => "houzez_user_role",
				"type" => "dropdown",
				"value" => array(
					esc_html__('All', 'houzez') => '',
					esc_html__('Owner', 'houzez') => 'houzez_owner',
					esc_html__('Manager', 'houzez') => 'houzez_manager',
					esc_html__('Agent', 'houzez') => 'houzez_agent',
					esc_html__('Author', 'houzez') => 'author',
					esc_html__('Agency', 'houzez') => 'houzez_agency'
				),
				"heading" => esc_html__("User Role:", "houzez"),
				"description" => "",
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "3",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => array( 
					esc_html__('Default', 'houzez') => '', 
					esc_html__('Price (Low to High)', 'houzez') => 'a_price', 
					esc_html__('Price (High to Low)', 'houzez') => 'd_price',
					esc_html__('Date Old to New', 'houzez') => 'a_date',
					esc_html__('Date New to Old', 'houzez') => 'd_date',
					esc_html__('Featured on Top', 'houzez') => 'featured_top'
				),
				"description" => '',
				"save_always" => true
			),
			
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "pagination_type",
				"type" => "dropdown",
				"heading" => esc_html__("Pagination", "houzez"),
				"value" => array( 
					esc_html__('Load More', 'houzez') => 'loadmore', 
					esc_html__('Number', 'houzez') => 'number'
				),
				"description" => '',
				"save_always" => true
			),

		) // End params
	));


	/*---------------------------------------------------------------------------------
	 Property cards v2
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Property Cards v2", "houzez"),
		"description" => '',
		"base" => "houzez_property_card_v2",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-properties",
		"params" => array(
			array(
				"param_name" => "module_type",
				"type" => "dropdown",
				"value" => array(' Grid 3 Columns ' => 'grid_3_cols', 'Grid 2 Columns' => 'grid_2_cols', 'list' => 'list'),
				"heading" => esc_html__("Layout:", "houzez"),
				"description" => '',
				"save_always" => true,
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				"param_name" => "houzez_user_role",
				"type" => "dropdown",
				"value" => array(
					esc_html__('All', 'houzez') => '',
					esc_html__('Owner', 'houzez') => 'houzez_owner',
					esc_html__('Manager', 'houzez') => 'houzez_manager',
					esc_html__('Agent', 'houzez') => 'houzez_agent',
					esc_html__('Author', 'houzez') => 'author',
					esc_html__('Agency', 'houzez') => 'houzez_agency'
				),
				"heading" => esc_html__("User Role:", "houzez"),
				"description" => "",
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "3",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => array( 
					esc_html__('Default', 'houzez') => '', 
					esc_html__('Price (Low to High)', 'houzez') => 'a_price', 
					esc_html__('Price (High to Low)', 'houzez') => 'd_price',
					esc_html__('Date Old to New', 'houzez') => 'a_date',
					esc_html__('Date New to Old', 'houzez') => 'd_date',
					esc_html__('Featured on Top', 'houzez') => 'featured_top'
				),
				"description" => '',
				"save_always" => true
			),
			
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "pagination_type",
				"type" => "dropdown",
				"heading" => esc_html__("Pagination", "houzez"),
				"value" => array( 
					esc_html__('Load More', 'houzez') => 'loadmore', 
					esc_html__('Number', 'houzez') => 'number'
				),
				"description" => '',
				"save_always" => true
			),

		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Property cards v3
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Property Cards v3", "houzez"),
		"description" => '',
		"base" => "houzez_property_card_v3",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-properties",
		"params" => array(
			array(
				"param_name" => "module_type",
				"type" => "dropdown",
				"value" => array(' Grid 3 Columns ' => 'grid_3_cols', 'Grid 2 Columns' => 'grid_2_cols'),
				"heading" => esc_html__("Layout:", "houzez"),
				"description" => '',
				"save_always" => true,
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				"param_name" => "houzez_user_role",
				"type" => "dropdown",
				"value" => array(
					esc_html__('All', 'houzez') => '',
					esc_html__('Owner', 'houzez') => 'houzez_owner',
					esc_html__('Manager', 'houzez') => 'houzez_manager',
					esc_html__('Agent', 'houzez') => 'houzez_agent',
					esc_html__('Author', 'houzez') => 'author',
					esc_html__('Agency', 'houzez') => 'houzez_agency'
				),
				"heading" => esc_html__("User Role:", "houzez"),
				"description" => "",
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "3",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => array( 
					esc_html__('Default', 'houzez') => '', 
					esc_html__('Price (Low to High)', 'houzez') => 'a_price', 
					esc_html__('Price (High to Low)', 'houzez') => 'd_price',
					esc_html__('Date Old to New', 'houzez') => 'a_date',
					esc_html__('Date New to Old', 'houzez') => 'd_date',
					esc_html__('Featured on Top', 'houzez') => 'featured_top'
				),
				"description" => '',
				"save_always" => true
			),
			
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "pagination_type",
				"type" => "dropdown",
				"heading" => esc_html__("Pagination", "houzez"),
				"value" => array( 
					esc_html__('Load More', 'houzez') => 'loadmore', 
					esc_html__('Number', 'houzez') => 'number'
				),
				"description" => '',
				"save_always" => true
			),

		) // End params
	));


	/*---------------------------------------------------------------------------------
	 Property cards v4
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Property Cards v4", "houzez"),
		"description" => '',
		"base" => "houzez_property_card_v4",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-properties",
		"params" => array(

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				"param_name" => "houzez_user_role",
				"type" => "dropdown",
				"value" => array(
					esc_html__('All', 'houzez') => '',
					esc_html__('Owner', 'houzez') => 'houzez_owner',
					esc_html__('Manager', 'houzez') => 'houzez_manager',
					esc_html__('Agent', 'houzez') => 'houzez_agent',
					esc_html__('Author', 'houzez') => 'author',
					esc_html__('Agency', 'houzez') => 'houzez_agency'
				),
				"heading" => esc_html__("User Role:", "houzez"),
				"description" => "",
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "3",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => array( 
					esc_html__('Default', 'houzez') => '', 
					esc_html__('Price (Low to High)', 'houzez') => 'a_price', 
					esc_html__('Price (High to Low)', 'houzez') => 'd_price',
					esc_html__('Date Old to New', 'houzez') => 'a_date',
					esc_html__('Date New to Old', 'houzez') => 'd_date',
					esc_html__('Featured on Top', 'houzez') => 'featured_top'
				),
				"description" => '',
				"save_always" => true
			),
			
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "pagination_type",
				"type" => "dropdown",
				"heading" => esc_html__("Pagination", "houzez"),
				"value" => array( 
					esc_html__('Load More', 'houzez') => 'loadmore', 
					esc_html__('Number', 'houzez') => 'number'
				),
				"description" => '',
				"save_always" => true
			),

		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Property cards v5
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Property Cards v5", "houzez"),
		"description" => '',
		"base" => "houzez_property_card_v5",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-properties",
		"params" => array(
			array(
				"param_name" => "module_type",
				"type" => "dropdown",
				"value" => array(' Grid 3 Columns ' => 'grid_3_cols', 'Grid 2 Columns' => 'grid_2_cols'),
				"heading" => esc_html__("Layout:", "houzez"),
				"description" => '',
				"save_always" => true,
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				"param_name" => "houzez_user_role",
				"type" => "dropdown",
				"value" => array(
					esc_html__('All', 'houzez') => '',
					esc_html__('Owner', 'houzez') => 'houzez_owner',
					esc_html__('Manager', 'houzez') => 'houzez_manager',
					esc_html__('Agent', 'houzez') => 'houzez_agent',
					esc_html__('Author', 'houzez') => 'author',
					esc_html__('Agency', 'houzez') => 'houzez_agency'
				),
				"heading" => esc_html__("User Role:", "houzez"),
				"description" => "",
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "3",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => array( 
					esc_html__('Default', 'houzez') => '', 
					esc_html__('Price (Low to High)', 'houzez') => 'a_price', 
					esc_html__('Price (High to Low)', 'houzez') => 'd_price',
					esc_html__('Date Old to New', 'houzez') => 'a_date',
					esc_html__('Date New to Old', 'houzez') => 'd_date',
					esc_html__('Featured on Top', 'houzez') => 'featured_top'
				),
				"description" => '',
				"save_always" => true
			),
			
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "pagination_type",
				"type" => "dropdown",
				"heading" => esc_html__("Pagination", "houzez"),
				"value" => array( 
					esc_html__('Load More', 'houzez') => 'loadmore', 
					esc_html__('Number', 'houzez') => 'number'
				),
				"description" => '',
				"save_always" => true
			),

		) // End params
	));
	
	/*---------------------------------------------------------------------------------
	 Property cards v6
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Property Cards v6", "houzez"),
		"description" => '',
		"base" => "houzez_property_card_v6",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-properties",
		"params" => array(
			array(
				"param_name" => "module_type",
				"type" => "dropdown",
				"value" => array(' Grid 3 Columns ' => 'grid_3_cols', 'Grid 2 Columns' => 'grid_2_cols'),
				"heading" => esc_html__("Layout:", "houzez"),
				"description" => '',
				"save_always" => true,
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				"param_name" => "houzez_user_role",
				"type" => "dropdown",
				"value" => array(
					esc_html__('All', 'houzez') => '',
					esc_html__('Owner', 'houzez') => 'houzez_owner',
					esc_html__('Manager', 'houzez') => 'houzez_manager',
					esc_html__('Agent', 'houzez') => 'houzez_agent',
					esc_html__('Author', 'houzez') => 'author',
					esc_html__('Agency', 'houzez') => 'houzez_agency'
				),
				"heading" => esc_html__("User Role:", "houzez"),
				"description" => "",
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "3",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => array( 
					esc_html__('Default', 'houzez') => '', 
					esc_html__('Price (Low to High)', 'houzez') => 'a_price', 
					esc_html__('Price (High to Low)', 'houzez') => 'd_price',
					esc_html__('Date Old to New', 'houzez') => 'a_date',
					esc_html__('Date New to Old', 'houzez') => 'd_date',
					esc_html__('Featured on Top', 'houzez') => 'featured_top'
				),
				"description" => '',
				"save_always" => true
			),
			
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "pagination_type",
				"type" => "dropdown",
				"heading" => esc_html__("Pagination", "houzez"),
				"value" => array( 
					esc_html__('Load More', 'houzez') => 'loadmore', 
					esc_html__('Number', 'houzez') => 'number'
				),
				"description" => '',
				"save_always" => true
			),

		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Property grids
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Properties", "houzez"),
		"description" => '',
		"base" => "houzez-properties",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-properties",
		"params" => array(
			array(
				"param_name" => "prop_grid_style",
				"type" => "dropdown",
				"value" => array('Version 1' => 'v_1', 'Version 2' => 'v_2'),
				"heading" => esc_html__("Grid/List Style:", "houzez"),
				"description" => esc_html__("Choose grid/list style, default will be version 1", "houzez"),
				"save_always" => true
			),
			array(
				"param_name" => "module_type",
				"type" => "dropdown",
				"value" => array(' Grid 3 Columns ' => 'grid_3_cols', 'Grid 2 Columns' => 'grid_2_cols', 'list' => 'list'),
				"heading" => esc_html__("Layout:", "houzez"),
				"description" => '',
				"save_always" => true,
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
				"group" => 'Filters',
			),

			array(
				"param_name" => "houzez_user_role",
				"type" => "dropdown",
				"value" => array(
					esc_html__('All', 'houzez') => '',
					esc_html__('Owner', 'houzez') => 'houzez_owner',
					esc_html__('Manager', 'houzez') => 'houzez_manager',
					esc_html__('Agent', 'houzez') => 'houzez_agent',
					esc_html__('Author', 'houzez') => 'author',
					esc_html__('Agency', 'houzez') => 'houzez_agency'
				),
				"heading" => esc_html__("User Role:", "houzez"),
				"description" => "",
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"group" => 'Filters',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "3",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => array( 
					esc_html__('Default', 'houzez') => '', 
					esc_html__('Price (Low to High)', 'houzez') => 'a_price', 
					esc_html__('Price (High to Low)', 'houzez') => 'd_price',
					esc_html__('Date Old to New', 'houzez') => 'a_date',
					esc_html__('Date New to Old', 'houzez') => 'd_date',
					esc_html__('Featured on Top', 'houzez') => 'featured_top'
				),
				"description" => '',
				"save_always" => true
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "pagination_type",
				"type" => "dropdown",
				"heading" => esc_html__("Pagination", "houzez"),
				"value" => array( 
					esc_html__('Load More', 'houzez') => 'loadmore', 
					esc_html__('Number', 'houzez') => 'number'
				),
				"description" => '',
				"save_always" => true
			),

		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Property Carousel Version 1
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Properties Carousel v1", "houzez"),
		"description" => '',
		"base" => "houzez-prop-carousel-v2",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-carousel-v2",
		"params" => array(

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"save_always" => true
			),

			array(
				"param_name" => "property_ids",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Properties IDs:", "houzez"),
				"description" => esc_html__("Enter properties ids comma separated. Ex 12,305,34", "houzez"),
				"save_always" => true
			),

			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => $sort_by,
				"description" => '',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "9",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true

			),

			array(
				"param_name" => "all_btn",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - Button Text:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "all_url",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - button url:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "slide_auto",
				"type" => "dropdown",
				"value" => array(
					'No' => 'false',
					'Yes' => 'true'
				),
				"heading" => esc_html__("Auto Play:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slide_infinite",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Infinite Scroll:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "auto_speed",
				"type" => "textfield",
				"value" => '3000',
				"heading" => esc_html__("Auto Play Speed:", "houzez"),
				"description" => "Autoplay Speed in milliseconds. Default 3000",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slides_to_show",
				"type" => "dropdown",
				"value" => array(
					'2' => '2',
					'3' => '3'
				),
				"heading" => esc_html__("Slides To Show:", "houzez"),
				"description" => "",
				"std" => "3",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slides_to_scroll",
				"type" => "dropdown",
				"value" => array(
					'2' => '2',
					'3' => '3'
				),
				"heading" => esc_html__("Slides To Scroll:", "houzez"),
				"description" => "",
				"std" => "3",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "navigation",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Next/Prev Navigation:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slide_dots",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Dots Nav:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			)
		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Property Carousel Version 2
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Properties Carousel v2", "houzez"),
		"description" => '',
		"base" => "houzez-prop-carousel-v2n",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-carousel-v2n",
		"params" => array(

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"save_always" => true
			),

			array(
				"param_name" => "property_ids",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Properties IDs:", "houzez"),
				"description" => esc_html__("Enter properties ids comma separated. Ex 12,305,34", "houzez"),
				"save_always" => true
			),

			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => $sort_by,
				"description" => '',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "9",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true

			),

			array(
				"param_name" => "all_btn",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - Button Text:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "all_url",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - button url:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "slide_auto",
				"type" => "dropdown",
				"value" => array(
					'No' => 'false',
					'Yes' => 'true'
				),
				"heading" => esc_html__("Auto Play:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slide_infinite",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Infinite Scroll:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "auto_speed",
				"type" => "textfield",
				"value" => '3000',
				"heading" => esc_html__("Auto Play Speed:", "houzez"),
				"description" => "Autoplay Speed in milliseconds. Default 3000",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slides_to_show",
				"type" => "dropdown",
				"value" => array(
					'2' => '2',
					'3' => '3'
				),
				"heading" => esc_html__("Slides To Show:", "houzez"),
				"description" => "",
				"std" => "3",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slides_to_scroll",
				"type" => "dropdown",
				"value" => array(
					'1' => '1',
					'2' => '2',
					'3' => '3'
				),
				"heading" => esc_html__("Slides To Scroll:", "houzez"),
				"description" => "",
				"std" => "2",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "navigation",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Next/Prev Navigation:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slide_dots",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Dots Nav:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			)
		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Property Carousel v3
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Properties Carousel v3", "houzez"),
		"description" => '',
		"base" => "houzez-prop-carousel",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-carousel",
		"params" => array(


			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
			),

			array(
				"param_name" => "property_ids",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Properties IDs:", "houzez"),
				"description" => esc_html__("Enter properties ids comma separated. Ex 12,305,34", "houzez"),
				"save_always" => true
			),

			array(
				"param_name" => "slides_meta_position",
				"type" => "dropdown",
				"value" => array(
					'Above Image' => 'caption-above',
					'Bottom ( Recommended for more then 3 columns )' => 'caption-bottom'
				),
				"heading" => esc_html__("Meta Position:", "houzez"),
				"description" => "",
				"save_always" => true
			),

			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => $sort_by,
				"description" => '',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "9",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true

			),

			array(
				"param_name" => "custom_title",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Optional - Custom Title:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "all_btn",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - Button Text:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "all_url",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - button url:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "slides_to_show",
				"type" => "dropdown",
				"value" => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6'
				),
				"heading" => esc_html__("Slides To Show:", "houzez"),
				"description" => "",
				"std" => "4",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slides_to_scroll",
				"type" => "dropdown",
				"value" => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6'
				),
				"heading" => esc_html__("Slides To Scroll:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slide_infinite",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Infinite Scroll:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slide_auto",
				"type" => "dropdown",
				"value" => array(
					'No' => 'false',
					'Yes' => 'true'
				),
				"heading" => esc_html__("Auto Play:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "auto_speed",
				"type" => "textfield",
				"value" => '3000',
				"heading" => esc_html__("Auto Play Speed:", "houzez"),
				"description" => "Autoplay Speed in milliseconds. Default 3000",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "navigation",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Next/Prev Navigation:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slide_dots",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Dots Nav:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			)

		) // End params
	));

	
	/*---------------------------------------------------------------------------------
	 Property Carousel Version 5
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Properties Carousel v5", "houzez"),
		"description" => '',
		"base" => "houzez-prop-carousel-v5",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-carousel-v5",
		"params" => array(

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"save_always" => true
			),

			array(
				"param_name" => "property_ids",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Properties IDs:", "houzez"),
				"description" => esc_html__("Enter properties ids comma separated. Ex 12,305,34", "houzez"),
				"save_always" => true
			),

			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => $sort_by,
				"description" => '',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "9",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true

			),

			array(
				"param_name" => "all_btn",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - Button Text:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "all_url",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - button url:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "slide_auto",
				"type" => "dropdown",
				"value" => array(
					'No' => 'false',
					'Yes' => 'true'
				),
				"heading" => esc_html__("Auto Play:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slide_infinite",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Infinite Scroll:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "auto_speed",
				"type" => "textfield",
				"value" => '3000',
				"heading" => esc_html__("Auto Play Speed:", "houzez"),
				"description" => "Autoplay Speed in milliseconds. Default 3000",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slides_to_show",
				"type" => "dropdown",
				"value" => array(
					'2' => '2',
					'3' => '3'
				),
				"heading" => esc_html__("Slides To Show:", "houzez"),
				"description" => "",
				"std" => "3",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slides_to_scroll",
				"type" => "dropdown",
				"value" => array(
					'2' => '2',
					'3' => '3'
				),
				"heading" => esc_html__("Slides To Scroll:", "houzez"),
				"description" => "",
				"std" => "3",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "navigation",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Next/Prev Navigation:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slide_dots",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Dots Nav:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			)
		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Property Carousel Version 6
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Properties Carousel v6", "houzez"),
		"description" => '',
		"base" => "houzez-prop-carousel-v6",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-carousel-v6",
		"params" => array(

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"save_always" => true
			),

			array(
				"param_name" => "property_ids",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Properties IDs:", "houzez"),
				"description" => esc_html__("Enter properties ids comma separated. Ex 12,305,34", "houzez"),
				"save_always" => true
			),

			array(
				"param_name" => "sort_by",
				"type" => "dropdown",
				"heading" => esc_html__("Sort By", "houzez"),
				"value" => $sort_by,
				"description" => '',
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "9",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true

			),

			array(
				"param_name" => "all_btn",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - Button Text:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "all_url",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - button url:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "slide_auto",
				"type" => "dropdown",
				"value" => array(
					'No' => 'false',
					'Yes' => 'true'
				),
				"heading" => esc_html__("Auto Play:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slide_infinite",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Infinite Scroll:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "auto_speed",
				"type" => "textfield",
				"value" => '3000',
				"heading" => esc_html__("Auto Play Speed:", "houzez"),
				"description" => "Autoplay Speed in milliseconds. Default 3000",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slides_to_show",
				"type" => "dropdown",
				"value" => array(
					'2' => '2',
					'3' => '3'
				),
				"heading" => esc_html__("Slides To Show:", "houzez"),
				"description" => "",
				"std" => "3",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slides_to_scroll",
				"type" => "dropdown",
				"value" => array(
					'2' => '2',
					'3' => '3'
				),
				"heading" => esc_html__("Slides To Scroll:", "houzez"),
				"description" => "",
				"std" => "3",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "navigation",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Next/Prev Navigation:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			),
			array(
				"param_name" => "slide_dots",
				"type" => "dropdown",
				"value" => array(
					'Yes' => 'true',
					'No' => 'false'
				),
				"heading" => esc_html__("Dots Nav:", "houzez"),
				"description" => "",
				"save_always" => true,
				"group" => 'Carousel Settings'
			)
		) // End params
	));

	/*---------------------------------------------------------------------------------
		Location Grid Section
	-----------------------------------------------------------------------------------*/
	vc_map( array(
		"name"	=>	esc_html__( "Houzez Grids", "houzez" ),
		"description"			=> 'Show Locations, Property Types, Cities, States in grid',
		"base"					=> "hz-grids",
		'category'				=> "By Favethemes",
		"class"					=> "",
		'admin_enqueue_js'		=> "",
		'admin_enqueue_css'		=> "",
		"icon" 					=> "icon-hz-grid",
		"params"				=> array(

			array(
				"param_name" => "houzez_grid_type",
				"type" => "dropdown",
				"value" => array( 'Grid v1' => 'grid_v1', 'Grid v2' => 'grid_v2', 'Grid v3' => 'grid_v3', 'Grid v4' => 'grid_v4' ),
				"heading" => esc_html__("Choose Grid:", "houzez" ),
				"save_always" => true
			),
			array(
				"param_name" => "houzez_grid_from",
				"type" => "dropdown",
				"value" => $houzez_grids_tax,
				"heading" => esc_html__("Choose Taxonomy", "houzez" ),
				"save_always" => true
			),
			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Types", "houzez"),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => false,
				'description'   => '',
				'param_name'    => 'property_type',
				"dependency" => Array("element" => "houzez_grid_from", "value" => array("property_type")),
				'save_always'   => true,
				'std'           => '',
			),
			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => false,
				'description'   => '',
				'param_name'    => 'property_status',
				"dependency" => Array("element" => "houzez_grid_from", "value" => array("property_status")),
				'save_always'   => true,
				'std'           => '',
			),
			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Labels", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => false,
				'description'   => '',
				'param_name'    => 'property_label',
				"dependency" => Array("element" => "houzez_grid_from", "value" => array("property_label")),
				'save_always'   => true,
				'std'           => '',
			),
			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property States", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => false,
				'description'   => '',
				'param_name'    => 'property_state',
				"dependency" => Array("element" => "houzez_grid_from", "value" => array("property_state")),
				'save_always'   => true,
				'std'           => '',
			),
			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Cities", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => false,
				'description'   => '',
				'param_name'    => 'property_city',
				"dependency" => Array("element" => "houzez_grid_from", "value" => array("property_city")),
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Areas", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => false,
				'description'   => '',
				'param_name'    => 'property_area',
				"dependency" => Array("element" => "houzez_grid_from", "value" => array("property_area")),
				'save_always'   => true,
				'std'           => '',
			),

			array(
				"param_name" => "houzez_show_child",
				"type" => "dropdown",
				"value" => array( 'No' => '0', 'Yes' => '1' ),
				"heading" => esc_html__("Show Child:", "houzez" ),
				"save_always" => true
			),
			array(
				"param_name" => "orderby",
				"type" => "dropdown",
				"value" => array( 'Name' => 'name', 'Count' => 'count', 'ID' => 'id' ),
				"heading" => esc_html__("Order By:", "houzez" ),
				"save_always" => true
			),
			array(
				"param_name" => "order",
				"type" => "dropdown",
				"value" => array( 'ASC' => 'ASC', 'DESC' => 'DESC' ),
				"heading" => esc_html__("Order:", "houzez" ),
				"save_always" => true
			),
			array(
				"param_name" => "houzez_hide_empty",
				"type" => "dropdown",
				"value" => array( 'Yes' => '1', 'No' => '0' ),
				"heading" => esc_html__("Hide Empty:", "houzez" ),
				"save_always" => true
			),
			array(
				"param_name" => "no_of_terms",
				"type" => "textfield",
				"value" => '',
				"heading" => esc_html__("Number of Items to Show:", "houzez" ),
				"save_always" => true
			)

		) // end params
	) );

	/*---------------------------------------------------------------------------------
	 Property By ID
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Property by ID", "houzez"),
		"description" => esc_html__('Show single property by id', "houzez"),
		"base" => "houzez-prop-by-id",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-by-id",
		"params" => array(
			array(
				"param_name" => "prop_grid_style",
				"type" => "dropdown",
				"value" => array(
					'Property Card v1' => 'v_1', 
					'Property Card v2' => 'v_2',
					'Property Card v3' => 'v_3',
					'Property Card v4' => 'v_4',
					'Property Card v5' => 'v_5',
					'Property Card v6' => 'v_6',
				),
				"heading" => esc_html__("Grid/List Style:", "houzez"),
				"description" => esc_html__("Choose grid/list style, default will be v1", "houzez"),
				"save_always" => true
			),
			array(
				"param_name" => "property_id",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Property ID:", "houzez"),
				"description" => esc_html__("Enter property ID. Ex 305", "houzez"),
				"save_always" => true
			)

		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Property By ID
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Properties by IDs", "houzez"),
		"description" => esc_html__("Show properties by IDs", "houzez"),
		"base" => "houzez-prop-by-ids",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-by-ids",
		"params" => array(
			array(
				"param_name" => "prop_grid_style",
				"type" => "dropdown",
				"value" => array(
					'Property Card v1' => 'v_1', 
					'Property Card v2' => 'v_2',
					'Property Card v3' => 'v_3',
					'Property Card v4' => 'v_4',
					'Property Card v5' => 'v_5',
					'Property Card v6' => 'v_6',
				),
				"heading" => esc_html__("Grid/List Style:", "houzez"),
				"description" => esc_html__("Choose grid/list style, default will be  v1", "houzez"),
				"save_always" => true
			),
			array(
				"param_name" => "property_ids",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Properties IDs:", "houzez"),
				"description" => esc_html__("Enter properties ids comma separated. Ex 12,305,34", "houzez"),
				"save_always" => true
			)

		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Property grids
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Properties Grids", "houzez"),
		"description" => '',
		"base" => "houzez-prop-grids",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-grids",
		"params" => array(


			array(
				"param_name" => "prop_grid_type",
				"type" => "dropdown",
				"value" => array(' Grid 1 ' => 'grid_1', 'Grid 2' => 'grid_2', 'Grid 3' => 'grid_3', 'Grid 4' => 'grid_4'),
				"heading" => esc_html__("Grid Style:", "houzez"),
				"description" => '',
				"save_always" => true,
			),
			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__('Property Type filter:', 'houzez'),
				'taxonomy'      => 'property_type',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_type',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Status filter:", "houzez"),
				'taxonomy'      => 'property_status',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_status',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property State filter:", "houzez"),
				'taxonomy'      => 'property_state',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_state',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property City filter:", "houzez"),
				'taxonomy'      => 'property_city',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_city',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property Area filter:", "houzez"),
				'taxonomy'      => 'property_area',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_area',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Property label filter:", "houzez"),
				'taxonomy'      => 'property_label',
				'is_multiple'   => true,
				'is_hide_empty'   => true,
				'description'   => '',
				'param_name'    => 'property_label',
				'save_always'   => true,
				'std'           => '',
			),

			array(
				"param_name" => "featured_prop",
				"type" => "dropdown",
				"value" => array(esc_html__('- Any -', 'houzez') => '', esc_html__('Without Featured', 'houzez') => 'no', esc_html__('Only Featured', 'houzez') => 'yes'),
				"heading" => esc_html__("Featured Properties:", "houzez"),
				"description" => esc_html__("You can make a post featured by clicking featured properties checkbox while add/edit post", "houzez"),
				"save_always" => true
			),

			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "9",
				"heading" => esc_html__("Limit post number:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true

			),

			array(
				"param_name" => "custom_title",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Optional - Custom Title:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "all_btn",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - Button Text:", "houzez"),
				"description" => "",

			),
			array(
				"param_name" => "all_url",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("All - button url:", "houzez"),
				"description" => "",
				"save_always" => true

			)



		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Price Tables
	-----------------------------------------------------------------------------------*/
	$packages_array = array( esc_html__('None', 'houzez') => '');
	$packages_posts = get_posts(array('post_type' => 'houzez_packages', 'posts_per_page' => -1));
	if (!empty($packages_posts)) {
		foreach ($packages_posts as $package_post) {
			$packages_array[$package_post->post_title] = $package_post->ID;
		}
	}

	vc_map(array(
		"name" => esc_html__("Price Table", "houzez"),
		"description" => '',
		"base" => "houzez-price-table",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-price",
		"params" => array(

			array(
				"param_name" => "package_id",
				"type" => "dropdown",
				"value" => $packages_array,
				"heading" => esc_html__("Select Package:", "houzez"),
				"description" => "",
				"save_always" => true
			),

			array(
				"param_name" => "package_data",
				"type" => "dropdown",
				"value" => array('Get Data From Package' => 'dynamic', 'Add Custom Data' => 'custom'),
				"heading" => esc_html__("Data Type:", "houzez"),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "package_popular",
				"type" => "dropdown",
				"value" => array('No' => 'no', 'Yes' => 'yes'),
				"heading" => esc_html__("Popular?", "houzez"),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "package_name",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Package Name:", "houzez"),
				"description" => '',
				"dependency" => Array("element" => "package_data", "value" => array("custom")),
				"save_always" => true
			),
			array(
				"param_name" => "package_price",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Package Price:", "houzez"),
				"description" => '',
				"dependency" => Array("element" => "package_data", "value" => array("custom")),
				"save_always" => true
			),
			
			array(
				"param_name" => "package_currency",
				"type" => "textfield",
				"value" => "$",
				"heading" => esc_html__("Package Currency:", "houzez"),
				"description" => '',
				"dependency" => Array("element" => "package_data", "value" => array("custom")),
				"save_always" => true
			),
			array(
				"param_name" => "content",
				"type" => "textarea_html",
				"value" => '<ul class="list-unstyled">
 	<li><i class="houzez-icon icon-check-circle-1 primary-text mr-1"></i> Time Period: <strong>10 days</strong></li>
 	<li><i class="houzez-icon icon-check-circle-1 primary-text mr-1"></i> Properties: <strong>2</strong></li>
 	<li><i class="houzez-icon icon-check-circle-1 primary-text mr-1"></i> Featured Listings: <strong>2</strong></li>
</ul>',
				"heading" => esc_html__("Content:", "houzez"),
				"description" => '',
				"dependency" => Array("element" => "package_data", "value" => array("custom")),
				"save_always" => true
			),
			array(
				"param_name" => "package_btn_text",
				"type" => "textfield",
				"value" => "Get Started",
				"heading" => esc_html__("Button Text:", "houzez"),
				"description" => '',
				"dependency" => Array("element" => "package_data", "value" => array("custom")),
				"save_always" => true
			),

		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Property Carousel
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Team", "houzez"),
		"description" => '',
		"base" => "houzez-team",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-team",
		"params" => array(
			array(
				"type" => "attach_image",
				"holder" => "div",
				"class" => "",
				"heading" => "Image",
				"param_name" => "team_image",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Name", "houzez"),
				"param_name" => "team_name",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Position", "houzez"),
				"param_name" => "team_position",
				"save_always" => true
			),
			array(
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Description", "houzez"),
				"param_name" => "team_description",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Custom Link", "houzez"),
				"param_name" => "team_link",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Facebook Profile Link", "houzez"),
				"param_name" => "team_social_facebook",
				"save_always" => true
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Facebook Target",
				"param_name" => "team_social_facebook_target",
				"value" => array(
					"" => "",
					"Self" => "_self",
					"Blank" => "_blank",
					"Parent" => "_parent"
				),
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Twitter Profile Link", "houzez"),
				"param_name" => "team_social_twitter",
				"save_always" => true
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Twitter Target",
				"param_name" => "team_social_twitter_target",
				"value" => array(
					"" => "",
					"Self" => "_self",
					"Blank" => "_blank",
					"Parent" => "_parent"
				),
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("LinkedIn Profile Link", "houzez"),
				"param_name" => "team_social_linkedin",
				"save_always" => true
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "LinkedIn Target",
				"param_name" => "team_social_linkedin_target",
				"value" => array(
					"" => "",
					"Self" => "_self",
					"Blank" => "_blank",
					"Parent" => "_parent"
				),
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Pinterest Profile Link", "houzez"),
				"param_name" => "team_social_pinterest",
				"save_always" => true
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Pinerest Target",
				"param_name" => "team_social_pinterest_target",
				"value" => array(
					"" => "",
					"Self" => "_self",
					"Blank" => "_blank",
					"Parent" => "_parent"
				),
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__("Google Plus Profile Link", "houzez"),
				"param_name" => "team_social_googleplus",
				"save_always" => true
			),
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Google Plus Target",
				"param_name" => "team_social_googleplus_target",
				"value" => array(
					"" => "",
					"Self" => "_self",
					"Blank" => "_blank",
					"Parent" => "_parent"
				),
				"description" => "",
				"save_always" => true
			),

		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Testimonials
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Testimonials", "houzez"),
		"description" => 'Show testimonials grid or slides',
		"base" => "houzez-testimonials",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-testimonials",
		"params" => array(

			array(
				"param_name" => "testimonials_type",
				"type" => "dropdown",
				"value" => array('Grid' => 'grid', 'Slides' => 'slides'),
				"heading" => esc_html__("Testimonials Type:", "houzez"),
				"description" => '',
				"save_always" => true,
			),
			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "6",
				"heading" => esc_html__("Limit:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "orderby",
				"type" => "dropdown",
				"value" => array('None' => 'none', 'ID' => 'ID', 'title' => 'title', 'Date' => 'date', 'Random' => 'rand', 'Menu Order' => 'menu_order' ),
				"heading" => esc_html__("Order By:", "houzez"),
				"description" => '',
				"save_always" => true,
			),
			array(
				"param_name" => "order",
				"type" => "dropdown",
				"value" => array('ASC' => 'ASC', 'DESC' => 'DESC' ),
				"heading" => esc_html__("Order:", "houzez"),
				"description" => '',
				"save_always" => true,
			),

		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Agents
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Agents", "houzez"),
		"description" => 'Show agents grid or carousel',
		"base" => "houzez-agents",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-agents",
		"params" => array(

			array(
				"param_name" => "agents_type",
				"type" => "dropdown",
				"value" => array('Grid' => 'grid', 'Carousel' => 'Carousel'),
				"heading" => esc_html__("Agents Type:", "houzez"),
				"description" => '',
				"save_always" => true,
			),
			
			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("Category filter:", "houzez"),
				'taxonomy'      => 'agent_category',
				'is_multiple'   => false,
				'is_hide_empty'   => false,
				'description'   => '',
				'param_name'    => 'agent_category',
				'save_always'   => true,
				'std'           => '',
			),
			array(
				'type'          => 'houzez_get_taxonomy_list',
				'heading'       => esc_html__("City:", "houzez"),
				'taxonomy'      => 'agent_city',
				'is_multiple'   => false,
				'is_hide_empty'   => false,
				'description'   => '',
				'param_name'    => 'agent_city',
				'save_always'   => true,
				'std'           => '',
			),
			array(
				"param_name" => "custom_title",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Optional - Custom Title:", "houzez"),
				"description" => "",
				"dependency" => Array("element" => "agents_type", "value" => array("Carousel")),
				"save_always" => true
			),
			array(
				"param_name" => "custom_subtitle",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Optional - Custom Sub Title:", "houzez"),
				"description" => "",
				"dependency" => Array("element" => "agents_type", "value" => array("Carousel")),
				"save_always" => true
			),
			array(
				"param_name" => "columns",
				"type" => "dropdown",
				"value" => array('3 Columns' => '3', '4 Columns' => '4'),
				"heading" => esc_html__("Columns:", "houzez"),
				"description" => '',
				"save_always" => true,
			),
			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "8",
				"heading" => esc_html__("Limit:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "orderby",
				"type" => "dropdown",
				"value" => array('None' => 'none', 'ID' => 'ID', 'title' => 'title', 'Date' => 'date', 'Random' => 'rand', 'Menu Order' => 'menu_order' ),
				"heading" => esc_html__("Order By:", "houzez"),
				"description" => '',
				"save_always" => true,
			),
			array(
				"param_name" => "order",
				"type" => "dropdown",
				"value" => array('ASC' => 'ASC', 'DESC' => 'DESC' ),
				"heading" => esc_html__("Order:", "houzez"),
				"description" => '',
				"save_always" => true,
			),

		) // End params
	));

	/*---------------------------------------------------------------------------------
	 Partners
	-----------------------------------------------------------------------------------*/
	vc_map(array(
		"name" => esc_html__("Partners", "houzez"),
		"description" => '',
		"base" => "houzez-partners",
		'category' => "By Favethemes",
		"class" => "",
		'admin_enqueue_js' => "",
		'admin_enqueue_css' => "",
		"icon" => "icon-prop-partners",
		"params" => array(

			array(
				"param_name" => "custom_title",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Optional - Custom Title:", "houzez"),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "custom_subtitle",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Optional - Custom Sub Title:", "houzez"),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => "8",
				"heading" => esc_html__("Limit:", "houzez"),
				"description" => "",
				"save_always" => true,
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => "",
				"heading" => esc_html__("Offset posts:", "houzez"),
				"description" => "",
				"save_always" => true

			),
			array(
				"param_name" => "orderby",
				"type" => "dropdown",
				"value" => array('None' => 'none', 'ID' => 'ID', 'title' => 'title', 'Date' => 'date', 'Random' => 'rand', 'Menu Order' => 'menu_order' ),
				"heading" => esc_html__("Order By:", "houzez"),
				"description" => '',
				"save_always" => true,
			),
			array(
				"param_name" => "order",
				"type" => "dropdown",
				"value" => array('ASC' => 'ASC', 'DESC' => 'DESC' ),
				"heading" => esc_html__("Order:", "houzez"),
				"description" => '',
				"save_always" => true,
			),

		) // End params
	));

	/*---------------------------------------------------------------------------------
		Blog Posts Grids
	-----------------------------------------------------------------------------------*/
	vc_map( array(
		"name"					=> esc_html__( "Blog Posts Grid", "houzez" ),
		"description"			=> '',
		"base"					=> "houzez-blog-posts",
		'category'				=> "By Favethemes",
		"class"					=> "",
		'admin_enqueue_js'		=> "",
		'admin_enqueue_css'		=> "",
		"icon" 					=> "icon-blog-posts",
		"params"				=> array(
			array(
				"param_name" => "grid_style",
				"type" => "dropdown",
				"value" => array(
					"Style 1"   => "style_1",
					"Style 2"   => "style_2"
				),
				"heading" => esc_html__("Grid Style:", "houzez" ),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "category_id",
				"type" => "dropdown",
				"value" => houzez_get_category_id_array(),
				"heading" => esc_html__("Category filter:", "houzez" ),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => '',
				"heading" => esc_html__("Offset", "houzez" ),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => '',
				"heading" => esc_html__("Number of posts to show", "houzez" ),
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Title", "houzez" ),
				"param_name" => "title",
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Subtitle", "houzez" ),
				"param_name" => "sub_title",
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"class" => "",
				"value" => 'All',
				"heading" => esc_html__("All Posts Text", "houzez" ),
				"param_name" => "all_btn",
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"class" => "",
				"value" => '',
				"heading" => esc_html__("All Posts Link", "houzez" ),
				"param_name" => "all_url",
				"description" => "",
				"save_always" => true
			),
		) // End params
	) );

	/*---------------------------------------------------------------------------------
		Blog Posts Carousels
	-----------------------------------------------------------------------------------*/
	vc_map( array(
		"name"					=> esc_html__( "Blog Posts Carousel", "houzez" ),
		"description"			=> '',
		"base"					=> "houzez-blog-posts-carousel",
		'category'				=> "By Favethemes",
		"class"					=> "",
		'admin_enqueue_js'		=> "",
		'admin_enqueue_css'		=> "",
		"icon" 					=> "icon-blog-posts-carousel",
		"params"				=> array(
			array(
				"param_name" => "grid_style",
				"type" => "dropdown",
				"value" => array(
					"Style 1"   => "style_1",
					"Style 2"   => "style_2"
				),
				"heading" => esc_html__("Grid Style:", "houzez" ),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "category_id",
				"type" => "dropdown",
				"value" => houzez_get_category_id_array(),
				"heading" => esc_html__("Category filter:", "houzez" ),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "offset",
				"type" => "textfield",
				"value" => '',
				"heading" => esc_html__("Offset", "houzez" ),
				"description" => "",
				"save_always" => true
			),
			array(
				"param_name" => "posts_limit",
				"type" => "textfield",
				"value" => '',
				"heading" => esc_html__("Number of posts to show", "houzez" ),
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Title", "houzez" ),
				"param_name" => "title",
				"description" => ""
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Subtitle", "houzez" ),
				"param_name" => "sub_title",
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"class" => "",
				"value" => 'All',
				"heading" => esc_html__("All Posts Text", "houzez" ),
				"param_name" => "all_btn",
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"class" => "",
				"value" => '',
				"heading" => esc_html__("All Posts Link", "houzez" ),
				"param_name" => "all_url",
				"description" => "",
				"save_always" => true
			),
		) // End params
	) );

	/*---------------------------------------------------------------------------------
	 Text with icons
	-----------------------------------------------------------------------------------*/
	class WPBakeryShortCode_Text_With_Icons  extends WPBakeryShortCodesContainer {}

	vc_map( array(
		"name" => "Text With Icons",
		"base" => "text_with_icons",
		"as_parent" => array('only' => 'text_with_icon'),
		"content_element" => true,
		"category" => 'By Favethemes',
		"icon" => "icon-text_with_icon",
		"show_settings_on_create" => true,
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Columns",
				"param_name" => "columns",
				"value" => array(
					"Three"     => "three_columns",
					"Four"      => "four_columns"
				),
				"description" => "",
				"save_always" => true
			)
		),
		"js_view" => 'VcColumnView'
	) );

	class WPBakeryShortCode_Text_With_Icon extends WPBakeryShortCode {}
	vc_map( array(
		"name" => "Text with icon",
		"base" => "text_with_icon",
		"icon" => "icon-text_with_icon",
		"content_element" => true,
		"as_child" => array('only' => 'text_with_icons'),
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Icon Type",
				"param_name" => "icon_type",
				"value" => array(
					"Font Awesome"   => "fontawesome_icon",
					"Custom Icon"   => "custom_icon"
				),
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "font_awesome_icon",
				"value" => $fontawesomeIcons,
				"description" => wp_kses(__("Please set an icon. The entire list of icons can be found at <a href='http://fortawesome.github.io/Font-Awesome/icons/' target='_blank'>FontAwesome project page</a>.", "houzez"), $allowed_html_array),
				"dependency" => Array('element' => "icon_type", 'value' => array('fontawesome_icon')),
				"save_always" => true
			),
			array(
				"type" => "attach_image",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "custom_icon",
				"description" => "",
				"dependency" => Array('element' => "icon_type", 'value' => array('custom_icon')),
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title",
				"param_name" => "title",
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => "Text",
				"param_name" => "text",
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Read More Text",
				"param_name" => "read_more_text",
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Read More Link",
				"param_name" => "read_more_link",
				"description" => "",
				"save_always" => true
			),
		)
	) );
	
	/*---------------------------------------------------------------------------------
	 Text with icons v2
	-----------------------------------------------------------------------------------*/
	class WPBakeryShortCode_Text_With_Icons_v2  extends WPBakeryShortCodesContainer {}

	vc_map( array(
		"name" => "Text With Icons v2",
		"base" => "text_with_icons_v2",
		"as_parent" => array('only' => 'text_with_icon_v2'),
		"content_element" => true,
		"category" => 'By Favethemes',
		"icon" => "icon-text_with_icon",
		"show_settings_on_create" => true,
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Columns",
				"param_name" => "columns",
				"value" => array(
					"Three"     => "three_columns",
					"Four"      => "four_columns"
				),
				"description" => "",
				"save_always" => true
			)
		),
		"js_view" => 'VcColumnView'
	) );

	class WPBakeryShortCode_Text_With_Icon_v2 extends WPBakeryShortCode {}
	vc_map( array(
		"name" => "Text with icon",
		"base" => "text_with_icon_v2",
		"icon" => "icon-text_with_icon",
		"content_element" => true,
		"as_child" => array('only' => 'text_with_icons_v2'),
		"params" => array(
			array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => "Icon Type",
				"param_name" => "icon_type",
				"value" => array(
					"Font Awesome"   => "fontawesome_icon",
					"Custom Icon"   => "custom_icon"
				),
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "font_awesome_icon",
				"value" => $fontawesomeIcons,
				"description" => wp_kses(__("Please set an icon. The entire list of icons can be found at <a href='http://fortawesome.github.io/Font-Awesome/icons/' target='_blank'>FontAwesome project page</a>.", "houzez"), $allowed_html_array),
				"dependency" => Array('element' => "icon_type", 'value' => array('fontawesome_icon')),
				"save_always" => true
			),
			array(
				"type" => "attach_image",
				"class" => "",
				"heading" => "Icon",
				"param_name" => "custom_icon",
				"description" => "",
				"dependency" => Array('element' => "icon_type", 'value' => array('custom_icon')),
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Title",
				"param_name" => "title",
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => "Text",
				"param_name" => "text",
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Read More Text",
				"param_name" => "read_more_text",
				"description" => "",
				"save_always" => true
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => "Read More Link",
				"param_name" => "read_more_link",
				"description" => "",
				"save_always" => true
			),
		)
	) );
	

	if ( !function_exists('houzez_get_taxonomy_list') )
	{
	    function houzez_get_vc_taxonomy_list($settings, $value)
	    {	
	    	$taxonomy    = isset($settings['taxonomy']) ? $settings['taxonomy'] : '';
	        $param_name  = isset($settings['param_name']) ? $settings['param_name'] : '';
	        $isHideEmpty = isset($settings['is_hide_empty']) && $settings['is_hide_empty']  ?  true : false;
	        $isMultiple  = isset($settings['is_multiple']) && $settings['is_multiple']  ?  'multiple' : '';
	        

	        if ( !is_array($value) )
	        {
	            $value = explode(',', $value);
	        }

	        $getTerms   = get_terms(
	           array(
	               'taxonomy'      => $taxonomy,
	               'hide_empty'    => $isHideEmpty
	           )
	        );

	        ob_start();
	        if ( !empty($getTerms) || !is_wp_error($getTerms) )
	        {
	            ?>
	            <select name="<?php echo esc_attr($param_name); ?>" class="wpb_vc_param_value <?php echo esc_attr($param_name); ?>" <?php echo esc_attr($isMultiple); ?>>
	            	<option value=""><?php esc_html_e('- All -', 'houzez')?></option>
	                <?php
	                    foreach ( $getTerms as $getTerm ) :
	                        if ( in_array($getTerm->slug, $value) )
	                        {
	                            $selected = 'selected';
	                        }else{
	                            $selected = '';
	                        }
	                ?>
	                        <option <?php echo esc_attr($selected); ?> value="<?php echo esc_attr($getTerm->slug); ?>"><?php echo esc_html($getTerm->name); ?></option>
	                <?php
	                    endforeach;
	                ?>
	            </select>
	            <?php if ( !empty($isMultiple) ) : ?>
	            <button style="margin-top: 5px;" class="button button-primary" id="houzez-toggle-select"><?php esc_html_e('Toggle Select', 'houzez'); ?></button>
	            <?php endif; ?>
	            <?php
	        }else{
	            esc_html_e('There are no taxonomy found', 'houzez');
	        }

	        $output = ob_get_clean();
	        return $output;
	    }

	    $houzez_shortcode_to_param = 'vc_add_';
	    $houzez_shortcode_to_param = $houzez_shortcode_to_param . 'shortcode_param';
	    $houzez_shortcode_to_param('houzez_get_taxonomy_list', 'houzez_get_vc_taxonomy_list');
	}


} // End Class_exists
?>