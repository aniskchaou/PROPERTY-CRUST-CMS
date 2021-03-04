<?php
/**
 * Widget Name: Advanced Search
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 *
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 20/01/16
 * Time: 10:51 PM
 */

class HOUZEZ_advanced_search extends WP_Widget {

    /**
     * Register widget
     **/
    public function __construct() {

        parent::__construct(
            'houzez_advanced_search', // Base ID
            esc_html__( 'HOUZEZ: Advanced Search', 'houzez' ), // Name
            array( 'description' => esc_html__( 'Advanced Search', 'houzez' ), ) // Args
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

        echo wp_kses( $before_widget, $allowed_html_array );

        if ( $title ) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );

        houzez_advanced_search_widget();

        echo wp_kses( $after_widget, $allowed_html_array );

    }


    /**
     * Sanitize widget form values as they are saved
     **/
    public function update( $new_instance, $old_instance ) {

        $instance = array();

        /* Strip tags to remove HTML. For text inputs and textarea. */
        $instance['title'] = strip_tags( $new_instance['title'] );

        return $instance;

    }


    /**
     * Back-end widget form
     **/
    public function form( $instance ) {

        /* Default widget settings. */
        $defaults = array(
            'title' => 'Find Your Home'
        );
        $instance = wp_parse_args( (array) $instance, $defaults );

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title:', 'houzez'); ?></label>
            <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>

        <?php
    }

}

if ( ! function_exists( 'HOUZEZ_advanced_search_loader' ) ) {
    function HOUZEZ_advanced_search_loader (){
        register_widget( 'HOUZEZ_advanced_search' );
    }
    add_action( 'widgets_init', 'HOUZEZ_advanced_search_loader', 1 );
}

if( !function_exists('houzez_advanced_search_widget') ) {
    function houzez_advanced_search_widget() {
        $search_builder = houzez_search_builder();
        $layout = $search_builder['enabled'];
        unset($layout['placebo']);
        unset($layout['geolocation']);
        unset($layout['price']);

        if(!taxonomy_exists('property_country')) {
            unset($layout['country']);
        }

        if(!taxonomy_exists('property_state')) {
            unset($layout['state']);
        }

        if(!taxonomy_exists('property_city')) {
            unset($layout['city']);
        }

        if(!taxonomy_exists('property_area')) {
            unset($layout['areas']);
        }

        if(houzez_is_price_range_search()) {
            unset($layout['min-price'], $layout['max-price']);
        }
    ?>
    
        <div class="advanced-search-widget">
            <form class="houzez-search-form-js" method="get" autocomplete="off" action="<?php echo esc_url( houzez_get_search_template_link() ); ?>">
                <?php
                $i = 0;
                if ($layout) {
                    foreach ($layout as $key=>$value) { $i ++;
                        
                        if(in_array($key, houzez_search_builtIn_fields())) {
                            
                            get_template_part('template-parts/search/fields/'.$key);
                            
                        } else {
                            houzez_get_custom_search_field($key);
                        }
                    }
                }
                
                if(houzez_is_price_range_search()) {
                    get_template_part('template-parts/search/fields/price-range'); 
                }

                if(houzez_is_other_featuers_search()) {
                    get_template_part('template-parts/search/other-features');
                }

                get_template_part('template-parts/search/fields/submit-button'); ?>
            </div>
        </form>
    <?php
    }
}