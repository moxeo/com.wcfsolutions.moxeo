{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<ul class="images">
	{foreach from=$images item=image}
		<li class="image">
			<a href="files/{$image.name}" class="enlargable"><img src="files/{$image.name}" alt="" /></a>
		</li>
	{/foreach}
</ul>