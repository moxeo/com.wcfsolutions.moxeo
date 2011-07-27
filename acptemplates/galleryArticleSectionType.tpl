{include file='headlineArticleSectionType'}

<fieldset>
	<legend>{lang}wsis.acp.article.section.gallery.images{/lang}</label></legend>
	
	<div class="formElement{if $errorField == 'images'} formError{/if}" id="imagesDiv">
		<div class="formFieldLabel">
			<label for="images">{lang}wsis.acp.article.section.gallery.images{/lang}</label>
		</div>
		<div class="formField">
			<input type="button" id="images" value="{lang}wsis.acp.fileManager{/lang}" />
			{if $errorField == 'images'}
				<p class="innerError">
					{if $errorType|is_array}
						{foreach from=$errorType item=error}
							<p>
								{if $error.errorType == 'badImage'}{lang}wsis.acp.article.section.gallery.images.error.badImage{/lang}{/if}
							</p>
						{/foreach}
					{elseif $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="imagesHelpMessage">
			<p>{lang}wsis.acp.article.section.gallery.images.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('images');
	//]]></script>
</fieldset>

<script type="text/javascript" src="{@RELATIVE_WSIS_DIR}acp/js/FileManager.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe('dom:loaded', function() {
		var fileManager = new FileManager('images', new Array({implode from=$images item=image}'{$image|encodeJS}'{/implode}), {
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
			multipleSelect:			true
		});
		
		var form = $$('form')[0];
		if (form) {
			form.observe('submit', function(form) { this.submit(form); }.bind(fileManager, form));
		}
	});
	//]]>
</script>