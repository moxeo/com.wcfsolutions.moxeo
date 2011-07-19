<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/news/archive/NewsArchive.class.php');

// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches all news archives.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	system.cache
 * @category	Infinite Site
 */
class CacheBuilderNewsArchive implements CacheBuilder {
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();
		
		$sql = "SELECT		* 
			FROM		wsis".WSIS_N."_news_archive";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$data[$row['newsArchiveID']] = new NewsArchive(null, $row);
			
		}
		
		return $data;
	}
}
?>