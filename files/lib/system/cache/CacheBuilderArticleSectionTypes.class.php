<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches the article section types.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	system.cache
 * @category	Moxeo Open Source CMS
 */
class CacheBuilderArticleSectionTypes implements CacheBuilder {
	/**
	 * @see	CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();

		$sql = "SELECT	*
			FROM	moxeo".MOXEO_N."_article_section_type";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$row['className'] = StringUtil::getClassName($row['classFile']);
			$data[] = $row;
		}

		return $data;
	}
}
?>