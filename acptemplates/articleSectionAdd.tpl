{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WSIS_DIR}icon/articleSection{@$action|ucfirst}L.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wsis.acp.article.section.{@$action}{/lang}</h2>
	</div>
</div>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}wsis.acp.article.section.{@$action}.success{/lang}</p>	
{/if}

<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li><a href="index.php?page=ArticleSectionList&amp;articleID={@$article->articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wsis.acp.article.section.view{/lang}"><img src="{@RELATIVE_WSIS_DIR}icon/articleSectionM.png" alt="" /> <span>{lang}wsis.acp.article.section.view{/lang}</span></a></li>
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>
<form method="post" action="index.php?form=ArticleSection{@$action|ucfirst}{if $action == 'add'}&amp;articleID={@$articleID}{elseif $action == 'edit'}&amp;articleSectionID={@$articleSectionID}{/if}">
	<div class="border content">
		<div class="container-1">			
			<fieldset>
				<legend>{lang}wsis.acp.article.section.general{/lang}</legend>
				
				<div class="formElement{if $errorField == 'articleSectionType'} formError{/if}" id="articleSectionTypeDiv">
					<div class="formFieldLabel">
						<label for="articleSectionType">{lang}wsis.acp.article.section.type{/lang}</label>
					</div>
					<div class="formField">
						<select name="articleSectionType" id="articleSectionType" onchange="this.form.submit();">
							<option value=""></option>
							{htmloptions options=$articleSectionTypeOptions selected=$articleSectionType}
						</select>
						{if $errorField == 'articleSectionType'}
							<p class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
							</p>
						{/if}
					</div>
					<div class="formFieldDesc hidden" id="articleSectionTypeHelpMessage">
						<p>{lang}wsis.acp.article.section.type.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('articleSectionType');
				//]]></script>
				
				<div class="formElement" id="showOrderDiv">
					<div class="formFieldLabel">
						<label for="showOrder">{lang}wsis.acp.article.section.showOrder{/lang}</label>
					</div>
					<div class="formField">	
						<input type="text" class="inputText" name="showOrder" id="showOrder" value="{$showOrder}" />
					</div>
					<div class="formFieldDesc hidden" id="showOrderHelpMessage">
						{lang}wsis.acp.article.section.showOrder.description{/lang}
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('showOrder');
				//]]></script>
				
				{if $additionalGeneralFields|isset}{@$additionalGeneralFields}{/if}
			</fieldset>
			
			<fieldset>
				<legend>{lang}wsis.acp.article.section.display{/lang}</legend>
				
				<div class="formElement" id="cssIDDiv">
					<div class="formFieldLabel">
						<label for="cssID">{lang}wsis.acp.article.section.cssID{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" id="cssID" name="cssID" value="{$cssID}" />
					</div>
					<div class="formFieldDesc hidden" id="cssIDHelpMessage">
						{lang}wsis.acp.article.section.cssID.description{/lang}
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('cssID');
				//]]></script>
				
				<div class="formElement" id="cssClassesDiv">
					<div class="formFieldLabel">
						<label for="cssClasses">{lang}wsis.acp.article.section.cssClasses{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" id="cssClasses" name="cssClasses" value="{$cssClasses}" />
					</div>
					<div class="formFieldDesc hidden" id="cssClassesHelpMessage">
						{lang}wsis.acp.article.section.cssClasses.description{/lang}
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('cssClasses');
				//]]></script>
				
				{if $additionalDisplayFields|isset}{@$additionalDisplayFields}{/if}
			</fieldset>
			
			{if $articleSectionTypeObject && $articleSectionTypeObject->getFormTemplateName()}
				{include file=$articleSectionTypeObject->getFormTemplateName()}
			{/if}
			
			{if $additionalFields|isset}{@$additionalFields}{/if}
		</div>
	</div>
	
	<div class="formSubmit">
		<input type="submit" name="send" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
 		{@SID_INPUT_TAG}
 		{if $articleSectionID|isset}<input type="hidden" name="articleSectionID" value="{@$articleSectionID}" />{/if}
 	</div>
</form>

{include file='footer'}