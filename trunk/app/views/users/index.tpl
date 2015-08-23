{$html->css("box.css")}
{$html->css("panel.css")}
<div style="width:92%">
<div class='x-panel-header'>Поиск</div>
<div class='x-panel-body' style="padding:5px;">
<form id='filter' name='filter' method='GET' action="{$html->webroot}users">
<table class='full'>
<tr><td colspan=2>Имя пользователя:</td></tr>
<tr><td>
<input class='x-form-field x-form-text' style="height:18px;width:90%;" type="text" name="name"/>
</td><td width="100px">
<input type="submit" class="x-btn-text" value="Искать"/>
</td></tr></table>
</form>
</div>
<div class="float_right"><a href="{$html->webroot}torrents">Все пользователи</a></div>
</div>


<div style="margin-bottom:0.3em;width:300px;">{pagelinks request="$request_url" total=$total lpp=5 rpp=10 back='назад' forw='вперед' to_first="первая" to_last='последня' offset=$offset separator="&nbsp;&nbsp;"}</div>
{foreach from=$users item=user}
<div style="width:45%;height:160px;{cycle values="margin-left:5px,margin-right:5px"};" class="float_left"> 
<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>

<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc">
{if $user.u.title ne ''}<div class="float_right"><span style="{$user.g.status_style}">{$user.u.title}</span></div>{/if}
<div><a style="{$user.g.status_style}" href="{$html->webroot}users/view/{$user.u.id}">{$user.u.username}</a></div>
<table class='full' cellspacing='0' cellpadding='0'>
<tr>
<td width="100"><img src="{$user.u.avatar|default:'/ztracker/img/default_avatar.gif'}" height="100" width="100"></td>
<td valign="top" align="left">

<table class='fixed' cellspacing='0' cellpadding='0'>
<tr><td>Загрузил:</td><td>{$user.u.uploaded|mksize}</td>
</tr><tr>
<td>Скачал:</td><td>{$user.u.downloaded|mksize}</td></tr>
<tr><td><img src="{$html->webroot}img/flag/{$user.c.flagpic}"/></td></tr>
</table>

</td>
</tr>
</table>

</div></div></div>

<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
</div>
{/foreach}
<div style="margin-bottom:0.3em;width:300px;">{pagelinks request="$request_url" total=$total lpp=5 rpp=10 back='назад' forw='вперед' to_first="первая" to_last='последня' offset=$offset separator="&nbsp;&nbsp;"}</div>
