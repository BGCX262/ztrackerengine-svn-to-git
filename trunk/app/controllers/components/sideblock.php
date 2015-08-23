<?php

class SideblockComponent extends Object
{
    var $name = 'Sideblock';

    function startup(&$controller)
    {
        $this->controller =& $controller;
    }

    function fetchUserMenu()
    {
        App::import('Model', 'Menu');
        $user = $this->controller->ZTAuth->user();
        if(!empty($user)){
            $this->Menu = new Menu();
            $data = $this->Menu->findAll('Menu.category = 2',array('Menu.name','Menu.link'),'order');
            return $data;
        }
    }
    
    function fetchStats()
    {
        $this->Session = $this->controller->Session;
        $stats = $this->Session->read('stats');
        if(empty($stats) || $stats['stexpire'] < mktime())
        {
            App::import('Model', 'Torrent');
            $this->Torrent = new Torrent();
            $st1 = $this->Torrent->query(
                "SELECT COUNT(id) as tcount FROM torrents ".
                "UNION SELECT COUNT(id) FROM peers WHERE seeder='yes' ".
                "UNION SELECT COUNT(id) FROM peers WHERE seeder='no' ".
                "UNION SELECT COUNT(id) FROM users ".
                "UNION SELECT COUNT(id) FROM users WHERE gender=1 ");
            $st2 = $this->Torrent->query("SELECT COUNT(id) as fmcount FROM users WHERE gender=2 ");
            $stats = array(
                'tcount' => $st1[0][0]['tcount'], 
                'scount' => $st1[1][0]['tcount'],
                'lcount' => $st1[2][0]['tcount'],
                'usrcount' => $st1[3][0]['tcount'],
                'mlcount' => $st1[4][0]['tcount'],
                'fmcount' => $st2[0][0]['fmcount'],
                'stexpire' => mktime()+600);
            $this->Session->write('stats', $stats);
        }
        return $stats;

    }
}
?>
