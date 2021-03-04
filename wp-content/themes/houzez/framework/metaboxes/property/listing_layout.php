<?php
/**
 * Add listing_layout metabox tab
 *
 * @param $metabox_tabs
 *
 * @return array
 */
function houzez_listing_layout_metabox_tab( $metabox_tabs ) {
	if ( is_array( $metabox_tabs ) ) {

		$metabox_tabs['listing_layout'] = array(
			'label' => houzez_option('cls_layout', 'Layout'),
            'icon' => 'dashicons-laptop',
		);

	}
	return $metabox_tabs;
}
add_filter( 'houzez_property_metabox_tabs', 'houzez_listing_layout_metabox_tab', 90 );


/**
 * Add listing_layout metaboxes fields
 *
 * @param $metabox_fields
 *
 * @return array
 */
function houzez_listing_layout_metabox_fields( $metabox_fields ) {
	$houzez_prefix = 'fave_';

	$fields = array(
		array(
            'id' => "{$houzez_prefix}single_top_area",
            'name' => esc_html__('Property Top Type', 'houzez'),
            'desc' => esc_html__('Set the property top area type.', 'houzez'),
            'type' => 'select',
            'std' => "global",
            'options' => array(
                'global' => esc_html__( 'Global', 'houzez' ),
                'v1' => esc_html__( 'Version 1', 'houzez' ),
                'v2' => esc_html__( 'Version 2', 'houzez' ),
                'v3' => esc_html__( 'Version 3', 'houzez' ),
                'v4' => esc_html__( 'Version 4', 'houzez' ),
                'v5' => esc_html__( 'Version 5', 'houzez' ),
                'v6' => esc_html__( 'Version 6', 'houzez' )
            ),
            'columns' => 12,
            'tab' => 'listing_layout'
        ),
        array(
            'id' => "{$houzez_prefix}single_content_area",
            'name' => esc_html__('Property Content Layout', 'houzez'),
            'desc' => esc_html__('Set property content area type.', 'houzez'),
            'type' => 'select',
            'std' => "global",
            'options' => array(
                'global' => esc_html__( 'Global', 'houzez' ),
                'simple' => esc_html__( 'Default', 'houzez' ),
                'tabs'   => esc_html__( 'Tabs', 'houzez' ),
                'tabs-vertical' => esc_html__( 'Tabs Vertical', 'houzez' ),
                'v2' => esc_html__( 'Luxury Homes', 'houzez' )
            ),
            'columns' => 12,
            'tab' => 'listing_layout'
        ),
	);

	return array_merge( $metabox_fields, $fields );

}
add_filter( 'houzez_property_metabox_fields', 'houzez_listing_layout_metabox_fields', 90 );
