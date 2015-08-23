{$html->css("box.css")}
{$html->css("panel.css")}
{$javascript->link("ext-base.js")}
{$javascript->link("ext-all.js")}
{if count($friends) > 0}
{foreach from=$friends item=friend}
<div style="width:45%;height:160px;{cycle values="margin-left:5px,margin-right:5px"};" class="float_left"> 
<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>

<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc">
{if $friend.User.title ne ''}<div class="float_right"><span style="{$friend.User.Group.status_style}">{$friend.User.title}</span></div>{/if}
<div><a style="{$friend.User.Group.status_style}" href="{$html->webroot}users/view/{$friend.User.id}">{$friend.User.username}</a></div>
<table class='full' cellspacing='0' cellpadding='0'>
<tr>
<td width="100">
<img src="{$friend.User.avatar|default:'/ztracker/img/default_avatar.gif'}" height="100" width="100">
<a href="#" id="uid_{$friend.User.id}" class="rFriend">Не дружить</a>
</td>
<td valign="top" align="left">

<table class='fixed' cellspacing='0' cellpadding='0'>
<tr><td>Загрузил:</td><td>{$friend.User.uploaded|mksize}</td>
</tr><tr>
<td>Скачал:</td><td>{$friend.User.downloaded|mksize}</td></tr>
<tr><td><img src="{$html->webroot}img/flag/{$friend.User.Country.flagpic}"/></td></tr>
</table>

</td>
</tr>
</table>

</div></div></div>

<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
</div>
{/foreach}
{literal}
<script>
Ext.onReady(function() {
    Ext.select(".rFriend").on('click',function(e,t) { var id = Ext.get(t.id).id; var m = id.match('uid_([0-9]+)'); Ext.getBody().mask('Обновление информации...'); Ext.Ajax.request({url: 'delfriend', params:{fid:m[1]}, success:function(){location.reload();}}); Ext.getBody().unmask();});})
</script>
{/literal}
{else}
<h1>Вы пока нискем не подружились</h1>
{/if}
