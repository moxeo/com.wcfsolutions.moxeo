<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/comment/object/CommentableObject.class.php');
require_once(WSIS_DIR.'lib/data/news/NewsItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents a news item commentable object.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.news
 * @category	Infinite Site
 */
class NewsItemCommentableObject extends NewsItem implements CommentableObject {
	// CommentableObject implementation
	/**
	 * @see	CommentableObject::getCommentableObjectID()
	 */
	public function getCommentableObjectID() {
		return $this->newsItemID;
	}
	
	/**
	 * @see	CommentableObject::getCommentableObjectType()
	 */
	public function getCommentableObjectType() {
		return 'newsItem';
	}
	
	/**
	 * @see	CommentableObject::getTitle()
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * @see	CommentableObject::getURL()
	 * @see	NewsItem::getURL()
	 */
	public function getURL() {
		if (!defined('URL_PREFIX')) {
			if (ENABLE_SEO_REWRITING) define('URL_PREFIX', '');
			else define('URL_PREFIX', 'index.php/');
		}
		return parent::getURL();
	}
}
?>