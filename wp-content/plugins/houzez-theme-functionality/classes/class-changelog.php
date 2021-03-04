<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 16/01/18
 * Time: 3:20 PM
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Houzez_Changelog {
    
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        
    }


    /**
     * Render dashboard
     * @return void
     */
    public static function render()
    {
        $template = apply_filters( 'houzez_changelog_template_path', HOUZEZ_TEMPLATES . '/changelog.php' );

        if ( file_exists( $template ) ) {
            include_once( $template );
        }
    }

        
}
?>