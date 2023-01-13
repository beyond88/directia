<?php

namespace Directia;

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
                'src'     => WOOTRIPLETEX_ASSETS . '/js/frontend.js',
                'version' => filemtime( WOOTRIPLETEX_PATH . '/assets/js/frontend.js' ),
                'deps'    => [ 'jquery' ]
            ],
            // 'directia-moment' => [
            //     'src'     => WOOTRIPLETEX_ASSETS . '/js/moment.min.js',
            //     'version' => filemtime( WOOTRIPLETEX_PATH . '/assets/js/moment.min.js' ),
            //     'deps'    => [ 'jquery' ]
            // ],    
            // 'directia-daterangepicker' => [
            //     'src'     => WOOTRIPLETEX_ASSETS . '/js/daterangepicker.js',
            //     'version' => filemtime( WOOTRIPLETEX_PATH . '/assets/js/daterangepicker.js' ),
            //     'deps'    => []
            // ],
            'directia-admin-script' => [
                'src'     => WOOTRIPLETEX_ASSETS . '/js/admin.js',
                'version' => filemtime( WOOTRIPLETEX_PATH . '/assets/js/admin.js' ),
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
                'src'     => WOOTRIPLETEX_ASSETS . '/css/frontend.css',
                'version' => filemtime( WOOTRIPLETEX_PATH . '/assets/css/frontend.css' )
            ],
            'directia-admin-style' => [
                'src'     => WOOTRIPLETEX_ASSETS . '/css/admin.css',
                'version' => filemtime( WOOTRIPLETEX_PATH . '/assets/css/admin.css' )
            ],
            // 'directia-daterangepicker' => [
            //     'src'     => WOOTRIPLETEX_ASSETS . '/css/daterangepicker.css',
            //     'version' => filemtime( WOOTRIPLETEX_PATH . '/assets/css/daterangepicker.css' )
            // ],
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

        wp_localize_script( 'directia-admin-script', 'directia', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'directia-admin-nonce' ),
            'confirm' => __( 'Are you sure?', 'directia' ),
            'error' => __( 'Something went wrong', 'directia' )
        ] );
    }
}
