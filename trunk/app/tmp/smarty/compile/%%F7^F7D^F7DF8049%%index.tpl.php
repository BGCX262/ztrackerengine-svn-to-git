<?php /* Smarty version 2.6.19, created on 2008-07-04 12:03:18
         compiled from /var/www/localhost/htdocs/ztracker/app/views/torrents/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'pagelinks', '/var/www/localhost/htdocs/ztracker/app/views/torrents/index.tpl', 18, false),array('modifier', 'mksize', '/var/www/localhost/htdocs/ztracker/app/views/torrents/index.tpl', 29, false),)), $this); ?>
<?php echo $this->_tpl_vars['html']->css("panel.css"); ?>

<?php echo $this->_tpl_vars['html']->css("form.css"); ?>

<?php echo $this->_tpl_vars['html']->css("rating.css"); ?>

<?php echo $this->_tpl_vars['html']->css('reset-min.css'); ?>

<div class='x-panel-header'>Поиск</div>
<div class='x-panel-body' style="padding:5px;">
<form id='filter' name='filter' method='GET' action="<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents">
<table class='full'>
<tr><td colspan=2>Название:</td></tr>
<tr><td>
<input class='x-form-field x-form-text' style="height:18px;width:90%;" type="text" name="name"/>
</td><td width="100px">
<input type="submit" class="x-btn-text" value="Искать"/>
</td></tr></table>
</form>
</div>
<div class="float_right"><a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents">Все раздачи</a></div>
<div style="margin-bottom:0.3em;width:200px;"><?php echo smarty_function_pagelinks(array('request' => ($this->_tpl_vars['request_url']),'total' => $this->_tpl_vars['total'],'lpp' => 5,'rpp' => 10,'back' => 'назад','forw' => 'вперед','to_first' => "первая",'to_last' => 'последня','offset' => $this->_tpl_vars['offset'],'separator' => "&nbsp;&nbsp;"), $this);?>
</div>
<?php $_from = $this->_tpl_vars['torrents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['torrent']):
?> &nbsp;
<div>
<table class="full" height="100" >
<tr><td style="vertical-align:top;width:65px;"><img src="<?php echo $this->_tpl_vars['torrent']['t']['image1']; ?>
" width="60"></td>
<td style="vertical-align:top;">
<div class="x-panel-header"><a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents/view/<?php echo $this->_tpl_vars['torrent']['t']['id']; ?>
"><?php echo $this->_tpl_vars['torrent']['t']['name']; ?>
</a></div>
<div class="x-panel-body" style="padding:5px 0 0 5px;">
Категория: <a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents/?c=<?php echo $this->_tpl_vars['torrent']['cg']['id']; ?>
"><?php echo $this->_tpl_vars['torrent']['cg']['name']; ?>
</a>
<table class='full' style="padding:0;margin-top:5px;">
<tr>
<td style="padding:0;width:20%">Размер: <?php echo ((is_array($_tmp=$this->_tpl_vars['torrent']['t']['size'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
</td>
<td style="padding:0;width:20%">Скачали: <?php echo $this->_tpl_vars['torrent']['t']['times_completed']; ?>
 раз</td>
<td style="padding:0;width:20%">Учасников: <?php echo $this->_tpl_vars['torrent']['t']['seeders']; ?>
</td>
<td style="padding:0;width:20%">Раздают: <?php echo $this->_tpl_vars['torrent']['t']['seeders']; ?>
</td>
<td style="padding:0;width:20%">Качают: <?php echo $this->_tpl_vars['torrent']['t']['leechers']; ?>
</td>
</tr>
<tr>
<td style="padding:0;width:20%">
<a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
torrents/?t=<?php echo $this->_tpl_vars['torrent']['t']['free_type']; ?>
"><?php if ($this->_tpl_vars['torrent']['t']['free_type'] == '1'): ?>Обычная раздача<?php endif; ?>
<?php if ($this->_tpl_vars['torrent']['t']['free_type'] == '2'): ?>Тренировочная раздача<?php endif; ?>
<?php if ($this->_tpl_vars['torrent']['t']['free_type'] == '3'): ?>Золотая раздача<?php endif; ?>
<?php if ($this->_tpl_vars['torrent']['t']['free_type'] == '4'): ?>Серебрянная раздача<?php endif; ?>
<?php if ($this->_tpl_vars['torrent']['t']['free_type'] == '5'): ?>Скрытая раздача<?php endif; ?></a>
</td>
<td style="padding:0;width:20%">
<div id="rating" style="margin-left:auto;margin-right:auto;text-align:center;">
<ul class="star-rating2">
<li class="current-rating" style="width:<?php echo $this->_tpl_vars['torrent'][0]['total']/$this->_tpl_vars['torrent'][0]['votes']*20; ?>
%;"></li>
<li><a class="one-star" href="#">1</a></li>
<li><a class="two-stars" href="#">2</a></li>
<li><a class="three-stars" href="#">3</a></li>
<li><a class="four-stars" href="#">4</a></li>
<li><a class="five-stars" href="#">5</a></li>
</ul>
</div>
</td>

<td style="padding:0;width:20%">Коментариев: 0</td>
<td style="padding:0;width:20%">Залил: <a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
users/view/<?php echo $this->_tpl_vars['torrent']['u']['id']; ?>
" style="<?php echo $this->_tpl_vars['torrent']['g']['status_style']; ?>
"><?php echo $this->_tpl_vars['torrent']['u']['username']; ?>
 <img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/flag/<?php echo $this->_tpl_vars['torrent']['c']['flagpic']; ?>
" width="16"/></a></td>
<td style="padding:0;width:20%"><?php echo $this->_tpl_vars['torrent']['t']['added']; ?>
</td>


</tr>
</table>

</div>
</td>
</tr>
</table>
</div>
<?php endforeach; endif; unset($_from); ?>
<div style="margin-bottom:0.3em;"><?php echo smarty_function_pagelinks(array('request' => ($this->_tpl_vars['request_url']),'total' => $this->_tpl_vars['total'],'lpp' => 5,'rpp' => 10,'back' => 'назад','forw' => 'вперед','to_first' => "первая",'to_last' => 'последня','offset' => $this->_tpl_vars['offset'],'separator' => "&nbsp;&nbsp;"), $this);?>
</div>