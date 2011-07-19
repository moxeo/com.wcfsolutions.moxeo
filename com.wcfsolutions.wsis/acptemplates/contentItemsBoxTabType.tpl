{if $contentItemOptions|count > 0}
	<fieldset>
		<legend>{lang}wcf.acp.box.tab.contentItems.data{/lang}</legend>
		
		<div class="formElement{if $errorField == 'contentItemID'} formError{/if}" id="contentItemIDDiv">
			<div class="formFieldLabel">
				<label for="contentItemID">{lang}wcf.acp.box.tab.contentItems.contentItemID{/lang}</label>
			</div>
			<div class="formField">
				<select name="contentItemID" id="contentItemID">
					<option value="0"></option>
					{htmlOptions options=$contentItemOptions selected=$contentItemID disableEncoding=true}
				</select>
				{if $errorField == 'contentItemID'}
					<p class="innerError">
						{if $errorType == 'invalid'}{lang}wcf.acp.box.tab.contentItems.error.contentItemID.invalid{/lang}{/if}
					</p>
				{/if}
			</div>
			<div class="formFieldDesc hidden" id="contentItemIDHelpMessage">
				<p>{lang}wcf.acp.box.tab.contentItems.contentItemID.description{/lang}</p>
			</div>
		</div>
		<script type="text/javascript">//<![CDATA[
			inlineHelp.register('contentItemID');
		//]]></script>
		
		<div class="formElement" id="useDetailedListDiv">
			<div class="formField">
				<label id="useDetailedList"><input type="checkbox" name="useDetailedList" value="1" {if $useDetailedList}checked="checked" {/if}/> {lang}wcf.acp.box.tab.contentItems.useDetailedList{/lang}</label>
			</div>
			<div class="formFieldDesc hidden" id="useDetailedListHelpMessage">
				<p>{lang}wcf.acp.box.tab.contentItems.useDetailedList.description{/lang}</p>
			</div>
		</div>
		<script type="text/javascript">//<![CDATA[
			inlineHelp.register('useDetailedList');
		//]]></script>
	</fieldset>
{/if}