<?php
class Houzez {

    /**
     * Plugin instance.
     *
     * @var Houzez
     */
    protected static $instance;


    /**
     * Plugin version.
     *
     * @var string
     */
    protected static $version = '2.0.7';


    /**
     * Constructor.
     */
    protected function __construct()
    {   
        $this->actions();
        $this->init();
        $this->houzez_inc_files();
        $this->filters();

        if( is_admin() ) {
            add_action( 'all_admin_notices', array($this, 'houzez_admin_agents_tabs') );
        }

        //add_action( 'current_screen', array( $this, 'conditional_includes' ) );

        do_action( 'houzez_core' ); 
    }

    /**
     * Return plugin version.
     *
     * @return string
     */
    public static function getVersion() {
        return static::$version;
    }

    /**
     * Return plugin instance.
     *
     * @return Houzez
     */
    protected static function getInstance() {
        return is_null( static::$instance ) ? new Houzez() : static::$instance;
    }

    /**
     * Initialize plugin.
     *
     * @return void
     */
    public static function run() {
        self::houzez_function_loader();
        self::houzez_class_loader();
        static::$instance = static::getInstance();

        if( get_option('houzez_custom_fields_update', 0) != 1 ) {
            self::houzez_ucfd_dummy();
        }
    }


    /**
     * include files
     *
     * @since 1.0
     *
    */
    function houzez_inc_files() {

        $fave_theme_name = (wp_get_theme()->Name);

        $activation_status = get_option( 'houzez_activation' );

        // Shourcodes
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/section-title.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/space.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/search.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-cards-v1.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-cards-v2.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-cards-v3.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-cards-v4.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-cards-v5.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-cards-v6.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-by-id.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-by-ids.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/recent-viewed-properties.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-carousel-v1.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-carousel-v2.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-carousel-v3.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/properties.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-carousel-v5.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/property-carousel-v6.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/properties-grids.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/grids.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/agents.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/testimonials.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/testimonials-v2.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/partners.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/blog-posts.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/blog-posts-carousel.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/team-member.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/price-table.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/properties-slider.php');
        require_once(HOUZEZ_PLUGIN_PATH . '/shortcodes/advance-search.php');

        //Elementor Page Builder
        if( $activation_status === 'activated' ) {
            require_once(HOUZEZ_PLUGIN_PATH . '/elementor/elementor.php');
        }


        /*---------------------------------------------
        * Include metaboxes
        * --------------------------------------------*/
        if ( ! class_exists( 'RW_Meta_Box' ) ) {
            if ( file_exists( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/meta-box.php' ) ) {
                include_once( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/meta-box.php' );
            }
        }

        if ( ! class_exists( 'MB_Tabs' ) ) {
            if ( file_exists( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/meta-box-tabs/meta-box-tabs.php' ) ) {
                include_once( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/meta-box-tabs/meta-box-tabs.php' );
            }
        }

        if ( ! class_exists( 'MB_Columns' ) ) {
            if ( file_exists( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/meta-box-columns/meta-box-columns.php' ) ) {
                include_once( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/meta-box-columns/meta-box-columns.php' );
            }
        }

        if ( ! class_exists( 'MB_Show_Hide' ) ) {
            if ( file_exists( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/meta-box-show-hide/meta-box-show-hide.php' ) ) {
                include_once( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/meta-box-show-hide/meta-box-show-hide.php' );
            }
        }

        if ( ! class_exists( 'RWMB_Group' ) ) {
            if ( file_exists( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/meta-box-group/meta-box-group.php' ) ) {
                include_once( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/meta-box-group/meta-box-group.php' );
            }
        }

        if ( ! class_exists( 'MB_Term_Meta_Box' ) ) {
            if ( file_exists( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/mb-term-meta/mb-term-meta.php' ) ) {
                include_once( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/mb-term-meta/mb-term-meta.php' );
            }
        }

        if ( ! class_exists( 'MB_Conditional_Logic' ) ) {
            if ( file_exists( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/meta-box-conditional-logic/meta-box-conditional-logic.php' ) ) {
                include_once( HOUZEZ_PLUGIN_PATH . '/extensions/meta-box/addons/meta-box-conditional-logic/meta-box-conditional-logic.php' );
            }
        }

        //paypal
        require_once(HOUZEZ_PLUGIN_PATH . '/third-party/3rdparty_functions.php');

        if( $activation_status === 'activated' ) {
            require_once(HOUZEZ_PLUGIN_PATH . '/demo-data/demo-importer.php');
        }
        

    }

    /**
     * Include admin files conditionally.
     */
    public function conditional_includes() {
        $screen = get_current_screen();

        if ( ! $screen ) {
            return;
        }

        switch ( $screen->id ) {
            case 'page':
                
                break;
        }
    }


    /**
     * Plugin actions.
     *
     * @return void
     */
    public function actions() {

    }

    /**
     * Add filters to the WordPress functionality.
     *
     * @return void
     */
    public function filters() {
        
    }

    public static function houzez_clean_meta_fields20($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }


    public static function houzez_ucfd_dummy() {
        $all_fields = Houzez_Fields_Builder::get_form_fields();

        if(!empty($all_fields)) {
            foreach ( $all_fields as $value ) {
                $id = $value->id;
                $slug = self::houzez_clean_meta_fields20($value->field_id);
                self::houzez_update_meta_key($value->field_id, $slug);
                self::houzez_update_cf($id, $slug);

                update_option('houzez_custom_fields_update', true);
            }
        }
    }

    public static function houzez_update_meta_key( $old_key=null, $new_key=null ){
        global $wpdb;

        $old_key = 'fave_'.$old_key;
        $new_key = 'fave_'.$new_key;

        $query = "UPDATE ".$wpdb->prefix."postmeta SET meta_key = '".$new_key."' WHERE meta_key = '".$old_key."'";
        $wpdb->query($query);
    }

    public static function houzez_update_cf($id, $slug) {
        global $wpdb;
        $query = "UPDATE ".$wpdb->prefix."houzez_fields_builder SET field_id = '".$slug."' WHERE id =".$id;
        $wpdb->query($query);
    }


    /**
     * Initialize classes
     *
     * @return void
     */
    public function init() {

        Houzez_Post_Type_Property::init();

        if(houzez_check_post_types_plugin('houzez_agencies_post')) {
            Houzez_Post_Type_Agency::init();
        }

        if(houzez_check_post_types_plugin('houzez_agents_post')) {
            Houzez_Post_Type_Agent::init();
        }

        if(houzez_check_post_types_plugin('houzez_testimonials_post')) {
            Houzez_Post_Type_Testimonials::init();
        }

        if(houzez_check_post_types_plugin('houzez_partners_post')) {
            Houzez_Post_Type_Partner::init();
        }

        if(houzez_check_post_types_plugin('houzez_invoices_post')) {
            Houzez_Post_Type_Invoice::init();
        }

        Houzez_Post_Type_Reviews::init();

        if(houzez_check_post_types_plugin('houzez_packages_post')) {
            Houzez_Post_Type_Membership::init();
        }

        HOUZEZ_Cron::init();
        
        if( is_admin() ) {

            if(houzez_check_post_types_plugin('houzez_packages_info_post')) {
                Houzez_Post_Type_Packages::init();
            }
            Houzez_Fields_Builder::init();
            Houzez_Currencies::init();
            Houzez_Changelog::init();
            Houzez_Post_Type::init();
            Houzez_Taxonomies::init();
            Houzez_Permalinks::init();

            FCC_API_Settings::init();
            Houzez_Menu::instance();

            FCC_Rates::init();
            if(isset($_GET['fcc-update']) && $_GET['fcc-update'] == 1) {
              FCC_Rates::update();
            }
        }

        add_action( 'admin_enqueue_scripts', array( __CLASS__ , 'enqueue_scripts' ) );

    }


    public static function enqueue_scripts() {
        $js_path = 'assets/admin/js/';
        $css_path = 'assets/admin/css/';

        wp_enqueue_style('houzez-admin-style', HOUZEZ_PLUGIN_URL . $css_path . 'style.css', array(), '1.0.0', 'all');
    }


    /**
     * Load plugin files.
     *
     * @return void
     */
    public static function houzez_class_loader()
    {
        $files = apply_filters( 'houzez_class_loader', array(
            HOUZEZ_PLUGIN_PATH . '/classes/class-property-post-type.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-agency-post-type.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-agent-post-type.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-reviews-post-type.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-membership-post-type.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-partners-post-type.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-testimonials-post-type.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-invoice-post-type.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-user-packages-post-type.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-fields-builder.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-permalinks.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-changelog.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-currencies.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-post-types.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-rates.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-cron.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-api-settings.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-taxonomies.php',
            HOUZEZ_PLUGIN_PATH . '/classes/class-menu.php',
        ) );

        foreach ( $files as $file ) {
            if ( file_exists( $file ) ) {
                include $file;
            }
        }
    }


    public static function houzez_function_loader() {
        $files = apply_filters( 'houzez_function_loader', array(
            HOUZEZ_PLUGIN_PATH . '/functions/functions-rewrite.php',
            HOUZEZ_PLUGIN_PATH . '/functions/functions-options.php',
            HOUZEZ_PLUGIN_PATH . '/functions/functions.php',
            
        ) );

        foreach ( $files as $file ) {
            if ( file_exists( $file ) ) {
                require_once $file;
            }
        }
    }


    /**
     * Comma separated taxonomy terms with admin side links
     *
     * @return boolean | term
     */
    public static function admin_taxonomy_terms( $post_id, $taxonomy, $post_type ) {

        $terms = get_the_terms( $post_id, $taxonomy );

        if ( ! empty ( $terms ) ) {
            $out = array();
            /* Loop through each term, linking to the 'edit posts' page for the specific term. */
            foreach ( $terms as $term ) {
                $out[] = sprintf( '<a href="%s">%s</a>',
                    esc_url( add_query_arg( array( 'post_type' => $post_type, $taxonomy => $term->slug ), 'edit.php' ) ),
                    esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $taxonomy, 'display' ) )
                );
            }
            /* Join the terms, separating them with a comma. */
            return join( ', ', $out );
        }

        return false;
    }


    /*
    * Render Form fields
    */
    public static function render_form_field( $label, $field_name, $type, $options = array() )
    {
        $template = '<div class="form-field">
                        <label>%s</label>
                        %s
                    </div>';

        $template = apply_filters( 'houzez_form_fields_template', $template, $label, $options );

        $options_string = null;
        $options['name'] = $field_name;
        $options['value'] = ! empty( $options['value'] ) ? $options['value'] : false;

        $multiple_options = isset( $options['options'] ) ? $options['options'] : '';
        unset($options['options']);
        
        foreach ( $options as $key => $value ) {
            if ( is_array( $value ) || ! $value ) continue;


            $options_string .= $key . '="' . $value . '" ';
        }

        switch ( $type ) {
            case 'checkbox':
                $field = "<input type='hidden' name='{$field_name}' value='0'/>
                          <input type='checkbox' {$options_string}>";
                break;

            case 'list':
            case 'select':
            case 'selectbox':
                $field = "<select {$options_string}>";

                if ( ! empty( $options['placeholder'] ) ) {
                    $field .= '<option value="">' . $options['placeholder'] . '</option>';
                }

                if ( ! empty( $options['values'] ) ) {
                    foreach ( $options['values'] as $pvalue => $plabel ) {
                        $field .= '<option value="' . $pvalue . '" '. selected( $pvalue, $options['value'], false ) .'>' .
                            ( is_string( $plabel ) ? $plabel : $plabel['label'] )
                            . '</option>';
                    }
                }

                $field .= '</select>';

                break;

            case 'textarea':
                    
                    $field = "<textarea type='" . $type . "' {$options_string}>".$multiple_options."</textarea>";
                    
                    break;    

            default:
                $field = "<input type='" . $type . "' {$options_string}>";
        }

        $template = sprintf( $template, $label, $field );

        return $template;
    }

    /*
     * Display tabs related to course in admin when user
     * viewing/editing course/category/tags.
     */
    function houzez_admin_agents_tabs() {
        if ( ! is_admin() ) {
            return;
        }
        $admin_tabs = apply_filters(
            'houzez_admin_tabs_info',
            array(

                10 => array(
                    "link" => "edit.php?post_type=houzez_agent",
                    "name" => __( "Agents", "houzez-theme-functionality" ),
                    "id"   => "edit-houzez_agent",
                ),

                20 => array(
                    "link" => "edit-tags.php?taxonomy=agent_category&post_type=houzez_agent",
                    "name" => __( "Categories", "houzez-theme-functionality" ),
                    "id"   => "edit-agent_category",
                ),
                30 => array(
                    "link" => "edit-tags.php?taxonomy=agent_city&post_type=houzez_agent",
                    "name" => __( "Cities", "houzez-theme-functionality" ),
                    "id"   => "edit-agent_city",
                ),

            )
        );
        ksort( $admin_tabs );
        $tabs = array();
        foreach ( $admin_tabs as $key => $value ) {
            array_push( $tabs, $key );
        }
        $pages              = apply_filters(
            'houzez_admin_tabs_on_pages',
            array( 'edit-houzez_agent', 'edit-agent_category', 'edit-agent_city', 'houzez_agent' )
        );
        $admin_tabs_on_page = array();
        foreach ( $pages as $page ) {
            $admin_tabs_on_page[ $page ] = $tabs;
        }


        $current_page_id = get_current_screen()->id;
        $current_user    = wp_get_current_user();
        if ( ! in_array( 'administrator', $current_user->roles ) ) {
            return;
        }
        if ( ! empty( $admin_tabs_on_page[ $current_page_id ] ) && count( $admin_tabs_on_page[ $current_page_id ] ) ) {
            echo '<h2 class="nav-tab-wrapper houzez-nav-tab-wrapper">';
            foreach ( $admin_tabs_on_page[ $current_page_id ] as $admin_tab_id ) {

                $class = ( $admin_tabs[ $admin_tab_id ]["id"] == $current_page_id ) ? "nav-tab nav-tab-active" : "nav-tab";
                echo '<a href="' . admin_url( $admin_tabs[ $admin_tab_id ]["link"] ) . '" class="' . $class . ' nav-tab-' . $admin_tabs[ $admin_tab_id ]["id"] . '">' . $admin_tabs[ $admin_tab_id ]["name"] . '</a>';
            }
            echo '</h2>';
        }
    }


    public static function houzez_plugin_activation()
    {

        global $wpdb;

        $table_name         = $wpdb->prefix . 'houzez_currencies';
        $charset_collate    = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
          id int(10) NOT NULL AUTO_INCREMENT,
          currency_name varchar(255) NOT NULL,
          currency_code varchar(55) NOT NULL,
          currency_symbol varchar(25) NOT NULL,
          currency_position varchar(25) NOT NULL DEFAULT 'before',
          currency_decimal int(10) NOT NULL,
          currency_decimal_separator varchar(10) NOT NULL DEFAULT '.',
          currency_thousand_separator varchar(10) NOT NULL DEFAULT ',',
          PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql );

        $table_name         = $wpdb->prefix . 'favethemes_currency_converter';
        $charset_collate    = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
          currency_code varchar(3) NOT NULL,
          currency_rate FLOAT NOT NULL,
          currency_data VARCHAR(5000) NOT NULL,
          `timestamp` TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
          UNIQUE KEY currency_code (currency_code)
        ) $charset_collate;";

        dbDelta( $sql );

        $table_name         = $wpdb->prefix . 'houzez_fields_builder';
        $charset_collate    = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
          id int(10) NOT NULL AUTO_INCREMENT,
          label varchar(255) NOT NULL,
          field_id varchar(255) NOT NULL,
          type varchar(25) NOT NULL,
          options text NULL,
          fvalues text NULL,
          is_search varchar(25) NULL,
          search_compare varchar(25) NULL,
          placeholder varchar(255) NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";

        dbDelta( $sql );


        $table_name         = $wpdb->prefix . 'houzez_search';
        $charset_collate    = $wpdb->get_charset_collate();
        $sql                = "CREATE TABLE $table_name (
           id mediumint(9) NOT NULL AUTO_INCREMENT,
           auther_id mediumint(9) NOT NULL,
           query longtext NOT NULL,
           email longtext DEFAULT '' NOT NULL,
           url longtext DEFAULT '' NOT NULL,
           time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
           UNIQUE KEY id (id)
       ) $charset_collate;";

        dbDelta( $sql );

        $table_name         = $wpdb->prefix . 'houzez_threads';
        $charset_collate    = $wpdb->get_charset_collate();
        $sql                = "CREATE TABLE $table_name (
           id mediumint(9) NOT NULL AUTO_INCREMENT,
           sender_id mediumint(9) NOT NULL,
           receiver_id mediumint(9) NOT NULL,
           property_id mediumint(9) NOT NULL,
           seen mediumint(9) NOT NULL,
           receiver_delete mediumint(9) NOT NULL DEFAULT '0',
           sender_delete mediumint(9) NOT NULL DEFAULT '0',
           time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
           UNIQUE KEY id (id)
       ) $charset_collate;";

        dbDelta( $sql );

        $table_name         = $wpdb->prefix . 'houzez_thread_messages';
        $charset_collate    = $wpdb->get_charset_collate();
        $sql                = "CREATE TABLE $table_name (
           id mediumint(9) NOT NULL AUTO_INCREMENT,
           created_by mediumint(9) NOT NULL,
           thread_id mediumint(9) NOT NULL,
           message longtext DEFAULT '' NOT NULL,
           attachments longtext DEFAULT '' NOT NULL,
           receiver_delete mediumint(9) NOT NULL DEFAULT '0',
           sender_delete mediumint(9) NOT NULL DEFAULT '0',
           time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
           UNIQUE KEY id (id)
       ) $charset_collate;";

        dbDelta( $sql );

        
        HOUZEZ_Cron::FCC_schedule_updates();

        if (!wp_next_scheduled('houzez_check_new_listing_action_hook')) {
            wp_schedule_event(time(), 'daily', 'houzez_check_new_listing_action_hook');
        }

        if (!wp_next_scheduled('houzez_check_new_listing_action_hook')) {
            wp_schedule_event(time(), 'weekly', 'houzez_check_new_listing_action_hook');
        }

        update_option( 'elementor_disable_typography_schemes', 'yes' );
        update_option( 'elementor_disable_color_schemes', 'yes' );

    }

    public static function houzez_plugin_deactivate()
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'houzez_search';
        $sql        = "DROP TABLE ". $table_name;

        $wpdb->query( $sql );

        wp_clear_scheduled_hook('houzez_check_new_listing_action_hook');
        wp_clear_scheduled_hook( 'favethemes_currencies_update' );

    }

    public function redirect($plugin) {
        if ( $plugin == HOUZEZ_PLUGIN_BASENAME ) {
            wp_redirect( 'admin.php?page=houzez_dashboard' );
            wp_die();
        }
    }

}
?>