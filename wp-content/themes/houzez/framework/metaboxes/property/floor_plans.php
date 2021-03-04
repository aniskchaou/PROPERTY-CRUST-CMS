<?php
/**
 * Add floor_plans metabox tab
 *
 * @param $metabox_tabs
 *
 * @return array
 */
function houzez_floor_plans_metabox_tab( $metabox_tabs ) {
	if ( is_array( $metabox_tabs ) ) {

		$metabox_tabs['floor_plans'] = array(
			'label' => houzez_option('cls_floor_plans', 'Floor Plans'),
            'icon' => 'dashicons-layout',
		);

	}
	return $metabox_tabs;
}
add_filter( 'houzez_property_metabox_tabs', 'houzez_floor_plans_metabox_tab', 65 );


/**
 * Add floor_plans metaboxes fields
 *
 * @param $metabox_fields
 *
 * @return array
 */
function houzez_floor_plans_metabox_fields( $metabox_fields ) {
	$houzez_prefix = 'fave_';

	$fields = array(
		array(
	        'id'     => 'floor_plans',
	        // Gropu field
	        'type'   => 'group',
	        // Clone whole group?
	        'clone'  => true,
	        'sort_clone' => false,
	        'tab' => 'floor_plans',
	        // Sub-fields
	        'fields' => array(
	            array(
	                'name' => houzez_option('cl_plan_title', 'Plan Title' ),
	                'placeholder' => houzez_option('cl_plan_title_plac', 'Enter the title'),
	                'id'   => "{$houzez_prefix}plan_title",
	                'type' => 'text',
	                'columns' => 12,
	            ),
	            array(
	                'name' => houzez_option('cl_plan_bedrooms', 'Bedrooms' ),
	                'placeholder' => houzez_option('cl_plan_bedrooms_plac', 'Enter the number of bedrooms'),
	                'id'   => "{$houzez_prefix}plan_rooms",
	                'type' => 'text',
	                'columns' => 6,
	            ),
	            array(
	                'name' => houzez_option('cl_plan_bathrooms', 'Bathrooms' ),
	                'placeholder' => houzez_option('cl_plan_bathrooms_plac', 'Enter the number of bathrooms'),
	                'id'   => "{$houzez_prefix}plan_bathrooms",
	                'type' => 'text',
	                'columns' => 6,
	            ),
	            array(
	                'name' => houzez_option('cl_plan_price', 'Price' ),
	                'id'   => "{$houzez_prefix}plan_price",
	                'placeholder' => houzez_option('cl_plan_price_plac', 'Enter the price'),
	                'type' => 'text',
	                'columns' => 6,
	            ),
	            array(
	                'name' => houzez_option('cl_plan_price_postfix', 'Price Postfix' ),
	                'placeholder' => houzez_option('cl_plan_price_postfix_plac', 'Enter the price postfix'),
	                'id'   => "{$houzez_prefix}plan_price_postfix",
	                'type' => 'text',
	                'columns' => 6,
	            ),
	            array(
	                'name' => houzez_option('cl_plan_size', 'Plan Size' ),
	                'placeholder' => houzez_option('cl_plan_size_plac', 'Enter the plan size' ),
	                'id'   => "{$houzez_prefix}plan_size",
	                'type' => 'text',
	                'columns' => 6,
	            ),
	            array(
	                'name' => houzez_option('cl_plan_img', 'Plan Image'),
	                'id'   => "{$houzez_prefix}plan_image",
	                'placeholder' => houzez_option('cl_plan_img_plac', 'upload the plan image'),
	                'desc' => houzez_option('cl_plan_img_size', 'Minimum size 800 x 600 px'),
	                'type' => 'file_input',
	                'columns' => 6,
	            ),
	            array(
	                'name' => houzez_option('cl_plan_des', 'Description'),
	                'placeholder' => houzez_option('cl_plan_des_plac', 'Enter the plan description'),
	                'id'   => "{$houzez_prefix}plan_description",
	                'type' => 'textarea',
	                'columns' => 12,
	            ),

	        ),
	    ),
	);

	return array_merge( $metabox_fields, $fields );

}
add_filter( 'houzez_property_metabox_fields', 'houzez_floor_plans_metabox_fields', 65 );
