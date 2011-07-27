{if $this->user->userID != 0}
	{lang}wcf.user.login.user{/lang}
{else}
	<form method="post" action="{$additionalData.contentItem->getURL()}">
		<div class="formElement{if $errorField == 'username'} formError{/if}">
			<div class="formFieldLabel">
				<label for="loginUsername">{lang}wcf.user.username{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" name="loginUsername" value="{$username}" id="loginUsername" />
				{if $errorField == 'username'}
					<p class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'notFound'}{lang}wcf.user.error.username.notFound{/lang}{/if}
						{if $errorType == 'notEnabled'}{lang}wcf.user.login.error.username.notEnabled{/lang}{/if}
					</p>
				{/if}
			</div>
		</div>
		
		<div class="formElement{if $errorField == 'password'} formError{/if}">
			<div class="formFieldLabel">
				<label for="loginPassword">{lang}wcf.user.password{/lang}</label>
			</div>
			<div class="formField">
				<input type="password" class="inputText" name="loginPassword" value="{$password}" id="loginPassword" />
				{if $errorField == 'password'}
					<p class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'false'}{lang}wcf.user.login.error.password.false{/lang}{/if}
					</p>
				{/if}
			</div>
		</div>
		
		{if $supportsPersistentLogins}
			<div class="formElement">
				<div class="formField">
					<label><input type="checkbox" name="useCookies" value="1" {if $useCookies == 1}checked="checked" {/if}/> {lang}wcf.user.login.useCookies{/lang}</label>
				</div>
			</div>
		{/if}
		
		{if $additionalLoginFields|isset}{@$additionalLoginFields}{/if}
			
		<div class="formSubmit">
			<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
			<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
			{@SID_INPUT_TAG}
		</div>
	</form>
{/if}