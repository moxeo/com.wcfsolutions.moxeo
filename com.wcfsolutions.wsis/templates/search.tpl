<form method="get">
	<div class="formElement">
		<div class="formFieldLabel">
			<label for="q">{lang}wsis.search.query{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" name="q" id="q" value="{$query}" />
		</div>
	</div>
	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
	</div>
</form>

{if $query}
	<h3 class="headline">{lang}wsis.search.results{/lang}</h3>
	
	<div class="contentHeader">
		{pages print=true assign=pagesOutput link=$contentItem->getURL()|concat:'?pageNo=%d':SID_ARG_2ND_NOT_ENCODED}
	</div>
	{if $result|count}
		<ul class="searchResults">
			{cycle name='searchResultCycle' values='even,odd' reset=true print=false advance=false}
			{foreach from=$result item=result}
				<li class="{cycle name='searchResultCycle'}">
					<h4 class="headline"><a href="{$result->getURL()}{@SID_ARG_1ST}">{$result->title}</a></h4>
					<p>{@$result->getFormattedDescription()}</p>
					<p class="info">{$result->getURL()}</p>
				</li>
			{/foreach}
		</ul>
	{else}
		{lang}wsis.search.error.noMatches{/lang}
	{/if}
	<div class="contentFooter">
		{@$pagesOutput}
	</div>
{/if}