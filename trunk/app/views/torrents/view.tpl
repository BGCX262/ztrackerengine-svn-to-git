{$html->css("panel.css")}
{$html->css("rating.css")}
{$html->css("form.css")}
{$html->css("combo.css")}
{$javascript->link("ext-base.js")}
{$javascript->link("ext-all.js")}

{if $canedit == true}
{$javascript->link("torrent-edit.js")}
{/if}
{if $candelete == true}
{$javascript->link("torrent-delete.js")}
{/if}

<div id='nfo' name='nfo' style="display:none;text-align:left;padding:5px"><pre>{$nfo}</pre></div>
<div id='torrent'>
<div class='x-panel-header'><h2>{$torrent.Torrent.name}</h2></div>
<div class='x-panel-body'>
<table class="full">

<tr>
<td style="width:200px;padding:0.5em;">
<div id="bookmark"><center><a href="#">В закладки</a></center></div>
<img style="width:180px;" src="{$torrent.Torrent.image1}" width="180" alt="{$torrent.Torrent.name}"/>
<div style="text-align:center;">Рейтинг</div>
<div id="rating" style="margin-left:auto;margin-right:auto;text-align:center;">
<center>{$rating}</center>
</div>
</td>

<td style="vertical-align:top;">
<div style="margin:5px;">
<table class="full"> 
<tr>
<td width="100"><a href="{$html->webroot}torrents/download/{$torrent.Torrent.id}" style="text-decoration:none;"><img align="middle" src="{$html->webroot}img/download.png"/>&nbsp;Скачать</a></td>
<td id='nfofile'><a href="#" style="text-decoration:none;"><img align="middle" src="{$html->webroot}img/info.png"/>&nbsp;NFO-файл</a></td>
{if $canedit == true}
<td width="120"><div id="edittorrent"><a href="#" style="text-decoration:none;"><img align="middle" src="{$html->webroot}img/edit.png"/>&nbsp;Редактировать</a></div></td>
{/if}
{if $candelete == true}
<td width="90"><div id="deltorrent"><a href="#" style="text-decoration:none;"><img align="middle" src="{$html->webroot}img/delete.png"/>&nbsp;Удалить</a></div></td>
{/if}
</tr>
</table>
</div>
<div>Категория: <a href="{$html->webroot}torrents?c={$torrent.Torrent.category}">{$torrent.Category.name}</a></div>
<div id="descr1"><p>{$torrent.Torrent.descr1|format_bb}</p></div>
<div id="descr3"><p>{$torrent.Torrent.descr3|format_bb}</p></div>
<div style="margin-top:10px;"><p><b>Залил:</b> &nbsp;<a href="{$html->webroot}users/view/{$torrent.owner.id}" style="{$torrent.owner.Group.status_style}">{$torrent.owner.username}</a>&nbsp;<img src="{$html->webroot}img/flag/{$torrent.owner.Country.flagpic}" width=16/></p>
<p><b>Размер:</b> {$torrent.Torrent.size|mksize}</p></div>
</td>
</tr>
</table>
</div>

{if $torrent.Torrent.free_type eq '1'}
<div class='x-panel'>
<div class='x-panel-header'><span style="color: #CC6600 !important;">Золотая раздача</span></div>
<div class='x-panel-bwrap'><div class='x-panel-body' style="padding:5px;">
Это обозначает то, что Вы можете качать и рейтинг для Вас на скачивание файлов не учитывается, а на раздачу учитывается. Таким образом, на золотых раздачах появляется уникальная возможность поднять свой рейтинг.
</div></div>
</div>
{/if}
{if $torrent.Torrent.free_type eq '2'}
<div class='x-panel'>
<div class='x-panel-header'><span style="color: #333366 !important;">Серебряная раздача</span></div>
<div class='x-panel-bwrap'><div class='x-panel-body' style="padding:5px;">
Это значит, что Вы можете качать и рейтинг при этом для Вас на скачивание файлов учитывается только на 50%, а на раздачу учитывается. Таким образом, на этой раздаче Вы сильно поднимете свой рейтинг. Это уникальная возможность поднять рейтинг.
</div></div>
</div>
{/if}


<div class='x-panel' style="margin-top:0.5em;margin-bottom:0.5em;">
<div class='x-panel-header'>Информация</div>
<div class='x-panel-bwrap'><div class='x-panel-body' style="padding:5px;"><cite>{$torrent.Torrent.descr2|format_bb}</cite></div></div>
</div>

{if $torrent.Torrent.descr4 ne ""}
<div class='x-panel' id='descr4' style="margin-top:0.5em;margin-bottom:0.5em;">
<div class='x-panel-header'>Дополнительная информация/скриншоты</div>
<div class='x-panel-body' style='padding:5px;'>{$torrent.Torrent.descr4|format_bb}</div>
</div>
{/if}

<script> var torid = {$torrent.Torrent.id};</script>
<div id='file_list'></div>

<div id='peer_list' style="margin-top:0.5em;margin-bottom:0.5em;"></div>
<div id='peer_error' style="margin-top:0.5em;margin-bottom:0.5em;"></div>
</div>
<div id="delcomment">
{foreach from=$torrent.Comments item=comment}
<div class='x-panel'>
<div class='x-panel-header'><a href="{$html->webroot}users/view/{$comment.User.id}">{$comment.User.username}</a> {$comment.added|date_format:"%c"}</div>
<div class='x-panel-body'>
<table class='full'>
<tr><td style="width:120px;"><img src="{$comment.User.avatar|default:'img/default_avatar.gif'}" width="100px"/></td><td style="text-align:left;vertical-align:top;">{if $delete_comm == true}<div class="float_right"><a id="{$comment.id}" href="#">Удалить</a></div>{/if}{$comment.text|format_bb}</td></tr>
</table>
</div>
</div>
{/foreach}
</div>
<!--- {$html->css('reset-min.css')} -->
{$html->css('button.css')}
{$html->css('reset-min.css')}
{$html->css('grid.css')}
{$html->css("layout.css")}
{$html->css("core.css")}
{$html->css("window.css")}

<div id='editor'></div>
{$javascript->link("miframe-min.js")}
{$javascript->link("tiny_mce/tiny_mce.js")}
{$javascript->link("Ext.ux.TinyMCE.js")}
{$javascript->link("torrent-view.js")}

