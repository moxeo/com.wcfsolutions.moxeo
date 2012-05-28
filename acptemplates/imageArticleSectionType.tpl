{include file='headlineArticleSectionType'}

<fieldset>
	<legend>{lang}moxeo.acp.article.section.image.image{/lang}</label></legend>

	<div class="formElement{if $errorField == 'image'} formError{/if}" id="imageDiv">
		<div class="formFieldLabel">
			<label for="image">{lang}moxeo.acp.article.section.image.image{/lang}</label>
		</div>
		<div class="formField">
			<input type="button" id="image" value="{lang}moxeo.acp.fileManager.selection.change{/lang}" />
			{if $errorField == 'image'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'badImage'}{lang}moxeo.acp.article.section.image.image.error.badImage{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="imageHelpMessage">
			<p>{lang}moxeo.acp.article.section.image.image.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('image');
	//]]></script>

	<div class="formElement" id="captionDiv">
		<div class="formFieldLabel">
			<label for="caption">{lang}moxeo.acp.article.section.image.caption{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="caption" name="caption" value="{$caption}" />
		</div>
		<div class="formFieldDesc hidden" id="captionHelpMessage">
			<p>{lang}moxeo.acp.article.section.image.caption.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('caption');
	//]]></script>

	<div class="formElement" id="alternativeTitleDiv">
		<div class="formFieldLabel">
			<label for="alternativeTitle">{lang}moxeo.acp.article.section.image.alternativeTitle{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="alternativeTitle" name="alternativeTitle" value="{$alternativeTitle}" />
		</div>
		<div class="formFieldDesc hidden" id="alternativeTitleHelpMessage">
			<p>{lang}moxeo.acp.article.section.image.alternativeTitle.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('alternativeTitle');
	//]]></script>

	<div class="formElement" id="enableFullsizeDiv">
		<div class="formField">
			<label for="enableFullsize"><input type="checkbox" name="enableFullsize" id="enableFullsize" value="1" {if $enableFullsize}checked="checked" {/if}/> {lang}moxeo.acp.article.section.image.enableFullsize{/lang}</label>
		</div>
		<div class="formFieldDesc hidden" id="enableFullsizeHelpMessage">
			<p>{lang}moxeo.acp.article.section.image.enableFullsize.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('enableFullsize');
	//]]></script>

	<div class="formElement" id="urlDiv">
		<div class="formFieldLabel">
			<label for="url">{lang}moxeo.acp.article.section.image.url{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="url" name="url" value="{$url}" />
		</div>
		<div class="formFieldDesc hidden" id="urlHelpMessage">
			<p>{lang}moxeo.acp.article.section.image.url.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('url');
	//]]></script>
</fieldset>

<script type="text/javascript" src="{@RELATIVE_MOXEO_DIR}acp/js/FileManager.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe('dom:loaded', function() {
		var fileManager = new FileManager('image', new Array('{$image|encodeJS}'), {
			iconCloseSrc:			'{@RELATIVE_WCF_DIR}icon/closeS.png',
			iconFileManagerSrc:		'{@RELATIVE_MOXEO_DIR}icon/fileManagerS.png',
			iconFileManagerFileSrc:		'{@RELATIVE_MOXEO_DIR}icon/fileManagerFileS.png',
			iconFileManagerFolderSrc:	'{@RELATIVE_MOXEO_DIR}icon/fileManagerFolderS.png',
			langFileManager: 		'{lang}moxeo.acp.fileManager{/lang}',
			langClose:			'{lang}wcf.global.button.close{/lang}',
			langFileName:			'{lang}moxeo.acp.fileManager.file.name{/lang}',
			langFileSize:			'{lang}moxeo.acp.fileManager.file.size{/lang}',
			langFileDate:			'{lang}moxeo.acp.fileManager.file.date{/lang}',
			langFilePermissions:		'{lang}moxeo.acp.fileManager.file.permissions{/lang}',
			langFileTypeFolder:		'{lang}moxeo.acp.fileManager.file.fileType.folder{/lang}',
			langFileTypeFile:		'{lang}moxeo.acp.fileManager.file.fileType.file{/lang}',
			langSelectionApply:		'{lang}moxeo.acp.fileManager.selection.apply{/lang}',
			multipleSelect:			false
		});

		var form = $$('form')[0];
		if (form) {
			form.observe('submit', function(form) { this.submit(form); }.bind(fileManager, form));
		}
	});
	//]]>
</script>