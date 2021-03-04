<?php
/**
 * Redux Framework media config.
 * For full documentation, please visit: http://docs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

Redux::set_section(
	$opt_name,
	array(
		'title'      => esc_html__( 'Media', 'your-textdomain-here' ),
		'id'         => 'media-media',
		'desc'       => esc_html__( 'For full documentation on this field, visit: ', 'your-textdomain-here' ) . '<a href="//docs.redux.io/core/fields/media/" target="_blank">docs.redux.io/core/fields/media/</a>',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'           => 'opt-media',
				'type'         => 'media',
				'url'          => true,
				'title'        => esc_html__( 'Media w/ URL', 'your-textdomain-here' ),
				'compiler'     => 'true',
				'desc'         => esc_html__( 'Basic media uploader with disabled URL input field.', 'your-textdomain-here' ),
				'subtitle'     => esc_html__( 'Upload any media using the WordPress native uploader', 'your-textdomain-here' ),
				'preview_size' => 'full',
			),
			array(
				'id'       => 'media-no-url',
				'type'     => 'media',
				'title'    => esc_html__( 'Media w/o URL', 'your-textdomain-here' ),
				'desc'     => esc_html__( 'This represents the minimalistic view. It does not have the preview box or the display URL in an input box. ', 'your-textdomain-here' ),
				'subtitle' => esc_html__( 'Upload any media using the WordPress native uploader', 'your-textdomain-here' ),
				'url'      => false,
				'preview'  => false,
			),
			array(
				'id'       => 'media-no-preview',
				'type'     => 'media',
				'preview'  => false,
				'title'    => esc_html__( 'Media No Preview', 'your-textdomain-here' ),
				'desc'     => esc_html__( 'This represents the minimalistic view. It does not have the preview box or the display URL in an input box. ', 'your-textdomain-here' ),
				'subtitle' => esc_html__( 'Upload any media using the WordPress native uploader', 'your-textdomain-here' ),
				'hint'     => array(
					'title'   => esc_html__( 'Test Hint', 'your-textdomain-here' ),
					'content' => wp_kses_post( 'This is a <b>hint</b> tool-tip for the webFonts field.<br/><br/>Add any HTML based text you like here.' ),
				),
			),
			array(
				'id'         => 'opt-random-upload',
				'type'       => 'media',
				'title'      => esc_html__( 'Upload Anything - Disabled Mode', 'your-textdomain-here' ),
				'full_width' => true,

				// Can be set to false to allow any media type, or can also be set to any mime type.
				'mode'       => false,

				'desc'       => esc_html__( 'Basic media uploader with disabled URL input field.', 'your-textdomain-here' ),
				'subtitle'   => esc_html__( 'Upload any media using the WordPress native uploader', 'your-textdomain-here' ),
			),
		),
	)
);
