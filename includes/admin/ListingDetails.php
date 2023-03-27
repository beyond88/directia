<?php

namespace Root\Directia\Admin;

/**
 * Listing details class
 */
if ( ! class_exists( 'ListingDetails' ) ) :
class ListingDetails {

    private $id;
    private $table; 

    /**
    * Constructor, we override the parent to pass our own arguments
    * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
    */
    public function __construct($id) {

        global $wpdb; 
        $this->id = $id; 
        $this->table = $wpdb->prefix . 'directia';

    }

    /**
     * 
     * Get listing details by id
     * 
     *  @params integer
     *  @return array
     * 
     */
    public function getListing(){

        global $wpdb; 
        $sql = $wpdb->prepare( "SELECT * FROM $this->table WHERE id=%d", $this->id );
        $listing = $wpdb->get_results( $sql, ARRAY_A );

        return $listing;

    }

    /**
     * 
     *  Retrieve listing status
     * 
     *  @params integer
     *  @return string
     * 
     */
    public function getListingStatus( $status ){

        $statusLabel = '';
        switch ($status) {
            case "1":
                $statusLabel = __('Publish', 'directia');
                break;
            case "2":
                $statusLabel = __('Draft', 'directia');
                break;
            case "3":
                $statusLabel = __('Spam', 'directia');
                break;
            default:
                $statusLabel = __('Draft', 'directia');
        }

        return $statusLabel; 

    }


}
endif; 