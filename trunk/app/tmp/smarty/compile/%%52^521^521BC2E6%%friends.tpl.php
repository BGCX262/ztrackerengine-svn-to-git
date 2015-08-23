<?php /* Smarty version 2.6.19, created on 2008-07-13 16:33:18
         compiled from /var/www/localhost/htdocs/app/views/users/friends.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', '/var/www/localhost/htdocs/app/views/users/friends.tpl', 7, false),array('modifier', 'default', '/var/www/localhost/htdocs/app/views/users/friends.tpl', 16, false),array('modifier', 'mksize', '/var/www/localhost/htdocs/app/views/users/friends.tpl', 22, false),)), $this); ?>
<?php echo $this->_tpl_vars['html']->css("box.css"); ?>

<?php echo $this->_tpl_vars['html']->css("panel.css"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-base.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-all.js"); ?>

<?php if (count ( $this->_tpl_vars['friends'] ) > 0): ?>
<?php $_from = $this->_tpl_vars['friends']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['friend']):
?>
<div style="width:45%;height:160px;<?php echo smarty_function_cycle(array('values' => "margin-left:5px,margin-right:5px"), $this);?>
;" class="float_left"> 
<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>

<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc">
<?php if ($this->_tpl_vars['friend']['User']['title'] != ''): ?><div class="float_right"><span style="<?php echo $this->_tpl_vars['friend']['User']['Group']['status_style']; ?>
"><?php echo $this->_tpl_vars['friend']['User']['title']; ?>
</span></div><?php endif; ?>
<div><a style="<?php echo $this->_tpl_vars['friend']['User']['Group']['status_style']; ?>
" href="<?php echo $this->_tpl_vars['html']->webroot; ?>
users/view/<?php echo $this->_tpl_vars['friend']['User']['id']; ?>
"><?php echo $this->_tpl_vars['friend']['User']['username']; ?>
</a></div>
<table class='full' cellspacing='0' cellpadding='0'>
<tr>
<td width="100">
<img src="<?php echo ((is_array($_tmp=@$this->_tpl_vars['friend']['User']['avatar'])) ? $this->_run_mod_handler('default', true, $_tmp, '/ztracker/img/default_avatar.gif') : smarty_modifier_default($_tmp, '/ztracker/img/default_avatar.gif')); ?>
" height="100" width="100">
<a href="#" id="uid_<?php echo $this->_tpl_vars['friend']['User']['id']; ?>
" class="rFriend">Не дружить</a>
</td>
<td valign="top" align="left">

<table class='fixed' cellspacing='0' cellpadding='0'>
<tr><td>Загрузил:</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['friend']['User']['uploaded'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
</td>
</tr><tr>
<td>Скачал:</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['friend']['User']['downloaded'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
</td></tr>
<tr><td><img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/flag/<?php echo $this->_tpl_vars['friend']['User']['Country']['flagpic']; ?>
"/></td></tr>
</table>

</td>
</tr>
</table>

</div></div></div>

<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
</div>
<?php endforeach; endif; unset($_from); ?>
<?php echo '
<script>
Ext.onReady(function() {
    Ext.select(".rFriend").on(\'click\',function(e,t) { var id = Ext.get(t.id).id; var m = id.match(\'uid_([0-9]+)\'); Ext.getBody().mask(\'Обновление информации...\'); Ext.Ajax.request({url: \'delfriend\', params:{fid:m[1]}, success:function(){location.reload();}}); Ext.getBody().unmask();});})
</script>
'; ?>

<?php else: ?>
<h1>Вы пока нискем не подружились</h1>
<?php endif; ?>