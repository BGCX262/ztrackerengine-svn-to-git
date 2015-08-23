<div class='x-panel'>
<div class='x-panel-header'>Объявления</div>
<div class='x-panel-body' style="padding:5px;">
<p>Как вы заметили, наш сайт немного изменился. К сожалению еще не все запланированные измения внесены и некоторые возможности не работают.</p>
</div>
</div>

<div class='x-panel' style="margin-top:0.5em;">
<div class='x-panel-header'>Новые поступления</div>
<div class='x-panel-body'>
{foreach from=$torrents item=torrent}
<div>
<div style="margin-left:5px;"><h4><a href="torrents/view/{$torrent.t.id}">{$torrent.t.name}</a></h4></div>
<div class="tor_body">
<table class="full">
<tr>
<td width="190" valign="top"><img src="{$torrent.t.image1}" width="180"></td>
<td valign="top" align="left">
<div class="float_right"><img src="{$html->webroot}img/categories/{$torrent.cg.image}"/></div>
<p>{$torrent.t.descr1|format_bb}</p>
<cite>{$torrent.t.descr2|format_bb}</cite>
<div class="float_right"><a href="torrents/view/{$torrent.t.id}">[Подробнее]</a></div>
</td>
</tr>
</table>
</div>
</div>
{/foreach}
<div style="margin-bottom:0.3em;">{pagelinks request="$request_url" total=$total lpp=5 rpp=5 back='назад' forw='вперед' to_first="первая" to_last='последня' offset=$offset separator="&nbsp;&nbsp;"}</div>
</div>
</div>

<div class='x-panel-header'>Сейчас на сайте</div>
<div class='x-panel-body' style="padding:5px;">
{foreach from=$OnlineUsers item=ou}
<a href="{$html->webroot}users/view/{$ou.u.id}" style="{$ou.g.status_style}">{$ou.u.username}</a>
{/foreach}
</div>
