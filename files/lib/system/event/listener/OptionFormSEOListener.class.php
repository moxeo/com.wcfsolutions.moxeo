<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Writes rewrite rules to the config file.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	system.event.listener
 * @category	Moxeo Open Source CMS
 */
class OptionFormSEOListener implements EventListener {
	/**
	 * @see	EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if ($eventObj->activeCategory == 'general') {
			SEOUtil::rebuildConfigFile();
		}
	}
}
?>