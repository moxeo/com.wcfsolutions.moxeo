{include file='header'}
<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/ItemListEditor.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe("dom:loaded", function() {
		var articleList = $('articleList');
		if (articleList) {
			articleList.addClassName('dragable');

			Sortable.create(articleList, {
				tag: 'tr',
				onUpdate: function(list) {
					var rows = list.select('tr');
					var showOrder = 0;
					var newShowOrder = 0;
					rows.each(function(row, i) {
						row.className = 'container-' + (i % 2 == 0 ? '1' : '2') + (row.hasClassName('marked') ? ' marked' : '');
						showOrder = row.select('.columnNumbers')[0];
						newShowOrder = i + 1;
						if (newShowOrder != showOrder.innerHTML) {
							showOrder.update(newShowOrder);
							new Ajax.Request('index.php?action=ArticleSort&articleID='+row.id.gsub('articleRow_', '')+SID_ARG_2ND, { method: 'post', parameters: { showOrder: newShowOrder } } );
						}
					});
				}
			});
		}
	});
	//]]>
</script>

<div class="mainHeadline">
	<img src="{@RELATIVE_MOXEO_DIR}icon/articleL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}moxeo.acp.article.view{/lang}</h2>
		{if $contentItemID}<p>{$contentItem->title}</p>{/if}
	</div>
</div>

{if $deletedArticleID}
	<p class="success">{lang}moxeo.acp.article.delete.success{/lang}</p>
{/if}

{if $successfulSorting}
	<p class="success">{lang}moxeo.acp.article.sort.success{/lang}</p>
{/if}

{if $contentItemOptions|count}
	<fieldset>
		<legend>{lang}moxeo.acp.article.contentItem{/lang}</legend>
		<div class="formElement" id="contentItemDiv">
			<div class="formFieldLabel">
				<label for="contentItemChange">{lang}moxeo.acp.article.contentItem{/lang}</label>
			</div>
			<div class="formField">
				<select id="contentItemChange" onchange="document.location.href=fixURL('index.php?page=ArticleList&amp;contentItemID='+this.options[this.selectedIndex].value+'&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}')">
					<option value="0"></option>
					{htmloptions options=$contentItemOptions selected=$contentItemID disableEncoding=true}
				</select>
			</div>
			<div class="formFieldDesc hidden" id="contentItemHelpMessage">
				{lang}moxeo.acp.article.contentItem.description{/lang}
			</div>
		</div>
		<script type="text/javascript">//<![CDATA[
			inlineHelp.register('contentItem');
		//]]></script>
	</fieldset>
{else}
	<div class="border content">
		<div class="container-1">
			<p>{lang}moxeo.acp.article.view.count.noContentItems{/lang}</p>
		</div>
	</div>
{/if}

{if $contentItemID}
	<div class="contentHeader">
		{pages print=true assign=pagesLinks link="index.php?page=ArticleList&contentItemID=$contentItemID&pageNo=%d&sortField=$sortField&sortOrder=$sortOrder&packageID="|concat:PACKAGE_ID:SID_ARG_2ND_NOT_ENCODED}
		{if $this->user->getPermission('admin.moxeo.canAddArticle')}
			<div class="largeButtons">
				<ul>
					<li><a href="index.php?form=ArticleAdd&amp;contentItemID={@$contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_MOXEO_DIR}icon/articleAddM.png" alt="" title="{lang}moxeo.acp.article.add{/lang}" /> <span>{lang}moxeo.acp.article.add{/lang}</span></a></li>
				</ul>
			</div>
		{/if}
	</div>

	{if $articles|count}
		<div class="border titleBarPanel">
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
		</div>

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
{/if}

{include file='footer'}