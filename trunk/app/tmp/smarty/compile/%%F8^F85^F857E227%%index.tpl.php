<?php /* Smarty version 2.6.19, created on 2008-07-11 13:01:07
         compiled from /var/www/localhost/htdocs/app/views/bookmarks/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'mksize', '/var/www/localhost/htdocs/app/views/bookmarks/index.tpl', 10, false),)), $this); ?>
<?php echo $this->_tpl_vars['html']->css("grid.css"); ?>

<?php echo $this->_tpl_vars['html']->css("core.css"); ?>

<?php echo $this->_tpl_vars['html']->css("reset-min.css"); ?>

<table class="full" height="100" style="border:1px solid gray;" id="bookmarks">
<thead><tr><th>Название</th><th>Размер</th><th>Учасников</th><th>Раздают</th><th>Качают</th><th>Тип</th></tr></thead>
<tbody>
<?php $_from = $this->_tpl_vars['bookmarks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['bm']):
?>
<tr>
<td style="vertical-align:top;"><a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents/view/<?php echo $this->_tpl_vars['bm']['Torrent']['id']; ?>
"><?php echo $this->_tpl_vars['bm']['Torrent']['name']; ?>
</a></td>
<td style="padding:0;"><?php echo ((is_array($_tmp=$this->_tpl_vars['bm']['Torrent']['size'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
</td>
<td style="padding:0;"><?php echo $this->_tpl_vars['bm']['Torrent']['seeders']; ?>
</td>
<td style="padding:0;"><?php echo $this->_tpl_vars['bm']['Torrent']['seeders']; ?>
</td>
<td style="padding:0;"><?php echo $this->_tpl_vars['bm']['Torrent']['leechers']; ?>
</td>

<td style="padding:0;">
<a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents/?t=<?php echo $this->_tpl_vars['bm']['Torrent']['free_type']; ?>
"><?php if ($this->_tpl_vars['bm']['Torrent']['free_type'] == '1'): ?>Обычная<?php endif; ?>
<?php if ($this->_tpl_vars['bm']['Torrent']['free_type'] == '2'): ?>Тренировочная<?php endif; ?>
<?php if ($this->_tpl_vars['bm']['Torrent']['free_type'] == '3'): ?>Золотая<?php endif; ?>
<?php if ($this->_tpl_vars['bm']['Torrent']['free_type'] == '4'): ?>Серебрянная<?php endif; ?>
<?php if ($this->_tpl_vars['bm']['Torrent']['free_type'] == '5'): ?>Скрытая<?php endif; ?></a>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</tbody>
</table>
<?php echo $this->_tpl_vars['javascript']->link("ext-base.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-all.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("bookmarks-index.js"); ?>
