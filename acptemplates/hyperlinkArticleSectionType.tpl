{include file='headlineArticleSectionType'}

<fieldset>
	<legend>{lang}moxeo.acp.article.section.hyperlink.data{/lang}</label></legend>
	
	<div class="formElement{if $errorField == 'url'} formError{/if}" id="urlDiv">
		<div class="formFieldLabel">
			<label for="url">{lang}moxeo.acp.article.section.hyperlink.url{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="url" name="url" value="{$url}" />
			{if $errorField == 'url'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="urlHelpMessage">
			<p>{lang}moxeo.acp.article.section.hyperlink.url.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('url');
	//]]></script>
	
	<div class="formElement" id="captionDiv">
		<div class="formFieldLabel">
			<label for="caption">{lang}moxeo.acp.article.section.hyperlink.caption{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="caption" name="caption" value="{$caption}" />
		</div>
		<div class="formFieldDesc hidden" id="captionHelpMessage">
			<p>{lang}moxeo.acp.article.section.hyperlink.caption.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('caption');
	//]]></script>
</fieldset>