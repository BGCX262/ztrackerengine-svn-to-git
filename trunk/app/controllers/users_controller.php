<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
uses("sanitize");

class UsersController extends AppController 
{
    var $name = 'Users';
    var $components = array('Acl','SwiftMailer');
    var $helpers = array('javascript');
    var $uses = array("User", "Torrent", "Message", "Peer", "Country", "Group", "Pending", "Friend");

    function manage()
    {
/*        $aro = new Aro();
        // mirgate normal users
        $users = $this->User->findAllByClass('3');
        foreach($users as $user)
        {
            $aro->create();
            $aro->save(array('Model' => 'User', 'foreign_key' => $user['User']['id'], 'alias'=>$user['User']['username'], 'parent_id' => 11));
        }
        $this->User->query('UPDATE users SET group_id = 5 WHERE class = 3');
*/
    }

    /**
     * messages 
     * 
     * @access public
     * @return void
     */

    function transferRatio()
    {
        Configure::write('debug', 0);
        $this->layout = 'ajax';
        $result = 'false'; $message = '';
        if(empty($this->params['form']['receiver']) || empty($this->params['form']['amount'])) 
            $message = 'Not enought params';
        else {
            $target_user = $this->User->findByUsername($this->params['form']['receiver']);
            if(!empty($target_user))
            {
                $amount = $this->params['form']['amount'];
                $dl = $this->ZTAuth->user('downloaded');
                $ul = $this->ZTAuth->user('uploaded');
                $cur_ratio = $dl > 0 ? $ul / $dl : 0;
                if($ul > $amount)
                    $target_ratio = $dl > 0 ? ($ul - $amount) / $dl : 0;
                else 
                    $target_ratio = 0.1;

                // process tranfer
                if($target_ratio > 0.2)
                {
                    $cur_user = $this->User->findById($this->ZTAuth->user('id'));
                    $cur_user['User']['uploaded'] -= $amount;
                    $this->User->save($cur_user);

                    $target_user['User']['uploaded'] += $amount;
                    $this->User->save($target_user);
                    $result = 'true';

                    // update session
                    $cuser = $this->Session->read($this->ZTAuth->sessionKey);
                    $cuser['uploaded'] = $cur_user['User']['uploaded'];
                    $this->Session->write($this->ZTAuth->sessionKey, $cuser);
                } else
                    $message = "Not enought ratio $target_ratio";
                
            } else
                $message = 'Invalid user';
        }
        $this->set('result', "{success:$result, msg:'".$message."'}");
    }

    function messages()
    {
        $this->layout = '2col_layout';
        $this->set('pageTitle', 'Личные сообщения');
    }

    /**
     * getmessages 
     * 
     * @access public
     * @return void
     */
    function getmessages()
    {
        Configure::write('debug','0');
        $this->layout = 'ajax';
        $this->Message->bindModel(array( 'belongsTo' => array('UserSender' => array('className' => 'User', 'foreignKey' => 'sender'))));
        $this->Message->bindModel(array( 'belongsTo' => array('UserReceiver' => array('className' => 'User', 'foreignKey' => 'receiver'))));

        if($this->params['form']["type"] == 'sended')
        {
            $messages = $this->Message->findAll('sender = '.$this->ZTAuth->user('id').' AND poster = '.$this->ZTAuth->user('id'), null, null, 0);
        } else {
            $messages = $this->Message->findAll('receiver = '.$this->ZTAuth->user('id').' AND poster = '.$this->ZTAuth->user('id'), null, null, 0);
        }
        $result = array();
        foreach($messages as $message) {
            $result[] = array(
                'id' => $message['Message']['id'],
                'subject' => $message['Message']['subject'],
                'body' => $message['Message']['msg'],
                'date' => $message['Message']['added'],
                'sender' => $message['UserSender']['username'],
                'receiver' => $message['UserReceiver']['username'],
                'new' => $message['Message']['unread'],
                'checked' => 'false'
            );
        }
        $this->set('result', $this->ajax_encode(array('messages' => $result)));
    }

    /**
     * sendmessage 
     * 
     * @access public
     * @return void
     */
    function sendmessage()
    {
        Configure::write('debug', '0');
        $this->layout='ajax';
        $receiver = $this->User->findByUsername($this->params['form']['receiver']);
        if(!empty($receiver)) 
        {
            $message = array(
                'sender' => $this->ZTAuth->user('id'),
                'receiver' => $receiver['User']['id'],
                'subject' => $this->params['form']['subject'] ? $this->params['form']['subject'] : "без темы",
                'msg' => $this->params['form']['body']
            );
            if($this->Message->sendMessage($message))
                $this->set('result', '{success:true}');
            else
                $this->set('result', '{success:false}');
        } else {
            $this->set('result', '{success: false, msg:"User '.$this->params['form']['receiver'].' not found"}');
        }
    }

    /**
     * delmessage 
     * 
     * @access public
     * @return void
     */
    function delmessage()
    {
        Configure::write('debug','0');
        $this->layout='ajax';

        $message = $this->Message->findById($this->params['form']['id']);
        if($message['Message']['poster'] != $this->ZTAuth->user('id'))
        {
            $this->set('result','{succes:false,msg:"message not found or hacking attempted!"}');
        } else {
            if($this->Message->del($this->params['form']['id']))
            {
                $this->set('result', '{succes:true}');
            } else {
                $this->set('result', '{success:false, msg:"Невозможно удалить запись номер '.$this->params['form']['id'].'. Сообщите администратору сайта."}');
            }
        }
    }
    
    /**
     * login 
     * 
     * @access public
     * @return void
     */
    function login()
    {
//        Configure::write('debug','0');
        $userid = $this->ZTAuth->user("id");
        if(!empty($userid) && $this->Session->valid())
        {
            $this->redirect(array('controller' => 'home', 'action' => 'index'), null, true);
        }
        $this->layout = 'login_layout';
    }

    /**
     * dologin 
     * 
     * @access public
     * @return void
     */
    function dologin()
    {
        Configure::write('debug', '0');
        $this->layout = 'ajax';
        $user_id=$this->ZTAuth->user('username');
        if(!empty($user_id))
        {
            $this->set('success', '{success:false,error:"Already logined"}');
        
        } else {
            if(!empty($this->data))
            {
                if(($user = $this->User->validateLogin($this->data['User'])) == true)
                {
                    $this->ZTAuth->fields = array('username' => 'username', 'password' => 'sha_hash');
                    if($this->ZTAuth->login($user))
                        $this->set('success', '{success:true}');
                    else
                        $this->set('success', '{success:false}');
                } else {
                    $this->set('success', '{success:false, msg:"User not found"}');
                }
            } else {
                $this->set('success', '{success:false}');
            }
        }
    }

    function forgotpass()
    {
        $this->layout = 'login_layout';
        if(!empty($this->data['User']))
        {
            fb($this->data['User']);
            $this->redirect(array('controller' => 'home', 'action' => 'index'), null, true);
        }
    }

    /**
     * index 
     * 
     * @access public
     * @return void
     */
    function index()
    {
        $this->layout='2col_layout';
        $san = new Sanitize();

        $filter = "";
        $limit = 10;
        $offset = 0;
        $url = $this->webroot."users/";

        if(!empty($this->params['url']['name'])) {
            $value = $san->escape($this->params['url']['name']);
            $filter = "u.username like '%$value%' OR u.title like '%$value%' OR u.info like '%$value%'";
            $url .= "?name=".$value;
        }

        if(!empty($this->params['url']['offset']) && is_numeric($this->params['url']['offset']))
            $offset = $san->paranoid($this->params['url']['offset']);

        if(empty($filter)) $filter="1";
        $sql =  "SELECT u.id, u.username, u.uploaded, u.downloaded, u.avatar, u.title, c.flagpic, g.status_style ".
            "FROM users u ".
            "LEFT JOIN groups g ON u.group_id = g.id ".
            "JOIN countries c ON u.country = c.id ".
            "WHERE $filter GROUP BY u.id LIMIT $limit OFFSET $offset";

        $tsql = "SELECT count(u.id) as total from users u WHERE $filter";
        $total = $this->User->query($tsql);
        $users = $this->User->query($sql);

        $this->set('total', $total[0][0]['total']);
        $this->set('offset', $offset);
        $this->set('request_url', $url);

        $this->set('users', $users);
        $this->set('pageTitle', 'Список пользователей');
    }

    /**
     * logout 
     * 
     * @access public
     * @return void
     */
    function logout()
    {
	    //$this->redirect->($this->Auth->logout());
	    //$this->Session->setFlash('Logout');
	    $this->redirect($this->ZTAuth->logout());
    }

    /**
     * myprofile 
     * 
     * @access public
     * @return void
     */
    function myprofile()
    {
        Configure::write('debug', '0');
        $curUser =  $this->User->findByUsername($this->ZTAuth->user('username'));
        $this->set('User', $curUser);
        $this->set('pageTitle', 'Конфигурация профиля');
    }

    /**
     * saveProfile 
     * 
     * @access public
     * @return void
     */
    function saveProfile()
    {
        Configure::write('debug','0');
        $this->layout = 'ajax';
        $this->data['User']['id'] = $this->ZTAuth->user('id');
        if($this->params['form']['gender']) $this->data['User']['gender'] = $this->params['form']['gender'];
        if($this->User->save($this->data['User']))
        {
            // update avatar in session
            if(!empty($this->data['User']['avatar']))
            {
                $cuser = $this->Session->read($this->ZTAuth->sessionKey);
                $cuser['avatar'] = $this->data['User']['avatar'];
                $this->Session->write($this->ZTAuth->sessionKey, $cuser);
            }
            $this->set('result', '{success:true}');
        } else {
            $this->set('result', '{success:false}');
        }
    }
    
    /**
     * getNotes 
     * 
     * @access public
     * @return void
     */
    function getNotes()
    {
        Configure::write('debug', '0');
        $this->layout='ajax';
        $curUser =  $this->User->findById($this->ZTAuth->user('id'));
        $this->set('result', $curUser['User']['info']);
    
    }

    /**
     * getgroups 
     * 
     * @access public
     * @return void
     */
    function getgroups()
    {
        Configure::write('debug','0');
        $this->layout = 'ajax';
        $groups = $this->Group->findAll();
        $result = array();
        foreach($groups as $group)
            $result[] = array('name' => $group['Group']['name'], 'id' => $group['Group']['id']);
        $this->set('result', $this->ajax_encode(array('groups' => $result)));
    }

    /**
     * getcountries 
     * 
     * @access public
     * @return void
     */
    function getcountries()
    {
        Configure::write('debug', '0');
        $this->layout = 'ajax';
        $countries = $this->Country->findAll();
        $result = array();
        foreach($countries as $country)
        {
            $result[] = array('name' => $country['Country']['name'], 'id' => $country['Country']['id']);
        }
        $this->set('result', $this->ajax_encode(array('countries' =>$result)));
    }

    /**
     * register 
     * 
     * @access public
     * @return void
     */
    function register()
    {
        $userid = $this->ZTAuth->user("id");
        if(!empty($userid) && $this->Session->valid())
        {
            $this->redirect(array('controller' => 'home', 'action' => 'index'), null, true);
        }

        $this->layout = 'login_layout';
    }

    /**
     * registersave 
     * 
     * @access public
     * @return void
     */
    function registersave()
    {
        Configure::write('debug', '0');
        $this->layout = 'ajax';
        if(!empty($this->data)) {
            $this->User->create();
            $this->data['User']['pending'] = 'yes';
            $this->data['User']['group_id'] = 2;
            $this->data['User']['added'] = date("Y-m-d H:i:s");
            if($this->User->findByUsername($this->data['User']['username'])) {
            	$this->set('success','{success:false,errors:[{"id":"data[User][username]","msg":"Такой пользователь уже есть"}]}');
            } else 
                if($this->User->findByEmail($this->data['User']['email'])) {
        	        $this->set('success','{success:false,errors:[{"id":"data[User][email]","msg":"Этот почтовый ящик уже используется"}]}');
                } else
                    if($this->User->save($this->data)) {
                        $uid = $this->User->getLastInsertID();
                        $key = $this->Pending->AddPending($uid);
                        if($key)
                        {
                            $this->_newUserEmail($this->data, $key);
                        }

                        // update ARO alias to reflect username
                        $aro = new Aro();
                        $obj = $aro->findByForeign_Key($uid);
                        $obj['Aro']['alias'] = $this->data['User']['username'];
                        $aro->save($obj);

                        $us['username'] = $this->data['User']['username'];
                        $us['sha_hash'] = $this->data['User']['sha_hash'];

                        $this->ZTAuth->fields = array('username' => 'username', 'password' => 'sha_hash');
                        if(!$this->ZTAuth->login($us)) 
                        {
                            $this->set('success','{success:true, msg:"login failed"}');
                        } else
                            $this->set('success','{success:true}');
                    } else {
                        $this->set('success','{success:false}');
            }
        }
    }

    /**
     * getuploads 
     * 
     * @access public
     * @return void
     */
    function getuploads()
    {
        Configure::write('debug','0');
        $this->layout='ajax';
        $this->Torrent->unbindModel(array('belongsTo' => array('Owner'), 'hasMany' => array('Comments')));
        $this->Torrent->bindModel(array('belongsTo' => array('Category' => array('className' => 'Category', 'foreignKey' => 'category'))));
        $this->Torrent->recursive = 0;
        $torrents = $this->Torrent->findAllByOwner($this->params['form']['user']);
        $result = array();
        foreach($torrents as $torrent)
        {
            $result[] = array(
                'id' => $torrent['Torrent']['id'], 
                'name' => $torrent['Torrent']['name'], 
                'category' => $torrent['Category']['image'],
                'completed' => $torrent['Torrent']['times_completed'],
                'leechers' => $torrent['Torrent']['leechers']);
        }
        $this->set('result', $this->ajax_encode(array('torrents' => $result)));
    }

    /**
     * getconnects 
     * 
     * @access public
     * @return void
     */
    function getconnects()
    {
        Configure::write('debug', '0');
        $this->layout='ajax';
        $this->Peer->bindModel(array('belongsTo' => array('User' => array('className' => 'User', 'foreignKey' => 'userid'))));
        $this->Peer->bindModel(array('belongsTo' => array('Torrent' => array('className' => 'Torrent', 'foreignKey' => 'torrent'))));
        $this->Torrent->bindModel(array('belongsTo' => array('Category' => array('className' => 'Category', 'foreignKey' => 'category'))));

        $this->Peer->recursive=2;
        $peers = $this->Peer->findAllByUserid($this->params['form']['user']);
        $result = array();
        foreach($peers as $peer)
        {
            $result[] = array(
                'name' => $peer['Torrent']['name'],
                'leechers' => $peer['Torrent']['leechers'],
                'seeders' => $peer['Torrent']['seeders'],
                'category' => $peer['Torrent']['Category']['image'],
            );
        }
        $this->set('result', $this->ajax_encode(array('torrents' => $result)));

    }

    /**
     * mksize 
     * 
     * @param mixed $bytes 
     * @access public
     * @return void
     */
    function mksize($bytes)
    {
        if(is_numeric($bytes)) {
            if ($bytes < 1000 * 1024)
                return number_format($bytes / 1024, 2) . " kB";
            elseif ($bytes < 1000 * 1048576)
                return number_format($bytes / 1048576, 2) . " MB";
            elseif ($bytes < 1000 * 1073741824)
                return number_format($bytes / 1073741824, 2) . " GB";
            else
                return number_format($bytes / 1099511627776, 2) . " TB";
        } 
    }


    /**
      
     * 
     * @param mixed $id 
     * @access public
     * @return void
     */
    function view($id = null) 
    {
        Configure::write('debug','0');
        if($id == null)
            $this->redirect($this->webroot."users/view/".$this->ZTAuth->user('id'));
        $this->layout='2col_layout';
        $vuser = $this->User->findById($id);
        $this->Acl->check($this->ZTAuth->user('username'), "Users::edit", '*')? $this->set('can_edit', true) : $this->set('can_edit', false);
        $this->set('user', $vuser);
        $this->set('pageTitle', 'Просмотр профиля '.$vuser['User']['username']);
        if($vuser['User']['id'] == $this->ZTAuth->user('id'))
        {
            $this->set('self', true);
        } else {
            $this->set('self', false);
        }
    }

    function delfriend()
    {
        Configure::write('debug','0');
        $this->layout = 'ajax';
        if(!empty($this->params['form']['fid']))
        {
            $message = array(
                'sender' => $this->ZTAuth->user('id'),
                'receiver' => $this->params['form']['fid'],
                'subject' => "Вас удалили из друзей",
                'msg' => "Пользователь ".$this->ZTAuth->user('username')." удалил Вас из свего списка друзей."
            );

            $this->Message->sendMessage($message, false);

            if($this->Friend->delFriend($this->ZTAuth->user('id'), $this->params['form']['fid']))
                $this->set('result', '{success:true}');
        } else
            $this->set('result','{success:false}');
    }


    function addfriend()
    {
        Configure::write('debug', '0');
        $this->layout = 'ajax';
        if(!empty($this->params['form']['fid']))
        {
            $this->Friend->addFriend($this->ZTAuth->user('id'), $this->params['form']['fid']);
            
            $message = array(
                'sender' => $this->ZTAuth->user('id'),
                'receiver' => $this->params['form']['fid'],
                'subject' => "Вас добавили в друзья!",
                'msg' => "Пользователь ".$this->ZTAuth->user('username')." добавил Вас в свой список друзей."
            );

            $this->Message->sendMessage($message, false);

            $this->set('result', '{success:true}');
        } else {
            $this->set('result', '{success:false, msg:"Error adding friend"}');
        }
    }

    /**
     * friends
     * 
     * @access public
     * @return void
     */
    function friends()
    {
        $this->layout = '2col_layout';
        $friends =  $this->Friend->getFriends($this->ZTAuth->user('id'));
        $this->set('friends', $friends);
    }

    /**
     * modify 
     * 
     * @access public
     * @return void
     */
    function modify()
    {
        Configure::write('debug','0');
        $this->layout = 'ajax';
        if($this->Acl->check($this->ZTAuth->user('username'), "Users::edit", '*'))
        {
            if($this->User->save($this->data['User'])) {
                $aro = new Aro();
                $arodata = $aro->findByForeign_Key($this->data['User']['id']);

                // try to find group ARO
                $newgroup = $aro->find('model LIKE "Group" AND foreign_key ='.$this->data['User']['group_id']);
                if(empty($newgroup)) 
                {
                    $this->set('result', '{success:false, msg:"Group ARO not found"}');
                    return;
                }

                // update ARO fields
                $arodata['Aro']['model'] = 'User';
                $arodata['Aro']['alias'] = $this->data['User']['username'];
                $arodata['Aro']['foreign_key'] = $this->data['User']['id'];
                $arodata['Aro']['parent_id'] = $newgroup['Aro']['id'];

                // create new ARO for user if it's not already exists
                if(empty($arodata['Aro']['id'])) $aro->create();
                $aro->save($arodata);

                $this->set('result', '{success:true}');
            } else {
                $this->set('result', '{success:false}');
            }
        } else
            $this->set('result', '{success:false, msg:"You can not do that"}');
    }

    /**
     * pending 
     * 
     * @access public
     * @return void
     */
    function pending()
    {
        Configure::write('debug', '0');
        $this->set('pageTitle', 'Activation needed');
    }

    /**
     * _newUserEmail 
     * 
     * @access protected
     * @return void
     */
    function _newUserEmail($user, $key)
    {
        $this->SwiftMailer->to = $user['User']['email'];
        $this->SwiftMailer->subject = 'Welcome to bymep.com';
        $this->SwiftMailer->from = 'noreply@bymep.com';
        $this->set('User', $user);
        $this->set('key', $key);
        $this->SwiftMailer->send('register', 'Welcome to bymep.com');
    }
}
?>
