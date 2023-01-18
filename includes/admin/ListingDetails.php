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
    function __construct($id) {

        global $wpdb; 
        $this->id = $id; 
        $this->table = $wpdb->prefix . 'directia';

    }

    /****
     * 
     * get listing details by id
     *  @params integer
     *  @return array
     * 
     */

    function getListing(){

        global $wpdb; 
        $listing = [];

        $sql = $wpdb->prepare( "SELECT * FROM $this->table WHERE id=%d", $this->id );
        $listing = $wpdb->get_results( $sql, ARRAY_A );

        return $listing;

    }


}
endif; 