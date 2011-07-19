{include file='headlineArticleSectionType'}

<fieldset>
	<legend>{lang}wsis.acp.article.section.youTube.data{/lang}</legend>
	
	<div class="formElement{if $errorField == 'videoID'} formError{/if}" id="videoIDDiv">
		<div class="formFieldLabel">
			<label for="videoID">{lang}wsis.acp.article.section.youTube.videoID{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="videoID" name="videoID" value="{$videoID}" />
			{if $errorField == 'videoID'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="videoIDHelpMessage">
			<p>{lang}wsis.acp.article.section.youTube.videoID.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('videoID');
	//]]></script>
</fieldset>