{include file='header'}

<div class="mainHeadline">
	<img src="{@RELATIVE_WSIS_DIR}icon/commentEditL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}wsis.acp.comment.edit{/lang}</h2>
	</div>
</div>

{if $errorField}
	<p class="error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="success">{lang}wsis.acp.comment.edit.success{/lang}</p>	
{/if}

<div class="contentHeader">
	<div class="largeButtons">
		<ul>
			<li><a href="index.php?page=CommentList&amp;packageID={@PACKAGE_ID}{@SID_ARG_2ND}" title="{lang}wsis.acp.menu.link.content.comment.view{/lang}"><img src="{@RELATIVE_WSIS_DIR}icon/articleM.png" alt="" /> <span>{lang}wsis.acp.menu.link.content.comment.view{/lang}</span></a></li>
			{if $additionalLargeButtons|isset}{@$additionalLargeButtons}{/if}
		</ul>
	</div>
</div>
<form method="post" action="index.php?form=CommentEdit">
	<div class="border content">
		<div class="container-1">
			<fieldset>
				<legend>{lang}wsis.acp.comment.data{/lang}</legend>
				
				<div class="formElement{if $errorField == 'comment'} formError{/if}" id="commentDiv">
					<div class="formFieldLabel">
						<label for="comment">{lang}wsis.comment.comment{/lang}</label>
					</div>
					<div class="formField">
						<textarea name="comment" id="comment" rows="10" cols="40">{$comment}</textarea>
						{if $errorField == 'comment'}
							<p class="innerError">
								{if $errorType == 'empty'}{lang}wcf.global.error.empty{/lang}{/if}
								{if $errorType == 'tooLong'}{lang}wsis.publication.object.comment.error.tooLong{/lang}{/if}
							</p>
						{/if}
					</div>
					<div class="formFieldDesc hidden" id="commentHelpMessage">
						<p>{lang}wsis.acp.comment.comment.description{/lang}</p>
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