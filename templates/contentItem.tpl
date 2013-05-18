<!DOCTYPE html>
<html dir="{lang}wcf.global.pageDirection{/lang}" lang="{@LANGUAGE_CODE}">
<head>
	<title>{$pageTitle} - {lang}{PAGE_TITLE}{/lang}</title>

	<meta name="generator" content="Moxeo Open Source CMS" />

	<base href="{PAGE_URL}/" />
	<meta charset="utf-8" />
	{if $metaDescription}<meta name="description" content="{$metaDescription}" />{/if}
	{if $metaKeywords}<meta name="keywords" content="{$metaKeywords}" />{/if}
	<meta name="robots" content="{@$contentItem->robots}" />

	<!-- theme style -->
	<link rel="stylesheet" type="text/css" media="screen" href="{@RELATIVE_WCF_DIR}theme/theme{$this->getThemeLayout()->getTheme()->themeID}-{$this->getThemeLayout()->themeLayoutID}.css" />

	{if $specialStyles|isset}
		<!-- special styles -->
		{@$specialStyles}
	{/if}

	<noscript>
		<style type="text/css">
			.javascriptOnly {
				display: none !important;
			}
		</style>
	</noscript>

	<script type="text/javascript">
		//<![CDATA[
		var SID_ARG_1ST	= '{@SID_ARG_1ST}';
		var SID_ARG_2ND	= '{@SID_ARG_2ND_NOT_ENCODED}';
		var SECURITY_TOKEN = '{@SECURITY_TOKEN}';
		var RELATIVE_WCF_DIR = '{@RELATIVE_WCF_DIR}';
		var RELATIVE_MOXEO_DIR = '{@RELATIVE_MOXEO_DIR}';
		//]]>
	</script>
	<script type="text/javascript" src="{@RELATIVE_MOXEO_DIR}js/3rdParty/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="{@RELATIVE_MOXEO_DIR}js/3rdParty/jquery-ui-1.10.0.min.js"></script>

	{if $executeCronjobs}
		<script type="text/javascript">
			//<![CDATA[
			$(function() {
				jQuery.get('cronjobs.php'+SID_ARG_1ST);
			});
			//]]>
		</script>
	{/if}
</head>
<body{if $contentItem->cssClasses} class="{$contentItem->cssClasses}"{/if}>

<div id="container">

	{assign var=headerThemeModules value=$this->getThemeLayout()->getModules('header', $additionalThemeModuleData)}
	{if $headerThemeModules|count}
		<header id="header">
			<div class="inner">
				{include file='themeModules' themeModulePosition='header' themeModules=$headerThemeModules additionalData=$additionalThemeModuleData}
			</div>
		</header>
	{/if}

	<div id="content">

		{assign var=leftThemeModules value=$this->getThemeLayout()->getModules('left', $additionalThemeModuleData)}
		{assign var=rightThemeModules value=$this->getThemeLayout()->getModules('right', $additionalThemeModuleData)}
		{assign var=mainThemeModules value=$this->getThemeLayout()->getModules('main', $additionalThemeModuleData)}

		<div id="layout-{if $leftThemeModules|count && $rightThemeModules|count}4{elseif $leftThemeModules|count}3{elseif $rightThemeModules|count}2{else}1{/if}">

			{if $leftThemeModules|count}
				<aside id="left">
					<div class="inner">
						{include file='themeModules' themeModulePosition='left' themeModules=$leftThemeModules additionalData=$additionalThemeModuleData}
					</div>
				</aside>
			{/if}

			{if $mainThemeModules|count}
				<div id="main">
					<div class="inner">
						{include file='themeModules' themeModulePosition='main' themeModules=$mainThemeModules additionalData=$additionalThemeModuleData}
					</div>
				</div>
			{/if}

			{if $rightThemeModules|count}
				<aside id="right">
					<div class="inner">
						{include file='themeModules' themeModulePosition='right' themeModules=$rightThemeModules additionalData=$additionalThemeModuleData}
					</div>
				</aside>
			{/if}

		</div>

	</div>

	{assign var=footerThemeModules value=$this->getThemeLayout()->getModules('footer', $additionalThemeModuleData)}
	{if $footerThemeModules|count}
		<footer id="footer">
			<div class="inner">
				{include file='themeModules' themeModulePosition='footer' themeModules=$footerThemeModules additionalData=$additionalThemeModuleData}
			</div>
		</footer>
	{/if}

</div>

</body>
</html>