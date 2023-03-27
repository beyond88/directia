<?php

namespace Root\Directia;

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
        $this->setup_pages();
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
                    content LONGTEXT,
                    author int(5),
                    attachment_id bigint(50),
                    created_at datetime NOT NULL,
                    updated_at datetime NULL,
                    PRIMARY KEY (id)
                ) $charset_collate;";
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
        $is_error = empty( $wpdb->last_error );
        return $is_error;
    }

    /**
     * Setup all pages for directia
     *
     * @return void
     */
    public function setup_pages() {
        $meta_key = '_wp_page_template';

        // return if pages were created before
        $page_created = get_option( 'directia_pages_created', false );

        if ( $page_created ) {
            return;
        }

        $pages = [
            [
                'post_title' => __( 'Directia Listing Details', 'directia' ),
                'slug'       => 'directia-listing-details',
                'page_id'    => 'directia_listing_details',
                'content'    => '[directia_listing_details]',
            ]
        ];

        $directia_page_settings = [];

        if ( $pages ) {
            foreach ( $pages as $page ) {
                $page_id = $this->create_page( $page );

                if ( $page_id ) {
                    $directia_page_settings[ $page['page_id'] ] = $page_id;

                    if ( isset( $page['child'] ) && count( $page['child'] ) > 0 ) {
                        foreach ( $page['child'] as $child_page ) {
                            $child_page_id = $this->create_page( $child_page );

                            if ( $child_page_id ) {
                                $directia_page_settings[ $child_page['page_id'] ] = $child_page_id;

                                wp_update_post(
                                    [
										'ID'          => $child_page_id,
										'post_parent' => $page_id,
									]
                                );
                            }
                        }
                    }
                }
            }
        }

        update_option( 'directia_pages', $directia_page_settings );
        update_option( 'directia_pages_created', true );
    }

    /**
     * Create all listing pages
     *
     * @return void
     */
    public function create_page( $page ) {
        $meta_key = '_wp_page_template';
        $page_obj = get_page_by_path( $page['post_title'] );

        if ( ! $page_obj ) {
            $page_id = wp_insert_post(
                [
					'post_title'     => $page['post_title'],
					'post_name'      => $page['slug'],
					'post_content'   => $page['content'],
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'comment_status' => 'closed',
				]
            );

            if ( $page_id && ! is_wp_error( $page_id ) ) {
                if ( isset( $page['template'] ) ) {
                    update_post_meta( $page_id, $meta_key, $page['template'] );
                }

                return $page_id;
            }
        }

        return false;
    }
}
