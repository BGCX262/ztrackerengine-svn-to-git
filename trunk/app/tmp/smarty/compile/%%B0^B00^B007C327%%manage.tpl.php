<?php /* Smarty version 2.6.19, created on 2008-06-27 20:47:54
         compiled from /var/www/localhost/htdocs/ztracker/app/views/users/manage.tpl */ ?>
<?php $_from = $this->_tpl_vars['Aros']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aro']):
?>
<table>
<tr><td><?php echo $this->_tpl_vars['aro']['Aro']['alias']; ?>
</td></tr>
</table>
<?php endforeach; endif; unset($_from); ?>