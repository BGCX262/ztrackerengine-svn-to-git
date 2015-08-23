<?php

function smarty_modifier_format_bb($text, $strip_html = true) {
	$s = $text;

	$s = str_replace(";)", ":wink:", $s);

	if ($strip_html)
		$s = htmlspecialchars($s);

	$bb[] = "#\[img\]([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#i";
	$html[] = "<img src=\"\\1\" border=\"0\" alt=\"\\1\" title=\"\\1\" />";
	$bb[] = "#\[img=([a-zA-Z]+)\]([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
	$html[] = "<img src=\"\\2\" align=\"\\1\" border=\"0\" alt=\"\\2\" title=\"\\2\" />";
	$bb[] = "#\[img\ alt=([a-zA-Zà-ÿÀ-ß0-9\_\-\. ]+)\]([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
	$html[] = "<img src=\"\\2\" align=\"\\1\" border=\"0\" alt=\"\\1\" title=\"\\1\" />";
	$bb[] = "#\[img=([a-zA-Z]+) alt=([a-zA-Zà-ÿÀ-ß0-9\_\-\. ]+)\]([^?](?:[^\[]+|\[(?!url))*?)\[/img\]#is";
	$html[] = "<img src=\"\\3\" align=\"\\1\" border=\"0\" alt=\"\\2\" title=\"\\2\" />";
	$bb[] = "#\[url\]([\w]+?://([\w\#$%&~/.\-;:=,?@\]+]+|\[(?!url=))*?)\[/url\]#is";
	$html[] = "<a href=\"\\1\" title=\"\\1\">\\1</a>";
	$bb[] = "#\[url\]((www|ftp)\.([\w\#$%&~/.\-;:=,?@\]+]+|\[(?!url=))*?)\[/url\]#is";
	$html[] = "<a href=\"http://\\1\" title=\"\\1\">\\1</a>";
	$bb[] = "#\[url=([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is";
	$html[] = "<a href=\"\\1\" title=\"\\1\">\\2</a>";
	$bb[] = "#\[url=((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*?)\]([^?\n\r\t].*?)\[/url\]#is";
	$html[] = "<a href=\"http://\\1\" title=\"\\1\">\\3</a>";
	$bb[] = "/\[url=([^()<>\s]+?)\]((\s|.)+?)\[\/url\]/i";
	$html[] = "<a href=\"\\1\">\\2</a>";
	$bb[] = "/\[url\]([^()<>\s]+?)\[\/url\]/i";
	$html[] = "<a href=\"\\1\">\\1</a>";
	$bb[] = "#\[mail\](\S+?)\[/mail\]#i";
	$html[] = "<a href=\"mailto:\\1\">\\1</a>";
	$bb[] = "#\[mail\s*=\s*([\.\w\-]+\@[\.\w\-]+\.[\w\-]+)\s*\](.*?)\[\/mail\]#i";
	$html[] = "<a href=\"mailto:\\1\">\\2</a>";
	$bb[] = "#\[color=(\#[0-9A-F]{6}|[a-z]+)\](.*?)\[/color\]#si";
	$html[] = "<span style=\"color: \\1\">\\2</span>";
	$bb[] = "#\[(font|family)=([A-Za-z ]+)\](.*?)\[/\\1\]#si";
	$html[] = "<span style=\"font-family: \\2\">\\3</span>";
	$bb[] = "#\[size=([0-9]+)\](.*?)\[/size\]#si";
	$html[] = "<span style=\"font-size: \\1\">\\2</span>";
	$bb[] = "#\[(left|right|center|justify)\](.*?)\[/\\1\]#is";
	$html[] = "<div align=\"\\1\">\\2</div>";
	$bb[] = "#\[b\](.*?)\[/b\]#si";
	$html[] = "<b>\\1</b>";
	$bb[] = "#\[i\](.*?)\[/i\]#si";
	$html[] = "<i>\\1</i>";
	$bb[] = "#\[u\](.*?)\[/u\]#si";
	$html[] = "<u>\\1</u>";
	$bb[] = "#\[s\](.*?)\[/s\]#si";
	$html[] = "<s>\\1</s>";
	$bb[] = "#\[li\]#si";
	$html[] = "<li>";
	$bb[] = "#\[hr\]#si";
	$html[] = "<hr>";

	$s = preg_replace($bb, $html, $s);

	// Linebreaks
	$s = nl2br($s);

	if (preg_match("#\[quote\](.*?)\[/quote\]#si", $s)) $s = encode_quote($s);
	if (preg_match("#\[quote=(.+?)\](.*?)\[/quote\]#si", $s)) {
		$s = encode_quote_from($s);
	}
	if (preg_match("#\[code\](.*?)\[/code\]#si", $s)) $s = encode_code($s);
	if (preg_match("#\[php\](.*?)\[/php\]#si", $s)) $s = encode_php($s);

	// [flash]http://www.svt.se/hogafflahage/hogafflaHage_site/Kor/hestekor.swf[/flash]
	$s = preg_replace(
	   "/\[flash\]([^()<>\s]+?)\[\/flash\]/i",
	   "<object><param name=\"movie\" value=\"\\1/\"><embed width=\"470\" height=\"310\" src=\\1></embed></object>", $s);

	// [audio].mp3[/audio]
	$s = preg_replace(
	   "/\[audio\]([^()<>\s]+?)\[\/audio\]/i",
	   "<embed autostart=\"false\" loop=\"false\" controller=\"true\" width=\"220\" height=\"42\" src=\\1></embed>", $s);

	// URLs
	$s = preg_replace(
    	"/(\A|[^=\]'\"a-zA-Z0-9])((http|ftp|https|ftps|irc):\/\/[^()<>\s]+)/i",
	    "\\1<a href=\"\\2\">\\2</a>", $s);
	//$s = format_local_urls($s);

	// Maintain spacing
	$s = str_replace("  ", "&nbsp;", $s);

	return $s;
}
?>