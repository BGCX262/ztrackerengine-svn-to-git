<?php /* Smarty version 2.6.19, created on 2008-07-04 12:20:31
         compiled from /var/www/localhost/htdocs/ztracker/app/views/torrents/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'format_bb', '/var/www/localhost/htdocs/ztracker/app/views/torrents/view.tpl', 47, false),array('modifier', 'mksize', '/var/www/localhost/htdocs/ztracker/app/views/torrents/view.tpl', 50, false),array('modifier', 'date_format', '/var/www/localhost/htdocs/ztracker/app/views/torrents/view.tpl', 95, false),array('modifier', 'default', '/var/www/localhost/htdocs/ztracker/app/views/torrents/view.tpl', 98, false),)), $this); ?>
<?php echo $this->_tpl_vars['html']->css("panel.css"); ?>

<?php echo $this->_tpl_vars['html']->css("rating.css"); ?>

<?php echo $this->_tpl_vars['html']->css("form.css"); ?>

<?php echo $this->_tpl_vars['html']->css("combo.css"); ?>

<?php echo $this->_tpl_vars['javascript']->link("/ext/adapter/ext/ext-base.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("/ext/ext-all.js"); ?>


<?php if ($this->_tpl_vars['canedit'] == true): ?>
<?php echo $this->_tpl_vars['javascript']->link("torrent-edit.js"); ?>

<?php endif; ?>
<?php if ($this->_tpl_vars['candelete'] == true): ?>
<?php echo $this->_tpl_vars['javascript']->link("torrent-delete.js"); ?>

<?php endif; ?>

<div id='nfo' name='nfo' style="display:none;text-align:left;padding:5px"><pre><?php echo $this->_tpl_vars['nfo']; ?>
</pre></div>
<div id='torrent'>
<div class='x-panel-header'><h2><?php echo $this->_tpl_vars['torrent']['Torrent']['name']; ?>
</h2></div>
<div class='x-panel-body'>
<table class="full">

<tr>
<td style="width:200px;padding:0.5em;">
<div id="bookmark"><center><a href="#">В закладки</a></center></div>
<img style="width:180px;" src="<?php echo $this->_tpl_vars['torrent']['Torrent']['image1']; ?>
" width="180" alt="<?php echo $this->_tpl_vars['torrent']['Torrent']['name']; ?>
"/>
<div style="text-align:center;">Рейтинг</div>
<div id="rating" style="margin-left:auto;margin-right:auto;text-align:center;">
<center><?php echo $this->_tpl_vars['rating']; ?>
</center>
</div>
</td>

<td style="vertical-align:top;">
<div style="margin:5px;">
<table class="full"> 
<tr>
<td width="100"><a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents/download/<?php echo $this->_tpl_vars['torrent']['Torrent']['id']; ?>
" style="text-decoration:none;"><img align="middle" src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/download.png"/>&nbsp;Скачать</a></td>
<td id='nfofile'><a href="#" style="text-decoration:none;"><img align="middle" src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/info.png"/>&nbsp;NFO-файл</a></td>
<?php if ($this->_tpl_vars['canedit'] == true): ?>
<td width="120"><div id="edittorrent"><a href="#" style="text-decoration:none;"><img align="middle" src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/edit.png"/>&nbsp;Редактировать</a></div></td>
<?php endif; ?>
<?php if ($this->_tpl_vars['candelete'] == true): ?>
<td width="90"><div id="deltorrent"><a href="#" style="text-decoration:none;"><img align="middle" src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/delete.png"/>&nbsp;Удалить</a></div></td>
<?php endif; ?>
</tr>
</table>
</div>
<div>Категория: <a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents?c=<?php echo $this->_tpl_vars['torrent']['Torrent']['category']; ?>
"><?php echo $this->_tpl_vars['torrent']['Category']['name']; ?>
</a></div>
<div id="descr1"><p><?php echo ((is_array($_tmp=$this->_tpl_vars['torrent']['Torrent']['descr1'])) ? $this->_run_mod_handler('format_bb', true, $_tmp) : smarty_modifier_format_bb($_tmp)); ?>
</p></div>
<div id="descr3"><p><?php echo ((is_array($_tmp=$this->_tpl_vars['torrent']['Torrent']['descr3'])) ? $this->_run_mod_handler('format_bb', true, $_tmp) : smarty_modifier_format_bb($_tmp)); ?>
</p></div>
<div style="margin-top:10px;"><p><b>Залил:</b> &nbsp;<a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
users/view/<?php echo $this->_tpl_vars['torrent']['owner']['id']; ?>
" style="<?php echo $this->_tpl_vars['torrent']['owner']['Group']['status_style']; ?>
"><?php echo $this->_tpl_vars['torrent']['owner']['username']; ?>
</a>&nbsp;<img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/flag/<?php echo $this->_tpl_vars['torrent']['owner']['Country']['flagpic']; ?>
" width=16/></p>
<p><b>Размер:</b> <?php echo ((is_array($_tmp=$this->_tpl_vars['torrent']['Torrent']['size'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
</p></div>
</td>
</tr>
</table>
</div>

<?php if ($this->_tpl_vars['torrent']['Torrent']['free_type'] == '1'): ?>
<div class='x-panel'>
<div class='x-panel-header'><span style="color: #CC6600 !important;">Золотая раздача</span></div>
<div class='x-panel-bwrap'><div class='x-panel-body' style="padding:5px;">
Это обозначает то, что Вы можете качать и рейтинг для Вас на скачивание файлов не учитывается, а на раздачу учитывается. Таким образом, на золотых раздачах появляется уникальная возможность поднять свой рейтинг.
</div></div>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['torrent']['Torrent']['free_type'] == '2'): ?>
<div class='x-panel'>
<div class='x-panel-header'><span style="color: #333366 !important;">Серебряная раздача</span></div>
<div class='x-panel-bwrap'><div class='x-panel-body' style="padding:5px;">
Это значит, что Вы можете качать и рейтинг при этом для Вас на скачивание файлов учитывается только на 50%, а на раздачу учитывается. Таким образом, на этой раздаче Вы сильно поднимете свой рейтинг. Это уникальная возможность поднять рейтинг.
</div></div>
</div>
<?php endif; ?>


<div class='x-panel' style="margin-top:0.5em;margin-bottom:0.5em;">
<div class='x-panel-header'>Информация</div>
<div class='x-panel-bwrap'><div class='x-panel-body' style="padding:5px;"><cite><?php echo ((is_array($_tmp=$this->_tpl_vars['torrent']['Torrent']['descr2'])) ? $this->_run_mod_handler('format_bb', true, $_tmp) : smarty_modifier_format_bb($_tmp)); ?>
</cite></div></div>
</div>

<?php if ($this->_tpl_vars['torrent']['Torrent']['descr4'] != ""): ?>
<div class='x-panel' id='descr4' style="margin-top:0.5em;margin-bottom:0.5em;">
<div class='x-panel-header'>Дополнительная информация/скриншоты</div>
<div class='x-panel-body' style='padding:5px;'><?php echo ((is_array($_tmp=$this->_tpl_vars['torrent']['Torrent']['descr4'])) ? $this->_run_mod_handler('format_bb', true, $_tmp) : smarty_modifier_format_bb($_tmp)); ?>
</div>
</div>
<?php endif; ?>

<script> var torid = <?php echo $this->_tpl_vars['torrent']['Torrent']['id']; ?>
;</script>
<div id='file_list'></div>

<div id='peer_list' style="margin-top:0.5em;margin-bottom:0.5em;"></div>
<div id='peer_error' style="margin-top:0.5em;margin-bottom:0.5em;"></div>
</div>
<div id="delcomment">
<?php $_from = $this->_tpl_vars['torrent']['Comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comment']):
?>
<div class='x-panel'>
<div class='x-panel-header'><a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
users/view/<?php echo $this->_tpl_vars['comment']['User']['id']; ?>
"><?php echo $this->_tpl_vars['comment']['User']['username']; ?>
</a> <?php echo ((is_array($_tmp=$this->_tpl_vars['comment']['added'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%c") : smarty_modifier_date_format($_tmp, "%c")); ?>
</div>
<div class='x-panel-body'>
<table class='full'>
<tr><td style="width:120px;"><img src="<?php echo ((is_array($_tmp=@$this->_tpl_vars['comment']['User']['avatar'])) ? $this->_run_mod_handler('default', true, $_tmp, 'img/default_avatar.gif') : smarty_modifier_default($_tmp, 'img/default_avatar.gif')); ?>
" width="100px"/></td><td style="text-align:left;vertical-align:top;"><?php if ($this->_tpl_vars['delete_comm'] == true): ?><div class="float_right"><a id="<?php echo $this->_tpl_vars['comment']['id']; ?>
" href="#">Удалить</a></div><?php endif; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['comment']['text'])) ? $this->_run_mod_handler('format_bb', true, $_tmp) : smarty_modifier_format_bb($_tmp)); ?>
</td></tr>
</table>
</div>
</div>
<?php endforeach; endif; unset($_from); ?>
</div>
<!--- <?php echo $this->_tpl_vars['html']->css('reset-min.css'); ?>
 -->
<?php echo $this->_tpl_vars['html']->css('button.css'); ?>

<?php echo $this->_tpl_vars['html']->css('reset-min.css'); ?>

<?php echo $this->_tpl_vars['html']->css('grid.css'); ?>

<?php echo $this->_tpl_vars['html']->css("layout.css"); ?>

<?php echo $this->_tpl_vars['html']->css("core.css"); ?>

<?php echo $this->_tpl_vars['html']->css("window.css"); ?>


<div id='editor'></div>
<?php echo $this->_tpl_vars['javascript']->link("miframe-min.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("tiny_mce/tiny_mce.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("Ext.ux.TinyMCE.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("torrent-view.js"); ?>

