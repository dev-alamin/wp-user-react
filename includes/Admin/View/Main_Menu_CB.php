<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'Posts user reacted', 'wur' ); ?></h1>
    <table>
        <?php 
       // Define custom list table class
        class Reaction_List_Table extends WP_List_Table {
            
            function __construct() {
                parent::__construct( array(
                    'singular' => 'reaction',
                    'plural' => 'reactions',
                    'ajax' => false
                ) );
            }
            
            function column_default( $item, $column_name ) {
                switch( $column_name ) {
                    case 'reaction_counts':
                        return $item->reaction_counts > 0 ? $item->reaction_counts : 'No reaction';
                    case 'post_author':
                        return get_the_author_meta( 'display_name', $item->post_author );
                    default:
                    return '<a href="' . get_permalink( $item->ID ) . '">' . $item->post_title . '</a>';
                }
            }
            
            function get_columns() {
                return array(
                    'title' => 'Post Title',
                    'reaction_counts' => 'Number of Reactions',
                    'post_author' => 'Post Author'
                );
            }
            
            function prepare_items() {
                
                
                $total_items = wp_urb_get_reacted_posts();

                $per_page = 10;
                
                $this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );
                
                $paged = isset( $_REQUEST['paged'] ) ? max( 0, intval( $_REQUEST['paged'] ) - 1 ) : 0;
                $offset = $paged * $per_page;
                
                $this->items = wp_urb_get_data_for_list_table( $per_page, $offset );
                
                $this->set_pagination_args( array(
                    'total_items' => $total_items,
                    'per_page' => $per_page,
                    'total_pages' => ceil( $total_items / $per_page )
                ) );
            }
        }

        // Create instance of custom list table class and display it
        $reaction_list_table = new Reaction_List_Table();
        $reaction_list_table->prepare_items();
        $reaction_list_table->display();

        ?>
    </table>
    
</div>