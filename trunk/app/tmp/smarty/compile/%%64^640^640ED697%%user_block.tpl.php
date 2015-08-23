<?php /* Smarty version 2.6.19, created on 2008-07-14 13:03:58
         compiled from ../views/users/user_block.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'lower', '../views/users/user_block.tpl', 45, false),array('modifier', 'default', '../views/users/user_block.tpl', 46, false),array('modifier', 'mksize', '../views/users/user_block.tpl', 47, false),array('modifier', 'string_format', '../views/users/user_block.tpl', 49, false),)), $this); ?>
<?php if ($this->_tpl_vars['logined'] == '0'): ?>
<?php echo $this->_tpl_vars['html']->css("box.css"); ?>

<?php echo $this->_tpl_vars['html']->css("panel.css"); ?>

<?php echo $this->_tpl_vars['html']->css("button.css"); ?>

<?php echo $this->_tpl_vars['html']->css("form.css"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-base.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-all.js"); ?>

<div style='width:300px;'>
<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>

<div class='x-box-ml'><div class='x-box-mr'><div class='x-box-mc'>
<div id='login_form' class='x-form'></div>
</div></div></div>


<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
</div>
<?php echo $this->_tpl_vars['javascript']->link("Ext.ux.Crypto.SHA1.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("Ext.util.MD5.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("users-login.js"); ?>

<?php else: ?>
<?php echo '
<style>
.userblock {
    padding:0.2em;
    margin:0;
}
</style>
'; ?>

<?php echo $this->_tpl_vars['html']->css("box.css"); ?>

<div style="width:300px">
<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>

<div class='x-box-ml'><div class='x-box-mr'><div class='x-box-mc'>

<div>
<table class='full userblock'>
<tr><td rowspan='5' width='110px' class='userblock'>
<?php if ($this->_tpl_vars['avatar'] == ''): ?>
<img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/default_avatar.gif" width='100px'/>
<?php else: ?>
<img src="<?php echo $this->_tpl_vars['avatar']; ?>
" width='100px'/>
<?php endif; ?>
</td>
<td colspan=2 class='userblock' style="<?php echo $this->_tpl_vars['group_style']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['group'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
</td></tr>
<tr><td colspan=2 class='userblock'><b><?php echo ((is_array($_tmp=@$this->_tpl_vars['username'])) ? $this->_run_mod_handler('default', true, $_tmp, 'username') : smarty_modifier_default($_tmp, 'username')); ?>
</b></td></tr>
<tr><td class='userblock'><img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/arrowup.gif" />&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['uploaded'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
</td><td class='userblock'><img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/arrowdown.gif" />&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['downloaded'])) ? $this->_run_mod_handler('mksize', true, $_tmp) : smarty_modifier_mksize($_tmp)); ?>
</td></tr>
<?php if ($this->_tpl_vars['downloaded'] != '0'): ?> <?php $this->assign('ratio', $this->_tpl_vars['uploaded']/$this->_tpl_vars['downloaded']); ?> <?php else: ?> <?php $this->assign('ratio', "беск."); ?> <?php endif; ?>
<td colspan=2 class='userblock'>Рейтинг:&nbsp;<?php if ($this->_tpl_vars['ratio'] > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['ratio'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
<?php else: ?>беск.<?php endif; ?></td></tr>
<td colspan=2 class='userblock'>Нет новых сообщений</td></tr>
</table>
</div>

</div></div></div>

<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
</div>
<?php endif; ?>