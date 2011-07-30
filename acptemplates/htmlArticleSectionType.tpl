<fieldset>
	<legend>{lang}wsis.acp.article.section.html.data{/lang}</legend>
	
	<div class="formElement{if $errorField == 'code'} formError{/if}" id="codeDiv">
		<div class="formFieldLabel">
			<label for="code">{lang}wsis.acp.article.section.html.code{/lang}</label>
		</div>
		<div class="formField">
			<textarea cols="40" rows="10" id="code" name="code">{$code}</textarea>
			{if $errorField == 'code'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'syntaxError'}{lang}wsis.acp.article.section.html.code.error.syntaxError{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="codeHelpMessage">
			<p>{lang}wsis.acp.article.section.html.code.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('code');
	//]]></script>
</fieldset>