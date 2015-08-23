<?php /* Smarty version 2.6.19, created on 2008-06-30 16:21:19
         compiled from /var/www/localhost/htdocs/ztracker/app/views/home/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'format_bb', '/var/www/localhost/htdocs/ztracker/app/views/home/index.tpl', 20, false),array('function', 'pagelinks', '/var/www/localhost/htdocs/ztracker/app/views/home/index.tpl', 29, false),)), $this); ?>
<div class='x-panel'>
<div class='x-panel-header'>Объявления</div>
<div class='x-panel-body' style="padding:5px;">
<p>Как вы заметили, наш сайт немного изменился. К сожалению еще не все запланированные измения внесены и некоторые возможности не работают.</p>
</div>
</div>

<div class='x-panel' style="margin-top:0.5em;">
<div class='x-panel-header'>Новые поступления</div>
<div class='x-panel-body'>
<?php $_from = $this->_tpl_vars['torrents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['torrent']):
?>
<div>
<div style="margin-left:5px;"><h4><a href="torrents/view/<?php echo $this->_tpl_vars['torrent']['t']['id']; ?>
"><?php echo $this->_tpl_vars['torrent']['t']['name']; ?>
</a></h4></div>
<div class="tor_body">
<table class="full">
<tr>
<td width="190" valign="top"><img src="<?php echo $this->_tpl_vars['torrent']['t']['image1']; ?>
" width="180"></td>
<td valign="top" align="left">
<div class="float_right"><img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/categories/<?php echo $this->_tpl_vars['torrent']['cg']['image']; ?>
"/></div>
<p><?php echo ((is_array($_tmp=$this->_tpl_vars['torrent']['t']['descr1'])) ? $this->_run_mod_handler('format_bb', true, $_tmp) : smarty_modifier_format_bb($_tmp)); ?>
</p>
<cite><?php echo ((is_array($_tmp=$this->_tpl_vars['torrent']['t']['descr2'])) ? $this->_run_mod_handler('format_bb', true, $_tmp) : smarty_modifier_format_bb($_tmp)); ?>
</cite>
<div class="float_right"><a href="torrents/view/<?php echo $this->_tpl_vars['torrent']['t']['id']; ?>
">[Подробнее]</a></div>
</td>
</tr>
</table>
</div>
</div>
<?php endforeach; endif; unset($_from); ?>
<div style="margin-bottom:0.3em;"><?php echo smarty_function_pagelinks(array('request' => ($this->_tpl_vars['request_url']),'total' => $this->_tpl_vars['total'],'lpp' => 5,'rpp' => 5,'back' => 'назад','forw' => 'вперед','to_first' => "первая",'to_last' => 'последня','offset' => $this->_tpl_vars['offset'],'separator' => "&nbsp;&nbsp;"), $this);?>
</div>
</div>
</div>

<div class='x-panel-header'>Сейчас на сайте</div>
<div class='x-panel-body' style="padding:5px;">
<?php $_from = $this->_tpl_vars['OnlineUsers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ou']):
?>
<a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
users/view/<?php echo $this->_tpl_vars['ou']['u']['id']; ?>
" style="<?php echo $this->_tpl_vars['ou']['g']['status_style']; ?>
"><?php echo $this->_tpl_vars['ou']['u']['username']; ?>
</a>
<?php endforeach; endif; unset($_from); ?>
</div>