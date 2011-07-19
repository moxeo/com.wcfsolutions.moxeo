<div class="contentHeader">
	{pages print=true assign=pagesOutput link=$contentItem->getURL()|concat:'?pageNo=%d':SID_ARG_2ND_NOT_ENCODED}
</div>
<ul class="newsItems">
	{cycle name='newsItemCycle' values='even,odd' reset=true print=false advance=false}
	{foreach from=$newsItems item=newsItem}
		<li class="{cycle name='newsItemCycle'}">
			<h2 class="headline"><a href="{$newsItem->getURL()}{@SID_ARG_1ST}">{$newsItem->title}</a></h2>
			<p class="author">{$newsItem->username} ({@$newsItem->time|time})</p>
			<p class="newsItem">{if $themeModule->displayType == 'full'}{@$newsItem->text}{else}{@$newsItem->teaser}{/if}</p>
		</li>
	{/foreach}
</ul>
<div class="contentFooter">
	{@$pagesOutput}
</div>