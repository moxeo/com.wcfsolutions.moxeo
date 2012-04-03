{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<ul class="files">
	{foreach from=$files item=file}
		<li class="file">
			<a href="files/{$file.path}">{$file.path}</a> <span class="size">{@$file.info.size|filesize}</span>
		</li>
	{/foreach}
</ul>