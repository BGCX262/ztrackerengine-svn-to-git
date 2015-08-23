<?php

class Bookmark extends AppModel
{
    var $name = 'Bookmark';

    function AddBookMark($uid, $tid)
    {
        $bm = $this->find("userid = $uid AND torrentid = $tid");
        if(empty($bm))
        {
            $this->create();
            $this->save(array('userid' => $uid, 'torrentid' => $tid));
        }
    }
}
?>
