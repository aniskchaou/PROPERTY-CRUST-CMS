<?php
/**
 * Widget Name: Mortgage Calculator
 * Version: 1.0
 * Author: Waqas Riaz
 * Author URI: http://favethemes.com/
 */

if(!class_exists('HOUZEZ_mortgage_calculator')) {
    class HOUZEZ_mortgage_calculator extends WP_Widget {

        /**
         * Register widget
         **/
        public function __construct() {

            parent::__construct(
                'houzez_mortgage_calculator', // Base ID
                esc_html__( 'HOUZEZ: Mortgage Calculator', 'houzez' ), // Name
                array( 'description' => esc_html__( 'Add a responsive mortgage calculator widget', 'houzez' ), 'classname' => 'widget-mortgage-calculator' ) // Args
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

            houzez_mortgage_calculator_widget();

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
                'title' => 'Mortgage Calculator'
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
}

if ( ! function_exists( 'HOUZEZ_mortgage_calculator_loader' ) ) {
    function HOUZEZ_mortgage_calculator_loader (){
        register_widget( 'HOUZEZ_mortgage_calculator' );
    }
    add_action( 'widgets_init', 'HOUZEZ_mortgage_calculator_loader', 1 );
}

if( ! function_exists('houzez_mortgage_calculator_widget') ) {
    function houzez_mortgage_calculator_widget() {

        $currency_symbol = houzez_option('currency_symbol');
    ?>

        <div class="widget-body">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><?php echo esc_attr($currency_symbol);?></div>
                    </div><!-- input-group-prepend -->
                    <input class="form-control" id="mc_total_amount" placeholder="<?php esc_html_e('Total Amount', 'houzez'); ?>" type="text">
                </div><!-- input-group -->
            </div><!-- form-group -->
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><?php echo esc_attr($currency_symbol);?></div>
                    </div><!-- input-group-prepend -->
                    <input class="form-control" id="mc_down_payment" placeholder="<?php esc_html_e('Down Payment', 'houzez'); ?>" type="text">
                </div><!-- input-group -->
            </div><!-- form-group -->
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">%</div>
                    </div><!-- input-group-prepend -->
                    <input class="form-control" id="mc_interest_rate" placeholder="<?php esc_html_e('Interest Rate', 'houzez'); ?>" type="text">
                </div><!-- input-group -->
            </div><!-- form-group -->
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="houzez-icon icon-calendar-3"></i>
                        </div>
                    </div><!-- input-group-prepend -->
                    <input class="form-control" id="mc_term_years" placeholder="<?php esc_html_e('Loan Term (Years)', 'houzez'); ?>" type="text">
                </div><!-- input-group -->
            </div><!-- form-group -->
            <div class="form-group">
                <select class="selectpicker form-control bs-select-hidden" id="mc_payment_period" data-live-search="false" data-live-search-style="begins">
                    <option value="12"><?php esc_html_e('Monthly', 'houzez'); ?></option>
                    <option value="26"><?php esc_html_e('Bi-Weekly', 'houzez'); ?></option>
                    <option value="52"><?php esc_html_e('Weekly', 'houzez'); ?></option>
                </select>
            </div><!-- form-group -->
            <button id="houzez_mortgage_calculate" type="submit" class="btn btn-search btn-secondary btn-full-width"><?php esc_html_e('Calculate', 'houzez'); ?></button>
            <div class="mortgage-details detail-wrap">
                <ul>
                    <li>
                        <strong><?php esc_html_e('Principal Amount:', 'houzez'); ?></strong> 
                        <span id="amount_financed" class="result-value"></span>
                    </li>
                    <li>
                        <strong><?php esc_html_e('Years:', 'houzez'); ?></strong> 
                        <span id="cal_years" class="result-value"></span>
                    </li>
                    <li id="mortgage_mwbi">
                        
                    </li>
                    <li>
                        <strong><?php esc_html_e('Balance Payable With Interest:', 'houzez'); ?></strong> 
                        <span id="balance_payable_with_interest" class="result-value"></span>
                    </li>
                    <li>
                        <strong><?php esc_html_e('Total With Down Payment:', 'houzez'); ?></strong> 
                        <span id="total_with_down_payment" class="result-value"></span>
                    </li>


                </ul>
            </div><!-- mortgage-details -->
        </div><!-- widget-body -->

        <?php
    }
}