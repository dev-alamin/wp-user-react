<?php 
namespace AA\WPUserReactionButton\Admin;

class Post_Action{
    public function __construct(){
        add_filter( 'page_row_actions', [ $this, 'post_stats' ], 10, 2 ); 
        add_filter( 'post_row_actions', [ $this, 'post_stats' ], 10, 2 );
    }

    /**
     * Add new action in POST
     * Like - Edit, Trash, Quick Edit etc
     *
     * @param action $actions
     * @param post $post
     * @return action
     */
    public function post_stats( $actions, $post ) {
         // Get the selected post type and position from the database
         $selected_post_type = get_option( 'wp_urb_selected_post_type' );

        if( in_array( get_post_type( ), $selected_post_type )  ) {
            // Add a new action link with the URL to the custom page
            $actions['reaction'] = '<a href="' . esc_url( admin_url( 'admin.php?page=wp-user-reaction-button' ) ) . '">Reaction Stats</a>';   
        }
        return $actions;
    }

    
}