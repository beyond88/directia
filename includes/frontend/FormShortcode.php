<?php

namespace Root\Directia\Frontend;

/**
 * Shortcode handler class
 */
class FormShortcode {

    /**
     * Initializes the class
     */
    function __construct() {
        add_shortcode( 'directia_listing_form', [ $this, 'directiaListingForm' ] );
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function directiaListingForm( $atts, $content = '' ) {
        wp_enqueue_script( 'directia-script' );
        wp_enqueue_style( 'directia-style' );

        $atts = shortcode_atts([
        ], $atts);

        if( is_user_logged_in() ) {
            $template = __DIR__ . '/views/form.php';
        } else {
            $template = __DIR__ . '/views/login.php';
        }

        if ( file_exists( $template ) ) {
            ob_start();
            include $template;
            return ob_get_clean();
        }

        return '';

    }
}