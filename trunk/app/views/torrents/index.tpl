{$html->css("panel.css")}
{$html->css("form.css")}
{$html->css("rating.css")}
{$html->css('reset-min.css')}
<div class='x-panel-header'>Поиск</div>
<div class='x-panel-body' style="padding:5px;">
<form id='filter' name='filter' method='GET' action="{$html->webroot}torrents">
<table class='full'>
<tr><td colspan=2>Название:</td></tr>
<tr><td>
<input class='x-form-field x-form-text' style="height:18px;width:90%;" type="text" name="name"/>
</td><td width="100px">
<input type="submit" class="x-btn-text" value="Искать"/>
</td></tr></table>
</form>
</div>
<div class="float_right"><a href="{$html->webroot}torrents">Все раздачи</a></div>
<div style="margin-bottom:0.3em;width:200px;">{pagelinks request="$request_url" total=$total lpp=5 rpp=10 back='назад' forw='вперед' to_first="первая" to_last='последня' offset=$offset separator="&nbsp;&nbsp;"}</div>
{foreach from=$torrents item=torrent} &nbsp;
<div>
<table class="full" height="100" >
<tr><td style="vertical-align:top;width:65px;"><img src="{$torrent.t.image1}" width="60"></td>
<td style="vertical-align:top;">
<div class="x-panel-header"><a href="{$html->webroot}torrents/view/{$torrent.t.id}">{$torrent.t.name}</a></div>
<div class="x-panel-body" style="padding:5px 0 0 5px;">
Категория: <a href="{$html->webroot}torrents/?c={$torrent.cg.id}">{$torrent.cg.name}</a>
<table class='full' style="padding:0;margin-top:5px;">
<tr>
<td style="padding:0;width:20%">Размер: {$torrent.t.size|mksize}</td>
<td style="padding:0;width:20%">Скачали: {$torrent.t.times_completed} раз</td>
<td style="padding:0;width:20%">Учасников: {$torrent.t.seeders + $torrent.t.leechers}</td>
<td style="padding:0;width:20%">Раздают: {$torrent.t.seeders}</td>
<td style="padding:0;width:20%">Качают: {$torrent.t.leechers}</td>
</tr>
<tr>
<td style="padding:0;width:20%">
<a href="{$html->webroot}torrents/?t={$torrent.t.free_type}">{if $torrent.t.free_type eq "1"}Обычная раздача{/if}
{if $torrent.t.free_type eq "2"}Тренировочная раздача{/if}
{if $torrent.t.free_type eq "3"}Золотая раздача{/if}
{if $torrent.t.free_type eq "4"}Серебрянная раздача{/if}
{if $torrent.t.free_type eq "5"}Скрытая раздача{/if}</a>
</td>
<td style="padding:0;width:20%">
<div id="rating" style="margin-left:auto;margin-right:auto;text-align:center;">
<ul class="star-rating2">
<li class="current-rating" style="width:{$torrent[0].total/$torrent[0].votes*20}%;"></li>
<li><a class="one-star" href="#">1</a></li>
<li><a class="two-stars" href="#">2</a></li>
<li><a class="three-stars" href="#">3</a></li>
<li><a class="four-stars" href="#">4</a></li>
<li><a class="five-stars" href="#">5</a></li>
</ul>
</div>
</td>

<td style="padding:0;width:20%">Коментариев: 0</td>
<td style="padding:0;width:20%">Залил: <a href="{$html->webroot}users/view/{$torrent.u.id}" style="{$torrent.g.status_style}">{$torrent.u.username} <img src="{$html->webroot}img/flag/{$torrent.c.flagpic}" width="16"/></a></td>
<td style="padding:0;width:20%">{$torrent.t.added}</td>


</tr>
</table>

</div>
</td>
</tr>
</table>
</div>
{/foreach}
<div style="margin-bottom:0.3em;">{pagelinks request="$request_url" total=$total lpp=5 rpp=10 back='назад' forw='вперед' to_first="первая" to_last='последня' offset=$offset separator="&nbsp;&nbsp;"}</div>
