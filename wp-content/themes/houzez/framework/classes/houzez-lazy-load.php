<?php
if ( !class_exists( 'Houzez_LazyLoad_Images' ) ) {

class Houzez_LazyLoad_Images {

      static function init() {
        if ( is_admin() ) return;

        add_action( 'wp_head', array( __CLASS__, 'setup_filters' ), 99 );
      }

      static function setup_filters() {
        add_filter( 'the_content', array( __CLASS__, 'add_image_placeholders' ), 9999 );
        add_filter( 'post_thumbnail_html', array( __CLASS__, 'add_image_placeholders' ), 11 ); 
        add_filter( 'wp_get_attachment_image_attributes', array( __CLASS__, 'elementor_image_widget' ), 12 ); 
        
      }

      static function elementor_image_widget($attr){
        
        if ( ! isset( $attr['srcset'] ) ) {
          $attr['srcset'] = '';
        }
        return $attr;

      }

      static function add_image_placeholders( $content ) {
        if ( ! self::is_enabled() )
          return $content;

        if ( is_feed() || is_preview() )
          return $content;

        $matches = array();
        preg_match_all( '/<img[\s\r\n]+.*?>/is', $content, $matches );

        $search = array();
        $replace = array();

        $i = 0;

        foreach ( $matches[0] as $imgHTML ) {
          
          if ( ! preg_match( "/src=['\"]data:image/is", $imgHTML ) ) {
            $i++;

            $src = self::create_base64_string( $imgHTML );

            $replaceHTML = '';

            if ( false === strpos( $imgHTML, 'data-src' ) ) {
              $replaceHTML = preg_replace( '/<img(.*?)src=/is', '<img$1src="' . $src . '" data-src=', $imgHTML );
            } else {
              $replaceHTML = preg_replace( '/<img(.*?)src=(["\'](.*?)["\'])/is', '<img$1src="' . $src . '"', $imgHTML );
            }

            $replaceHTML = preg_replace( '/<img(.*?)srcset=/is', '<img$1srcset="" data-srcset=', $replaceHTML );

            $classes = 'houzez-lazyload';

            if ( preg_match( '/class=["\']/i', $replaceHTML ) ) {
              $replaceHTML = preg_replace( '/class=(["\'])(.*?)["\']/is', 'class=$1' . $classes . ' $2$1', $replaceHTML );
            } else {
              $replaceHTML = preg_replace( '/<img/is', '<img class="' . $classes . '"', $replaceHTML );
            }

            array_push( $search, $imgHTML );
            array_push( $replace, $replaceHTML );
          }
        }

        $search = array_unique( $search );
        $replace = array_unique( $replace );

        $content = str_replace( $search, $replace, $content );

        return $content;
      }

      static function is_enabled() {
        return houzez_option('lazyload_images', 0);
      }

      static function get_image_size( $html ) {
        preg_match_all( '/(height|width)=["\'](.*?)["\']/is', $html, $matches, PREG_PATTERN_ORDER );
        $size = array( 100, 100 );

        foreach ( $matches[1] as $key => $attr ) {
          $value = intval( $matches[2][ $key ] );

          if ( $attr === 'width' ) $size[0] = $value;
          if ( $attr === 'height' ) $size[1] = $value;
        }

        return $size;
      }

      static function create_base64_string( $imgHTML ) {
          list( $width, $height ) = self::get_image_size( $imgHTML );

          $svg = '<svg';
          $svg .= ' viewBox="0 0 ' . $width . ' ' . $height . '"';
          $svg .= ' xmlns="http://www.w3.org/2000/svg"';
          $svg .= '></svg>';
          return 'data:image/svg+xml,' . rawurlencode( $svg );
      }
  }

  add_action( 'init', array( 'Houzez_LazyLoad_Images', 'init' ) );
}
