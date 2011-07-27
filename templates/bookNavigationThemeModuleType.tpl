<ul>
	<li class="previous{if !$previousContentItem} empty{/if}">
		{if $previousContentItem}<a href="{$previousContentItem->getURL()}{if $previousContentItem->addSecurityToken}?t={@SECURITY_TOKEN}{@SID_ARG_2ND}{else}{@SID_ARG_1ST}{/if}" title="{$previousContentItem->title}"><span>&laquo; {$previousContentItem->title}</span></a>{else}&nbsp;{/if}
	</li>
	<li class="up{if !$previousContentItem} empty{/if}">
		{if $upContentItem}<a href="{$upContentItem->getURL()}{if $upContentItem->addSecurityToken}?t={@SECURITY_TOKEN}{@SID_ARG_2ND}{else}{@SID_ARG_1ST}{/if}" title="{$upContentItem->title}"><span>{lang}wsis.global.up{/lang}</span></a>{else}&nbsp;{/if}
	</li>
	<li class="next{if !$previousContentItem} empty{/if}">
		{if $nextContentItem}<a href="{$nextContentItem->getURL()}{if $nextContentItem->addSecurityToken}?t={@SECURITY_TOKEN}{@SID_ARG_2ND}{else}{@SID_ARG_1ST}{/if}" title="{$nextContentItem->title}"><span>&raquo; {$nextContentItem->title}</span></a>{else}&nbsp;{/if}
	</li>
</ul>