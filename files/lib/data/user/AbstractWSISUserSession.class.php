<?php
// wcf imports
require_once(WCF_DIR.'lib/system/session/UserSession.class.php');

/**
 * Abstract class for wsis user and guest sessions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.user
 * @category	Infinite Site
 */
class AbstractWSISUserSession extends UserSession {
	/**
	 * list of content item user permissions
	 * 
	 * @var	array
	 */
	protected $contentItemPermissions = array();
	
	/**
	 * list of content item admin permissions
	 * 
	 * @var	array
	 */
	protected $contentItemAdminPermissions = array();
	
	/**
	 * Checks whether this user has the permission with the given name on the content item with the given content item id.
	 * 
	 * @param	string		$permission
	 * @param	integer		$contentItemID
	 * @return	mixed
	 */
	public function getContentItemPermission($permission, $contentItemID) {
		if (isset($this->contentItemPermissions[$contentItemID][$permission])) {
			return $this->contentItemPermissions[$contentItemID][$permission];
		}
		return $this->getPermission('user.site.'.$permission);
	}
	
	/**
	 * Checks whether this user has the admin permission with the given name on the content item with the given content item id.
	 * 
	 * @param	string		$permission
	 * @param	integer		$contentItemID
	 * @return	mixed
	 */
	public function getContentItemAdminPermission($permission, $contentItemID) {
		// content item admins have all permissions
		if ($this->getPermission('admin.site.isContentItemAdmin')) {
			return true;
		}
		
		if (isset($this->contentItemAdminPermissions[$contentItemID][$permission])) {
			return $this->contentItemAdminPermissions[$contentItemID][$permission];
		}
		return $this->getPermission('admin.site.'.$permission);
	}
	
	/**
	 * @see UserSession::getGroupData()
	 */
	protected function getGroupData() {
		parent::getGroupData();
		
		// get content item group permissions from cache
		$groups = implode(',', $this->groupIDs);
		$groupsFilename = StringUtil::getHash(implode('-', $this->groupIDs));
		
		// register cache resource
		WCF::getCache()->addResource('contentItemPermissions-'.$groups, WSIS_DIR.'cache/cache.contentItemPermissions-'.$groupsFilename.'.php', WSIS_DIR.'lib/system/cache/CacheBuilderContentItemPermissions.class.php');
		
		// get content item group data from cache
		$this->contentItemPermissions = WCF::getCache()->get('contentItemPermissions-'.$groups);
		if (isset($this->contentItemPermissions['groupIDs']) && $this->contentItemPermissions['groupIDs'] != $groups) {
			$this->contentItemPermissions = array();
		}
		
		// get content item admin permissions
		$sql = "SELECT		*
			FROM		wsis".WSIS_N."_content_item_admin
			WHERE		groupID IN (".implode(',', $this->groupIDs).")
					".($this->userID ? " OR userID = ".$this->userID : '')."
			ORDER BY 	userID DESC";
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$contentItemID = $row['contentItemID'];
			unset($row['contentItemID'], $row['userID'], $row['groupID']);
			
			if (!isset($this->contentItemAdminPermissions[$contentItemID])) {
				$this->contentItemAdminPermissions[$contentItemID] = array();
			}
			
			foreach ($row as $permission => $value) {
				if ($value == -1) continue;
				
				if (!isset($this->contentItemAdminPermissions[$contentItemID][$permission])) $this->contentItemAdminPermissions[$contentItemID][$permission] = $value;
				else $this->contentItemAdminPermissions[$contentItemID][$permission] = $value || $this->contentItemAdminPermissions[$contentItemID][$permission];
			}
		}
		
		if (count($this->contentItemAdminPermissions)) {
			require_once(WSIS_DIR.'lib/data/content/ContentItem.class.php');
			ContentItem::inheritPermissions(0, $this->contentItemAdminPermissions);
		}
	}
}
?>