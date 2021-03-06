{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
{if $articleSection->enableThumbnail}
	<p class="thumbnail">
		{if $articleSection->thumbnailEnableFullsize}
			<a href="{if $articleSection->thumbnailURL}{$articleSection->thumbnailURL}{else}files/{$articleSection->thumbnail}{/if}" rel="lightbox-{@$articleSection->articleSectionID}" title="{$articleSection->thumbnailTitle}"><img src="files/{$articleSection->thumbnail}" alt="{$articleSection->thumbnailAlternativeTitle}" /></a>
		{else}
			<img src="files/{$articleSection->thumbnail}" alt="{$articleSection->thumbnailAlternativeTitle}" />
		{/if}
		{if $articleSection->thumbnailCaption}<span class="caption">{$articleSection->thumbnailCaption}</span>{/if}
	</p>
{/if}
<div class="text">
	{@$articleSection->code}
</div>