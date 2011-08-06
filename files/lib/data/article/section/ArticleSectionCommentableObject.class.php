<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/section/ArticleSection.class.php');
require_once(WSIS_DIR.'lib/data/comment/object/CommentableObject.class.php');
require_once(WSIS_DIR.'lib/data/content/ContentItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents an article section commentable object.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.article.section
 * @category	Infinite Site
 */
class ArticleSectionCommentableObject extends ArticleSection implements CommentableObject {
	/**
	 * @see	ArticleSection::__construct()
	 */
	public function __construct($articleSectionID, $row = null) {
		if ($articleSectionID !== null) {
			$sql = "SELECT		article_section.*, article.contentItemID
				FROM 		wsis".WSIS_N."_article_section article_section
				LEFT JOIN	wsis".WSIS_N."_article article
				ON		(article.articleID = article_section.articleID)
				WHERE 		article_section.articleSectionID = ".$articleSectionID;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		DatabaseObject::__construct($row);
	}
	
	// CommentableObject implementation
	/**
	 * @see	CommentableObject::getCommentableObjectID()
	 */
	public function getCommentableObjectID() {
		return $this->articleSectionID;
	}
	
	/**
	 * @see	CommentableObject::getCommentableObjectType()
	 */
	public function getCommentableObjectType() {
		return 'articleSection';
	}
	
	/**
	 * @see	CommentableObject::getTitle()
	 */
	public function getTitle() {
		return ContentItem::getContentItem($this->contentItemID)->title;
	}
	
	/**
	 * @see	CommentableObject::getURL()
	 */
	public function getURL() {
		if (!defined('URL_PREFIX')) {
			if (ENABLE_SEO_REWRITING) define('URL_PREFIX', '');
			else define('URL_PREFIX', 'index.php/');
		}
		return ContentItem::getContentItem($this->contentItemID)->getURL();
	}
}
?>