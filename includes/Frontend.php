<?php
namespace AA\WPUserReactionButton;

class Frontend{
    public function __construct(){

        new \AA\WPUserReactionButton\Frontend\Shortcode();
        $reaction = new \AA\WPUserReactionButton\Frontend\Reaction();

        $reaction->dispatch_reaction();
    }
}