<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/content/ContentItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/theme/module/type/AbstractThemeModuleType.class.php');

/**
 * Represents a breadcrumb theme module type.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.theme.module.type
 * @category	Infinite Site
 */
class BreadCrumbThemeModuleType extends AbstractThemeModuleType {
	// display methods	
	/**
	 * @see	ThemeModuleType::getContent()
	 */
	public function getContent(ThemeModule $themeModule, $themeModulePosition, $additionalData) {
		if (!isset($additionalData['contentItem'])) return '';
		$contentItem = $additionalData['contentItem'];
		
		$indexID = ContentItem::getIndexContentItemID();
		$index = ContentItem::getContentItem($indexID);
		
		WCF::getTPL()->assign(array(
			'index' => $index,
			'contentItem' => $contentItem
		));
		return WCF::getTPL()->fetch('breadCrumbThemeModuleType');
	}
}
?>