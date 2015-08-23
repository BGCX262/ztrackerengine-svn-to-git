<?php /* Smarty version 2.6.19, created on 2008-07-03 10:26:49
         compiled from ../views/users/editor.tpl */ ?>
<?php echo $this->_tpl_vars['html']->css("combo.css"); ?>

<div class='x-panel-header'>Редактирование пользователя</div>
<div class='x-panel-body'>
<div id='user_editor'></div>
<script>
var uid="<?php echo $this->_tpl_vars['user']['User']['id']; ?>
";
var username="<?php echo $this->_tpl_vars['user']['User']['username']; ?>
";
var title="<?php echo $this->_tpl_vars['user']['User']['title']; ?>
";
var group_id="<?php echo $this->_tpl_vars['user']['User']['group_id']; ?>
";
</script>
<?php echo $this->_tpl_vars['javascript']->link("user-edit.js"); ?>

</div>