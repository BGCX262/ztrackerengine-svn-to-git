{$html->css("reset-min.css")}
{$html->css("box.css")}
{$html->css("tabs.css")}
{$html->css("button.css")}
{$html->css("form.css")}
{$html->css("layout.css")}
{$html->css("panel.css")}
{$html->css("date-picker.css")}
{$html->css("toolbar.css")}
{$html->css("editor.css")}
{$html->css("combo.css")}
{$html->css("core.css")}
{$html->css("tabs.css")}
{$html->css("qtips.css")}
{$javascript->link("ext-base.js")}
{$javascript->link("ext-all.js")}

<h3>Редактор профиля</h3>
<div>

<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>

<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc">
<div id="profileeditor" name="profileeditor"></div>
</div></div></div>

<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
</div>
{$javascript->link("miframe-min.js")}
{$javascript->link("tiny_mce/tiny_mce.js")}
{$javascript->link("Ext.ux.TinyMCE.js")}
<script>
var country_value="{$User.Country.name}";var countryid_value="{$User.Country.id}";var email_value="{$User.User.email}";
var birth_value="{$User.User.birthday}";var avatar_value="{$User.User.avatar}";var gender_value="{$User.User.gender}";
var icq_value="{$User.User.icq}";var skype_value="{$User.User.skype}";var yahoo_value="{$User.User.yahoo}";var jabber_value="{$User.User.jabber}";
</script>
{$javascript->link("profile-editor.js")}
