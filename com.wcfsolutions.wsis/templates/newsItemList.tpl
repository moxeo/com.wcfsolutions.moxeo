{pages print=true assign=pagesOutput link=$contentItem->getURL()|concat:'?pageNo=%d':SID_ARG_2ND_NOT_ENCODED}

<ul class="newsItems">
	{cycle name='newsItemCycle' values='even,odd' reset=true print=false advance=false}
	{foreach from=$newsItems item=newsItem}
		<li class="element newsItem {cycle name='newsItemCycle'}">
			<h3><a href="{$newsItem->getURL()}{@SID_ARG_1ST}">{$newsItem->title}</a></h3>
			<p class="author">{$newsItem->username} ({@$newsItem->time|time})</p>
			<p class="text">{if $themeModule->displayType == 'full'}{@$newsItem->text}{else}{@$newsItem->teaser}{/if}</p>
		</li>
	{/foreach}
</ul>

{@$pagesOutput}