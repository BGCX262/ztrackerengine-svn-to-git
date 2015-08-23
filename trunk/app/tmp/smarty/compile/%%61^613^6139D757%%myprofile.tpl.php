<?php /* Smarty version 2.6.19, created on 2008-07-09 11:10:39
         compiled from /var/www/localhost/htdocs/app/views/users/myprofile.tpl */ ?>
<?php echo $this->_tpl_vars['html']->css("reset-min.css"); ?>

<?php echo $this->_tpl_vars['html']->css("box.css"); ?>

<?php echo $this->_tpl_vars['html']->css("tabs.css"); ?>

<?php echo $this->_tpl_vars['html']->css("button.css"); ?>

<?php echo $this->_tpl_vars['html']->css("form.css"); ?>

<?php echo $this->_tpl_vars['html']->css("layout.css"); ?>

<?php echo $this->_tpl_vars['html']->css("panel.css"); ?>

<?php echo $this->_tpl_vars['html']->css("date-picker.css"); ?>

<?php echo $this->_tpl_vars['html']->css("toolbar.css"); ?>

<?php echo $this->_tpl_vars['html']->css("editor.css"); ?>

<?php echo $this->_tpl_vars['html']->css("combo.css"); ?>

<?php echo $this->_tpl_vars['html']->css("core.css"); ?>

<?php echo $this->_tpl_vars['html']->css("tabs.css"); ?>

<?php echo $this->_tpl_vars['html']->css("qtips.css"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-base.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-all.js"); ?>


<h3>Редактор профиля</h3>
<div>

<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>

<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc">
<div id="profileeditor" name="profileeditor"></div>
</div></div></div>

<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>
</div>
<?php echo $this->_tpl_vars['javascript']->link("miframe-min.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("tiny_mce/tiny_mce.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("Ext.ux.TinyMCE.js"); ?>

<script>
var country_value="<?php echo $this->_tpl_vars['User']['Country']['name']; ?>
";var countryid_value="<?php echo $this->_tpl_vars['User']['Country']['id']; ?>
";var email_value="<?php echo $this->_tpl_vars['User']['User']['email']; ?>
";
var birth_value="<?php echo $this->_tpl_vars['User']['User']['birthday']; ?>
";var avatar_value="<?php echo $this->_tpl_vars['User']['User']['avatar']; ?>
";var gender_value="<?php echo $this->_tpl_vars['User']['User']['gender']; ?>
";
var icq_value="<?php echo $this->_tpl_vars['User']['User']['icq']; ?>
";var skype_value="<?php echo $this->_tpl_vars['User']['User']['skype']; ?>
";var yahoo_value="<?php echo $this->_tpl_vars['User']['User']['yahoo']; ?>
";var jabber_value="<?php echo $this->_tpl_vars['User']['User']['jabber']; ?>
";
</script>
<?php echo $this->_tpl_vars['javascript']->link("profile-editor.js"); ?>
