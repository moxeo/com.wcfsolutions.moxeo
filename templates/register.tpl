<form method="post" action="{$additionalData.contentItem->getURL()}">
	<div class="formElement{if $errorField == 'username'} formError{/if}">
		<div class="formFieldLabel">
			<label for="loginUsername">{lang}wcf.user.username{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" name="username" value="{$username}" id="username" />
			{if $errorField == 'username'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'notValid'}{lang}wcf.user.error.username.notValid{/lang}{/if}
					{if $errorType == 'notUnique'}{lang}wcf.user.error.username.notUnique{/lang}{/if}
				</p>
			{/if}
		</div>
	</div>
	
	<fieldset>
		<legend><label for="email">{lang}wcf.user.email{/lang}</label></legend>
		
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
			<div class="formFieldDesc">
				<p>{lang}wcf.user.register.email.description{/lang}</p>
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
			<div class="formFieldDesc">
				<p>{lang}wcf.user.register.confirmEmail.description{/lang}</p>
			</div>
		</div>
	</div>
	
	<fieldset>
		<legend><label for="password">{lang}wcf.user.password{/lang}</label></legend>
		
		<div class="formElement{if $errorField == 'password'} formError{/if}">
			<div class="formFieldLabel">
				<label for="password">{lang}wcf.user.password{/lang}</label>
			</div>
			<div class="formField">
				<input type="password" class="inputText" name="password" value="{$password}" id="password" />
				
				{if $errorField == 'password'}
					<p class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
						{if $errorType == 'notSecure'}{lang}wcf.user.error.password.notSecure{/lang}{/if}
					</p>
				{/if}
			</div>
			<div class="formFieldDesc">
				<p>{lang}wcf.user.register.password.description{/lang}</p>
			</div>
		</div>
			
		<div class="formElement{if $errorField == 'confirmPassword'} formError{/if}">
			<div class="formFieldLabel">
				<label for="confirmPassword">{lang}wcf.user.confirmPassword{/lang}</label>
			</div>
			<div class="formField">
				<input type="password" class="inputText" name="confirmPassword" value="{$confirmPassword}" id="confirmPassword" />
				{if $errorField == 'confirmPassword'}
					<p class="innerError">
						{if $errorType == 'notEqual'}{lang}wcf.user.error.confirmPassword.notEqual{/lang}{/if}
					</p>
				{/if}
			</div>
			<div class="formFieldDesc">
				<p>{lang}wcf.user.register.confirmPassword.description{/lang}</p>
			</div>
		</div>
	</div>
			
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
	
	{include file='captcha'}
	
	{if $additionalRegistrationFields|isset}{@$additionalRegistrationFields}{/if}
		
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" />
		{@SID_INPUT_TAG}
	</div>
</form>