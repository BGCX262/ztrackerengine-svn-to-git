{$html->css("grid.css")}
{$html->css("core.css")}
{$html->css("reset-min.css")}
<table class="full" height="100" style="border:1px solid gray;" id="bookmarks">
<thead><tr><th>Название</th><th>Размер</th><th>Учасников</th><th>Раздают</th><th>Качают</th><th>Тип</th></tr></thead>
<tbody>
{foreach from=$bookmarks item=bm}
<tr>
<td style="vertical-align:top;"><a href="{$html->webroot}torrents/view/{$bm.Torrent.id}">{$bm.Torrent.name}</a></td>
<td style="padding:0;">{$bm.Torrent.size|mksize}</td>
<td style="padding:0;">{$bm.Torrent.seeders + $bm.Torrent.leechers}</td>
<td style="padding:0;">{$bm.Torrent.seeders}</td>
<td style="padding:0;">{$bm.Torrent.leechers}</td>

<td style="padding:0;">
<a href="{$html->webroot}torrents/?t={$bm.Torrent.free_type}">{if $bm.Torrent.free_type eq "1"}Обычная{/if}
{if $bm.Torrent.free_type eq "2"}Тренировочная{/if}
{if $bm.Torrent.free_type eq "3"}Золотая{/if}
{if $bm.Torrent.free_type eq "4"}Серебрянная{/if}
{if $bm.Torrent.free_type eq "5"}Скрытая{/if}</a>
</td>
</tr>
{/foreach}
</tbody>
</table>
{$javascript->link("ext-base.js")}
{$javascript->link("ext-all.js")}
{$javascript->link("bookmarks-index.js")}
