<?php

class Comment extends AppModel 
{
    var $name = 'Comment';

    var $belongsTo = array('User' =>
        array('className' => 'User',
              'conditions' => '',
              'order' =>'',
              'dependent' => false,
              'foreignKey' => 'user'
          ));

}
?>
