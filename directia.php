<?php
/**
 * Plugin Name: Directia
 * Description: Directia is a professional, powerful, flexible, high quality directory plugin, you can create any kind of directory site. Help businesses everywhere get found through their listings by your directory website visitors.
 * Plugin URI: https://github.com/beyond88/directia
 * Author: Mohiuddin Abdul Kader
 * Author URI: https://github.com/beyond88
 * Version: 1.0.0
 * Text Domain:       directia
 * Domain Path:       /languages
 * Requires PHP:      5.6
 * Requires at least: 4.4
 * Tested up to:      5.7
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Directia {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0.0';

    /**
     * Class constructor
     */
    private function __construct() {
        //REMOVE THIS AFTER DEV
        error_reporting(E_ALL ^ E_DEPRECATED);

        $this->define_constants();

        register_activation_hook( DIRECTIA_FILE, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes a singleton instance
     *
     * @return \Directia
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'DIRECTIA_VERSION', self::version );
        define( 'DIRECTIA_FILE', __FILE__ );
        define( 'DIRECTIA_PATH', __DIR__ );
        define( 'DIRECTIA_URL', plugins_url( '', DIRECTIA_FILE ) );
        define( 'DIRECTIA_ASSETS', DIRECTIA_URL . '/assets' );
        define( 'DIRECTIA_BASENAME', plugin_basename( __FILE__ ) );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {
        new Root\Directia\Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Root\Directia\Ajax();
        }

        if ( is_admin() ) {
            new Root\Directia\Admin();
        } else {
            new Root\Directia\Frontend();
        }

        new Root\Directia\API();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new Root\Directia\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 */
function Directia() {
    return Directia::init();
}

// kick-off the plugin
Directia();
