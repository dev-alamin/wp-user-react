<?php 
namespace AA\WPUserReactionButton;

class Assets{
    public function __construct(){
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }


    /**
     * Enqueue WP URB Assets
     *
     * @return void
     */
    public function enqueue_assets(){
        wp_enqueue_style( 'wp-user-reaction-button', WPUR_PLUGIN_ASSETS . '/css/style.css', [], fileatime(WPUR_PLUGIN_PATH . '/assets/css/style.css'), 'all' );
        
        wp_enqueue_script( 'wp-user-reaction-button', WPUR_PLUGIN_ASSETS . '/js/script.js', ['jquery'], fileatime(WPUR_PLUGIN_PATH . '/assets/js/script.js'), true );
        

        wp_localize_script('wp-user-reaction-button', 'wp_urb_reactions', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wpurb_reaction_nonce'),
        ));
    }
    
}