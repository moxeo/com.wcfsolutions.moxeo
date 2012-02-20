<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItemList.class.php');

/**
 * Represents an acp list of content items.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.content
 * @category	Moxeo Open Source CMS
 */
class ACPContentItemList extends ContentItemList {
	/**
	 * @see	ContentItemList::isVisible()
	 */
	protected function isVisible(ContentItem $contentItem) {
		if (!$contentItem->getAdminPermission('canAddContentItem') && !$contentItem->getAdminPermission('canEditContentItem') && !$contentItem->getAdminPermission('canDeleteContentItem') && !$contentItem->getAdminPermission('canEnableContentItem')) {
			return false;
		}
		return true;
	}
}
?>