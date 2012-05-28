{include file='headlineArticleSectionType'}

<fieldset>
	<legend>{lang}moxeo.acp.article.section.download.file{/lang}</label></legend>

	<div class="formElement{if $errorField == 'file'} formError{/if}" id="fileDiv">
		<div class="formFieldLabel">
			<label for="file">{lang}moxeo.acp.article.section.download.file{/lang}</label>
		</div>
		<div class="formField">
			<input type="button" id="file" value="{lang}moxeo.acp.fileManager.selection.change{/lang}" />
			{if $errorField == 'file'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'invalid'}{lang}moxeo.acp.article.section.download.file.error.invalid{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="fileHelpMessage">
			<p>{lang}moxeo.acp.article.section.download.file.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('file');
	//]]></script>

	<div class="formElement" id="captionDiv">
		<div class="formFieldLabel">
			<label for="caption">{lang}moxeo.acp.article.section.download.caption{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="caption" name="caption" value="{$caption}" />
		</div>
		<div class="formFieldDesc hidden" id="captionHelpMessage">
			<p>{lang}moxeo.acp.article.section.download.caption.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('caption');
	//]]></script>
</fieldset>

<script type="text/javascript" src="{@RELATIVE_MOXEO_DIR}acp/js/FileManager.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe('dom:loaded', function() {
		var fileManager = new FileManager('file', new Array('{$file|encodeJS}'), {
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