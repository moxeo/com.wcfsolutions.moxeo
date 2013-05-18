{if $this->user->userID != 0}
	{lang}wcf.user.login.user{/lang}
{else}
	<form method="post" action="{$additionalData.contentItem->getURL()}">
		<dl class="formElement{if $errorField == 'username'} formError{/if}">
			<dt>
				<label for="loginUsername">{lang}wcf.user.username{/lang}</label>
			</dt>
			<dd>
				<input type="text" class="large" name="loginUsername" value="{$username}" id="loginUsername" />
				{if $errorField == 'username'}
					<small class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'notFound'}{lang}wcf.user.error.username.notFound{/lang}{/if}
						{if $errorType == 'notEnabled'}{lang}wcf.user.login.error.username.notEnabled{/lang}{/if}
					</small>
				{/if}
			</dd>
		</dl>

		<dl class="formElement{if $errorField == 'password'} formError{/if}">
			<dt>
				<label for="loginPassword">{lang}wcf.user.password{/lang}</label>
			</dt>
			<dd>
				<input type="password" class="large" name="loginPassword" value="{$password}" id="loginPassword" />
				{if $errorField == 'password'}
					<small class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'false'}{lang}wcf.user.login.error.password.false{/lang}{/if}
					</small>
				{/if}
			</dd>
		</dl>

		{if $supportsPersistentLogins}
			<dl class="formElement">
				<dd>
					<label><input type="checkbox" name="useCookies" value="1" {if $useCookies == 1}checked="checked" {/if}/> {lang}wcf.user.login.useCookies{/lang}</label>
				</dd>
			</dl>
		{/if}

		{if $additionalLoginFields.$identifier|isset}{@$additionalLoginFields.$identifier}{/if}

		<div class="formSubmit">
			<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
			{@$formElementInputTag}
			{@SID_INPUT_TAG}
		</div>
	</form>
{/if}