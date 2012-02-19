{include file='headlineArticleSectionType'}

<fieldset>
	<legend>{lang}moxeo.acp.article.section.text.data{/lang}</legend>
	
	<div class="formElement{if $errorField == 'code'} formError{/if}" id="codeDiv">
		<div class="formFieldLabel">
			<label for="code">{lang}moxeo.acp.article.section.text.code{/lang}</label>
		</div>
		<div class="formField">
			<textarea cols="40" rows="10" id="code" name="code">{$code}</textarea>
			{if $errorField == 'code'}
				<p class="innerError">
					{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
				</p>
			{/if}
		</div>
		<div class="formFieldDesc hidden" id="codeHelpMessage">
			<p>{lang}moxeo.acp.article.section.text.code.description{/lang}</p>
		</div>
	</div>
	<script type="text/javascript">//<![CDATA[
		inlineHelp.register('code');
	//]]></script>
</fieldset>

<script type="text/javascript">
	//<![CDATA[
	document.observe('dom:loaded', function() {
		// enable thumbnail
		var enableThumbnail = $('enableThumbnail');
		if (enableThumbnail) {
			enableThumbnail.observe('click', function() { openList('thumbnailSettings'); });
		}
		
		{if !$enableThumbnail}
			var thumbnailSettings = $('thumbnailSettings');
			if (thumbnailSettings) {
				thumbnailSettings.hide();
			}
		{/if}
		
		// thumbnail enable fullsize
		var thumbnailEnableFullsize = $('thumbnailEnableFullsize');
		if (thumbnailEnableFullsize) {
			thumbnailEnableFullsize.observe('change', function() {
				if (this.checked) {
					enableOptions('thumbnailURL');
				}
				else {
					disableOptions('thumbnailURL');
				}
			});
		}
		
		{if !$thumbnailEnableFullsize}
			disableOptions('thumbnailURL');
		{/if}
	});
	//]]>
</script>

<fieldset>
	<legend><label for="enableThumbnail"><input type="checkbox" name="enableThumbnail" id="enableThumbnail" value="1" {if $enableThumbnail}checked="checked" {/if}/> {lang}moxeo.acp.article.section.text.thumbnail{/lang}</label></legend>
	
	<div id="thumbnailSettings">
		<div class="formElement{if $errorField == 'thumbnail'} formError{/if}" id="thumbnailDiv">
			<div class="formFieldLabel">
				<label for="thumbnail">{lang}moxeo.acp.article.section.text.thumbnail{/lang}</label>
			</div>
			<div class="formField">
				<input type="button" id="thumbnail" value="{lang}moxeo.acp.fileManager{/lang}" />
				{if $errorField == 'thumbnail'}
					<p class="innerError">
						{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					</p>
				{/if}
			</div>
			<div class="formFieldDesc hidden" id="thumbnailHelpMessage">
				<p>{lang}moxeo.acp.article.section.text.thumbnail.description{/lang}</p>
			</div>
		</div>
		<script type="text/javascript">//<![CDATA[
			inlineHelp.register('thumbnail');
		//]]></script>
		
		<div class="formElement" id="thumbnailCaptionDiv">
			<div class="formFieldLabel">
				<label for="thumbnailCaption">{lang}moxeo.acp.article.section.text.thumbnailCaption{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" id="thumbnailCaption" name="thumbnailCaption" value="{$thumbnailCaption}" />
			</div>
			<div class="formFieldDesc hidden" id="thumbnailCaptionHelpMessage">
				<p>{lang}moxeo.acp.article.section.text.thumbnailCaption.description{/lang}</p>
			</div>
		</div>
		<script type="text/javascript">//<![CDATA[
			inlineHelp.register('thumbnailCaption');
		//]]></script>
		
		<div class="formElement" id="thumbnailAlternativeTitleDiv">
			<div class="formFieldLabel">
				<label for="thumbnailAlternativeTitle">{lang}moxeo.acp.article.section.text.thumbnailAlternativeTitle{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" id="thumbnailAlternativeTitle" name="thumbnailAlternativeTitle" value="{$thumbnailAlternativeTitle}" />
			</div>
			<div class="formFieldDesc hidden" id="thumbnailAlternativeTitleHelpMessage">
				<p>{lang}moxeo.acp.article.section.text.thumbnailAlternativeTitle.description{/lang}</p>
			</div>
		</div>
		<script type="text/javascript">//<![CDATA[
			inlineHelp.register('thumbnailAlternativeTitle');
		//]]></script>
		
		<div class="formElement" id="thumbnailEnableFullsizeDiv">
			<div class="formField">
				<label for="thumbnailEnableFullsize"><input type="checkbox" name="thumbnailEnableFullsize" id="thumbnailEnableFullsize" value="1" {if $thumbnailEnableFullsize}checked="checked" {/if}/> {lang}moxeo.acp.article.section.text.thumbnailEnableFullsize{/lang}</label>
			</div>
			<div class="formFieldDesc hidden" id="thumbnailEnableFullsizeHelpMessage">
				<p>{lang}moxeo.acp.article.section.text.thumbnailEnableFullsize.description{/lang}</p>
			</div>
		</div>
		<script type="text/javascript">//<![CDATA[
			inlineHelp.register('thumbnailEnableFullsize');
		//]]></script>
		
		<div class="formElement" id="thumbnailURLDiv">
			<div class="formFieldLabel">
				<label for="thumbnailURL">{lang}moxeo.acp.article.section.text.thumbnailURL{/lang}</label>
			</div>
			<div class="formField">
				<input type="text" class="inputText" id="thumbnailURL" name="thumbnailURL" value="{$thumbnailURL}" />
			</div>
			<div class="formFieldDesc hidden" id="thumbnailURLHelpMessage">
				<p>{lang}moxeo.acp.article.section.text.thumbnailURL.description{/lang}</p>
			</div>
		</div>
		<script type="text/javascript">//<![CDATA[
			inlineHelp.register('thumbnailURL');
		//]]></script>
	</div>
</fieldset>

<script type="text/javascript" src="{@RELATIVE_MOXEO_DIR}acp/js/FileManager.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe('dom:loaded', function() {
		var fileManager = new FileManager('thumbnail', new Array('{$thumbnail|encodeJS}'), {
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