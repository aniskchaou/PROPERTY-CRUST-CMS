<?php
/**
 * Class Houzez_Post_Type_Agency
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 28/09/16
 * Time: 10:16 PM
 */
class Houzez_Post_Type {


	/**
	 * Sets up init
	 *
	 */
	public static function init() {
        add_action( 'admin_init', array( __CLASS__, 'houzez_register_settings' ) );
    }


	public static function render() {
      
        // Flush the rewrite rules if the settings were updated.
        if ( isset( $_GET['settings-updated'] ) )
            flush_rewrite_rules(); ?>

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
                <form method="post" action="options.php">
                    <?php settings_fields( 'houzez_ptype_settings' ); ?>
                    <?php do_settings_sections( 'houzez_post_types' ); ?>
                    <?php submit_button( esc_attr__( 'Update Settings', 'houzez-theme-functionality' ), 'primary' ); ?>
                </form>
            </div>

        </div><!-- wrap -->
    <?php
    }

    public static function houzez_register_settings() {

        // Register the setting.
        register_setting( 'houzez_ptype_settings', 'houzez_ptype_settings', array( __CLASS__, 'houzez_validate_settings' ) );

        /* === Settings Sections === */
        add_settings_section( 'houzez_post_types_section', esc_html__( 'Custom Post Types', 'houzez-theme-functionality' ), array( __CLASS__, 'houzez_section_post_types' ), 'houzez_post_types' );

        /* === Settings Fields === */
        add_settings_field( 'houzez_agents_post',   esc_html__( 'Agents',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_agents_field'   ), 'houzez_post_types', 'houzez_post_types_section' );

        add_settings_field( 'houzez_agencies_post',   esc_html__( 'Agencies',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_agencies_field'   ), 'houzez_post_types', 'houzez_post_types_section' );

        add_settings_field( 'houzez_packages_post',   esc_html__( 'Houzez Packages',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_packages_field'   ), 'houzez_post_types', 'houzez_post_types_section' );

        add_settings_field( 'houzez_invoices_post',   esc_html__( 'Houzez Invoices',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_invoices_field'   ), 'houzez_post_types', 'houzez_post_types_section' );

        add_settings_field( 'houzez_partners_post',   esc_html__( 'Partners',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_partners_field'   ), 'houzez_post_types', 'houzez_post_types_section' );

        add_settings_field( 'houzez_testimonials_post',   esc_html__( 'Testimonials',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_testimonials_field'   ), 'houzez_post_types', 'houzez_post_types_section' );

        add_settings_field( 'houzez_packages_info_post',   esc_html__( 'User Packages Info',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_packages_info_field'   ), 'houzez_post_types', 'houzez_post_types_section' );

    }

    /**
     * Validates the plugin settings.
     *
     * @since  1.0.8
     * @access public
     * @param  array  $input
     * @return array
     */
    public static function houzez_validate_settings( $settings ) {

        // Text boxes.
        $settings['houzez_agents_post'] = $settings['houzez_agents_post'] ? trim( strip_tags( $settings['houzez_agents_post']   ), '/' ) : '';
        $settings['houzez_agencies_post'] = $settings['houzez_agencies_post'] ? trim( strip_tags( $settings['houzez_agencies_post']   ), '/' ) : '';
        $settings['houzez_packages_post'] = $settings['houzez_packages_post'] ? trim( strip_tags( $settings['houzez_packages_post']   ), '/' ) : '';
        $settings['houzez_partners_post'] = $settings['houzez_partners_post'] ? trim( strip_tags( $settings['houzez_partners_post']   ), '/' ) : '';
        $settings['houzez_testimonials_post'] = $settings['houzez_testimonials_post'] ? trim( strip_tags( $settings['houzez_testimonials_post']   ), '/' ) : '';
        $settings['houzez_packages_info_post'] = $settings['houzez_packages_info_post'] ? trim( strip_tags( $settings['houzez_packages_info_post']   ), '/' ) : '';
        $settings['houzez_invoices_post'] = $settings['houzez_invoices_post'] ? trim( strip_tags( $settings['houzez_invoices_post']   ), '/' ) : '';

        // Return the validated/sanitized settings.
        return $settings;
    }

    /**
     * Taxonomies section callback.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function houzez_section_post_types() { ?>

        <p class="description">
            <?php esc_html_e( 'Disable Custom Post Types which you do not want to show(if disabled then these will not show on back-end and front-end)', 'houzez-theme-functionality' ); ?>
        </p>
    <?php }


    /**
     * Agents field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_agents_field() { ?>

        <label>
            <select name="houzez_ptype_settings[houzez_agents_post]" class="regular-text">
                <option <?php selected(self::get_setting('houzez_agents_post'), 'enabled'); ?> value="enabled"><?php esc_html_e('Enabled', 'houzez'); ?></option>
                <option <?php selected(self::get_setting('houzez_agents_post'), 'disabled'); ?> value="disabled"><?php esc_html_e('Disabled', 'houzez'); ?></option>
            </select>
        </label>

    <?php }


    /**
     * Agencies field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_agencies_field() { ?>

        <label>
            <select name="houzez_ptype_settings[houzez_agencies_post]" class="regular-text">
                <option <?php selected(self::get_setting('houzez_agencies_post'), 'enabled'); ?> value="enabled"><?php esc_html_e('Enabled', 'houzez'); ?></option>
                <option <?php selected(self::get_setting('houzez_agencies_post'), 'disabled'); ?> value="disabled"><?php esc_html_e('Disabled', 'houzez'); ?></option>
            </select>
        </label>

    <?php }

    /**
     * Packages field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_packages_field() { ?>

        <label>
            <select name="houzez_ptype_settings[houzez_packages_post]" class="regular-text">
                <option <?php selected(self::get_setting('houzez_packages_post'), 'enabled'); ?> value="enabled"><?php esc_html_e('Enabled', 'houzez'); ?></option>
                <option <?php selected(self::get_setting('houzez_packages_post'), 'disabled'); ?> value="disabled"><?php esc_html_e('Disabled', 'houzez'); ?></option>
            </select>
        </label>

    <?php }

    /**
     * Invoices field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_invoices_field() { ?>

        <label>
            <select name="houzez_ptype_settings[houzez_invoices_post]" class="regular-text">
                <option <?php selected(self::get_setting('houzez_invoices_post'), 'enabled'); ?> value="enabled"><?php esc_html_e('Enabled', 'houzez'); ?></option>
                <option <?php selected(self::get_setting('houzez_invoices_post'), 'disabled'); ?> value="disabled"><?php esc_html_e('Disabled', 'houzez'); ?></option>
            </select>
        </label>

    <?php }

    /**
     * Partners field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_partners_field() { ?>

        <label>
            <select name="houzez_ptype_settings[houzez_partners_post]" class="regular-text">
                <option <?php selected(self::get_setting('houzez_partners_post'), 'enabled'); ?> value="enabled"><?php esc_html_e('Enabled', 'houzez'); ?></option>
                <option <?php selected(self::get_setting('houzez_partners_post'), 'disabled'); ?> value="disabled"><?php esc_html_e('Disabled', 'houzez'); ?></option>
            </select>
        </label>

    <?php }

    /**
     * Testomonials field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_testimonials_field() { ?>

        <label>
            <select name="houzez_ptype_settings[houzez_testimonials_post]" class="regular-text">
                <option <?php selected(self::get_setting('houzez_testimonials_post'), 'enabled'); ?> value="enabled"><?php esc_html_e('Enabled', 'houzez'); ?></option>
                <option <?php selected(self::get_setting('houzez_testimonials_post'), 'disabled'); ?> value="disabled"><?php esc_html_e('Disabled', 'houzez'); ?></option>
            </select>
        </label>

    <?php }

    /**
     * Packages Info field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_packages_info_field() { ?>

        <label>
            <select name="houzez_ptype_settings[houzez_packages_info_post]" class="regular-text">
                <option <?php selected(self::get_setting('houzez_packages_info_post'), 'enabled'); ?> value="enabled"><?php esc_html_e('Enabled', 'houzez'); ?></option>
                <option <?php selected(self::get_setting('houzez_packages_info_post'), 'disabled'); ?> value="disabled"><?php esc_html_e('Disabled', 'houzez'); ?></option>
            </select>
        </label>

    <?php }

    


    /**
     * Returns taxonomy settings.
     *
     * @since  1.0.8
     * @access public
     * @param  string  $setting
     * @return mixed
     */
    public static function get_setting( $setting ) {

        $defaults = self::get_default_settings();
        $settings = wp_parse_args( get_option('houzez_ptype_settings', $defaults ), $defaults );

        return isset( $settings[ $setting ] ) ? $settings[ $setting ] : false;
    }

    /**
     * Returns the default settings for the plugin.
     *
     * @since  1.0.8
     * @access public
     * @return array
     */
    public static function get_default_settings() {

        $settings = array(
            'houzez_agents_post' => 'enabled',
            'houzez_agencies_post' => 'enabled',
            'houzez_packages_post' => 'enabled',
            'houzez_invoices_post' => 'enabled',
            'houzez_partners_post' => 'enabled',
            'houzez_testimonials_post' => 'enabled',
            'houzez_packages_info_post' => 'disabled',
        );

        return $settings;
    }
	
}