<?php
namespace AA\WPUserReactionButton;

/**
 * Frontent to handle
 * All the Frontend stuff
 * Call the other, child class
 */
class Frontend{
    public function __construct(){

        new \AA\WPUserReactionButton\Frontend\Shortcode();
        $reaction = new \AA\WPUserReactionButton\Frontend\Reaction();

        $reaction->dispatch_reaction();
    }
}