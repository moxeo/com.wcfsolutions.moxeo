<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches the content item types.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	system.cache
 * @category	Infinite Site
 */
class CacheBuilderContentItemTypes implements CacheBuilder {
	/**
	 * @see	CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();
		
		// get content item type ids
		$contentItemTypeIDArray = array();
		$sql = "SELECT	contentItemTypeID 
			FROM	wsis".WSIS_N."_content_item_type";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$contentItemTypeIDArray[] = $row['contentItemTypeID'];
		}
		
		if (count($contentItemTypeIDArray) > 0) {
			$sql = "SELECT	*
				FROM	wsis".WSIS_N."_content_item_type content_item_type
				WHERE	contentItemTypeID IN (".implode(',', $contentItemTypeIDArray).")";
			$result = WCF::getDB()->sendQuery($sql);
			while ($row = WCF::getDB()->fetchArray($result)) {
				$row['className'] = StringUtil::getClassName($row['classFile']);
				$data[] = $row;
			}
		}
		
		return $data;
	}
}
?>