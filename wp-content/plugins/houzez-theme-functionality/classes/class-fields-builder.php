<?php
/**
 * Class Houzez_Post_Type_Agency
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 28/09/16
 * Time: 10:16 PM
 */
class Houzez_Fields_Builder {


    /**
     * Sets up init
     *
     */
    public static function init() {
        add_action( 'admin_enqueue_scripts', array( __CLASS__ , 'enqueue_scripts' ) );
        add_action( 'init', array( __CLASS__ , 'save_fields' ) );
        add_action( 'init', array( __CLASS__ , 'delete_field' ) );
        add_action( 'wp_ajax_houzez_load_select_options', array( __CLASS__ , 'load_select_options' ) );
    }


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
            $template = apply_filters( 'houzez_fbuilder_index_template_path', HOUZEZ_TEMPLATES . '/fields-builder/page.php' );

            if ( file_exists( $template ) ) {
                load_template( $template );
            } ?>
            </div>
        </div>
    <?php        
    }

    public static function enqueue_scripts()
    {
        $path = 'assets/admin/js/';

        wp_register_script( 'houzez-jquery-cloneya', HOUZEZ_PLUGIN_URL . $path . 'jquery-cloneya.min.js', array('jquery') );
        wp_enqueue_script( 'houzez-jquery-cloneya' );

        wp_register_script( 'houzez-admin-custom', HOUZEZ_PLUGIN_URL . $path . 'custom.js', array('jquery', 'houzez-jquery-cloneya') );
        wp_enqueue_script( 'houzez-admin-custom' );
    }

    public static function get_form_fields() {
        global $wpdb;

        $result = $wpdb->get_results(" SELECT * FROM " . $wpdb->prefix . "houzez_fields_builder order by id ASC");

        if(!empty($result)) {
            return $result;
        }
        return false;
    }

    public static function get_search_fields() {
        global $wpdb;

        $result = $wpdb->get_results(" SELECT * FROM " . $wpdb->prefix . "houzez_fields_builder WHERE is_search='yes' order by id ASC");

        if(!empty($result)) {
            return $result;
        }
        return false;
    }


    public static function delete_field() {

        $nonce = 'houzez-delete-field';

        if ( ! empty( $_GET[ 'nonce' ] ) && wp_verify_nonce( $_GET[ 'nonce' ], $nonce ) && ! empty( $_GET['id'] ) ) {

            global $wpdb;

            $wpdb->delete( $wpdb->prefix . 'houzez_fields_builder', array( 'id' => $_GET['id'] ) );
            wp_redirect( 'admin.php?page=houzez_fbuilder' ); die;

        }

    }

    public static function load_select_options() {

        $file = HOUZEZ_TEMPLATES . '/fields-builder/multiple.php';
        if ( file_exists( $file ) ) {
            include $file;
        }
        die;
    }

    public static function get_field_types() {

        return apply_filters( 'houzez_fbuilder_field_types', array(
            'text' => esc_html__( 'Text', 'houzez-theme-functionality' ),
            'number' => esc_html__( 'Number', 'houzez-theme-functionality' ),
            'textarea' => esc_html__( 'Text area', 'houzez-theme-functionality' ),
            'select' => esc_html__( 'Select', 'houzez-theme-functionality' ),
            'multiselect' => esc_html__( 'Multi Select', 'houzez-theme-functionality' ),
            'checkbox_list' => esc_html__( 'Checkbox List', 'houzez-theme-functionality' ),
            'radio' => esc_html__( 'Radio', 'houzez-theme-functionality' ),
        ) );
    }

    public static function get_field_option($instance) {

        if( $instance['type'] == 'checkbox_list' || $instance['type'] == 'radio' ) {
            return isset($instance['fvalues']) && ! empty( $instance['fvalues'] ) ? $instance['fvalues'] : '';
        }
    }

    public static function field_edit_link( $id ) {
        return add_query_arg( array(
            'action' => 'houzez-edit-field',
            'id' => $id,
        ) );
    }
    public static function field_add_link() {
        $url = site_url( 'wp-admin/admin.php?page=houzez_fbuilder' );
        return add_query_arg( 'action', 'add-new', $url);
    }

    public static function field_delete_link( $id ) {
        
        return add_query_arg( array(
            'action' => 'houzez-delete-field',
            'id' => $id,
            'nonce' => wp_create_nonce( 'houzez-delete-field' )
        ) );
    }

    public static function get_field_value( $instance, $key, $default = null )
    {
        $instance = stripslashes($instance[ $key ]);
        return apply_filters( 'houzez_fbuilder_get_field_value', ! empty($instance) ? $instance : $default, $key, $instance );
    }


    public static function is_edit_field() {
        return self::get_edit_field() ? true : false;
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
        $instance = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "houzez_fields_builder WHERE id = '{$id}'", ARRAY_A );

        if ( $instance ) {
            $instance['fvalues'] = ! empty( $instance['fvalues'] ) ? unserialize( $instance['fvalues'] ) : array();
        }

        return $instance;
    }

    public static function get_field_by_slug( $slug ) {
        global $wpdb;
        $instance = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "houzez_fields_builder WHERE field_id = '{$slug}'", ARRAY_A );

        return $instance;
    }

    public static function get_field_title_type_by_slug( $slug ) {
        global $wpdb;
        $result = $wpdb->get_row( "SELECT label, type FROM " . $wpdb->prefix . "houzez_fields_builder WHERE field_id = '{$slug}'", ARRAY_A );

        return $result;
    }


    public static function add_field_notice() { ?>
        <div class="updated notice notice-success is-dismissible">
            <p><?php esc_html_e( 'The field has been added, excellent!', 'houzez-theme-functionality' ); ?></p>
        </div>
    <?php    
    }

    public static function update_field_notice() { ?>
        <div class="updated notice notice-success is-dismissible">
            <p><?php esc_html_e( 'The field has been updated, excellent!', 'houzez-theme-functionality' ); ?></p>
        </div>
    <?php    
    }

    public static function error_field_notice() { ?>
        <div class="error notice notice-error is-dismissible">
            <p><?php esc_html_e( 'There has been an error. Bummer!', 'houzez-theme-functionality' ); ?></p>
        </div>
    <?php    
    }

    public static function stripslashes_deep($value)
    {
        $value = is_array($value) ?
                    array_map('stripslashes_deep', $value) :
                    stripslashes($value);

        return $value;
    }


    public static function save_fields() {
        global $wpdb;

        $nonce = 'houzez_fbuilder_save_field';

        if ( ! empty( $_REQUEST[ $nonce ] ) && wp_verify_nonce( $_REQUEST[ $nonce ], $nonce ) ) {
            $data = $_POST['hz_fbuilder'];

            $fvalues = ! empty( $data['fvalues'] ) ? ( $data['fvalues'] ) : null;

            if(!empty($fvalues)) {
                $fvalues = stripslashes_deep($fvalues);
            }

            if(!empty($fvalues)) {
                foreach ($fvalues as $option) {
                    do_action( 'wpml_register_single_string', 'houzez_cfield', $option, $option );
                }
            }

            $field_type = self::get_field_value( $data, 'type' );
            $field_label = self::get_field_value( $data, 'label' );
            $placeholder = self::get_field_value( $data, 'placeholder' );
            $field_is_search = self::get_field_value( $data, 'is_search' );

            if($field_type == 'select' || $field_type == 'multiselect') {
                $fvalues = $fvalues ? serialize( array_combine( $fvalues, $fvalues  ) ) : null;
            } else {
                $fvalues = $data['options'] ? serialize( $data['options'] ) : null;
            }

            $instance = apply_filters( 'houzez_fields_builder_before_fields_save', array(
                'label' => $field_label,
                'type' => $field_type,
                'fvalues' => $fvalues,
                'is_search' => $field_is_search,
                'placeholder' => $placeholder,
                'options' => ''//$field_icon,
                
                
            ) );
            do_action( 'wpml_register_single_string', 'houzez_cfield', $field_label, $field_label );
            do_action( 'wpml_register_single_string', 'houzez_cfield', $placeholder, $placeholder );

            if ( ! empty( $data['id'] ) ) {
                $updated = $wpdb->update( $wpdb->prefix . 'houzez_fields_builder', $instance, array( 'id' => $data['id'] ) );
                
                add_action( 'admin_notices', array( __CLASS__ , 'update_field_notice' ) );
                
            } else {
                $field_id = self::houzez_slugify( self::get_field_value( $data, 'label' ) );

                if(is_rtl()) {
                    $field_id = self::houzez_slugify( uniqid( 'f' ) );
                } else {
                    $field_id = self::houzez_slugify( self::get_field_value( $data, 'label' ) );
                }

                $inserted = $wpdb->insert( $wpdb->prefix . 'houzez_fields_builder', array_merge( array(
                    'field_id' => $field_id ), $instance ));
                if($inserted) {
                    add_action( 'admin_notices', array( __CLASS__ , 'add_field_notice' ) );
                } else {
                    add_action( 'admin_notices', array( __CLASS__ , 'error_field_notice' ) );
                }

            }

        } //$nonce

    }

    public static function houzez_slugify($text) {
      // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);

      // transliterate
      if (seems_utf8($text)) {
            if (function_exists('mb_strtolower')) {
                $text = mb_strtolower($text, 'UTF-8');
            }
            $text = utf8_uri_encode($text, 200);
        }


      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
      $text = trim($text, '-');

      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);

      // lowercase
      $text = strtolower($text);

      if (empty($text)) {
        return 'n-a';
      }

      return $text;
    }

    
}