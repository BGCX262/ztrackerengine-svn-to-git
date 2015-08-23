<?php
class Group extends AppModel {

	var $name = 'Group';
	var $actsAs = array('Acl' => 'requester');
	
	function parentNode()
	{
	    if(!$this->id) {
            return null;
        }
	    
	    $data = $this->read();
//	    pr($data);
	    if(!$data['Group']['parent_id']) {
            return null;
	    } else {
            return $data['Group']['parent_id'];
	    }
	}
}
?>
