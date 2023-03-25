<?php
namespace AA\WPUserReactionButton\Frontend;

class Shortcode{
    public function __construct(){
        add_shortcode( 'wp_urb_reactions', [ $this, 'icon_shortcode' ] );
    }

    /**
     * Plugin's shortcode
     *
     * @return content
     */
    public function icon_shortcode() {
        ob_start();
        $reaction = new \AA\WPUserReactionButton\Frontend\Reaction();

        echo $reaction->icon_html();

        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    
}