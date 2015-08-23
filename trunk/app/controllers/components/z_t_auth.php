<?php

uses('controller/components/auth');

class ZTAuthComponent extends AuthComponent 
{
    var $name = 'ZTAuth';
    
    // do not hash passwords they must be already hashed on client-side
    function password($password) 
    {
        return $password;
    }

}
?>
