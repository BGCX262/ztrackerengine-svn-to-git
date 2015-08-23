<?php

class MenuComponent extends Object
{
    var $name = 'Menu';
    function fetchData(&$controller)
    {
        App::import('Model', 'Menu');
        $this->Menu = new Menu();
        return $this->Menu->findAllByCategory('1',null,'order asc');
    }
}

?>
