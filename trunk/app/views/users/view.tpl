{$html->css("panel.css")}
{$html->css("layout.css")}
{$html->css("core.css")}
{$html->css("menu.css")}
{$html->css('core.css')}
{$html->css('layout.css')}
{$html->css('form.css')}
{$html->css('button.css')}
{$html->css('qtips.css')}
{$html->css('resizable.css')}
{$html->css('window.css')}
{$html->css('combo.css')}


{$javascript->link("ext-base.js")}
{$javascript->link("ext-all.js")}
{$javascript->link("miframe-min.js")}
{$javascript->link("tiny_mce/tiny_mce.js")}
{$javascript->link("Ext.ux.TinyMCE.js")}
{$javascript->link("newmessage.js")}
{$javascript->link("transfer_ratio.js")}

<script>var username="{$user.User.username}";var userid="{$user.User.id}";</script>
<div class='x-panel-header'><h2>{$user.User.username}</h2></div>
<div class='x-panel-body'>

<table class='full'>
<tr>
<td style="width:200px;text-align:center;vertical-align:top;" rowspan=2><img src={if $user.User.avatar ne ''}"{$user.User.avatar}"{else}"{$html->webroot}img/default_avatar.gif"{/if} width="100px"><br/>
{if $self ne true}<div id="addfriend"><a href="#">Подружиться</a></div>{/if}
</td>

<td style="vertical-align:top;text-align:left;padding:0.5em;">
<div class="float_right"><img src="{$html->webroot}img/flag/{$user.Country.flagpic}"/></div>
<h2 style="{$user.Group.status_style}"><span style="font-size:200%;">{$user.Group.user_status}</span></h2>
{if $user.User.title ne ''}<h2>{$user.User.title}</h2>{/if}
<p>Зарегистрирован: {$user.User.added|date_format}<br/>
Последний раз был на сайте: {$user.User.last_login}</p>
</td>
</tr>
<tr><td style="padding:0.5em;">

{if $user.User.downloaded ne '0'} {assign var="ratio" value=$user.User.uploaded/$user.User.downloaded} {else} {assign var="ratio" value="беск."} {/if}

<div class="floatbox">
<div style="width:48%;margin-right:1em;margin-bottom:1em;" class="float_right">
<div class='x-panel-header'>Трекер</div>
<div class='x-panel-body' style="padding:5px;">
<p>
<img src="{$html->webroot}img/arrowup.gif" />&nbsp;Залил: {$user.User.uploaded|mksize}&nbsp;
<img src="{$html->webroot}img/arrowdown.gif" />&nbsp;Скачал: {$user.User.downloaded|mksize}<br/>
Рейтинг: {if $ratio > 0}{$ratio|string_format:"%.2f"}{else}беск.{/if}&nbsp;
(Бонус: {$user.User.bonus|mksize})</p>
{if $self ne true}<center><div id="transfer"><a href=#>Трансфер трафика</a></div></center>{/if}
</div>
</div>


<div style="width:48%;margin-bottom:1em;">
<div class='x-panel-header'>Контакты</div>
<div class='x-panel-body' style="padding:5px;">
<p>
{if $user.User.icq ne ''}<img src="{$html->webroot}img/contact/icq.gif" />&nbsp;{$user.User.icq}<br/>{/if}
{if $user.User.skype ne ''}<img src="{$html->webroot}img/contact/skype.gif" />&nbsp;{$user.User.skype}<br/>{/if}
{if $user.User.yahoo ne ''}<img src="{$html->webroot}img/contact/yahoo.gif" />&nbsp;{$user.User.yahoo}<br/>{/if}
{if $user.User.website ne ''}Сайт: {$user.User.website}<br/>{/if}
</p>
{if $self ne true}
{if $user.User.acceptpms eq 'yes'}<center><div id="sendpm"><a href=#>Отправить личное сообщение</a></div></center>{/if}
{/if}
</div>
</div>
</div>
{literal}
<style>
.center_cell {
    vertical-align:middle !important;
}
</style>
{/literal}

{$html->css('grid.css')}
{$html->css('reset-min.css')}
<div id='upload_block' style="margin-top:5px;"></div>
<script>
var user_id={$user.User.id};
</script>
{$javascript->link("uploads.js")}

<div id='connect_block' style="margin-top:5px;"></div>
{$javascript->link("connects.js")}

{if $user.User.info ne ''}
<div class='x-panel-header' style="margin-top:0.5em;">Дополнительная информация</div>
<div class='x-panel-body' style="padding:5px;">
{$user.User.info|format_bb}
</div>
{/if}

</td></tr></table>

</div>
{$javascript->link("user-view.js")}
{if $self ne true}
{if $can_edit eq true}{include file='../views/users/editor.tpl'}{/if}
{/if}
