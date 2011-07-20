{if !$this->user->userID}
	<div class="element required{if $errorField == 'captchaValue'} formError{/if}">
		<label for="captchaValue">{lang}wsis.captcha.captchaValue{/lang}</label>
		<input type="text" class="inputText" name="captchaValue" id="captchaValue" value="" />
		<input type="hidden" id="captchaID" name="captchaID" value="{@$captchaID}" />
		
		{if $errorField == 'captchaValue'}
			<p class="innerError">
				{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				{if $errorType == 'false'}{lang}wsis.captcha.error.captchaValue.false{/lang}{/if}
			</p>
		{/if}
		
		<div class="description">
			<p>{@$captcha->getEncodedQuestion()}</p>
			<p>{lang}wsis.captcha.captchaValue.description{/lang}</p>
		</div>
	</div>
{/if}