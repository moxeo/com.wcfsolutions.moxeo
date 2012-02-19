<fieldset>
	<legend>{lang}moxeo.acp.theme.module.newsItemList.data{/lang}</legend>
	
	<div class="formElement{if $errorField == 'newsArchiveIDs'} formError{/if}" id="newsArchiveIDsDiv">
		<div class="formFieldLabel">
			<label for="newsArchiveIDs">{lang}moxeo.acp.theme.module.newsItemList.newsArchiveIDs{/lang}</label>
		</div>
		<div class="formField">
			<select name="newsArchiveIDs[]" id="newsArchiveIDs" multiple="multiple" size="5">
				{htmloptions options=$newsArchiveOptions selected=$newsArchiveIDs}
			</select>
			{if $errorField == 'newsArchiveIDs'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="newsArchiveIDsHelpMessage">
			<p>{lang}moxeo.acp.theme.module.newsItemList.newsArchiveIDs.description{/lang}</p>
			<p>{lang}wcf.global.multiSelect{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('newsArchiveIDs');
	//]]></script>
	
	<div class="formElement" id="displayTypeDiv">
		<div class="formFieldLabel">
			<label for="displayType">{lang}moxeo.acp.theme.module.newsItemList.displayType{/lang}</label>
		</div>
		<div class="formField">
			<select name="displayType" id="displayType">
				<option value="full"{if $displayType == 'full'} selected="selected"{/if}>{lang}moxeo.acp.theme.module.newsItemList.displayType.full{/lang}</option>
				<option value="short"{if $displayType == 'short'} selected="selected"{/if}>{lang}moxeo.acp.theme.module.newsItemList.displayType.short{/lang}</option>
			</select>
		</div>
		<div class="formFieldDesc hidden" id="displayTypeHelpMessage">
			<p>{lang}moxeo.acp.theme.module.newsItemList.displayType.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('displayType');
	//]]></script>
	
	<div class="formElement" id="newsItemsPerPageDiv">
		<div class="formFieldLabel">
			<label for="newsItemsPerPage">{lang}moxeo.acp.theme.module.newsItemList.newsItemsPerPage{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="newsItemsPerPage" name="newsItemsPerPage" value="{@$newsItemsPerPage}" />
		</div>
		<div class="formFieldDesc hidden" id="newsItemsPerPageHelpMessage">
			<p>{lang}moxeo.acp.theme.module.newsItemList.newsItemsPerPage.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('newsItemsPerPage');
	//]]></script>
</fieldset>