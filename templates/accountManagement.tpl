<form method="post" action="{$additionalData.contentItem->getURL()}">
	{if $success|isset}
		<p class="success">{lang}wcf.user.accountManagement.success{/lang}</p>	
	{/if}
	
	<div class="formElement{if $errorField == 'password'} formError{/if}">
		<div class="formFieldLabel">
			<label for="password">{lang}wcf.user.accountManagement.password{/lang}</label>
		</div>
		<div class="formField">
			<input type="password" class="inputText" name="password" value="{$password}" id="password" />
			{if $errorField == 'password'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'false'}{lang}wcf.user.login.error.password.false{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc">
			<p>{lang}wcf.user.accountManagement.password.description{/lang}</p>
		</div>
	</div>
	
	<fieldset>
		<legend><label for="newPassword">{lang}wcf.user.passwordChange.title{/lang}</label></legend>
		
		<div class="formElement{if $errorField == 'newPassword'} formError{/if}">
			<div class="formFieldLabel">
				<label for="newPassword">{lang}wcf.user.passwordChange.newPassword{/lang}</label>
			</div>
			<div class="formField">
				<input type="password" class="inputText" name="newPassword" value="{$newPassword}" id="newPassword" />
				
				{if $errorField == 'newPassword'}
					<p class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					</p>
				{/if}
			</div>
		</div>
		
		<div class="formElement{if $errorField == 'confirmNewPassword'} formError{/if}">
			<div class="formFieldLabel">
				<label for="confirmNewPassword">{lang}wcf.user.passwordChange.confirmNewPassword{/lang}</label>
			</div>
			<div class="formField">
				<input type="password" class="inputText" name="confirmNewPassword" value="{$confirmNewPassword}" id="confirmNewPassword" />
				
				{if $errorField == 'confirmNewPassword'}
					<p class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'notEqual'}{lang}wcf.user.error.confirmPassword.notEqual{/lang}{/if}
					</p>
				{/if}
			</div>
		</div>
	</fieldset>
	
	<fieldset>
		<legend><label for="email">{lang}wcf.user.emailChange.title{/lang}</label></legend>
		
		<div class="formElement{if $errorField == 'email'} formError{/if}">
			<div class="formFieldLabel">
				<label for="email">{lang}wcf.user.email{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" name="email" value="{$email}" id="email" />
				
				{if $errorField == 'email'}
					<p class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'notValid'}{lang}wcf.user.error.email.notValid{/lang}{/if}
						{if $errorType == 'notUnique'}{lang}wcf.user.error.email.notUnique{/lang}{/if}
					</p>
				{/if}
			</div>
		</div>
		
		<div class="formElement{if $errorField == 'confirmEmail'} formError{/if}">
			<div class="formFieldLabel">
				<label for="confirmEmail">{lang}wcf.user.confirmEmail{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" name="confirmEmail" value="{$confirmEmail}" id="confirmEmail" />
				
				{if $errorField == 'confirmEmail'}
					<p class="innerError">
						{if $errorType == 'notEqual'}{lang}wcf.user.error.confirmEmail.notEqual{/lang}{/if}
					</p>
				{/if}
			</div>
		</div>
	</fieldset>
	
	{if $availableLanguages|count > 1}
		<div class="formElement">
			<div class="formFieldLabel">
				<label for="languageID">{lang}wcf.user.language{/lang}</label>
			</div>
			<div class="formField">
				{htmlOptions options=$availableLanguages selected=$languageID name=languageID id=languageID disableEncoding=true}
			</div>
			<div class="formFieldDesc">
				<p>{lang}wcf.user.language.description{/lang}</p>
			</div>
		</div>
	{/if}
	
	{if $additionalAccountManagementFields|isset}{@$additionalAccountManagementFields}{/if}
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" />
		{@$formElementInputTag}
		{@SID_INPUT_TAG}
	</div>
</form>