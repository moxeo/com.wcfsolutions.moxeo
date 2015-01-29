<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItemList.class.php');

/**
 * Represents a viewable list of content items.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.content
 * @category	Moxeo Open Source CMS
 */
class ViewableContentItemList extends ContentItemList {
	/**
	 * level offset
	 *
	 * @var	integer
	 */
	protected $levelOffset = 0;

	/**
	 * level limit
	 *
	 * @var	integer
	 */
	protected $levelLimit = 0;

	/**
	 * Creates a new ViewableContentItemList.
	 *
	 * @param	integer		$contentItemID
	 * @param	integer		$levelOffset
	 * @param	integer		$levelLimit
	 */
	public function __construct($contentItemID = 0, $levelOffset = 0, $levelLimit = 0) {
		$this->levelOffset = $levelOffset;
		$this->levelLimit = $levelLimit;
		parent::__construct($contentItemID);
	}

	/**
	 * @see	ContentItemList::isVisible()
	 */
	protected function isVisible(ContentItem $contentItem) {
		if (($contentItem->isRoot() && $contentItem->languageID != WCF::getLanguage()->getLanguageID())
			|| !$contentItem->isVisiblePage() || !$contentItem->getPermission()
			|| ((!$contentItem->enabled || !$contentItem->isPublished())
				&& !$contentItem->getPermission('canViewHiddenContentItem'))
			|| $this->levelLimit && $contentItem->getLevel() >= ($this->levelOffset + $this->levelLimit)) {
			return false;
		}
		return true;
	}
}
?>