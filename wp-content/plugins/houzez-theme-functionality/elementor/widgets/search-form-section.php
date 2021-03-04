<?php
namespace Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Houzez_Search_Form_Section {

	public static $instance = null;

	public function __construct() {
		$this->add_actions();
	}

	public function add_actions() {
		add_action( 'elementor/element/after_section_end', Array( $this, 'register_controls' ), 10, 3 );
		add_action( 'elementor/frontend/section/before_render', Array( $this, 'before_render' ), 10, 1 );
		add_action( 'elementor/frontend/section/after_render', Array( $this, 'after_render' ), 10, 1 );
	}

	public function register_controls( $element, $section_id, $args ) {
		if( ! in_array( $section_id, Array( /* 'layout' , */'section_layout' ) ) ) {
			return;
		}

		$element->start_controls_section( 'section_houzez_settings', Array(
			'label' => esc_html__( "Houzez Section Settings", 'houzez-theme-functionality' ),
			'tab' => Controls_Manager::TAB_LAYOUT,
		) );


		$element->add_control( 'houzez_search_form', Array(
			'label' => esc_html__( "Houzez Search Form container?", 'houzez-theme-functionality' ),
			'type' => Controls_Manager::SWITCHER,
			'default' => '',
			'return_value' => 'yes',
		) );


		$element->end_controls_section();

	}

	public function before_render( $element ) {
		$settings = $element->get_settings();
		if( $this->is_search_form_section( $element ) ) {
		?>
		<form class="houzez-search-form-js" method="get" autocomplete="off" action="<?php echo esc_url( houzez_get_search_template_link() ); ?>">
		<?php
		}

	}

	public function after_render( $element ) {
		$settings = $element->get_settings();
		if( $this->is_search_form_section( $element ) ) {
			echo '</form>';
		}
		
	}

	public function is_search_form_section( $element ) {
		if( ! in_array( $element->get_name(), Array( 'section' ) ) ) {
			return false;
		}
		$settings = $element->get_settings();
		return isset( $settings[ 'houzez_search_form' ] ) && 'yes' === $settings[ 'houzez_search_form' ];
	}
	
	public static function getInstance() {
		if( is_null( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}

if( ! function_exists( 'Houzez_search_container' ) ) {
	function Houzez_search_container() {
		return Houzez_Search_Form_Section::getInstance();
	}
	Houzez_search_container();
}