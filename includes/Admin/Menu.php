<?php 
namespace AA\WPUserReactionButton\Admin;

class Menu{
    public function __construct(){
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
    * Register a top Level Menu
    * Admin Menu
    * @return menu
    */
    public function admin_menu(){
            add_menu_page( 
            __( 'WP User Reaction', 'wur' ), 
            __( 'WP User Reaction', 'wur' ), 
            'manage_options', 
            'wp-user-reaction-button', 
            [ $this, 'menu_page' ], 
            'dashicons-format-status',
            25 
        );
    }

    /**
     * Admin Menu Callback
     *
     * @return HTML Content
     */
    public function menu_page(){
        echo 'Hello from Menu page';
    }
}