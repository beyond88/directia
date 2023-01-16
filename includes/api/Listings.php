<?php

namespace Root\Directia\API;

use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * API Class
 */
class Listings {

    private $restBase = 'directia-api/v1';

    /**
     * Initialize the class
     */
    function __construct() {
       add_action( 'rest_api_init', [ $this, 'registerApi' ] );
    }

    /**
     * Register the API
     *
     * @return void
     */
    public function registerApi() {

        register_rest_route( $this->restBase, '/listings', [
            'methods'  => WP_REST_SERVER::READABLE,
            'callback' => [ $this, 'getListings' ]
        ]);

        register_rest_route( $this->restBase, '/create-listing', [
            'methods'  => WP_REST_SERVER::CREATABLE,
            'callback' => [ $this, 'createListing' ]
        ]);

    }

    /**
     * Create listing
     *
     * @return void
     */
    public function getListings( WP_REST_Request $request ) {

        $results = [];
        return new \WP_REST_Response(
            [
                'success' => true,
                'data' => $results,
            ],
            200
        );
    }

    /**
     * Create listing
     *
     * @return void
     */
    public function createListing( WP_REST_Request $request ) {

        $results = [];
        return new \WP_REST_Response(
            [
                'success' => true,
                'data' => $results,
            ],
            201
        );
    }

}