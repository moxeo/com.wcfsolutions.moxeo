{include file='headlineArticleSectionType'}

<fieldset>
	<legend>{lang}moxeo.acp.article.section.gallery.images{/lang}</label></legend>

	<div class="formElement{if $errorField == 'images'} formError{/if}" id="imagesDiv">
		<div class="formFieldLabel">
			<label for="images">{lang}moxeo.acp.article.section.gallery.images{/lang}</label>
		</div>
		<div class="formField">
			<input type="button" id="images" value="{lang}moxeo.acp.fileManager.selection.change{/lang}" />
			{if $errorField == 'images'}
				<p class="innerError">
					{if $errorType|is_array}
						{foreach from=$errorType item=error}
							<p>
								{if $error.errorType == 'badImage'}{lang}moxeo.acp.article.section.gallery.images.error.badImage{/lang}{/if}
							</p>
						{/foreach}
					{elseif $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="imagesHelpMessage">
			<p>{lang}moxeo.acp.article.section.gallery.images.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('images');
	//]]></script>
</fieldset>

<script type="text/javascript" src="{@RELATIVE_MOXEO_DIR}acp/js/FileManager.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe('dom:loaded', function() {
		var fileManager = new FileManager('images', new Array({implode from=$images item=image}'{$image|encodeJS}'{/implode}), {
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