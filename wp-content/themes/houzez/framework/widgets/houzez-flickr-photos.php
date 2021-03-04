<?php
/*
 * Widget Name: Flickr Photos
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 */

class houzez_Flickr_Feeds extends WP_Widget {

	/**
	 * Register widget
	**/
	public function __construct() {
		
		parent::__construct(
	 		'houzez_flickr_feeds', // Base ID
			esc_html__( 'HOUZEZ: Flickr', 'houzez' ), // Name
			array( 'description' => esc_html__( 'Show photos from Flickr.', 'houzez' ), ) // Args
		);
		
	}
	

	function widget($args, $instance) {

		$instance = wp_parse_args( (array) $instance );

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

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo wp_kses( $before_widget, $allowed_html_array );

		if ( ! empty( $title ) ) {
			echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );
		}

		$photos = $this->get_photos( $instance['userid'], $instance['count'] );

		if ( !empty( $photos ) ) {
			$style = 'style="width: '.esc_attr( $instance['t_width'] ).'px; height: '.esc_attr( $instance['t_height']).'px;"';

			echo '<div class="widget-flickr-thumbs">';
				echo '<div class="widget-body">';
					echo '<div class="module-body">';
						echo '<div class="flickr-thumbs clearfix">';
							
							foreach ( $photos as $photo ) {
								echo '<a href="'.esc_url( $photo['img_url'] ).'" title="'.esc_attr( $photo['title'] ).'" target="_blank"><img src="'.esc_url( $photo['img_src'] ).'" alt="'.esc_attr( $photo['title'] ).'" '.$style.'/></a>';
							}

						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

		}

		echo wp_kses( $after_widget, $allowed_html_array );
	}

	function get_photos( $id, $count = 8 ) {
		if ( empty( $id ) )
			return false;

		$transient_key = md5( 'favethemes_flickr_cache_' . $id . $count );
		$cached = get_transient( $transient_key );
		if ( !empty( $cached ) ) {
			return $cached;
		}

		$output = array();
		$rss = 'http://api.flickr.com/services/feeds/photos_public.gne?id='.esc_attr( $id ).'&lang=en-us&format=rss_200';
		$rss = fetch_feed( $rss );

		if ( is_wp_error( $rss ) ) {
			//check for group feed
			$rss = 'http://api.flickr.com/services/feeds/groups_pool.gne?id='.esc_attr( $id ).'&lang=en-us&format=rss_200';
			$rss = fetch_feed( $rss );

		}
		if ( !is_wp_error( $rss ) ) {
			$maxitems = $rss->get_item_quantity( $count );
			$rss_items = $rss->get_items( 0, $maxitems );

			foreach ( $rss_items as $item ) {
				$temp = array();
				$temp['img_url'] = esc_url( $item->get_permalink() );
				$temp['title'] = esc_html( $item->get_title() );
				$content =  $item->get_content();
				preg_match_all( "/<IMG.+?SRC=[\"']([^\"']+)/si", $content, $sub, PREG_SET_ORDER );
				$photo_url = str_replace( "_m.jpg", "_t.jpg", $sub[0][1] );
				$temp['img_src'] = esc_url( $photo_url );
				$output[] = $temp;
			}

			set_transient( $transient_key, $output, 60 * 60 * 24 );
		}


		return $output;
	}

	

	function update($new_instance, $old_instance)
	{

		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['userid'] = strip_tags( $new_instance['userid'] );
		$instance['count'] = absint( $new_instance['count'] );
		$instance['t_width'] = absint( $new_instance['t_width'] );
		$instance['t_height'] = absint( $new_instance['t_height'] );
		return $new_instance;

	}



	function form($instance)
	{

		$defaults = array(
		 'title' 	 => 'Flickr Photos',
		 'userid' 	 => '',
		 't_height'  => '90',
		 't_width' 	 => '120',
		 'count' 	 => 6
	 );
	 $instance = wp_parse_args( (array) $instance, $defaults );
	 ?>

		

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'houzez' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'userid' ) ); ?>"><?php esc_html_e( 'Flickr ID', 'houzez' ); ?>:</label> <small><a href="http://idgettr.com/" target="_blank"><?php esc_html_e( 'What\'s my Flickr ID?', 'houzez' ); ?></a></small>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'userid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'userid' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['userid'] ); ?>" />
			<small class="howto"><?php esc_html_e( 'Example ID: 23100287@N07', 'houzez' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of photos', 'houzez' ); ?>:</label>
			<input class="small-text" type="text" value="<?php echo absint( $instance['count'] ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 't_width' ) ); ?>"><?php esc_html_e( 'Thumbnail width', 'houzez' ); ?>:</label>
			<input class="small-text" type="text" value="<?php echo absint( $instance['t_width'] ); ?>" id="<?php echo esc_attr( $this->get_field_id( 't_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 't_width' ) ); ?>" /> px
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 't_height' ) ); ?>"><?php esc_html_e( 'Thumbnail height', 'houzez' ); ?>:</label>
			<input class="small-text" type="text" value="<?php echo absint( $instance['t_height'] ); ?>" id="<?php echo esc_attr( $this->get_field_id( 't_height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 't_height' ) ); ?>" /> px
		</p>

		

	<?php

	}

}

if ( ! function_exists( 'houzez_Flickr_Feeds_loader' ) ) {
    function houzez_Flickr_Feeds_loader (){
     register_widget( 'houzez_Flickr_Feeds' );
    }
     add_action( 'widgets_init', 'houzez_Flickr_Feeds_loader' );
}
?>