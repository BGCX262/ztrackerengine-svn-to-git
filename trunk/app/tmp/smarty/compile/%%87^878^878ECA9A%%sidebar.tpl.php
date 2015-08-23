<?php /* Smarty version 2.6.19, created on 2008-06-25 09:11:19
         compiled from ../views/layouts/sidebar.tpl */ ?>
<?php if (isset ( $this->_tpl_vars['username'] )): ?>
<div class='x-panel'>
<div class='x-panel-header'><?php echo $this->_tpl_vars['username']; ?>
</div>
<div class='x-panel-body' style="padding:5px;">
<?php $_from = $this->_tpl_vars['UserMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menuitem']):
?>
<a href="<?php echo $this->_tpl_vars['html']->webroot; ?>
<?php echo $this->_tpl_vars['menuitem']['Menu']['link']; ?>
"><?php echo $this->_tpl_vars['menuitem']['Menu']['name']; ?>
</a><br/>
<?php endforeach; endif; unset($_from); ?>
</div>
</div>
<?php else: ?>
<div class='x-panel'>
<div class='x-panel-header'>Bymep.com</div>
<div class='x-panel-body' style="padding:5px;text-align:justify;font-size:x-small;">
Бумер - посвящённый кино и другой не менее интересной информации. На сайте представлено невероятное количество современных и классических кинолент, созданных мировым и отечественным кинематографом. Блокбастеры, комедии, сериалы, мультфильмы и многое другое - любой киноман найдёт себе фильм по вкусу, сможет обсудить его или, если фильма не окажется в фильмотеке, заказать его. Заходите, знакомьтесь с нами с волшебным миром кино, и уверяю, вы не останетесь равнодушны. 
</div>
</div>
<?php endif; ?>

<div class='x-panel' style="margin-top:0.5em;">
<div class='x-panel-header'>Друзья сайта</div>
<div class='x-panel-body' style="padding:5px;text-align:justify;font-size:x-small;">
<center><a href="http://zthata.com.ua/" title="Недвижимость и все для дома"><img src="http://zthata.com.ua/ztbutton.gif" alt="Недвижимость и все для дома" border="0"></a></center>
<br/>
<center><a href="http://reliz.lv/" target="_blank"><img src="http://reliz.lv/pic/baner1.gif" alt="Фильмы, Музыка, Игры и много другого .:RELIZ TRACKER:. " border="0"></a></center>
<br/>
<center><a href="6_0%7Chttp://fiwka.vnet.ee/" target="_blank"><img src="http://i035.radikal.ru/0804/36/61b573d2d339.gif"></a></center>
</div>
</div>
