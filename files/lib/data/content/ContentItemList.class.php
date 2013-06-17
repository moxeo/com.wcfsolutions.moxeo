<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItem.class.php');

/**
 * Represents a list of content items.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.content
 * @category	Moxeo Open Source CMS
 */
class ContentItemList {
	/**
	 * content item id
	 *
	 * @var	integer
	 */
	public $contentItemID = 0;

	/**
	 * list of all content items
	 *
	 * @var	array<ContentItem>
	 */
	public $contentItems = null;

	/**
	 * content item structure
	 *
	 * @var	array
	 */
	public $contentItemStructure = null;

	/**
	 * list of content items
	 *
	 * @var	array
	 */
	public $contentItemList = array();

	/**
	 * Creates a new ContentItemList.
	 *
	 * @param	integer		$contentItemID
	 */
	public function __construct($contentItemID = 0) {
		$this->contentItemID = $contentItemID;

		// read cache
		$this->contentItems = ContentItem::getContentItems();
		$this->contentItemStructure = ContentItem::getContentItemStructure();
	}

	/**
	 * Gets the content items.
	 */
	public function readContentItems() {
		$this->clearContentItemList($this->contentItemID);
		$this->makeContentItemList($this->contentItemID);
	}

	/**
	 * Returns the content item list.
	 *
	 * @return	array
	 */
	public function getContentItemList() {
		return $this->contentItemList;
	}

	/**
	 * Returns true, if the given content item is visible.
	 *
	 * @param	ContentItem		$contentItem
	 * @return	boolean
	 */
	protected function isVisible(ContentItem $contentItem) {
		return true;
	}

	/**
	 * Removes invisible content items from content item list.
	 *
	 * @param	integer		parentID
	 */
	protected function clearContentItemList($parentID = 0) {
		if (!isset($this->contentItemStructure[$parentID])) return;

		// remove invisible content items
		foreach ($this->contentItemStructure[$parentID] as $key => $contentItemID) {
			$contentItem = $this->contentItems[$contentItemID];
			if (!$this->isVisible($contentItem)) {
				unset($this->contentItemStructure[$parentID][$key]);
				continue;
			}

			$this->clearContentItemList($contentItemID);
		}

		if (!count($this->contentItemStructure[$parentID])) {
			unset($this->contentItemStructure[$parentID]);
		}
	}

	/**
	 * Renders one level of the content item structure.
	 *
	 * @param	integer		$parentID
	 * @param	integer		$depth
	 * @param	integer		$openParents
	 */
	protected function makeContentItemList($parentID = 0, $depth = 1, $openParents = 0) {
		if (!isset($this->contentItemStructure[$parentID])) return;

		$i = 0;
		$children = count($this->contentItemStructure[$parentID]);
		foreach ($this->contentItemStructure[$parentID] as $contentItemID) {
			$contentItem = $this->contentItems[$contentItemID];
			$childrenOpenParents = $openParents + 1;
			$hasChildren = isset($this->contentItemStructure[$contentItemID]);
			$last = $i == count($this->contentItemStructure[$parentID]) - 1;
			if ($hasChildren && !$last) $childrenOpenParents = 1;

			// update content item list
			$this->contentItemList[$contentItemID] = array(
				'depth' => $depth,
				'hasChildren' => $hasChildren,
				'openParents' => ((!$hasChildren && $last) ? $openParents : 0),
				'contentItem' => $contentItem,
				'parentID' => $parentID, // necessary?
				'position' => $i + 1,
				'maxPosition' => $children
			);

			// make next level of the content item list
			$this->makeContentItemList($contentItem->contentItemID, $depth + 1, $childrenOpenParents);
			$i++;
		}
	}
}
?>