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

        global $wpdb;
        $table = $wpdb->prefix . 'directia';
        // Prepare array for output
        $msg = [];

        // Request the data send
        $params = $request->get_params();
        $attach_id = $this->imageUpload( $request );

        $title = $params['listing_title'];
        $content = $params['listing_content'];
        $author = $params['listing_user'];
        $date   = current_time( 'mysql' );
        $status = 1;

        $sql = $wpdb->prepare( "INSERT INTO ".$table." (title, content, author, attachment_id, created_at, updated_at, status) VALUES ( %s, %s, %d, %d, %s, %s, %d)", $title, $content, $author, $attach_id, $date, $date, $status );
        $a = $wpdb->query($sql);
        $id = $wpdb->insert_id;

        if( $id ){
            $msg['status'] = 'success';
            $msg['msg'] = __('Listing added successfully', 'directia');
        } else {
            $msg['status'] = 'error';
            $msg['msg'] = __('Something went wrong', 'directia');
        }

        return new \WP_REST_Response(
            $msg,
            201
        );
    }

    /**
     * Create listing
     *
     * @return integer
     */
    function imageUpload( $request ){

        $attach_id = 0;
        // Get the upload files
        $files = $request->get_file_params();

        // These files need to be included as dependencies when on the front end.
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        // Process images
        if (! empty( $files ) ) {
            $upload_overrides = array( 'test_form' => false );
            foreach ($files as $key => $file) {
                $attachment_id = media_handle_upload( $key, 0 );
                if ( is_wp_error( $attachment_id ) ) {
                    $attach_id = 0;
                } else {
                    $attach_id = $attachment_id;
                }
            }
        }

        return $attach_id; 

    }

}