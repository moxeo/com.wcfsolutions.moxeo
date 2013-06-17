<ul>
	{foreach from=$contentItems item=contentItem}
		{if $contentItem->contentItemID == $activeContentItemID || $contentItem->isParent($activeContentItemID)}{assign var='active' value=true}{else}{assign var='active' value=false}{/if}
		<li{if $active || $contentItem->cssClasses} class="{if $active}active{if $contentItem->cssClasses} {/if}{/if}{if $contentItem->cssClasses} {$contentItem->cssClasses}{/if}"{/if}>
			<a href="{$contentItem->getURL()}{if $contentItem->addSecurityToken}?t={@SECURITY_TOKEN}{@SID_ARG_2ND}{else}{@SID_ARG_1ST}{/if}" title="{$contentItem->title}"><span>{$contentItem->title}</span></a>
		</li>
	{/foreach}
</ul>