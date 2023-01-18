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

        $hook = add_menu_page( __( 'Directia', 'directia' ), __( 'Directia', 'directia' ), $capability, $parentslug, [ $this, 'pluginPage' ], $iconUrl, 50 );
        add_submenu_page( 'directia', __( 'Listing details', 'directia' ), __( 'Listing details', 'directia' ), $capability, 'listing-details', [ $this, 'listingDetails' ], 50 );
        add_action( 'admin_head-' . $hook, [ $this, 'enqueueAssets' ] );
        add_action( "load-".$hook, [ $this, 'addOptions' ] ); 

    }

    /**
     * Add option to control per page item
     *
     * @return void
     */
    function addOptions() {

        $option = 'per_page';
        $args = array(
            'label' => 'Results',
            'default' => 10,
            'option' => 'results_per_page'
        );
        add_screen_option( $option, $args );

    }

    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueueAssets() 
    {
        wp_enqueue_style( 'directia-admin-style' );
        wp_enqueue_script( 'directia-admin-script' );
    }

    /**
     * Add plugin page
     *
     * @return void
     */
    public function pluginPage() {
        
        $listing = new DirectoryListings();
        $template = __DIR__ . '/views/listings.php';

        if ( file_exists( $template ) ) {
            return include $template;
        }

        return '';
    }

    /**
     * Listing details page
     *
     * @return void
     */
    function listingDetails() {
        
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $listing = new ListingDetails($id);
        $template = __DIR__ . '/views/listing-details.php';

        if ( file_exists( $template ) ) {
            return include $template;
        }

        return '';
    }


}
