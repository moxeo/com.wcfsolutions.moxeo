<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents an article.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article
 * @category	Moxeo Open Source CMS
 */
class Article extends DatabaseObject {
	/**
	 * Creates a new Article object.
	 *
	 * @param 	integer		$articleID
	 * @param 	array		$row
	 */
	public function __construct($articleID, $row = null) {
		if ($articleID !== null) {
			$sql = "SELECT	*
				FROM 	moxeo".MOXEO_N."_article
				WHERE 	articleID = ".$articleID;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		parent::__construct($row);
	}
}
?>