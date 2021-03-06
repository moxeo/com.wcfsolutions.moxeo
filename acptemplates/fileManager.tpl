{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_MOXEO_DIR}icon/fileManagerL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}moxeo.acp.fileManager{/lang}</h2>
	</div>
</div>

{if $deletedFile}
	<p class="success">{lang}moxeo.acp.fileManager.file.delete.success{/lang}</p>
{/if}

{if $files|count}
	<div class="border titleBarPanel">
		<div class="containerHead"><h3>files/{$dir}</h3></div>
	</div>
	<div class="border borderMarginRemove">
		<table class="tableList">
			<thead>
				<tr class="tableHead">
					<th><div><span class="emptyHead">&nbsp;</span></div></th>
					<th class="columnName{if $sortField == 'name'} active{/if}"><div><a href="index.php?page=FileManager&amp;dir={$dir}&amp;pageNo={@$pageNo}&amp;sortField=name&amp;sortOrder={if $sortField == 'name' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.fileManager.file.name{/lang}{if $sortField == 'name'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnSize{if $sortField == 'size'} active{/if}"><div><a href="index.php?page=FileManager&amp;dir={$dir}&amp;pageNo={@$pageNo}&amp;sortField=size&amp;sortOrder={if $sortField == 'size' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.fileManager.file.size{/lang}{if $sortField == 'size'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnDate{if $sortField == 'date'} active{/if}"><div><a href="index.php?page=FileManager&amp;dir={$dir}&amp;pageNo={@$pageNo}&amp;sortField=date&amp;sortOrder={if $sortField == 'date' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.fileManager.file.date{/lang}{if $sortField == 'date'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnPermissions{if $sortField == 'permissions'} active{/if}"><div><a href="index.php?page=FileManager&amp;dir={$dir}&amp;pageNo={@$pageNo}&amp;sortField=permissions&amp;sortOrder={if $sortField == 'permissions' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.fileManager.file.permissions{/lang}{if $sortField == 'permissions'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>

					{if $additionalColumnHeads|isset}{@$additionalColumnHeads}{/if}
				</tr>
			</thead>
			<tbody>
				{foreach from=$files item=file}
					<tr class="{cycle values="container-1,container-2"}">
						<td class="columnIcon">
							{if $file.name != '..'}
						   		<a href="index.php?action=FileManagerFileDelete&amp;file={$file.relativePath|urlencode}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" onclick="return confirm('{lang}moxeo.acp.fileManager.file.delete.sure{/lang}')" title="{lang}moxeo.acp.fileManager.file.delete{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" /></a>
							{else}
								<img src="{@RELATIVE_WCF_DIR}icon/deleteDisabledS.png" alt="" title="{lang}moxeo.acp.fileManager.file.delete{/lang}" />
							{/if}

							<img src="{@RELATIVE_MOXEO_DIR}icon/fileManager{if $file.isDir}Folder{else}File{/if}S.png" alt="{lang}moxeo.acp.fileManager.file.fileType.{if $file.isDir}folder{else}file{/if}{/lang}" title="{lang}moxeo.acp.fileManager.file.fileType.{if $file.isDir}folder{else}file{/if}{/lang}" />
						</td>
						<td class="columnName columnText">
							{if $file.isDir}
								<a href="index.php?page=FileManager{if $file.relativePath}&amp;dir={$file.relativePath|urlencode}{/if}&amp;sortField={$sortField}&amp;sortOrder={$sortOrder}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{$file.name}</a>
							{else}
								<a href="index.php?page=FileManagerFileDownload&amp;file={$file.relativePath|urlencode}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{$file.name}</a>
							{/if}
						</td>
						<td class="columnSize columnText">{if !$file.isDir}{@$file.size|filesize}{/if}</td>
						<td class="columnDate columnText">{if $file.date != 0}{@$file.date|shorttime}{/if}</td>
						<td class="columnPermissions columnNumbers">{@$file.permissions}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
{else}
	<div class="border content">
		<div class="container-1">
			<p>{lang}moxeo.acp.fileManager.file.count.noFiles{/lang}</p>
		</div>
	</div>
{/if}

<script type="text/javascript">
	//<![CDATA[
	function setFileType(newType) {
		switch (newType) {
			case 'folder':
				$('folderDiv').show();
				$('fileDiv').hide();
				break;
			case 'file':
				$('folderDiv').hide();
				$('fileDiv').show();
				break;
		}
	}
	document.observe("dom:loaded", function() {
		setFileType('{@$fileType}');
	});
	//]]>
</script>

<form enctype="multipart/form-data" method="post" action="index.php?page=FileManager">
	<div class="border titleBarPanel">
		<div class="containerHead"><h3>{lang}moxeo.acp.fileManager.file.add{/lang}</h3></div>
	</div>
	<div class="border content borderMarginRemove">
		<div class="container-1">
			<fieldset>
				<legend>{lang}moxeo.acp.fileManager.file.fileType{/lang}</legend>

				<div class="formGroup{if $errorField == 'fileType'} formError{/if}">
					<div class="formGroupLabel">
						{lang}moxeo.acp.fileManager.file.fileType{/lang}
					</div>
					<div class="formGroupField">
						<fieldset>
							<legend>{lang}moxeo.acp.fileManager.file.fileType{/lang}</legend>
							<div class="formField">
								<ul class="formOptions">
									<li><label><input onclick="if (IS_SAFARI) setFileType('folder')" onfocus="setFileType('folder')" type="radio" name="fileType" value="folder" {if $fileType == 'folder'}checked="checked" {/if} /> {lang}moxeo.acp.fileManager.file.fileType.folder{/lang}</label></li>
									<li><label><input onclick="if (IS_SAFARI) setFileType('file')" onfocus="setFileType('file')" type="radio" name="fileType" value="file" {if $fileType == 'file'}checked="checked" {/if} /> {lang}moxeo.acp.fileManager.file.fileType.file{/lang}</label></li>
								</ul>
							</div>
							{if $errorField == 'fileType'}
								<p class="innerError">
									{if $errorType == 'invalid'}{lang}moxeo.acp.fileManager.file.error.fileType.invalid{/lang}{/if}
								</p>
							{/if}
						</fieldset>
					</div>
				</div>
			</fieldset>

			<fieldset{if $errorField == 'dirName'} class="formError"{/if} id="folderDiv">
				<legend>{lang}moxeo.acp.fileManager.dirName{/lang}</legend>

				<div class="formElement{if $errorField == 'dirName'} formError{/if}">
					<div class="formFieldLabel">
						<label for="dirName">{lang}moxeo.acp.fileManager.dirName{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" id="dirName" name="dirName" value="{$dirName}" />
						{if $errorField == 'dirName'}
							<p class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
							</p>
						{/if}
					</div>
				</div>
			</fieldset>

			<fieldset{if $errorField == 'fileUpload'} class="formError"{/if} id="fileDiv">
				<legend>{lang}moxeo.acp.fileManager.fileUpload{/lang}</legend>

				<ol id="uploadFields" class="itemList">
					<li>
						<div class="buttons">
							<a href="#delete" title="{lang}wcf.global.button.delete{/lang}" class="hidden"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" longdesc="" alt="" /></a>
						</div>
						<div class="itemListTitle">
							<input type="file" size="50" name="fileUpload[]" />
						</div>
					</li>
				</ol>

				{if $errorField == 'fileUpload'}
					<div class="innerError">
						{if $errorType|is_array}
							{foreach from=$errorType item=error}
								{assign var=filename value=$error.filename}
								<p>
									{if $error.errorType == 'uploadFailed'}{lang}moxeo.acp.fileManager.file.fileUpload.error.uploadFailed{/lang}{/if}
									{if $error.errorType == 'copyFailed'}{lang}moxeo.acp.fileManager.file.fileUpload.error.copyFailed{/lang}{/if}
									{if $error.errorType == 'illegalExtension'}{lang}moxeo.acp.fileManager.file.fileUpload.error.illegalExtension{/lang}{/if}
								</p>
							{/foreach}
						{elseif $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
					</div>
				{/if}

				<script type="text/javascript">
					//<![CDATA[
					var openUploads = 20;
					function addUploadField() {
						if (openUploads > 0) {
							var fileInput = new Element('input', { 'type': 'file', 'name': 'fileUpload[]', 'size': 50 });
							var fileDiv = new Element('div').addClassName('itemListTitle');
							var deleteButton = new Element('a', { 'href': '#delete', 'title': '{lang}wcf.global.button.delete{/lang}' });
							deleteButton.addClassName('hidden');
							var deleteImg = new Element('img', { 'src': '{@RELATIVE_WCF_DIR}icon/deleteS.png', 'longdesc': '' });
							var buttons = new Element('div').addClassName('buttons').insert(deleteButton.insert(deleteImg));

							$('uploadFields').insert(new Element('li').insert(buttons).insert(fileDiv.insert(fileInput)));
							deleteButton.observe('click', removeUploadField);
							fileInput.observe('change', uploadFieldChanged);
							openUploads--;
						}
					}

					function removeUploadField(evt) {
						var fileInput = evt.findElement().up('li').down('input');
						var emptyField = true;
						var counter = 0;
						$$('#uploadFields input[type=file]').each(function(input) {
							if (input.value == '') {
								emptyField = true;
							}
							counter++;
						});
						if (emptyField && fileInput.value != '' && counter > 1) {
							fileInput.up('li').fade({
								'duration': '0.5', afterFinish: function() { fileInput.up('li').remove(); }
							});
							openUploads++;
						}
						else {
							fileInput.value = '';
						}
						evt.stop();
					}

					function uploadFieldChanged(e) {
						if (!e) e = window.event;

						if (e.target) var inputField = e.target;
						else if (e.srcElement) var inputField = e.srcElement;

						var emptyField = false;
						$$('#uploadFields input[type=file]').each(function(input) {
							if (input.value == '') emptyField = true;
						});

						if (!emptyField && inputField.value != '' && inputField.value != inputField.oldValue) {
							inputField.oldValue = inputField.value;
							addUploadField();
						}
						if (inputField.value == '') {
							$(inputField).up('li').down('a[href*="#delete"]').addClassName('hidden');
						}
						else {
							$(inputField).up('li').down('a[href*="#delete"]').removeClassName('hidden');
						}
					}

					// add button
					document.observe('dom:loaded', function() {
						$$('#uploadFields input[type=file]').invoke('observe', 'change', uploadFieldChanged);
						$$('#uploadFields a[href*="#delete"]').invoke('observe', 'click', removeUploadField);
					});
					//]]>
				</script>
			</fieldset>
		</div>
	</div>

	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
		<input type="hidden" name="dir" value="{$dir}" />
 		{@SID_INPUT_TAG}
 	</div>
</form>

{include file='footer'}