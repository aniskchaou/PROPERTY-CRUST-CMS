<?php
global $houzez_opt_name, $custom_fields_array;
Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Membership', 'houzez' ),
    'id'     => 'payment-membership',
    'desc'   => '',
    'icon'   => 'el-icon-credit-card el-icon-small',
    'fields'        => array(
        array(
            'id'       => 'enable_paid_submission',
            'type'     => 'select',
            'title'    => esc_html__('Enable Paid Submission', 'houzez'),
            'subtitle' => '',
            'desc'     => esc_html__('Select the submission type.', 'houzez'),
            'options'  => array(
                'no'   => esc_html__( 'No', 'houzez' ),
                'free_paid_listing'   => esc_html__( 'Free (Pay For Featured)', 'houzez' ),
                'per_listing'   => esc_html__( 'Per Listing', 'houzez' ),
                'membership'   => esc_html__( 'Membership', 'houzez' )
            ),
            'default'  => 'no',
        ),

        array(
            'id'       => 'houzez_disable_recurring',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Recurring Payments', 'houzez' ),
            'required' => array( 'enable_paid_submission', '=', 'membership' ),
            'desc'     => esc_html__( 'Enable or disable recurring option for PayPal & Stripe.', 'houzez' ),
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),

        array(
            'id'       => 'houzez_auto_recurring',
            'type'     => 'switch',
            'title'    => esc_html__( 'Auto Recurring Payments', 'houzez' ),
            'required' => array( 'houzez_disable_recurring', '=', '1' ),
            'desc'     => esc_html__( 'Enable auto recurring payments for PayPal & Stripe.', 'houzez' ),
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),

        array(
            'id'       => 'per_listing_expire_unlimited',
            'type'     => 'switch',
            //'required' => array('enable_paid_submission', '=', 'per_listing'),
            'title'    => esc_html__( 'Expire Days', 'houzez' ),
            'subtitle'     => esc_html__( 'Only for "Per Listings" and "Free (Pay for Featured)"', 'houzez' ),
            'desc' => esc_html__('Want to set single listing expire days?', 'houzez'),
            'default'  => 0,
            'on'       => 'Yes',
            'off'      => 'No',
        ),
        array(
            'id'       => 'per_listing_expire',
            'type'     => 'text',
            'required' => array( 'per_listing_expire_unlimited', '=', '1' ),
            'title'    => esc_html__('Number Of Expiring Days', 'houzez'),
            'subtitle' => esc_html__('It starts from the moment the property is published on the website', 'houzez'),
            'desc'     => esc_html__('Enter the number of days', 'houzez'),
            'default'  => '30',
        ),
        array(
            'id'       => 'currency_paid_submission',
            'type'     => 'select',
            'required' => array( 'enable_paid_submission', '!=', 'no' ),
            'title'    => esc_html__('Currency', 'houzez'),
            'subtitle' => '',
            'desc'     => esc_html__('Select the currency to use for paid submissions', 'houzez'),
            'options'  => array(
                'USD'  => 'USD',
                'EUR'  => 'EUR',
                'AUD'  => 'AUD',
                'ARS'  => 'ARS',
                'AZN'  => 'AZN',
                'BRL'  => 'BRL',
                'CAD'  => 'CAD',
                'CHF'  => 'CHF',
                'COP'  => 'COP',
                'CZK'  => 'CZK',
                'DKK'  => 'DKK',
                'HKD'  => 'HKD',
                'HUF'  => 'HUF',
                'IDR'  => 'IDR',
                'ILS'  => 'ILS',
                'INR'  => 'INR',
                'JMD'  => 'JMD',
                'JPY'  => 'JPY',
                'KOR'  => 'KOR',
                'KSH'  => 'KSH',
                'LKR'  => 'LKR',
                'MYR'  => 'MYR',
                'MXN'  => 'MXN',
                'MUR'  => 'MUR',
                'NGN'  => 'NGN',
                'NOK'  => 'NOK',
                'NZD'  => 'NZD',
                'PEN'  => 'PEN',
                'PHP'  => 'PHP',
                'PLN'  => 'PLN',
                'GEL'  => 'GEL',
                'GBP'  => 'GBP',
                'RON'  => 'RON',
                'RUB'  => 'RUB',
                'SGD'  => 'SGD',
                'SEK'  => 'SEK',
                'TWD'  => 'TWD',
                'THB'  => 'THB',
                'TRY'  => 'TRY',
                'VND'  => 'VND',
                'ZAR'  => 'ZAR'
            ),
            'default'  => 'USD',
        ),
        array(
            'id'       => 'price_listing_submission',
            'type'     => 'text',
            'required' => array( 'enable_paid_submission', '=', 'per_listing' ),
            'title'    => esc_html__('Submission Price', 'houzez'),
            'subtitle' => '',
            'desc'     => esc_html__('Enter the price to list a property', 'houzez'),
            'default'  => '',
        ),
        array(
            'id'       => 'price_featured_listing_submission',
            'type'     => 'text',
            'required' => array( 'enable_paid_submission', '!=', 'no' ),
            'title'    => esc_html__('Featured Price', 'houzez'),
            'subtitle' => '',
            'desc'     => esc_html__('Enter the price to feature a property', 'houzez'),
            'default'  => '',
        ),

        array(
            'id'       => 'paypal_api',
            'type'     => 'select',
            'required' => array( 'enable_paid_submission', '!=', 'no' ),
            'title'    => esc_html__('Paypal, Stripe and 2Checkout Api', 'houzez'),
            'subtitle' => esc_html__('Sandbox = test API. LIVE = real payments API', 'houzez'),
            'desc'     => esc_html__('Update PayPal, Stripe and 2Checkout settings according to API type selection', 'houzez'),
            'options'  => array(
                'sandbox'=> 'Sandbox',
                'live'   => 'Live',
            ),
            'default'  => 'sandbox',
        ),
        array(
            'id'       => 'payment_terms_condition',
            'type'     => 'select',
            'data'     => 'pages',
            'title'    => esc_html__( 'Terms & Conditions', 'houzez' ),
            'desc' => esc_html__( 'Select which page to use for Terms & Conditions', 'houzez' ),
            //'desc'     => '',
        ),
    ),
));


Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Thank You Page', 'houzez' ),
    'id'     => 'mem-thankyou',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'thankyou_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Title', 'houzez' ),
            'desc'     => esc_html__( 'Enter the page title', 'houzez' ),
            'subtitle' => '',
            'default'  => esc_html__( 'Thank you for your business with us', 'houzez' ),
        ),
        array(
            'id'       => 'thankyou_des',
            'type'     => 'editor',
            'title'    => esc_html__('Message', 'houzez'),
            'subtitle' => '',
            'desc'     => esc_html__( 'Enter the page message', 'houzez' ),
            'default'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer in augue rhoncus, congue neque eu, consequat quam. Maecenas in cursus dui, sed tempor est. Duis varius nibh in lorem venenatis, in tincidunt nunc scelerisque.',
            'args'   => array(
                'teeny'            => true,
                'textarea_rows'    => 10
            )
        ),

    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Payment Gateways', 'houzez' ),
    'id'     => 'payment-gateways',
    'desc'   => '',
    'icon'   => 'el-icon-credit-card el-icon-small',
    'fields' => array(
        array(
            'id'       => 'houzez_payment_gateways',
            'type'     => 'button_set',
            'title'    => __('Choose Payment gateway type', 'houzez'),
            'subtitle' => '',
            'desc'     => '',
            //Must provide key => value pairs for options
            'options' => array(
                'houzez_custom_gw' => 'Houzez Custom Gateways', 
                'gw_woocommerce' => 'WooCommerce', 
             ), 
            'default' => 'houzez_custom_gw'
        ),

        array(
            'id'     => 'woocommerce-info',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
            'title'  => wp_kses(__( 'Follow <a target="_blank" href="https://favethemes.zendesk.com/hc/en-us/articles/360045293072">WooCommerce Documentation</a>', 'houzez' ), $allowed_html_array),
            'subtitle' => __('"houzez-woo-addon" and "woocommerce" plugin required', 'houzez'),
            'desc'   => '',
            'required' => array('houzez_payment_gateways', '=', 'gw_woocommerce')
        ),
    )


));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Paypal Settings', 'houzez' ),
    'id'     => 'mem-paypal-settings',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'enable_paypal',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable PayPal', 'houzez' ),
            
            'desc'     => esc_html__( 'Enable or disable PayPal', 'houzez' ),
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'paypal_client_id',
            'type'     => 'text',
            'required' => array( 'enable_paypal', '=', '1' ),
            'title'    => esc_html__('Client ID', 'houzez'),
            'subtitle' => '',
            'desc'    => esc_html__('Enter the PayPal client ID', 'houzez'),
            'default'  => '',
        ),
        array(
            'id'       => 'paypal_client_secret_key',
            'type'     => 'text',
            'required' => array( 'enable_paypal', '=', '1' ),
            'title'    => esc_html__('Client Secret Key', 'houzez'),
            'subtitle' => '',
            'desc'    => esc_html__('Enter the PayPal client secret key', 'houzez'),
            'default'  => '',
        ),
        array(
            'id'       => 'paypal_receiving_email',
            'type'     => 'text',
            'required' => array( 'enable_paypal', '=', '1' ),
            'title'    => esc_html__('Receiving Email', 'houzez'),
            'subtitle' => '',
            'desc'    => esc_html__('Enter the PayPal receiving email account', 'houzez'),
            'default'  => '',
        ),
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Stripe Settings', 'houzez' ),
    'id'     => 'mem-stripe-settings',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'enable_stripe',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Stripe', 'houzez' ),
            
            'desc'     => esc_html__( 'Enable or disable Stripe', 'houzez' ),
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'stripe_secret_key',
            'type'     => 'text',
            'required' => array( 'enable_stripe', '=', '1' ),
            'title'    => esc_html__('Secret Key', 'houzez'),
            'subtitle' => esc_html__('Info is taken from your account at https://dashboard.stripe.com/login', 'houzez'),
            'desc'    => esc_html__('Enter the Stripe secret key', 'houzez'),
            'default'  => '',
        ),
        array(
            'id'       => 'stripe_publishable_key',
            'type'     => 'text',
            'required' => array( 'enable_stripe', '=', '1' ),
            'title'    => esc_html__('Publishable Key', 'houzez'),
            'subtitle' => esc_html__('Info is taken from your account at https://dashboard.stripe.com/login', 'houzez'),
            'desc'    => esc_html__('Enter the Stripe publishable key', 'houzez'),
            'default'  => '',
        ),
    )
));

Redux::setSection( $houzez_opt_name, array(
    'title'  => esc_html__( 'Direct Payment / Wire Payment', 'houzez' ),
    'id'     => 'mem-wire-payment',
    'desc'   => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'enable_wireTransfer',
            'type'     => 'switch',
            'title'    => esc_html__( 'Enable Wire Transfer', 'houzez' ),
            
            'desc'    => esc_html__('Enable or disable the Wire Transfert', 'houzez'),
            'subtitle' => '',
            'default'  => 0,
            'on'       => esc_html__( 'Enabled', 'houzez' ),
            'off'      => esc_html__( 'Disabled', 'houzez' ),
        ),
        array(
            'id'       => 'direct_payment_instruction',
            'type'     => 'editor',
            'required' => array( 'enable_wireTransfer', '=', '1' ),
            'title'    => esc_html__('Wire instructions', 'houzez'),
            'subtitle' => '',
            'desc'    => esc_html__('Enter the wire instructions and detail to send the payment', 'houzez'),
            'default'  => '',
            'args'   => array(
                'teeny'            => true,
                'textarea_rows'    => 10
            )
        ),
        array(
            'id'     => 'direct-pay-info',
            'type'   => 'info',
            'notice' => false,
            'style'  => 'info',
            'title'  => wp_kses(__( '<span class="font24">Direct pay / Wire Transfer</span>', 'houzez' ), $allowed_html_array),
            'desc'   => ''
        ),

        array(
            'id'       => 'thankyou_wire_title',
            'type'     => 'text',
            'title'    => esc_html__( 'Title', 'houzez' ),
            'desc'     => esc_html__( 'Enter the page title', 'houzez' ),
            'subtitle' => '',
            'default'  => 'Thank you. Your order has been received',
        ),
        array(
            'id'       => 'thankyou_wire_des',
            'type'     => 'editor',
            'title'    => esc_html__('Message', 'houzez'),
            'subtitle' => '',
            'desc'     => esc_html__( 'Enter the page message', 'houzez' ),
            'default'  => 'Make your payment directly into our bank account. Please use your Order ID as payment reference.',
            'args'   => array(
                'teeny'            => true,
                'textarea_rows'    => 10
            )
        ),
    )
));