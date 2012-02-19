<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches content item articles.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	system.cache
 * @category	Moxeo Open Source CMS
 */
class CacheBuilderContentItemArticles implements CacheBuilder {
	/**
	 * @see	CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();
		
		$sql = "SELECT		articleID, contentItemID, themeModulePosition
			FROM		moxeo".MOXEO_N."_article
			ORDER BY	contentItemID, showOrder";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			if (!isset($data[$row['contentItemID']])) {
				$data[$row['contentItemID']] = array();
			}
			if (!isset($data[$row['contentItemID']][$row['themeModulePosition']])) {
				$data[$row['contentItemID']][$row['themeModulePosition']] = array();
			}
			$data[$row['contentItemID']][$row['themeModulePosition']][] = $row['articleID'];
		}
		
		return $data;
	}
}
?>