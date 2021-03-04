<?php
/**
 * Add home_slider metabox tab
 *
 * @param $metabox_tabs
 *
 * @return array
 */
function houzez_home_slider_metabox_tab( $metabox_tabs ) {
	if ( is_array( $metabox_tabs ) ) {

		$metabox_tabs['home_slider'] = array(
			'label' => houzez_option('cls_slider', 'Slider'),
            'icon' => 'dashicons-images-alt',
		);

	}
	return $metabox_tabs;
}
add_filter( 'houzez_property_metabox_tabs', 'houzez_home_slider_metabox_tab', 60 );


/**
 * Add home_slider metaboxes fields
 *
 * @param $metabox_fields
 *
 * @return array
 */
function houzez_home_slider_metabox_fields( $metabox_fields ) {
	$houzez_prefix = 'fave_';

	$fields = array(
		array(
            'name' => houzez_option('cl_add_slider', 'Do you want to display this property on the custom property slider?'),
            'id' => "{$houzez_prefix}prop_homeslider",
            'desc' => houzez_option('cl_add_slider_plac', 'Upload an image below if you selected yes.'),
            'type' => 'radio',
            'std' => 'no',
            'options' => array(
                'yes' => houzez_option('cl_yes', 'Yes '),
                'no' => houzez_option('cl_no', 'No')
            ),
            'columns' => 12,
            'tab' => 'home_slider',
        ),
        array(
            'name' => houzez_option('cl_slider_img', 'Slider Image'),
            'id' => "{$houzez_prefix}prop_slider_image",
            'desc' => houzez_option('cl_slider_img_size', 'Suggested size 2000px x 700px'),
            'type' => 'image_advanced',
            'max_file_uploads' => 1,
            'columns' => 12,
            'tab' => 'home_slider',
        ),
	);

	return array_merge( $metabox_fields, $fields );

}
add_filter( 'houzez_property_metabox_fields', 'houzez_home_slider_metabox_fields', 60 );
