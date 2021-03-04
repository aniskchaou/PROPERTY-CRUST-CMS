<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 04/09/18
 * Time: 11:39 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Currencies {
    
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__ , 'submit_currencies_form' ) );
        add_action( 'init', array( __CLASS__ , 'delete_currency' ) );
    }


    /**
     * Render currency main page
     * @return void
     */
    public static function render() {
    ?>

        <div class="houzez-admin-wrapper">
            <?php

            $header = get_template_directory().'/framework/admin/header.php';
            $tabs = get_template_directory().'/framework/admin/tabs.php';

            if ( file_exists( $header ) ) {
                load_template( $header );
            }

            if ( file_exists( $tabs ) ) {
                load_template( $tabs );
            } ?>

            <div class="admin-houzez-content"> 
                <?php
                if(isset($_GET['action']) && ( $_GET['action'] == 'add-new' || $_GET['action'] == 'edit-currency')) {
                    load_template( HOUZEZ_TEMPLATES . '/currency/form.php' );
                } else {
                    load_template( HOUZEZ_TEMPLATES . '/currency/currency-list.php' );
                } ?>
            </div>
        </div>

        <?php
    }

    public static function delete_currency() {

        $nonce = 'delete-currency';

        if ( ! empty( $_GET[ 'nonce' ] ) && wp_verify_nonce( $_GET[ 'nonce' ], $nonce ) && ! empty( $_GET['id'] ) ) {

            global $wpdb;

            $wpdb->delete( $wpdb->prefix . 'houzez_currencies', array( 'id' => $_GET['id'] ) );
            wp_redirect( 'admin.php?page=houzez_currencies' ); die;

        }

    }

    public static function currency_add_link() {
        $url = site_url( 'wp-admin/admin.php?page=houzez_currencies' );
        return add_query_arg( 'action', 'add-new', $url);
    }

    public static function get_property_currency($property_id) {
        global $wpdb;

        $currency_code = get_post_meta( get_the_ID(), 'fave_currency', true);
        
        $result = $wpdb->get_results(" SELECT * FROM " . $wpdb->prefix . "houzez_currencies where currency_code='$currency_code'");
        
        if(!empty($result)) {
            return $result;
        }
        return false;
    }

    public static function get_property_currency_by_id($property_id) {
        global $wpdb;

        $currency_code = get_post_meta( $property_id, 'fave_currency', true);
        
        $result = $wpdb->get_results(" SELECT * FROM " . $wpdb->prefix . "houzez_currencies where currency_code='$currency_code'");
        
        if(!empty($result)) {
            return $result;
        }
        return false;
    }

    public static function get_property_currency_2($property_id, $currency_code) {
        global $wpdb;
    
        $result = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "houzez_currencies where currency_code='$currency_code'", ARRAY_A);

        if(!empty($result)) {
            return $result;
        }
        return false;
    }

    public static function get_currency_by_code($currency_code) {
        global $wpdb;
    
        $result = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "houzez_currencies where currency_code='$currency_code'", ARRAY_A);

        if(!empty($result)) {
            return $result;
        }
        return false;
    }

    public static function get_form_fields() {
        global $wpdb;

        $result = $wpdb->get_results(" SELECT * FROM " . $wpdb->prefix . "houzez_currencies");

        if(!empty($result)) {
            return $result;
        }
        return false;
    }

    public static function get_currency_codes() {
        global $wpdb;

        $result = $wpdb->get_results(" SELECT currency_code FROM " . $wpdb->prefix . "houzez_currencies");

        if(!empty($result)) {
            return $result;
        }
        return false;
    }

    public static function get_currencies_data() {
        global $wpdb;

        $result = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "houzez_currencies");

        if(!empty($result)) {
            return $result;
        }
        return false;
    }

    public static function submit_currencies_form() {
        global $wpdb;
        $nonce = 'houzez_currency_save_field';

        if ( ! empty( $_REQUEST[ $nonce ] ) && wp_verify_nonce( $_REQUEST[ $nonce ], $nonce ) ) {

            $data = $_POST['hz_currency'];

            $currency_name = $data['name'];
            $currency_code = $data['code'];
            $currency_symbol = $data['symbol'];
            $currency_position = $data['position'];
            $currency_decimal = self::get_field_value( $data, 'decimals' );
            $currency_decimal_separator = self::get_field_value( $data, 'decimal_separator' );
            $currency_thousand_separator = self::get_field_value( $data, 'thousand_separator' );

            $instance = apply_filters( 'houzez_currencies_before_save', array(
                'currency_name' => $currency_name,
                'currency_code' => $currency_code,
                'currency_symbol' => $currency_symbol,
                'currency_position' => $currency_position,
                'currency_decimal' => !empty($currency_decimal) ? $currency_decimal : '0',
                'currency_decimal_separator' => $currency_decimal_separator,
                'currency_thousand_separator' => $currency_thousand_separator,
            ) );

            if ( ! empty( $data['id'] ) ) {
                $wpdb->update( $wpdb->prefix . 'houzez_currencies', $instance, array( 'id' => $data['id'] ) );
                add_action( 'admin_notices', array( __CLASS__ , 'update_currency_notice' ) );
            } else {
                $inserted = $wpdb->insert( $wpdb->prefix . 'houzez_currencies', $instance);
                if($inserted) {
                    add_action( 'admin_notices', array( __CLASS__ , 'add_currency_notice' ) );
                } else {
                    add_action( 'admin_notices', array( __CLASS__ , 'error_currency_notice' ) );
                }
            }

            self::houzez_update_currency_data($data);
        }
    }

    public static function houzez_update_currency_data($data) {

        global $wpdb;
        $table = $wpdb->prefix . 'favethemes_currency_converter';

        $currency_decimal = self::get_field_value( $data, 'decimals' );
        $currency_decimal_separator = self::get_field_value( $data, 'decimal_separator' );
        $currency_thousand_separator = self::get_field_value( $data, 'thousand_separator' );

        $currency_data = array(
            'name'          => $data['name'],
            'symbol'        => $data['symbol'],
            'position'      => $data['position'],
            'decimals'      => !empty($currency_decimal) ? $currency_decimal : '0',
            'thousands_sep' => $currency_thousand_separator,
            'decimals_sep'  => $currency_decimal_separator,
        );

        $currency_data = json_encode( (array) $currency_data );

        $wpdb->update(
            $table, array(
            'currency_data' => $currency_data,
        ), array( 'currency_code' => $data['code'] ) );
    }


    public static function add_currency_notice() { ?>
        <div class="updated notice notice-success is-dismissible">
            <p><?php esc_html_e( 'The currency has been added, excellent!', 'houzez-theme-functionality' ); ?></p>
        </div>
    <?php    
    }

    public static function update_currency_notice() { ?>
        <div class="updated notice notice-success is-dismissible">
            <p><?php esc_html_e( 'The currency has been updated, excellent!', 'houzez-theme-functionality' ); ?></p>
        </div>
    <?php    
    }

    public static function error_currency_notice() { ?>
        <div class="error notice notice-error is-dismissible">
            <p><?php esc_html_e( 'There has been an error. Bummer!', 'houzez-theme-functionality' ); ?></p>
        </div>
    <?php    
    }

    public static function currency_edit_link( $id ) {
        return add_query_arg( array(
            'action' => 'edit-currency',
            'id' => $id,
        ) );
    }

    public static function currency_delete_link( $id ) {
        
        return add_query_arg( array(
            'action' => 'delete-currency',
            'id' => $id,
            'nonce' => wp_create_nonce( 'delete-currency' )
        ) );
    }

    public static function get_edit_field()
    {
        if ( ! empty( $_GET['id'] ) && ! empty( $_GET['action'] ) ) {
            $field =  self::get_field( $_GET['id'] );

            return $field;
        }

        return null;
    }

    public static function get_field( $id ) {
        global $wpdb;
        $instance = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "houzez_currencies WHERE id = '{$id}'", ARRAY_A );

        return $instance;
    }

    public static function get_field_value( $instance, $key, $default = null ) {
        return apply_filters( 'houzez_currencies_get_field_value', ! empty( $instance[ $key ] ) ? $instance[ $key ] : $default, $key, $instance );
    }

    public static function is_edit_field() {
        return self::get_edit_field() ? true : false;
    }

        
}
?>