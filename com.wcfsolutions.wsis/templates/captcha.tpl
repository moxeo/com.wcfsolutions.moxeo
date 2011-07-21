{if !$this->user->userID}
	<div class="formElement{if $errorField == 'captchaValue'} formError{/if}">
		<div class="formFieldLabel">
			<label for="captchaValue">{lang}wsis.captcha.captchaValue{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" name="captchaValue" id="captchaValue" value="" />
			{if $errorField == 'captchaValue'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'false'}{lang}wsis.captcha.error.captchaValue.false{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc">
			<p>{@$captcha->getEncodedQuestion()}</p>
			<p>{lang}wsis.captcha.captchaValue.description{/lang}</p>
		</div>
		
		<input type="hidden" id="captchaID" name="captchaID" value="{@$captchaID}" />
	</div>
{/if}