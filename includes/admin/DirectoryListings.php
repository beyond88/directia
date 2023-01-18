<?php

namespace Root\Directia\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Directory Listings Class to extend WP_List_Table
 */
if ( ! class_exists( 'DirectoryListings' ) ) :
class DirectoryListings extends \WP_List_Table {


    public $searchColumn = 'search_id';
    //public $searchBoxText = __('Search reviews', 'reviewx');


    /**
    * Constructor, we override the parent to pass our own arguments
    * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
    */
    function __construct() {

        parent::__construct( array(
            'singular'  => 'singular_name',     //singular name of the listed records
            'plural'    => 'plural_name',    //plural name of the listed records
            'ajax'      => false 
 
        ) );
 
    }

    private function table_data()
    {      
        global $wpdb;
        $tableName = $wpdb->prefix . 'directia';
        $data = [];
        
        if( isset( $_GET['s'] ) ){
           $search = $_GET['s'];
           $search = trim( $search );

           $sql = $wpdb->prepare( "SELECT * FROM %s WHERE CONCAT_WS('', title,content) LIKE %1$s ORDER BY id DESC", $tableName, $search );
           $listings = $wpdb->get_results( $sql, ARRAY_A );
        } else {
            $sql = "SELECT * FROM {$tableName} ORDER BY id DESC";
            $listings = $wpdb->get_results( $sql, ARRAY_A );
        }

        $data = $listings;
        return $data;
    }

    /**
    * Get a list of columns.
    *
    * @return array
    */
    public function get_columns() {

        return array(
            'cb' => '<input type="checkbox" />',
            'title' => wp_strip_all_tags( __( 'Title' ) ),
            'content' => wp_strip_all_tags( __( 'Content' ) ),
            'author' => wp_strip_all_tags( __( 'Author' ) ),
            'date' => wp_strip_all_tags( __( 'Date' ) ),
        );

    }

    /**
     * @param object $item
     */
    public function column_cb($item)
    {
        $id = $item['id'];
        ?>
        <input type="checkbox" name="<?php isset($name) ? _e($name) : _e('delete_listing[]') ?>" value="<?php echo esc_attr( $id ); ?>"/>
        <?php
    }

    /**
    * Prepares the list of items for displaying.
    */
    public function prepare_items() {
        
        global $wpdb;  
        $columns = $this->get_columns();
        $sortable = $this->get_sortable_columns();
        $hidden = $this->get_hidden_columns();
        $this->process_bulk_action();
        $data = $this->table_data();
        
        $totalitems = count($data);
        $user = get_current_user_id();
        $screen = get_current_screen();
        $option = $screen->get_option('per_page', 'option'); 
        $perpage = get_user_meta($user, $option, true) ? get_user_meta($user, $option, true) : 10;
        $this->_column_headers = array($columns,$hidden,$sortable); 
        if ( empty ( $per_page) || $per_page < 1 ) {
        
          $per_page = $screen->get_option( 'per_page', 'default' ); 
        }

        usort($data, function($a, $b){
            $orderby = ( !empty( $_REQUEST['orderby'] ) ) ? $_REQUEST['orderby'] : 'id'; //If no sort, default to title
            $order = ( !empty( $_REQUEST['order'] ) ) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
            $result = strcmp( $a[$orderby], $b[$orderby] ); //Determine sort order
            return ( $order==='asc' ) ? $result : -$result; //Send final sort direction to usort
        });
        $totalpages = ceil($totalitems/$perpage); 
        $currentPage = $this->get_pagenum();
        
        $data = array_slice($data,(($currentPage-1)*$perpage),$perpage);
        $this->set_pagination_args( array(
            "total_items" => $totalitems,
            "total_pages" => $totalpages,
            "per_page" => $perpage,
        ) );
            
        $this->items =$data;

    }

    /**
    * Generates content for a single row of the table.
    *
    * @param object $item The current item.
    * @param string $column_name The current column name.
    */
    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'title':
                    return esc_html( $item['title'] );
            case 'content':
                return esc_html( $item['content'] );
            case 'author':
                return esc_html( $item['author'] );
            case 'date':
                return esc_html( $item['created_at'] );
            return 'Unknown';
        }
    }

    /**
     * Decide which columns to activate the sorting functionality on
     * @return array $sortable, the array of columns that can be sorted by the user
     */
    public function get_sortable_columns() {
        $sortable_columns = [
            'title' => [ 'title',true ],
            'content' => [ 'content',true ],
            'author' => [ 'author',true ],
            'date' => [ 'date',true ],
        ]; 
        return $sortable_columns;
    }

    /**
    * Setup Hidden columns and return them
    *
    * @return array
    */
    public function get_hidden_columns()
    {
        return array();
    }

	/**
	 * Retrieves the list of bulk actions available for this table.
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$selected_status = $this->order_query_args['status'] ?? false;

		if ( array( 'trash' ) === $selected_status ) {
			$actions = array(
				'untrash' => __( 'Restore', 'directia' ),
				'delete'  => __( 'Delete permanently', 'directia' ),
			);
		} else {
			$actions = array(
				'trash'           => __( 'Move to Trash', 'directia' ),
			);
		}

		return $actions;
	}

    /**
    * Generates custom table navigation to prevent conflicting nonces.
    *
    * @param string $which The location of the bulk actions: 'top' or 'bottom'.
    */
    protected function display_tablenav( $which ) {
    ?>
        <div class="tablenav <?php echo esc_attr( $which ); ?>">
            <div class="alignleft actions bulkactions">
                <?php $this->bulk_actions( $which ); ?>
            </div>
            <?php
                $this->extra_tablenav( $which );
                $this->pagination( $which );
            ?>
            <br class="clear" />
        </div>
    <?php
    }

    /**
    * Generates content for a single row of the table.
    *
    * @param object $item The current item.
    */
    public function single_row( $item ) {
        echo '<tr>';
            $this->single_row_columns( $item );
        echo '</tr>';
    }

    /**
     * @return string|false
     */
    public function current_action()
    {
        return parent::current_action();
    }

    /**
     * Process Bulk Action
     *
     * @return void
     */
    public function process_bulk_action()
    {
        $doaction = $this->current_action();
        if ( $doaction ) {
            $comment_ids = $_REQUEST['delete_listing'];

            $approved   = 0;
            $unapproved = 0;
            $spammed    = 0;
            $unspammed  = 0;
            $trashed    = 0;
            $untrashed  = 0;
            $deleted    = 0;
            $redirect_to = remove_query_arg( array( 'trashed', 'untrashed', 'deleted', 'spammed', 'unspammed', 'approved', 'unapproved', 'ids' ), wp_get_referer() );

            wp_defer_comment_counting( true );

            foreach ( $comment_ids as $comment_id ) { // Check the permissions on each.
                if ( ! current_user_can( 'edit_comment', $comment_id ) ) {
                    continue;
                }

                switch ( $doaction ) {
                    case 'approve':
                        wp_set_comment_status( $comment_id, 'approve' );
                        $this->add_rating_into_total_rating_data($comment_id);
                        $approved++;
                        break;
                    case 'unapprove':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        wp_set_comment_status( $comment_id, 'hold' );
                        $unapproved++;
                        break;
                    case 'spam':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        wp_spam_comment( $comment_id );
                        $spammed++;
                        break;
                    case 'unspam':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        wp_unspam_comment( $comment_id );
                        $unspammed++;
                        break;
                    case 'trash':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        wp_trash_comment( $comment_id );
                        $trashed++;
                        break;
                    case 'untrash':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        wp_untrash_comment( $comment_id );
                        $untrashed++;
                        break;
                    case 'delete':
                        $this->deduct_rating_by_previous_comment_status($comment_id, $doaction);
                        CriteriaController::removeCriteria($comment_id);
                        Gatekeeper::removeLog($comment_id);
                        wp_delete_comment( $comment_id );
                        $deleted++;
                        break;
                }
            }

            if ( ! in_array( $doaction, array( 'approve', 'unapprove', 'spam', 'unspam', 'trash', 'delete' ), true ) ) {
                $screen = get_current_screen()->id;

                /** This action is documented in wp-admin/edit.php */
                $redirect_to = apply_filters( "handle_bulk_actions-{$screen}", $redirect_to, $doaction, $comment_ids ); // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
            }

            wp_defer_comment_counting( false );

            if ( $approved ) {
                $redirect_to = add_query_arg( 'approved', $approved, $redirect_to );
            }
            if ( $unapproved ) {
                $redirect_to = add_query_arg( 'unapproved', $unapproved, $redirect_to );
            }
            if ( $spammed ) {
                $redirect_to = add_query_arg( 'spammed', $spammed, $redirect_to );
            }
            if ( $unspammed ) {
                $redirect_to = add_query_arg( 'unspammed', $unspammed, $redirect_to );
            }
            if ( $trashed ) {
                $redirect_to = add_query_arg( 'trashed', $trashed, $redirect_to );
            }
            if ( $untrashed ) {
                $redirect_to = add_query_arg( 'untrashed', $untrashed, $redirect_to );
            }
            if ( $deleted ) {
                $redirect_to = add_query_arg( 'deleted', $deleted, $redirect_to );
            }
            if ( $trashed || $spammed ) {
                $redirect_to = add_query_arg( 'ids', join( ',', $comment_ids ), $redirect_to );
            }

            wp_safe_redirect( $redirect_to );
            exit;
        }

    }

    /**
     * @return object
     */
    public function get_listings_count()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'directia';
        $totals = (array) $wpdb->get_results("SELECT status, COUNT( * ) AS total FROM {$table} GROUP BY status", ARRAY_A );

        $listing_count = array(
            'all'               => 0,
            'trash'           => 0,
        );

        foreach ( $totals as $row ) {
            switch ( $row['status'] ) {
                case 'all':
                    $listing_count['all']        = $row['total'];
                    $listing_count['all']        += $row['total'];
                    break;                  
                case 'trash':
                    $listing_count['trash']        = $row['total'];
                    $listing_count['all']          += $row['total'];
                    break;
                default:
                    break;
            }
        }

        return (object) $listing_count;
    }

    /**
     * @global int $post_id
     * @global string $comment_status
     * @global string $comment_type
     */
    protected function get_views()
    {
        global $post_id, $listing_status;

        $status_links = array();
        $num_comments = $this->get_listings_count();
        $stati = array(
            /* translators: %s: Number of comments. */
            'all'       => _nx_noop(
                'All <span class="count">(%s)</span>',
                'All <span class="count">(%s)</span>',
                'comments',
                'directia'
            ), // Singular not used.

            /* translators: %s: Number of comments. */
            'trash' => _nx_noop(
                'Trash <span class="count">(%s)</span>',
                'Trash <span class="count">(%s)</span>',
                'comments',
                'directia'
            )
        );

        $link = admin_url('admin.php?page=directia');

        if ( ! empty( $listing_status ) && 'all' != $listing_status ) {
            $link = add_query_arg( 'listing_status', $listing_status, $link );
        }

        foreach ( $stati as $status => $label ) {
            $current_link_attributes = '';

            if ( $status === $listing_status ) {
                $current_link_attributes = ' class="current" aria-current="page"';
            }

            $link = add_query_arg( 'listing_status', $status, $link );
            if ( $post_id ) {
                $link = add_query_arg( 'p', absint( $post_id ), $link );
            }

            $status_links[ $status ] = "<a href='$link'$current_link_attributes>" . sprintf(
                    translate_nooped_plural( $label, $num_comments->$status ),
                    sprintf(
                        '<span class="%s-count">%s</span>',
                        ( 'moderated' === $status ) ? 'pending' : $status,
                        number_format_i18n( $num_comments->$status )
                    )
                ) . '</a>';
        }

        return apply_filters( 'listing_status_links', $status_links );
    }


}
endif; 