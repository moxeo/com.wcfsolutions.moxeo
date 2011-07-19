{if $articleSection->headline}
	{include file='headlineArticleSectionType'}
{/if}
<{@$listTag} style="list-style-type: {@$articleSection->listStyleType}">
	{foreach from=$listItems item=listItem}
		<li>{@$listItem}</li>
	{/foreach}
</{@$listTag}>