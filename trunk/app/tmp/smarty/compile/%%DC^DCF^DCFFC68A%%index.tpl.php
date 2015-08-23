<?php /* Smarty version 2.6.19, created on 2008-06-28 12:55:36
         compiled from /var/www/localhost/htdocs/ztracker/app/views/users/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'pagelinks', '/var/www/localhost/htdocs/ztracker/app/views/users/index.tpl', 20, false),array('function', 'cycle', '/var/www/localhost/htdocs/ztracker/app/views/users/index.tpl', 22, false),array('modifier', 'default', '/var/www/localhost/htdocs/ztracker/app/views/users/index.tpl', 30, false),array('modifier', 'mksize', '/var/www/localhost/htdocs/ztracker/app/views/users/index.tpl', 34, false),)), $this); ?>
<?php echo $this->_tpl_vars['html']->css("box.css"); ?>

<?php echo $this->_tpl_vars['html']->css("panel.css"); ?>

<div style="width:92%">
<div class='x-panel-header'>Поиск</div>
<div class='x-panel-body' style="padding:5px;">
<form id='filter' name='filter' method='GET' action="<?php echo $this->_tpl_vars['html']->webroot; ?>
users">
<table class='full'>
<tr><td colspan=2>Имя пользователя:</td></tr>
<tr><td>
<input class='x-form-field x-form-text' style="height:18px;width:90%;" type="text" name="name"/>
</td><td width="100px">
<input type="submit" class="x-btn-text" value="Искать"/>
</td></tr></table>
</form>
</div>
<div class="float_right"><a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents">Все пользователи</a></div>
</div>


<div style="margin-bottom:0.3em;width:300px;"><?php echo smarty_function_pagelinks(array('request' => ($this->_tpl_vars['request_url']),'total' => $this->_tpl_vars['total'],'lpp' => 5,'rpp' => 10,'back' => 'назад','forw' => 'вперед','to_first' => "первая",'to_last' => 'последня','offset' => $this->_tpl_vars['offset'],'separator' => "&nbsp;&nbsp;"), $this);?>
</div>
<?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
<div style="width:45%;height:160px;<?php echo smarty_function_cycle(array('values' => "margin-left:5px,margin-right:5px"), $this);?>
;" class="float_left"> 
<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>

<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc">
<?php if ($this->_tpl_vars['user']['u']['title'] != ''): ?><div class="float_right"><span style="<?php echo $this->_tpl_vars['user']['g']['status_style']; ?>
"><?php echo $this->_tpl_vars['user']['u']['title']; ?>
</span></div><?php endif; ?>
<div><a style="<?php echo $this->_tpl_vars['user']['g']['status_style']; ?>
" href="<?php echo $this->_tpl_vars['html']->webroot; ?>
users/view/<?php echo $this->_tpl_vars['user']['u']['id']; ?>
"><?php echo $this->_tpl_vars['user']['u']['username']; ?>
</a></div>
<table class='full' cellspacing='0' cellpadding='0'>
<tr>
<td width="100"><img src="<?php echo ((is_array($_tmp=@$this->_tpl_vars['user']['u']['avatar'])) ? $this->_run_mod_handler('default', true, $_tmp, '/ztracker/img/default_avatar.gif') : smarty_modifier_default($_tmp, '/ztracker/img/default_avatar.gif')); ?>
" height="100" width="100"></td>
<td valign="top" align="left">

<table class='fixed' cellspacing='0' cellpadding='0'>
<tr><td>Загрузил:</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['u']['uploaded'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
</td>
</tr><tr>
<td>Скачал:</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['u']['downloaded'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
</td></tr>
<tr><td><img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/flag/<?php echo $this->_tpl_vars['user']['c']['flagpic']; ?>
"/></td></tr>
</table>

</td>
</tr>
</table>

</div></div></div>

<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
</div>
<?php endforeach; endif; unset($_from); ?>
<div style="margin-bottom:0.3em;width:300px;"><?php echo smarty_function_pagelinks(array('request' => ($this->_tpl_vars['request_url']),'total' => $this->_tpl_vars['total'],'lpp' => 5,'rpp' => 10,'back' => 'назад','forw' => 'вперед','to_first' => "первая",'to_last' => 'последня','offset' => $this->_tpl_vars['offset'],'separator' => "&nbsp;&nbsp;"), $this);?>
</div>