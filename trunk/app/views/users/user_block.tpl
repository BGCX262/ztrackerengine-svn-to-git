{if $logined eq '0'}
{$html->css("box.css")}
{$html->css("panel.css")}
{$html->css("button.css")}
{$html->css("form.css")}
{$javascript->link("ext-base.js")}
{$javascript->link("ext-all.js")}
<div style='width:300px;'>
<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>

<div class='x-box-ml'><div class='x-box-mr'><div class='x-box-mc'>
<div id='login_form' class='x-form'></div>
</div></div></div>


<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
</div>
{$javascript->link("Ext.ux.Crypto.SHA1.js")}
{$javascript->link("Ext.util.MD5.js")}
{$javascript->link("users-login.js")}
{else}
{literal}
<style>
.userblock {
    padding:0.2em;
    margin:0;
}
</style>
{/literal}
{$html->css("box.css")}
<div style="width:300px">
<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>

<div class='x-box-ml'><div class='x-box-mr'><div class='x-box-mc'>

<div>
<table class='full userblock'>
<tr><td rowspan='5' width='110px' class='userblock'>
{if $avatar eq ''}
<img src="{$html->webroot}img/default_avatar.gif" width='100px'/>
{else}
<img src="{$avatar}" width='100px'/>
{/if}
</td>
<td colspan=2 class='userblock' style="{$group_style}">{$group|lower}</td></tr>
<tr><td colspan=2 class='userblock'><b>{$username|default:'username'}</b></td></tr>
<tr><td class='userblock'><img src="{$html->webroot}img/arrowup.gif" />&nbsp;{$uploaded|mksize}</td><td class='userblock'><img src="{$html->webroot}img/arrowdown.gif" />&nbsp;{$downloaded|mksize}</td></tr>
{if $downloaded ne '0'} {assign var="ratio" value=$uploaded/$downloaded} {else} {assign var="ratio" value="беск."} {/if}
<td colspan=2 class='userblock'>Рейтинг:&nbsp;{if $ratio > 0}{$ratio|string_format:"%.2f"}{else}беск.{/if}</td></tr>
<td colspan=2 class='userblock'>Нет новых сообщений</td></tr>
</table>
</div>

</div></div></div>

<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
</div>
{/if}
