<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Houzez_Item_Tools extends Widget_Base {

	public function get_name() {
		return 'houzez-property-tools';
	}

	public function get_title() {
		return __( 'Share, Favorite', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-favorite';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return [ 'houzez', 'share', 'favourite', 'favorite', 'property' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_share_content',
			[
				'label' => __( 'Content', 'houzez-theme-functionality' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
            'show_share',
            [
                'label' => esc_html__( 'Share Button', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_print',
            [
                'label' => esc_html__( 'Print Button', 'houzez-theme-functionality' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'houzez-theme-functionality' ),
                'label_off' => esc_html__( 'No', 'houzez-theme-functionality' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
			'share_align',
			[
				'label' => __( 'Alignment', 'houzez-theme-functionality' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'right',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'houzez-theme-functionality' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'houzez-theme-functionality' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'houzez-theme-functionality' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} ul.ele-item-tools' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		
		global $post; 
		$settings = $this->get_settings();

		$key = '';
		$userID      =   get_current_user_id();
		$fav_option = 'houzez_favorites-'.$userID;
		$fav_option = get_option( $fav_option );
		if( !empty($fav_option) ) {
		    $key = array_search($post->ID, $fav_option);
		}

		$icon = '';
		if( $key != false || $key != '' ) {
		    $icon = 'text-danger';
		}

		?>
		<ul class="ele-item-tools">

		    <?php if( $settings['show_print'] == 'yes' ) { ?>
		    <li class="item-tool">
		        <span class="add-favorite-js item-tool-favorite" data-listid="<?php echo intval($post->ID)?>">
		            <i class="houzez-icon icon-love-it <?php echo esc_attr($icon); ?>"></i>
		        </span><!-- item-tool-favorite -->
		    </li><!-- item-tool -->
		    <?php } ?>

		    <?php if( $settings['show_share'] == 'yes' ) { ?>
		    <li class="item-tool">
		        <span class="item-tool-share dropdown-toggle" data-toggle="dropdown">
		            <i class="houzez-icon icon-share"></i>
		        </span><!-- item-tool-favorite -->
		        <div class="dropdown-menu dropdown-menu-right item-tool-dropdown-menu">
		            <?php get_template_part('property-details/partials/share'); ?>
		        </div>
		    </li><!-- item-tool -->
		    <?php } ?>
		</ul><!-- item-tools -->

	<?php
	}

	public function render_plain_content() {}
}
Plugin::instance()->widgets_manager->register_widget_type( new Houzez_Item_Tools );
