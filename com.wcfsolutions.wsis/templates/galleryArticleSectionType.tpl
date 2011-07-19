{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<ul class="images">
	{foreach from=$images item=image}
		<li class="image">
			<img src="files/{$image.name}" alt="" />
		</li>
	{/foreach}
</ul>