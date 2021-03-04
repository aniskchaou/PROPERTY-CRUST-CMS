<?php
global $houzez_opt_name;
Redux::setSection( $houzez_opt_name, array(
    'title'      => esc_html__( 'Custom Code', 'houzez' ),
    'id'         => 'custom_code',
    'icon'       => 'el el-cog el-icon-small',
    'desc'       => '',
    'fields'     => array(
        array(
            'id'       => 'custom_css',
            'type'     => 'ace_editor',
            'title'    => esc_html__( 'CSS Code', 'houzez' ),
            'subtitle' => esc_html__( 'Paste your CSS code here.', 'houzez' ),
            'mode'     => 'css',
            'theme'    => 'monokai',
            'desc'     => '',
            'default'  => ""
        ),
        array(
            'id'       => 'custom_js_header',
            'type'     => 'ace_editor',
            'title'    => esc_html__( 'Custom JS Code', 'houzez' ),
            'subtitle' => esc_html__( 'Custom JavaScript/Analytics Header.', 'houzez' ),
            'mode'     => 'text',
            'theme'    => 'chrome',
            'desc'     => '',
            'default'  => ""
        ),
        array(
            'id'       => 'custom_js_footer',
            'type'     => 'ace_editor',
            'title'    => esc_html__( 'Custom JS Code', 'houzez' ),
            'subtitle' => esc_html__( 'Custom JavaScript/Analytics Footer.', 'houzez' ),
            'mode'     => 'text',
            'theme'    => 'chrome',
            'desc'     => '',
            'default'  => ""
        )
    )
) );