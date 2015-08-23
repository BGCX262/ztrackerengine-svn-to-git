<?php

class BookmarksController extends AppController
{
    var $name = 'Bookmarks';
    var $uses = array('Bookmark');

    function index()
    {
        $this->Bookmark->bindModel(array('belongsTo' => array('Torrent' => array('className' => 'Torrent', 'foreignKey' => 'torrentid'))));
        $bookmarks = $this->Bookmark->findAllByUserid($this->ZTAuth->user('id'));
        $this->set('pageTitle', 'Закладки');
        $this->set('bookmarks', $bookmarks);
    }
}
?>
