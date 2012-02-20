{include file='header'}
<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/TabMenu.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	var tabMenu = new TabMenu();
	onloadEvents.push(function() { tabMenu.showSubTabMenu("{$activeTabMenuItem}") });
	//]]>
</script>

<div class="mainHeadline">
	<img src="{@RELATIVE_MOXEO_DIR}icon/contentItem{@$action|ucfirst}L.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}moxeo.acp.contentItem.{@$action}{/lang}</h2>
		{if $contentItemID|isset}<p>{$contentItem->title}</p>{/if}
	</div>
</div>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{if $action == 'add'}{lang}moxeo.acp.contentItem.add.success{/lang}{else}{lang}moxeo.acp.contentItem.edit.success{/lang}{/if}</p>
{/if}

<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/Suggestion.class.js"></script>
<script type="text/javascript" src="{@RELATIVE_MOXEO_DIR}acp/js/PermissionList.class.js"></script>
<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/Calendar.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	var language = new Object();
	language['moxeo.acp.contentItem.permissions.permissionsFor'] = '{staticlang}moxeo.acp.contentItem.permissions.permissionsFor{/staticlang}';
	language['moxeo.acp.contentItem.permissions.fullControl'] = '{lang}moxeo.acp.contentItem.permissions.fullControl{/lang}';
	{foreach from=$permissionSettings item=permissionSetting}
		language['moxeo.acp.contentItem.permissions.{@$permissionSetting}'] = '{lang}moxeo.acp.contentItem.permissions.{@$permissionSetting}{/lang}';
	{/foreach}
	{foreach from=$adminSettings item=adminSetting}
		language['moxeo.acp.contentItem.permissions.{@$adminSetting}'] = '{lang}moxeo.acp.contentItem.permissions.{@$adminSetting}{/lang}';
	{/foreach}

	var permissions = new Hash();
	{assign var=i value=0}
	{foreach from=$permissions item=permission}
		var settings = new Hash();
		settings.set('fullControl', -1);

		{foreach from=$permission.settings key=setting item=value}
			{if $setting != 'name' && $setting != 'type' && $setting != 'id'}
				settings.set('{@$setting}', {@$value});
			{/if}
		{/foreach}

		permissions.set({@$i}, {
			'name': '{@$permission.name|encodeJS}',
			'type': '{@$permission.type}',
			'id': '{@$permission.id}',
			'settings': settings
		});

		{assign var=i value=$i+1}
	{/foreach}

	var admins = new Hash();
	{assign var=i value=0}
	{foreach from=$admins item=admin}
		var settings = new Hash();
		settings.set('fullControl', -1);

		{foreach from=$admin.settings key=setting item=value}
			{if $setting != 'name' && $setting != 'type' && $setting != 'id'}
				settings.set('{@$setting}', {@$value});
			{/if}
		{/foreach}

		admins.set({@$i}, {
			'name': '{@$admin.name|encodeJS}',
			'type': '{@$admin.type}',
			'id': '{@$admin.id}',
			'settings': settings
		});

		{assign var=i value=$i+1}
	{/foreach}

	var permissionSettings = new Array({implode from=$permissionSettings item=permissionSetting}'{@$permissionSetting}'{/implode});
	var adminSettings = new Array({implode from=$adminSettings item=adminSetting}'{@$adminSetting}'{/implode});

	var calendar = new Calendar('{$monthList}', '{$weekdayList}', {@$startOfWeek});

	// content item type
	function setContentItemType(newType) {
		switch (newType) {
			case 0:
				showOptions('descriptionDiv', 'meta', 'themeLayoutIDDiv', 'invisibleDiv', 'addSecurityTokenDiv', 'publishing');
				hideOptions('externalURLDiv');
				break;
			case 1:
				showOptions('externalURLDiv', 'invisibleDiv', 'publishing');
				hideOptions('descriptionDiv', 'meta', 'themeLayoutIDDiv', 'addSecurityTokenDiv');
				break;
			case 2:
			case 3:
				showOptions('descriptionDiv', 'meta', 'themeLayoutIDDiv');
				hideOptions('externalURLDiv', 'invisibleDiv', 'addSecurityTokenDiv', 'publishing');
				break;
		}
	}

	document.observe("dom:loaded", function() {
		setContentItemType({@$contentItemType});

		// user/group permissions
		var permissionList = new PermissionList('permission', 'contentItem', permissions, permissionSettings);

		// admins
		var adminList = new PermissionList('admin', 'contentItem', admins, adminSettings);

		// add onsubmit event
		$('contentItemAddForm').onsubmit = function() {
			if (suggestion.selectedIndex != -1) return false;
			if (permissionList.inputHasFocus || adminList.inputHasFocus) return false;
			permissionList.submit(this);
			adminList.submit(this);
		};
	});
	//]]>
</script>

<div class="contentHeader">
	<div class="largeButtons">
		<ul><li><a href="index.php?page=ContentItemList&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}moxeo.acp.menu.link.content.contentItem.view{/lang}"><img src="{@RELATIVE_MOXEO_DIR}icon/contentItemM.png" alt="" /> <span>{lang}moxeo.acp.menu.link.content.contentItem.view{/lang}</span></a></li></ul>
	</div>
</div>

<form method="post" action="index.php?form=ContentItem{@$action|ucfirst}" id="contentItemAddForm">
	{if $contentItemID|isset && $contentItemQuickJumpOptions|count > 1}
		<fieldset>
			<legend>{lang}moxeo.acp.contentItem.edit{/lang}</legend>
			<div class="formElement">
				<div class="formFieldLabel">
					<label for="contentItemChange">{lang}moxeo.acp.contentItem.edit{/lang}</label>
				</div>
				<div class="formField">
					<select id="contentItemChange" onchange="document.location.href=fixURL('index.php?form=ContentItemEdit&amp;contentItemID='+this.options[this.selectedIndex].value+'&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}')">
						{htmloptions options=$contentItemQuickJumpOptions selected=$contentItemID disableEncoding=true}
					</select>
				</div>
			</div>
		</fieldset>
	{/if}

	<div class="tabMenu">
		<ul>
			<li id="data"><a onclick="tabMenu.showSubTabMenu('data');"><span>{lang}moxeo.acp.contentItem.data{/lang}</span></a></li>
			<li id="permissions"><a onclick="tabMenu.showSubTabMenu('permissions');"><span>{lang}moxeo.acp.contentItem.permissions{/lang}</span></a></li>
			{if $this->user->getPermission('admin.moxeo.isContentItemAdmin')}<li id="admins"><a onclick="tabMenu.showSubTabMenu('admins');"><span>{lang}moxeo.acp.contentItem.admins{/lang}</span></a></li>{/if}
			{if $additionalTabs|isset}{@$additionalTabs}{/if}
		</ul>
	</div>
	<div class="subTabMenu">
		<div class="containerHead"><div> </div></div>
	</div>

	<div class="border tabMenuContent hidden" id="data-content">
		<div class="container-1">
			<h3 class="subHeadline">{lang}moxeo.acp.contentItem.data{/lang}</h3>

			<fieldset>
				<legend>{lang}moxeo.acp.contentItem.contentItemType{/lang}</legend>
				<div class="formElement">
					<ul class="formOptions">
						<li><label><input onclick="if (IS_SAFARI) setContentItemType(0)" onfocus="setContentItemType(0)" type="radio" name="contentItemType" value="0" {if $contentItemType == 0}checked="checked" {/if}/> {lang}moxeo.acp.contentItem.contentItemType.0{/lang}</label></li>
						<li><label><input onclick="if (IS_SAFARI) setContentItemType(1)" onfocus="setContentItemType(1)" type="radio" name="contentItemType" value="1" {if $contentItemType == 1}checked="checked" {/if}/> {lang}moxeo.acp.contentItem.contentItemType.1{/lang}</label></li>
						<li><label><input onclick="if (IS_SAFARI) setContentItemType(2)" onfocus="setContentItemType(2)" type="radio" name="contentItemType" value="2" {if $contentItemType == 2}checked="checked" {/if}/> {lang}moxeo.acp.contentItem.contentItemType.2{/lang}</label></li>
						<li><label><input onclick="if (IS_SAFARI) setContentItemType(3)" onfocus="setContentItemType(3)" type="radio" name="contentItemType" value="3" {if $contentItemType == 3}checked="checked" {/if}/> {lang}moxeo.acp.contentItem.contentItemType.3{/lang}</label></li>
					</ul>
				</div>
			</fieldset>

			<fieldset>
				<legend>{lang}moxeo.acp.contentItem.classification{/lang}</legend>

				{if $contentItemOptions|count > 0}
					<div class="formElement" id="parentIDDiv">
						<div class="formFieldLabel">
							<label for="parentID">{lang}moxeo.acp.contentItem.parentID{/lang}</label>
						</div>
						<div class="formField">
							<select name="parentID" id="parentID">
								<option value="0"></option>
								{htmlOptions options=$contentItemOptions selected=$parentID disableEncoding=true}
							</select>
						</div>
						<div class="formFieldDesc hidden" id="parentIDHelpMessage">
							<p>{lang}moxeo.acp.contentItem.parentID.description{/lang}</p>
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('parentID');
					//]]></script>
				{/if}

				<div class="formElement" id="showOrderDiv">
					<div class="formFieldLabel">
						<label for="showOrder">{lang}moxeo.acp.contentItem.showOrder{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" name="showOrder" id="showOrder" value="{$showOrder}" />
					</div>
					<div class="formFieldDesc hidden" id="showOrderHelpMessage">
						{lang}moxeo.acp.contentItem.showOrder.description{/lang}
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('showOrder');
				//]]></script>

				<div class="formElement" id="invisibleDiv">
					<div class="formField">
						<label id="invisible"><input type="checkbox" name="invisible" value="1" {if $invisible}checked="checked" {/if}/> {lang}moxeo.acp.contentItem.invisible{/lang}</label>
					</div>
					<div class="formFieldDesc hidden" id="invisibleHelpMessage">
						<p>{lang}moxeo.acp.contentItem.invisible.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('invisible');
				//]]></script>

				{if $additionalClassificationFields|isset}{@$additionalClassificationFields}{/if}
			</fieldset>

			<fieldset>
				<legend>{lang}moxeo.acp.contentItem.data{/lang}</legend>

				<div class="formElement" id="languageIDDiv">
					<div class="formFieldLabel">
						<label for="languageID">{lang}moxeo.acp.contentItem.language{/lang}</label>
					</div>
					<div class="formField">
						<select name="languageID" id="languageID">
							{foreach from=$languages key=availableLanguageID item=languageCode}
								<option value="{@$availableLanguageID}"{if $availableLanguageID == $languageID} selected="selected"{/if}>{lang}wcf.global.language.{@$languageCode}{/lang}</option>
							{/foreach}
						</select>
					</div>
					<div class="formFieldDesc hidden" id="languageIDHelpMessage">
						{lang}moxeo.acp.contentItem.language.description{/lang}
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('languageID');
				//]]></script>

				<div class="formElement{if $errorField == 'title'} formError{/if}" id="titleDiv">
					<div class="formFieldLabel">
						<label for="title">{lang}moxeo.acp.contentItem.title{/lang}</label>
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
						<p>{lang}moxeo.acp.contentItem.title.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('title');
				//]]></script>

				<div class="formElement{if $errorField == 'contentItemAlias'} formError{/if}" id="contentItemAliasDiv">
					<div class="formFieldLabel">
						<label for="contentItemAlias">{lang}moxeo.acp.contentItem.contentItemAlias{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" id="contentItemAlias" name="contentItemAlias" value="{$contentItemAlias}" />
						{if $errorField == 'contentItemAlias'}
							<p class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
							</p>
						{/if}
					</div>
					<div class="formFieldDesc hidden" id="contentItemAliasHelpMessage">
						<p>{lang}moxeo.acp.contentItem.contentItemAlias.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('contentItemAlias');
				//]]></script>

				<div class="formElement" id="descriptionDiv">
					<div class="formFieldLabel">
						<label for="description">{lang}moxeo.acp.contentItem.description{/lang}</label>
					</div>
					<div class="formField">
						<textarea id="description" name="description" cols="40" rows="5">{$description}</textarea>
					</div>
					<div class="formFieldDesc hidden" id="descriptionHelpMessage">
						<p>{lang}moxeo.acp.contentItem.description.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('description');
				//]]></script>

				<div class="formElement{if $errorField == 'externalURL'} formError{/if}" id="externalURLDiv">
					<div class="formFieldLabel">
						<label for="externalURL">{lang}moxeo.acp.contentItem.externalURL{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" id="externalURL" name="externalURL" value="{$externalURL}" />
						{if $errorField == 'externalURL'}
							<p class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
							</p>
						{/if}
					</div>
					<div class="formFieldDesc hidden" id="externalURLHelpMessage">
						<p>{lang}moxeo.acp.contentItem.externalURL.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('externalURL');
				//]]></script>

				<div class="formElement" id="addSecurityTokenDiv">
					<div class="formField">
						<label id="addSecurityToken"><input type="checkbox" name="addSecurityToken" value="1" {if $addSecurityToken}checked="checked" {/if}/> {lang}moxeo.acp.contentItem.addSecurityToken{/lang}</label>
					</div>
					<div class="formFieldDesc hidden" id="addSecurityTokenHelpMessage">
						<p>{lang}moxeo.acp.contentItem.addSecurityToken.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('addSecurityToken');
				//]]></script>

				{if $additionalDataFields|isset}{@$additionalDataFields}{/if}
			</fieldset>

			<fieldset id="meta">
				<legend>{lang}moxeo.acp.contentItem.meta{/lang}</legend>

				<div class="formElement" id="pageTitleDiv">
					<div class="formFieldLabel">
						<label for="pageTitle">{lang}moxeo.acp.contentItem.pageTitle{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" id="pageTitle" name="pageTitle" value="{$contentItemPageTitle}" />
					</div>
					<div class="formFieldDesc hidden" id="pageTitleHelpMessage">
						<p>{lang}moxeo.acp.contentItem.pageTitle.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('pageTitle');
				//]]></script>

				<div class="formElement" id="metaDescriptionDiv">
					<div class="formFieldLabel">
						<label for="metaDescription">{lang}moxeo.acp.contentItem.metaDescription{/lang}</label>
					</div>
					<div class="formField">
						<textarea id="metaDescription" name="metaDescription" cols="40" rows="5">{$metaDescription}</textarea>
					</div>
					<div class="formFieldDesc hidden" id="metaDescriptionHelpMessage">
						<p>{lang}moxeo.acp.contentItem.metaDescription.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('metaDescription');
				//]]></script>

				<div class="formElement" id="metaKeywordsDiv">
					<div class="formFieldLabel">
						<label for="metaKeywords">{lang}moxeo.acp.contentItem.metaKeywords{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" id="metaKeywords" name="metaKeywords" value="{$metaKeywords}" />
					</div>
					<div class="formFieldDesc hidden" id="metaKeywordsHelpMessage">
						<p>{lang}moxeo.acp.contentItem.metaKeywords.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('metaKeywords');
				//]]></script>

				<div class="formElement" id="robotsDiv">
					<div class="formFieldLabel">
						<label for="robots">{lang}moxeo.acp.contentItem.robots{/lang}</label>
					</div>
					<div class="formField">
						<select name="robots" id="robots">
							<option value="index,follow"{if $robots == 'index,follow'} selected="selected"{/if}>index,follow</option>
							<option value="index,nofollow"{if $robots == 'index,nofollow'} selected="selected"{/if}>index,nofollow</option>
							<option value="noindex,follow"{if $robots == 'noindex,follow'} selected="selected"{/if}>noindex,follow</option>
							<option value="noindex,nofollow"{if $robots == 'noindex,nofollow'} selected="selected"{/if}>noindex,nofollow</option>
						</select>
					</div>
					<div class="formFieldDesc hidden" id="robotsHelpMessage">
						<p>{lang}moxeo.acp.contentItem.robots.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('robots');
				//]]></script>

				{if $additionalMetaFields|isset}{@$additionalMetaFields}{/if}
			</fieldset>

			<fieldset>
				<legend>{lang}moxeo.acp.contentItem.display{/lang}</legend>

				{if $themeLayoutOptions|count > 0}
					<div class="formElement" id="themeLayoutIDDiv">
						<div class="formFieldLabel">
							<label for="themeLayoutID">{lang}moxeo.acp.contentItem.themeLayoutID{/lang}</label>
						</div>
						<div class="formField">
							<select name="themeLayoutID" id="themeLayoutID">
								<option value="0"></option>
								{htmlOptions options=$themeLayoutOptions selected=$themeLayoutID}
							</select>
						</div>
						<div class="formFieldDesc hidden" id="themeLayoutIDHelpMessage">
							<p>{lang}moxeo.acp.contentItem.themeLayoutID.description{/lang}</p>
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('themeLayoutID');
					//]]></script>
				{/if}

				<div class="formElement" id="cssClassesDiv">
					<div class="formFieldLabel">
						<label for="cssClasses">{lang}moxeo.acp.contentItem.cssClasses{/lang}</label>
					</div>
					<div class="formField">
						<input type="text" class="inputText" id="cssClasses" name="cssClasses" value="{$cssClasses}" />
					</div>
					<div class="formFieldDesc hidden" id="cssClassesHelpMessage">
						{lang}moxeo.acp.contentItem.cssClasses.description{/lang}
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('cssClasses');
				//]]></script>

				{if $additionalDisplayFields|isset}{@$additionalDisplayFields}{/if}
			</fieldset>

			<fieldset id="publishing">
				<legend>{lang}moxeo.acp.contentItem.publishingTime{/lang}</legend>

				<div class="formGroup{if $errorField == 'publishingStartTime'} formError{/if}" id="publishingStartTimeDiv">
					<div class="formGroupLabel">
						<label>{lang}moxeo.acp.contentItem.publishingStartTime{/lang}</label>
					</div>
					<div class="formGroupField">
						<fieldset>
							<legend><label>{lang}moxeo.acp.contentItem.publishingStartTime{/lang}</label></legend>

							<div class="formField">
								<div class="floatedElement">
									<label for="publishingStartTimeDay">{lang}wcf.global.date.day{/lang}</label>
									{htmlOptions options=$dayOptions selected=$publishingStartTimeDay id=publishingStartTimeDay name=publishingStartTimeDay}
								</div>

								<div class="floatedElement">
									<label for="publishingStartTimeMonth">{lang}wcf.global.date.month{/lang}</label>
									{htmlOptions options=$monthOptions selected=$publishingStartTimeMonth id=publishingStartTimeMonth name=publishingStartTimeMonth}
								</div>

								<div class="floatedElement">
									<label for="publishingStartTimeYear">{lang}wcf.global.date.year{/lang}</label>
									<input id="publishingStartTimeYear" class="inputText fourDigitInput" type="text" name="publishingStartTimeYear" value="{@$publishingStartTimeYear}" maxlength="4" />
								</div>

								<div class="floatedElement">
									<label for="publishingStartTimeHour">{lang}wcf.global.date.hour{/lang}</label>
									{htmlOptions options=$hourOptions selected=$publishingStartTimeHour id=publishingStartTimeHour name=publishingStartTimeHour} :
								</div>

								<div class="floatedElement">
									<label for="publishingStartTimeMinutes">{lang}wcf.global.date.minutes{/lang}</label>
									{htmlOptions options=$minuteOptions selected=$publishingStartTimeMinutes id=publishingStartTimeMinutes name=publishingStartTimeMinutes}
								</div>

								<div class="floatedElement">
									<a id="publishingStartTimeButton"><img src="{@RELATIVE_WCF_DIR}icon/datePickerOptionsM.png" alt="" /></a>
									<div id="publishingStartTimeCalendar" class="inlineCalendar"></div>
									<script type="text/javascript">
										//<![CDATA[
										calendar.init('publishingStartTime');
										//]]>
									</script>
								</div>

								{if $errorField == 'publishingStartTime'}
									<p class="floatedElement innerError">
										{if $errorType == 'invalid'}{lang}moxeo.acp.contentItem.publishingStartTime.error.invalid{/lang}{/if}
									</p>
								{/if}
							</div>

							<div class="formFieldDesc hidden" id="publishingStartTimeHelpMessage">
								<p>{lang}moxeo.acp.contentItem.publishingStartTime.description{/lang}</p>
							</div>
						</fieldset>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('publishingStartTime');
				//]]></script>

				<div class="formGroup{if $errorField == 'publishingEndTime'} formError{/if}" id="publishingEndTimeDiv">
					<div class="formGroupLabel">
						<label>{lang}moxeo.acp.contentItem.publishingEndTime{/lang}</label>
					</div>
					<div class="formGroupField">
						<fieldset>
							<legend><label>{lang}moxeo.acp.contentItem.publishingEndTime{/lang}</label></legend>

							<div class="formField">
								<div class="floatedElement">
									<label for="publishingEndTimeDay">{lang}wcf.global.date.day{/lang}</label>
									{htmlOptions options=$dayOptions selected=$publishingEndTimeDay id=publishingEndTimeDay name=publishingEndTimeDay}
								</div>

								<div class="floatedElement">
									<label for="publishingEndTimeMonth">{lang}wcf.global.date.month{/lang}</label>
									{htmlOptions options=$monthOptions selected=$publishingEndTimeMonth id=publishingEndTimeMonth name=publishingEndTimeMonth}
								</div>

								<div class="floatedElement">
									<label for="publishingEndTimeYear">{lang}wcf.global.date.year{/lang}</label>
									<input id="publishingEndTimeYear" class="inputText fourDigitInput" type="text" name="publishingEndTimeYear" value="{@$publishingEndTimeYear}" maxlength="4" />
								</div>

								<div class="floatedElement">
									<label for="publishingEndTimeHour">{lang}wcf.global.date.hour{/lang}</label>
									{htmlOptions options=$hourOptions selected=$publishingEndTimeHour id=publishingEndTimeHour name=publishingEndTimeHour} :
								</div>

								<div class="floatedElement">
									<label for="publishingEndTimeMinutes">{lang}wcf.global.date.minutes{/lang}</label>
									{htmlOptions options=$minuteOptions selected=$publishingEndTimeMinutes id=publishingEndTimeMinutes name=publishingEndTimeMinutes}
								</div>

								<div class="floatedElement">
									<a id="publishingEndTimeButton"><img src="{@RELATIVE_WCF_DIR}icon/datePickerOptionsM.png" alt="" /></a>
									<div id="publishingEndTimeCalendar" class="inlineCalendar"></div>
									<script type="text/javascript">
										//<![CDATA[
										calendar.init('publishingEndTime');
										//]]>
									</script>
								</div>

								{if $errorField == 'publishingEndTime'}
									<p class="floatedElement innerError">
										{if $errorType == 'invalid'}{lang}moxeo.acp.contentItem.publishingEndTime.error.invalid{/lang}{/if}
									</p>
								{/if}
							</div>

							<div class="formFieldDesc hidden" id="publishingEndTimeHelpMessage">
								<p>{lang}moxeo.acp.contentItem.publishingEndTime.description{/lang}</p>
							</div>
						</fieldset>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('publishingEndTime');
				//]]></script>
			</fieldset>
		</div>
	</div>

	<div class="border tabMenuContent hidden" id="permissions-content">
		<div class="container-1">
			<h3 class="subHeadline">{lang}moxeo.acp.contentItem.permissions{/lang}</h3>

			<fieldset id="permissions">
				<legend>{lang}moxeo.acp.contentItem.permissions{/lang}</legend>

				<div class="formElement">
					<div class="formFieldLabel" id="permissionTitle">
						{lang}moxeo.acp.contentItem.permissions.title{/lang}
					</div>
					<div class="formField"><div id="permission" class="accessRights"></div></div>
				</div>
				<div class="formElement">
					<div class="formField">
						<input id="permissionAddInput" type="text" name="" value="" class="inputText accessRightsInput" />
						<script type="text/javascript">
							//<![CDATA[
							suggestion.setSource('index.php?page=PermissionsObjectsSuggest{@SID_ARG_2ND_NOT_ENCODED}');
							suggestion.enableIcon(true);
							suggestion.init('permissionAddInput');
							//]]>
						</script>
						<input id="permissionAddButton" type="button" value="{lang}moxeo.acp.contentItem.permissions.add{/lang}" />
					</div>
				</div>

				<div class="formElement" style="display: none;">
					<div class="formFieldLabel">
						<div id="permissionSettingsTitle" class="accessRightsTitle"></div>
					</div>
					<div class="formField">
						<div id="permissionHeader" class="accessRightsHeader">
							<span class="deny">{lang}moxeo.acp.contentItem.permissions.deny{/lang}</span>
							<span class="allow">{lang}moxeo.acp.contentItem.permissions.allow{/lang}</span>
						</div>
						<div id="permissionSettings" class="accessRights"></div>
					</div>
				</div>

				{if $additionalPermissionFields|isset}{@$additionalPermissionFields}{/if}
			</fieldset>
		</div>
	</div>

	{if $this->user->getPermission('admin.moxeo.isContentItemAdmin')}
		<div class="border tabMenuContent hidden" id="admins-content">
			<div class="container-1">
				<h3 class="subHeadline">{lang}moxeo.acp.contentItem.admins{/lang}</h3>

				<fieldset id="admins">
					<legend>{lang}moxeo.acp.contentItem.admins{/lang}</legend>

					<div class="formElement">
						<div class="formFieldLabel" id="adminTitle">
							{lang}moxeo.acp.contentItem.permissions.title{/lang}
						</div>
						<div class="formField"><div id="admin" class="accessRights"></div></div>
					</div>
					<div class="formElement">
						<div class="formField">
							<input id="adminAddInput" type="text" name="" value="" class="inputText accessRightsInput" />
							<script type="text/javascript">
								//<![CDATA[
								suggestion.init('adminAddInput');
								//]]>
							</script>
							<input id="adminAddButton" type="button" value="{lang}moxeo.acp.contentItem.permissions.add{/lang}" />
						</div>
					</div>

					<div class="formElement" style="display: none;">
						<div class="formFieldLabel">
							<div id="adminSettingsTitle" class="accessRightsTitle"></div>
						</div>
						<div class="formField">
							<div id="adminHeader" class="accessRightsHeader">
								<span class="deny">{lang}moxeo.acp.contentItem.permissions.deny{/lang}</span>
								<span class="allow">{lang}moxeo.acp.contentItem.permissions.allow{/lang}</span>
							</div>
							<div id="adminSettings" class="accessRights"></div>
						</div>
					</div>

					{if $additionalAdminFields|isset}{@$additionalAdminFields}{/if}
				</fieldset>
			</div>
		</div>
	{/if}

	{if $additionalFields|isset}{@$additionalFields}{/if}

	<div class="formSubmit">
		<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
 		{@SID_INPUT_TAG}
 		{if $contentItemID|isset}<input type="hidden" name="contentItemID" value="{@$contentItemID}" />{/if}
 	</div>
</form>

{include file='footer'}