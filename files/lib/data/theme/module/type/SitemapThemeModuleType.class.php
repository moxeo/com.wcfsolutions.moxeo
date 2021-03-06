<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ViewableContentItemList.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/AbstractThemeModuleType.class.php');

/**
 * Represents a sitemap theme module type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.theme.module.type
 * @category	Moxeo Open Source CMS
 */
class SitemapThemeModuleType extends AbstractThemeModuleType {
	// display methods
	/**
	 * @see	ThemeModuleType::getContent()
	 */
	public function getContent(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		// init content item list
		$contentItemList = new ViewableContentItemList($themeModule->contentItemID);
		$contentItemList->readContentItems();

		WCF::getTPL()->assign(array(
			'contentItems' => $contentItemList->getContentItemList()
		));
		return WCF::getTPL()->fetch('sitemapThemeModuleType');
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
		$this->formData['contentItemID'] = 0;
		if (isset($_POST['contentItemID'])) $this->formData['contentItemID'] = intval($_POST['contentItemID']);
	}

	/**
	 * @see	ThemeModuleType::validate()
	 */
	public function validate() {
		// content item id
		if ($this->formData['contentItemID']) {
			try {
				ContentItem::getContentItem($this->formData['contentItemID']);
			}
			catch (IllegalLinkException $e) {
				throw new UserInputException('contentItemID', 'invalid');
			}
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
		return 'sitemapThemeModuleType';
	}
}
?>