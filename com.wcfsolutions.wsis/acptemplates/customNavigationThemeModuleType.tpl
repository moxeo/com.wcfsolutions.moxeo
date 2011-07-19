<fieldset>
	<legend>{lang}wsis.acp.theme.module.customNavigation.data{/lang}</legend>
	
	<div class="formElement{if $errorField == 'contentItemIDs'} formError{/if}" id="contentItemIDsDiv">
		<div class="formFieldLabel">
			<label for="contentItemIDs">{lang}wsis.acp.theme.module.customNavigation.contentItemIDs{/lang}</label>
		</div>
		<div class="formField">
			<select name="contentItemIDs[]" id="contentItemIDs" multiple="multiple" size="5">
				{htmloptions options=$contentItemOptions selected=$contentItemIDs disableEncoding=true}
			</select>
			{if $errorField == 'contentItemIDs'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="contentItemIDsHelpMessage">
			<p>{lang}wsis.acp.theme.module.customNavigation.contentItemIDs.description{/lang}</p>
			<p>{lang}wcf.global.multiSelect{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('contentItemIDs');
	//]]></script>
</fieldset>