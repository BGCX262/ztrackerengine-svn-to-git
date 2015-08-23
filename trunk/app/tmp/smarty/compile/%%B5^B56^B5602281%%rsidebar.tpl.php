<?php /* Smarty version 2.6.19, created on 2008-07-04 11:45:10
         compiled from ../views/layouts/rsidebar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '../views/layouts/rsidebar.tpl', 5, false),)), $this); ?>
<div class='x-panel'>
<div class='x-panel-header'>Статистика</div>
<div class='x-panel-body' style="padding:5px;">
<table cellspacing=0 cellpadding=0 class="full">
<tr><td>Раздач:</td><td><?php echo ((is_array($_tmp=@$this->_tpl_vars['Stats']['tcount'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
</td></tr>
<tr><td>Раздают:</td><td> <?php echo ((is_array($_tmp=@$this->_tpl_vars['Stats']['scount'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
</td></tr>
<tr><td>Качают:</td><td> <?php echo ((is_array($_tmp=@$this->_tpl_vars['Stats']['lcount'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
</td></tr>
<tr><td>Пользователей:</td><td> <?php echo ((is_array($_tmp=@$this->_tpl_vars['Stats']['usrcount'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
</td></tr>
<tr><td>Парней:</td><td> <?php echo ((is_array($_tmp=@$this->_tpl_vars['Stats']['mlcount'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
</td></tr>
<tr><td>Девушек:</td><td> <?php echo ((is_array($_tmp=@$this->_tpl_vars['Stats']['fmcount'])) ? $this->_run_mod_handler('default', true, $_tmp, "") : smarty_modifier_default($_tmp, "")); ?>
</td></tr>
</table>
</div>
</div>