<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/Article.class.php');
require_once(WSIS_DIR.'lib/data/article/section/ArticleSection.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents a content item.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.content
 * @category	Infinite Site
 */
class ContentItem extends DatabaseObject {
	/**
	 * list of all content items
	 * 
	 * @var	array<ContentItem>
	 */
	protected static $contentItems = null;
	
	/**
	 * content item structure
	 * 
	 * @var	array
	 */
	protected static $contentItemStructure = null;
	
	/**
	 * content item options
	 * 
	 * @var	array
	 */
	protected static $contentItemSelect;
	
	/**
	 * list of parent content items
	 * 
	 * @var	array<ContentItem>
	 */
	protected static $parentContentItems = null;
	
	/**
	 * Defines that a content item acts as a page.
	 */
	const TYPE_PAGE = 0;
	
	/**
	 * Defines that a content item acts as an external link.
	 */
	const TYPE_LINK = 1;
	
	/**
	 * Defines that a content item acts as an error 403 page.
	 */
	const TYPE_ERROR_403 = 2;
	
	/**
	 * Defines that a content item acts as an error 404 page.
	 */
	const TYPE_ERROR_404 = 3;
	
	/**
	 * Creates a new ContentItem object.
	 * 
	 * @param 	integer		$contentItemID
	 * @param 	array		$row
	 * @param 	ContentItem	$cacheObject
	 */
	public function __construct($contentItemID, $row = null, $cacheObject = null) {
		if ($contentItemID !== null) $cacheObject = self::getContentItem($contentItemID);
		if ($row != null) parent::__construct($row);
		if ($cacheObject != null) parent::__construct($cacheObject->data);
	}
	
	/**
	 * Enters this content item.
	 */
	public function enter() {		
		// check permissions
		if (!$this->getPermission('canViewContentItem') || !$this->getPermission('canEnterContentItem') || ((!$this->enabled || !$this->isPublished()) && !$this->getPermission('canViewHiddenContentItem'))) {
			throw new PermissionDeniedException();
		}
	}
	
	/**
	 * Returns true, if this content item is published.
	 * 
	 * @return	boolean
	 */
	public function isPublished() {
		if ($this->publishingStartTime && $this->publishingStartTime > TIME_NOW) {
			return false;
		}
		if ($this->publishingEndTime && $this->publishingEndTime <= TIME_NOW) {
			return false;
		}
		return true;
	}
	
	/**
	 * Returns the formatted description of this item.
	 * 
	 * @return	string
	 */
	public function getFormattedDescription() {
		return nl2br(StringUtil::encodeHTML($this->description));
	}
	
	/**
	 * Returns the page title.
	 * 
	 * @return	string
	 */
	public function getPageTitle() {
		if ($this->pageTitle) {
			return $this->pageTitle;
		}
		return $this->title;
	}
	
	/**
	 * Returns the url of this content item.
	 * 
	 * @return string
	 */
	public function getURL() {
		$contentItemURL = URL_PREFIX;
		foreach ($this->getParentContentItems() as $parentContentItem) {
			$contentItemURL .= $parentContentItem->contentItemAlias.'/';
		}
		$contentItemURL .= $this->contentItemAlias.'/';
		return $contentItemURL;
	}
	
	/**
	 * Returns the flag icon for the content item language.
	 * 
	 * @return	string
	 */
	public function getLanguageIcon() {
		$languageData = Language::getLanguage($this->languageID);
		if ($languageData !== null) {
			return '<img src="'.RELATIVE_WCF_DIR.'icon/language'.ucfirst($languageData['languageCode']).'S.png" alt="" title="'.WCF::getLanguage()->get('wcf.global.language.'.$languageData['languageCode']).'" />';
		}
		return '';
	}
	
	/**
	 * Returns true, if this content item is a page.
	 * 
	 * @return	boolean
	 */
	public function isPage() {
		if ($this->contentItemType == self::TYPE_PAGE) {
			return true;
		}
		return false;
	}
	
	/**
	 * Returns true, if this content item is an external link.
	 * 
	 * @return	boolean
	 */
	public function isExternalLink() {
		if ($this->contentItemType == self::TYPE_LINK) {
			return true;
		}
		return false;
	}
	
	/**
	 * Returns true, if this content item is an error page with the given error type.
	 * 
	 * @param	string		$errorType
	 * @return	boolean
	 */
	public function isErrorPage($errorType = '404') {
		if ($errorType == '404' && $this->contentItemType == self::TYPE_ERROR_404) {
			return true;
		}
		else if ($errorType == '403' && $this->contentItemType == self::TYPE_ERROR_403) {
			return true;
		}
		return false;
	}
	
	/**
	 * Returns true, if this content item is a visible page.
	 * 
	 * @return	boolean
	 */
	public function isVisiblePage() {
		if (!$this->invisible && ($this->isPage() || $this->isExternalLink())) {
			return true;
		}
		return false;
	}
	
	/**
	 * Returns the icon of this content item.
	 * 
	 * @return	string
	 */
	public function getIcon() {
		if ($this->isExternalLink()) {
			return 'contentItemRedirect';
		}
		return 'contentItem';
	}
	
	/**
	 * Returns a list of the parent content items of this item.
	 * 
	 * @return	array
	 */
	public function getParentContentItems() {
		if ($this->parentContentItems === null) {
			$this->parentContentItems = array();
			$contentItems = self::getContentItems();
			
			$parentContentItem = $this;
			while ($parentContentItem->parentID != 0) {
				$parentContentItem = $contentItems[$parentContentItem->parentID];
				array_unshift($this->parentContentItems, $parentContentItem);
			}
		}
		
		return $this->parentContentItems;
	}
	
	/**
	 * Returns the level of this content item.
	 * 
	 * @return	integer
	 */
	public function getLevel() {
		$parentContentItems = $this->getParentContentItems();
		return count($parentContentItems);
	}
	
	/**
	 * Returns true, if this content item is the parent of the content item with the given id.
	 * 
	 * @param	integer		$childID
	 * @return	boolean
	 */
	public function isParent($childID) {
		return self::searchChildren($this->contentItemID, $childID);
	}
	
	/**
	 * Returns true, if the active user has the permission with the given name on this content item.
	 * 
	 * @param	string		$permission
	 * @return	boolean
	 */
	public function getPermission($permission = 'canViewContentItem') {
		return (boolean) WCF::getUser()->getContentItemPermission($permission, $this->contentItemID);
	}
	
	/**
	 * Returns true, if the active user has the admin permission with the given name on this content item.
	 * 
	 * @param	string		$permission
	 * @return	boolean
	 */
	public function getAdminPermission($permission) {
		return (boolean) WCF::getUser()->getContentItemAdminPermission($permission, $this->contentItemID);
	}
	
	/**
	 * Checks the requested permission on this content item.
	 * Throws a PermissionDeniedException if the permission is false.
	 * 
	 * @param	mixed		$permissions
	 */
	public function checkAdminPermission($permissions) {
		if (!is_array($permissions)) $permissions = array($permissions);
		
		$result = false;
		foreach ($permissions as $permission) {
			$result = $result || $this->getAdminPermission($permission);
		}
		
		if (!$result) {
			throw new PermissionDeniedException();
		}
	}
	
	/**
	 * Returns an editor object for this content item.
	 *
	 * @return	ContentItemEditor
	 */
	public function getEditor() {
		require_once(WSIS_DIR.'lib/data/content/ContentItemEditor.class.php');
		return new ContentItemEditor(null, $this->data);
	}
	
	/**
	 * Returns the content item structure.
	 * 
	 * @return 	array
	 */
	public static function getContentItemStructure() {
		if (self::$contentItemStructure === null) {
			self::$contentItemStructure = WCF::getCache()->get('contentItemStructure');
		}
		
		return self::$contentItemStructure;
	}
	
	/**
	 * Returns a list of all content items.
	 * 
	 * @return 	array<ContentItem>
	 */
	public static function getContentItems() {
		if (self::$contentItems === null) {
			self::$contentItems = WCF::getCache()->get('contentItem');
		}
		
		return self::$contentItems;
	}
	
	/**
	 * Returns the content item with the given content item id from cache.
	 * 
	 * @param 	integer		$contentItemID
	 * @return	ContentItem
	 */
	public static function getContentItem($contentItemID) {
		$contentItems = self::getContentItems();
		
		if (!isset($contentItems[$contentItemID])) {
			throw new IllegalLinkException();
		}
		
		return $contentItems[$contentItemID];
	}
	
	/**
	 * Creates the content item select list.
	 * 
	 * @param	array		$permissions
	 * @param	array		$ignoredContentItems
	 * @return 	array
	 */
	public static function getContentItemSelect($permissions = array('canViewContentItem'), $adminPermissions = array(), $ignoredTypes = array(), $ignoredContentItems = array()) {
		self::$contentItemSelect = array();
		
		self::getContentItems();
		self::getContentItemStructure();
		self::makeContentItemSelect(0, 0, $permissions, $adminPermissions, $ignoredTypes, $ignoredContentItems);
		
		return self::$contentItemSelect;
	}
	
	/**
	 * Generates the content item select list.
	 * 
	 * @param	integer		$parentID
	 * @param	integer		$depth
	 * @param	array		$permissions
	 * @param	array		$ignoredContentItems
	 */
	protected static function makeContentItemSelect($parentID = 0, $depth = 0, $permissions = array('canViewContentItem'), $adminPermissions = array(), $ignoredTypes = array(), $ignoredContentItems = array()) {
		if (!isset(self::$contentItemStructure[$parentID])) return;
		
		foreach (self::$contentItemStructure[$parentID] as $contentItemID) {
			if (in_array($contentItemID, $ignoredContentItems)) continue;
			$contentItem = self::$contentItems[$contentItemID];
			if (in_array($contentItem->contentItemType, $ignoredTypes)) continue;
			
			// permissions
			$result = true;
			foreach ($permissions as $permission) {
				$result = $result && $contentItem->getPermission($permission);
			}
			if (!$result) continue;
			
			// admin permissions
			$result = true;
			foreach ($adminPermissions as $permission) {
				$result = $result && $contentItem->getAdminPermission($permission);
			}
			if (!$result) continue;
			
			$title = StringUtil::encodeHTML($contentItem->title);
			if ($depth > 0) $title = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $depth). ' '.$title;
			
			self::$contentItemSelect[$contentItemID] = $title;
			self::makeContentItemSelect($contentItemID, $depth + 1, $permissions, $ignoredTypes, $ignoredContentItems);
		}
	}

	/**
	 * Searches for a content item in the child tree of another content item.
	 * 
	 * @param	integer		$parentID
	 * @param	integer		$searchedContentItemID
	 */
	public static function searchChildren($parentID, $searchedContentItemID) {
		$contentItemStructure = self::getContentItemStructure();
		if (isset($contentItemStructure[$parentID])) {
			foreach ($contentItemStructure[$parentID] as $contentItemID) {
				if ($contentItemID == $searchedContentItemID) return true;
				if (self::searchChildren($contentItemID, $searchedContentItemID)) return true;
			}
		}		
		return false;
	}
	
	/** 
	 * Inherits content item permissions.
	 * 
	 * @param 	integer 	$parentID
	 * @param 	array 		$permissions
	 */
	public static function inheritPermissions($parentID = 0, &$permissions) {
		$contentItems = self::getContentItems();
		$contentItemStructure = self::getContentItemStructure();
		
		if (isset($contentItemStructure[$parentID]) && is_array($contentItemStructure[$parentID])) {
			foreach ($contentItemStructure[$parentID] as $contentItemID) {
				$contentItem = $contentItems[$contentItemID];
				
				// inherit permissions from parent content item
				if ($contentItem->parentID) {
					if (isset($permissions[$contentItem->parentID]) && !isset($permissions[$contentItemID])) {
						$permissions[$contentItemID] = $permissions[$contentItem->parentID];
					}
				}
				
				self::inheritPermissions($contentItemID, $permissions);
			}
		}
	}
	
	/**
	 * Returns available permission settings.
	 * 
	 * @return 	array
	 */
	public static function getPermissionSettings() {
		$sql = "SHOW COLUMNS FROM wsis".WSIS_N."_content_item_to_group";
		$result = WCF::getDB()->sendQuery($sql);
		$settings = array();
		while ($row = WCF::getDB()->fetchArray($result)) {
			if ($row['Field'] != 'contentItemID' && $row['Field'] != 'groupID') {
				$settings[] = $row['Field'];
			}
		}
		return $settings;
	}
	
	/**
	 * Returns available admin permission settings.
	 * 
	 * @return 	array
	 */
	public static function getAdminSettings() {
		$sql = "SHOW COLUMNS FROM wsis".WSIS_N."_content_item_admin";
		$result = WCF::getDB()->sendQuery($sql);
		$settings = array();
		while ($row = WCF::getDB()->fetchArray($result)) {
			if ($row['Field'] != 'contentItemID' && $row['Field'] != 'userID' && $row['Field'] != 'groupID') {
				$settings[] = $row['Field'];
			}
		}
		return $settings;
	}
	
	/**
	 * Searches in content items.
	 * 
	 * @param	string		$query
	 * @return	array<ContentItem>
	 */
	public static function search($query, $limit, $offset) {
		$contentItems = array();
		
		$sql = "SELECT		contentItemID 
			FROM		wsis".WSIS_N."_content_item
			WHERE		searchableContent LIKE '%".escapeString($query)."%'
			ORDER BY	parentID, showOrder";
		$result = WCF::getDB()->sendQuery($sql, $limit, $offset);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$contentItems[] = new ContentItem($row['contentItemID']);
		}
		
		return $contentItems;
	}
	
	/**
	 * Returns the error content item id with the given error type and the given language id.
	 * 
	 * @param	string		$errorType
	 * @param	integer		$languageID
	 * @return	integer
	 */
	public static function getErrorContentItemID($errorType = '404', $languageID = 0) {
		if ($languageID == 0) {
			$languageID = Language::getDefaultLanguageID();
			if (is_object(WCF::getLanguage())) {
				$languageID = WCF::getLanguage()->getLanguageID();
			}
		}
		
		$contentItems = self::getContentItems();
		
		foreach ($contentItems as $contentItem) {
			if ($contentItem->languageID == $languageID && $contentItem->isErrorPage($errorType)) {
				return $contentItem->contentItemID;
			}
		}
		
		return 0;
	}
	
	/**
	 * Returns the index content item id with the given language id.
	 * 
	 * @param	integer		$languageID
	 * @return	integer
	 */
	public static function getIndexContentItemID($languageID = 0) {
		if ($languageID == 0) {
			$languageID = Language::getDefaultLanguageID();
			if (is_object(WCF::getLanguage())) {
				$languageID = WCF::getLanguage()->getLanguageID();
			}
		}
		
		$contentItemStructure = self::getContentItemStructure();
		
		foreach (self::$contentItemStructure as $contentItemIDArray) {
			foreach ($contentItemIDArray as $contentItemID) {
				$contentItem = new ContentItem($contentItemID);
				if ($contentItem->isVisiblePage() && $contentItem->languageID == $languageID) {
					return $contentItemID;
				}
			}
			
		}
		
		return 0;		
	}
}
?>