<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/news/NewsItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObjectList.class.php');

/**
 * Represents a list of news items.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.news
 * @category	Infinite Site
 */
class NewsItemList extends DatabaseObjectList {
	/**
	 * list of news items
	 * 
	 * @var array<NewsItem>
	 */
	public $newsItems = array();
	
	/**
	 * sql order by statement
	 * 
	 * @var	string
	 */
	public $sqlOrderBy = 'news_item.time DESC';
	
	/**
	 * @see DatabaseObjectList::countObjects()
	 */
	public function countObjects() {
		$sql = "SELECT	COUNT(*) AS count
			FROM	wsis".WSIS_N."_news_item news_item
			".(!empty($this->sqlConditions) ? "WHERE ".$this->sqlConditions : '');
		$row = WCF::getDB()->getFirstRow($sql);
		return $row['count'];
	}
	
	/**
	 * @see DatabaseObjectList::readObjects()
	 */
	public function readObjects() {
		$sql = "SELECT		".(!empty($this->sqlSelects) ? $this->sqlSelects.',' : '')."
					news_item.*, user_table.username
			FROM		wsis".WSIS_N."_news_item news_item
			LEFT JOIN	wcf".WCF_N."_user user_table
			ON		(user_table.userID = news_item.userID)
			".$this->sqlJoins."
			".(!empty($this->sqlConditions) ? "WHERE ".$this->sqlConditions : '')."
			".(!empty($this->sqlOrderBy) ? "ORDER BY ".$this->sqlOrderBy : '');
		$result = WCF::getDB()->sendQuery($sql, $this->sqlLimit, $this->sqlOffset);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$this->newsItems[] = new NewsItem(null, $row);
		}
	}
	
	/**
	 * @see DatabaseObjectList::getObjects()
	 */
	public function getObjects() {
		return $this->newsItems;
	}
}
?>