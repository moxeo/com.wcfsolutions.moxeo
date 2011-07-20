{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<ul class="files">
	{foreach from=$files item=file}
		<li class="element file">
			<a href="files/{$file.name}">{$file.name}</a> <span class="size">{@$file.size|filesize}</span>
		</li>
	{/foreach}
</ul>