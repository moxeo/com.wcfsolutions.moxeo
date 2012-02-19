{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_MOXEO_DIR}icon/newsArchive{@$action|ucfirst}L.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}moxeo.acp.news.archive.{@$action}{/lang}</h2>
	</div>
</div>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}moxeo.acp.news.archive.{@$action}.success{/lang}</p>	
{/if}

<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li><a href="index.php?page=NewsArchiveList&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}moxeo.acp.menu.link.content.newsArchive.view{/lang}"><img src="{@RELATIVE_MOXEO_DIR}icon/newsArchiveM.png" alt="" /> <span>{lang}moxeo.acp.menu.link.content.newsArchive.view{/lang}</span></a></li>
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>
<form method="post" action="index.php?form=NewsArchive{@$action|ucfirst}">
	<div class="border content">
		<div class="container-1">					
			<fieldset>
				<legend>{lang}moxeo.acp.news.archive.data{/lang}</legend>
				
				<div class="formElement{if $errorField == 'title'} formError{/if}" id="titleDiv">
					<div class="formFieldLabel">
						<label for="title">{lang}moxeo.acp.news.archive.title{/lang}</label>
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
						<p>{lang}moxeo.acp.news.archive.title.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('title');
				//]]></script>
				
				<div class="formElement{if $errorField == 'contentItemID'} formError{/if}" id="contentItemIDDiv">
					<div class="formFieldLabel">
						<label for="contentItemID">{lang}moxeo.acp.news.archive.contentItemID{/lang}</label>
					</div>
					<div class="formField">
						<select name="contentItemID" id="contentItemID">
							{htmlOptions options=$contentItemOptions selected=$contentItemID disableEncoding=true}
						</select>
						{if $errorField == 'parentID'}
							<p class="innerError">
								{if $errorType == 'invalid'}{lang}moxeo.acp.archive.error.contentItemID.invalid{/lang}{/if}
							</p>
						{/if}
					</div>
					<div class="formFieldDesc hidden" id="contentItemIDHelpMessage">
						<p>{lang}moxeo.acp.news.archive.contentItemID.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('contentItemID');
				//]]></script>
				
				{if $additionalDataFields|isset}{@$additionalDataFields}{/if}
			</fieldset>
			
			{if $additionalFields|isset}{@$additionalFields}{/if}
		</div>
	</div>
	
	<div class="formSubmit">
		<input type="submit" name="send" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
 		{@SID_INPUT_TAG}
 		{if $newsArchiveID|isset}<input type="hidden" name="newsArchiveID" value="{@$newsArchiveID}" />{/if}
 	</div>
</form>

{include file='footer'}