<fieldset>
	<legend>{lang}moxeo.acp.article.section.headline{/lang}</legend>
	
	<div class="formElement{if $errorField == 'headline'} formError{/if}" id="headlineDiv">
		<div class="formFieldLabel">
			<label for="headline">{lang}moxeo.acp.article.section.headline{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="headline" name="headline" value="{$headline}" />
			{if $errorField == 'headline'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="headlineHelpMessage">
			<p>{lang}moxeo.acp.article.section.headline.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('headline');
	//]]></script>
	
	<div class="formElement{if $errorField == 'headlineSize'} formError{/if}" id="headlineSizeDiv">
		<div class="formFieldLabel">
			<label for="headlineSize">{lang}moxeo.acp.article.section.headlineSize{/lang}</label>
		</div>
		<div class="formField">
			<select name="headlineSize" id="headlineSize">
				{section loop=7 start=1 name='size'}
					<option value="{@$size}"{if $headlineSize == $size} selected="selected"{/if}>h{@$size}</option>
				{/section}
			</select>
			{if $errorField == 'headlineSize'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="headlineSizeHelpMessage">
			<p>{lang}moxeo.acp.article.section.headlineSize.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('headlineSize');
	//]]></script>
</fieldset>