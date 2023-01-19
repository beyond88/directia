<?php

namespace Root\Directia\Frontend;

/**
 * Listing Shortcode handler class
 */
class ListingShortcode {

    private $id;
    private $table; 

    /**
     * Initializes the class
     */
    function __construct() {

        global $wpdb;
        $this->table = $wpdb->prefix . 'directia';

        add_shortcode( 'directia_listings', [ $this, 'directiaListings' ] );
    }

    /**
     * Set id 
     *
     * @param  integer $atts
     * @param  string $content
     *
     * @return string
     */
    function setId( $id ) {
        return $this->id = $id;
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
        $sql = $wpdb->prepare( "SELECT * FROM $this->table ORDER BY id DESC");
        $listing = $wpdb->get_results( $sql, ARRAY_A );

        return $listing;

    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function directiaListings( $atts, $content = '' ) {
        wp_enqueue_script( 'directia-script' );
        wp_enqueue_style( 'directia-style' );

        $atts = shortcode_atts([
        ], $atts);

        $listing = $this->getListing();
        $template = __DIR__ . '/views/listings.php';

        if ( file_exists( $template ) ) {
            ob_start();
            include $template;
            return ob_get_clean();
        }

        return '';

    }
}