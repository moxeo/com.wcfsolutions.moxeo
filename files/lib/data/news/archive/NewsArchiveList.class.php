<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/news/archive/NewsArchive.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObjectList.class.php');

/**
 * Represents a list of news archives.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.news.archive
 * @category	Moxeo Open Source CMS
 */
class NewsArchiveList extends DatabaseObjectList {
	/**
	 * list of news archives
	 *
	 * @var array<NewsArchive>
	 */
	public $newsArchives = array();

	/**
	 * sql order by statement
	 *
	 * @var	string
	 */
	public $sqlOrderBy = 'news_archive.title ASC';

	/**
	 * @see	DatabaseObjectList::countObjects()
	 */
	public function countObjects() {
		$sql = "SELECT	COUNT(*) AS count
			FROM	moxeo".MOXEO_N."_news_archive news_archive
			".(!empty($this->sqlConditions) ? "WHERE ".$this->sqlConditions : '');
		$row = WCF::getDB()->getFirstRow($sql);
		return $row['count'];
	}

	/**
	 * @see	DatabaseObjectList::readObjects()
	 */
	public function readObjects() {
		$sql = "SELECT		".(!empty($this->sqlSelects) ? $this->sqlSelects.',' : '')."
					news_archive.*,
					(SELECT COUNT(*) FROM moxeo".MOXEO_N."_news_item WHERE newsArchiveID = news_archive.newsArchiveID) AS newsItems
			FROM		moxeo".MOXEO_N."_news_archive news_archive
			".$this->sqlJoins."
			".(!empty($this->sqlConditions) ? "WHERE ".$this->sqlConditions : '')."
			".(!empty($this->sqlOrderBy) ? "ORDER BY ".$this->sqlOrderBy : '');
		$result = WCF::getDB()->sendQuery($sql, $this->sqlLimit, $this->sqlOffset);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$this->newsArchives[] = new NewsArchive(null, $row);
		}
	}

	/**
	 * @see	DatabaseObjectList::getObjects()
	 */
	public function getObjects() {
		return $this->newsArchives;
	}
}
?>