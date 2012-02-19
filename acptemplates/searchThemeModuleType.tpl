<fieldset>
	<legend>{lang}moxeo.acp.theme.module.search.data{/lang}</legend>
	
	<div class="formElement" id="itemsPerPageDiv">
		<div class="formFieldLabel">
			<label for="itemsPerPage">{lang}moxeo.acp.theme.module.search.itemsPerPage{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="itemsPerPage" name="itemsPerPage" value="{@$itemsPerPage}" />
		</div>
		<div class="formFieldDesc hidden" id="itemsPerPageHelpMessage">
			<p>{lang}moxeo.acp.theme.module.search.itemsPerPage.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('itemsPerPage');
	//]]></script>
</fieldset>