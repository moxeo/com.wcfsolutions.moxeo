{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<p class="download">
	<a href="files/{$articleSection->file}">{if $articleSection->caption}{$articleSection->caption}{else}{$articleSection->file}{/if}</a> <span class="size">{@$file.size|filesize}</span>
</p>