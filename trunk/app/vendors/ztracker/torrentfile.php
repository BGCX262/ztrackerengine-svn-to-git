<?php

require_once("bittorrent.php");
require_once("dict.php");
require_once("benc.php");

$max_torrent_size = 1000000;

class TTorrentFile {
	var $dict;
	var $multiList;
    var $totalSize;
    var $numFiles;
    var $downloadName;
    var $filelist;
    var $type;

	function TTorrentFile($fname, $size) {
        $this->dict = new TDict($fname, $size);
		if($this->dict->ErrorMsg != '')
			bark($dict->ErrorMsg);

        $this->_tmpname = $fname;

		$info = new TDict('', $this->dict->check("info"));

		list($dname, $plen, $pieces) = $info->check("name(string):piece length(integer):pieces(string)");
        $this->downloadName = $dname;
		if (strlen($pieces) % 20 != 0)
			die("invalid pieces");

		$this->filelist = array();
		$totallen = $info->get("length", "integer");
		if (isset($totallen)) {
			$this->filelist[] = array('filename' => $dname, 'size' => $totallen);
			$this->type = "single";
            $this->totalSize = $totallen;
            $this->numFiles = 1;
		} else {
			$this->multiList = new TFileList($info->get("files", "list"));
			$this->type = "multi";
			$this->filelist = $this->multiList->filelist;
            $this->totalSize = $this->multiList->totalSize;
            $this->numFiles = $this->multiList->count;
		}
		// change announce url to local
		$this->dict->hashSetter("['value']['announce']", bdec(benc_str(DEFAULTBASEURL."/announce.php")));
		// add private tracker flag
		$this->dict->hashSetter('[\'value\'][\'info\'][\'value\'][\'private\']', bdec('i1e'));
		// add link for bitcomet users
		$this->dict->hashSetter('[\'value\'][\'info\'][\'value\'][\'source\']', bdec(benc_str( "[".DEFAULTBASEURL."] ".SITENAME)));

		$this->dict->unsetHash('[\'value\'][\'announce-list\']'); // remove multi-tracker capability
		$this->dict->unsetHash('[\'value\'][\'nodes\']'); // remove cached peers (Bitcomet & Azareus)
		$this->dict->unsetHash('[\'value\'][\'info\'][\'value\'][\'crc32\']'); // remove crc32
		$this->dict->unsetHash('[\'value\'][\'info\'][\'value\'][\'ed2k\']'); // remove ed2k
		$this->dict->unsetHash('[\'value\'][\'info\'][\'value\'][\'md5sum\']'); // remove md5sum
		$this->dict->unsetHash('[\'value\'][\'info\'][\'value\'][\'sha1\']'); // remove sha1
		$this->dict->unsetHash('[\'value\'][\'info\'][\'value\'][\'tiger\']'); // remove tiger
		$this->dict->unsetHash('[\'value\'][\'azureus_properties\']'); // remove azureus properties
		// double up on the becoding solves the occassional misgenerated infohash
		$this->dict->doubleUp();

	}

    function setComment($comment) {
        $this->dict->hashSetter('[\'value\'][\'comment\']', bdec(benc_str("$comment")));
    }

    function setUser($username, $userid) {
        $this->dict->hashSetter('[\'value\'][\'created by\']', bdec(benc_str("$username")));
        $this->dict->hashSetter('[\'value\'][\'publisher\']', bdec(benc_str("$username")));
        $this->dict->hashSetter('[\'value\'][\'publisher.utf-8\']', bdec(benc_str( "username")));
        $this->dict->hashSetter('[\'value\'][\'publisher-url\']', bdec(benc_str(DEFAULTBASEURL."/users/view/$userid")));
        $this->dict->hashSetter('[\'value\'][\'publisher-url.utf-8\']', bdec(benc_str(DEFAULTBASEURL."/users/view/$userid")));
    }

    function getInfoHash() {
        $info = new TDict('', $this->dict->check("info"));
        return sha1($info->hashGetter('[\'string\']'));
    }

    function move($destfile) {
        move_uploaded_file($this->_tmpname, $destfile);
        $fp = fopen($destfile, "w");
        if($fp)
        {
            @fwrite($fp, benc($this->dict->_dict), strlen(benc($this->dict->_dict)));
            fclose($fp);
        }
    }
}
?>
