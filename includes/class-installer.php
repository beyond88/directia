<?php

namespace Directia;

/**
 * Installer class
 */
class Installer {

    /**
     * Run the installer
     *
     * @return void
     */
    public function run() {
        $this->add_version();
        $this->create_tables();
    }

    /**
     * Add time and version on DB
     */
    public function add_version() {
        $installed = get_option( 'directia_installed' );

        if ( ! $installed ) {
            update_option( 'directia_installed', time() );
        }

        update_option( 'directia_version', DIRECTIA_VERSION );
    }

    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_tables() {
        global $wpdb;
        // set the default character set and collation for the table
        $charset_collate = $wpdb->get_charset_collate();

        // Check that the table does not already exist before continuing
        $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}directia` (
                    id bigint(50) NOT NULL AUTO_INCREMENT,
                    title TEXT,
                    content_type LONGTEXT,
                    author int(5),
                    attachment_id bigint(50),
                    created_at datetime NOT NULL,
                    updated_at datetime NOT NULL,
                    PRIMARY KEY (id)
                ) $charset_collate;";
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
        $is_error = empty( $wpdb->last_error );
        return $is_error;
    }
}
