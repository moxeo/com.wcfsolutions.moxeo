{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_MOXEO_DIR}icon/commentL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}moxeo.acp.comment.view{/lang}</h2>
	</div>
</div>

{if $deletedCommentID}
	<p class="success">{lang}moxeo.acp.comment.delete.success{/lang}</p>	
{/if}

<div class="contentHeader">
	{pages print=true assign=pagesLinks link="index.php?page=CommentList&pageNo=%d&sortField=$sortField&sortOrder=$sortOrder&packageID="|concat:PACKAGE_ID:SID_ARG_2ND_NOT_ENCODED}
</div>

{if $comments|count}
	<div class="border titleBarPanel">
		<div class="containerHead"><h3>{lang}moxeo.acp.comment.view.count{/lang}</h3></div>
	</div>
	<div class="border borderMarginRemove">
		<table class="tableList">
			<thead>
				<tr class="tableHead">
					<th class="columnCommentID{if $sortField == 'commentID'} active{/if}" colspan="2"><div><a href="index.php?page=CommentList&amp;pageNo={@$pageNo}&amp;sortField=commentID&amp;sortOrder={if $sortField == 'commentID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.comment.commentID{/lang}{if $sortField == 'commentID'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnCommentableObjectType{if $sortField == 'commentableObjectType'} active{/if}"><div><a href="index.php?page=CommentList&amp;pageNo={@$pageNo}&amp;sortField=commentableObjectType&amp;sortOrder={if $sortField == 'commentableObjectType' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.comment.commentableObjectType{/lang}{if $sortField == 'commentableObjectType'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnCommentableObjectID{if $sortField == 'commentableObjectID'} active{/if}"><div><a href="index.php?page=CommentList&amp;pageNo={@$pageNo}&amp;sortField=commentableObjectID&amp;sortOrder={if $sortField == 'commentableObjectID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.comment.commentableObjectID{/lang}{if $sortField == 'commentableObjectID'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnUsername{if $sortField == 'username'} active{/if}"><div><a href="index.php?page=CommentList&amp;pageNo={@$pageNo}&amp;sortField=username&amp;sortOrder={if $sortField == 'username' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.comment.username{/lang}{if $sortField == 'username'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnIpAddress{if $sortField == 'ipAddress'} active{/if}"><div><a href="index.php?page=CommentList&amp;pageNo={@$pageNo}&amp;sortField=ipAddress&amp;sortOrder={if $sortField == 'ipAddress' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.comment.ipAddress{/lang}{if $sortField == 'ipAddress'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnComment{if $sortField == 'comment'} active{/if}"><div><a href="index.php?page=CommentList&amp;pageNo={@$pageNo}&amp;sortField=comment&amp;sortOrder={if $sortField == 'comment' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.comment.comment{/lang}{if $sortField == 'comment'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					<th class="columnTime{if $sortField == 'time'} active{/if}"><div><a href="index.php?page=CommentList&amp;pageNo={@$pageNo}&amp;sortField=time&amp;sortOrder={if $sortField == 'time' && $sortOrder == 'ASC'}DESC{else}ASC{/if}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}">{lang}moxeo.acp.comment.time{/lang}{if $sortField == 'time'} <img src="{@RELATIVE_WCF_DIR}icon/sort{@$sortOrder}S.png" alt="" />{/if}</a></div></th>
					
					{if $additionalColumnHeads|isset}{@$additionalColumnHeads}{/if}
				</tr>
			</thead>
			<tbody id="commentList">
				{foreach from=$comments item=comment}
					<tr class="{cycle values="container-1,container-2"}">
						<td class="columnIcon">
							{if $this->user->getPermission('admin.site.canEditComment')}
								<a href="index.php?form=CommentEdit&amp;commentID={@$comment->commentID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/editS.png" alt="" title="{lang}moxeo.acp.comment.edit{/lang}" /></a>
							{else}
								<img src="{@RELATIVE_WCF_DIR}icon/editDisabledS.png" alt="" title="{lang}moxeo.acp.comment.edit{/lang}" />
							{/if}
							{if $this->user->getPermission('admin.site.canDeleteComment')}
								<a onclick="return confirm('{lang}moxeo.acp.comment.delete.sure{/lang}')" href="index.php?action=CommentDelete&amp;commentID={@$comment->commentID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}"><img src="{@RELATIVE_WCF_DIR}icon/deleteS.png" alt="" title="{lang}moxeo.acp.comment.delete{/lang}" /></a>
							{else}
								<img src="{@RELATIVE_WCF_DIR}icon/deleteDisabledS.png" alt="" title="{lang}moxeo.acp.comment.delete{/lang}" />
							{/if}
							
							{if $additionalButtons.$comment->commentID|isset}{@$additionalButtons.$comment->commentID}{/if}
						</td>
						<td class="columnCommentID columnID">{@$comment->commentID}</td>
						<td class="columnCommentableObjectType columnText">
							{lang}moxeo.comment.commentableObjectType.{@$comment->commentableObjectType}{/lang}
						</td>
						<td class="columnCommentableObjectID columnText">
							{if $comment->commentableObject}
								<a href="{@RELATIVE_MOXEO_DIR}{$comment->commentableObject->getURL()}">{$comment->commentableObject->getTitle()}</a>
							{/if}
						</td>
						<td class="columnUsername columnText">
							{if $comment->userID && $this->user->getPermission('admin.user.canEditUser')}
								<a href="index.php?form=UserEdit&amp;userID={@$comment->userID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.acp.user.edit{/lang}">{$comment->username}</a>
							{else}
								{$comment->username}
							{/if}
						</td>
						<td class="columnIpAddress columnText">
							{$comment->ipAddress}
						</td>
						<td class="columnComment columnText">
							{@$comment->getFormattedComment()}
						</td>
						<td class="columnTime columnText">
							{@$comment->time|time}
						</td>
						
						{if $additionalColumns.$comment->commentID|isset}{@$additionalColumns.$comment->commentID}{/if}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>

	<div class="contentFooter">
		{@$pagesLinks}
	</div>
{else}
	<div class="border content">
		<div class="container-1">
			<p>{lang}moxeo.acp.comment.view.count.noComments{/lang}</p>
		</div>
	</div>
{/if}

{include file='footer'}