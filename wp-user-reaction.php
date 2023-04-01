<?php 
/**
 * Plugin Name: WP Reaction Button
 * Plugin URI:  https://almn.me
 * Description: A WordPress Plugin that helps you to add Reaction option to any POST type.
 * Version:     1.0
 * Author:      Al Amin
 * Author URI:  https://almn.me
 * Text Domain: wur
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * Requires at least: 5.4
 * Requires PHP: 7.0
 * Requires Plugins: 
 *
 * @package     WPUserReaction
 * @author      Al Amin
 * @copyright   2023 webnomadalamin
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 *
 * Prefix:      wur
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

require_once __DIR__ . '/vendor/autoload.php';

final class WP_User_Reaction_Button{

    /**
     * Plugin's version
     */

    const version = '1.0';

    private function __construct(){
        $this->define_constant();

        add_action( 'plugins_loaded', [ $this, 'activate' ] );
        add_action( 'init', [ $this, 'plugin_activate' ] );
    }

     /**
     * Initialzes a singleton instance
     * @return 
     */
    public static function init(){
        static $instance = false;

        if( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define plugin's constants
     * @return void
     */
    public function define_constant(){
        define( 'WPUR_VERSION', self::version );
        define( 'WPUR_PLUGIN', __FILE__ );
        define( 'WPUR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
        define( 'WPUR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
        define( 'WPUR_PLUGIN_ASSETS', WPUR_PLUGIN_URL . 'assets' );
    }

    /**
     * Plugin activation stuff
     *
     * @return void
     */
    public function activate(){

    }
    
    /**
     * Do stuff after activation
     *
     * @return void
     */
    public function plugin_activate(){
        load_plugin_textdomain( 'wur', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        new \AA\WPUserReactionButton\Assets(); 
        new \AA\WPUserReactionButton\Frontend();

        // Register the elementor widget
        add_action( 'elementor/widgets/widgets_registered', function() {
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \AA\WPUserReactionButton\Elementor\Widget() );
        });

        if( is_admin() ) {
            new \AA\WPUserReactionButton\Admin();
        }else{
        }
        
    }
}

// Call plugin class 
if( ! function_exists( 'wp_user_reaction_button' ) ) {
    function wp_user_reaction_button(){
        WP_User_Reaction_Button::init();
    }
}

// Kick-off the Plugin
if( function_exists( 'wp_user_reaction_button' ) ) {
    wp_user_reaction_button();
}

