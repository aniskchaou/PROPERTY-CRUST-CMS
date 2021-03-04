<?php
/*
 * Plugin Name: Instagram widget
 * Plugin URI: http://favethemes.com/
 * Description: A widget that displays a slider with instagram images
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 */
 
class houzez_instagram extends WP_Widget {
	
	
	/**
	 * Register widget
	**/
	public function __construct() {
		
		parent::__construct(
	 		'houzez_instagram', // Base ID
			__( 'Houzez: Instagram Slider',  'houzez'  ), // Name
			array( 'description' => __( 'A widget that displays a slider/thumbs with instagram images',  'houzez'  ), ) // Args
		);
		
	}

	
	/** @see WP_Widget::widget */
  function widget($args, $instance) {	
    extract( $args );

	$title        = apply_filters('widget_title', $instance['title'] );
	$userid = apply_filters('userid', $instance['userid']);
    $accessToken = apply_filters('accessToken', $instance['accessToken']);
	$link_to	  = isset( $instance['images_link'] ) ? $instance['images_link'] : 'image_url';
	$amount    = isset( $instance['images_number'] ) ? $instance['images_number'] : 5;
	$template	  = isset( $instance['template'] ) ? $instance['template'] : 'slider';
	
	
?>
<?php echo $before_widget; 
if ( $title )
echo $before_title . $title . $after_title; ?>
                 

<?php
	

		// Pulls and parses data.
	    $connection = wp_remote_get( 'https://api.instagram.com/v1/users/'.$userid.'/media/recent/?access_token='.$accessToken.'&count='.$amount );
		if ( ! is_wp_error( $connection ) ) {
		   $body        = wp_remote_retrieve_body( $connection );
		   $result = json_decode( $body );
		}

		$unique_key = houzez_unique_key();
	    if ( is_rtl() ) { $houzez_rtl = 'true'; } else { $houzez_rtl = 'false'; }
		?>
			
			<script type="text/javascript">
			jQuery(document).ready(function($) { 
				
				$("#owl-carousel-instagram-<?php echo $unique_key; ?>").owlCarousel({
					rtl: <?php echo $houzez_rtl; ?>,
					loop: true,
					touchDrag: true,
					items : 1,

				    //Autoplay
				    autoplay : true,
					autoplayHoverPause : true,

				    // Navigation
					nav : true,
					navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
				    rewindNav : true,
				    dots:false,

				    // Responsive 
					responsiveClass:true,
					responsiveRefreshRate : 200,
					responsiveBaseWidth: window,

				    //Lazy load
				    lazyLoad : true,
				    lazyFollow : true,
				    lazyEffect : "fade",
				});
				
			});
			</script>
		<?php
	
		//include the template based on user choice
        if(!empty($result->data)) {

	        if($template == "slider"){
			   $this->houzez_instagram_slider($template, $result, $link_to, $unique_key);
			}
			else{
				$this->houzez_instagram_slider_thumbs($template, $result, $link_to);
			}
		}
	?>

								
<?php echo $after_widget; ?>
			 
<?php }
	
	
	/** @see WP_Widget::update */
    function update($new_instance, $old_instance) {	
	
        return $new_instance;
    }
	
	
	/** @see WP_Widget::form */
    function form($instance) {
      /* Set up some default widget settings. */
      $defaults = array(
		 'title' 		=> __('Instagram Slider', 'houzez'),
		 'userid' 		=> '',
		 'accessToken'  => '',
		 'template' 		=> 'slider',
		 'images_link' 	=> 'image_url',
		 'images_number' => 6
	 );
	 $instance = wp_parse_args( (array) $instance, $defaults );
			
			
    ?>
    	<p>Generate your Instagram user ID and Instagram access token on: <a target="_blank" href="http://instagram.pixelunion.net/">Instagram access token generator</a> website</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'houzez'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title']); ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('userid'); ?>"><?php _e('Instagram user ID:', 'houzez'); ?> <input class="widefat" id="<?php echo $this->get_field_id('userid'); ?>" name="<?php echo $this->get_field_name('userid'); ?>" type="text" value="<?php echo $instance['userid']; ?>" /></label></p>
	  	<p><label for="<?php echo $this->get_field_id('accessToken'); ?>"><?php _e('Instagram access token:', 'houzez'); ?> <input class="widefat" id="<?php echo $this->get_field_id('accessToken'); ?>" name="<?php echo $this->get_field_name('accessToken'); ?>" type="text" value="<?php echo $instance['accessToken']; ?>" /></label></p>
        <p>
          <label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Images Layout', 'houzez' ); ?>
          <select class="widefat" name="<?php echo $this->get_field_name( 'template' ); ?>">
          <option value="slider" <?php echo ($instance['template'] == 'slider') ? ' selected="selected"' : ''; ?>><?php _e( 'Slider', 'houzez' ); ?></option>
          <!-- <option value="slider-overlay" <?php echo ($instance['template'] == 'slider-overlay') ? ' selected="selected"' : ''; ?>><?php _e( 'Slider - Overlay Text', 'houzez' ); ?></option> -->
          <option value="thumbs" <?php echo ($instance['template'] == 'thumbs') ? ' selected="selected"' : ''; ?>><?php _e( 'Thumbnails', 'houzez' ); ?></option>
          </select>  
          </label>
       </p>
       <p>
            <?php _e('Link Images To:', 'houzez'); ?><br>
            <label><input type="radio" id="<?php echo $this->get_field_id( 'images_link' ); ?>" name="<?php echo $this->get_field_name( 'images_link' ); ?>" value="image_url" <?php checked( 'image_url', $instance['images_link'] ); ?> /> <?php _e('Instagram Image', 'houzez'); ?></label><br />
            <label><input type="radio" id="<?php echo $this->get_field_id( 'images_link' ); ?>" name="<?php echo $this->get_field_name( 'images_link' ); ?>" value="user_url" <?php checked( 'user_url', $instance['images_link'] ); ?> /> <?php _e('Instagram Profile', 'houzez'); ?></label><br />
            
         </p>
		   
		<p>
			<label  for="<?php echo $this->get_field_id( 'images_number' ); ?>"><?php _e('Number of Images to Show:', 'houzez'); ?>
			<input  class="small-text" id="<?php echo $this->get_field_id( 'images_number' ); ?>" name="<?php echo $this->get_field_name( 'images_number' ); ?>" value="<?php echo $instance['images_number']; ?>" />
			<small><?php _e('( max 20 )', 'houzez'); ?></small>
            </label>
		</p>
			
<?php }

	function houzez_instagram_slider($template, $result, $link_to, $unique_key){?>

		
		<div class="widget-instagramm-slider">
		<div class="widget-body">
			<div class="module-body">
				<div id="owl-carousel-instagram-<?php echo $unique_key; ?>" class="owl-carousel">
					
					<?php
			        foreach ( $result->data as $post) {


			        		if ( $link_to == 'image_url' ) {
			                    $link = $post->link;
			                } else {
			                	$link = "http://instagram.com/".$post->user->username."";
			                }

			                if( isset( $post->caption->text ) ) {
			                	$text = $post->caption->text;
			                } else {
			                	$text = '';
			                }
			                
			                echo '<div class="slide">'. "\n";
			                echo '<a target="_blank" href="'.$link.'"><img class="featured-image lazyOwl" data-src="'.$post->images->standard_resolution->url.'" src="'.$post->images->standard_resolution->url.'" alt="'.$text.'"></a>' . "\n";
			                echo '</div>' . "\n";

			        }
			        ?>


				</div>
			</div>
		</div>
		</div>

		<?php
		}


		function houzez_instagram_slider_thumbs($template, $result, $link_to){ ?>
	
		<div class="widget-instagramm-thumbs">
		<div class="widget-body">
			<div class="module-body">
				<div class="instagramm-thumbs clearfix">
					
					<?php
					foreach ( $result->data as $post) {

			        		if ( $link_to == 'image_url' ) {
			                    $link = $post->link;
			                } else {
			                	$link = "http://instagram.com/".$post->user->username."";
			                }
			               
			                echo '<a target="_blank" href="' . $link . '"><img width="100" src="' . $post->images->thumbnail->url . '" alt=""></a>' . "\n";

			        }
				    ?>

				</div>
			</div>
		</div>
		</div>

		<?php	
		}


}// end .houzez_instagram

if ( ! function_exists( 'houzez_instagram_loader' ) ) {
    function houzez_instagram_loader (){
     register_widget( 'houzez_instagram' );
    }
     add_action( 'widgets_init', 'houzez_instagram_loader' );
}


