<?php
/**
 * Add private_note metabox tab
 *
 * @param $metabox_tabs
 *
 * @return array
 */
function houzez_private_note_metabox_tab( $metabox_tabs ) {
	if ( is_array( $metabox_tabs ) ) {

		$metabox_tabs['private_note'] = array(
			'label' => houzez_option('cls_private_notes', 'Private Note'),
            'icon' => 'dashicons-lightbulb',
		);

	}
	return $metabox_tabs;
}
add_filter( 'houzez_property_metabox_tabs', 'houzez_private_note_metabox_tab', 75 );


/**
 * Add private_note metaboxes fields
 *
 * @param $metabox_fields
 *
 * @return array
 */
function houzez_private_note_metabox_fields( $metabox_fields ) {
	$houzez_prefix = 'fave_';

	$fields = array(
		array(
            'id' => "{$houzez_prefix}private_note",
            'name' => houzez_option('cls_private_notes', 'Private Note'),
            'placeholder' => houzez_option('cl_private_note', 'Enter the note here'),
            'desc' => houzez_option('cl_private_note', 'Write private note for this property, it will not display for public.'),
            'type' => 'textarea',
            'mime_type' => '',
            'columns' => 12,
            'tab' => 'private_note',
        ),
	);

	return array_merge( $metabox_fields, $fields );

}
add_filter( 'houzez_property_metabox_fields', 'houzez_private_note_metabox_fields', 75 );
