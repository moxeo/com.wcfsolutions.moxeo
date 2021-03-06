{include file='headlineArticleSectionType'}

<fieldset>
	<legend>{lang}moxeo.acp.article.section.downloads.files{/lang}</label></legend>

	<div class="formElement{if $errorField == 'files'} formError{/if}" id="filesDiv">
		<div class="formFieldLabel">
			<label for="files">{lang}moxeo.acp.article.section.downloads.files{/lang}</label>
		</div>
		<div class="formField">
			<input type="button" id="files" value="{lang}moxeo.acp.fileManager.selection.change{/lang}" />
			{if $errorField == 'image'}
				<p class="innerError">
					{if $errorType|is_array}
						{foreach from=$errorType item=error}
							<p>
								{if $error.errorType == 'invalid'}{lang}moxeo.acp.article.section.downloads.files.error.invalid{/lang}{/if}
							</p>
						{/foreach}
					{elseif $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="filesHelpMessage">
			<p>{lang}moxeo.acp.article.section.downloads.files.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('files');
	//]]></script>
</fieldset>

<script type="text/javascript" src="{@RELATIVE_MOXEO_DIR}acp/js/FileManager.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe('dom:loaded', function() {
		var fileManager = new FileManager('files', new Array({implode from=$files item=file}'{$file|encodeJS}'{/implode}), {
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
			multipleSelect:			true
		});

		var form = $$('form')[0];
		if (form) {
			form.observe('submit', function(form) { this.submit(form); }.bind(fileManager, form));
		}
	});
	//]]>
</script>