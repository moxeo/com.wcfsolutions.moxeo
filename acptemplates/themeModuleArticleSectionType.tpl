{include file='headlineArticleSectionType'}

<fieldset>
	<legend>{lang}moxeo.acp.article.section.themeModule.data{/lang}</legend>
	
	<div class="formElement{if $errorField == 'themeModuleID'} formError{/if}" id="themeModuleIDDiv">
		<div class="formFieldLabel">
			<label for="themeModuleID">{lang}moxeo.acp.article.section.themeModule.themeModuleID{/lang}</label>
		</div>
		<div class="formField">
			<select name="themeModuleID" id="themeModuleID">
				{htmlOptions options=$themeModuleOptions selected=$themeModuleID disableEncoding=true}
			</select>
			{if $errorField == 'themeModuleID'}
				<p class="innerError">
					{if $errorType == 'invalid'}{lang}moxeo.acp.article.section.themeModule.themeModuleID.invalid{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="themeModuleIDHelpMessage">
			<p>{lang}moxeo.acp.article.section.themeModule.themeModuleID.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('themeModuleID');
	//]]></script>
</div>