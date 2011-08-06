<form method="post" action="{$formURL}">
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
	
	{if $additionalCommentFields.$identifier|isset}{@$additionalCommentFields.$identifier}{/if}
	
	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		{@$formElementInputTag}
		{@SID_INPUT_TAG}
	</div>
</form>