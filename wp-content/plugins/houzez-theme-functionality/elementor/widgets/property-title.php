<?php
namespace Elementor;
use Elementor\Widget_Heading;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Title extends Widget_Heading {


	public function get_name() {
		return 'houzez-property-title';
	}

	public function get_title() {
		return __( 'Property Title', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-post-title';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return [ 'houzez', 'property title', 'title', 'heading', 'property' ];
	}

	protected function _register_controls() {
		parent::_register_controls();

		$this->update_control(
			'title',
			[
				'dynamic' => [
					
					'default' => \Elementor\Plugin::$instance->dynamic_tags->tag_data_to_tag_text( null, 'houzez-property-title-tag' ),
				],
			],
			[
				'recursive' => true,
			]
		);

		$this->update_control(
			'header_size',
			[
				'default' => 'h1',
			]
		);
	}

	protected function get_html_wrapper_class() {
		return parent::get_html_wrapper_class() . ' elementor-page-title elementor-widget-' . parent::get_name();
	}

	protected function render() {
		$this->add_render_attribute( 'title', 'class', [ 'property_title' ] );
		echo '<div class="page-title">';
		parent::render();
		echo '</div>';
	}

	/**
	 * Render Houzez Property Title output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<# view.addRenderAttribute( 'title', 'class', [ 'property_title', 'item-title' ] ); #>
		<?php
		parent::content_template();
	}

	public function render_plain_content() {}
}
Plugin::instance()->widgets_manager->register_widget_type( new Property_Title );