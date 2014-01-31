{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
{assign var=themeModuleType value=$themeModule->getThemeModuleType()}
<{@$themeModuleType->getHTMLTag()} class="module {@$themeModule->themeModuleType}Module{if $themeModule->cssClasses} {$themeModule->cssClasses}{/if}">
	{capture assign='content'}{@$themeModuleType->getContent($themeModule, $articleSection->themeModulePosition, $additionalData)}{/capture}
	{@$content}
</{@$themeModuleType->getHTMLTag()}>