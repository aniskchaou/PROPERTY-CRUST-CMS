<?php
/**
 * Add information metabox tab
 *
 * @param $metabox_tabs
 *
 * @return array
 */
function houzez_information_metabox_tab( $metabox_tabs ) {
	if ( is_array( $metabox_tabs ) ) {

		$metabox_tabs['property_details'] = array(
			'label' => houzez_option('cls_information', 'Information'),
			'icon'  => 'dashicons-admin-home',
		);

	}
	return $metabox_tabs;
}
add_filter( 'houzez_property_metabox_tabs', 'houzez_information_metabox_tab', 10 );


/**
 * Add information metaboxes fields
 *
 * @param $metabox_fields
 *
 * @return array
 */
function houzez_information_metabox_fields( $metabox_fields ) {
	$houzez_prefix = 'fave_';

	$currency_hidden = 'multi_currency';
    $multi_currency = houzez_option('multi_currency');

    $id_pattern = '';
    if( houzez_option('auto_property_id', 0) ) {
        $id_pattern = houzez_option('property_id_pattern', '{0}');
    }

    $multi_currency_field = array();
    if($multi_currency == 1 ) {
        $multi_currency_field = array(
                'id' => "{$houzez_prefix}currency",
                'name' => esc_html__('Currency', 'houzez'),
                'type' => 'select',
                'options' => houzez_available_currencies(),
                'std' => houzez_option('default_multi_currency'),
                'columns' => 6,
                'tab' => 'property_details',
            );
    } else {
        $multi_currency_field = array(
                'id' => "hhh_divider",
                'type' => 'divider',
                'columns' => 12,
                'class' => 'houzez_hidden',
                'tab' => 'property_details',
            );
    }

	$fields = array(
        $multi_currency_field,
		array(
            'id' => "{$houzez_prefix}property_price",
            'name' => houzez_option('cl_sale_price', 'Sale or Rent Price'),
            'desc' => '',
            'placeholder' => houzez_option('cl_sale_price_plac', 'Enter the price'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_sec_price",
            'name' => houzez_option('cl_second_price', 'Second Price (Optional)'),
            'desc' => '',
            'placeholder' => houzez_option('cl_second_price_plac', 'Enter the second price'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_price_prefix",
            'name' => houzez_option('cl_price_prefix', 'Price Prefix'),
            'desc' => houzez_option('cl_price_prefix_tooltip', 'For example: Start from'),
            'placeholder' => houzez_option('cl_price_prefix_plac', 'Enter the price prefix'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_price_postfix",
            'name' => houzez_option('cl_price_postfix', 'After The Price Label'),
            'desc' => houzez_option('cl_price_postfix_tooltip', 'For example: Monthly'),
            'placeholder' => houzez_option('cl_price_postfix_plac', 'Enter the label after price'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),

        array(
            'id' => "{$houzez_prefix}property_size",
            'name' => houzez_option('cl_area_size', 'Area Size'),
            'desc' => houzez_option('cl_only_digits', 'Only digits'),
            'placeholder' => houzez_option('cl_area_size_plac', 'Enter property area size'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_size_prefix",
            'name' => houzez_option('cl_area_size_postfix', 'Size Postfix'),
            'desc' => houzez_option('cl_area_size_postfix_tooltip', 'For example: Sq Ft'),
            'placeholder' => houzez_option('cl_area_size_postfix_plac', 'Enter the size postfix'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_land",
            'name' => houzez_option('cl_land_size', 'Land Area'),
            'desc' => houzez_option('cl_only_digits', 'Only digits'),
            'placeholder' => houzez_option('cl_land_size_plac', 'Enter property land area size'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_land_postfix",
            'name' => houzez_option('cl_land_size_postfix', 'Land Area Size Postfix'),
            'desc' => houzez_option('cl_land_size_postfix_tooltip', 'For example: Sq Ft'),
            'placeholder' => houzez_option('cl_land_size_postfix_plac', 'Enter property land area postfix'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_bedrooms",
            'name' => houzez_option('cl_bedrooms', 'Bedrooms'),
            'placeholder' => houzez_option('cl_bedrooms_plac', 'Bedrooms'),
            'desc' => houzez_option('cl_only_digits', 'Only digits'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_rooms",
            'name' => houzez_option('cl_rooms', 'Rooms'),
            'placeholder' => houzez_option('cl_rooms_plac', 'Rooms'),
            'desc' => houzez_option('cl_only_digits', 'Only digits'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_bathrooms",
            'name' => houzez_option('cl_bathrooms', 'Bathrooms'),
            'placeholder' => houzez_option('cl_bathrooms_plac', 'Bathrooms'),
            'desc' => houzez_option('cl_only_digits', 'Only digits'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        
        array(
            'id' => "{$houzez_prefix}property_garage",
            'name' => houzez_option('cl_garage', 'Garages'),
            'placeholder' => houzez_option('cl_garage_plac', 'Garages'),
            'desc' => houzez_option('cl_only_digits', 'Only digits'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_garage_size",
            'name' => houzez_option('cl_garage_size', 'Garages Size'),
            'placeholder' => houzez_option('cl_garage_size_plac', 'Garages Size'),
            'desc' => houzez_option('cl_garage_size_tooltip', 'For example: 200 Sq Ft'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_year",
            'name' => houzez_option('cl_year_built', 'Year Built'),
            'placeholder' => houzez_option('cl_year_built_plac', 'Year Built'),
            'desc' => houzez_option('cl_only_digits', 'Only digits'),
            'type' => 'text',
            'std' => "",
            'columns' => 6,
            'tab' => 'property_details',
        ),
        array(
            'id' => "{$houzez_prefix}property_id",
            'name' => houzez_option('cl_prop_id', 'Property ID'),
            'desc' => houzez_option('cl_prop_id_tooltip', 'For example: HZ-01'),
            'placeholder' => houzez_option('cl_prop_id_plac', 'Enter property ID'),
            'type' => 'text',
            'std' => $id_pattern,
            'columns' => 6,
            'attributes' => array(
                'readonly' => ( 1 == houzez_option( 'auto_property_id' ) ) ? true : false,
            ),
            'tab' => 'property_details',
        ),
	);

	return array_merge( $metabox_fields, $fields );

}
add_filter( 'houzez_property_metabox_fields', 'houzez_information_metabox_fields', 10 );
