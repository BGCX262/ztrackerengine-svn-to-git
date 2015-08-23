<?php

class AppError extends ErrorHandler {

	function __construct($method, $messages) {

		$params = Router::getParams();

		if (($method == 'missingController' || $method == 'missingAction') 
           && file_exists(VIEWS . DS . $params['controller'] . DS . $params['action'] . ".tpl")) {
			$this->controller =& new AppController();
			$this->controller->_set(Router::getPaths());
			$this->controller->params = $params;
			$this->controller->constructClasses();
			$this->controller->viewPath = $params['controller'];
			$this->controller->render($params['action']);
			e($this->controller->output);
			exit;
		}

		parent::__construct($method, $messages);
		exit();
	}

}
?>
