<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/section/type/ViewableArticleSectionType.class.php');

/**
 * Represents the comments article section type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.article.section.type
 * @category	Infinite Site
 */
class CommentsArticleSectionType extends ViewableArticleSectionType {
	/**
	 * @see	ViewableArticleSectionType::$pageElement
	 */
	public $pageElement = 'comments';
	
	// display methods
	/**
	 * @see	ArticleSectionType::getPreviewHTML()
	 */	
	public function getPreviewHTML(ArticleSection $articleSection, Article $article, ContentItem $contentItem) {
		return WCF::getLanguage()->get('wsis.comment.comments');
	}
}
?>