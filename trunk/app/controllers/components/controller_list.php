<?php

class ControllerListComponent extends Object 
{
    var $name = 'ControllerList';

    function get()
    {
	$controllerClasses = Configure::listObjects('controller');
	
	foreach($controllerClasses as $controller)
	{
	    if($controller != 'App') {
		$filenName = strtolower($controller).'_controller.php';
		$file = CONTROLLERS.$fileName;
		require_once($file);
		$className = $controller.'Controller';
		$action = get_class_methods($className);
		foreach($actions as $k => $v) {
		    if($v{0} == '_') {
			unset($actions[$k]);
		    }
		}
		$parentActions = get_class_methods('AppController');
		$controllers[$controller] = array_diff($actions, $parentActions);
	    }
	}
	return $controllers;
    }
}
?>