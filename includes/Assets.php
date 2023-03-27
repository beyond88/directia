<?php

namespace Root\Directia;

/**
 * Assets handlers class
 */
class Assets {

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts() {
        return [
            'directia-script' => [
                'src'     => DIRECTIA_ASSETS . '/js/frontend.js',
                'version' => filemtime( DIRECTIA_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            'directia-admin-script' => [
                'src'     => DIRECTIA_ASSETS . '/js/admin.js',
                'version' => filemtime( DIRECTIA_PATH . '/assets/js/admin.js' ),
                'deps'    => [ 'jquery', 'wp-util' ]
            ],
        

        ];
    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles() {
        return [
            'directia-style' => [
                'src'     => DIRECTIA_ASSETS . '/css/frontend.css',
                'version' => filemtime( DIRECTIA_PATH . '/assets/css/frontend.css' )
            ],
            'directia-admin-style' => [
                'src'     => DIRECTIA_ASSETS . '/css/admin.css',
                'version' => filemtime( DIRECTIA_PATH . '/assets/css/admin.css' )
            ],
        ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets() {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;

            wp_enqueue_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_enqueue_style( $handle, $style['src'], $deps, $style['version'] );
        }

        wp_localize_script( 'directia-script', 'directia', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'wp_rest' ),
            'error' => __( 'Something went wrong', 'directia' ),
            'user_id' => get_current_user_id(),
            'field_required' => __( 'All field is required!', 'directia' ),
            'site_url' => site_url('/').'wp-json',
            'button_text' => __( 'Submit', 'directia' ),
            'request_text' => __( 'Processing', 'directia' ),
            'login_text' => __( 'Login', 'directia' ),
        ] );
    }
}
