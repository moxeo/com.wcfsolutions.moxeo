{pages print=true assign=pagesOutput link=$contentItem->getURL()|concat:'?pageNo=%d':SID_ARG_2ND_NOT_ENCODED}

<ul class="comments">
	{cycle name='commentsCycle' values='even,odd' reset=true print=false advance=false}
	{foreach from=$comments item=commentObj}
		<li class="comment {cycle name='commentsCycle'}">
			<p class="author">{$commentObj->username} ({@$commentObj->time|time})</p>
			<p class="text">{@$commentObj->getFormattedComment()}</p>
		</li>
	{/foreach}
</ul>

{@$pagesOutput}

{@$commentForm}