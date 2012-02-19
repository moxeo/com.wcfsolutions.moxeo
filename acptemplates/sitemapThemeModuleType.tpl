<fieldset>
	<legend>{lang}moxeo.acp.theme.module.sitemap.data{/lang}</legend>
	
	<div class="formElement{if $errorField == 'contentItemID'} formError{/if}" id="contentItemIDDiv">
		<div class="formFieldLabel">
			<label for="contentItemID">{lang}moxeo.acp.theme.module.sitemap.contentItemID{/lang}</label>
		</div>
		<div class="formField">
			<select name="contentItemID" id="contentItemID">
				<option value="0"></option>
				{htmloptions options=$contentItemOptions selected=$contentItemID disableEncoding=true}
			</select>
			{if $errorField == 'contentItemID'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="contentItemIDHelpMessage">
			<p>{lang}moxeo.acp.theme.module.sitemap.contentItemID.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('contentItemID');
	//]]></script>
</fieldset>