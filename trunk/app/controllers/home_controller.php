<?php

class HomeController extends AppController 
{
    var $name = 'Home';
    var $uses = array('Torrent');

    function index() 
    {
//        Configure::write('debug', '0');

        $total = $this->Torrent->query("SELECT COUNT(t.id) as total FROM torrents t WHERE t.ontop = 'yes'");
        $offset = 0;
        if(!empty($this->params['url']['offset']) && is_numeric($this->params['url']['offset']))
            $offset = $this->params['url']['offset'];

        $sql =  "SELECT t.id, t.name, t.image1, t.descr1, t.descr2, t.added, ".
            "cg.name, cg.id, cg.image, COUNT(t.id) as total ".
            "FROM torrents t ".
            "LEFT JOIN categories cg ON t.category = cg.id ".
            "WHERE t.ontop = 'yes' GROUP BY t.id ORDER BY t.added DESC LIMIT 5 OFFSET $offset";

        $torrents = $this->Torrent->query($sql);
        $url = $this->webroot;

        $this->set('torrents', $torrents);
        $this->set('request_url', $url);
        $this->set('total', $total[0][0]['total']);
        $this->set('offset', $offset);
        $this->set('pageTitle', 'Главная');
    }
}
?>
