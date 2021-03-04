<?php
/**
 * Partners
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 07/01/16
 * Time: 7:00 PM
 */
if( !function_exists('houzez_advanced_search') ) {
    function houzez_advanced_search($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'search_field' => '',
        ), $atts));

        ob_start();
        

        if(array_key_exists($search_field, houzez_search_builtIn_fields_elementor())) {
            get_template_part('template-parts/search/fields/'.$search_field);
            
        } else {

            houzez_get_custom_search_field($search_field);
            
        }
        
        
        $result = ob_get_contents();
        ob_end_clean();
        return $result;

    }

    //add_shortcode('houzez-partners', 'houzez_search');
}