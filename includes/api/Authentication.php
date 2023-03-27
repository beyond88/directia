<?php

namespace Root\Directia\API;

use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * API Class
 */
class Authentication {

    private $restBase = 'directia-api/v1';

    /**
     * Initialize the class
     */
    function __construct() {
       add_action( 'rest_api_init', [ $this, 'register_api' ] );
    }

    /**
     * Register the API
     *
     * @return void
     */
    public function register_api() {

        register_rest_route( $this->restBase, '/login', [
            'methods'  => WP_REST_SERVER::CREATABLE,
            'callback' => [ $this, 'try_login' ],
            'permission_callback' => '__return_true'
        ]);

    }

    /**
     * Login
     *
     * @return void
     */
    public function try_login( WP_REST_Request $request ) {

        if (empty( $client_ip_address = $this->directia_client_ip() ) ) {
            die();
        }


        // Request the data send
        $params = $request->get_params();

        $client_key = 'login_attempt_' . $client_ip_address;
        $status_code = 200;
        $response = array(
            'isLoggedIn' => false,
            'errorMessage' => '',
        );

        if ((get_transient($client_key) !== false)) {
            $response['errorMessage'] = 'Slow down a bit';
        } elseif ( empty( $username = sanitize_text_field( $params['username'] ) ) ) {
            $response['errorMessage'] = 'No user name';
        } elseif ( empty( $password = sanitize_text_field( $params['password'] ) ) ) {
            $response['errorMessage'] = 'No password';
        } elseif ( !is_a( $user = wp_authenticate( $username, $password ), 'WP_User' ) ) {
            $response['errorMessage'] = 'Invalid login';
        } else {
            // Logged in OK.
            $response['isLoggedIn'] = true;
            // We need to do this so wp_send_json() can return the cookie in
            // our response.
            wp_set_auth_cookie(
                $user->ID,
                False// << This is the "remember me" option.
            );
        }

        if (! empty( $response['errorMessage'] ) ) {
            error_log( $response['errorMessage'] );
            set_transient($client_key, '1', DIRECTIA_LOGIN_RETRY_PAUSE);
        }
        wp_send_json(
            $response,
            $status_code
        );
        
    }

    /**
     * Get the IP address of the current browser.
     * 
     * @return string
     * */
    function directia_client_ip() {

        global $directia_client_ip;
        if (!is_null($directia_client_ip)) {
        // We've already discovered the browser's IP address.
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $directia_client_ip = filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $directia_client_ip = filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP);
        } else {
        $directia_client_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
        }
        return $directia_client_ip;

    }

}