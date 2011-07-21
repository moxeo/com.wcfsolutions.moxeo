{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<{@$listTag} class="list" style="list-style-type: {@$articleSection->listStyleType}">
	{foreach from=$listItems item=listItem}
		<li class="listItem">{@$listItem}</li>
	{/foreach}
</{@$listTag}>