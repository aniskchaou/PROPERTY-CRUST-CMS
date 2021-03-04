<?php
/**
 * Add media metabox tab
 *
 * @param $metabox_tabs
 *
 * @return array
 */
function houzez_media_metabox_tab( $metabox_tabs ) {
	if ( is_array( $metabox_tabs ) ) {

		$metabox_tabs['gallery'] = array(
			'label' => houzez_option('cls_media', 'Property Media'),
            'icon' => 'dashicons-format-gallery',
		);

	}
	return $metabox_tabs;
}
add_filter( 'houzez_property_metabox_tabs', 'houzez_media_metabox_tab', 40 );


/**
 * Add media metaboxes fields
 *
 * @param $metabox_fields
 *
 * @return array
 */
function houzez_media_metabox_fields( $metabox_fields ) {
	$houzez_prefix = 'fave_';

	$fields = array(
		array(
            'name' => houzez_option('cl_image_btn', 'Select and Upload'),
            'id' => "{$houzez_prefix}property_images",
            'desc' => houzez_option('cl_image_size', '(Minimum size 1440x900)'),
            'type' => 'image_advanced',
            'max_file_uploads' => houzez_option('max_prop_images', 50),
            'columns' => 12,
            'tab' => 'gallery',
        ),

        array(
            'id' => "{$houzez_prefix}video_url",
            'name' => houzez_option('cl_video_url', 'Video URL'),
            'placeholder' => houzez_option('cl_video_url_plac', 'YouTube, Vimeo, SWF File and MOV File are supported'),
            'desc' => houzez_option('cl_example', 'For example').' https://www.youtube.com/watch?v=49d3Gn41IaA',
            'type' => 'text',
            'columns' => 12,
            'tab' => 'gallery',
        ),
	);

	return array_merge( $metabox_fields, $fields );

}
add_filter( 'houzez_property_metabox_fields', 'houzez_media_metabox_fields', 40 );
