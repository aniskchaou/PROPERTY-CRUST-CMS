<?php
/*
 * Widget Name: Latest Posts
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 */

class houzez_latest_posts extends WP_Widget {
	
	/**
	 * Register widget
	**/
	public function __construct() {
		
		parent::__construct(
	 		'houzez_latest_posts', // Base ID
			esc_html__( 'HOUZEZ: Latest Posts', 'houzez' ), // Name
			array( 'description' => esc_html__( 'Show latest posts by category', 'houzez' ), 'classname' => 'widget-blog-posts' ) // Args
		);
		
	}

	
	/**
	 * Front-end display of widget
	**/
	public function widget( $args, $instance ) {

		global $before_widget, $after_widget, $before_title, $after_title;
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
		$category = $instance['category'];
		
		echo wp_kses( $before_widget, $allowed_html_array );
			
			
			if ( $title ) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );
            ?>
            
            <?php
			$qy_latest = new WP_Query(
				array(
					'post_type' => 'post',
					'cat'		=> $category,
					'posts_per_page' => $items_num,
					'ignore_sticky_posts' => 1,
					'post_status' => 'publish'
				)
			);
			?>
            

			<div class="widget-body">

				<?php $i = 0; ?>
				<?php if( $qy_latest->have_posts() ): 
					while( $qy_latest->have_posts() ): $qy_latest->the_post(); $i++; ?>

						<div class="blog-post-item-widget">
							<div class="d-flex">
								<div class="blog-post-image-widget">
									<a href="<?php the_permalink(); ?>">
		                                <?php the_post_thumbnail(array(70, 70), array('class' => 'img-fluid'));?>
		                            </a>
								</div><!-- blog-post-image-widget -->
								<div class="blog-post-content-widget">
									<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								</div><!-- blog-post-content-widget -->
							</div><!-- d-flex -->
						</div><!-- blog-post-item-widget -->

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
		$instance['category'] = strip_tags( $new_instance['category'] );
		
		return $instance;
		
	}
	
	
	/**
	 * Back-end widget form
	**/
	public function form( $instance ) {
		
		/* Default widget settings. */
		$defaults = array(
			'title' => 'Latest Posts',
			'items_num' => '5',
			'category'  => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'items_num' ) ); ?>"><?php esc_html_e('Maximum posts to show:', 'houzez'); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'items_num' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'items_num' ) ); ?>" value="<?php echo esc_attr( $instance['items_num'] ); ?>" size="1" />
		</p>
		<?php
		$blog_cats = get_terms('category', array('hide_empty' => false));
		$cats_array = array();
		?>
		<p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e('Category:', 'houzez'); ?></label>
          <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
          
          <option value=""><?php esc_html_e( 'All', 'houzez' ); ?></option>
          <?php foreach($blog_cats as $blog_cat) { ?>
				
		  		<option <?php echo ($instance['category'] == $blog_cat->term_id ) ? ' selected="selected"' : ''; ?> value="<?php echo esc_attr( $blog_cat->term_id ); ?>"><?php echo esc_attr( $blog_cat->name ); ?></option>

		  <?php } ?>
          
          </select>
       </p>
		
	<?php
	}

}

if ( ! function_exists( 'houzez_latest_posts_loader' ) ) {
    function houzez_latest_posts_loader (){
     register_widget( 'houzez_latest_posts' );
    }
     add_action( 'widgets_init', 'houzez_latest_posts_loader' );
}