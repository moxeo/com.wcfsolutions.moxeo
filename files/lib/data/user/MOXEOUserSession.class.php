<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/user/AbstractMOXEOUserSession.class.php');

/**
 * Represents a user session in the site.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.user
 * @category	Moxeo Open Source CMS
 */
class MOXEOUserSession extends AbstractMOXEOUserSession {
	/**
	 * @see	UserSession::getGroupData()
	 */
	protected function getGroupData() {
		parent::getGroupData();

		// get content item user permissions
		$contentItemUserPermissions = array();
		$sql = "SELECT		*
			FROM		moxeo".MOXEO_N."_content_item_to_user
			WHERE		userID = ".$this->userID;
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$contentItemID = $row['contentItemID'];
			unset($row['contentItemID'], $row['userID']);
			$contentItemUserPermissions[$contentItemID] = $row;
		}

		if (count($contentItemUserPermissions)) {
			require_once(MOXEO_DIR.'lib/data/content/ContentItem.class.php');
			ContentItem::inheritPermissions(0, $contentItemUserPermissions);

			foreach ($contentItemUserPermissions as $contentItemID => $row) {
				foreach ($row as $key => $val) {
					if ($val != -1) {
						$this->contentItemPermissions[$contentItemID][$key] = $val;
					}
				}
			}
		}
	}
}
?>