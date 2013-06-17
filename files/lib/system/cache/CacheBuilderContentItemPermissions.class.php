<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches the content item group permissions.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	system.cache
 * @category	Moxeo Open Source CMS
 */
class CacheBuilderContentItemPermissions implements CacheBuilder {
	/**
	 * @see	CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		list($cache, $groupIDs) = explode('-', $cacheResource['cache']);
		$data = array();

		$sql = "SELECT		*
			FROM		moxeo".MOXEO_N."_content_item_to_group
			WHERE		groupID IN (".$groupIDs.")";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$contentItemID = $row['contentItemID'];
			unset($row['contentItemID'], $row['groupID']);

			foreach ($row as $permission => $value) {
				if ($value == -1) continue;

				if (!isset($data[$contentItemID][$permission])) $data[$contentItemID][$permission] = $value;
				else $data[$contentItemID][$permission] = $value || $data[$contentItemID][$permission];
			}
		}

		// inherit content item group permissions
		if (count($data)) {
			require_once(MOXEO_DIR.'lib/data/content/ContentItem.class.php');
			ContentItem::inheritPermissions(0, $data);
		}

		$data['groupIDs'] = $groupIDs;
		return $data;
	}
}
?>