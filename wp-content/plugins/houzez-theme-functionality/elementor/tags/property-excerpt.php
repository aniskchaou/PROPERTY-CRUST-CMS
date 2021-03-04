<?php
Class Property_Excerpt_Tag extends \Elementor\Core\DynamicTags\Tag {

	public function get_name() {
		return 'houzez-property-excerpt-tag';
	}

	public function get_title() {
		return __( 'Property Excerpt', 'houzez-theme-functionality' );
	}

	public function get_group() {
		return Houzez_Elementor_Extensions::HOUZEZ_GROUP;
	}

	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
	}

	public function render() {
		// Allow only a real `post_excerpt` and not the trimmed `post_content` from the `get_the_excerpt` filter
		$post = get_post();

		if ( ! $post || empty( $post->post_excerpt ) ) {
			return;
		}

		echo wp_kses_post( $post->post_excerpt );
	}
}
