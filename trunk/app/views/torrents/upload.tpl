{literal}
<style>
div {text-align:left;}
</style>
{/literal}
{$html->css("form.css")}
{$html->css("box.css")}
{$html->css("panel.css")}
{$html->css("button.css")}
{$html->css("toolbar.css")}
{$html->css("reset-min.css")}
{$html->css("window.css")}
{$html->css("dialog.css")}
{$html->css("combo.css")}
{$javascript->link("ext-base.js")}
{$javascript->link("ext-all.js")}

<div class='x-panel-header'><h3>Загрузить торрент</h3></div>
<div>

<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc"> 
<div id="uploadeditor" name="uploadeditor">
<div id="toolbar"></div>

</div>
</div></div></div>

<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
</div>
<div id='preview'></div>
{$javascript->link("upload-editor.js")}
