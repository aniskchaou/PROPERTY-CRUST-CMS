<?php
/**
 * Add listing_rental metabox tab
 *
 * @param $metabox_tabs
 *
 * @return array
 */
function houzez_listing_rental_metabox_tab( $metabox_tabs ) {
	if ( is_array( $metabox_tabs ) ) {

		$metabox_tabs['listing_rental'] = array(
			'label' => houzez_option('cls_rental', 'Rental Details'),
            'icon' => 'dashicons-layout',
		);

	}
	return $metabox_tabs;
}
add_filter( 'houzez_property_metabox_tabs', 'houzez_listing_rental_metabox_tab', 95 );


/**
 * Add listing_rental metaboxes fields
 *
 * @param $metabox_fields
 *
 * @return array
 */
function houzez_listing_rental_metabox_fields( $metabox_fields ) {
	$houzez_prefix = 'fave_';

	$fields = array(
		array(
            'id' => "{$houzez_prefix}booking_shortcode",
            'name' => esc_html__('Booking Shortcode', 'houzez'),
            'desc' => esc_html__('Enter the booking form shortcode. Example [booking]', 'houzez'),
            'type' => 'text',
            'placeholder' => '[booking]',
            'std' => "",
            'columns' => 12,
            'tab' => 'listing_rental',
        )
	);

	return array_merge( $metabox_fields, $fields );

}
add_filter( 'houzez_property_metabox_fields', 'houzez_listing_rental_metabox_fields', 95 );
