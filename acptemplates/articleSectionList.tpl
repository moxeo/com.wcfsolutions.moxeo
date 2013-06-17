{include file='header'}
<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/ItemListEditor.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe("dom:loaded", function() {
		var articleSectionList = $('articleSectionList');
		if (articleSectionList) {
			articleSectionList.addClassName('dragable');

			Sortable.create(articleSectionList, {
				tag: 'div',
				onUpdate: function(list) {
					var rows = list.select('.message');
					var newShowOrder = 0;
					rows.each(function(row, i) {
					    	row.firstDescendant().removeClassName('container-1').removeClassName('container-2');
						row.firstDescendant().addClassName('container-' + (i % 2 == 0 ? '1' : '2'));
						newShowOrder = i + {@$startIndex} - 1;
						new Ajax.Request('index.php?action=ArticleSectionSort&articleSectionID='+row.id.gsub('articleSectionRow_', '')+SID_ARG_2ND, { method: 'post', parameters: { showOrder: newShowOrder } } );
					});
				}
			});
		}
	});
	//]]>
</script>

<ul class="breadCrumbs">
	<li><a href="index.php?page=ArticleList{@SID_ARG_2ND}"><span>{lang}moxeo.acp.article.view{/lang}</span></a> &raquo;</li>
	<li><a href="index.php?page=ArticleList&amp;contentItemID={@$article->contentItemID}{@SID_ARG_2ND}"><span>{$contentItem->title}</span></a> &raquo;</li>
</ul>
<div class="mainHeadline">
	<img src="{@RELATIVE_MOXEO_DIR}icon/articleSectionL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}moxeo.acp.article.section.view{/lang}</h2>
	</div>
</div>

{if $deletedArticleSectionID}
	<p class="success">{lang}moxeo.acp.article.section.delete.success{/lang}</p>
{/if}

<div class="contentHeader">
	{pages print=true assign=pagesLinks link="index.php?page=ArticleSectionList&articleID=$articleID&pageNo=%d&packageID="|concat:PACKAGE_ID:SID_ARG_2ND_NOT_ENCODED}
	<div class="largeButtons">
		<ul>
			<li><a href="index.php?form=ArticleSectionAdd&amp;articleID={@$articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_MOXEO_DIR}icon/articleSectionAddM.png" alt="" title="{lang}moxeo.acp.article.section.add{/lang}" /> <span>{lang}moxeo.acp.article.section.add{/lang}</span></a></li>
		</ul>
	</div>
</div>

{if $articleSections|count}
	<div id="articleSectionList">
		{foreach from=$articleSections item=articleSection}
			<div class="message content" id="articleSectionRow_{@$articleSection->articleSectionID}">
				<div class="messageInner container-{cycle name='articleSections' values='1,2'}">
					<h3 class="subHeadline">
						{lang}moxeo.article.section.type.{@$articleSection->articleSectionType}{/lang}
					</h3>

					<div class="messageBody">
						{@$articleSection->getArticleSectionType()->getPreviewHTML($articleSection, $article, $contentItem)}
					</div>

					<div class="messageFooter">
						<div class="smallButtons">
							<ul>
								<li class="extraButton"><a href="#top" title="{lang}wcf.global.scrollUp{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/upS.png" alt="{lang}wcf.global.scrollUp{/lang}" /></a></li>
								<li><a onclick="return confirm('{lang}moxeo.acp.article.section.delete.sure{/lang}')" href="index.php?action=ArticleSectionDelete&amp;articleSectionID={@$articleSection->articleSectionID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.global.button.delete{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" /> <span>{lang}wcf.global.button.delete{/lang}</span></a></li>
								<li><a href="index.php?form=ArticleSectionEdit&amp;articleSectionID={@$articleSection->articleSectionID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.global.button.edit{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/editS.png" alt="" /> <span>{lang}wcf.global.button.edit{/lang}</span></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		{/foreach}
	</div>

	<div class="contentFooter">
		{@$pagesLinks}

		<div class="largeButtons">
			<ul>
				<li><a href="index.php?form=ArticleSectionAdd&amp;articleID={@$articleID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_MOXEO_DIR}icon/articleSectionAddM.png" alt="" title="{lang}moxeo.acp.article.section.add{/lang}" /> <span>{lang}moxeo.acp.article.section.add{/lang}</span></a></li>
			</ul>
		</div>
	</div>
{else}
	<div class="border content">
		<div class="container-1">
			<p>{lang}moxeo.acp.article.section.view.count.noArticleSections{/lang}</p>
		</div>
	</div>
{/if}

{include file='footer'}