<?php
/*
 * Widget Name: Image Banner
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 */

class houzez_Image_Banner_300_250 extends WP_Widget {
	
	
	/**
	 * Register widget
	**/
	public function __construct() {
		
		parent::__construct(
	 		'houzez_image_banner_300_250', // Base ID
			esc_html__( 'HOUZEZ: Image Banner 300x250', 'houzez' ), // Name
			array( 'description' => esc_html__( 'Add image banner 300x300 or 300x250', 'houzez' ), ) // Args
		);
		
	}

	
	/**
	 * Front-end display of widget
	**/
	public function widget( $args, $instance ) {
				
		extract( $args );

		$allowed_html_array = array(
			'div' => array(
				'id' => array(),
				'class' => array()
			),
			'h3' => array(
				'class' => array()
			)
		);

		$title = apply_filters('widget_title', $instance['title'] );
		$banner_url = $instance['banner_url'];
		$banner_link = $instance['banner_link'];
		$hide_title = isset( $instance['hide_title'] ) ? $instance['hide_title'] : false;
		
		echo wp_kses( $before_widget, $allowed_html_array );
			
			if ( ! $hide_title )
			if ( $title ) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );
            ?>
            
            <div class="widget-body">
				<div class="widget-content">
					<a href="<?php echo esc_url( $instance['banner_link'] ); ?>" rel="nofollow" target="_blank">
		            	<img class="img-fluid" src="<?php echo esc_url( $instance['banner_url'] ); ?>" width="300" height="250" alt="Ad" />
		            </a>
				</div><!-- widget-content -->
			</div><!-- widget-body -->
            
	    <?php 
		echo wp_kses( $after_widget, $allowed_html_array );
		
	}
	
	
	/**
	 * Sanitize widget form values as they are saved
	**/
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();

		/* Strip tags to remove HTML. For text inputs and textarea. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['banner_url'] = strip_tags( $new_instance['banner_url'] );
		$instance['banner_link'] = strip_tags( $new_instance['banner_link'] );
		$instance['hide_title'] = $new_instance['hide_title'];
		
		return $instance;
		
	}
	
	
	/**
	 * Back-end widget form
	**/
	public function form( $instance ) {
		
		/* Default widget settings. */
		$defaults = array(
			'title' => 'Image Ad',
			'banner_url' => 'http://',
			'banner_link' => '#',
			'hide_title' => false
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'banner_url' ) ); ?>"><?php esc_html_e('Image Banner URL:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'banner_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'banner_url' ) ); ?>" value="<?php echo esc_url( $instance['banner_url'] ); ?>" class="widefat" />
		</p>
        <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'banner_link' ) ); ?>"><?php esc_html_e('Image Banner Link:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'banner_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'banner_link' ) ); ?>" value="<?php echo esc_url( $instance['banner_link'] ); ?>" class="widefat" />
		</p>
        <p>
			<input class="checkbox" type="checkbox" <?php if( $instance['hide_title'] == true ) echo 'checked'; ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_title' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_title' ) ); ?>"><?php esc_html_e( 'Do not display the title', 'houzez' ); ?></label>
		</p>
	<?php
	}

}
if ( ! function_exists( 'houzez_Image_Banner_300_250_loader' ) ) {
    function houzez_Image_Banner_300_250_loader (){
     register_widget( 'houzez_Image_Banner_300_250' );
    }
     add_action( 'widgets_init', 'houzez_Image_Banner_300_250_loader' );
}
