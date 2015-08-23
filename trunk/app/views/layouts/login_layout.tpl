<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>{$title|default:"untitled"}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
{$html->css("2col_layout.css")}
{$html->css("panel.css")}
<!--[if lte IE 7]>
{$html->css("patches/patch_2col_left_13.css")}
<![endif]-->
</head>
<body>
<div id="page_margins">
	<div id="page">
		<div id="header" style="height:130px;">
         <div style='position:absolute;left:10px;top:10px'><img src="{$html->webroot}img/g3106.gif" height="140px"/></div>
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
                {include file="../views/layouts/sidebar.tpl"}
				</div>
			</div>
			<!-- end: #col1 -->
			<!-- begin: #col3 static column -->
			<div id="col3">
				<div id="col3_content" class="clearfix"> <a id="content" name="content"></a>
					<!-- skiplink anchor: Content -->
                    {$content_for_layout}
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
