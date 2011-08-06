<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/section/ArticleSectionCommentableObject.class.php');
require_once(WSIS_DIR.'lib/data/comment/object/CommentableObjectType.class.php');

/**
 * Represents an article section commentable object type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.article.section
 * @category	Infinite Site
 */
class ArticleSectionCommentableObjectType implements CommentableObjectType {	
	/**
	 * @see CommentableObjectType::getObjectByID()
	 */
	public function getObjectByID($objectID) {
		// get object
		$articleSection = new ArticleSectionCommentableObject($objectID);
		if (!$articleSection->articleSectionID) return null;
		
		// return object
		return $articleSection;
	}
	
	/**
	 * @see CommentableObjectType::getObjectsByIDs()
	 */
	public function getObjectsByIDs($objectIDs) {
		$articleSections = array();
		$sql = "SELECT		article_section.*, article.contentItemID
			FROM 		wsis".WSIS_N."_article_section article_section
			LEFT JOIN	wsis".WSIS_N."_article article
			ON		(article.articleID = article_section.articleID)
			WHERE 		article_section.articleSectionID IN (".implode(',', $objectIDs).")";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$articleSections[$row['articleSectionID']] = new ArticleSectionCommentableObject(null, $row);
		}
		
		return (count($articleSections) > 0 ? $articleSections : null);
	}
}
?>