<ul class="breadCrumbs">
	{foreach from=$contentItem->getParentContentItems() item=parentContentItem}
		<li><a href="{$parentContentItem->getURL()}{@SID_ARG_1ST}"><span>{$parentContentItem->title}</span></a> &raquo;</li>
	{/foreach}
	<li><span>{$contentItem->title}</span></li>
</ul>