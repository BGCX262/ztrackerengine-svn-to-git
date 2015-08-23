<?php /* Smarty version 2.6.19, created on 2008-07-02 09:51:46
         compiled from /var/www/localhost/htdocs/ztracker/app/views/users/register.tpl */ ?>
<?php echo $this->_tpl_vars['html']->css("panel.css"); ?>

<?php echo $this->_tpl_vars['html']->css("button.css"); ?>

<?php echo $this->_tpl_vars['html']->css("form.css"); ?>

<?php echo $this->_tpl_vars['html']->css("date-picker.css"); ?>

<?php echo $this->_tpl_vars['html']->css("combo.css"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-base.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("ext-all.js"); ?>


<?php echo '
<style>
.x-form-element .strengthMeter {
.border: 1px solid #B5B8C8;
 margin: 3px 0 3px 0;
 background-image: url('; ?>
<?php echo $this->_tpl_vars['html']->webroot; ?>
<?php echo 'img/meter_background.gif);
}
.x-form-element .strengthMeter-focus {
 border: 1px solid #000;
}
.x-form-element .scoreBar {
 background-image: url('; ?>
<?php echo $this->_tpl_vars['html']->webroot; ?>
<?php echo 'img/meter.gif);
 height: 10px;
 width: 0px;
 line-height: 1px;
 font-size: 1px;
}
</style>
'; ?>

<div id="register_form"></div>
<?php echo $this->_tpl_vars['javascript']->link("Ext.ux.Crypto.SHA1.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("Ext.ux.PasswordMeter.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("countries.js"); ?>

<?php echo $this->_tpl_vars['javascript']->link("users-register.js"); ?>
