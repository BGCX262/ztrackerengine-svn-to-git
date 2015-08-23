<?php

class Friend extends AppModel {
    var $name = 'Friend';
    var $useTable = 'friends';

    function addFriend($uid, $fid)
    {
        $friend = $this->find("userid = $uid AND friendid = $fid");
        if(empty($friend) && ($uid != $fid))
        {
            $this->create();
            $this->save(array('userid' => $uid, 'friendid' => $fid));
        }
 
    }

    function delFriend($uid, $fid)
    {
        $friend = $this->find("userid = $uid AND friendid = $fid");
        if(!empty($friend))
        {
            $this->del($friend['Friend']['id'], false);
            return true;
        } else 
            return false;
    }

    function getFriends($uid)
    {
        $this->bindModel(array('belongsTo' => array('User' => array('className' => 'User', 'foreignKey' => 'friendid'))));
        $this->recursive = 2;
        $friends = $this->findAllByUserid($uid);
        return $friends;
    }
}
?>
