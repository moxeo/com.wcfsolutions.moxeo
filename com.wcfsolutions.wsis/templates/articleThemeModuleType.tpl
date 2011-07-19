{foreach from=$articles item=article}
	{assign var=articleID value=$article->articleID}
	<div class="article{if $article->cssClasses} {$article->cssClasses}{/if}"{if $article->cssID} id="{$article->cssID}"{/if}>
		{if $articleSections.$articleID|isset}
			{foreach from=$articleSections.$articleID item=articleSection}
				{if $articleSection->getArticleSectionType()->hasContent($articleSection, $article, $contentItem)}
					<div class="{@$articleSection->articleSectionType}ArticleSection{if $articleSection->cssClasses} {$articleSection->cssClasses}{/if}"{if $articleSection->cssID} id="{$articleSection->cssID}"{/if}>
						{@$articleSection->getArticleSectionType()->getContent($articleSection, $article, $contentItem)}
					</div>
				{/if}
			{/foreach}
		{/if}
	</div>
{/foreach}