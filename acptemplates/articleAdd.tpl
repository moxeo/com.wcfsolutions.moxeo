{include file='header'}

<ul class="breadCrumbs">
	<li><a href="index.php?page=ArticleList{@SID_ARG_2ND}"><span>{lang}moxeo.acp.article.view{/lang}</span></a> &raquo;</li>
	{if $contentItem}<li><a href="index.php?page=ArticleList&amp;contentItemID={@$contentItem->contentItemID}{@SID_ARG_2ND}"><span>{$contentItem->title}</span></a> &raquo;</li>{/if}
</ul>
<div class="mainHeadline">
	<img src="{@RELATIVE_MOXEO_DIR}icon/article{@$action|ucfirst}L.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}moxeo.acp.article.{@$action}{/lang}</h2>
	</div>
</div>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}moxeo.acp.article.{@$action}.success{/lang}</p>
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
{else}
	{if $contentItems|count > 0}
		<div class="info">
			{lang}moxeo.acp.article.add.info{/lang}
		</div>

		<div class="border content">
			<div class="container-1">
				<ol class="itemList" id="contentItemList">
					{foreach from=$contentItems item=child}
						{assign var="contentItem" value=$child.contentItem}

						<li id="item_{@$contentItem->contentItemID}">
							<div class="buttons">
								{if !$contentItem->isRoot() && !$contentItem->isExternalLink() && $contentItem->getAdminPermission('canAddArticle')}
									<a href="index.php?form=ArticleAdd&amp;contentItemID={@$contentItem->contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}moxeo.acp.article.add{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/addS.png" alt="" /></a>
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/addDisabledS.png" alt="" title="{lang}moxeo.acp.article.add{/lang}" />
								{/if}
								{if $child.additionalButtons|isset}{@$child.additionalButtons}{/if}
							</div>

							<h3 class="itemListTitle{if $contentItem->isRoot()} itemListCategory{/if}">
								{if $contentItem->isRoot()}
									{@$contentItem->getLanguageIcon()}
								{else}
									<img src="{@RELATIVE_MOXEO_DIR}icon/contentItem{if $contentItem->isExternalLink()}Redirect{/if}S.png" alt="" />
								{/if}

								{if $contentItem->isRoot() || $contentItem->isExternalLink()}
									ID-{@$contentItem->contentItemID} {$contentItem->title}
								{else}
									ID-{@$contentItem->contentItemID} <a href="index.php?form=ArticleAdd&amp;contentItemID={@$contentItem->contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" class="title">{$contentItem->title}</a>
								{/if}
							</h3>

						{if $child.hasChildren}<ol id="parentItem_{@$contentItem->contentItemID}">{else}<ol id="parentItem_{@$contentItem->contentItemID}"></ol></li>{/if}
						{if $child.openParents > 0}{@"</ol></li>"|str_repeat:$child.openParents}{/if}
					{/foreach}
				</ol>
			</div>
		</div>
	{else}
		<div class="border content">
			<div class="container-1">
				<p>{lang}moxeo.acp.article.view.count.noContentItems{/lang}</p>
			</div>
		</div>
	{/if}
{/if}

{include file='footer'}