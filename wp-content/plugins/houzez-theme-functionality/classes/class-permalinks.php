<?php
/**
 * Class Houzez_Post_Type_Agency
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 28/09/16
 * Time: 10:16 PM
 */
class Houzez_Permalinks {


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
                    <?php settings_fields( 'houzez_settings' ); ?>
                    <?php do_settings_sections( 'houzez_permalinks' ); ?>
                    <?php submit_button( esc_attr__( 'Update Permalinks', 'houzez-theme-functionality' ), 'primary' ); ?>
                </form>
            </div>

        </div><!-- wrap -->
    <?php
    }

    public static function houzez_register_settings() {

        // Register the setting.
        register_setting( 'houzez_settings', 'houzez_settings', array( __CLASS__, 'houzez_validate_settings' ) );

        /* === Settings Sections === */
        add_settings_section( 'permalinks', esc_html__( 'Permalinks', 'houzez-theme-functionality' ), array( __CLASS__, 'houzez_section_permalinks' ), 'houzez_permalinks' );

        /* === Settings Fields === */
        add_settings_field( 'property_rewrite_base',   esc_html__( 'Property Slug',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_property_slug_field'   ), 'houzez_permalinks', 'permalinks' );

        add_settings_field( 'property_type_rewrite_base',   esc_html__( 'Property Type Slug',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_property_type_rewrite_base'   ), 'houzez_permalinks', 'permalinks' );

        add_settings_field( 'property_feature_rewrite_base',   esc_html__( 'Property Feature Slug',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_property_feature_rewrite_base'   ), 'houzez_permalinks', 'permalinks' );

        add_settings_field( 'property_status_rewrite_base',   esc_html__( 'Property Status Slug',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_property_status_rewrite_base'   ), 'houzez_permalinks', 'permalinks' );

        add_settings_field( 'property_country_rewrite_base',   esc_html__( 'Property Country Slug',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_property_country_rewrite_base'   ), 'houzez_permalinks', 'permalinks' );

        add_settings_field( 'property_state_rewrite_base',   esc_html__( 'Property State Slug',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_property_state_rewrite_base'   ), 'houzez_permalinks', 'permalinks' );

        add_settings_field( 'property_city_rewrite_base',   esc_html__( 'Property City Slug',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_property_city_rewrite_base'   ), 'houzez_permalinks', 'permalinks' );

        add_settings_field( 'property_area_rewrite_base',   esc_html__( 'Property Area Slug',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_property_area_rewrite_base'   ), 'houzez_permalinks', 'permalinks' );

        add_settings_field( 'property_label_rewrite_base',   esc_html__( 'Property Label Slug',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_property_label_rewrite_base'   ), 'houzez_permalinks', 'permalinks' );

        add_settings_field( 'agent_rewrite_base',   esc_html__( 'Agent Slug',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_agent_rewrite_base'   ), 'houzez_permalinks', 'permalinks' );

        add_settings_field( 'agency_rewrite_base',   esc_html__( 'Agency Slug',   'houzez-theme-functionality' ), array( __CLASS__, 'houzez_agency_rewrite_base'   ), 'houzez_permalinks', 'permalinks' );
        
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
        $settings['property_rewrite_base'] = $settings['property_rewrite_base'] ? trim( strip_tags( $settings['property_rewrite_base']   ), '/' ) : '';
        $settings['property_type_rewrite_base'] = $settings['property_type_rewrite_base'] ? trim( strip_tags( $settings['property_type_rewrite_base']   ), '/' ) : '';
        $settings['property_feature_rewrite_base'] = $settings['property_feature_rewrite_base'] ? trim( strip_tags( $settings['property_feature_rewrite_base']   ), '/' ) : '';
        $settings['property_status_rewrite_base'] = $settings['property_status_rewrite_base'] ? trim( strip_tags( $settings['property_status_rewrite_base']   ), '/' ) : '';
        $settings['property_area_rewrite_base'] = $settings['property_area_rewrite_base'] ? trim( strip_tags( $settings['property_area_rewrite_base']   ), '/' ) : '';
        $settings['property_label_rewrite_base'] = $settings['property_label_rewrite_base'] ? trim( strip_tags( $settings['property_label_rewrite_base']   ), '/' ) : '';

        $settings['property_country_rewrite_base'] = $settings['property_country_rewrite_base'] ? trim( strip_tags( $settings['property_country_rewrite_base']   ), '/' ) : '';

        $settings['agent_rewrite_base'] = $settings['agent_rewrite_base'] ? trim( strip_tags( $settings['agent_rewrite_base']   ), '/' ) : '';

        $settings['agency_rewrite_base'] = $settings['agency_rewrite_base'] ? trim( strip_tags( $settings['agency_rewrite_base']   ), '/' ) : '';

        // Return the validated/sanitized settings.
        return $settings;
    }

    /**
     * Permalinks section callback.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function houzez_section_permalinks() { ?>

        <p class="description">
            <?php esc_html_e( 'Set up custom permalinks for the property section on your site.', 'houzez-theme-functionality' ); ?>
        </p>
    <?php }

    /**
     * Property rewrite base field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_property_slug_field() { ?>

        <label>
            <code><?php echo esc_url( home_url( '/' ) ); ?></code>
            <input type="text" class="regular-text code" name="houzez_settings[property_rewrite_base]" value="<?php echo esc_attr( houzez_get_property_rewrite_base() ); ?>" />
        </label>

    <?php }

    /**
     * Agent rewrite base field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_agent_rewrite_base() { ?>

        <label>
            <code><?php echo esc_url( home_url( '/' ) ); ?></code>
            <input type="text" class="regular-text code" name="houzez_settings[agent_rewrite_base]" value="<?php echo esc_attr( houzez_get_agent_rewrite_base() ); ?>" />
        </label>

    <?php }

    /**
     * Agency rewrite base field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_agency_rewrite_base() { ?>

        <label>
            <code><?php echo esc_url( home_url( '/' ) ); ?></code>
            <input type="text" class="regular-text code" name="houzez_settings[agency_rewrite_base]" value="<?php echo esc_attr( houzez_get_agency_rewrite_base() ); ?>" />
        </label>

    <?php }

    /**
     * Property type rewrite base field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_property_type_rewrite_base() { ?>

        <label>
            <code><?php echo esc_url( home_url( '/' ) ); ?></code>
            <input type="text" class="regular-text code" name="houzez_settings[property_type_rewrite_base]" value="<?php echo esc_attr( houzez_get_property_type_rewrite_base() ); ?>" />
        </label>

    <?php }

    /**
     * Property status rewrite base field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_property_status_rewrite_base() { ?>

        <label>
            <code><?php echo esc_url( home_url( '/' ) ); ?></code>
            <input type="text" class="regular-text code" name="houzez_settings[property_status_rewrite_base]" value="<?php echo esc_attr( houzez_get_property_status_rewrite_base() ); ?>" />
        </label>

    <?php }

    /**
     * Property feature rewrite base field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_property_feature_rewrite_base() { ?>

        <label>
            <code><?php echo esc_url( home_url( '/' ) ); ?></code>
            <input type="text" class="regular-text code" name="houzez_settings[property_feature_rewrite_base]" value="<?php echo esc_attr( houzez_get_property_feature_rewrite_base() ); ?>" />
        </label>

    <?php }

    /**
     * Property label rewrite base field callback.
     *
     * @since  2.0.6
     * @access public
     * @return void
     */
    public static function houzez_property_label_rewrite_base() { ?>

        <label>
            <code><?php echo esc_url( home_url( '/' ) ); ?></code>
            <input type="text" class="regular-text code" name="houzez_settings[property_label_rewrite_base]" value="<?php echo esc_attr( houzez_get_property_label_rewrite_base() ); ?>" />
        </label>

    <?php }

    /**
     * Property area rewrite base field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_property_area_rewrite_base() { ?>

        <label>
            <code><?php echo esc_url( home_url( '/' ) ); ?></code>
            <input type="text" class="regular-text code" name="houzez_settings[property_area_rewrite_base]" value="<?php echo esc_attr( houzez_get_property_area_rewrite_base() ); ?>" />
        </label>

    <?php }

    /**
     * Property city rewrite base field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_property_city_rewrite_base() { ?>

        <label>
            <code><?php echo esc_url( home_url( '/' ) ); ?></code>
            <input type="text" class="regular-text code" name="houzez_settings[property_city_rewrite_base]" value="<?php echo esc_attr( houzez_get_property_city_rewrite_base() ); ?>" />
        </label>

    <?php }

    /**
     * Property state rewrite base field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_property_state_rewrite_base() { ?>

        <label>
            <code><?php echo esc_url( home_url( '/' ) ); ?></code>
            <input type="text" class="regular-text code" name="houzez_settings[property_state_rewrite_base]" value="<?php echo esc_attr( houzez_get_property_state_rewrite_base() ); ?>" />
        </label>

    <?php }

    /**
     * Property country rewrite base field callback.
     *
     * @since  1.0.8
     * @access public
     * @return void
     */
    public static function houzez_property_country_rewrite_base() { ?>

        <label>
            <code><?php echo esc_url( home_url( '/' ) ); ?></code>
            <input type="text" class="regular-text code" name="houzez_settings[property_country_rewrite_base]" value="<?php echo esc_attr( houzez_get_property_country_rewrite_base() ); ?>" />
        </label>

    <?php }

	
}