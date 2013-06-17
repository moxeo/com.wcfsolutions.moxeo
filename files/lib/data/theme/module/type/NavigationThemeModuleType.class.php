<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ViewableContentItemList.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/AbstractThemeModuleType.class.php');

/**
 * Represents a navigation theme module type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.theme.module.type
 * @category	Moxeo Open Source CMS
 */
class NavigationThemeModuleType extends AbstractThemeModuleType {
	/**
	 * cached content item lists
	 *
	 * @var	array<ViewableContentItemList>
	 */
	public $cache = array();

	// display methods
	/**
	 * @see	ThemeModuleType::hasContent()
	 */
	public function hasContent(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		if (!isset($additionalData['contentItem'])) return '';
		$activeContentItem = $additionalData['contentItem'];

		// check level and offset
		if ($themeModule->levelOffset > ($activeContentItem->getLevel() + 1)) {
			return false;
		}

		// get parent content item
		$contentItem = $activeContentItem;
		$rootID = $activeContentItem->getRootID();
		$parentID = $contentItem->contentItemID;
		while ($parentID != $rootID && $themeModule->levelOffset != ($contentItem->getLevel() + 1)) {
			$parentID = $contentItem->parentID;
			if ($parentID) {
				$contentItem = ContentItem::getContentItem($parentID);
			}
		}

		// init content item list
		$contentItemList = new ViewableContentItemList($parentID, $themeModule->levelOffset, $themeModule->levelLimit);
		$contentItemList->readContentItems();
		if (!count($contentItemList->getContentItemList())) {
			return false;
		}

		$this->cache[$themeModule->themeModuleID.'@'.$themeModulePosition] = $contentItemList;
		return true;
	}

	/**
	 * @see	ThemeModuleType::getContent()
	 */
	public function getContent(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		if (!isset($additionalData['contentItem'])) return '';
		$activeContentItem = $additionalData['contentItem'];

		if (!isset($this->cache[$themeModule->themeModuleID.'@'.$themeModulePosition])) return '';
		$contentItemList = $this->cache[$themeModule->themeModuleID.'@'.$themeModulePosition];

		WCF::getTPL()->assign(array(
			'activeContentItemID' => $activeContentItem->contentItemID,
			'contentItems' => $contentItemList->getContentItemList()
		));
		return WCF::getTPL()->fetch('navigationThemeModuleType');
	}

	/**
	 * @see	ThemeModuleType::getHTMLTag()
	 */
	public function getHTMLTag() {
		return 'nav';
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