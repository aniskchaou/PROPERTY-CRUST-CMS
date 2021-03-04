<?php
global $houzez_opt_name;

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Webhooks', 'houzez' ),
    'id'     => 'houzez-webhooks',
    'desc'   => '',
    'icon'          => 'el-icon-envelope el-icon-small',
    'fields'        => array(
    
        array(
            'id'       => 'houzez_webhook_url',
            'type'     => 'text',
            'title'    => esc_html__( 'Webhook URL', 'houzez' ),
            'subtitle'     => esc_html__( "Enter the integration URL (like Zapier) that will receive the form's submitted data.", 'houzez' ),
            'placeholder' => esc_html__( 'https://your-webhook-url.com' , 'houzez' ),
            'default'  => ''
        ),
        array(
            'id'       => 'webhook_property_agent_contact',
            'type'     => 'switch',
            'title'    => esc_html__( 'Property Agent Form', 'houzez' ),
            'subtitle' => esc_html__( 'Enable webhook for single property agent contact form.', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),
        array(
            'id'       => 'webhook_agent_contact',
            'type'     => 'switch',
            'title'    => esc_html__( 'Agent Profile Page Form', 'houzez' ),
            'subtitle' => esc_html__( 'Enable webhook for agent profile page form.', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),
        array(
            'id'       => 'webhook_agency_contact',
            'type'     => 'switch',
            'title'    => esc_html__( 'Agency Profile Page Form', 'houzez' ),
            'subtitle' => esc_html__( 'Enable webhook for agency profile page form.', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        ),
        array(
            'id'       => 'add_new_property',
            'type'     => 'switch',
            'title'    => esc_html__( 'Add New Property Form', 'houzez' ),
            'subtitle' => esc_html__( 'Enable webhook for add new property Form.', 'houzez' ),
            'default'  => 0,
            'on'       => esc_html__( 'Yes', 'houzez' ),
            'off'      => esc_html__( 'No', 'houzez' ),
        )
    
    ),
));