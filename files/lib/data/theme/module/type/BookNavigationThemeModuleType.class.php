<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/content/ViewableContentItemList.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/AbstractThemeModuleType.class.php');

/**
 * Represents a book navigation theme module type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.theme.module.type
 * @category	Infinite Site
 */
class BookNavigationThemeModuleType extends AbstractThemeModuleType {
	// display methods
	/**
	 * @see	ThemeModuleType::hasContent()
	 */
	public function hasContent(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		if (!isset($additionalData['contentItem'])) return '';
		$activeContentItem = $additionalData['contentItem'];
		
		// get content item
		$contentItem = ContentItem::getContentItem($themeModule->contentItemID);
		
		// get content items
		if ($activeContentItem->contentItemID == $contentItem->contentItemID || $contentItem->isParent($activeContentItem->contentItemID)) {
			return true;
		}
		return false;
	}
	
	/**
	 * @see	ThemeModuleType::getContent()
	 */
	public function getContent(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		if (!isset($additionalData['contentItem'])) return '';
		$activeContentItem = $additionalData['contentItem'];
		
		// get content item
		$contentItem = ContentItem::getContentItem($themeModule->contentItemID);
		
		// init content item list
		$contentItemList = new ViewableContentItemList($contentItem->contentItemID);
		$contentItemList->readContentItems();
		$contentItems = $contentItemList->getContentItemList();
		
		// get content item ids
		$contentItemIDs = array_keys($contentItems);
		array_unshift($contentItemIDs, $contentItem->contentItemID);
		
		// get keys
		$activeKey = array_search($activeContentItem->contentItemID, $contentItemIDs);
		$previousKey = $activeKey - 1;
		$nextKey = $activeKey + 1;
		
		// get previous content item
		$previousContentItem = null;
		if (isset($contentItemIDs[$previousKey])) {
			$previousContentItemID = $contentItemIDs[$previousKey];
			$previousContentItem = ContentItem::getContentItem($previousContentItemID);
		}
		
		// get up content item
		$upContentItem = null;
		if ($activeContentItem->contentItemID != $contentItem->contentItemID) {
			$upContentItem = ContentItem::getContentItem($activeContentItem->parentID);
		}
		
		// get next content item
		$nextContentItem = null;
		if (isset($contentItemIDs[$nextKey])) {
			$nextContentItemID = $contentItemIDs[$nextKey];
			$nextContentItem = ContentItem::getContentItem($nextContentItemID);
		}
		
		WCF::getTPL()->assign(array(
			'previousContentItem' => $previousContentItem,
			'upContentItem' => $upContentItem,
			'nextContentItem' => $nextContentItem
		));
		return WCF::getTPL()->fetch('bookNavigationThemeModuleType');
	}
	
	// form methods
	/**
	 * @see	ThemeModuleType::readFormParameters()
	 */
	public function readFormParameters() {
		$this->formData['contentItemID'] = 0;
		if (isset($_POST['contentItemID'])) $this->formData['contentItemID'] = intval($_POST['contentItemID']);
	}
	
	/**
	 * @see	ThemeModuleType::validate()
	 */
	public function validate() {
		// content item id
		try {
			ContentItem::getContentItem($this->formData['contentItemID']);
		}
		catch (IllegalLinkException $e) {
			throw new UserInputException('contentItemID', 'invalid');
		}
	}
	
	/**
	 * @see	ThemeModuleType::assignVariables()
	 */
	public function assignVariables() {
		WCF::getTPL()->assign(array(
			'contentItemOptions' => ContentItem::getContentItemSelect(array()),
			'contentItemID' => (isset($this->formData['contentItemID']) ? $this->formData['contentItemID'] : 0)
		));
	}
	
	/**
	 * @see	ThemeModuleType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'bookNavigationThemeModuleType';
	}
}
?>