<?php /* Smarty version 2.6.19, created on 2008-07-11 11:41:49
         compiled from /var/www/localhost/htdocs/app/views/torrents/upload.tpl */ ?>
<?php echo '
<style>
div {text-align:left;}
</style>
'; ?>

<?php echo $this->_tpl_vars['html']->css("form.css"); ?>

<?php echo $this->_tpl_vars['html']->css("box.css"); ?>

<?php echo $this->_tpl_vars['html']->css("panel.css"); ?>

<?php echo $this->_tpl_vars['html']->css("button.css"); ?>

<?php echo $this->_tpl_vars['html']->css("toolbar.css"); ?>

<?php echo $this->_tpl_vars['html']->css("reset-min.css"); ?>

<?php echo $this->_tpl_vars['html']->css("window.css"); ?>

<?php echo $this->_tpl_vars['html']->css("dialog.css"); ?>

<?php echo $this->_tpl_vars['html']->css("combo.css"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-base.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-all.js"); ?>


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
<?php echo $this->_tpl_vars['javascript']->link("upload-editor.js"); ?>
