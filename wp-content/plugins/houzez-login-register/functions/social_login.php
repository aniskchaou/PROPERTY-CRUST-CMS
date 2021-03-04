<?php
/**
 * Created by PhpStorm.
 * User: waqasriaz
 * Date: 29/03/16
 * Time: 12:02 AM
 */

/* -----------------------------------------------------------------------------------------------------------
 *  Login With Facebook
 -------------------------------------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_houzez_facebook_login_oauth', 'houzez_facebook_login_oauth' );
add_action( 'wp_ajax_houzez_facebook_login_oauth', 'houzez_facebook_login_oauth' );

if( !function_exists('houzez_facebook_login_oauth') ) {

    function houzez_facebook_login_oauth() {
        $dir = plugin_dir_path( __DIR__ ) . 'social/Facebook/'; 
        require_once $dir.'autoload.php';

        $dashboard_profile_link = houzez_get_dashboard_profile_link();

        $facebook_api    =  houzez_option('facebook_api_key');
        $facebook_secret =  houzez_option('facebook_secret');

        if(empty($facebook_api) || empty($facebook_secret)) {
            echo json_encode( array(
                'success' => false,
                'message' => esc_html__('Please enter facebook api & secret keys', 'houzez')
                ) );
            wp_die();
        }

        $fb = new Facebook\Facebook([
            'app_id' => $facebook_api,
            'app_secret' => $facebook_secret,
            'default_graph_version' => 'v3.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl( $dashboard_profile_link, $permissions );

        echo json_encode( array(
            'success' => true,
            'message' => esc_html__('Connecting to facebook, please wait...', 'houzez'),
            'url' => $loginUrl
        ));
        wp_die();
    }
}

if( !function_exists('houzez_facebook_login') ):

    function houzez_facebook_login($get_vars){
        if(session_id() == '') {
            session_start(); 
        }

        $dir = plugin_dir_path( __DIR__ ) . 'social/Facebook/';
        require $dir.'autoload.php';

        $dashboard_profile_link = houzez_get_dashboard_profile_link();

        $facebook_api    =  houzez_option('facebook_api_key');
        $facebook_secret =  houzez_option('facebook_secret');

        $fb = new Facebook\Facebook([
            'app_id' => $facebook_api,
            'app_secret' => $facebook_secret,
            'default_graph_version' => 'v3.2',
            'http_client_handler' => 'curl', // can be changed to stream or guzzle
            'persistent_data_handler' => 'session' // make sure session has started
        ]);

        if( isset( $get_vars['code'] ) )
        {
            $helper = $fb->getRedirectLoginHelper();
            // Trick below will avoid "Cross-site request forgery validation failed. Required param "state" missing." from Facebook
            $_SESSION['FBRLH_state'] = $_REQUEST['state'];
        }
        else
        {
            // login helper with redirect_uri
            $helper = $fb->getRedirectLoginHelper( $dashboard_profile_link );
        }


        // see if we have a code in the URL
        if( isset( $get_vars['code'] ) ) {
            // get new access token if we've been redirected from login page
            try {
                // get access token
                $access_token = $helper->getAccessToken();

                // save access token to persistent data store
                $helper->getPersistentDataHandler()->set( 'access_token', $access_token );
            } catch ( Exception $e ) {
                // error occured
                echo 'Exception 1: ' . $e->getMessage() . '';
            }

            // get stored access token
            $access_token = $helper->getPersistentDataHandler()->get( 'access_token' );
        }

        // check if we have an access_token, and that it's valid
        if ( $access_token && !$access_token->isExpired() )
        {
            // set default access_token so we can use it in any requests
            $fb->setDefaultAccessToken( $access_token );
            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get('/me?fields=first_name,last_name,email', $access_token);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            $user = $response->getGraphObject()->asArray();

            $profile_image_url = 'https://graph.facebook.com/'.$user['id'].'/picture?width=300&height=300';

            $fb_email       = $user['email'];
            $fb_firstname   = $user['first_name'];
            $fb_lastname    = $user['last_name'];
            $password       = $user['id'];

            $username = explode( '@', $fb_email );
            $username=  $username[0];
            $display_name = $fb_firstname.' '.$fb_lastname;

            houzez_register_user_social( $fb_email, $username, $display_name, $password, $profile_image_url );

            $info                   = array();
            $info['user_login']     = $username;
            $info['user_password']  = $password;
            $info['remember']       = true;
            $user_signon            = wp_signon( $info, false );

            if ( is_wp_error($user_signon) ){
                wp_redirect( home_url() );
                exit;
            } else {
                ///ueu
                wp_redirect( $dashboard_profile_link );  // redirect to any page
                exit;
            }


        }
        exit;

    }

endif;



/* -----------------------------------------------------------------------------------------------------------
 *  Login With Google
 -------------------------------------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_houzez_google_login_oauth', 'houzez_google_login_oauth' );
add_action( 'wp_ajax_houzez_google_login_oauth', 'houzez_google_login_oauth' );

if( !function_exists('houzez_google_login_oauth') ):

    function houzez_google_login_oauth(){

        $google_client_id      =  houzez_option('google_client_id');
        $google_client_secret  =  houzez_option('google_secret');
        $google_redirect_url   =  houzez_get_dashboard_profile_link();

        $dir = plugin_dir_path( __DIR__ ) . 'social/';
        require_once $dir.'google/Google_Client.php';
        require_once $dir.'google/contrib/Google_Oauth2Service.php';
        
        $client = new Google_Client();

        $client->setApplicationName('Login to Houzez');
        $client->setClientId($google_client_id);
        $client->setClientSecret($google_client_secret);
        $client->setRedirectUri($google_redirect_url);
        $client->setScopes(array('email', 'profile'));

        $google_oauthV2 = new Google_Oauth2Service($client);
        $authUrl = $client->createAuthUrl();


        print $authUrl;
        wp_die();
    }

endif;


/* --------------------------------------------------------------------------
 * Houzez login with google
 ---------------------------------------------------------------------------*/
if( !function_exists('houzez_google_oauth_login') ):

    function houzez_google_oauth_login(){
        $allowed_html   =   array();

        $dir = plugin_dir_path( __DIR__ ) . 'social/';
        require_once $dir.'google/Google_Client.php';
        require_once $dir.'google/contrib/Google_Oauth2Service.php';

        $google_client_id      =  houzez_option('google_client_id');
        $google_client_secret  =  houzez_option('google_secret');
        $google_redirect_url   =  houzez_get_dashboard_profile_link();

        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to Houzez');
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setScopes(array('email', 'profile'));

        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($_REQUEST['code'])) { 
            $code = sanitize_text_field ( wp_kses($_REQUEST['code'],$allowed_html) );
            $gClient->authenticate($code);
        }

        if ($gClient->getAccessToken()) {

            $dashboard_url     =   houzez_get_dashboard_profile_link();
            $user              =   $google_oauthV2->userinfo->get();

            $user_id           =   $user['id'];
            $display_name      =   wp_kses($user['name'], $allowed_html);
            $email             =   wp_kses($user['email'], $allowed_html);

            $first_name = $last_name = '';
            if(isset($user['family_name'])){
                $last_name = $user['family_name'];
            }  
            if(isset($user['given_name'])){
                $first_name = $user['given_name'];
            }

            $profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);

            $username = str_replace(' ', '.', $display_name);

            houzez_register_user_social( $email, $username, $display_name, $user_id, $profile_image_url );

            $wordpress_user_id = username_exists($username);
            wp_set_password( $user_id, $wordpress_user_id ) ;

            $info                   = array();
            $info['user_login']     = $username;
            $info['user_password']  = $user_id;
            $info['remember']       = true;
            $user_signon            = wp_signon( $info, false );



            if ( is_wp_error($user_signon) ){
                wp_redirect( home_url() );
            } else {
                ///ueu
                wp_redirect($dashboard_url);
            }
        }
    }

endif;

/* -----------------------------------------------------------------------------------------------------------
 *  Login With Yahoo
 -------------------------------------------------------------------------------------------------------------*/
add_action( 'wp_ajax_nopriv_houzez_yahoo_login', 'houzez_yahoo_login' );
add_action( 'wp_ajax_houzez_yahoo_login', 'houzez_yahoo_login' );

if( !function_exists('houzez_yahoo_login') ) {

    function houzez_yahoo_login() {

        //$dir = ABSPATH . 'wp-content/plugins/houzez-login-register/social/';
        $dir = plugin_dir_path( __DIR__ ) . 'social/';
        require $dir.'openid.php';

        $dashboard_profile_link = houzez_get_dashboard_profile_link();

        try {
            $openID = new LightOpenID( houzez_get_domain_openid() );

            if ( !$openID->mode ) {
                $openID->identity = 'https://me.yahoo.com';

                $openID->required = array(
                    'namePerson',
                    'namePerson/first',
                    'namePerson/last',
                    'contact/email',
                );
                $openID->optional = array('namePerson', 'namePerson/friendly');
                $openID->returnUrl = $dashboard_profile_link;

                print  $openID->authUrl();
                wp_die();

            }
        } catch (ErrorException $e) {
            echo $e->getMessage();
        }
    }
}

/* --------------------------------------------------------------------------
 * Open Id login
 ---------------------------------------------------------------------------*/
if( !function_exists('houzez_openid_login') ) {

    function houzez_openid_login($get_vars) {

        //$dir = ABSPATH . 'wp-content/plugins/houzez-login-register/social/';
        $dir = plugin_dir_path( __DIR__ ) . 'social/';
        require $dir.'openid.php';

        $openID = new LightOpenID(houzez_get_domain_openid());
        $allowed_html = array();

        if ( $openID->validate() ) {

            $dashboard_profile_link = houzez_get_dashboard_profile_link();
            $openID_identity = wp_kses($get_vars['openid_identity'], $allowed_html);

            if ( strrpos($openID_identity, 'yahoo') ) {
                $email = wp_kses($get_vars['openid_ax_value_email'], $allowed_html);
                $username = explode( '@', $email );
                $username=  $username[0];
                $display_name = wp_kses($get_vars['openid_ax_value_fullname'], $allowed_html);
                $openID_identity_pos = strrpos( $openID_identity, '/a/.' );
                $openID_identity = str_split( $openID_identity, $openID_identity_pos + 4 );
                $openID_identity_code = $openID_identity[1];
            }

            houzez_register_user_social( $email, $username, $display_name, $openID_identity_code, '' );

            $info = array();
            $info['user_login'] = $username;
            $info['user_password'] = $openID_identity_code;
            $info['remember'] = true;
            $user_logon = wp_signon( $info, false );

            if (is_wp_error( $user_logon )) {
                wp_redirect(home_url());
            } else {
                ///ueu
                wp_redirect( $dashboard_profile_link );
            }

        }
    }
}

/* --------------------------------------------------------------------------
 * Get domain open id
 ---------------------------------------------------------------------------*/
if( !function_exists('houzez_get_domain_openid') ) {
    function houzez_get_domain_openid()
    {
        $home_url = get_home_url();
        $home_url = str_replace('http://', '', $home_url);
        $home_url = str_replace('https://', '', $home_url);
        return $home_url;
    }
}


/* --------------------------------------------------------------------------
 * Register User Via Social ( )
 ---------------------------------------------------------------------------*/
if( !function_exists('houzez_register_user_social') ) {

    function houzez_register_user_social( $email, $username, $display_name, $password, $profile_image_url  )
    {

        $user_as_agent = houzez_option('user_as_agent');
        $full_name = explode(' ', $display_name );
        $first_name = $full_name[0];
        $last_name = $full_name[1];
        $user_role = get_option( 'default_role' );

        if ( email_exists($email) ) {

            if (username_exists( $username )) {
                return;
            } else {
                $userID = wp_create_user( $username, $password, ' ');

                if( !is_wp_error( $userID ) ) {
                    wp_update_user(array('ID' => $userID, 'display_name' => $display_name, 'first_name' => $first_name, 'last_name' => $last_name));
                    update_user_meta($userID, 'fave_author_custom_picture', $profile_image_url);

                    ///ueu
                    if ($user_as_agent == 'yes' && $user_role != 'houzez_buyer' && $user_role != 'subscriber' ) {
                        houzez_register_as_agent($username, $email, $userID, '', $profile_image_url);
                    }
                    houzez_wp_new_user_notification( $userID, $password );
                }
            }

        } else {

            if ( username_exists($username) ) {
                return;

            } else {
                $userID = wp_create_user( $username, $password, $email );

                if( !is_wp_error( $userID ) ) {
                    wp_update_user(array('ID' => $userID, 'display_name' => $display_name, 'first_name' => $first_name, 'last_name' => $last_name));
                    update_user_meta($userID, 'fave_author_custom_picture', $profile_image_url);

                    ///ueu
                    if ($user_as_agent == 'yes' && $user_role != 'houzez_buyer' && $user_role != 'subscriber' ) {
                        houzez_register_as_agent($username, $email, $userID, '', $profile_image_url);
                    }
                    houzez_wp_new_user_notification( $userID, $password );
                }
            }

        }

    }
}