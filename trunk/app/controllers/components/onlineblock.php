<?php

class OnlineblockComponent extends Object
{
    var $name="Onlineblock";
    
    function startup(&$controller)
    {
        $this->controller =& $controller;
    }

    function fetchOnlineBlock()
    {
        App::import('Model', 'User');
        $this->User = new User();
        return $this->User->WhoOnline();
    }
}
?>
