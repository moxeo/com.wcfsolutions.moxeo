<form method="post" action="{$additionalData.contentItem->getURL()}">
	<dl class="formElement{if $errorField == 'username'} formError{/if}">
		<dt>
			<label for="username">{lang}wcf.user.username{/lang}</label>
		</dt>
		<dd>
			<input type="text" class="medium" name="username" value="{$username}" id="username" />

			{if $errorField == 'username'}
				<small class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'notValid'}{lang}wcf.user.error.username.notValid{/lang}{/if}
					{if $errorType == 'notUnique'}{lang}wcf.user.error.username.notUnique{/lang}{/if}
				</small>
			{/if}
		</dd>
	</dl>

	<fieldset>
		<legend><label for="email">{lang}wcf.user.email{/lang}</label></legend>

		<dl class="formElement{if $errorField == 'email'} formError{/if}">
			<dt>
				<label for="email">{lang}wcf.user.email{/lang}</label>
			</dt>
			<dd>
				<input type="text" class="medium" name="email" value="{$email}" id="email" />

				{if $errorField == 'email'}
					<small class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'notValid'}{lang}wcf.user.error.email.notValid{/lang}{/if}
						{if $errorType == 'notUnique'}{lang}wcf.user.error.email.notUnique{/lang}{/if}
					</small>
				{/if}

				<small>
					<p>{lang}wcf.user.register.email.description{/lang}</p>
				</small>
			</dd>

		</dl>

		<dl class="formElement{if $errorField == 'confirmEmail'} formError{/if}">
			<dt>
				<label for="confirmEmail">{lang}wcf.user.confirmEmail{/lang}</label>
			</dt>
			<dd>
				<input type="text" class="medium" name="confirmEmail" value="{$confirmEmail}" id="confirmEmail" />

				{if $errorField == 'confirmEmail'}
					<small class="innerError">
						{if $errorType == 'notEqual'}{lang}wcf.user.error.confirmEmail.notEqual{/lang}{/if}
					</small>
				{/if}

				<small>
					<p>{lang}wcf.user.register.confirmEmail.description{/lang}</p>
				</small>
			</dd>
		</dl>
	</fieldset>

	<fieldset>
		<legend><label for="password">{lang}wcf.user.password{/lang}</label></legend>

		<dl class="formElement{if $errorField == 'password'} formError{/if}">
			<dt>
				<label for="password">{lang}wcf.user.password{/lang}</label>
			</dt>
			<dd>
				<input type="password" class="medium" name="password" value="{$password}" id="password" />

				{if $errorField == 'password'}
					<small class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'notSecure'}{lang}wcf.user.error.password.notSecure{/lang}{/if}
					</small>
				{/if}

				<small>
					<p>{lang}wcf.user.register.password.description{/lang}</p>
				</small>
			</dd>
		</dl>

		<dl class="formElement{if $errorField == 'confirmPassword'} formError{/if}">
			<dt>
				<label for="confirmPassword">{lang}wcf.user.confirmPassword{/lang}</label>
			</dt>
			<dd>
				<input type="password" class="medium" name="confirmPassword" value="{$confirmPassword}" id="confirmPassword" />

				{if $errorField == 'confirmPassword'}
					<small class="innerError">
						{if $errorType == 'notEqual'}{lang}wcf.user.error.confirmPassword.notEqual{/lang}{/if}
					</small>
				{/if}

				<small>
					<p>{lang}wcf.user.register.confirmPassword.description{/lang}</p>
				</small>
			</dd>
		</dl>
	</fieldset>

	{if $availableLanguages|count > 1}
		<dl class="formElement">
			<dt>
				<label for="languageID">{lang}wcf.user.language{/lang}</label>
			</dt>
			<dd>
				{htmlOptions options=$availableLanguages selected=$languageID name=languageID id=languageID disableEncoding=true}

				<small>
					<p>{lang}wcf.user.language.description{/lang}</p>
				</small>
			</dd>
		</dl>
	{/if}

	{include file='captcha'}

	{if $additionalRegistrationFields.$identifier|isset}{@$additionalRegistrationFields.$identifier}{/if}

	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" />
		{@$formElementInputTag}
		{@SID_INPUT_TAG}
	</div>
</form>