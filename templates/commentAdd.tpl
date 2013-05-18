<form method="post" action="{$formURL}">
	{if !$this->user->userID}
		<dl class="formElement{if $errorField == 'username'} formError{/if}">
			<dt>
				<label for="username">{lang}wcf.user.username{/lang}</label>
			</dt>
			<dd>
				<input type="text" class="medium" name="username" id="username" value="{$username}" />
				{if $errorField == 'username'}
					<small class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'notValid'}{lang}wcf.user.error.username.notValid{/lang}{/if}
						{if $errorType == 'notAvailable'}{lang}wcf.user.error.username.notUnique{/lang}{/if}
					</small>
				{/if}
			</dd>
		</dl>
	{/if}

	<dl class="formElement{if $errorField == 'comment'} formError{/if}">
		<dt>
			<label for="comment">{lang}moxeo.comment.comment{/lang}</label>
		</dt>
		<dd>
			<textarea class="medium" name="comment" id="comment" rows="10" cols="40">{$comment}</textarea>
			{if $errorField == 'comment'}
				<small class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'tooLong'}{lang}moxeo.publication.object.comment.error.tooLong{/lang}{/if}
				</small>
			{/if}
		</dd>
	</dl>

	{include file='captcha'}

	{if $additionalCommentFields.$identifier|isset}{@$additionalCommentFields.$identifier}{/if}

	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		{@$formElementInputTag}
		{@SID_INPUT_TAG}
	</div>
</form>