{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WSIS_DIR}icon/newsItem{@$action|ucfirst}L.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wsis.acp.news.item.{@$action}{/lang}</h2>
	</div>
</div>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}wsis.acp.news.item.{@$action}.success{/lang}</p>	
{/if}

<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li><a href="index.php?page=NewsItemList{if $newsArchiveID}&amp;newsArchiveID={@$newsArchiveID}{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wsis.acp.menu.link.content.newsItem.view{/lang}"><img src="{@RELATIVE_WSIS_DIR}icon/newsItemM.png" alt="" /> <span>{lang}wsis.acp.menu.link.content.newsItem.view{/lang}</span></a></li>
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>

{if $action == 'add'}
	{if $newsArchiveOptions|count}
		<fieldset>
			<legend>{lang}wsis.acp.news.archive{/lang}</legend>
			<div class="formElement" id="newsArchiveIDDiv">
				<div class="formFieldLabel">
					<label for="newsArchiveChange">{lang}wsis.acp.news.item.newsArchiveID{/lang}</label>
				</div>
				<div class="formField">
					<select id="newsArchiveChange" onchange="document.location.href=fixURL('index.php?form=NewsItemAdd&amp;newsArchiveID='+this.options[this.selectedIndex].value+'&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}')">
						<option value="0"></option>
						{htmloptions options=$newsArchiveOptions selected=$newsArchiveID disableEncoding=true}
					</select>
				</div>
				<div class="formFieldDesc hidden" id="newsArchiveIDHelpMessage">
					{lang}wsis.acp.news.item.newsArchiveID.description{/lang}
				</div>
			</div>
			<script type="text/javascript">//<![CDATA[
				inlineHelp.register('newsArchiveID');
			//]]></script>
		</fieldset>
	{else}
		<div class="border content">
			<div class="container-1">
				<p>{lang}wsis.acp.news.item.view.count.noNewsArchives{/lang}</p>
			</div>
		</div>
	{/if}
{/if}

{if $newsArchiveID || $action == 'edit'}
	<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/Calendar.class.js"></script>
	<script type="text/javascript">
		//<![CDATA[	
		var calendar = new Calendar('{$monthList}', '{$weekdayList}', {@$startOfWeek});
		//]]>
	</script>
	
	<form method="post" action="index.php?form=NewsItem{@$action|ucfirst}">
		<div class="border content">
			<div class="container-1">					
				<fieldset>
					<legend>{lang}wsis.acp.news.item.data{/lang}</legend>
					
					<div class="formElement{if $errorField == 'username'} formError{/if}" id="usernameDiv">
						<div class="formFieldLabel">
							<label for="username">{lang}wsis.acp.news.item.username{/lang}</label>
						</div>
						<div class="formField">
							<input type="text" class="inputText" id="username" name="username" value="{$username}" />
							{if $errorField == 'username'}
								<p class="innerError">
									{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
									{if $errorType == 'notFound'}{lang}wcf.user.error.username.notFound{/lang}{/if}
								</p>
							{/if}
						</div>
						<div class="formFieldDesc hidden" id="usernameHelpMessage">
							<p>{lang}wsis.acp.news.item.username.description{/lang}</p>
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('username');
					//]]></script>
					
					<div class="formElement{if $errorField == 'title'} formError{/if}" id="titleDiv">
						<div class="formFieldLabel">
							<label for="title">{lang}wsis.acp.news.item.title{/lang}</label>
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
							<p>{lang}wsis.acp.news.item.title.description{/lang}</p>
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('title');
					//]]></script>
					
					<div class="formElement{if $errorField == 'newsItemAlias'} formError{/if}" id="newsItemAliasDiv">
						<div class="formFieldLabel">
							<label for="newsItemAlias">{lang}wsis.acp.news.item.newsItemAlias{/lang}</label>
						</div>
						<div class="formField">
							<input type="text" class="inputText" id="newsItemAlias" name="newsItemAlias" value="{$newsItemAlias}" />
							{if $errorField == 'newsItemAlias'}
								<p class="innerError">
									{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
								</p>
							{/if}
						</div>
						<div class="formFieldDesc hidden" id="newsItemAliasHelpMessage">
							<p>{lang}wsis.acp.news.item.newsItemAlias.description{/lang}</p>
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('newsItemAlias');
					//]]></script>
					
					<div class="formElement{if $errorField == 'teaser'} formError{/if}" id="teaserDiv">
						<div class="formFieldLabel">
							<label for="teaser">{lang}wsis.acp.news.item.teaser{/lang}</label>
						</div>
						<div class="formField">
							<textarea id="teaser" name="teaser" cols="40" rows="5">{$teaser}</textarea>
							{if $errorField == 'teaser'}
								<p class="innerError">
									{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
								</p>
							{/if}
						</div>
						<div class="formFieldDesc hidden" id="teaserHelpMessage">
							<p>{lang}wsis.acp.news.item.teaser.description{/lang}</p>
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('teaser');
					//]]></script>
					
					<div class="formElement{if $errorField == 'text'} formError{/if}" id="textDiv">
						<div class="formFieldLabel">
							<label for="text">{lang}wsis.acp.news.item.text{/lang}</label>
						</div>
						<div class="formField">
							<textarea id="text" name="text" cols="40" rows="10">{$text}</textarea>
							{if $errorField == 'text'}
								<p class="innerError">
									{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
								</p>
							{/if}
						</div>
						<div class="formFieldDesc hidden" id="textHelpMessage">
							<p>{lang}wsis.acp.news.item.text.description{/lang}</p>
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('text');
					//]]></script>
					
					{if $additionalDataFields|isset}{@$additionalDataFields}{/if}
				</fieldset>
				
				<fieldset>
					<legend>{lang}wsis.acp.news.item.display{/lang}</legend>
					
					<div class="formElement" id="cssIDDiv">
						<div class="formFieldLabel">
							<label for="cssID">{lang}wsis.acp.news.item.cssID{/lang}</label>
						</div>
						<div class="formField">
							<input type="text" class="inputText" id="cssID" name="cssID" value="{$cssID}" />
						</div>
						<div class="formFieldDesc hidden" id="cssIDHelpMessage">
							{lang}wsis.acp.news.item.cssID.description{/lang}
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('cssID');
					//]]></script>
					
					<div class="formElement" id="cssClassesDiv">
						<div class="formFieldLabel">
							<label for="cssClasses">{lang}wsis.acp.news.item.cssClasses{/lang}</label>
						</div>
						<div class="formField">
							<input type="text" class="inputText" id="cssClasses" name="cssClasses" value="{$cssClasses}" />
						</div>
						<div class="formFieldDesc hidden" id="cssClassesHelpMessage">
							{lang}wsis.acp.news.item.cssClasses.description{/lang}
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('cssClasses');
					//]]></script>
					
					{if $additionalDisplayFields|isset}{@$additionalDisplayFields}{/if}
				</fieldset>
				
				<fieldset>
					<legend>{lang}wsis.acp.news.item.publishingTime{/lang}</legend>
					
					<div class="formGroup{if $errorField == 'publishingStartTime'} formError{/if}" id="publishingStartTimeDiv">
						<div class="formGroupLabel">
							<label>{lang}wsis.acp.news.item.publishingStartTime{/lang}</label>
						</div>
						<div class="formGroupField">
							<fieldset>
								<legend><label>{lang}wsis.acp.news.item.publishingStartTime{/lang}</label></legend>
					
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
											{if $errorType == 'invalid'}{lang}wsis.acp.news.item.publishingStartTime.error.invalid{/lang}{/if}
										</p>
									{/if}
								</div>
								
								<div class="formFieldDesc hidden" id="publishingStartTimeHelpMessage">
									<p>{lang}wsis.acp.news.item.publishingStartTime.description{/lang}</p>
								</div>
							</fieldset>
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('publishingStartTime');
					//]]></script>
					
					<div class="formGroup{if $errorField == 'publishingEndTime'} formError{/if}" id="publishingEndTimeDiv">
						<div class="formGroupLabel">
							<label>{lang}wsis.acp.news.item.publishingEndTime{/lang}</label>
						</div>
						<div class="formGroupField">
							<fieldset>
								<legend><label>{lang}wsis.acp.news.item.publishingEndTime{/lang}</label></legend>
								
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
											{if $errorType == 'invalid'}{lang}wsis.acp.news.item.publishingEndTime.error.invalid{/lang}{/if}
										</p>
									{/if}
								</div>
								
								<div class="formFieldDesc hidden" id="publishingEndTimeHelpMessage">
									<p>{lang}wsis.acp.news.item.publishingEndTime.description{/lang}</p>
								</div>
							</fieldset>
						</div>
					</div>
					<script type="text/javascript">//<![CDATA[
						inlineHelp.register('publishingEndTime');
					//]]></script>
				</fieldset>
				
				{if $additionalFields|isset}{@$additionalFields}{/if}
			</div>
		</div>
		
		<div class="formSubmit">
			<input type="submit" name="send" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
			<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
			<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
	 		{@SID_INPUT_TAG}
	 		{if $newsArchiveID}<input type="hidden" name="newsArchiveID" value="{@$newsArchiveID}" />{/if}
	 		{if $newsItemID|isset}<input type="hidden" name="newsItemID" value="{@$newsItemID}" />{/if}
	 	</div>
	</form>
{/if}

{include file='footer'}