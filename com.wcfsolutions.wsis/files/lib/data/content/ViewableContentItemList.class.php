<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/content/ContentItemList.class.php');

/**
 * Represents a viewable list of content items.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.content
 * @category	Infinite Site
 */
class ViewableContentItemList extends ContentItemList {
	/**
	 * max depth
	 * 
	 * @var	integer
	 */
	public $maxDepth = 0;
	
	/**
	 * Creates a new ViewableContentItemList.
	 * 
	 * @param	integer		$contentItemID
	 * @param	integer		$maxDepth
	 */
	public function __construct($contentItemID = 0, $maxDepth = 0) {
		$this->maxDepth = $maxDepth;
		parent::__construct($contentItemID);
	}
	
	/**
	 * @see	ContentItemList::isVisible()
	 */
	protected function isVisible(ContentItem $contentItem) {
		if ($contentItem->languageID != WCF::getLanguage()->getLanguageID() || !$contentItem->isVisiblePage() || !$contentItem->getPermission() || (!$contentItem->isPublished() && !$contentItem->getPermission('canViewHiddenContentItem')) || $this->maxDepth && ($contentItem->getLevel()+1) > $this->maxDepth) {
			return false;
		}
		return true;
	}
}
?>