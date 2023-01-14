<?php

namespace Root\Directia\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initializes the class
     */
    function __construct() {
        add_shortcode( 'directia', [ $this, 'renderShortcode' ] );
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function renderShortcode( $atts, $content = '' ) {
        wp_enqueue_script( 'directia-script' );
        wp_enqueue_style( 'directia-style' );

        return '<div class="directia-shortcode">Hello from Shortcode</div>';
    }
}