<?php

class Torrent extends AppModel 
{
    var $name = 'Torrent';
    var $recursive = 2;
    var $actsAs = array('SoftDeletable');
    var $belongsTo = array('owner' =>
        array('className' => 'User',
            'conditions' => '',
            'order' => '',
            'dependent' => false,
            'foreignKey' => 'owner'
            ));

}
?>
