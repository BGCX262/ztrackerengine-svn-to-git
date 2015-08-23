<?php /* Smarty version 2.6.19, created on 2008-07-13 18:58:17
         compiled from /var/www/localhost/htdocs/app/views/torrents/train.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'mksize', '/var/www/localhost/htdocs/app/views/torrents/train.tpl', 19, false),)), $this); ?>
<div class='x-panel-header'>Информация</div>
<div class='x-panel-body' style="padding:5px;">
Администрация не несет ответственности за оформление и качество раздач на тренировочном трекере.
Предоставленные сдесь материалы пока не прошли проверку. Если у Вас есть чем поделиться Вы также можете
попробовать свои силы. (<a href='<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents/upload'>Залить торрент</a>)
</div>
<br/>

<?php if (count ( $this->_tpl_vars['torrents'] ) > 0): ?>
<?php echo $this->_tpl_vars['html']->css("grid.css"); ?>

<?php echo $this->_tpl_vars['html']->css("core.css"); ?>

<?php echo $this->_tpl_vars['html']->css("reset-min.css"); ?>


<table class="full" height="100" id="bookmarks">
<thead><th>Название</th><th>Размер</th><th>Помогает</th><th>Участников</th><th>Коментариев</th><th>Залил</th><th>Дата</th></thead>
<tbody>
<?php $_from = $this->_tpl_vars['torrents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['torrent']):
?>
<tr><td style="padding:0;width:40%;"><a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents/view/<?php echo $this->_tpl_vars['torrent']['t']['id']; ?>
"><?php echo $this->_tpl_vars['torrent']['t']['name']; ?>
</a></td>
<td style="padding:0;"><?php echo ((is_array($_tmp=$this->_tpl_vars['torrent']['t']['size'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
</td>
<td style="padding:0;"></td>
<td style="padding:0;"><?php echo $this->_tpl_vars['torrent']['t']['seeders']; ?>
</td>
<td style="padding:0;">0</td>
<td style="padding:0;"><a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
users/view/<?php echo $this->_tpl_vars['torrent']['u']['id']; ?>
" style="<?php echo $this->_tpl_vars['torrent']['g']['status_style']; ?>
"><?php echo $this->_tpl_vars['torrent']['u']['username']; ?>
 <img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/flag/<?php echo $this->_tpl_vars['torrent']['c']['flagpic']; ?>
" width="16"/></a></td>
<td style="padding:0;"><?php echo $this->_tpl_vars['torrent']['t']['added']; ?>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</tbody>
</table>
<?php echo $this->_tpl_vars['javascript']->link("ext-base.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-all.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("bookmarks-index.js"); ?>

<?php else: ?>
<h1>Нет тренировочных раздачь</h1>
<?php endif; ?>