{if $this->session->userAgent|stripos:'MSIE' === false}<?xml version="1.0" encoding="{@CHARSET}"?>
{/if}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{lang}wcf.global.pageDirection{/lang}" xml:lang="{@LANGUAGE_CODE}">
<head>
	<title>{$pageTitle} - {lang}{PAGE_TITLE}{/lang}</title>
	
	<base href="{PAGE_URL}/" />
	<meta http-equiv="content-type" content="text/html; charset={@CHARSET}" />
	<meta http-equiv="content-script-type" content="text/javascript" />
	<meta http-equiv="content-style-type" content="text/css" />
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	{if $metaDescription}<meta name="description" content="{$metaDescription}" />{/if}
	{if $metaKeywords}<meta name="keywords" content="{$metaKeywords}" />{/if}
	<meta name="robots" content="{@$contentItem->robots}" />
	
	<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/3rdParty/protoaculous.1.8.2.min.js"></script>
	<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/default.js"></script>
	<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/PopupMenuList.class.js"></script>
	
	<!-- theme styles -->
	<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}style/theme/global{if PAGE_DIRECTION == 'rtl'}-rtl{/if}.css" />
	{foreach from=$this->getThemeLayout()->getStyleSheets() item=styleSheet}
		<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}style/theme/{$this->getThemeLayout()->getTheme()->dataLocation}/{$styleSheet}{if PAGE_DIRECTION == 'rtl'}-rtl{/if}.css" />
	{/foreach}
	
	{if $specialStyles|isset}
		<!-- special styles -->
		{@$specialStyles}
	{/if}
	
	<!-- print styles -->
	<link rel="stylesheet" type="text/css" media="print" href="{@RELATIVE_WSIS_DIR}style/print{if PAGE_DIRECTION == 'rtl'}-rtl{/if}.css" />
	
	<script type="text/javascript">
		//<![CDATA[
		var SID_ARG_1ST	= '{@SID_ARG_1ST}';
		var SID_ARG_2ND	= '{@SID_ARG_2ND_NOT_ENCODED}';
		var SECURITY_TOKEN = '{@SECURITY_TOKEN}';
		var RELATIVE_WCF_DIR = '{@RELATIVE_WCF_DIR}';
		var RELATIVE_WSIS_DIR = '{@RELATIVE_WSIS_DIR}';
		var LANG_DELETE_CONFIRM = '{lang}wcf.global.button.delete.confirm{/lang}';
		//]]>
	</script>
	
	{if $executeCronjobs}
		<script type="text/javascript">
			//<![CDATA[
			new Ajax.Request('cronjobs.php'+SID_ARG_1ST, { method: 'get' });
			//]]>
		</script>
	{/if}
</head>
<body{if $contentItem->cssClasses} class="{$contentItem->cssClasses}"{/if}>

<div id="container">
	
	{assign var=headerThemeModules value=$this->getThemeLayout()->getModules('header')}
	{if $headerThemeModules|count}
		<div id="header">
			<div class="inner">
				{include file='themeModules' themeModulePosition='header' themeModules=$headerThemeModules additionalData=$additionalThemeModuleData}
			</div>
		</div>
	{/if}
	
	<div id="content">
		
		{assign var=leftThemeModules value=$this->getThemeLayout()->getModules('left')}
		{if $leftThemeModules|count}
			<div id="left">
				<div class="inner">
					{include file='themeModules' themeModulePosition='left' themeModules=$leftThemeModules additionalData=$additionalThemeModuleData}
				</div>
			</div>
		{/if}
		
		{assign var=mainThemeModules value=$this->getThemeLayout()->getModules('main')}
		{if $mainThemeModules|count}
			<div id="main">
				<div class="inner">
					{include file='themeModules' themeModulePosition='main' themeModules=$mainThemeModules additionalData=$additionalThemeModuleData}
				</div>
			</div>
		{/if}
		
		{assign var=rightThemeModules value=$this->getThemeLayout()->getModules('right')}
		{if $rightThemeModules|count}
			<div id="right">
				<div class="inner">
					{include file='themeModules' themeModulePosition='right' themeModules=$rightThemeModules additionalData=$additionalThemeModuleData}
				</div>
			</div>
		{/if}
		
	</div>
	
	{assign var=footerThemeModules value=$this->getThemeLayout()->getModules('footer')}
	{if $footerThemeModules|count}
		<div id="footer">
			<div class="inner">
				{include file='themeModules' themeModulePosition='footer' themeModules=$footerThemeModules additionalData=$additionalThemeModuleData}
			</div>
		</div>
	{/if}
	
</div>

</body>
</html>