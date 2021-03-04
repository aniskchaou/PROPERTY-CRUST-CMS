<?php
if( !function_exists('houzez_posts_metaboxes') ) {

    function houzez_posts_metaboxes( $meta_boxes ) {
        $houzez_prefix = 'fave_';
        
        $meta_boxes[] = array(
            'id' => 'fave_format_gallery',
            'title' => esc_html__('Gallery Format', 'houzez' ),
            'post_types' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',

            'fields' => array(
                array(
                    'name' => esc_html__('Upload Gallery Images ', 'houzez' ),
                    'desc' => '',
                    'id' => $houzez_prefix . 'gallery_posts',
                    'type' => 'image_advanced',
                    'std' => ''
                )
            )
        );

        $meta_boxes[] = array(
            'id' => 'fave_format_video',
            'title' => esc_html__('Video Format', 'houzez' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',

            'fields' => array(
                array(
                    'name' => esc_html__('Add the video URL', 'houzez' ),
                    'desc' => '',
                    'id' => $houzez_prefix . 'video_post',
                    'type' => 'text',
                    'std' => '',
                    'desc'  => __('Exmaple https://vimeo.com/120596335', 'houzez' )
                )
            )
        );

        $meta_boxes[] = array(
            'id' => 'fave_format_audio',
            'title' => esc_html__('Audio Format', 'houzez' ),
            'pages' => array( 'post' ),
            'context' => 'normal',
            'priority' => 'high',

            'fields' => array(
                array(
                    'name' => esc_html__('Add SoundCloud Audio', 'houzez' ),
                    'desc' => '',
                    'id' => $houzez_prefix . 'audio_post',
                    'type' => 'text',
                    'std' => '',
                    'desc'  => esc_html__('Paste the page URL from SoundCloud', 'houzez' )
                )
            )
        );

        return apply_filters('houzez_posts_meta', $meta_boxes);

    }

    add_filter( 'rwmb_meta_boxes', 'houzez_posts_metaboxes' );
}