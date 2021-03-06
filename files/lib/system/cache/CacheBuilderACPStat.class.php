<?php
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches the acp stats.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	system.cache
 * @category	Moxeo Open Source CMS
 */
class CacheBuilderACPStat implements CacheBuilder {
	/**
	 * @see	CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();

		// get installation age
		$installationAge = (TIME_NOW - INSTALL_DATE) / 86400;
		if ($installationAge < 1) $installationAge = 1;

		// members
		$sql = "SELECT	COUNT(*) AS members
			FROM	wcf".WCF_N."_user";
		$row = WCF::getDB()->getFirstRow($sql);
		$data['members'] = $row['members'];

		// database entries and size
		$data['databaseSize'] = 0;
		$data['databaseEntries'] = 0;
		$sql = "SHOW TABLE STATUS";
		$result = WCF::getDB()->sendQuery($sql);
		while($row = WCF::getDB()->fetchArray($result)) {
			$data['databaseSize'] += $row['Data_length'] + $row['Index_length'];
			$data['databaseEntries'] += $row['Rows'];
		}

		return $data;
	}
}
?>