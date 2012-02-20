{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_MOXEO_DIR}icon/newsArchiveL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}moxeo.acp.news.archive.view{/lang}</h2>
	</div>
</div>

{if $deletedNewsArchiveID}
	<p class="success">{lang}moxeo.acp.news.archive.delete.success{/lang}</p>
{/if}

<div class="contentHeader">
	{pages print=true assign=pagesLinks link="index.php?page=NewsArchiveList&pageNo=%d&sortField=$sortField&sortOrder=$sortOrder&packageID="|concat:PACKAGE_ID:SID_ARG_2ND_NOT_ENCODED}

	{if $this->user->getPermission('admin.moxeo.canAddNewsArchive')}
		<div class="largeButtons">
			<ul>
				<li><a href="index.php?form=NewsArchiveAdd&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_MOXEO_DIR}icon/newsArchiveAddM.png" alt="" title="{lang}moxeo.acp.news.archive.add{/lang}" /> <span>{lang}moxeo.acp.news.archive.add{/lang}</span></a></li>
			</ul>
		</div>
	{/if}
</div>

{if $newsArchives|count}
	<div class="border titleBarPanel">
		<div class="containerHead"><h3>{lang}moxeo.acp.news.archive.view.count{/lang}</h3></div>
	</div>
	<div class="border borderMarginRemove">
		<table class="tableList">
			<thead>
				<tr class="tableHead">
					<th class="columnNewsArchiveID{if $sortField == 'newsArchiveID'} active{/if}" colspan="2"><div><a href="index.php?page=NewsArchiveList&amp;pageNo={@$pageNo}&amp;sortField=newsArchiveID&amp;sortOrder={if $sortField == 'newsArchiveID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.news.archive.newsArchiveID{/lang}{if $sortField == 'newsArchiveID'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnTitle{if $sortField == 'title'} active{/if}"><div><a href="index.php?page=NewsArchiveList&amp;pageNo={@$pageNo}&amp;sortField=title&amp;sortOrder={if $sortField == 'title' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.news.archive.title{/lang}{if $sortField == 'title'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnNewsItems{if $sortField == 'newsItems'} active{/if}"><div><a href="index.php?page=NewsArchiveList&amp;pageNo={@$pageNo}&amp;sortField=newsItems&amp;sortOrder={if $sortField == 'newsItems' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.news.archive.newsItems{/lang}{if $sortField == 'newsItems'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>

					{if $additionalColumnHeads|isset}{@$additionalColumnHeads}{/if}
				</tr>
			</thead>
			<tbody id="commentList">
				{foreach from=$newsArchives item=newsArchive}
					<tr class="{cycle values="container-1,container-2"}">
						<td class="columnIcon">
							{if $this->user->getPermission('admin.moxeo.canEditNewsArchive')}
								<a href="index.php?form=NewsArchiveEdit&amp;newsArchiveID={@$newsArchive->newsArchiveID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/editS.png" alt="" title="{lang}moxeo.acp.news.archive.edit{/lang}" /></a>
							{else}
								<img src="{@RELATIVE_WCF_DIR}icon/editDisabledS.png" alt="" title="{lang}moxeo.acp.news.archive.edit{/lang}" />
							{/if}
							{if $this->user->getPermission('admin.moxeo.canDeleteNewsArchive')}
								<a onclick="return confirm('{lang}moxeo.acp.news.archive.delete.sure{/lang}')" href="index.php?action=NewsArchiveDelete&amp;newsArchiveID={@$newsArchive->newsArchiveID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" title="{lang}moxeo.acp.news.archive.delete{/lang}" /></a>
							{else}
								<img src="{@RELATIVE_WCF_DIR}icon/deleteDisabledS.png" alt="" title="{lang}moxeo.acp.news.archive.delete{/lang}" />
							{/if}

							{if $additionalButtons.$newsArchive->newsArchiveID|isset}{@$additionalButtons.$newsArchive->newsArchiveID}{/if}
						</td>
						<td class="columnNewsArchiveID columnID">{@$newsArchive->newsArchiveID}</td>
						<td class="columnTitle columnText">
							{if $this->user->getPermission('admin.moxeo.canEditNewsArchive')}
								<a href="index.php?form=NewsArchiveEdit&amp;newsArchiveID={@$newsArchive->newsArchiveID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{$newsArchive->title}</a>
							{else}
								{$newsArchive->title}
							{/if}
						</td>
						<td class="columnNewsItems columnNumbers">{@$newsArchive->newsItems}</td>

						{if $additionalColumns.$newsArchive->newsArchiveID|isset}{@$additionalColumns.$newsArchive->newsArchiveID}{/if}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>

	<div class="contentFooter">
		{@$pagesLinks}

		{if $this->user->getPermission('admin.moxeo.canAddNewsArchive')}
			<div class="largeButtons">
				<ul>
					<li><a href="index.php?form=NewsArchiveAdd&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_MOXEO_DIR}icon/newsArchiveAddM.png" alt="" title="{lang}moxeo.acp.news.archive.add{/lang}" /> <span>{lang}moxeo.acp.news.archive.add{/lang}</span></a></li>
				</ul>
			</div>
		{/if}
	</div>
{else}
	<div class="border content">
		<div class="container-1">
			<p>{lang}moxeo.acp.news.archive.view.count.noNewsArchives{/lang}</p>
		</div>
	</div>
{/if}

{include file='footer'}