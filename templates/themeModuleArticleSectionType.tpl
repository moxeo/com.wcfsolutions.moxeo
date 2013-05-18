{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<div class="module {@$themeModule->themeModuleType}Module{if $themeModule->cssClasses} {$themeModule->cssClasses}{/if}">
	{@$themeModule->getThemeModuleType()->getContent($themeModule, $articleSection->themeModulePosition, $additionalData)}
</div>