<?php
namespace AA\WPUserReactionButton\Frontend;

class Shortcode{
    public function __construct(){
        add_shortcode( 'wp_urb_reactions', 'icon_shortcode' );
    }

    public function icon_shortcode() {
        ob_start();
        $reaction = new \AA\WPUserReactionButton\Frontend\Reaction();

        $reaction->icon_html();

        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    
}