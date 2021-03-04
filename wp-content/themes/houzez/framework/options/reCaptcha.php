<?php
global $houzez_opt_name, $allowed_html_array;
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Google reCaptcha', 'houzez' ),
    'id'     => 'google-recaptcha',
    'desc'   => '',
    'icon'   => 'el-icon-envelope el-icon-small',
    'fields'        => array(
        array(
            'id'       => 'enable_reCaptcha',
            'type'     => 'switch',
            'title'    => esc_html__( 'reCaptcha', 'houzez' ),
            'desc'     => esc_html__( 'Enable or disable Google reCaptcha on forms', 'houzez' ),
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id' => 'google_recaptcha_info',
            'type' => 'info',
            'title' => esc_html__('Google reCaptcha', 'houzez'),
            'style' => 'info',
            'desc' => __('<p>If you do not have keys already then visit <kbd>
            <a href = "https://www.google.com/recaptcha/admin">
                https://www.google.com/recaptcha/admin</a></kbd> to generate them.
        Set the respective keys in <kbd>Site Key</kbd> and
        <kbd>Secret Key</kbd></p>', 'houzez'),
            'required'  => array('enable_reCaptcha', '=', 1)
        ),
        array(
            'id'       => 'recaptha_type',
            'type'     => 'radio',
            'title'    => esc_html__( 'reCaptcha Version', 'houzez' ),
            'desc'     => esc_html__('Get new keys for V3 as V2 keys will not work!', 'houzez'),
            'options'  => array(
                'v2' => 'V2',
                'v3' => 'V3'
            ),
            'default'  => 'v2',
            'required'  => array('enable_reCaptcha', '=', 1)
        ),

        array(
            'id'       => 'recaptha_site_key',
            'type'     => 'text',
            'title'    => esc_html__( 'Site Key', 'houzez' ),
            'desc'     => esc_html__('Enter your Google reCaptha site key.', 'houzez'),
            'default'  => '',
            'required'  => array('enable_reCaptcha', '=', 1)
        ),

        array(
            'id'       => 'recaptha_secret_key',
            'type'     => 'text',
            'title'    => esc_html__( 'Secret Key', 'houzez' ),
            'desc'     => esc_html__('Enter your Google reCaptha Secret key.', 'houzez'),
            'default'  => '',
            'required'  => array('enable_reCaptcha', '=', 1)
        ),
    ),
));