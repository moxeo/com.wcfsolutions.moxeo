{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<ul class="images">
	{foreach from=$images item=image}
		<li class="element image">
			<img src="files/{$image.name}" alt="" />
		</li>
	{/foreach}
</ul>