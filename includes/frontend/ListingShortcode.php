<?php

namespace Root\Directia\Frontend;

/**
 * Listing Shortcode handler class
 */
class ListingShortcode {

    /**
     * Initializes the class
     */
    function __construct() {
        add_shortcode( 'directia_listings', [ $this, 'directiaListings' ] );
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

        $template = __DIR__ . '/views/listings.php';

        if ( file_exists( $template ) ) {
            ob_start();
            include $template;
            return ob_get_clean();
        }

        return '';

    }
}