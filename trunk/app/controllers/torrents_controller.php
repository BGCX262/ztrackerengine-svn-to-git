<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
uses('sanitize');

class TorrentsController extends AppController 
{
    var $name = 'Torrents';
    var $helpers = array("javascript");
    var $uses = array('Torrent', 'User', 'Ufile', 'Peer', 'Rating', 'Category', 'Uploadtype', 'Bookmark', 'Log');

    function getInfo()
    {
        Configure::write('debug', '0');
        $this->layout = 'ajax';
        $this->Torrent->bindModel(array('belongsTo' => array('Category' => array('className' => 'Category', 'foreignKey' => 'category'))));
        $this->Torrent->recursive=2;
        $this->Torrent->id = $this->params['form']['id'];
        $torrent = $this->Torrent->read();
        $result = array(
            'descr1' => $torrent['Torrent']['descr1'],
            'descr2' => $torrent['Torrent']['descr2'],
            'descr3' => $torrent['Torrent']['descr3'],
            'descr4' => $torrent['Torrent']['descr4'],
            'image' => $torrent['Torrent']['image1'],
            'name' => $torrent['Torrent']['name'],
            'cat' => $torrent['Torrent']['category'],
            'ftype' => $torrent['Torrent']['free_type']
        );
        if($this->isAuthorized($this->ZTAuth->user('username'), $this->name, 'ontop'))
        {
            $result['ontop'] = $torrent['Torrent']['ontop'] == 'yes' ? 1 : 2;
        }
        $this->set('result', $this->ajax_encode(array('torrent' => $result)));
    }

    function index()
    {
        Configure::write('debug', '0');
        $this->layout = '2col_layout';
        $san = new Sanitize();
        $filter = "";
        $limit = 10;
        $offset = 0;
        $url = $this->webroot."torrents/";

        if(!empty($this->params['url']['name'])) {
            $filter = "t.name like '%".$san->escape($this->params['url']['name'])."%'";
            $url .= "?name=".$this->params['url']['name'];
        }

        if(!empty($this->params['url']['c'])) {
            $filter .= !empty($filter) ? " AND ":"";
            $filter .= "cg.id = ".$san->escape($this->params['url']['c']);
            $url .= (strpos($url, "?") === false) ? "?" : "&";
            $url .= 'c='.$this->params['url']['c'];
        }

         if(!empty($this->params['url']['t'])) {
            $filter .= !empty($filter) ? " AND ":"";
            $filter .= "t.free_type = ".$san->escape($this->params['url']['t']);
            $url .= (strpos($url, "?") === false) ? "?" : "&";
            $url .= 't='.$this->params['url']['t'];
        }

        if(!empty($this->params['url']['offset']) && is_numeric($this->params['url']['offset']))
            $offset = $this->params['url']['offset'];

        $filter .= !empty($filter) ? " AND ":"";
        $filter .= "t.free_type != 2 AND deleted != 1";

        if(!$this->isAuthorized($this->ZTAuth->user('username'), $this->name, "hidden"))
        {
            $filter .= ' AND t.free_type != 5';
        }


        if(empty($filter)) $filter="1";
        $sql =  "SELECT t.id, t.name, t.image1, t.size, t.times_completed, t.seeders, t.leechers, t.added, c.flagpic, t.free_type, ".
            "u.username, u.id, g.status_style, SUM(r.rating) as total, COUNT(r.id) as votes, cg.name, cg.id ".
            "FROM torrents t JOIN users u ON t.owner = u.id ".
            "LEFT JOIN groups g ON u.group_id = g.id ".
            "JOIN countries c ON u.country = c.id ".
            "LEFT JOIN categories cg ON t.category = cg.id ".
            "LEFT JOIN ratings r ON r.torrent = t.id WHERE $filter GROUP BY t.id ORDER BY t.added DESC LIMIT $limit OFFSET $offset";

        $tsql = "SELECT count(t.id) as total from torrents t LEFT JOIN categories cg ON t.category = cg.id WHERE $filter";
        $total = $this->Torrent->query($tsql);
        $torrents = $this->Torrent->query($sql);
        $this->set('torrents', $torrents);
        $this->set('total', $total[0][0]['total']);
        $this->set('offset', $offset);
        $this->set('request_url', $url);
        $this->set('pageTitle', 'Список раздач');
    }
    
    function view($id = null) 
    {
        Configure::write('debug', '0');
        if($id == null)
            $this->redirect("/torrents");
        $this->layout = '2col_layout';
        $this->Torrent->bindModel(array(
            'belongsTo' => array('Category' => array('className' => 'Category', 'foreignKey' => 'category')),
            'hasMany' => array('Comments' => array('className' => 'Comment', 'foreignKey' => 'torrent'))));
        $this->Torrent->recursive=3;
        $this->Torrent->id = $id;
        $torrent = $this->Torrent->read();
        if(empty($torrent))
        	$this->redirect("/torrents");
        //$nfo = file("../nfo/$id.nfo");
        $nfo = file_exists("../nfo/$id.nfo") ? implode('', file("../nfo/$id.nfo")) : "NFO-файл не найден";

        $canedit = false;
        if(($this->isAuthorized($this->ZTAuth->user('username'), $this->name, "edit")) || 
            ($torrent['Torrent']['owner'] == $this->ZTAuth->user('id'))) 
        {
            $canedit = true;
        }
        $candelete = $this->isAuthorized($this->ZTAuth->user('username'), $this->name, "delete") ? true : false;
        $delete_comm = $canedit;
        
        $this->set('candelete', $candelete);
        $this->set('delete_comm', $delete_comm);
        $this->set('canedit', $canedit);
        $this->set('nfo', $nfo);
        $this->set('torrent', $torrent);
        $this->set('pageTitle', $torrent['Torrent']['name']);
        $this->set('rating', $this->Rating->pullRating($torrent['Torrent']['id'], $this->ZTAuth->user('id') ,true, false, true));
    }

    function modify()
    {
        Configure::write('debug', '0');
        $this->layout = 'ajax';
        
        if(!$this->data['Torrent']['id']) 
        {
            $this->set('result', '{success:false, msg:"Неизвестная раздача"}');
            return;
        }

        $this->Torrent->id = $this->data['Torrent']['id'];
        $torrent = $this->Torrent->read();
        //check permissions
        if(!$this->Acl->check($this->ZTAuth->user('username'), $this->name."::edit", '*') && 
            ($torrent['Torrent']['owner'] != $this->ZTAuth->user('id')))
        { 
            $this->set('result', '{success:false, msg:"Не достаточно прав на операцию"}');
            return;
        }

        if(!$this->isAuthorized($this->ZTAuth->user('username'), $this->name, 'ontop') && isset($this->data['Torrent']['ontop']))
            unset($this->data['Torrent']['ontop']);
        else
            $this->data['Torrent']['ontop'] = $this->data['Torrent']['ontop'] ? 'yes' : 'no';

        if($this->Torrent->save($this->data['Torrent']))
        {
            $this->Log->create();
            $this->Log->save(array('Log' => array(
                'user_id' => $this->ZTAuth->user('id'),
                'msg' => "Пользователь ".$this->ZTAuth->user('username')." изменил торрент ".$this->data['Torrent']['name']." (".$this->data['Torrent']['id'].")")));

            $this->set('result', '{success:true}');
        } else {
            $this->set('result', '{success:false}');
        }
    }

    function delete()
    {
        Configure::write('debug', '0');
        $this->layout = 'ajax';
        if(!$this->isAuthorized($this->ZTAuth->user('username'), $this->name, "delete")) {
            echo "Not enough permissions";
            return;
        }
        $this->Torrent->bindModel(array('hasMany' =>
            array(
                'Files' => array('className' => 'Ufile', 'foreignKey' => 'torrent', 'dependent' => true, 'exclusive' => true),
                'Comments' => array('className' => 'Comment', 'foreignKey' => 'torrent', 'dependent' => true, 'exclusive' => true),
                'Ratings' => array('className' => 'Rating', 'foreignKey' => 'torrent', 'dependent' => true, 'exclusive' => true))));
        $this->Torrent->id = $this->params['form']['id'];
        $this->Torrent->delete();

        $this->Log->create();
        $this->Log->save(array('Log' => array(
            'user_id' => $this->ZTAuth->user('id'),
            'msg' => "Пользователь ".$this->ZTAuth->user('username')." удалил торрент номер ".$this->params['form']['id'])));

    }

    function rateit()
    {
        Configure::write('debug', '0');
        $this->layout='ajax';
        $uid = $this->ZTAuth->user('id');
        $votes = $this->Rating->find(array('user' => $uid, 'torrent' => $this->params['form']['id']));
        if(!empty($votes)) 
        {
            $this->set('result', 'already_voted');
            return;
        }
        $this->Rating->create();
        $this->Rating->save(array('Rating' => 
            array(
                'torrent' => $this->params['form']['id'], 
                'user' => $uid, 
                'rating' => $this->params['form']['rate'],
                'added' => date("Y-m-d H:i:s")
            )));
        $res = $this->Rating->query("SELECT COUNT(id) as r, SUM(rating) as tot FROM ratings WHERE torrent=".$this->params['form']['id']);
        $perc = ($res[0][0]['tot']/$res[0][0]['r'])*20;

        $this->set('result', round($perc,2));
    }

    function mksize($bytes)
    {
        if(is_numeric($bytes)) {
            if ($bytes < 1000 * 1024)
                return number_format($bytes / 1024, 2) . " kB";
            elseif ($bytes < 1000 * 1048576)
                return number_format($bytes / 1048576, 2) . " MB";
            elseif ($bytes < 1000 * 1073741824)
                return number_format($bytes / 1073741824, 2) . " GB";
            else
                return number_format($bytes / 1099511627776, 2) . " TB";
        } 
    }

    function getfiles()
    {
        Configure::write('debug', '0');
        $this->layout='ajax';
        $files = $this->Ufile->findAllByTorrent($this->params['form']['torrent']);
        $result = array();
        foreach($files as $file) {
            $result[] = array(
                'name' => $file['Ufile']['filename'],
                'size' => $this->mksize($file['Ufile']['size']));
        }
        $this->set('result', $this->ajax_encode(array('files' => $result)));
    }

    function getpeers()
    {
        Configure::write('debug', '0');
        $this->layout='ajax';
        $this->Peer->bindModel(array('belongsTo' => array('User' => array('className' => 'User', 'foreignKey' => 'userid'))));
        $this->Peer->recursive=2;
        $peers = $this->Peer->findAllByTorrent($this->params['form']['torrent']);
        $result = array();
        foreach($peers as $peer)
        {
            $result[] = array(
                'username' => $peer['User']['username'],
                'userid' => $peer['Peer']['userid'],
                'userstyle' => $peer['User']['Group']['status_style'],
                'downloaded' => $this->mksize($peer['Peer']['downloaded']),
                'uploaded' => $this->mksize($peer['Peer']['uploaded']),
                'seeder' => $peer['Peer']['seeder'],
                'connectable' => $peer['Peer']['connectable'],
                'agent' => $peer['Peer']['agent'],
            );
        }
        $this->set('result', $this->ajax_encode(array('peers' => $result)));
    }

    function block()
    {
        if(isset($this->params['url']['gettotal']))
        {
            return $this->Torrent->query("SELECT COUNT(t.id) as total FROM torrents t WHERE t.ontop = 'yes'");
        }
        pr($this->params);
        $sql =  "SELECT t.id, t.name, t.image1, t.descr1, t.descr2, ".
            "cg.name, cg.id, COUNT(t.id) as total ".
            "FROM torrents t ".
            "LEFT JOIN categories cg ON t.category = cg.id ".
            "WHERE t.ontop = 'yes' GROUP BY t.id LIMIT 5 OFFSET 0";

        $torrents = $this->Torrent->query($sql);
        if(isset($this->params['requested']))
        {
            return $torrents;
        }
    }

    function download($id)
    {
        $this->autoRender = false;
        $this->autoLayout = false;

        Configure::write('debug', '0');
        app::import('vendor', 'ztracker/dict');
        app::import('vendor', 'ztracker/global');

        $tfile = "../torrents/$id.torrent";
        $torrent = $this->Torrent->find(array('id' => $id));
        $user = $this->User->find(array('username' => $this->ZTAuth->user('username')));
        if(strlen($user['User']['passkey']) != 40) {
            $user['User']['passkey'] = sha1($user['User']['username'].get_date_time().$user['User']['username']);
            $this->User->save($user['User']);
        }
        $passkey = $user['User']['passkey'];
        $dict = bdec_file($tfile, (1024*1024));
        $dict['value']['announce']['value'] = $this->webroot."announce.php?passkey=$passkey";
        $dict['value']['announce']['string'] = strlen($dict['value']['announce']['value']).":".$dict['value']['announce']['value'];
        $dict['value']['announce']['strlen'] = strlen($dict['value']['announce']['string']);
        header ("Expires: Tue, 1 Jan 2000 00:00:00 GMT");
        header ("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header ("Cache-Control: no-store, no-cache, must-revalidate");
        header ("Cache-Control: post-check=0, pre-check=0", false);
        header ("Pragma: no-cache");
        header ("X-Powered-by: ZTracker (c) ZTSoft Research Lab - http://bymep.com");
        header ("Accept-Ranges: bytes");
        header ("Connection: close");
        header ("Content-Transfer-Encoding: binary");
        header ("Content-Type: application/x-bittorrent");
        header ("Content-Disposition: attachment; filename=\"".$torrent['Torrent']['filename']."\"");

        print(benc($dict));
        exit;
    }

    function upload()
    {
        $this->set('pageTitle', 'Загрузить торрент');
    }

    function getuptypes()
    {
        Configure::write('debug', '0');
        $this->layout = 'ajax';
        $utypes = $this->Uploadtype->findAll("user_lvl <= ".$this->ZTAuth->user('group_id'));
        $result = array();
        foreach($utypes as $ut)
            $result[] = array('name' => $ut['Uploadtype']['name'], 'id' => $ut['Uploadtype']['id']);
        $this->set('result', $this->ajax_encode(array('utypes' => $result)));
    }

    function getcats()
    {
        Configure::write('debug', '0');
        $this->layout = 'ajax';
        $cats = $this->Category->findAll();
        $result = array();
        foreach($cats as $cat)
            $result[] = array('name' => $cat['Category']['name'], 'id' => $cat['Category']['id']);
        $this->set('result', $this->ajax_encode(array('categories' => $result)));
    }

    function doupload()
    {
        Configure::write('debug', '0');
        $max_torrent_size = 1000000;
        $announce_urls=array();
        $announce_urls[]=$this->webroot.'announce.php';
        $this->layout='ajax';
        $uses = array('Torrent', 'File');
        app::import('vendor', 'ztracker/global');
        app::import('vendor', 'ztracker/dict');
        app::import('vendor', 'ztracker/torrentfile');
  
        if(!preg_match('/^(.+)\.torrent$/si', $this->params['form']['torrentFile']['name'], $matches))
        {
            $this->set('success','{success:false,msg:"Это не файл торрента"}');
            return;
        }
        $shortname = $torrent = $matches[1];
        $tmp_name = $this->params['form']['torrentFile']['tmp_name'];
        if(!is_uploaded_file($tmp_name) || !filesize($tmp_name))
        {
            $this->set('success','{success:false,msg:"Ошибка"}');
            return;
        }

        $tor = new TTorrentFile($tmp_name, $max_torrent_size);
        $tor->setComment("Torrent was created for BYMEP.COM");
        $tor->setUser($this->ZTAuth->user('username'), $this->ZTAuth->user('id'));

        // setup torrent {{{
        $utype = $this->Uploadtype->find("user_lvl <= ".$this->ZTAuth->user('group_id')." AND id = ".$this->data['Torrent']['free_type']);
        if(empty($utype))
        {
            $utype =  $this->Uploadtype->find("user_lvl <= ".$this->ZTAuth->user('group_id'));
            $this->data['Torrent']['free_type'] = $utype['id'];
        }

        $this->data['Torrent']['filename'] = $this->params['form']['torrentFile']['name'];
        $this->data['Torrent']['added'] = date('Y-m-d H:i:s');
        $this->data['Torrent']['owner'] = $this->ZTAuth->user('id');
        $this->data['Torrent']['info_hash'] = $tor->getInfoHash();
        $this->data['Torrent']['size'] = $tor->totalSize;
        $this->data['Torrent']['numfiles'] = $tor->numFiles;
        if($this->data['Torrent']['numfiles'] > 1)
            $this->data['Torrent']['type'] = 'multi';
        else
            $this->data['Torrent']['type'] = 'single';
        $this->data['Torrent']['save_as'] = $tor->downloadName;

        $this->Torrent->save($this->data['Torrent']);
        $torid = $this->Torrent->getLastInsertId();
        // }}}
        foreach($tor->filelist as $file)
        {
            $file['torrent'] = $torid;
            $this->Ufile->create();
            $this->Ufile->save(array('Ufile' =>$file));
        }

        $tor->move("../torrents/$torid.torrent");

        
        $this->set('success','{success:false}');
        // DONE: Move Info file to specific directory
        move_uploaded_file($this->params['form']['torrentNFO']['tmp_name'], "../nfo/$torid.nfo");
        // TODO: Sanitize NFO file
        //
        $this->Log->create();
        $this->Log->save(array('Log' => array(
            'user_id' => $this->ZTAuth->user('id'),
            'msg' => "Пользователь ".$this->ZTAuth->user('username')." залил торрент ".$this->data['Torrent']['name'])));

    }

    function addbookmark()
    {
        Configure::write('debug', '0');
        $this->layout = 'ajax';
        $this->Bookmark->AddBookMark($this->ZTAuth->user('id'), $this->params['form']['id']);
    }

    function train()
    {
        $this->layout = "2col_layout";
        $this->set('pageTitle', 'Тренировочный трекер');

        $filter = "t.free_type = 2 AND deleted != 1";
        $sql =  "SELECT t.id, t.name, t.image1, t.size, t.times_completed, t.seeders, t.leechers, t.added, c.flagpic, t.free_type, ".
            "u.username, u.id, g.status_style, SUM(r.rating) as total, COUNT(r.id) as votes, cg.name, cg.id ".
            "FROM torrents t JOIN users u ON t.owner = u.id ".
            "LEFT JOIN groups g ON u.group_id = g.id ".
            "JOIN countries c ON u.country = c.id ".
            "LEFT JOIN categories cg ON t.category = cg.id ".
            "LEFT JOIN ratings r ON r.torrent = t.id WHERE $filter GROUP BY t.id ORDER BY t.added DESC ";

        $torrents = $this->Torrent->query($sql);
        $this->set('torrents', $torrents);
    }
}
?>
