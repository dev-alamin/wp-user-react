<?php 
namespace AA\WPUserReactionButton\Admin;

class Settings{
    /**
     * Settings Admin Configure apge
     *
     * @return void
     */
    public function settings_page(){

        $file = __DIR__ . '/View/Settings/Settings.php';
        if( file_exists( $file ) ) {
            include $file; 
        }
    }
}