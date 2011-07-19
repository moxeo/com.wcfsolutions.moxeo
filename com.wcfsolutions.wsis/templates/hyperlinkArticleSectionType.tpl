{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<a href="{$articleSection->url}" class="link">{if $articleSection->caption}{$articleSection->caption}{else}{$articleSection->url}{/if}</a>