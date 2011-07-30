{include file='header'}
<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/ItemListEditor.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe("dom:loaded", function() {
		var articleSectionList = $('articleSectionList');
		if (articleSectionList) {
			articleSectionList.addClassName('dragable');
			
			Sortable.create(articleSectionList, { 
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
							new Ajax.Request('index.php?action=ArticleSectionSort&articleSectionID='+row.id.gsub('articleSectionRow_', '')+SID_ARG_2ND, { method: 'post', parameters: { showOrder: newShowOrder } } );
						}
					});
				}
			});
		}
	});
	//]]>
</script>

<div class="mainHeadline">
	<img src="{@RELATIVE_WSIS_DIR}icon/articleSectionL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wsis.acp.article.section.view{/lang}</h2>
		<p>{$article->title}</p>
	</div>
</div>

{*<div class="border titleBarPanel">
	<div class="containerHead"><h3>{lang}wsis.acp.article{/lang}</h3></div>
</div>
<div class="border borderMarginRemove">
	<div class="content">
		<div class="container-1">
			<div class="formElement">
				<div class="formFieldLabel">
					<label>{lang}wsis.acp.article.title{/lang}</label>
				</div>
				<div class="formField">
					{$article->title}
				</div>
			</div>
		</div>
	</div>
</div>*}

{if $deletedArticleSectionID}
	<p class="success">{lang}wsis.acp.article.section.delete.success{/lang}</p>	
{/if}

{if $successfulSorting}
	<p class="success">{lang}wsis.acp.article.section.sort.success{/lang}</p>	
{/if}

<div class="contentHeader">
	{pages print=true assign=pagesLinks link="index.php?page=ArticleSectionList&articleID=$articleID&pageNo=%d&sortField=$sortField&sortOrder=$sortOrder&packageID="|concat:PACKAGE_ID:SID_ARG_2ND_NOT_ENCODED}
	<div class="largeButtons">
		<ul>
			<li><a href="index.php?form=ArticleSectionAdd&amp;articleID={@$articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WSIS_DIR}icon/articleSectionAddM.png" alt="" title="{lang}wsis.acp.article.section.add{/lang}" /> <span>{lang}wsis.acp.article.section.add{/lang}</span></a></li>
			<li><a href="index.php?page=ArticleList&amp;contentItemID={@$article->contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WSIS_DIR}icon/articleM.png" alt="" title="{lang}wsis.acp.article.view{/lang}" /> <span>{lang}wsis.acp.article.view{/lang}</span></a></li>
		</ul>
	</div>
</div>

{if $articleSections|count}
	<div class="border titleBarPanel">
		<div class="containerHead"><h3>{lang}wsis.acp.article.section.view.count{/lang}</h3></div>
	</div>
	<div class="border borderMarginRemove">
		<table class="tableList">
			<thead>
				<tr class="tableHead">
					<th class="columnArticleSectionID{if $sortField == 'articleSectionID'} active{/if}" colspan="2"><div><a href="index.php?page=ArticleSectionList&amp;articleID={@$articleID}&amp;pageNo={@$pageNo}&amp;sortField=articleSectionID&amp;sortOrder={if $sortField == 'articleSectionID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}wsis.acp.article.section.articleSectionID{/lang}{if $sortField == 'articleSectionID'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnArticleSectionType{if $sortField == 'articleSectionType'} active{/if}"><div><a href="index.php?page=ArticleSectionList&amp;articleID={@$articleID}&amp;pageNo={@$pageNo}&amp;sortField=articleSectionType&amp;sortOrder={if $sortField == 'articleSectionType' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}wsis.acp.article.section.articleSectionType{/lang}{if $sortField == 'articleSectionType'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnArticleSectionPreview"><div><span class="emptyHead">{lang}wsis.acp.article.section.preview{/lang}</span></div></th>
					<th class="columnShowOrder{if $sortField == 'showOrder'} active{/if}"><div><a href="index.php?page=ArticleSectionList&amp;articleID={@$articleID}&amp;pageNo={@$pageNo}&amp;sortField=showOrder&amp;sortOrder={if $sortField == 'showOrder' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}wsis.acp.article.section.showOrder{/lang}{if $sortField == 'showOrder'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					
					{if $additionalColumnHeads|isset}{@$additionalColumnHeads}{/if}
				</tr>
			</thead>
			<tbody id="articleSectionList">
				{foreach from=$articleSections item=articleSection}
					<tr class="{cycle values="container-1,container-2"}" id="articleSectionRow_{@$articleSection->articleSectionID}">
						<td class="columnIcon">
							<a href="index.php?form=ArticleSectionEdit&amp;articleSectionID={@$articleSection->articleSectionID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/editS.png" alt="" title="{lang}wsis.acp.article.section.edit{/lang}" /></a>
							<a href="index.php?action=ArticleSectionDelete&amp;articleSectionID={@$articleSection->articleSectionID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" onclick="return confirm('{lang}wsis.acp.article.section.delete.sure{/lang}')" title="{lang}wsis.acp.article.section.delete{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" /></a>
							
							{if $additionalButtons.$articleSection->articleSectionID|isset}{@$additionalButtons.$articleSection->articleSectionID}{/if}
						</td>
						<td class="columnArticleSectionID columnID">{@$articleSection->articleSectionID}</td>
						<td class="columnArticleSectionType columnText">
							{lang}wsis.article.section.type.{@$articleSection->articleSectionType}{/lang}
						</td>
						<td class="columnArticleSectionPreview columnText">
							{@$articleSection->getArticleSectionType()->getPreviewHTML($articleSection, $article, $contentItem)}
						</td>
						<td class="columnShowOrder columnNumbers">{@$articleSection->showOrder}</td>
						
						{if $additionalColumns.$articleSection->articleSectionID|isset}{@$additionalColumns.$articleSection->articleSectionID}{/if}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
	
	<div class="contentFooter">
		{@$pagesLinks}
		
		<div class="largeButtons">
			<ul>
				<li><a href="index.php?form=ArticleSectionAdd&amp;articleID={@$articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WSIS_DIR}icon/articleSectionAddM.png" alt="" title="{lang}wsis.acp.article.section.add{/lang}" /> <span>{lang}wsis.acp.article.section.add{/lang}</span></a></li>
				<li><a href="index.php?page=ArticleList&amp;contentItemID={@$article->contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WSIS_DIR}icon/articleM.png" alt="" title="{lang}wsis.acp.article.view{/lang}" /> <span>{lang}wsis.acp.article.view{/lang}</span></a></li>
			</ul>
		</div>
	</div>
{else}
	<div class="border content">
		<div class="container-1">
			<p>{lang}wsis.acp.article.section.view.count.noArticleSections{/lang}</p>
		</div>
	</div>
{/if}

{include file='footer'}