<?php

class SidebarHelper extends Helper
{
    function display() 
    {
        //        pr($this->data['Menu']);
        $content = "";
        foreach($this->data['Menu'] as $item) {
            $content .= '<li><a href="'.$item['Menu']['link'].'">'.$item['Menu']['name'].'</a></li>';
        }
        $ret = '<ul>'.$content.'</ul>';
        return $ret;
    }
}
?>
