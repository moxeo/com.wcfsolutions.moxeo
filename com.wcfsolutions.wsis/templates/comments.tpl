{pages print=true assign=pagesOutput link=$contentItem->getURL()|concat:'?pageNo=%d#articleSection':$articleSection->articleSectionID:SID_ARG_2ND_NOT_ENCODED}

<ul class="comments">
	{cycle name='commentsCycle' values='even,odd' reset=true print=false advance=false}
	{foreach from=$comments item=commentObj}
		<li class="element comment {cycle name='commentsCycle'}">
			<a id="comment{@$commentObj->commentID}"></a>
			<p class="author">{$commentObj->username} ({@$commentObj->time|time})</p>
			<p class="text">{@$commentObj->getFormattedComment()}</p>
		</li>
	{/foreach}
</ul>

{@$pagesOutput}

<h2>{lang}wsis.comment.add{/lang}</h2>
<form method="post" action="{$contentItem->getURL()}?action=add">
	{if !$this->user->userID}
		<div class="element required{if $errorField == 'username'} formError{/if}">
			<label for="username">{lang}wcf.user.username{/lang}</label>
			<input type="text" class="inputText" name="username" id="username" value="{$username}" />
			
			{if $errorField == 'username'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'notValid'}{lang}wcf.user.error.username.notValid{/lang}{/if}
					{if $errorType == 'notAvailable'}{lang}wcf.user.error.username.notUnique{/lang}{/if}
				</p>
			{/if}
		</div>
	{/if}
	
	<div class="element required{if $errorField == 'comment'} formError{/if}">
		<label for="comment">{lang}wsis.comment.comment{/lang}</label>
		<textarea name="comment" id="comment" rows="10" cols="40">{$comment}</textarea>
		
		{if $errorField == 'comment'}
			<p class="innerError">
				{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				{if $errorType == 'tooLong'}{lang}wsis.publication.object.comment.error.tooLong{/lang}{/if}
			</p>
		{/if}
	</div>
	
	{include file='captcha'}
	
	<div class="submit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" />
		{@SID_INPUT_TAG}
		<input type="hidden" name="articleSectionID" value="{@$articleSection->articleSectionID}" />
	</div>
</form>