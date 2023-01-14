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
        add_action( 'wp_enqueue_scripts', [ $this, 'registerAssets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'registerAssets' ] );
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function getScripts() {
        return [
            'directia-script' => [
                'src'     => DIRECTIA_ASSETS . '/js/frontend.js',
                'version' => filemtime( DIRECTIA_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            // 'directia-moment' => [
            //     'src'     => DIRECTIA_ASSETS . '/js/moment.min.js',
            //     'version' => filemtime( DIRECTIA_PATH . '/assets/js/moment.min.js' ),
            //     'deps'    => [ 'jquery' ]
            // ],    
            // 'directia-daterangepicker' => [
            //     'src'     => DIRECTIA_ASSETS . '/js/daterangepicker.js',
            //     'version' => filemtime( DIRECTIA_PATH . '/assets/js/daterangepicker.js' ),
            //     'deps'    => []
            // ],
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
    public function getStyles() {
        return [
            'directia-style' => [
                'src'     => DIRECTIA_ASSETS . '/css/frontend.css',
                'version' => filemtime( DIRECTIA_PATH . '/assets/css/frontend.css' )
            ],
            'directia-admin-style' => [
                'src'     => DIRECTIA_ASSETS . '/css/admin.css',
                'version' => filemtime( DIRECTIA_PATH . '/assets/css/admin.css' )
            ],
            // 'directia-daterangepicker' => [
            //     'src'     => DIRECTIA_ASSETS . '/css/daterangepicker.css',
            //     'version' => filemtime( DIRECTIA_PATH . '/assets/css/daterangepicker.css' )
            // ],
        ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function registerAssets() {
        $scripts = $this->getScripts();
        $styles  = $this->getStyles();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;

            wp_enqueue_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_enqueue_style( $handle, $style['src'], $deps, $style['version'] );
        }

        wp_localize_script( 'directia-admin-script', 'directia', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'directia-admin-nonce' ),
            'confirm' => __( 'Are you sure?', 'directia' ),
            'error' => __( 'Something went wrong', 'directia' )
        ] );
    }
}
