<?php 
namespace AA\WPUserReactionButton\Admin;

/**
 * Handle admin Notice
 * Add or remove
 */
class Screen{
    public function __construct(){
        add_action( 'admin_notices', [ $this, 'remove_all_notice' ] );
    }

    public function remove_all_notice() {
        $screen = get_current_screen();
        if ( $screen->base === 'toplevel_page_wp-user-reaction-button' || $screen->id === 'wp-user-reaction_page_wp-user-reaction-button-settings') {
            remove_all_filters( 'admin_notices' );
        }
    }
}
