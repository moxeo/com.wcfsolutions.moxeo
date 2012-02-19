<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItemEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Refreshes the searchable content of content items.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	system.event.listener
 * @category	Moxeo Open Source CMS
 */
class ThemeModuleAddFormContentItemListener implements EventListener {
	/**
	 * @see	EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		$contentItems = ContentItem::getContentItems();
		foreach ($contentItems as $contentItem) {
			$searchableContent = $eventObj->themeModule->getThemeModuleType()->getSearchableContent($eventObj->themeModule, 'main', array('contentItem' => $contentItem));
			if ($searchableContent) {
				$contentItem->getEditor()->refreshSearchableContent();
			}
		}
	}
}
?>