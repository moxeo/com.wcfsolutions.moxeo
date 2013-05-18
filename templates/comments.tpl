{pages print=true assign=pagesOutput link=$contentItem->getURL()|concat:'?pageNo=%d':SID_ARG_2ND_NOT_ENCODED}

{if $comments|count}
	<h2>{lang}moxeo.comment.comments{/lang}</h2>

	<ul class="comments">
		{foreach from=$comments item=commentObj}
			<li class="comment">
				<p class="author">{$commentObj->username} ({@$commentObj->time|time})</p>
				<p class="text">{@$commentObj->getFormattedComment()}</p>
			</li>
		{/foreach}
	</ul>
{/if}

{@$pagesOutput}

<h3>{lang}moxeo.comment.add{/lang}</h3>
{@$commentForm}