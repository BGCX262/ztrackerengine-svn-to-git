<?php

class MenuHelper extends Helper 
{
    function display() 
    {
        //        pr($this->data['Menu']);
        $content = "";
        foreach($this->data['Menu'] as $item) {
            if(!preg_match('/^http:/i',$item['Menu']['link']))
                $item['Menu']['link'] = $this->webroot.$item['Menu']['link'];
            $content .= '<li><a href="'.$item['Menu']['link'].'">'.$item['Menu']['name'].'</a></li>';
        }
        $ret = '<ul>'.$content.'</ul>';
        return $ret;
    }
}
?>
