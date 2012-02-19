{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_MOXEO_DIR}icon/article{@$action|ucfirst}L.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}moxeo.acp.article.{@$action}{/lang}</h2>
		{if $contentItemID}<p>{$contentItem->title}</p>{/if}
	</div>
</div>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}moxeo.acp.article.{@$action}.success{/lang}</p>	
{/if}

<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li><a href="index.php?page=ArticleList{if $contentItem}&amp;contentItemID={@$contentItem->contentItemID}{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}moxeo.acp.menu.link.content.article.view{/lang}"><img src="{@RELATIVE_MOXEO_DIR}icon/articleM.png" alt="" /> <span>{lang}moxeo.acp.menu.link.content.article.view{/lang}</span></a></li>
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>

{if $action == 'add'}
	{if $contentItemOptions|count}
		<fieldset>
			<legend>{lang}moxeo.acp.article.contentItem{/lang}</legend>
			<div class="formElement" id="contentItemIDDiv">
				<div class="formFieldLabel">
					<label for="contentItemChange">{lang}moxeo.acp.article.contentItemID{/lang}</label>
				</div>
				<div class="formField">
					<select id="contentItemChange" onchange="document.location.href=fixURL('index.php?form=ArticleAdd&amp;contentItemID='+this.options[this.selectedIndex].value+'&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}')">
						<option value="0"></option>
						{htmloptions options=$contentItemOptions selected=$contentItemID disableEncoding=true}
					</select>
				</div>
				<div class="formFieldDesc hidden" id="contentItemIDHelpMessage">
					{lang}moxeo.acp.article.contentItemID.description{/lang}
				</div>
			</div>
			<script type="text/javascript">//<![CDATA[
				inlineHelp.register('contentItemID');
			//]]></script>
		</fieldset>
	{else}
		<div class="border content">
			<div class="container-1">
				<p>{lang}moxeo.acp.article.view.count.noContentItems{/lang}</p>
			</div>
		</div>
	{/if}
{/if}

{if $contentItemID || $action == 'edit'}
	<form method="post" action="index.php?form=Article{@$action|ucfirst}">
		<div class="border content">
			<div class="container-1">
				<fieldset>
					<legend>{lang}moxeo.acp.article.classification{/lang}</legend>
					
					<div class="formElement" id="showOrderDiv">
						<div class="formFieldLabel">
							<label for="showOrder">{lang}moxeo.acp.article.showOrder{/lang}</label>
						</div>
						<div class="formField">	
							<input type="text" class="inputText" name="showOrder" id="showOrder" value="{$showOrder}" />
						</div>
						<div class="formFieldDesc hidden" id="showOrderHelpMessage">
							{lang}moxeo.acp.article.showOrder.description{/lang}
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('showOrder');
					//]]></script>
						
					{if $additionalClassificationFields|isset}{@$additionalClassificationFields}{/if}
				</fieldset>
						
				<fieldset>
					<legend>{lang}moxeo.acp.article.data{/lang}</legend>
					
					<div class="formElement{if $errorField == 'title'} formError{/if}" id="titleDiv">
						<div class="formFieldLabel">
							<label for="title">{lang}moxeo.acp.article.title{/lang}</label>
						</div>
						<div class="formField">
							<input type="text" class="inputText" id="title" name="title" value="{$title}" />
							{if $errorField == 'title'}
								<p class="innerError">
									{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
								</p>
							{/if}
						</div>
						<div class="formFieldDesc hidden" id="titleHelpMessage">
							<p>{lang}moxeo.acp.article.title.description{/lang}</p>
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('title');
					//]]></script>
					
					<div class="formElement" id="themeModulePositionDiv">
						<div class="formFieldLabel">
							<label for="themeModulePosition">{lang}moxeo.acp.article.themeModulePosition{/lang}</label>
						</div>
						<div class="formField">
							<select name="themeModulePosition" id="position">
								{foreach from=$themeModulePositions item=position}
									<option value="{@$position}"{if $position == $themeModulePosition} selected="selected"{/if}>{lang}wcf.theme.module.position.{@$position}{/lang}</option>
								{/foreach}
							</select>
						</div>
						<div class="formFieldDesc hidden" id="themeModulePositionHelpMessage">
							{lang}moxeo.acp.article.themeModulePosition.description{/lang}
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('themeModulePosition');
					//]]></script>
					
					{if $additionalDataFields|isset}{@$additionalDataFields}{/if}
				</fieldset>
				
				<fieldset>
					<legend>{lang}moxeo.acp.article.display{/lang}</legend>
					
					<div class="formElement" id="cssIDDiv">
						<div class="formFieldLabel">
							<label for="cssID">{lang}moxeo.acp.article.cssID{/lang}</label>
						</div>
						<div class="formField">
							<input type="text" class="inputText" id="cssID" name="cssID" value="{$cssID}" />
						</div>
						<div class="formFieldDesc hidden" id="cssIDHelpMessage">
							{lang}moxeo.acp.article.cssID.description{/lang}
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('cssID');
					//]]></script>
					
					<div class="formElement" id="cssClassesDiv">
						<div class="formFieldLabel">
							<label for="cssClasses">{lang}moxeo.acp.article.cssClasses{/lang}</label>
						</div>
						<div class="formField">
							<input type="text" class="inputText" id="cssClasses" name="cssClasses" value="{$cssClasses}" />
						</div>
						<div class="formFieldDesc hidden" id="cssClassesHelpMessage">
							{lang}moxeo.acp.article.cssClasses.description{/lang}
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('cssClasses');
					//]]></script>
					
					{if $additionalDisplayFields|isset}{@$additionalDisplayFields}{/if}
				</fieldset>
				
				{if $additionalFields|isset}{@$additionalFields}{/if}
			</div>
		</div>
		
		<div class="formSubmit">
			<input type="submit" name="send" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
			<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
			<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
	 		{@SID_INPUT_TAG}
	 		{if $contentItemID}<input type="hidden" name="contentItemID" value="{@$contentItemID}" />{/if}
	 		{if $articleID|isset}<input type="hidden" name="articleID" value="{@$articleID}" />{/if}
	 	</div>
	</form>
{/if}

{include file='footer'}