<?php

$max_torrent_size = 1000000;
$announce_urls = array();
$announce_urls[] = 'http://localhost/ztracker/announce.php';
define('DEFAULTBASEURL', 'http://localhost/ztracker');
define('SITENAME','BYMEP.COM');

function get_date_time($timestamp = 0) {
	if ($timestamp)
		return date("Y-m-d H:i:s", $timestamp);
	else
		return date("Y-m-d H:i:s");
}
?>
