{assign var='contentItemCounter' value=0}
{assign var='contentItemCount' value=$contentItems|count}
<ul>
	{foreach from=$contentItems item=child}
		{assign var='contentItem' value=$child.contentItem}
		
		{if $contentItem->contentItemID == $activeContentItemID || $contentItem->isParent($activeContentItemID)}{assign var='active' value=true}{else}{assign var='active' value=false}{/if}
		<li{if $active || $contentItem->cssClasses} class="active{if $contentItem->cssClasses} {$contentItem->cssClasses}{/if}"{/if}>
			<a href="{$contentItem->getURL()}{if $contentItem->addSecurityToken}?t={@SECURITY_TOKEN}{@SID_ARG_2ND}{else}{@SID_ARG_1ST}{/if}" title="{$contentItem->title}"><span>{$contentItem->title}</span></a>
		
		{if $child.hasChildren}<ul>{else}</li>{/if}
		{if $child.openParents > 0}{@"</ul></li>"|str_repeat:$child.openParents}{/if}
	{/foreach}
</ul>