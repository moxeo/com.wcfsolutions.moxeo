{include file='header'}
<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/ItemListEditor.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	function init() {
		{if $contentItems|count > 0 && $contentItems|count < 100 && $this->user->getPermission('admin.site.isContentItemAdmin') && $this->user->getPermission('admin.site.canEditContentItem')}
			new ItemListEditor('contentItemList', { itemTitleEdit: true, itemTitleEditURL: 'index.php?action=ContentItemRename&contentItemID=', tree: true, treeTag: 'ol' });
		{/if}
	}
	
	// when the dom is fully loaded, execute these scripts
	document.observe("dom:loaded", init);	
	//]]>
</script>

<div class="mainHeadline">
	<img src="{@RELATIVE_WSIS_DIR}icon/contentItemL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wsis.acp.contentItem.view{/lang}</h2>
	</div>
</div>

{if $deletedContentItemID}
	<p class="success">{lang}wsis.acp.contentItem.delete.success{/lang}</p>	
{/if}

{if $successfulSorting}
	<p class="success">{lang}wsis.acp.contentItem.sort.success{/lang}</p>	
{/if}

{if $this->user->getPermission('admin.site.canAddContentItem')}
	<div class="contentHeader">
		<div class="largeButtons">
			<ul><li><a href="index.php?form=ContentItemAdd&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WSIS_DIR}icon/contentItemAddM.png" alt="" title="{lang}wsis.acp.contentItem.add{/lang}" /> <span>{lang}wsis.acp.contentItem.add{/lang}</span></a></li></ul>
		</div>
	</div>
{/if}

{if $contentItems|count > 0}
	{if $this->user->getPermission('admin.site.isContentItemAdmin') && $this->user->getPermission('admin.site.canEditContentItem')}
	<form method="post" action="index.php?action=ContentItemSort">
	{/if}
		<div class="border content">
			<div class="container-1">
				<ol class="itemList" id="contentItemList">
					{foreach from=$contentItems item=child}
						{assign var="contentItem" value=$child.contentItem}
						
						<li id="item_{@$contentItem->contentItemID}" class="deletable">
							<div class="buttons">
								{if $contentItem->getAdminPermission('canEnableContentItem')}
									{if $contentItem->enabled}
										<a href="index.php?action=ContentItemDisable&amp;contentItemID={@$contentItem->contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/enabledS.png" alt="" title="{lang}wsis.acp.contentItem.disable{/lang}" /></a>
									{else}
										<a href="index.php?action=ContentItemEnable&amp;contentItemID={@$contentItem->contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/disabledS.png" alt="" title="{lang}wsis.acp.contentItem.enable{/lang}" /></a>
									{/if}
								{else}
									{if $contentItem->enabled}
										<img src="{@RELATIVE_WCF_DIR}icon/enabledDisabledS.png" alt="" title="{lang}wsis.acp.contentItem.disable{/lang}" />
									{else}
										<img src="{@RELATIVE_WCF_DIR}icon/disabledDisabledS.png" alt="" title="{lang}wsis.acp.contentItem.enable{/lang}" />
									{/if}
								{/if}
								
								{if $contentItem->getAdminPermission('canEditContentItem')}
									<a href="index.php?form=ContentItemEdit&amp;contentItemID={@$contentItem->contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/editS.png" alt="" title="{lang}wsis.acp.contentItem.edit{/lang}" /></a>
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/editDisabledS.png" alt="" title="{lang}wsis.acp.contentItem.edit{/lang}" />
								{/if}
								{if $contentItem->getAdminPermission('canAddContentItem')}
									<a href="index.php?form=ContentItemAdd&amp;parentID={@$contentItem->contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wsis.acp.contentItem.add{/lang}"><img src="{@RELATIVE_WCF_DIR}icon/addS.png" alt="" /></a>
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/addDisabledS.png" alt="" title="{lang}wsis.acp.contentItem.add{/lang}" />
								{/if}								
								{if $contentItem->getAdminPermission('canDeleteContentItem')}
									<a href="index.php?action=ContentItemDelete&amp;contentItemID={@$contentItem->contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wsis.acp.contentItem.delete{/lang}" class="deleteButton"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" longdesc="{lang}wsis.acp.contentItem.delete.sure{/lang}"  /></a>
								{else}
									<img src="{@RELATIVE_WCF_DIR}icon/deleteDisabledS.png" alt="" title="{lang}wsis.acp.contentItem.delete{/lang}" />
								{/if}
								
								{if $child.additionalButtons|isset}{@$child.additionalButtons}{/if}
							</div>
							
							<h3 class="itemListTitle">
								<img src="{@RELATIVE_WSIS_DIR}icon/contentItem{if $contentItem->isExternalLink()}Redirect{/if}S.png" alt="" />
								{@$contentItem->getLanguageIcon()}
								
								{if $this->user->getPermission('admin.site.isContentItemAdmin') && $this->user->getPermission('admin.site.canEditContentItem')}
									<select name="contentItemListPositions[{@$contentItem->contentItemID}][{@$child.parentID}]">
										{section name='positions' loop=$child.maxPosition}
											<option value="{@$positions+1}"{if $positions+1 == $child.position} selected="selected"{/if}>{@$positions+1}</option>
										{/section}
									</select>
								{/if}
								
								ID-{@$contentItem->contentItemID} <a href="index.php?form=ContentItemEdit&amp;contentItemID={@$contentItem->contentItemID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" class="title">{$contentItem->title}</a>
							</h3>
						
						{if $child.hasChildren}<ol id="parentItem_{@$contentItem->contentItemID}">{else}<ol id="parentItem_{@$contentItem->contentItemID}"></ol></li>{/if}
						{if $child.openParents > 0}{@"</ol></li>"|str_repeat:$child.openParents}{/if}
					{/foreach}
				</ol>
			</div>
		</div>
	{if $this->user->getPermission('admin.site.isContentItemAdmin') && $this->user->getPermission('admin.site.canEditContentItem')}
		<div class="formSubmit">
			<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
			<input type="reset" accesskey="r" id="reset" value="{lang}wcf.global.button.reset{/lang}" />
			<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
	 		{@SID_INPUT_TAG}
	 	</div>
	</form>
	{/if}
{else}
	<div class="border content">
		<div class="container-1">
			<p>{lang}wsis.acp.contentItem.view.count.noContentItems{/lang}</p>
		</div>
	</div>
{/if}

{include file='footer'}