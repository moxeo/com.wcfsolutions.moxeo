{pages print=true assign=pagesOutput link=$contentItem->getURL()|concat:'?pageNo=%d#articleSection':$articleSection->articleSectionID:SID_ARG_2ND_NOT_ENCODED}

<ul class="comments">
	{cycle name='commentsCycle' values='even,odd' reset=true print=false advance=false}
	{foreach from=$comments item=commentObj}
		<li class="comment {cycle name='commentsCycle'}">
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
		<div class="formElement{if $errorField == 'username'} formError{/if}">
			<div class="formFieldLabel">
				<label for="username">{lang}wcf.user.username{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" name="username" id="username" value="{$username}" />
				{if $errorField == 'username'}
					<p class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'notValid'}{lang}wcf.user.error.username.notValid{/lang}{/if}
						{if $errorType == 'notAvailable'}{lang}wcf.user.error.username.notUnique{/lang}{/if}
					</p>
				{/if}
			</div>
		</div>
	{/if}
	
	<div class="formElement{if $errorField == 'comment'} formError{/if}">
		<div class="formFieldLabel">
			<label for="comment">{lang}wsis.comment.comment{/lang}</label>
		</div>
		<div class="formField">
			<textarea name="comment" id="comment" rows="10" cols="40">{$comment}</textarea>
			{if $errorField == 'comment'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'tooLong'}{lang}wsis.publication.object.comment.error.tooLong{/lang}{/if}
				</p>
			{/if}
		</div>
	</div>
	
	{include file='captcha'}
	
	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		{@$articleSectionInputTag}
		{@SID_INPUT_TAG}
	</div>
</form>