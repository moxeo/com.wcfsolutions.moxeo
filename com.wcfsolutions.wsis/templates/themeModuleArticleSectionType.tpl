{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<div class="{@$themeModule->themeModuleType}ThemeModule{if $themeModule->cssClasses} {$themeModule->cssClasses}{/if}">
	{@$themeModule->getThemeModuleType()->getContent($themeModule, $articleSection->themeModulePosition, $additionalData)}
</div>