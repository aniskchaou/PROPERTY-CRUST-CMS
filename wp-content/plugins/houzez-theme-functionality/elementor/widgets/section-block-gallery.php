<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Property_Section_Block_Gallery extends \Elementor\Widget_Base {

    
	public function get_name() {
		return 'houzez-property-section-block-gallery';
	}

	public function get_title() {
		return __( 'Section Block Gallery', 'houzez-theme-functionality' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'houzez-single-property' ];
	}

	public function get_keywords() {
		return ['property', 'Block Gallery', 'houzez' ];
	}

	protected function _register_controls() {
		parent::_register_controls();


		$this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'houzez-theme-functionality' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'visible_images',
            [
                'label' => esc_html__( 'Visible Images', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '9',
            ]
        );

        $this->add_control(
            'images_in_row',
            [
                'label' => esc_html__( 'Images in a row', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => array(
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ),
            ]
        );

        $this->add_control(
            'popup_type',
            [
                'label' => esc_html__( 'Popup Type', 'houzez-theme-functionality' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'elementor',
                'options' => array(
                    'elementor' => 'Elementor',
                    'houzez' => 'Houzez',
                ),
            ]
        );

        $this->end_controls_section();


	}

	protected function render() {
        global $post;
		$settings = $this->get_settings_for_display();
        $visible_images = $settings['visible_images'];
        $images_in_row = $settings['images_in_row'];

        if( empty($visible_images) ) {
            $visible_images = 9;
        }

        $percentage = 100 / $images_in_row;

        $size = 'houzez-item-image-1';
        $properties_images = rwmb_meta( 'fave_property_images', 'type=plupload_image&size='.$size, $post->ID );

        $i = 0;

        if( !empty($properties_images) && count($properties_images)) {

            $total_images = count($properties_images);
            $remaining_images = $total_images - $visible_images;
        ?>
        <div class="property-gallery-grid property-section-wrap" id="property-gallery-grid">        
            <div class="d-flex flex-wrap">

                <?php 
                foreach( $properties_images as $image ) { $i++; 
                ?>
                <a <?php if($settings['popup_type'] == 'elementor') { ?>href="<?php echo esc_url($image['full_url']);?>" <?php } ?> data-toggle="modal" data-target="#property-lightbox" class="gallery-grid-item <?php if($i == $visible_images){ echo 'more-images'; } elseif($i > $visible_images) {echo 'gallery-hidden'; } ?>">
                    <?php if( $i == $visible_images ){ echo '<span>'.$remaining_images.'+</span>'; } ?>
                    <img class="img-fluid" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                </a>
                <?php } ?>
                
            </div>
        </div><!-- property-gallery-grid -->
        <style> 
            .property-gallery-grid .gallery-grid-item {
                max-width: calc(<?php echo $percentage; ?>% - 1px);
                margin-right: 1px;
                margin-bottom: 1px;
            }
        </style>
        <?php 
        }     
	}

}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Property_Section_Block_Gallery() );