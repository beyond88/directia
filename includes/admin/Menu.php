<?php

namespace Root\Directia\Admin;

/**
 * The Menu handler class
 */
class Menu 
{

    /**
     * Initialize the class
     */
    function __construct() 
    {
        add_action( 'admin_menu', [ $this, 'adminMenu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function adminMenu() 
    {
        $parentslug = 'directia';
        $capability = 'manage_options';
        $iconUrl = 'dashicons-analytics';

        $hook = add_menu_page( __( 'Listings', 'directia' ), __( 'Listings', 'directia' ), $capability, $parentslug, [ $this, 'pluginPage' ], $iconUrl, 50 );
        add_action( 'admin_head-' . $hook, [ $this, 'enqueueAssets' ] );
    }

    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueueAssets() 
    {
        wp_enqueue_style( 'directia-admin-boostrap' );
        wp_enqueue_style( 'directia-admin-style' );
        wp_enqueue_script( 'directia-admin-script' );
    }

    /**
     * Add plugin page
     *
     * @return void
     */
    public function pluginPage(){
        echo 'Hello world';
    }


}
