<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/system/language/LanguageEditor.class.php');

/**
 * Provides functions to manage content items.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.content
 * @category	Moxeo Open Source CMS
 */
class ContentItemEditor extends ContentItem {
	/**
	 * Creates a new ContentItemEditor object.
	 */
	public function __construct($contentItemID, $row = null, $cacheObject = null, $useCache = true) {
		if ($useCache) parent::__construct($contentItemID, $row, $cacheObject);
		else {
			$sql = "SELECT	*
				FROM	moxeo".MOXEO_N."_content_item
				WHERE 	contentItemID = ".$contentItemID;
			$row = WCF::getDB()->getFirstRow($sql);
			parent::__construct(null, $row);
		}
	}
	
	/**
	 * Updates this content item.
	 * 
	 * @param	integer		$languageID
	 * @param	integer		$parentID
	 * @param	string		$title
	 * @param	string		$contentItemAlias
	 * @param	string		$description
	 * @param	integer		$contentItemType
	 * @param	string		$externalURL
	 * @param	string		$pageTitle
	 * @param	string		$metaDescription
	 * @param	string		$metaKeywords
	 * @param	integer		$publishingStartTime
	 * @param	integer		$publishingEndTime
	 * @param	integer		$themeLayoutID
	 * @param	string		$cssClasses
	 * @param	string		$robots
	 * @param	integer		$showOrder
	 * @param	integer		$invisible
	 * @param	integer		$addSecurityToken
	 */
	public function update($languageID, $parentID, $title, $contentItemAlias, $description, $contentItemType, $externalURL, $pageTitle, $metaDescription, $metaKeywords, $publishingStartTime, $publishingEndTime, $themeLayoutID, $cssClasses, $robots, $showOrder, $invisible, $addSecurityToken) {
		// update show order
		if ($this->showOrder != $showOrder) {
			if ($showOrder < $this->showOrder) {
				$sql = "UPDATE	moxeo".MOXEO_N."_content_item
					SET 	showOrder = showOrder + 1
					WHERE 	showOrder >= ".$showOrder."
						AND showOrder < ".$this->showOrder."
						AND parentID = ".$parentID;
				WCF::getDB()->sendQuery($sql);
			}
			else if ($showOrder > $this->showOrder) {
				$sql = "UPDATE	moxeo".MOXEO_N."_content_item
					SET	showOrder = showOrder - 1
					WHERE	showOrder <= ".$showOrder."
						AND showOrder > ".$this->showOrder."
						AND parentID = ".$parentID;
				WCF::getDB()->sendQuery($sql);
			}
		}
		
		// update item
		$sql = "UPDATE	moxeo".MOXEO_N."_content_item
			SET	languageID = ".$languageID.",
				parentID = ".$parentID.",
				title = '".escapeString($title)."',
				contentItemAlias = '".escapeString($contentItemAlias)."',
				description = '".escapeString($description)."',
				pageTitle = '".escapeString($pageTitle)."',
				metaDescription = '".escapeString($metaDescription)."',
				metaKeywords = '".escapeString($metaKeywords)."',
				contentItemType = ".$contentItemType.",
				externalURL = '".escapeString($externalURL)."',
				publishingStartTime = ".$publishingStartTime.",
				publishingEndTime = ".$publishingEndTime.",
				themeLayoutID = ".$themeLayoutID.",
				cssClasses = '".escapeString($cssClasses)."',
				robots = '".escapeString($robots)."',
				showOrder = ".$showOrder.",
				invisible = ".$invisible.",
				addSecurityToken = ".$addSecurityToken."
			WHERE	contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Updates the title of this content item.
	 * 
	 * @param	string		$title
	 */
	public function updateTitle($title) {
		$sql = "UPDATE	moxeo".MOXEO_N."_content_item
			SET	title = '".escapeString($title)."'
			WHERE	contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Refreshes the searchable content of this content item.
	 * 
	 * @param	string		$title
	 */
	public function refreshSearchableContent() {
		$searchableContent = $this->getSearchableContent();
		$sql = "UPDATE	moxeo".MOXEO_N."_content_item
			SET	searchableContent = '".escapeString($searchableContent)."'
			WHERE	contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Returns the cleaned permission list.
	 * Removes default permissions from the given permission list.
	 * 
	 * @param	array		$permissions
	 * @return	array
	 */
	public static function getCleanedPermissions($permissions) {
		$noDefaultValue = false;
		foreach ($permissions as $key => $permission) {
			foreach ($permission['settings'] as $value) {
				if ($value != -1) $noDefaultValue = true;
			}
			if (!$noDefaultValue) {
				unset($permissions[$key]);
				continue;
			}
		}
		return $permissions;
	}
	
	/**
	 * Removes the user and group permissions of this content item.
	 */
	public function removePermissions() {
		// user
		$sql = "DELETE FROM	moxeo".MOXEO_N."_content_item_to_user
			WHERE		contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
		
		// group
		$sql = "DELETE FROM	moxeo".MOXEO_N."_content_item_to_group
			WHERE		contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Adds the given permissions to this content item.
	 * 
	 * @param	array		$permissions
	 * @param	array		$permissionSettings
	 */
	public function addPermissions($permissions, $permissionSettings) {
		$userInserts = $groupInserts = '';
		foreach ($permissions as $key => $permission) {
			if ($permission['type'] == 'user') {
				if (!empty($userInserts)) $userInserts .= ',';
				$userInserts .= '('.$this->contentItemID.',
						 '.intval($permission['id']).',
						 '.(implode(', ', ArrayUtil::toIntegerArray($permission['settings']))).')';
			
			}
			else {
				if (!empty($groupInserts)) $groupInserts .= ',';
				$groupInserts .= '('.$this->contentItemID.',
						 '.intval($permission['id']).',
						 '.(implode(', ', ArrayUtil::toIntegerArray($permission['settings']))).')';
			}
		}
	
		if (!empty($userInserts)) {
			$sql = "INSERT INTO	moxeo".MOXEO_N."_content_item_to_user
						(contentItemID, userID, ".implode(', ', $permissionSettings).")
				VALUES		".$userInserts;
			WCF::getDB()->sendQuery($sql);
		}
		
		if (!empty($groupInserts)) {
			$sql = "INSERT INTO	moxeo".MOXEO_N."_content_item_to_group
						(contentItemID, groupID, ".implode(', ', $permissionSettings).")
				VALUES		".$groupInserts;
			WCF::getDB()->sendQuery($sql);
		}
	}
	
	/**
	 * Removes the admin permissions of this content item.
	 */
	public function removeAdmins() {
		$sql = "DELETE FROM	moxeo".MOXEO_N."_content_item_admin
			WHERE		contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Adds the given admins to this content item.
	 * 
	 * @param	array		$admins
	 * @param	array		$adminSettings
	 */
	public function addAdmins($admins, $adminSettings) {
		$inserts = '';
		foreach ($admins as $key => $admin) {
			if (!empty($inserts)) $inserts .= ',';
			$inserts .= '	('.$this->contentItemID.',
					'.($admin['type'] == 'user' ? intval($admin['id']) : 0).',
					'.($admin['type'] == 'group' ? intval($admin['id']) : 0).',
					 '.(implode(', ', ArrayUtil::toIntegerArray($admin['settings']))).')';
		}
		
		if (!empty($inserts)) {
			$sql = "INSERT INTO	moxeo".MOXEO_N."_content_item_admin
						(contentItemID, userID, groupID, ".implode(', ', $adminSettings).")
				VALUES		".$inserts;
			WCF::getDB()->sendQuery($sql);
		}
	}
	
	/**
	 * Deletes this content item.
	 */
	public function delete() {
		// update news archives
		$sql = "UPDATE	moxeo".MOXEO_N."_news_archive
			SET	contentItemID = 0
			WHERE	contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
		
		// get all article ids
		$articleIDs = '';
		$sql = "SELECT	articleID
			FROM	moxeo".MOXEO_N."_article
			WHERE	contentItemID = ".$this->contentItemID;
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
			if (!empty($articleIDs)) $articleIDs .= ',';
			$articleIDs .= $row['articleID'];
		}
		if (!empty($articleIDs)) {
			// delete articles
			require_once(MOXEO_DIR.'lib/data/article/ArticleEditor.class.php');
			ArticleEditor::deleteAll($articleIDs);
		}
		
		// update show order
		$sql = "UPDATE	moxeo".MOXEO_N."_content_item
			SET	showOrder = showOrder - 1
			WHERE	showOrder >= ".$this->showOrder."
				AND parentID = ".$this->parentID;
		WCF::getDB()->sendQuery($sql);
		
		// update sub content items
		$sql = "UPDATE	moxeo".MOXEO_N."_content_item
			SET	parentID = ".$this->parentID."
			WHERE	parentID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
		
		// delete category group options
		$sql = "DELETE FROM	moxeo".MOXEO_N."_content_item_to_group
			WHERE		contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
		
		// delete category user options
		$sql = "DELETE FROM	moxeo".MOXEO_N."_content_item_to_user
			WHERE		contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
		
		// delete content item
		$sql = "DELETE FROM	moxeo".MOXEO_N."_content_item
			WHERE		contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Returns the searchable content of this content item.
	 * 
	 * @return	string
	 */
	public function getSearchableContent() {
		$cache = WCF::getCache()->get('contentItemArticles');
		
		$articleIDs = '';
		if (isset($cache[$this->contentItemID]['main'])) {
			$articleIDs = implode(',', $cache[$this->contentItemID]['main']);
		}
		
		$contents = '';
		if ($articleIDs) {
			// get article sections
			$sql = "SELECT		*
				FROM		moxeo".MOXEO_N."_article_section
				WHERE		articleID IN (".$articleIDs.")
				ORDER BY	articleID, showOrder";
			$result = WCF::getDB()->sendQuery($sql);
			while ($row = WCF::getDB()->fetchArray($result)) {
				if (!isset($articleSections[$row['articleID']])) {
					$articleSections[$row['articleID']] = array();
				}
				$articleSections[$row['articleID']][] = new ArticleSection(null, $row);
			}
			
			// get articles
			$sql = "SELECT		*
				FROM		moxeo".MOXEO_N."_article
				WHERE		articleID IN (".$articleIDs.")
				ORDER BY	showOrder";
			$result = WCF::getDB()->sendQuery($sql);
			while ($row = WCF::getDB()->fetchArray($result)) {	
				$article = new Article(null, $row);
				
				// cache article section data
				if (isset($articleSections[$row['articleID']])) {
					foreach ($articleSections[$row['articleID']] as $articleSection) {
						if (!empty($contents)) $contents .= "\n";
						
						$content = $articleSection->getArticleSectionType()->getSearchableContent($articleSection, $article, $this);
						if (!empty($content)) {
							$contents .= $content;
						}
					}
				}
			}
		}
		
		return $contents;
	}
	
	/**
	 * Enables this content item.
	 */
	public function enable() {
		$sql = "UPDATE	moxeo".MOXEO_N."_content_item
			SET	enabled = 1
			WHERE	contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Disables this content item.
	 */
	public function disable() {
		$sql = "UPDATE	moxeo".MOXEO_N."_content_item
			SET	enabled = 0
			WHERE	contentItemID = ".$this->contentItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Creates a new content item.
	 * 
	 * @param	integer		$languageID
	 * @param	integer		$parentID
	 * @param	string		$title
	 * @param	string		$contentItemAlias
	 * @param	string		$description
	 * @param	integer		$contentItemType
	 * @param	string		$externalURL
	 * @param	string		$pageTitle
	 * @param	string		$metaDescription
	 * @param	string		$metaKeywords
	 * @param	integer		$publishingStartTime
	 * @param	integer		$publishingEndTime
	 * @param	integer		$themeLayoutID
	 * @param	string		$cssClasses
	 * @param	string		$robots
	 * @param	integer		$showOrder
	 * @param	integer		$invisible
	 * @param	integer		$addSecurityToken
	 * @return	ContentItemEditor
	 */
	public static function create($languageID, $parentID, $title, $contentItemAlias, $description, $contentItemType, $externalURL, $pageTitle, $metaDescription, $metaKeywords, $publishingStartTime, $publishingEndTime, $themeLayoutID, $cssClasses, $robots, $showOrder, $invisible, $addSecurityToken) {
		// get show order
		if ($showOrder == 0) {
			// get next number in row
			$sql = "SELECT	MAX(showOrder) AS showOrder
				FROM	moxeo".MOXEO_N."_content_item
				WHERE	parentID = ".$parentID;
			$row = WCF::getDB()->getFirstRow($sql);
			if (!empty($row)) $showOrder = intval($row['showOrder']) + 1;
			else $showOrder = 1;
		}
		else {
			$sql = "UPDATE	moxeo".MOXEO_N."_content_item
				SET 	showOrder = showOrder + 1
				WHERE 	showOrder >= ".$showOrder."
					AND parentID = ".$parentID;
			WCF::getDB()->sendQuery($sql);
		}
		
		// insert content item
		$sql = "INSERT INTO	moxeo".MOXEO_N."_content_item
					(languageID, parentID, title, contentItemAlias, description, pageTitle, metaDescription, metaKeywords, contentItemType, externalURL, publishingStartTime, publishingEndTime, themeLayoutID, cssClasses, robots, showOrder, enabled, invisible, addSecurityToken)
			VALUES		(".$languageID.", ".$parentID.", '".escapeString($title)."', '".escapeString($contentItemAlias)."', '".escapeString($description)."', '".escapeString($pageTitle)."', '".escapeString($metaDescription)."', '".escapeString($metaKeywords)."', ".$contentItemType.", '".escapeString($externalURL)."', ".$publishingStartTime.", ".$publishingEndTime.", ".$themeLayoutID.", '".escapeString($cssClasses)."', '".escapeString($robots)."', ".$showOrder.", ".intval(WCF::getUser()->getPermission('admin.site.canEnableContentItem')).", ".$invisible.", ".$addSecurityToken.")";
		WCF::getDB()->sendQuery($sql);
		
		// get content item id
		$contentItemID = WCF::getDB()->getInsertID("moxeo".MOXEO_N."_content_item", 'contentItemID');
		
		// create first article
		require_once(MOXEO_DIR.'lib/data/article/ArticleEditor.class.php');
		ArticleEditor::create($contentItemID, 'main', $title, '', '', 0);
		
		// return content item
		return new ContentItemEditor($contentItemID, null, null, false);
	}
	
	/**
	 * Updates the position of the content item with the given content item id.
	 * 
	 * @param	integer		$contentItemID
	 * @param	integer		$parentID
	 * @param	integer		$position
	 */
	public static function updatePosition($contentItemID, $parentID, $position) {		
		$sql = "UPDATE	moxeo".MOXEO_N."_content_item
			SET	parentID = ".$parentID.",
				showOrder = ".$position."
			WHERE 	contentItemID = ".$contentItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Resets the content item cache.
	 */
	public static function resetCache() {
		// reset cache
		WCF::getCache()->clearResource('contentItem');
		WCF::getCache()->clearResource('contentItemStructure');
		WCF::getCache()->clearResource('contentItemAlias');
		WCF::getCache()->clearResource('contentItemArticles');
		
		// reset permissions cache
		WCF::getCache()->clear(MOXEO_DIR.'cache/', 'cache.contentItemPermissions-*', true);
		
		self::$contentItems = self::$contentItemStructure = self::$contentItemSelect = null;
	}
}
?>