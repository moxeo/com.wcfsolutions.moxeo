<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches the commentable object types.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	system.cache
 * @category	Infinite Site
 */
class CacheBuilderCommentableObjectTypes implements CacheBuilder {
	/**
	 * @see	CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();
		
		$sql = "SELECT	*
			FROM	wsis".WSIS_N."_commentable_object_type";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$row['className'] = StringUtil::getClassName($row['classFile']);
			$data[] = $row;
		}
		
		return $data;
	}
}
?>