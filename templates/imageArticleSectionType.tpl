{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<p class="image">
	{if $articleSection->enableFullsize}
		<a href="{if $articleSection->url}{$articleSection->url}{else}files/{$articleSection->image}{/if}" rel="lightbox-{@$articleSection->articleSectionID}" title="{$articleSection->title}"><img src="files/{$articleSection->image}" alt="{$articleSection->alternativeTitle}" /></a>
	{else}
		<img src="files/{$articleSection->image}" alt="{$articleSection->alternativeTitle}" />
	{/if}
	{if $articleSection->caption}<span class="caption">{$articleSection->caption}</span>{/if}
</p>