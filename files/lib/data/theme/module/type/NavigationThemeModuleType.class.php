<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/content/ViewableContentItemList.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/AbstractThemeModuleType.class.php');

/**
 * Represents a navigation theme module type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.theme.module.type
 * @category	Infinite Site
 */
class NavigationThemeModuleType extends AbstractThemeModuleType {
	// display methods
	/**
	 * @see	ThemeModuleType::hasContent()
	 */
	public function hasContent(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		if (!isset($additionalData['contentItem'])) return '';
		$activeContentItem = $additionalData['contentItem'];
		
		if ($themeModule->levelOffset <= ($activeContentItem->getLevel() + 1)) {
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
					
		// get parent content item
		$contentItem = $activeContentItem;
		$parentID = $contentItem->contentItemID;
		while ($parentID != 0 && $themeModule->levelOffset != ($contentItem->getLevel() + 1)) {
			$parentID = $contentItem->parentID;
			if ($parentID) {
				$contentItem = ContentItem::getContentItem($parentID);
			}
		}
		
		// init content item list
		$contentItemList = new ViewableContentItemList($parentID, $themeModule->levelOffset, $themeModule->levelLimit);
		$contentItemList->readContentItems();
		
		WCF::getTPL()->assign(array(
			'activeContentItemID' => $activeContentItem->contentItemID,
			'contentItems' => $contentItemList->getContentItemList()
		));
		return WCF::getTPL()->fetch('navigationThemeModuleType');
	}
	
	// form methods
	/**
	 * @see	ThemeModuleType::readFormParameters()
	 */
	public function readFormParameters() {
		// level start
		$this->formData['levelOffset'] = 0;
		if (isset($_POST['levelOffset'])) $this->formData['levelOffset'] = intval($_POST['levelOffset']);
		
		// level end
		$this->formData['levelLimit'] = 0;
		if (isset($_POST['levelLimit'])) $this->formData['levelLimit'] = intval($_POST['levelLimit']);
	}
	
	/**
	 * @see	ThemeModuleType::assignVariables()
	 */
	public function assignVariables() {
		WCF::getTPL()->assign(array(
			'levelOffset' => (isset($this->formData['levelOffset']) ? $this->formData['levelOffset'] : 0),
			'levelLimit' => (isset($this->formData['levelLimit']) ? $this->formData['levelLimit'] : 0)
		));
	}
	
	/**
	 * @see	ThemeModuleType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'navigationThemeModuleType';
	}
}
?>