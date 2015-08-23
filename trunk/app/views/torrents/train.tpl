<div class='x-panel-header'>Информация</div>
<div class='x-panel-body' style="padding:5px;">
Администрация не несет ответственности за оформление и качество раздач на тренировочном трекере.
Предоставленные сдесь материалы пока не прошли проверку. Если у Вас есть чем поделиться Вы также можете
попробовать свои силы. (<a href='{$html->webroot}torrents/upload'>Залить торрент</a>)
</div>
<br/>

{if count($torrents) > 0}
{$html->css("grid.css")}
{$html->css("core.css")}
{$html->css("reset-min.css")}

<table class="full" height="100" id="bookmarks">
<thead><th>Название</th><th>Размер</th><th>Помогает</th><th>Участников</th><th>Коментариев</th><th>Залил</th><th>Дата</th></thead>
<tbody>
{foreach from=$torrents item=torrent}
<tr><td style="padding:0;width:40%;"><a href="{$html->webroot}torrents/view/{$torrent.t.id}">{$torrent.t.name}</a></td>
<td style="padding:0;">{$torrent.t.size|mksize}</td>
<td style="padding:0;"></td>
<td style="padding:0;">{$torrent.t.seeders + $torrent.t.leechers}</td>
<td style="padding:0;">0</td>
<td style="padding:0;"><a href="{$html->webroot}users/view/{$torrent.u.id}" style="{$torrent.g.status_style}">{$torrent.u.username} <img src="{$html->webroot}img/flag/{$torrent.c.flagpic}" width="16"/></a></td>
<td style="padding:0;">{$torrent.t.added}</td>
</tr>
{/foreach}
</tbody>
</table>
{$javascript->link("ext-base.js")}
{$javascript->link("ext-all.js")}
{$javascript->link("bookmarks-index.js")}
{else}
<h1>Нет тренировочных раздачь</h1>
{/if}
