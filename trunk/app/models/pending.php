<?php

class Pending extends AppModel
{
    var $name = 'Pending';
    var $useTable = 'pending';

    function AddPending($userId)
    {
        $key = sha1(mktime());
        $this->create();
        if($this->save(array('key' => $key, 'user_id' => $userId, 'flag' => 'p')))
        {
            return $key;
        }
        return null;
    }
}
?>
