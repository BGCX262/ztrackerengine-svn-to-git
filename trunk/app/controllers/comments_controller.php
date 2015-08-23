<?php

class CommentsController extends AppController 
{
    var $name = 'Comments';
    var $uses = array('Comment');

    function Add()
    {
        Configure::write('debug', '0');
        $this->layout = 'ajax';
        $data['torrent'] = $this->params['form']['tid'];
        $data['user'] = $this->ZTAuth->user('id');
        $data['text'] = $this->params['form']['comment'];
        $data['added'] = date('Y-m-d H:i:s');
        if(!empty($data['torrent']) && !empty($data['text']))
        {
            if($this->Comment->save($data))
                $this->set('result', '{success:true}');
            else
                $this->set('result', '{success:false}');
        } else
            $this->set('result', '{success:false, msg:"Incosistent data"}');
    }

    function Delete()
    {
        Configure::write('debug','0');
        $this->layout = 'ajax';
        if($this->isAuthorized($this->ZTAuth->user('username'), $this->name, 'delete') && isset($this->params['form']['id']))
        {
            $this->Comment->id = $this->params['form']['id'];
            $this->Comment->delete();
        }
    }
}
?>
