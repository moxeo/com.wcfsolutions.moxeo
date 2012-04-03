{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<ul class="images">
	{foreach from=$images item=image}
		<li class="image">
			<a href="files/{$image.path}" class="enlargable"><img src="files/{$image.path}" alt="" /></a>
		</li>
	{/foreach}
</ul>