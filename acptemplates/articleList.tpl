{include file='header'}
<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/ItemListEditor.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe("dom:loaded", function() {
		var articleList = $('articleList');
		if (articleList) {
			articleList.addClassName('dragable');

			Sortable.create(articleList, {
				tag: 'div',
				onUpdate: function(list) {
					var rows = list.select('.message');
					var newShowOrder = 0;
					rows.each(function(row, i) {
					    	row.firstDescendant().removeClassName('container-1').removeClassName('container-2');
						row.firstDescendant().addClassName('container-' + (i % 2 == 0 ? '1' : '2'));
						newShowOrder = i + {@$startIndex} - 1;
						new Ajax.Request('index.php?action=ArticleSort&articleID='+row.id.gsub('articleRow_', '')+SID_ARG_2ND, { method: 'post', parameters: { showOrder: newShowOrder } } );
					});
				}
			});
		}
	});
	//]]>
</script>

{if $contentItemID}
	<ul class="breadCrumbs">
		<li><a href="index.php?page=ArticleList{@SID_ARG_2ND}"><span>{lang}moxeo.acp.article.view{/lang}</span></a> &raquo;</li>
	</ul>
{/if}
<div class="mainHeadline">
	<img src="{@RELATIVE_MOXEO_DIR}icon/articleL.png" alt="" />
	<div class="headlineContainer">
		<h2>{if $contentItemID}{$contentItem->title}{else}{lang}moxeo.acp.article.view{/lang}{/if}</h2>
	</div>
</div>

{if $deletedArticleID}
	<p class="success">{lang}moxeo.acp.article.delete.success{/lang}</p>
{/if}

{if $contentItemID}
	<div class="contentHeader">
		{pages print=true assign=pagesLinks link="index.php?page=ArticleList&contentItemID=$contentItemID&pageNo=%d&packageID="|concat:PACKAGE_ID:SID_ARG_2ND_NOT_ENCODED}
		{if $this->user->getPermission('admin.moxeo.canAddArticle')}
			<div class="largeButtons">
				<ul>
					<li><a href="index.php?form=ArticleAdd&amp;contentItemID={@$contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_MOXEO_DIR}icon/articleAddM.png" alt="" title="{lang}moxeo.acp.article.add{/lang}" /> <span>{lang}moxeo.acp.article.add{/lang}</span></a></li>
				</ul>
			</div>
		{/if}
	</div>

	{if $articles|count}
		<div id="articleList">
			{foreach from=$articles item=article}
				<div class="message content" id="articleRow_{@$article->articleID}">
					<div class="messageInner container-{cycle name='articles' values='1,2'}">
						<h3 class="subHeadline">
							{if $this->user->getPermission('admin.moxeo.canEditArticle')}
								<a href="index.php?page=ArticleSectionList&amp;articleID={@$article->articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{$article->title}</a>
							{else}
								{$article->title}
							{/if}
						</h3>

						<div class="messageBody">
							<div class="formElement">
								<div class="formFieldLabel">
									<label>{lang}moxeo.acp.article.themeModulePosition{/lang}</label>
								</div>
								<div class="formField">
									<span>{lang}wcf.theme.module.position.{@$article->themeModulePosition}{/lang}</span>
								</div>
							</div>
							{if $this->user->getPermission('admin.moxeo.canEditArticle')}
								<div class="formElement">
									<div class="formFieldLabel">
										<label>{lang}moxeo.acp.article.articleSections{/lang}</label>
									</div>
									<div class="formField">
										<a href="index.php?page=ArticleSectionList&amp;articleID={@$article->articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{@$article->articleSections}</a>
									</div>
								</div>
							{/if}
						</div>

						<div class="messageFooter">
							<div class="smallButtons">
								<ul>
									<li class="extraButton"><a href="#top" title="{lang}wcf.global.scrollUp{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/upS.png" alt="{lang}wcf.global.scrollUp{/lang}" /></a></li>
									{if $this->user->getPermission('admin.moxeo.canDeleteArticle')}
								    		<li><a onclick="return confirm('{lang}moxeo.acp.article.delete.sure{/lang}')" href="index.php?action=ArticleDelete&amp;articleID={@$article->articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.global.button.delete{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" /> <span>{lang}wcf.global.button.delete{/lang}</span></a></li>
									{/if}
									{if $this->user->getPermission('admin.moxeo.canEditArticle')}
										<li><a href="index.php?form=ArticleEdit&amp;articleID={@$article->articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.global.button.edit{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/editS.png" alt="" /> <span>{lang}wcf.global.button.edit{/lang}</span></a></li>
										<li><a href="index.php?page=ArticleSectionList&amp;articleID={@$article->articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}moxeo.acp.article.manageSections{/lang}"><img src="{@RELATIVE_MOXEO_DIR}icon/articleSectionS.png" alt="" /> <span>{lang}moxeo.acp.article.sections{/lang}</span></a></li>
									{/if}
								</ul>
							</div>
						</div>
					</div>
				</div>
			{/foreach}
		</div>
		{*<div class="border titleBarPanel">
			<div class="containerHead"><h3>{lang}moxeo.acp.article.view.count{/lang}</h3></div>
		</div>
		<div class="border borderMarginRemove">
			<table class="tableList">
				<thead>
					<tr class="tableHead">
						<th class="columnArticleID{if $sortField == 'articleID'} active{/if}" colspan="2"><div><a href="index.php?page=ArticleList&amp;contentItemID={@$contentItemID}&amp;pageNo={@$pageNo}&amp;sortField=articleID&amp;sortOrder={if $sortField == 'articleID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.article.articleID{/lang}{if $sortField == 'articleID'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
						<th class="columnTitle{if $sortField == 'title'} active{/if}"><div><a href="index.php?page=ArticleList&amp;contentItemID={@$contentItemID}&amp;pageNo={@$pageNo}&amp;sortField=title&amp;sortOrder={if $sortField == 'title' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.article.title{/lang}{if $sortField == 'title'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
						<th class="columnArticleSections{if $sortField == 'articleSections'} active{/if}"><div><a href="index.php?page=ArticleList&amp;contentItemID={@$contentItemID}&amp;pageNo={@$pageNo}&amp;sortField=articleSections&amp;sortOrder={if $sortField == 'articleSections' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.article.articleSections{/lang}{if $sortField == 'articleSections'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
						<th class="columnThemeModulePosition{if $sortField == 'themeModulePosition'} active{/if}"><div><a href="index.php?page=ArticleList&amp;contentItemID={@$contentItemID}&amp;pageNo={@$pageNo}&amp;sortField=themeModulePosition&amp;sortOrder={if $sortField == 'themeModulePosition' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.article.themeModulePosition{/lang}{if $sortField == 'themeModulePosition'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
						<th class="columnShowOrder{if $sortField == 'showOrder'} active{/if}"><div><a href="index.php?page=ArticleList&amp;contentItemID={@$contentItemID}&amp;pageNo={@$pageNo}&amp;sortField=showOrder&amp;sortOrder={if $sortField == 'showOrder' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.article.showOrder{/lang}{if $sortField == 'showOrder'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>

						{if $additionalColumnHeads|isset}{@$additionalColumnHeads}{/if}
					</tr>
				</thead>
				<tbody id="articleList">
					{foreach from=$articles item=article}
						<tr class="{cycle values="container-1,container-2"}" id="articleRow_{@$article->articleID}">
							<td class="columnIcon">
								{if $this->user->getPermission('admin.moxeo.canEditArticle')}
									<a href="index.php?page=ArticleSectionList&amp;articleID={@$article->articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_MOXEO_DIR}icon/articleSectionS.png" alt="" title="{lang}moxeo.acp.article.sections{/lang}" /></a>
								{else}
									<img src="{@RELATIVE_MOXEO_DIR}icon/articleSectionDisabledS.png" alt="" title="{lang}moxeo.acp.article.sections{/lang}" />
								{/if}
								{if $this->user->getPermission('admin.moxeo.canEditArticle')}
									<a href="index.php?form=ArticleEdit&amp;articleID={@$article->articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/editS.png" alt="" title="{lang}moxeo.acp.article.edit{/lang}" /></a>
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/editDisabledS.png" alt="" title="{lang}moxeo.acp.article.edit{/lang}" />
								{/if}
								{if $this->user->getPermission('admin.moxeo.canDeleteArticle')}
									<a href="index.php?action=ArticleDelete&amp;articleID={@$article->articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" onclick="return confirm('{lang}moxeo.acp.article.delete.sure{/lang}')" title="{lang}moxeo.acp.article.delete{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" /></a>
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/deleteDisabledS.png" alt="" title="{lang}moxeo.acp.article.delete{/lang}" />
								{/if}

								{if $additionalButtons.$article->articleID|isset}{@$additionalButtons.$article->articleID}{/if}
							</td>
							<td class="columnArticleID columnID">{@$article->articleID}</td>
							<td class="columnTitle columnText">
								{if $this->user->getPermission('admin.moxeo.canEditArticle')}
									<a href="index.php?form=ArticleEdit&amp;articleID={@$article->articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{$article->title}</a>
								{else}
									{$article->title}
								{/if}
							</td>
							<td class="columnArticleSections columnNumbers"><a href="index.php?page=ArticleSectionList&amp;articleID={@$article->articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{@$article->articleSections}</a></td>
							<td class="columnThemeModulePosition columnText">
								{lang}wcf.theme.module.position.{@$article->themeModulePosition}{/lang}
							</td>
							<td class="columnShowOrder columnNumbers">{@$article->showOrder}</td>

							{if $additionalColumns.$article->articleID|isset}{@$additionalColumns.$article->articleID}{/if}
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>*}

		<div class="contentFooter">
			{@$pagesLinks}

			{if $this->user->getPermission('admin.moxeo.canAddArticle')}
				<div class="largeButtons">
					<ul>
						<li><a href="index.php?form=ArticleAdd&amp;contentItemID={@$contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_MOXEO_DIR}icon/articleAddM.png" alt="" title="{lang}moxeo.acp.article.add{/lang}" /> <span>{lang}moxeo.acp.article.add{/lang}</span></a></li>
					</ul>
				</div>
			{/if}
		</div>
	{else}
		<div class="border content">
			<div class="container-1">
				<p>{lang}moxeo.acp.article.view.count.noArticles{/lang}</p>
			</div>
		</div>
	{/if}
{else}
	<div class="info">
		{lang}moxeo.acp.article.view.info{/lang}
	</div>

	{if $contentItems|count > 0}
			<div class="border content">
				<div class="container-1">
					<ol class="itemList" id="contentItemList">
						{foreach from=$contentItems item=child}
							{assign var="contentItem" value=$child.contentItem}

							<li id="item_{@$contentItem->contentItemID}">
								<div class="buttons">
									{if $child.additionalButtons|isset}{@$child.additionalButtons}{/if}
								</div>

								<h3 class="itemListTitle{if $contentItem->isRoot()} itemListCategory{/if}">
									{if $contentItem->isRoot()}
										{@$contentItem->getLanguageIcon()}
									{else}
										<img src="{@RELATIVE_MOXEO_DIR}icon/contentItem{if $contentItem->isExternalLink()}Redirect{/if}S.png" alt="" />
									{/if}

									ID-{@$contentItem->contentItemID} <a href="index.php?page=ArticleList&amp;contentItemID={@$contentItem->contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" class="title">{$contentItem->title}</a>
								</h3>

							{if $child.hasChildren}<ol id="parentItem_{@$contentItem->contentItemID}">{else}<ol id="parentItem_{@$contentItem->contentItemID}"></ol></li>{/if}
							{if $child.openParents > 0}{@"</ol></li>"|str_repeat:$child.openParents}{/if}
						{/foreach}
					</ol>
				</div>
			</div>
	{else}
		<div class="border content">
			<div class="container-1">
				<p>{lang}moxeo.acp.article.view.count.noContentItems{/lang}</p>
			</div>
		</div>
	{/if}
{/if}

{include file='footer'}