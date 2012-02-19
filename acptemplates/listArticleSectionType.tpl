{include file='headlineArticleSectionType'}

<fieldset>
	<legend>{lang}moxeo.acp.article.section.list.data{/lang}</label></legend>
	
	<div class="formElement{if $errorField == 'listItems'} formError{/if}" id="listItemsDiv">
		<div class="formFieldLabel">
			<label for="listItems">{lang}moxeo.acp.article.section.list.listItems{/lang}</label>
		</div>
		<div class="formField">
			<textarea id="listItems" name="listItems" cols="40" rows="5">{$listItems}</textarea>
			{if $errorField == 'listItems'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="listItemsHelpMessage">
			<p>{lang}moxeo.acp.article.section.list.listItems.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('listItems');
	//]]></script>
	
	<div class="formElement{if $errorField == 'listStyleType'} formError{/if}" id="listStyleTypeDiv">
		<div class="formFieldLabel">
			<label for="listStyleType">{lang}moxeo.acp.article.section.list.listStyleType{/lang}</label>
		</div>
		<div class="formField">
			<select name="listStyleType" id="listStyleType">
				{foreach from=$listStyleTypeOptions item=availableListStyleType}
					<option value="{@$availableListStyleType}"{if $listStyleType == $availableListStyleType} selected="selected"{/if}>{@$availableListStyleType}</option>
				{/foreach}
			</select>
			{if $errorField == 'listStyleType'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="listStyleTypeHelpMessage">
			<p>{lang}moxeo.acp.article.section.list.listStyleType.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('listStyleType');
	//]]></script>
</fieldset>