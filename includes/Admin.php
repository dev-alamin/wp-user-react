<?php
namespace AA\WPUserReactionButton;

class Admin{
    public function __construct(){
        new \AA\WPUserReactionButton\Admin\Menu(); // Trigger Admin Menu
        new \AA\WPUserReactionButton\Admin\Post_Action(); // Add new action to posts, pages
        new \AA\WPUserReactionButton\Admin\Screen();
    }
}