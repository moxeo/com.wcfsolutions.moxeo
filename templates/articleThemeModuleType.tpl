{foreach from=$articles item=article}
	{assign var=articleID value=$article->articleID}
	<article class="article{if $article->cssClasses} {$article->cssClasses}{/if}"{if $article->cssID} id="{$article->cssID}"{/if}>
		{if $articleSections.$articleID|isset}
			{foreach from=$articleSections.$articleID item=articleSection}
				{if $articleSection->getArticleSectionType()->hasContent($articleSection, $article, $contentItem)}
					<section class="section {@$articleSection->articleSectionType}Section{if $articleSection->cssClasses} {$articleSection->cssClasses}{/if}"{if $articleSection->cssID} id="{$articleSection->cssID}"{/if}>
						{@$articleSection->getArticleSectionType()->getContent($articleSection, $article, $contentItem)}
					</section>
				{/if}
			{/foreach}
		{/if}
	</article>
{/foreach}