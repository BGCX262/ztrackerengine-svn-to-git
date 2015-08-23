<?php

class PendingsController extends AppController
{
    var $name = 'Pendings';
    var $uses = array('Pending', 'User');

    function activateAccount()
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        if(empty($this->params['url']['key'])) {
            $this->redirect(array('controller' => 'home', 'action' => 'index'), null, true);
        }
        $key = $this->params['url']['key'];
        $data = $this->Pending->findByKey($key);
        if($data)
        {
            $uid = $data['Pending']['user_id'];
            $user = $this->User->findById($uid);
            if($user)
            {
                $user['User']['pending'] = 'no';
                $user['User']['secret'] = $this->User->mksecret();
                $user['User']['passkey'] = sha1($user['User']['username'].mktime().$user['User']['username']);
                $user['User']['group_id'] = 3;
                $this->User->save($user);
                $this->Pending->remove($data['Pending']['id']);

                $aro = new Aro();
                $arodata = $aro->findByForeign_key($uid);
                $newgroup = $aro->find('model LIKE "Group" AND foreign_key = 3');
                $arodata['Aro']['parent_id'] = $newgroup['Aro']['id'];
                $aro->save($arodata);

                $this->ZTAuth->fields = array('username' => 'username', 'password' => 'sha_hash');
                if($this->ZTAuth->login($user['User']))
                    $this->redirect(array('controller' => 'home', 'action' => 'index'), null, true);
            }
        }
    }
}
?>
