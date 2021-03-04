<?php
global $houzez_opt_name, $allowed_html_array;
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Blog', 'houzez' ),
    'id'     => 'blog',
    'desc'   => '',
    'icon'   => 'el-icon-edit el-icon-small',
    'fields'        => array(
        array(
            'id'       => 'masorny_num_posts',
            'type'     => 'text',
            'title'    => esc_html__( 'Masonry Blog Template', 'houzez' ),
            'subtitle' => esc_html__( 'Number of posts to display on the Masonry blog pages', 'houzez' ),
            'desc'     => esc_html__( 'Enter the number of posts', 'houzez' ),
            'default'  => '12'
        ),
        array(
            'id'       => 'blog_featured_image',
            'type'     => 'switch',
            'title'    => esc_html__( 'Featured Image', 'houzez' ),
            'desc'     => esc_html__( 'Enable or disable the featured image', 'houzez' ),
            'subtitle' => esc_html__( 'Displayed on the single post page', 'houzez' ),
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),

        array(
            'id'       => 'blog_date',
            'type'     => 'switch',
            'title'    => esc_html__( 'Post Date', 'houzez' ),
            'desc'     => esc_html__( 'Enable or disable the post date', 'houzez' ),
            'subtitle' => esc_html__( 'Displayed on the blog, archive and single post page', 'houzez' ),
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),

        array(
            'id'       => 'blog_author',
            'type'     => 'switch',
            'title'    => esc_html__( 'Posts Author', 'houzez' ),
            'desc'     => esc_html__( 'Enable or disable the post author', 'houzez' ),
            'subtitle' => esc_html__( 'Displayed on the blog, archive and single post page', 'houzez' ),
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),

        array(
            'id'       => 'blog_tags',
            'type'     => 'switch',
            'title'    => esc_html__( 'Tags', 'houzez' ),
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),

        array(
            'id'       => 'blog_author_box',
            'type'     => 'switch',
            'title'    => esc_html__( 'Author Box', 'houzez' ),
            'desc'     => esc_html__( 'Enable or disable the author box', 'houzez' ),
            'subtitle' => esc_html__( 'Displayed on the single post page', 'houzez' ),
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),
        array(
            'id'       => 'blog_next_prev',
            'type'     => 'switch',
            'title'    => esc_html__( 'Next/Prev Post', 'houzez' ),
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),
        array(
            'id'       => 'blog_related_posts',
            'type'     => 'switch',
            'title'    => esc_html__( 'Related Posts', 'houzez' ),
            'default'  => 1,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),

    ),
));