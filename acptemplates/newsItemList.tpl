{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WSIS_DIR}icon/newsItemL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wsis.acp.news.item.view{/lang}</h2>
		{if $newsArchiveID}<p>{$newsArchive->title}</p>{/if}
	</div>
</div>

{if $deletedNewsItemID}
	<p class="success">{lang}wsis.acp.news.item.delete.success{/lang}</p>	
{/if}

{if $newsArchiveOptions|count}
	<fieldset>
		<legend>{lang}wsis.acp.news.archive{/lang}</legend>
		<div class="formElement" id="newsArchiveDiv">
			<div class="formFieldLabel">
				<label for="newsArchiveChange">{lang}wsis.acp.news.archive{/lang}</label>
			</div>
			<div class="formField">
				<select id="newsArchiveChange" onchange="document.location.href=fixURL('index.php?page=NewsItemList&amp;newsArchiveID='+this.options[this.selectedIndex].value+'&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}')">
					<option value="0"></option>
					{htmloptions options=$newsArchiveOptions selected=$newsArchiveID disableEncoding=true}
				</select>
			</div>
			<div class="formFieldDesc hidden" id="newsArchiveHelpMessage">
				{lang}wsis.acp.news.archive.description{/lang}
			</div>
		</div>
		<script type="text/javascript">//<![CDATA[
			inlineHelp.register('newsArchive');
		//]]></script>
	</fieldset>
{else}
	<div class="border content">
		<div class="container-1">
			<p>{lang}wsis.acp.news.item.view.count.noNewsArchives{/lang}</p>
		</div>
	</div>
{/if}

{if $newsArchiveID}
	<div class="contentHeader">
		{pages print=true assign=pagesLinks link="index.php?page=NewsItemList&newsArchiveID=$newsArchiveID&pageNo=%d&sortField=$sortField&sortOrder=$sortOrder&packageID="|concat:PACKAGE_ID:SID_ARG_2ND_NOT_ENCODED}
		{if $this->user->getPermission('admin.site.canAddNewsItem')}
			<div class="largeButtons">
				<ul><li><a href="index.php?form=NewsItemAdd&amp;newsArchiveID={@$newsArchiveID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WSIS_DIR}icon/newsItemAddM.png" alt="" title="{lang}wsis.acp.news.item.add{/lang}" /> <span>{lang}wsis.acp.news.item.add{/lang}</span></a></li></ul>
			</div>
		{/if}
	</div>
	
	{if $newsItems|count}
		<div class="border titleBarPanel">
			<div class="containerHead"><h3>{lang}wsis.acp.news.item.view.count{/lang}</h3></div>
		</div>
		<div class="border borderMarginRemove">
			<table class="tableList">
				<thead>
					<tr class="tableHead">
						<th class="columnNewsItemID{if $sortField == 'newsItemID'} active{/if}" colspan="2"><div><a href="index.php?page=NewsItemList&amp;newsArchiveID={@$newsArchiveID}&amp;pageNo={@$pageNo}&amp;sortField=newsItemID&amp;sortOrder={if $sortField == 'newsItemID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}wsis.acp.news.item.newsItemID{/lang}{if $sortField == 'newsItemID'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
						<th class="columnNewsItemTitle{if $sortField == 'title'} active{/if}"><div><a href="index.php?page=NewsItemList&amp;newsArchiveID={@$newsArchiveID}&amp;pageNo={@$pageNo}&amp;sortField=title&amp;sortOrder={if $sortField == 'title' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}wsis.acp.news.item.title{/lang}{if $sortField == 'title'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
						<th class="columnTime{if $sortField == 'time'} active{/if}"><div><a href="index.php?page=NewsItemList&amp;newsArchiveID={@$newsArchiveID}&amp;pageNo={@$pageNo}&amp;sortField=time&amp;sortOrder={if $sortField == 'time' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}wsis.acp.news.item.time{/lang}{if $sortField == 'time'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
						
						{if $additionalColumnHeads|isset}{@$additionalColumnHeads}{/if}
					</tr>
				</thead>
				<tbody id="newsItemList">
					{foreach from=$newsItems item=newsItem}
						<tr class="{cycle values="container-1,container-2"}">
							<td class="columnIcon">
								{if $this->user->getPermission('admin.site.canEnableNewsItem')}
									{if $newsItem->enabled}
										<a href="index.php?action=NewsItemDisable&amp;newsItemID={@$newsItem->newsItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/enabledS.png" alt="" title="{lang}wsis.acp.news.item.disable{/lang}" /></a>
									{else}
										<a href="index.php?action=NewsItemEnable&amp;newsItemID={@$newsItem->newsItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/disabledS.png" alt="" title="{lang}wsis.acp.news.item.enable{/lang}" /></a>
									{/if}
								{else}
									{if $newsItem->enabled}
										<img src="{@RELATIVE_WCF_DIR}icon/enabledDisabledS.png" alt="" title="{lang}wsis.acp.news.item.disable{/lang}" />
									{else}
										<img src="{@RELATIVE_WCF_DIR}icon/disabledDisabledS.png" alt="" title="{lang}wsis.acp.news.item.enable{/lang}" />
									{/if}
								{/if}
								{if $this->user->getPermission('admin.site.canEditNewsItem')}
									<a href="index.php?form=NewsItemEdit&amp;newsItemID={@$newsItem->newsItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/editS.png" alt="" title="{lang}wsis.acp.news.item.edit{/lang}" /></a>
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/editDisabledS.png" alt="" title="{lang}wsis.acp.news.item.edit{/lang}" />
								{/if}
								{if $this->user->getPermission('admin.site.canDeleteNewsItem')}
									<a onclick="return confirm('{lang}wsis.acp.news.item.delete.sure{/lang}')" href="index.php?action=NewsItemDelete&amp;newsItemID={@$newsItem->newsItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" title="{lang}wsis.acp.news.item.delete{/lang}" /></a>
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/deleteDisabledS.png" alt="" title="{lang}wsis.acp.news.item.delete{/lang}" />
								{/if}
								
								{if $additionalButtons.$newsItem->newsItemID|isset}{@$additionalButtons.$newsItem->newsItemID}{/if}
							</td>
							<td class="columnNewsItemID columnID">{@$newsItem->newsItemID}</td>
							<td class="columnNewsItemTitle columnText">
								{if $this->user->getPermission('admin.site.canEditNewsItem')}
									<a href="index.php?form=NewsItemEdit&amp;newsItemID={@$newsItem->newsItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{$newsItem->title}</a>
								{else}
									{$newsItem->title}
								{/if}
							</td>
							<td class="columnTime columnText">
								{@$newsItem->time|time}
							</td>
							
							{if $additionalColumns.$newsItem->newsItemID|isset}{@$additionalColumns.$newsItem->newsItemID}{/if}
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
		
		<div class="contentFooter">
			{@$pagesLinks}
			
			{if $this->user->getPermission('admin.site.canAddNewsItem')}
				<div class="largeButtons">
					<ul><li><a href="index.php?form=NewsItemAdd&amp;newsArchiveID={@$newsArchiveID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WSIS_DIR}icon/newsItemAddM.png" alt="" title="{lang}wsis.acp.news.item.add{/lang}" /> <span>{lang}wsis.acp.news.item.add{/lang}</span></a></li></ul>
				</div>
			{/if}
		</div>
	{else}
		<div class="border content">
			<div class="container-1">
				<p>{lang}wsis.acp.news.item.view.count.noNewsItems{/lang}</p>
			</div>
		</div>
	{/if}
{/if}

{include file='footer'}