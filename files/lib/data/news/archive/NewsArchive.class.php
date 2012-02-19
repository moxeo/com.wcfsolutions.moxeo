<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents a news archive.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.news.archive
 * @category	Moxeo Open Source CMS
 */
class NewsArchive extends DatabaseObject {
	/**
	 * list of all news archives
	 * 
	 * @var	array<NewsArchive>
	 */
	protected static $newsArchives = null;
	
	/**
	 * content item object
	 * 
	 * @var	ContentItem
	 */
	protected $contentItem = null;
	
	/**
	 * Creates a new NewsArchive object.
	 * 
	 * @param 	integer		$newsArchiveID
	 * @param 	array		$row
	 * @param 	NewsArchive	$cacheObject
	 */
	public function __construct($newsArchiveID, $row = null, $cacheObject = null) {
		if ($newsArchiveID !== null) $cacheObject = self::getNewsArchive($newsArchiveID);
		if ($row != null) parent::__construct($row);
		if ($cacheObject != null) parent::__construct($cacheObject->data);
	}
	
	/**
	 * Returns the title of this news archive.
	 * 
	 * @return	string
	 */
	public function __toString() {
		return $this->title;
	}
	
	/**
	 * Returns the content item object of this news archive.
	 * 
	 * @return	ContentItem
	 */
	public function getContentItem() {
		if ($this->contentItem === null) {
			$this->contentItem = new ContentItem($this->contentItemID);
		}
		return $this->contentItem;
	}
	
	/**
	 * Returns a list of all news archives.
	 * 
	 * @return 	array<NewsArchive>
	 */
	public static function getNewsArchives() {
		if (self::$newsArchives === null) {
			self::$newsArchives = WCF::getCache()->get('newsArchive');
		}
		
		return self::$newsArchives;
	}
	
	/**
	 * Returns the news archive with the given news archive id from cache.
	 * 
	 * @param 	integer		$newsArchiveID
	 * @return	NewsArchive
	 */
	public static function getNewsArchive($newsArchiveID) {
		$newsArchives = self::getNewsArchives();
		
		if (!isset($newsArchives[$newsArchiveID])) {
			throw new IllegalLinkException();
		}
		
		return $newsArchives[$newsArchiveID];
	}
}
?>