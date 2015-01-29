<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/Article.class.php');
require_once(MOXEO_DIR.'lib/data/article/section/ArticleSection.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents a content item.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.content
 * @category	Moxeo Open Source CMS
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
	protected $parentContentItems = null;

	/**
	 * Defines that a content item acts as a root page.
	 */
	const TYPE_ROOT = -1;

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
		return ((!$this->publishingStartTime || $this->publishingStartTime <= TIME_NOW)
			&& (!$this->publishingEndTime || $this->publishingEndTime > TIME_NOW));
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
		// use external url
		if ($this->isExternalLink()) {
			return $this->externalURL;
		}

		// generate url
		$contentItemURL = URL_PREFIX;
		foreach ($this->getParentContentItems() as $parentContentItem) {
			if (!$parentContentItem->isRoot() || $parentContentItem->contentItemAlias != '') {
				$contentItemURL .= $parentContentItem->contentItemAlias.'/';
			}
		}
		if (!$this->isRoot() || $this->contentItemAlias != '') {
			$contentItemURL .= $this->contentItemAlias.'/';
		}

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
	 * Returns true, if this content item is the root of the website.
	 *
	 * @return	boolean
	 */
	public function isRoot() {
		return ($this->contentItemType == self::TYPE_ROOT);
	}

	/**
	 * Returns true, if this content item is a page.
	 *
	 * @return	boolean
	 */
	public function isPage() {
		return ($this->contentItemType == self::TYPE_PAGE);
	}

	/**
	 * Returns true, if this content item is an external link.
	 *
	 * @return	boolean
	 */
	public function isExternalLink() {
		return ($this->contentItemType == self::TYPE_LINK);
	}

	/**
	 * Returns true, if this content item is an error page with the given error type.
	 *
	 * @param	string		$errorType
	 * @return	boolean
	 */
	public function isErrorPage($errorType = '404') {
		return ($errorType == '404' && $this->contentItemType == self::TYPE_ERROR_404
			|| $errorType == '403' && $this->contentItemType == self::TYPE_ERROR_403);
	}

	/**
	 * Returns true, if this content item is a visible page.
	 *
	 * @return	boolean
	 */
	public function isVisiblePage() {
		return (!$this->invisible && ($this->isPage() || $this->isExternalLink()));
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
				//if ($parentContentItem->isRoot()) break;
				array_unshift($this->parentContentItems, $parentContentItem);
			}
		}

		return $this->parentContentItems;
	}

	/**
	 * Returns the root object of this content item.
	 *
	 * @return	ContentItem
	 */
	public function getRoot() {
		$contentItems = self::getContentItems();

		$parentContentItem = $this;
		while ($parentContentItem->parentID != 0) {
			$parentContentItem = $contentItems[$parentContentItem->parentID];
		}

		return $parentContentItem;
	}

	/**
	 * Returns the root id of this content item.
	 *
	 * @return	integer
	 */
	public function getRootID() {
		return $this->getRoot()->contentItemID;
	}

	/**
	 * Returns the level of this content item (based on the root).
	 *
	 * @return	integer
	 */
	public function getLevel() {
		$parentContentItems = $this->getParentContentItems();
		return count($parentContentItems) - 1;
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
		require_once(MOXEO_DIR.'lib/data/content/ContentItemEditor.class.php');
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
		$sql = "SHOW COLUMNS FROM moxeo".MOXEO_N."_content_item_to_group";
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
		$sql = "SHOW COLUMNS FROM moxeo".MOXEO_N."_content_item_admin";
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
	 * Returns the number of search results matching the given query.
	 *
	 * @param	string		$query
	 * @return	integer
	 */
	public static function countSearchResults($query) {
		$sql = "SELECT	COUNT(*) AS count
			FROM	moxeo".MOXEO_N."_content_item
			WHERE	searchableContent LIKE '%".escapeString($query)."%'";
		$row = WCF::getDB()->getFirstRow($sql);
		return $row['count'];
	}

	/**
	 * Searches in content items.
	 *
	 * @param	string		$query
	 * @param	integer		$limit
	 * @param	integer		$offset
	 * @return	array<ContentItem>
	 */
	public static function search($query, $limit, $offset) {
		$contentItems = array();

		$sql = "SELECT		contentItemID
			FROM		moxeo".MOXEO_N."_content_item
			WHERE		title LIKE '%".escapeString($query)."%'
					OR searchableContent LIKE '%".escapeString($query)."%'
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
	 * @param	integer		$rootID
	 * @param	string		$errorType
	 * @return	integer
	 */
	public static function getErrorContentItemID($rootID, $errorType = '404') {
		$contentItemIDs = self::getSubContentItemIDArray($rootID);

		foreach ($contentItemIDs as $contentItemID) {
			$contentItem = ContentItem::getContentItem($contentItemID);
			if ($contentItem->isErrorPage($errorType)) {
				return $contentItem->contentItemID;
			}
		}

		return 0;
	}

	/**
	 * Returns the super root id. The super root is the content item with no alias.
	 *
	 * @return	integer
	 */
	public static function getSuperRootID() {
		// find root page with empty alias
		$cache = WCF::getCache()->get('contentItemAlias');
		foreach ($cache[0] as $contentItemAlias => $contentItemID) {
			if (empty($contentItemAlias)) {
				return $contentItemID;
			}
		}

		return 0;
	}

	/**
	 * Returns the first root id.
	 *
	 * @return	integer
	 */
	public static function getFirstRootID() {
		$cache = self::getContentItemStructure();

		if (isset($cache[0])) {
			return reset($cache[0]);
		}

		return 0;
	}

	/**
	 * Returns the language id of the root which a user with a new session most likely wants to see.
	 *
	 * @return	integer
	 */
	public static function getInitialRootLanguageID() {
		// load language cache if first language has not been initialized yet
		if (Language::$cache === null) {
			Language::$cache = WCF::getCache()->get('languages');
		}

		$languageCode = Language::$cache['languages'][Language::$cache['default']]['languageCode'];

		// get available language codes
		$availableLanguageCodes = array();
		foreach (Language::getAvailableLanguages(PACKAGE_ID) as $language) {
			$availableLanguageCodes[] = $language['languageCode'];
		}

		// get preferred language
		$languageCode = Language::getPreferredLanguage($availableLanguageCodes, $languageCode);

		// get language id of preferred language
		$languageID = 0;
		foreach (Language::$cache['languages'] as $key => $language) {
			if ($language['languageCode'] == $languageCode) {
				$languageID = $key;
				break;
			}
		}

		return $languageID;
	}

	/**
	 * Returns the index content item id with the given language id.
	 *
	 * @param	integer		$rootID
	 * @param	integer		$languageID
	 * @return	integer
	 */
	public static function getRootIDByLanguageID($languageID) {
		$contentItemStructure = self::getContentItemStructure();

		$fallbackRootID = 0;

		if (isset($contentItemStructure[0])) {
			foreach ($contentItemStructure[0] as $contentItemID) {
				$fallbackRootID = $contentItemID;

				$contentItem = ContentItem::getContentItem($contentItemID);
				// todo: check permissions
				if ($contentItem->languageID == $languageID) {
					return $contentItemID;
				}

			}
		}

		return $fallbackRootID;
	}

	/**
	 * Returns the index content item id with the given language id.
	 *
	 * @param	integer		$rootID
	 * @return	integer
	 */
	public static function getIndexContentItemID($rootID) {
		$contentItemStructure = self::getContentItemStructure();

		if (isset($contentItemStructure[$rootID])) {
			foreach ($contentItemStructure[$rootID] as $contentItemID) {
				$contentItem = ContentItem::getContentItem($contentItemID);
				// todo: check permissions
				if ($contentItem->isVisiblePage()) {
					return $contentItemID;
				}

			}
		}

		return 0;
	}

	/**
	 * Returns an array of sub content items of the content item with the given id.
	 *
	 * @param	mixed		$contentItemID
	 * @return	array<integer>
	 */
	public static function getSubContentItemIDArray($contentItemID) {
		$contentItemIDArray = (is_array($contentItemID) ? $contentItemID : array($contentItemID));
		$subContentItemIDArray = array();

		foreach ($contentItemIDArray as $contentItemID) {
			$subContentItemIDArray = array_merge($subContentItemIDArray, self::makeSubContentItemIDArray($contentItemID));
		}

		$subContentItemIDArray = array_unique($subContentItemIDArray);
		return $subContentItemIDArray;
	}

	/**
	 * Creates an array of sub content items of the content item with the given id.
	 *
	 * @param	integer		$parentContentItemID
	 * @return	array<integer>
	 */
	public static function makeSubContentItemIDArray($parentContentItemID) {
		$contentItemStructure = self::getContentItemStructure();
		if (!isset($contentItemStructure[$parentContentItemID])) {
			return array();
		}

		$subContentItemIDArray = array();
		foreach ($contentItemStructure[$parentContentItemID] as $contentItemID) {
			$subContentItemIDArray = array_merge($subContentItemIDArray, self::makeSubContentItemIDArray($contentItemID));
			$subContentItemIDArray[] = $contentItemID;
		}

		return $subContentItemIDArray;
	}
}
?>