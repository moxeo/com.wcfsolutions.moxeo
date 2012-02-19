{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_MOXEO_DIR}icon/commentEditL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}moxeo.acp.comment.edit{/lang}</h2>
	</div>
</div>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}moxeo.acp.comment.edit.success{/lang}</p>	
{/if}

<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li><a href="index.php?page=CommentList&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}moxeo.acp.menu.link.content.comment.view{/lang}"><img src="{@RELATIVE_MOXEO_DIR}icon/articleM.png" alt="" /> <span>{lang}moxeo.acp.menu.link.content.comment.view{/lang}</span></a></li>
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>
<form method="post" action="index.php?form=CommentEdit">
	<div class="border content">
		<div class="container-1">
			<fieldset>
				<legend>{lang}moxeo.acp.comment.data{/lang}</legend>
				
				<div class="formElement">
					<div class="formFieldLabel">
						{lang}wcf.user.username{/lang}
					</div>
					<div class="formField">
						{if $commentObj->userID && $this->user->getPermission('admin.user.canEditUser')}
							<a href="index.php?form=UserEdit&amp;userID={@$commentObj->userID}&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wcf.acp.user.edit{/lang}">{$commentObj->username}</a>
						{else}
							{$commentObj->username}
						{/if}
					</div>
				</div>
				
				<div class="formElement">
					<div class="formFieldLabel">
						{lang}moxeo.acp.comment.commentableObjectType{/lang}
					</div>
					<div class="formField">
						{lang}moxeo.comment.commentableObjectType.{@$commentObj->commentableObjectType}{/lang}
					</div>
				</div>
				
				<div class="formElement">
					<div class="formFieldLabel">
						{lang}moxeo.acp.comment.commentableObjectID{/lang}
					</div>
					<div class="formField">
						{if $commentableObject}
							<a href="{@RELATIVE_MOXEO_DIR}{$commentableObject->getURL()}">{$commentableObject->getTitle()}</a>
						{/if}
					</div>
				</div>
				
				<div class="formElement{if $errorField == 'comment'} formError{/if}" id="commentDiv">
					<div class="formFieldLabel">
						<label for="comment">{lang}moxeo.comment.comment{/lang}</label>
					</div>
					<div class="formField">
						<textarea name="comment" id="comment" rows="10" cols="40">{$comment}</textarea>
						{if $errorField == 'comment'}
							<p class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
								{if $errorType == 'tooLong'}{lang}moxeo.publication.object.comment.error.tooLong{/lang}{/if}
							</p>
						{/if}
					</div>
					<div class="formFieldDesc hidden" id="commentHelpMessage">
						<p>{lang}moxeo.acp.comment.comment.description{/lang}</p>
					</div>
				</div>
				<script type="text/javascript">//<![CDATA[
					inlineHelp.register('comment');
				//]]></script>
			</fieldset>
		</div>
	</div>
	
	<div class="formSubmit">
		<input type="submit" name="send" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
		<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
		<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
 		{@SID_INPUT_TAG}
 		<input type="hidden" name="commentID" value="{@$commentID}" />
 	</div>
</form>

{include file='footer'}