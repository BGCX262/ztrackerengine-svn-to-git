<?php /* Smarty version 2.6.19, created on 2008-07-07 10:35:44
         compiled from /var/www/localhost/htdocs/app/views/layouts/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/var/www/localhost/htdocs/app/views/layouts/default.tpl', 5, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo ((is_array($_tmp=@$this->_tpl_vars['pageTitle'])) ? $this->_run_mod_handler('default', true, $_tmp, "без названия") : smarty_modifier_default($_tmp, "без названия")); ?>
 - Бумер трекер</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<?php echo $this->_tpl_vars['html']->css("central_draft.css"); ?>

<?php echo $this->_tpl_vars['html']->css("default.css"); ?>

<?php echo $this->_tpl_vars['html']->css("panel.css"); ?>

<!--[if lte IE 7]>
<?php echo $this->_tpl_vars['html']->css("patches/patch_layout_draft.css"); ?>

<![endif]-->
</head>
<body>
<div id="page_margins">
	<div id="page">
		<div id="header">
         <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../views/users/user_block.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         <div style='position:absolute;left:300px;top:10px'><img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/g3106.gif" height="140px"/></div>
         <div style='position:absolute;left:450px;top:70px;width:480px;height:60px;'>Баннер</div>


        			<div id="topnav">
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../views/layouts/search.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

				<!-- start: skip link navigation -->
               
				<a class="skip" href="#navigation" title="skip link">Skip to the navigation</a><span class="hideme">.</span>
				<a class="skip" href="#content" title="skip link">Skip to the content</a><span class="hideme">.</span>
                				<!-- end: skip link navigation -->
				</div>
		</div>
		<!-- begin: main navigation #nav -->
		<div id="nav">
			<!-- skip anchor: navigation -->
			<a id="navigation" name="navigation"></a>
			<div id="nav_main"><?php echo $this->_tpl_vars['menu']->display(); ?>
</div>
		</div>
		<!-- begin: main content area #main -->
		<div id="main"> <a id="content" name="content"></a>
			<!-- skiplink anchor: Content -->
			<!-- begin: #col1 - first float column -->
			<div id="col1">
				<div id="col1_content" class="clearfix">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../views/layouts/sidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</div>
			</div>
			<!-- end: #col1 -->
			<!-- begin: #col2 second float column -->
			<div id="col2">
				<div id="col2_content" class="clearfix">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../views/layouts/rsidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</div>
			</div>
			<!-- end: #col2 -->
			<!-- begin: #col3 static column -->
			<div id="col3">
				<div id="col3_content" class="clearfix">
                <?php echo $this->_tpl_vars['content_for_layout']; ?>

				</div>
				<!-- IE Column Clearing -->
				<div id="ie_clearing">&nbsp;</div>
				<!-- End: IE Column Clearing -->
			</div>
			<!-- end: #col3 -->
		</div>
		<!-- end: #main -->

		<!-- begin: #footer -->
		<div id="footer">Powered by ZTracker (c) 2008 by ZTSoft Research Lab.</a></div>
		<!-- end: #footer -->
	</div>
</div>
</body>
</html>