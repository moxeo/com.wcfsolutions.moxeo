<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches content item structure.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	system.cache
 * @category	Infinite Site
 */
class CacheBuilderContentItemStructure implements CacheBuilder {
	/**
	 * @see	CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();
		
		$sql = "SELECT		contentItemID, parentID
			FROM		wsis".WSIS_N."_content_item
			ORDER BY	parentID, showOrder";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			if (!isset($data[$row['parentID']])) {
				$data[$row['parentID']] = array();
			}
			$data[$row['parentID']][] = $row['contentItemID'];		
		}
		
		return $data;
	}
}
?>