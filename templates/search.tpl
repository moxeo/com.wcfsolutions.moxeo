<form method="get" action="{$additionalData.contentItem->getURL()}">
	<div class="formElement">
		<div class="formFieldLabel">
			<label for="q">{lang}moxeo.search.query{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" name="q" id="q" value="{$query}" />
		</div>
	</div>
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" />
	</div>
</form>

{if $query}
	<h2>{lang}moxeo.search.results{/lang}</h2>
	
	{pages print=true assign=pagesOutput link=$contentItem->getURL()|concat:'?pageNo=%d&q=':$query:SID_ARG_2ND_NOT_ENCODED}
	
	{if $result|count}
		<ul class="searchResults">
			{cycle name='searchResultCycle' values='even,odd' reset=true print=false advance=false}
			{foreach from=$result item=result}
				<li class="searchResult {cycle name='searchResultCycle'}">
					<h4 class="headline"><a href="{$result->getURL()}{@SID_ARG_1ST}">{$result->title}</a></h4>
					<p>{@$result->getFormattedDescription()}</p>
					<p class="info">{$result->getURL()}</p>
				</li>
			{/foreach}
		</ul>
	{else}
		{lang}moxeo.search.error.noMatches{/lang}
	{/if}
	
	{@$pagesOutput}
{/if}