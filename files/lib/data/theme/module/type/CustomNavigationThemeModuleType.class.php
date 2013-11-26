<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/AbstractThemeModuleType.class.php');

/**
 * Represents a custom navigation theme module type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.theme.module.type
 * @category	Moxeo Open Source CMS
 */
class CustomNavigationThemeModuleType extends AbstractThemeModuleType {
	// display methods
	/**
	 * @see	ThemeModuleType::getContent()
	 */
	public function getContent(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		if (!isset($additionalData['contentItem'])) return '';
		$activeContentItem = $additionalData['contentItem'];

		// get content items
		$contentItems = array();
		foreach ($themeModule->contentItemIDs as $contentItemID) {
			try {
				$contentItems[] = ContentItem::getContentItem($contentItemID);
			}
			catch (IllegalLinkException $e) {}
		}

		WCF::getTPL()->assign(array(
			'activeContentItemID' => $activeContentItem->contentItemID,
			'contentItems' => $contentItems
		));
		return WCF::getTPL()->fetch('customNavigationThemeModuleType');
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
		$this->formData['contentItemIDs'] = array();
		if (isset($_POST['contentItemIDs'])) $this->formData['contentItemIDs'] = ArrayUtil::toIntegerArray($_POST['contentItemIDs']);
	}

	/**
	 * @see	ThemeModuleType::validate()
	 */
	public function validate() {
		// content item ids
		foreach ($this->formData['contentItemIDs'] as $key => $contentItemID) {
			try {
				ContentItem::getContentItem($contentItemID);
			}
			catch (IllegalLinkException $e) {
				unset($this->formData['contentItemIDs'][$key]);
			}
		}
		if (!count($this->formData['contentItemIDs'])) {
			throw new UserInputException('contentItemIDs');
		}
	}

	/**
	 * @see	ThemeModuleType::assignVariables()
	 */
	public function assignVariables() {
		WCF::getTPL()->assign(array(
			'contentItemOptions' => ContentItem::getContentItemSelect(array()),
			'contentItemIDs' => (isset($this->formData['contentItemIDs']) ? $this->formData['contentItemIDs'] : array())
		));
	}

	/**
	 * @see	ThemeModuleType::getFormTemplateName()
	 */
	public function getFormTemplateName() {
		return 'customNavigationThemeModuleType';
	}
}
?>