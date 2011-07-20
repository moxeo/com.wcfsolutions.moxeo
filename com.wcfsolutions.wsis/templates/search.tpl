<form method="get" action="{$contentItem->getURL()}">
	<div class="element required">
		<label for="q">{lang}wsis.search.query{/lang}</label>
		<input type="text" class="inputText" name="q" id="q" value="{$query}" />
	</div>
	<div class="submit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" />
	</div>
</form>

{if $query}
	<h2>{lang}wsis.search.results{/lang}</h2>
	
	{pages print=true assign=pagesOutput link=$contentItem->getURL()|concat:'?pageNo=%d':SID_ARG_2ND_NOT_ENCODED}
	
	{if $result|count}
		<ul class="searchResults">
			{cycle name='searchResultCycle' values='even,odd' reset=true print=false advance=false}
			{foreach from=$result item=result}
				<li class="element searchResult {cycle name='searchResultCycle'}">
					<h4 class="headline"><a href="{$result->getURL()}{@SID_ARG_1ST}">{$result->title}</a></h4>
					<p>{@$result->getFormattedDescription()}</p>
					<p class="info">{$result->getURL()}</p>
				</li>
			{/foreach}
		</ul>
	{else}
		{lang}wsis.search.error.noMatches{/lang}
	{/if}
	
	{@$pagesOutput}
{/if}