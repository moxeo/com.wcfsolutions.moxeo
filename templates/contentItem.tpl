{if $this->session->userAgent|stripos:'MSIE' === false}<?xml version="1.0" encoding="{@CHARSET}"?>
{/if}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="{lang}wcf.global.pageDirection{/lang}" xml:lang="{@LANGUAGE_CODE}">
<head>
	<title>{$pageTitle} - {lang}{PAGE_TITLE}{/lang}</title>
	
	<!--
		This website is powered by Infinite Site, an Open Source CMS licensed under GNU LGPL
		Copyright 2009-2011 Sebastian Oettl <http://www.wcfsolutions.com/>
		Extensions are copyright of their respective owners
	-->
	
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
	
	<!-- image viewer -->	
	<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/ImageViewer.class.js"></script>
	<script type="text/javascript">
		//<![CDATA[			
		document.observe('dom:loaded', function() {
			new ImageViewer($$('.enlargable'), {
				langCaption		: '{lang}wcf.imageViewer.caption{/lang}',
				langPrevious		: '{lang}wcf.imageViewer.previous{/lang}',
				langNext		: '{lang}wcf.imageViewer.next{/lang}',
				langPlay		: '{lang}wcf.imageViewer.play{/lang}',
				langPause		: '{lang}wcf.imageViewer.pause{/lang}',
				langEnlarge		: '{lang}wcf.imageViewer.external{/lang}',
				langClose		: '{lang}wcf.imageViewer.close{/lang}',
				imgBlankSrc		: '{@RELATIVE_WCF_DIR}images/imageViewer/blank.png',
				imgMenuSrc		: '{@RELATIVE_WCF_DIR}images/imageViewer/menu.png',
				imgPlaySrc		: '{@RELATIVE_WCF_DIR}icon/imageViewer/playM.png',
				imgPreviousSrc		: '{@RELATIVE_WCF_DIR}icon/imageViewer/previousM.png',
				imgNextSrc		: '{@RELATIVE_WCF_DIR}icon/imageViewer/nextM.png',
				imgEnlargeSrc		: '{@RELATIVE_WCF_DIR}icon/imageViewer/enlargeM.png',
				imgPauseSrc		: '{@RELATIVE_WCF_DIR}icon/imageViewer/pauseM.png',
				imgCloseSrc		: '{@RELATIVE_WCF_DIR}icon/imageViewer/closeM.png',
				imgPlayHoverSrc		: '{@RELATIVE_WCF_DIR}icon/imageViewer/playHoverM.png',
				imgPreviousHoverSrc	: '{@RELATIVE_WCF_DIR}icon/imageViewer/previousHoverM.png',
				imgNextHoverSrc		: '{@RELATIVE_WCF_DIR}icon/imageViewer/nextHoverM.png',
				imgEnlargeHoverSrc	: '{@RELATIVE_WCF_DIR}icon/imageViewer/enlargeHoverM.png',
				imgPauseHoverSrc	: '{@RELATIVE_WCF_DIR}icon/imageViewer/pauseHoverM.png',
				imgCloseHoverSrc	: '{@RELATIVE_WCF_DIR}icon/imageViewer/closeHoverM.png'	
			});
		});
	//]]>
	</script>		
	
	<!-- theme styles -->
	<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}theme/global.css" />
	{foreach from=$this->getThemeLayout()->getStyleSheets() item=styleSheet}
		<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}theme/{$this->getThemeLayout()->getTheme()->dataLocation}/{$styleSheet}.css" />
	{/foreach}
	
	<!-- additional styles -->
	<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}style/imageViewer.css" />
	
	{if $specialStyles|isset}
		<!-- special styles -->
		{@$specialStyles}
	{/if}
	
	<script type="text/javascript">
		//<![CDATA[
		var SID_ARG_1ST	= '{@SID_ARG_1ST}';
		var SID_ARG_2ND	= '{@SID_ARG_2ND_NOT_ENCODED}';
		var SECURITY_TOKEN = '{@SECURITY_TOKEN}';
		var RELATIVE_WCF_DIR = '{@RELATIVE_WCF_DIR}';
		var RELATIVE_WSIS_DIR = '{@RELATIVE_WSIS_DIR}';
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
	
	{assign var=headerThemeModules value=$this->getThemeLayout()->getModules('header', $additionalThemeModuleData)}
	{if $headerThemeModules|count}
		<div id="header">
			<div class="inner">
				{include file='themeModules' themeModulePosition='header' themeModules=$headerThemeModules additionalData=$additionalThemeModuleData}
			</div>
		</div>
	{/if}
	
	<div id="content">
		
		{assign var=leftThemeModules value=$this->getThemeLayout()->getModules('left', $additionalThemeModuleData)}
		{assign var=rightThemeModules value=$this->getThemeLayout()->getModules('right', $additionalThemeModuleData)}
		{assign var=mainThemeModules value=$this->getThemeLayout()->getModules('main', $additionalThemeModuleData)}
		
		<div id="layout-{if $leftThemeModules|count && $rightThemeModules|count}4{elseif $leftThemeModules|count}3{elseif $rightThemeModules|count}2{else}1{/if}">
			
			{if $leftThemeModules|count}
				<div id="left">
					<div class="inner">
						{include file='themeModules' themeModulePosition='left' themeModules=$leftThemeModules additionalData=$additionalThemeModuleData}
					</div>
				</div>
			{/if}
			
			{if $rightThemeModules|count}
				<div id="right">
					<div class="inner">
						{include file='themeModules' themeModulePosition='right' themeModules=$rightThemeModules additionalData=$additionalThemeModuleData}
					</div>
				</div>
			{/if}
			
			{if $mainThemeModules|count}
				<div id="main">
					<div class="inner">
						{include file='themeModules' themeModulePosition='main' themeModules=$mainThemeModules additionalData=$additionalThemeModuleData}
					</div>
				</div>
			{/if}
			
		</div>
		
	</div>
	
	{assign var=footerThemeModules value=$this->getThemeLayout()->getModules('footer', $additionalThemeModuleData)}
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