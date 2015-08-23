{$html->css("panel.css")}
{$html->css("button.css")}
{$html->css("form.css")}
{$html->css("date-picker.css")}
{$html->css("combo.css")}
{$javascript->link("ext-base.js")}
{$javascript->link("ext-all.js")}

{literal}
<style>
.x-form-element .strengthMeter {
.border: 1px solid #B5B8C8;
 margin: 3px 0 3px 0;
 background-image: url({/literal}{$html->webroot}{literal}img/meter_background.gif);
}
.x-form-element .strengthMeter-focus {
 border: 1px solid #000;
}
.x-form-element .scoreBar {
 background-image: url({/literal}{$html->webroot}{literal}img/meter.gif);
 height: 10px;
 width: 0px;
 line-height: 1px;
 font-size: 1px;
}
</style>
{/literal}
<div id="register_form"></div>
{$javascript->link("Ext.ux.Crypto.SHA1.js")}
{$javascript->link("Ext.ux.PasswordMeter.js")}
{$javascript->link("countries.js")}
{$javascript->link("users-register.js")}
