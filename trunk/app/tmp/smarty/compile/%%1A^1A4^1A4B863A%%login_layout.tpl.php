<?php /* Smarty version 2.6.19, created on 2008-07-02 13:39:44
         compiled from /var/www/localhost/htdocs/ztracker/app/views/layouts/login_layout.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/var/www/localhost/htdocs/ztracker/app/views/layouts/login_layout.tpl', 5, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo ((is_array($_tmp=@$this->_tpl_vars['title'])) ? $this->_run_mod_handler('default', true, $_tmp, 'untitled') : smarty_modifier_default($_tmp, 'untitled')); ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php echo $this->_tpl_vars['html']->css("2col_layout.css"); ?>

<?php echo $this->_tpl_vars['html']->css("panel.css"); ?>

<!--[if lte IE 7]>
<?php echo $this->_tpl_vars['html']->css("patches/patch_2col_left_13.css"); ?>

<![endif]-->
</head>
<body>
<div id="page_margins">
	<div id="page">
		<div id="header" style="height:130px;">
         <div style='position:absolute;left:10px;top:10px'><img src="<?php echo $this->_tpl_vars['html']->webroot; ?>
img/g3106.gif" height="140px"/></div>
         <div style='position:absolute;left:200px;top:70px;width:480px;height:60px;'>Баннер</div>
			<div id="topnav">
				<!-- start: skip link navigation -->
				<a class="skip" href="#navigation" title="skip link">Skip to the navigation</a><span class="hideme">.</span>
				<a class="skip" href="#content" title="skip link">Skip to the content</a><span class="hideme">.</span>
				<!-- end: skip link navigation -->
			</div>
        </div>
		<!-- begin: main content area #main -->
		<div id="main">
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
			<!-- begin: #col3 static column -->
			<div id="col3">
				<div id="col3_content" class="clearfix"> <a id="content" name="content"></a>
					<!-- skiplink anchor: Content -->
                    <?php echo $this->_tpl_vars['content_for_layout']; ?>

				</div>
				<div id="ie_clearing">&nbsp;</div>
				<!-- End: IE Column Clearing -->
			</div>
			<!-- end: #col3 -->
		</div>
		<!-- end: #main -->
		<!-- begin: #footer -->
		<div id="footer">Powered by ZTracker (c) 2008 by ZTSoft Research Lab.</div>
		<!-- end: #footer -->
	</div>
</div>
</body>
</html>