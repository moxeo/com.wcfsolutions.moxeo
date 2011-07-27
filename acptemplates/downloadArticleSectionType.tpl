{include file='headlineArticleSectionType'}

<fieldset>
	<legend>{lang}wsis.acp.article.section.download.file{/lang}</label></legend>
	
	<div class="formElement{if $errorField == 'file'} formError{/if}" id="fileDiv">
		<div class="formFieldLabel">
			<label for="file">{lang}wsis.acp.article.section.download.file{/lang}</label>
		</div>
		<div class="formField">
			<input type="button" id="file" value="{lang}wsis.acp.fileManager{/lang}" />
			{if $errorField == 'file'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					{if $errorType == 'invalid'}{lang}wsis.acp.article.section.download.file.error.invalid{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="fileHelpMessage">
			<p>{lang}wsis.acp.article.section.download.file.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('file');
	//]]></script>
	
	<div class="formElement" id="captionDiv">
		<div class="formFieldLabel">
			<label for="caption">{lang}wsis.acp.article.section.download.caption{/lang}</label>
		</div>
		<div class="formField">
			<input type="text" class="inputText" id="caption" name="caption" value="{$caption}" />
		</div>
		<div class="formFieldDesc hidden" id="captionHelpMessage">
			<p>{lang}wsis.acp.article.section.download.caption.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('caption');
	//]]></script>
</fieldset>

<script type="text/javascript" src="{@RELATIVE_WSIS_DIR}acp/js/FileManager.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe('dom:loaded', function() {
		var fileManager = new FileManager('file', new Array('{$file|encodeJS}'), {
			iconCloseSrc:			'{@RELATIVE_WCF_DIR}icon/closeS.png',
			iconFileManagerSrc:		'{@RELATIVE_WSIS_DIR}icon/fileManagerS.png',
			iconFileManagerFileSrc:		'{@RELATIVE_WSIS_DIR}icon/fileManagerFileS.png',
			iconFileManagerFolderSrc:	'{@RELATIVE_WSIS_DIR}icon/fileManagerFolderS.png',
			langFileManager: 		'{lang}wsis.acp.fileManager{/lang}',
			langClose:			'{lang}wcf.global.button.close{/lang}',
			langFileName:			'{lang}wsis.acp.fileManager.file.name{/lang}',
			langFileSize:			'{lang}wsis.acp.fileManager.file.size{/lang}',
			langFileDate:			'{lang}wsis.acp.fileManager.file.date{/lang}',
			langFilePermissions:		'{lang}wsis.acp.fileManager.file.permissions{/lang}',
			langFileTypeFolder:		'{lang}wsis.acp.fileManager.file.fileType.folder{/lang}',
			langFileTypeFile:		'{lang}wsis.acp.fileManager.file.fileType.file{/lang}',
			langClose:			'{lang}wcf.global.button.close{/lang}',
			multipleSelect:			false
		});
		
		var form = $$('form')[0];
		if (form) {
			form.observe('submit', function(form) { this.submit(form); }.bind(fileManager, form));
		}
	});
	//]]>
</script>