<?php
class houzez_Code_Banner extends WP_Widget {
	
	
	/**
	 * Register widget
	**/
	public function __construct() {
		
		parent::__construct(
	 		'houzez_code_banner', // Base ID
			esc_html__( 'HOUZEZ: Code Banner', 'houzez' ), // Name
			array( 'description' => esc_html__( 'Paste your banner JS or Google Adsense code', 'houzez' ), ) // Args
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
		$banner_code = $instance['banner_code'];
		$hide_title = isset( $instance['hide_title'] ) ? $instance['hide_title'] : false;
		
		echo wp_kses( $before_widget, $allowed_html_array );
			
			if ( ! $hide_title )
			if ( $title ) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );
            
			echo '<div class="widget-body">';
				echo '<div class="widget-content">';
        				
        			print ( $instance['banner_code'] );

        		echo '</div>';
        	echo '</div>';
            
	    
		echo wp_kses( $after_widget, $allowed_html_array );
		
	}
	
	
	/**
	 * Sanitize widget form values as they are saved
	**/
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();

		/* Strip tags to remove HTML. For text inputs and textarea. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['banner_code'] = $new_instance['banner_code'];
		$instance['hide_title'] = $new_instance['hide_title'];
		
		return $instance;
		
	}
	
	
	/**
	 * Back-end widget form
	**/
	public function form( $instance ) {
		
		/* Default widget settings. */
		$defaults = array(
			'title' => 'Ad Code',
			'banner_code' => 'Paste you code here...',
			'hide_title' => false
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'banner_code' ) ); ?>"><?php esc_html_e('JS or Google AdSense Code', 'houzez'); ?></label>
			<textarea id="<?php echo esc_attr( $this->get_field_id( 'banner_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'banner_code' ) ); ?>" class="widefat" style="height:70px;"><?php echo esc_textarea( $instance['banner_code'] ); ?></textarea>
		</p>
        <p>
			<input class="checkbox" type="checkbox" <?php if( $instance['hide_title'] == true ) echo 'checked'; ?> id="<?php echo esc_attr( $this->get_field_id( 'hide_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_title' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_title' ) ); ?>"><?php esc_html_e( 'Do not display the title', 'houzez' ); ?></label>
		</p>
	<?php
	}

}

if ( ! function_exists( 'houzez_Code_Banner_loader' ) ) {
    function houzez_Code_Banner_loader (){
     register_widget( 'houzez_Code_Banner' );
    }
     add_action( 'widgets_init', 'houzez_Code_Banner_loader' );
}