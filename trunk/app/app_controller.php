<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

class AppController extends Controller {
    var $components = array('Acl', 'Session', 'ZTAuth', 'Menu', 'Sideblock', 'Onlineblock');
    var $view = 'Smarty';
    var $helpers = array('html', 'javascript', 'menu');
    var $uses=array('Group','User');
    var $json = null;
	
    var $allowed = array('home' => '*', 'pendings' => array('activateAccount'), 'users' => array('dologin','registersave','register','login','logout', 'messages', 'myprofile', 'getcountries', 'pending', 'forgotpass'));

    /*
     *
     *
     */
    function beforeRender()
    {
        $user=$this->ZTAuth->user();
        $group=$this->Group->findById($user['User']['group_id']);
        if(!empty($user))
        {
            $this->set('logined', '1');
            $this->set('group', $group['Group']['user_status']);
            $this->set('group_style', $group['Group']['status_style']);
            $this->set('username', $user['User']['username']);
            $this->set('avatar', $user['User']['avatar']);
            $this->set('uploaded', $user['User']['uploaded']);
            $this->set('downloaded', $user['User']['downloaded']);
            $this->User->save(array('id' => $user['User']['id'], 'last_access' => date("Y-m-d H:i:s")));
        } else {
            $this->set('logined', '0');
        }
        if($this->name != 'CakeError') {
            $this->set('UserMenu', $this->Sideblock->fetchUserMenu());
            $this->set('OnlineUsers', $this->Onlineblock->fetchOnlineBlock());
            $this->set('Stats', $this->Sideblock->fetchStats());
            $this->data = am($this->data, array('Menu' => $this->Menu->fetchData(&$this)));
        } else {
            $this->layout = '2col_layout';
        }
    }

    /*
     *
     */
	function beforeFilter()
	{
        $this->checkAuth();
	}
	
    /*
     *
     */
    function checkAuth()
	{
	    if(isset($this->ZTAuth))
	    {
    		$this->ZTAuth->userScope = array('User.enabled' => 'yes');
	    	$this->ZTAuth->loginAction = '/users/login';
    		$this->ZTAuth->loginRedirect = $this->webroot;
    		$this->ZTAuth->authorize = 'object';
    		$this->Auth->fields = array('username' => 'username', 'password' => 'sha_hash');
            $this->ZTAuth->loginError = 'No matching user found';
            $this->ZTAuth->object=$this;

            if(array_key_exists($this->viewPath, $this->allowed) && 
                ($this->allowed[$this->viewPath] == '*' || (is_array($this->allowed[$this->viewPath]) &&
                (in_array($this->action, $this->allowed[$this->viewPath]))))) {
                    $this->ZTAuth->allow();
                } else if($this->ZTAuth->user('group_id') == 2) {
                    $this->redirect('/users/pending');
                }
	    }
    }

    /*
     *
     */
    function isAuthorized($user, $controller, $action)
    {
        $aco = new Aco();
        $resource = $aco->findByAlias($controller."::".$action);
        if(!empty($resource)) {
            return $this->Acl->check($user, $controller."::".$action, '*');
        } else {
            return $this->Acl->check($user, $controller, 'read');
        }
    }

    /*
     *
     *
     */
    function ajax_encode($value)
    {
        if(function_exists('json_encode')) {
            return json_encode($value);
        } else {
	        App::import('vendor', 'ztracker/json');
    	    if($this->json == null)
    	    {
	    	    $this->json = new Services_JSON();
	        }
    	    return $this->json->encode($value);
	    }
    }
}
?>
