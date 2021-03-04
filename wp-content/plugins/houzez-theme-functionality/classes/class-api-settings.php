<?php
/**
 * Class fcc_Post_Type_Agency
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 28/09/16
 * Time: 10:16 PM
 */
class FCC_API_Settings {


	/**
	 * Sets up init
	 *
	 */
	public static function init() {
        add_action( 'admin_init', array( __CLASS__, 'fcc_register_settings' ) );

        // Update cron job when API settings updated
        add_action( 'update_option_fcc_api_settings', array( __CLASS__, 'updated_option' ), 10, 2 );
    }


    public static function render() {

        // Flush the rewrite rules if the settings were updated.
        if ( isset( $_GET['settings-updated'] ) ) {
            flush_rewrite_rules();
            FCC_Rates::update();
        }
        ?>

        <div class="houzez-admin-wrapper">

            <?php settings_errors(); 
            
            $header = get_template_directory().'/framework/admin/header.php';
            $tabs = get_template_directory().'/framework/admin/tabs.php';

            if ( file_exists( $header ) ) {
                load_template( $header );
            }

            if ( file_exists( $tabs ) ) {
                load_template( $tabs );
            }
            ?>

            <div class="admin-houzez-content">
                <h2 class="houzez-heading-inline">Currency Switcher</h2>
                <div class="admin-houzez-row">
                    <div class="admin-houzez-box-wrap">
                        <div class="admin-houzez-box">
                            <div class="admin-houzez-box-header">
                                <div class="dashicons-before dashicons-admin-generic"></div><h3>API Settings</h3>
                            </div><!-- admin-houzez-box-header -->
                            <div class="admin-houzez-box-content">
                                <p>
                                <?php printf(
                                _x( 'Plugin get currency data from %1s and imports it into the WordPress database. The exchange rates will be updated on a frequency that you can specify below.',
                                    'openexchangerates.org link', 'favethemes-currency-converter' ),
                                    '<a href="//openexchangerates.org" target="_blank">openexchangerates.org</a>' ); ?>
                                </p>
                                <form class="form-wrap" method="post" action="options.php">
                                    <?php settings_fields( 'fcc_api_settings' ); ?>
                                    <?php do_settings_sections( 'fcc_api_settings' ); ?>
                                    <?php submit_button( esc_attr__( 'Save', 'favethemes-currency-converter' ), 'primary' ); ?>
                                </form>
                            </div><!-- admin-houzez-box-content -->
                        </div><!-- admin-houzez-box -->
                    </div><!-- admin-houzez-box-wrap -->
                </div><!-- admin-houzez-row -->
            </div>
        </div><!-- wrap -->
        <?php
    }

    public static function fcc_register_settings() {

        // Register the setting.
        register_setting( 'fcc_api_settings', 'fcc_api_settings', array( __CLASS__, 'fcc_api_validate_settings' ) );

        /* === Settings Sections === */
        add_settings_section( 'fcc_api_section', '', array( __CLASS__, 'fcc_section_callback' ), 'fcc_api_settings' );

        /* === Settings Fields === */
        add_settings_field( 'api_key',   esc_html__( 'API Key',   'favethemes-currency-converter' ), array( __CLASS__, 'fcc_api_callback'   ), 'fcc_api_settings', 'fcc_api_section' );

        add_settings_field( 'update_interval',   esc_html__( 'Update Interval',   'favethemes-currency-converter' ), array( __CLASS__, 'fcc_interval_field_callback'   ), 'fcc_api_settings', 'fcc_api_section' );

    }

    /**
     * Validates the plugin settings.
     *
     * @since  1.0.0
     * @access public
     * @param  array  $input
     * @return array
     */
    public static function fcc_api_validate_settings( $settings ) {

        $settings['api_key'] = $settings['api_key'] ? trim( strip_tags( $settings['api_key']   ), '/' ) : '';
        $settings['update_interval'] = $settings['update_interval'] ? trim( strip_tags( $settings['update_interval']   ), '/' ) : '';

        return $settings;
    }

    /**
     * Section callback.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function fcc_section_callback() {}


    /**
     * API Key field callback.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function fcc_api_callback() {

        $api_key = self::get_setting('api_key');
        ?>
        <label for="api_key" class="form-field">
            <input type="password" id="api_key" name="fcc_api_settings[api_key]" value="<?php echo $api_key; ?>" class="regular-text" placeholder="<?php esc_html_e( 'Enter the Open Exchange Rates API key', 'favethemes-currency-converter' ); ?>">
            <p>
            <?php printf(
                _x( 'Get yours at: %1s', 'URL where to get the API key', 'favethemes-currency-converter' ),
                '<a href="//openexchangerates.org/" target="_blank">openexchangerates.org</a>' ); ?>
            </p>
        </label>
        
            <?php 
        }


    /**
     * Interval field callback.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function fcc_interval_field_callback() { 

        $update_frequency = self::get_setting('update_interval');

        ?>
        <label for="update_interval">
            <?php // esc_html_e( 'Rates update frequency:', 'favethemes-currency-converter' ); ?>
            <select name="fcc_api_settings[update_interval]" id="update_interval">
                <option value="hourly"   <?php selected( $update_frequency, 'hourly',   true ); ?>><?php esc_html_e( 'Hourly',  'favethemes-currency-converter' ); ?></option>
                <option value="daily"    <?php selected( $update_frequency, 'daily',    true ); ?>><?php esc_html_e( 'Daily',   'favethemes-currency-converter' ); ?></option>
                <option value="weekly"   <?php selected( $update_frequency, 'weekly',   true ); ?>><?php esc_html_e( 'Weekly',  'favethemes-currency-converter' ); ?></option>
                <option value="biweekly" <?php selected( $update_frequency, 'biweekly', true ); ?>><?php esc_html_e( 'Biweekly','favethemes-currency-converter' ); ?></option>
                <option value="monthly"  <?php selected( $update_frequency, 'monthly',  true ); ?>><?php esc_html_e( 'Monthly', 'favethemes-currency-converter' ); ?></option>
            </select>
        </label>
        
        <p>
            <?php esc_html_e( 'Specify the frequency when to update currencies exchange rates', 'favethemes-currency-converter' ); ?>
        </p>
        <?php
    }


    /**
     * Updated option callback.
     *
     * @since   1.0.0
     *
     * @param string $old_value
     * @param string $new_value
     */
    public static function updated_option( $old_value, $new_value ) {

        if ( $old_value != $new_value ) {

            wp_clear_scheduled_hook( 'favethemes_currencies_update' );

            $api_key = isset( $new_value['api_key'] ) ? $new_value['api_key'] : ( isset( $old_value['api_key'] ) ? $old_value['api_key'] : '' );

            if ( ! empty( $api_key ) ) {

                $interval = isset( $new_value['update_interval'] ) ? $new_value['update_interval'] : ( isset( $old_value['update_interval'] ) ? $old_value['update_interval'] : 'weekly' );

                HOUZEZ_Cron::FCC_schedule_updates($api_key, $interval);

            }

        }

    }



    /**
     * Returns settings.
     *
     * @since  1.0.0
     * @access public
     * @param  string  $setting
     * @return mixed
     */
    public static function get_setting( $setting ) {

        $defaults = self::get_default_settings();
        $settings = wp_parse_args( get_option('fcc_api_settings', $defaults ), $defaults );

        return isset( $settings[ $setting ] ) ? $settings[ $setting ] : false;
    }

    /**
     * Returns the default settings for the plugin.
     *
     * @since  1.0.0
     * @access public
     * @return array
     */
    public static function get_default_settings() {

        $settings = array(
            'api_key' => '',
            'update_interval' => 'weekly',
        );

        return $settings;
    }

}