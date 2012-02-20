<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches all content items aliases.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	system.cache
 * @category	Moxeo Open Source CMS
 */
class CacheBuilderContentItemAlias implements CacheBuilder {
	/**
	 * @see	CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();

		$sql = "SELECT	contentItemID, parentID, contentItemAlias
			FROM	moxeo".MOXEO_N."_content_item";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			if (!isset($data[$row['parentID']])) {
				$data[$row['parentID']] = array();
			}
			$data[$row['parentID']][$row['contentItemAlias']] = $row['contentItemID'];
		}

		return $data;
	}
}
?>