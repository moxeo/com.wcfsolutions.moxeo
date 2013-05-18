{if !$this->user->userID}
	<dl class="formElement{if $errorField == 'captchaValue'} formError{/if}">
		<dt>
			<label for="captchaValue">{lang}moxeo.captcha.captchaValue{/lang}</label>
		</dt>
		<dd>
			<input type="text" class="medium" name="captchaValue" id="captchaValue" value="" />
			{if $errorField == 'captchaValue'}
				<small class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'false'}{lang}moxeo.captcha.error.captchaValue.false{/lang}{/if}
				</small>
			{/if}
			<small>
				<p>{@$captcha->getEncodedQuestion()}</p>
				<p>{lang}moxeo.captcha.captchaValue.description{/lang}</p>
			</small>
		</dd>

		<input type="hidden" id="captchaID" name="captchaID" value="{@$captchaID}" />
	</dl>
{/if}