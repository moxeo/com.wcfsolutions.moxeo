<form method="get" action="{$additionalData.contentItem->getURL()}">
	<dl class="formElement">
		<dt>
			<label for="q">{lang}moxeo.search.query{/lang}</label>
		</dt>
		<dd>
			<input type="text" class="medium" name="q" id="q" value="{$query}" />
		</dd>
	</dl>
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" />
	</div>
</form>

{if $query}
	<h2>{lang}moxeo.search.results{/lang}</h2>

	{pages print=true assign=pagesOutput link=$contentItem->getURL()|concat:'?pageNo=%d&q=':$query:SID_ARG_2ND_NOT_ENCODED}

	{if $result|count}
		<ul class="searchResults">
			{foreach from=$result item=result}
				<li class="searchResult">
					<h3><a href="{$result->getURL()}{@SID_ARG_1ST}">{$result->title}</a></h3>
					<div class="author">{PAGE_URL}/{$result->getURL()}</div>
					<div class="text">{@$result->getFormattedDescription()}</div>
				</li>
			{/foreach}
		</ul>
	{else}
		{lang}moxeo.search.error.noMatches{/lang}
	{/if}

	{@$pagesOutput}
{/if}