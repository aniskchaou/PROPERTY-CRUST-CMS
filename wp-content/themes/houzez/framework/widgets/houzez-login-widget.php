<?php
/*
 * Widget Name: Login - Register
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 */

class houzez_login_widget extends WP_Widget {


    /**
     * Register widget
     **/
    public function __construct() {

        parent::__construct(
            'houzez_login_widget', // Base ID
            esc_html__( 'HOUZEZ: Login', 'houzez' ), // Name
            array( 'description' => esc_html__( 'houzez login widget', 'houzez' ), 'classname' => 'widget-login' ) // Args
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

        echo wp_kses( $before_widget, $allowed_html_array );

        global $current_user;
        wp_get_current_user();
        $userID  =  $current_user->ID;
        $user_custom_picture =  get_the_author_meta( 'fave_author_custom_picture' , $userID );
        if( empty( $user_custom_picture )) {
            $user_custom_picture = get_template_directory_uri().'/images/profile-avatar.png';
        }


        if ( $title ) echo wp_kses( $before_title, $allowed_html_array ) . $title . wp_kses( $after_title, $allowed_html_array );

        if( is_user_logged_in() ) { ?>

            <div class="widget-body">
                <div class="media">
                    <div class="media-left">
                        <div class="thumb">
                            <img src="<?php echo esc_url( $user_custom_picture ); ?>" alt="Image" width="64">
                        </div>
                    </div>
                    <div class="media-body v-align-middle">
                        <p><?php echo esc_attr( $current_user->display_name ); ?></p>
                        <a href="<?php echo wp_logout_url( home_url('/') ); ?>"> <i class="fa fa-unlock"></i> <?php esc_html_e( 'Log out', 'houzez' ); ?> </a>
                    </div>
                </div>
            </div>

        <?php } else { ?>

                <div class="widget-body">
                    <ul class="login-tabs">
                        <li class="active"><?php esc_html_e( 'Login', 'houzez' ); ?></li>
                        <li><?php esc_html_e( 'Register', 'houzez' ); ?></li>
                    </ul>
                    <div class="modal-body login-block">
                        <?php get_template_part('template-parts/login-register'); ?>
                    </div>
                </div>


            <?php
        }
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
            'title' => 'Login',
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

if ( ! function_exists( 'houzez_login_widget_loader' ) ) {
    function houzez_login_widget_loader (){
        register_widget( 'houzez_login_widget' );
    }
    add_action( 'widgets_init', 'houzez_login_widget_loader' );
}