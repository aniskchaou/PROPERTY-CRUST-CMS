<?php
/**
 * Add multi_units metabox tab
 *
 * @param $metabox_tabs
 *
 * @return array
 */
function houzez_multi_units_metabox_tab( $metabox_tabs ) {
	if ( is_array( $metabox_tabs ) ) {

		$metabox_tabs['multi_units'] = array(
			'label' => houzez_option('cls_sub_listings', 'Sub Listings'),
            'icon' => 'dashicons-layout',
		);

	}
	return $metabox_tabs;
}
add_filter( 'houzez_property_metabox_tabs', 'houzez_multi_units_metabox_tab', 61 );


/**
 * Add multi_units metaboxes fields
 *
 * @param $metabox_fields
 *
 * @return array
 */
function houzez_multi_units_metabox_fields( $metabox_fields ) {
	$houzez_prefix = 'fave_';

	$fields = array(
		array(
            'id' => "{$houzez_prefix}multi_units_ids",
            'name' => houzez_option('cl_subl_ids', 'Listing IDs'),
            'placeholder' => houzez_option('cl_subl_ids_plac', 'Enter the listing IDs comma separated'),
            'desc' => houzez_option('cl_subl_ids_tooltip', 'If the sub-properties are separated listings, use the box above to enter the listing IDs (Example: 4,5,6)'),
            'type' => 'textarea',
            'columns' => 12,
            'tab' => 'multi_units',
        ),
        array(
            'type' => 'heading',
            'name' => houzez_option('cl_or', 'Or'),
            'columns' => 12,
            'desc' => "",
            'tab' => 'multi_units',
        ),
        array(
            'id'     => "{$houzez_prefix}multi_units",
            // Gropu field
            'type'   => 'group',
            // Clone whole group?
            'clone'  => true,
            'sort_clone' => false,
            'tab' => 'multi_units',
            // Sub-fields
            'fields' => array(
                array(
                    'name' => houzez_option('cl_subl_title', 'Title' ),
                    'id'   => "{$houzez_prefix}mu_title",
                    'type' => 'text',
                    'placeholder' => houzez_option('cl_subl_title_plac', 'Enter the title'),
                    'columns' => 12,
                ),
                array(
                    'name' => houzez_option('cl_subl_price', 'Price' ),
                    'id'   => "{$houzez_prefix}mu_price",
                    'placeholder' => houzez_option('cl_subl_price_plac', 'Enter the price'),
                    'type' => 'text',
                    'columns' => 6,
                ),
                array(
                    'name' => houzez_option('cl_subl_price_postfix', 'Price Postfix' ),
                    'id'   => "{$houzez_prefix}mu_price_postfix",
                    'placeholder' => houzez_option('cl_subl_price_postfix_plac', 'Enter the price postfix'),
                    'type' => 'text',
                    'columns' => 6,
                ),
                array(
                    'name' => houzez_option('cl_subl_bedrooms', 'Bedrooms' ),
                    'id'   => "{$houzez_prefix}mu_beds",
                    'placeholder' => houzez_option('cl_subl_bedrooms', 'Enter the number of bedrooms'),
                    'type' => 'text',
                    'columns' => 6,
                ),
                array(
                    'name' => houzez_option('cl_subl_bathrooms', 'Bathrooms' ),
                    'id'   => "{$houzez_prefix}mu_baths",
                    'placeholder' => houzez_option('cl_subl_bathrooms_plac', 'Enter the number of bathrooms'),
                    'type' => 'text',
                    'columns' => 6,
                ),
                array(
                    'name' => houzez_option('cl_subl_size', 'Property Size' ),
                    'id'   => "{$houzez_prefix}mu_size",
                    'placeholder' => houzez_option('cl_subl_size', 'Enter the property size'),
                    'type' => 'text',
                    'columns' => 6,
                ),
                array(
                    'name' => houzez_option('cl_subl_size_postfix', 'Size Postfix' ),
                    'id'   => "{$houzez_prefix}mu_size_postfix",
                    'placeholder' => houzez_option('cl_subl_size_postfix_plac', 'Enter the property size postfix'),
                    'type' => 'text',
                    'columns' => 6,
                ),
                array(
                    'name' => houzez_option('cl_subl_type', 'Property Type' ),
                    'id'   => "{$houzez_prefix}mu_type",
                    'placeholder' => houzez_option('cl_subl_type_plac', 'Enter the property type'),
                    'type' => 'text',
                    'columns' => 6,
                ),
                array(
                    'name' => houzez_option('cl_subl_date', 'Availability Date' ),
                    'id'   => "{$houzez_prefix}mu_availability_date",
                    'placeholder' => houzez_option('cl_subl_date_plac', 'Enter the availability date'),
                    'type' => 'text',
                    'columns' => 6,
                ),

            ),
        ),
	);

	return array_merge( $metabox_fields, $fields );

}
add_filter( 'houzez_property_metabox_fields', 'houzez_multi_units_metabox_fields', 61 );
