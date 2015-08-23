<?php

class SmartyView extends View
{
    function __construct (&$controller)
	{
        parent::__construct($controller);
        App::import('Vendor', 'Smarty', array('file' => 'Smarty'.DS.'Smarty.class.php'));
		$this->Smarty = &new Smarty();
		// requires views be in a 'smarty' subdirectory, you can remove this limitation if you aren't using other inherited views that use .tpl as the extension
		//$this->subDir = 'smarty'.DS;		
		$this->ext= '.tpl';
		$this->Smarty->plugins_dir[] = VIEWS.'smarty_plugins'.DS;
		$this->Smarty->compile_dir = TMP.'smarty'.DS.'compile'.DS;
		$this->Smarty->cache_dir = TMP.'smarty'.DS.'cache'.DS;
		$this->Smarty->template_dir = VIEWS.DS;
		$this->Smarty->caching=false;
		$this->Smarty->config_dir = 'config';
		$this->Smarty->debugging = true;
		
	}

	function _render($___viewFn, $___data_for_view, $___play_safe = true, $loadHelpers = true, $cached = false)
    {
        if ($this->helpers != false && $loadHelpers === true)
		{
			$loadedHelpers =  array();
			$loadedHelpers = $this->_loadHelpers($loadedHelpers, $this->helpers);

			foreach(array_keys($loadedHelpers) as $helper)
			{
				$replace = strtolower(substr($helper, 0, 1));
				$camelBackedHelper = preg_replace('/\\w/', $replace, $helper, 1);

				${$camelBackedHelper} =& $loadedHelpers[$helper];
				if(isset(${$camelBackedHelper}->helpers) && is_array(${$camelBackedHelper}->helpers))
				{
					foreach(${$camelBackedHelper}->helpers as $subHelper)
					{
						${$camelBackedHelper}->{$subHelper} =& $loadedHelpers[$subHelper];
					}
				}
				$this->loaded[$camelBackedHelper] = (${$camelBackedHelper});
				$this->Smarty->assign_by_ref($camelBackedHelper, ${$camelBackedHelper});
			}
		}

		$this->register_functions();

		foreach($___data_for_view as $data => $value)
		{
			if(!is_object($data))
			{
				$this->Smarty->assign($data, $value);
			}
		}
		$this->Smarty->assign_by_ref('view', $this);
		return $this->Smarty->fetch($___viewFn);
	}

    function _getLayoutFileName() {
		$type = null;

		if (isset($this->plugin) && !is_null($this->plugin)) {
			if (file_exists(APP . 'plugins' . DS . $this->plugin . DS . 'views' . DS . 'layouts' . DS . $this->layout . $this->ext)) {
				$layoutFileName = APP . 'plugins' . DS . $this->plugin . DS . 'views' . DS . 'layouts' . DS . $this->layout . $this->ext;
				return $layoutFileName;
			}
		}
		$paths = Configure::getInstance();

		foreach($paths->viewPaths as $path) {
			if (file_exists($path . 'layouts' . DS . $this->subDir . $type . $this->layout . $this->ext)) {
				$layoutFileName = $path . 'layouts' . DS . $this->subDir . $type . $this->layout . $this->ext;
				return $layoutFileName;
			}
		}

		// added for .ctp viewPath fallback
		foreach($paths->viewPaths as $path) {
			if (file_exists($path . 'layouts' . DS  . $type . $this->layout . '.ctp')) {
				$layoutFileName = $path . 'layouts' . DS . $type . $this->layout . '.ctp';
				return $layoutFileName;
			}
		}

		if($layoutFileName = fileExistsInPath(LIBS . 'view' . DS . 'templates' . DS . 'layouts' . DS . $type . $this->layout . '.ctp')) {
		} else {
			$layoutFileName = LAYOUTS . $type . $this->layout.$this->ext;
		}
		return $layoutFileName;
	}


	function _getViewFileName($action) {
		$action = Inflector::underscore($action);
		$paths = Configure::getInstance();

		$type = null;
 
		if (empty($action)) {
			$action = $this->action;
		}

		$position = strpos($action, '..');

		if ($position === false) {
		} else {
			$action = explode('/', $action);
			$i = array_search('..', $action);
			unset($action[$i - 1]);
			unset($action[$i]);
			$action='..' . DS . implode(DS, $action);
		}

		foreach($paths->viewPaths as $path) {
			if (file_exists($path . $this->viewPath . DS . $this->subDir . $type . $action . $this->ext)) {
				$viewFileName = $path . $this->viewPath . DS . $this->subDir . $type . $action . $this->ext;
				return $viewFileName;
			}
		}

		// added for .ctp viewPath fallback
		foreach($paths->viewPaths as $path) {
			if (file_exists($path . $this->viewPath . DS . $type . $action . '.ctp')) {
				$viewFileName = $path . $this->viewPath . DS . $type . $action . '.ctp';
				return $viewFileName;
			}
		}

		if ($viewFileName = fileExistsInPath(LIBS . 'view' . DS . 'templates' . DS . 'errors' . DS . $type . $action . '.ctp')) {
		} elseif($viewFileName = fileExistsInPath(LIBS . 'view' . DS . 'templates' . DS . $this->viewPath . DS . $type . $action . '.ctp')) {
		} else {
			$viewFileName = VIEWS . $this->viewPath . DS . $this->subDir . $type . $action . $this->ext;
		}

		return $viewFileName;
	}

    function register_functions() {
		foreach(array_keys($this->loaded) as $helper) {
			if (method_exists($this->loaded[$helper], '_register_smarty_functions')) {
				$this->loaded[$helper]->_register_smarty_functions($this->Smarty);
			}
		}
	}
}
?>
