{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<p class="download">
	<a href="files/{$file.name}">{if $articleSection->caption}{$articleSection->caption}{else}{$file.name}{/if}</a> <span class="size">{@$file.size|filesize}</span>
</p>