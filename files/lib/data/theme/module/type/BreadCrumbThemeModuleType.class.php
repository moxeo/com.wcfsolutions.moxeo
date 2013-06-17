<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/AbstractThemeModuleType.class.php');

/**
 * Represents a breadcrumb theme module type.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.theme.module.type
 * @category	Moxeo Open Source CMS
 */
class BreadCrumbThemeModuleType extends AbstractThemeModuleType {
	// display methods
	/**
	 * @see	ThemeModuleType::getContent()
	 */
	public function getContent(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		if (!isset($additionalData['contentItem'])) return '';
		$contentItem = $additionalData['contentItem'];

		WCF::getTPL()->assign(array(
			'contentItem' => $contentItem
		));
		return WCF::getTPL()->fetch('breadCrumbThemeModuleType');
	}
}
?>