<?php

class ChatController extends AppController 
{
    var $uses = array('Group');
    var $name = 'Chat';

    function index()
    {
        App::import('Vendor', 'phpFreeChat', array('file' => 'phpfreechat'.DS.'src'.DS.'phpfreechat.class.php'));
	    Configure::write('debug', '0');
        $this->layout = '2col_layout';
        $this->Group->id = $this->ZTAuth->user('group_id');
        $group = $this->Group->read();
    	$params["serverid"] = md5(__FILE__);
    	$params["theme"] = "animated";
    	$params["theme_url"] = 'vendors/phpfreechat/themes/';
        $params["data_public_url"] = 'vendors/phpfreechat/data/public';
        $params["theme"] = 'msn';
        $params["language"] = 'ru_RU';
        $params["display_pfc_logo"] = false;
        $params["title"] = 'Бумер чат';
        $params["nick"] = $this->ZTAuth->user('username');
        $params["isadmin"] = $this->isAuthorized($this->ZTAuth->user('username'), $this->name, 'admin');
        $params["nickmeta"] = array('Статус'=>$group['Group']['user_status']);
        $params["nickmarker"] = false;
        $params["frozen_nick"] = true;
//        $params["debug"] = true;
//        $params["server_script_path"] = '../../vendors/phpfreechat/chat.php';
    	$chat = new phpFreeChat($params);
	    $this->set('chat', $chat->printChat(true));
    }
}
?>
