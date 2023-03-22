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
        
        $setting = new \AA\WPUserReactionButton\Admin\Settings();

        $parent_slug = 'wp-user-reaction-button';
        $capability = 'manage_options';

            add_menu_page( 
            __( 'WP User Reaction', 'wur' ), 
            __( 'WP User Reaction', 'wur' ), 
            $capability, 
            $parent_slug, 
            [ $this, 'menu_page' ], 
            'dashicons-format-status',
            25 
        );

        add_submenu_page( 
            $parent_slug,  
            __( 'Overview', 'wur' ), 
            __( 'Overview', 'wur' ), 
            $capability, 
            'wp-user-reaction-button', 
            [ $this, 'menu_page']
        );
        
        add_submenu_page( 
            $parent_slug,  
            __( 'Settings', 'wur' ), 
            __( 'Settings', 'wur' ), 
            $capability, 
            'wp-user-reaction-button-settings', 
            [ $setting, 'settings_page']
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