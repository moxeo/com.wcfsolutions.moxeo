{if $this->user->userID != 0}
	{lang}wcf.user.login.user{/lang}
{else}
	<form method="post" action="{$contentItem->getURL()}">
		<div class="element required{if $errorField == 'username'} formError{/if}">
			<label for="loginUsername">{lang}wcf.user.username{/lang}</label>
			<input type="text" class="inputText" name="loginUsername" value="{$username}" id="loginUsername" />
			
			{if $errorField == 'username'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'notFound'}{lang}wcf.user.error.username.notFound{/lang}{/if}
					{if $errorType == 'notEnabled'}{lang}wcf.user.login.error.username.notEnabled{/lang}{/if}
				</p>
			{/if}
		</div>
		
		<div class="element required{if $errorField == 'password'} formError{/if}">
			<label for="loginPassword">{lang}wcf.user.password{/lang}</label>
			<input type="password" class="inputText" name="loginPassword" value="{$password}" id="loginPassword" />
			
			{if $errorField == 'password'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'false'}{lang}wcf.user.login.error.password.false{/lang}{/if}
				</p>
			{/if}
		</div>
		
		{if $supportsPersistentLogins}
			<div class="element">
				<label><input type="checkbox" name="useCookies" value="1" {if $useCookies == 1}checked="checked" {/if}/> {lang}wcf.user.login.useCookies{/lang}</label>
			</div>
		{/if}
		
		{if $additionalLoginFields|isset}{@$additionalLoginFields}{/if}
		
		<div class="submit">
			<input type="submit" value="{lang}wcf.global.button.submit{/lang}" />
			<input type="reset" value="{lang}wcf.global.button.reset{/lang}" />
			{@SID_INPUT_TAG}
		</div>
	</form>
{/if}