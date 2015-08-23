<?php

class User extends AppModel {
	var $name = 'User';
    var $actsAs = array('Acl' => 'requester');
    var $belongsTo = array('Country' =>
        array('className' => 'Country',
              'conditions' => '',
              'order' =>'',
              'dependent' => false,
              'foreignKey' => 'country'
          ),
        'Group' =>
        array('className' => 'Group',
              'conditions' => '',
              'order' =>'',
              'dependent' => false,
              'foreignKey' => 'group_id'
          ));

    /*
     *
     *
     */
    function validateLogin($data)
    {
        $user = $this->find(array('username' => $data['username'], 'sha_hash' => $data['password']), array('id','username','sha_hash'));
        if(!empty($user)) 
            return $user['User'];

        // old users
        $user = $this->find(array('username' => $data['username']));
        if(!empty($user))
        {
            if($user['User']['passhash'] == md5($user['User']['secret'].$data['pass'].$user['User']['secret']))
            {
                $user['User']['sha_hash'] = sha1($data['pass']);
                $this->save($user["User"]);
                return $user["User"];   
            }
        }
        return false;
    }

    /*
     *
     *
     */
    function parentNode()
    {
        if(!$this->id) { 
            return null;
        }
        $data = $this->read();
        if(!$data['User']['group_id']) {
            return null;
        } else {
            return array('model' => 'Group', 'foreign_key' => $data['User']['group_id']);
        }
    }

    /*
     *
     *
     */
    function mksecret($length = 20) 
    {
        $set = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L","m","M",
            "n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X","y","Y","z","Z",
            "1","2","3","4","5","6","7","8","9");
        $str = '';
        for($i = 1; $i <= $length; $i++)
        {
            $ch = rand(0, count($set)-1);
            $str .= $set[$ch];
        }
        return $str;
    }

    /*
     *
     *
     */

    function WhoOnline() 
    {
        $online = $this->query("SELECT u.id, u.username, u.group_id, g.status_style FROM users u JOIN groups g ON u.group_id = g.id WHERE last_access > DATE_SUB(NOW(), INTERVAL 5 MINUTE) ORDER BY u.group_id");
        return $online;
    }

}

?>
