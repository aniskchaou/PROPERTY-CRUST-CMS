<?php
/*-----------------------------------------------------------------------------------*/
/*	Space
/*-----------------------------------------------------------------------------------*/

function houzez_space_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'height' => '50'
    ), $atts ) );
   return '<div style="clear:both; width:100%; height:'.$height.'px"></div>';
}
add_shortcode( 'houzez-space', 'houzez_space_shortcode' );
?>