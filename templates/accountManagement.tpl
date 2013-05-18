<form method="post" action="{$additionalData.contentItem->getURL()}">
	{if $success|isset}
		<p class="success">{lang}wcf.user.accountManagement.success{/lang}</p>
	{/if}

	<dl class="formElement{if $errorField == 'password'} formError{/if}">
		<dt>
			<label for="password">{lang}wcf.user.accountManagement.password{/lang}</label>
		</dt>
		<dd>
			<input type="password" class="medium" name="password" value="{$password}" id="password" />

			{if $errorField == 'password'}
				<small class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'false'}{lang}wcf.user.login.error.password.false{/lang}{/if}
				</small>
			{/if}

			<small>
				<p>{lang}wcf.user.accountManagement.password.description{/lang}</p>
			</small>
		</dd>
	</dl>

	<fieldset>
		<legend><label for="newPassword">{lang}wcf.user.passwordChange.title{/lang}</label></legend>

		<dl class="formElement{if $errorField == 'newPassword'} formError{/if}">
			<dt>
				<label for="newPassword">{lang}wcf.user.passwordChange.newPassword{/lang}</label>
			</dt>
			<dd>
				<input type="password" class="medium" name="newPassword" value="{$newPassword}" id="newPassword" />

				{if $errorField == 'newPassword'}
					<small class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					</small>
				{/if}
			</dd>
		</dl>

		<dl class="formElement{if $errorField == 'confirmNewPassword'} formError{/if}">
			<dt>
				<label for="confirmNewPassword">{lang}wcf.user.passwordChange.confirmNewPassword{/lang}</label>
			</dt>
			<dd>
				<input type="password" class="medium" name="confirmNewPassword" value="{$confirmNewPassword}" id="confirmNewPassword" />

				{if $errorField == 'confirmNewPassword'}
					<small class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'notEqual'}{lang}wcf.user.error.confirmPassword.notEqual{/lang}{/if}
					</small>
				{/if}
			</dd>
		</dl>
	</fieldset>

	<fieldset>
		<legend><label for="email">{lang}wcf.user.emailChange.title{/lang}</label></legend>

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

	{if $additionalAccountManagementFields.$identifier|isset}{@$additionalAccountManagementFields.$identifier}{/if}

	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" />
		{@$formElementInputTag}
		{@SID_INPUT_TAG}
	</div>
</form>