<?php
global $houzez_opt_name, $allowed_html_array;
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'GDPR Agreement', 'houzez' ),
    'id'     => 'gdpr-agreement',
    'desc'   => '',
    'icon'   => 'el-icon-bookmark el-icon-small',
    'fields'        => array(
        
        array(
            'id'     => 'gdpr-info-for-add-property',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
            'title'  => esc_html__( 'GDPR for Add Property', 'houzez' ),
            'desc'   => ''
        ),
        array(
            'id'       => 'add-prop-gdpr-enabled',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable/Disable GRPR on add property page.', 'houzez' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 0,
            'on'       => 'Enabled',
            'off'      => 'Disabled',
        ),
        array(
            'id'       => 'add-prop-gdpr-label',
            'type'     => 'text',
            'title'    => esc_html__( 'GDPR Label.', 'houzez' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => 'I consent to having this website to store my submitted infomation, read more infomation below',
        ),
        array(
            'id'       => 'add-prop-gdpr-agreement-content',
            'type'     => 'textarea',
            'title'    => esc_html__( 'GDPR Description', 'houzez' ),
            'desc'     => '',
            'subtitle' => '',
            'default'  => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed risus lacus, sollicitudin at finibus at, pretium id dui. Nunc erat felis, pharetra id feugiat et, faucibus a justo. Donec eu condimentum nisi. Integer facilisis luctus massa, sit amet commodo nulla vehicula ac. Fusce vehicula nibh magna, in efficitur elit euismod eget. Quisque egestas consectetur diam, eu facilisis justo vestibulum a. Aenean facilisis volutpat orci. Mauris in pellentesque nulla. Maecenas justo felis, vestibulum non cursus sit amet, blandit et velit.

Vivamus a commodo urna. In hac habitasse platea dictumst. Ut tincidunt est sed accumsan aliquet. Sed fringilla volutpat bibendum. Nunc fermentum massa vitae iaculis pulvinar. Integer hendrerit auctor risus et luctus. Donec convallis luctus ultrices. Maecenas scelerisque sed purus ac hendrerit. Nulla vel facilisis magna.

Suspendisse hendrerit enim in tellus pharetra cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer sed laoreet nisl. Nullam feugiat ut enim id tempor. Nunc euismod nec dui at suscipit. Duis sit amet cursus nibh. Mauris tincidunt ante quis augue accumsan, quis porttitor ipsum bibendum. Vivamus congue arcu sit amet arcu imperdiet, a laoreet ligula auctor. Aliquam ultrices porttitor malesuada.

Mauris erat quam, condimentum quis lacinia sed, suscipit in nisi. Etiam eleifend tristique pellentesque. Duis a odio neque. Quisque mollis velit enim, in mollis arcu blandit vel. Praesent accumsan nisi odio, vitae semper neque faucibus in. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam pellentesque neque sem. Donec vehicula, lacus vitae gravida tempus, lorem felis faucibus est, sed dapibus velit tortor nec velit.

Aliquam convallis id metus eu venenatis. Morbi nec augue turpis. Suspendisse tincidunt massa vitae malesuada mollis. Donec suscipit feugiat porttitor. Sed pharetra auctor enim. Cras faucibus in metus eu ultrices. Mauris vitae vehicula sapien."
        ),

    

    ),
));