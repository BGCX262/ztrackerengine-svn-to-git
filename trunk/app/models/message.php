<?php

class Message extends AppModel
{
    var $name = 'Message';

    /*
     *
     * $message following array
     *      sender 
     *      receiver
     *      subject
     *      msg
     *
     * $leavecopy - save message in user's mail box
     */
    function sendMessage($message, $leavecopy = true)
    {
        if(empty($message)) return false;

        $message['added'] = date('Y-m-d H:i:s');
        $message['unread'] = 'yes';
        $message['poster'] = $message['receiver'];
        
        $this->create();
        if(!$this->save(array('Message' => $message))) return false;
        if($leavecopy)
        {
            $message['poster'] = $message['sender'];
            $message['unread'] = 'no';
            $this->create();
            if(!$this->save(array('Message' => $message))) return false;
        }
        return true;
    }

    function sendMassMessage($message, $group = 3)
    {
        if(empty($message)) return false;
        
        App::import('Model','User');
        $User = new User();

        $targets = $User->findAll("group_id > $group");
        if(!empty($targets))
        {
            $message['added'] = date('Y-m-d H:i:s');
            $message['unread'] = 'yes';
            foreach($targets as $target)
            {
                $message['poster'] = $target['User']['id'];
                $this->sendMessage($message, false);
            }
        }

    }
}
?>
