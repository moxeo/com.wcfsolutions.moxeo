<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/content/ViewableContentItemList.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/AbstractThemeModuleType.class.php');

/**
 * Represents a navigation theme module type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.theme.module.type
 * @category	Infinite Site
 */
class NavigationThemeModuleType extends AbstractThemeModuleType {
	// display methods
	/**
	 * @see	ThemeModuleType::getContent()
	 */
	public function getContent(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		if (!isset($additionalData['contentItem'])) return '';
		$contentItem = $additionalData['contentItem'];
		
		// get content items
		$contentItems = array();
		if ($themeModule->levelOffset <= $contentItem->getLevel()) {
			// get parent content item
			while ($contentItem->parentID != 0 && $themeModule->levelOffset != $contentItem->getLevel()) {
				$contentItem = ContentItem::getContentItem($contentItem->parentID);
			}
			
			// init content item list
			$contentItemList = new ViewableContentItemList($contentItem->parentID, $themeModule->levelOffset + $themeModule->levelLimit);
			$contentItemList->readContentItems();
			
			// update content items
			$contentItems = $contentItemList->getContentItemList();			
		}
		
		WCF::getTPL()->assign(array(
			'activeContentItemID' => $contentItem->contentItemID,
			'contentItems' => $contentItems
		));
		return WCF::getTPL()->fetch('navigationThemeModuleType');
	}
	
	// form methods
	/**
	 * @see ThemeModuleType::readFormParameters()
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
	 * @see ThemeModuleType::assignVariables()
	 */
	public function assignVariables() {
		WCF::getTPL()->assign(array(
			'levelOffset' => (isset($this->formData['levelOffset']) ? $this->formData['levelOffset'] : 0),
			'levelLimit' => (isset($this->formData['levelLimit']) ? $this->formData['levelLimit'] : 0)
		));
	}
	
	/**
	 * @see ThemeModuleType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'navigationThemeModuleType';
	}
}
?>