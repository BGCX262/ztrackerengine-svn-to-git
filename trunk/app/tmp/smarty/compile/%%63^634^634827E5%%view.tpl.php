<?php /* Smarty version 2.6.19, created on 2008-07-14 11:42:05
         compiled from /var/www/localhost/htdocs/app/views/users/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/var/www/localhost/htdocs/app/views/users/view.tpl', 37, false),array('modifier', 'mksize', '/var/www/localhost/htdocs/app/views/users/view.tpl', 50, false),array('modifier', 'string_format', '/var/www/localhost/htdocs/app/views/users/view.tpl', 52, false),array('modifier', 'format_bb', '/var/www/localhost/htdocs/app/views/users/view.tpl', 96, false),)), $this); ?>
<?php echo $this->_tpl_vars['html']->css("panel.css"); ?>

<?php echo $this->_tpl_vars['html']->css("layout.css"); ?>

<?php echo $this->_tpl_vars['html']->css("core.css"); ?>

<?php echo $this->_tpl_vars['html']->css("menu.css"); ?>

<?php echo $this->_tpl_vars['html']->css('core.css'); ?>

<?php echo $this->_tpl_vars['html']->css('layout.css'); ?>

<?php echo $this->_tpl_vars['html']->css('form.css'); ?>

<?php echo $this->_tpl_vars['html']->css('button.css'); ?>

<?php echo $this->_tpl_vars['html']->css('qtips.css'); ?>

<?php echo $this->_tpl_vars['html']->css('resizable.css'); ?>

<?php echo $this->_tpl_vars['html']->css('window.css'); ?>

<?php echo $this->_tpl_vars['html']->css('combo.css'); ?>



<?php echo $this->_tpl_vars['javascript']->link("ext-base.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-all.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("miframe-min.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("tiny_mce/tiny_mce.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("Ext.ux.TinyMCE.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("newmessage.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("transfer_ratio.js"); ?>


<script>var username="<?php echo $this->_tpl_vars['user']['User']['username']; ?>
";var userid="<?php echo $this->_tpl_vars['user']['User']['id']; ?>
";</script>
<div class='x-panel-header'><h2><?php echo $this->_tpl_vars['user']['User']['username']; ?>
</h2></div>
<div class='x-panel-body'>

<table class='full'>
<tr>
<td style="width:200px;text-align:center;vertical-align:top;" rowspan=2><img src=<?php if ($this->_tpl_vars['user']['User']['avatar'] != ''): ?>"<?php echo $this->_tpl_vars['user']['User']['avatar']; ?>
"<?php else: ?>"<?php echo $this->_tpl_vars['html']->webroot; ?>
img/default_avatar.gif"<?php endif; ?> width="100px"><br/>
<?php if ($this->_tpl_vars['self'] != true): ?><div id="addfriend"><a href="#">Подружиться</a></div><?php endif; ?>
</td>

<td style="vertical-align:top;text-align:left;padding:0.5em;">
<div class="float_right"><img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/flag/<?php echo $this->_tpl_vars['user']['Country']['flagpic']; ?>
"/></div>
<h2 style="<?php echo $this->_tpl_vars['user']['Group']['status_style']; ?>
"><span style="font-size:200%;"><?php echo $this->_tpl_vars['user']['Group']['user_status']; ?>
</span></h2>
<?php if ($this->_tpl_vars['user']['User']['title'] != ''): ?><h2><?php echo $this->_tpl_vars['user']['User']['title']; ?>
</h2><?php endif; ?>
<p>Зарегистрирован: <?php echo ((is_array($_tmp=$this->_tpl_vars['user']['User']['added'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<br/>
Последний раз был на сайте: <?php echo $this->_tpl_vars['user']['User']['last_login']; ?>
</p>
</td>
</tr>
<tr><td style="padding:0.5em;">

<?php if ($this->_tpl_vars['user']['User']['downloaded'] != '0'): ?> <?php $this->assign('ratio', $this->_tpl_vars['user']['User']['uploaded']/$this->_tpl_vars['user']['User']['downloaded']); ?> <?php else: ?> <?php $this->assign('ratio', "беск."); ?> <?php endif; ?>

<div class="floatbox">
<div style="width:48%;margin-right:1em;margin-bottom:1em;" class="float_right">
<div class='x-panel-header'>Трекер</div>
<div class='x-panel-body' style="padding:5px;">
<p>
<img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/arrowup.gif" />&nbsp;Залил: <?php echo ((is_array($_tmp=$this->_tpl_vars['user']['User']['uploaded'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
&nbsp;
<img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/arrowdown.gif" />&nbsp;Скачал: <?php echo ((is_array($_tmp=$this->_tpl_vars['user']['User']['downloaded'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
<br/>
Рейтинг: <?php if ($this->_tpl_vars['ratio'] > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ratio'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
<?php else: ?>беск.<?php endif; ?>&nbsp;
(Бонус: <?php echo ((is_array($_tmp=$this->_tpl_vars['user']['User']['bonus'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
)</p>
<?php if ($this->_tpl_vars['self'] != true): ?><center><div id="transfer"><a href=#>Трансфер трафика</a></div></center><?php endif; ?>
</div>
</div>


<div style="width:48%;margin-bottom:1em;">
<div class='x-panel-header'>Контакты</div>
<div class='x-panel-body' style="padding:5px;">
<p>
<?php if ($this->_tpl_vars['user']['User']['icq'] != ''): ?><img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/contact/icq.gif" />&nbsp;<?php echo $this->_tpl_vars['user']['User']['icq']; ?>
<br/><?php endif; ?>
<?php if ($this->_tpl_vars['user']['User']['skype'] != ''): ?><img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/contact/skype.gif" />&nbsp;<?php echo $this->_tpl_vars['user']['User']['skype']; ?>
<br/><?php endif; ?>
<?php if ($this->_tpl_vars['user']['User']['yahoo'] != ''): ?><img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/contact/yahoo.gif" />&nbsp;<?php echo $this->_tpl_vars['user']['User']['yahoo']; ?>
<br/><?php endif; ?>
<?php if ($this->_tpl_vars['user']['User']['website'] != ''): ?>Сайт: <?php echo $this->_tpl_vars['user']['User']['website']; ?>
<br/><?php endif; ?>
</p>
<?php if ($this->_tpl_vars['self'] != true): ?>
<?php if ($this->_tpl_vars['user']['User']['acceptpms'] == 'yes'): ?><center><div id="sendpm"><a href=#>Отправить личное сообщение</a></div></center><?php endif; ?>
<?php endif; ?>
</div>
</div>
</div>
<?php echo '
<style>
.center_cell {
    vertical-align:middle !important;
}
</style>
'; ?>


<?php echo $this->_tpl_vars['html']->css('grid.css'); ?>

<?php echo $this->_tpl_vars['html']->css('reset-min.css'); ?>

<div id='upload_block' style="margin-top:5px;"></div>
<script>
var user_id=<?php echo $this->_tpl_vars['user']['User']['id']; ?>
;
</script>
<?php echo $this->_tpl_vars['javascript']->link("uploads.js"); ?>


<div id='connect_block' style="margin-top:5px;"></div>
<?php echo $this->_tpl_vars['javascript']->link("connects.js"); ?>


<?php if ($this->_tpl_vars['user']['User']['info'] != ''): ?>
<div class='x-panel-header' style="margin-top:0.5em;">Дополнительная информация</div>
<div class='x-panel-body' style="padding:5px;">
<?php echo ((is_array($_tmp=$this->_tpl_vars['user']['User']['info'])) ? $this->_run_mod_handler('format_bb', true, $_tmp) : smarty_modifier_format_bb($_tmp)); ?>

</div>
<?php endif; ?>

</td></tr></table>

</div>
<?php echo $this->_tpl_vars['javascript']->link("user-view.js"); ?>

<?php if ($this->_tpl_vars['self'] != true): ?>
<?php if ($this->_tpl_vars['can_edit'] == true): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../views/users/editor.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
<?php endif; ?>