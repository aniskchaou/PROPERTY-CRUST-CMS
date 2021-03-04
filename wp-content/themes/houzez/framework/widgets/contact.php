<?php
class houzez_contact_us extends WP_Widget {
	
	
	/**
	 * Register widget
	**/
	public function __construct() {
		
		parent::__construct(
	 		'houzez_contact', // Base ID
			esc_html__( 'HOUZEZ: Contact Us', 'houzez' ), // Name
			array( 'description' => esc_html__( 'Contact us widget', 'houzez' ), 'classname' => 'widget-contact-us' ) // Args
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
		$about_text = $instance['about_text'];
		$address = $instance['address'];
		$phone = $instance['phone'];
		$fax = isset($instance['fax']) ? $instance['fax'] : '';
		$email = $instance['email'];
		$more_url = $instance['more_url'];
		
		echo wp_kses( $before_widget, $allowed_html_array );
			
			
			if ( $title ) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );
			?>

			<div class="widget-body">
				<div class="widget-content">
					<p><?php echo wp_kses_post( $about_text ); ?></p>
					<ul class="list-unstyled contact-list">
						<?php if( !empty($address) ) { ?>
	                    <li><i class="houzez-icon icon-pin mr-1"></i> <?php echo esc_attr( $address ); ?></li>
	                    <?php } ?>

	                    <?php if( !empty($phone) ) { ?>
	                    <li><i class="houzez-icon icon-phone mr-1"></i> <?php echo esc_attr( $phone ); ?></li>
	                    <?php } ?>

						<?php if( !empty($fax) ) { ?>
							<li><i class="houzez-icon icon-answer-machine mr-1"></i> <?php echo esc_attr( $fax ); ?></li>
						<?php } ?>

	                    <?php if( !empty($email) ) { ?>
	                    <li><i class="houzez-icon icon-envelope mr-1"></i> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ); ?></a></li>
	                    <?php } ?>
					</ul>
				</div><!-- widget-content -->

				<?php if( !empty($more_url) ) { ?>
				<div class="widget-read-more">
					<a href="<?php echo esc_url( $more_url ); ?>"><?php esc_html_e( 'Contact us', 'houzez' ); ?></a>
				</div><!-- widget-read-more -->
				<?php } ?>

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
		$instance['about_text'] = $new_instance['about_text'];
		$instance['phone'] = strip_tags( $new_instance['phone'] );
		$instance['fax'] = strip_tags( $new_instance['fax'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['address'] = strip_tags( $new_instance['address'] );
		$instance['more_url'] = strip_tags( $new_instance['more_url'] );
		
		return $instance;
		
	}
	
	
	/**
	 * Back-end widget form
	**/
	public function form( $instance ) {
		
		/* Default widget settings. */
		$defaults = array(
			'title' => 'Contact Us',
			'address' => '',
			'phone' => '',
			'fax' => '',
			'email' => '',
			'about_text' => '',
			'more_url' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'about_text' )); ?>"><?php esc_html_e('Text:', 'houzez'); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'about_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'about_text' ) ); ?>"><?php echo esc_textarea( $instance['about_text'] ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'address' )); ?>"><?php esc_html_e('Address:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'address' )); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' )); ?>" value="<?php echo esc_attr( $instance['address']); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_html_e('Phone Number:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" value="<?php echo esc_attr( $instance['phone'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'fax' ) ); ?>"><?php esc_html_e('Fax:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'fax' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'fax' ) ); ?>" value="<?php echo esc_attr( $instance['fax'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e('Email:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" value="<?php echo esc_attr( $instance['email'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'more_url' ) ); ?>"><?php esc_html_e('Link:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'more_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_url' ) ); ?>" value="<?php echo esc_url( $instance['more_url'] ); ?>" class="widefat" />
		</p>
		
	<?php
	}

}

if ( ! function_exists( 'houzez_contact_us_loader' ) ) {
    function houzez_contact_us_loader (){
     register_widget( 'houzez_contact_us' );
    }
     add_action( 'widgets_init', 'houzez_contact_us_loader' );
}