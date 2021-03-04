<?php
/*
 * Widget Name: Featured Properties
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 */
 
class HOUZEZ_properties_viewed extends WP_Widget {
	
	/**
	 * Register widget
	**/
	public function __construct() {
		
		parent::__construct(
	 		'houzez_properties_viewed', // Base ID
			esc_html__( 'HOUZEZ: Recent View Properties', 'houzez' ), // Name
			array( 'description' => esc_html__( 'Show properties Recently viewed properties', 'houzez' ), 'classname' => 'widget-properties') // Args
		);
		
	}

	
	/**
	 * Front-end display of widget
	**/
	public function widget( $args, $instance ) {

		global $before_widget, $after_widget, $before_title, $after_title, $post;
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
		$items_num = $instance['items_num'];
		
		echo wp_kses( $before_widget, $allowed_html_array );
			
			
			if ( $title ) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );
            ?>
            
            <?php
			$wp_qry = new WP_Query(
				array(
					'post_type' => 'property',
					'posts_per_page' => $items_num,
					'orderby' => 'meta_value',
					
					'meta_key' => 'houzez_recently_viewed',
					'ignore_sticky_posts' => 1,
					'post_status' => 'publish',
					
				)
			);
			?>
            

			<div class="widget-body">

				<?php if( $wp_qry->have_posts() ): while( $wp_qry->have_posts() ): $wp_qry->the_post(); ?>

					<div class="property-item-widget">
						<div class="d-flex align-items-start">
							<div class="left-property-item-widget-wrap">
								<?php get_template_part('template-parts/listing/partials/item-image'); ?>
							</div><!-- left-property-item-widget-wrap -->
							<div class="right-property-item-widget-wrap">
								<?php get_template_part('template-parts/listing/partials/item-title'); ?>
								<?php get_template_part('template-parts/listing/partials/item-price'); ?>
							</div><!-- right-property-item-widget-wrap -->
						</div><!-- d-flex -->
					</div><!-- property-item-widget -->

				<?php endwhile; endif; ?>
				<?php wp_reset_postdata(); ?>
				
			</div>


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
		$instance['items_num'] = strip_tags( $new_instance['items_num'] );
		
		return $instance;
		
	}
	
	
	/**
	 * Back-end widget form
	**/
	public function form( $instance ) {
		
		/* Default widget settings. */
		$defaults = array(
			'title' => 'Properties',
			'items_num' => '5'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'items_num' ) ); ?>"><?php esc_html_e('Maximum posts to show:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'items_num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'items_num' ) ); ?>" value="<?php echo esc_attr( $instance['items_num'] ); ?>" size="1" />
		</p>
		
	<?php
	}

}

if ( ! function_exists( 'HOUZEZ_properties_viewed_loader' ) ) {
    function HOUZEZ_properties_viewed_loader (){
     register_widget( 'HOUZEZ_properties_viewed' );
    }
     add_action( 'widgets_init', 'HOUZEZ_properties_viewed_loader' );
}