<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/news/NewsItem.class.php');

/**
 * Provides functions to manage news items.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.news
 * @category	Infinite Site
 */
class NewsItemEditor extends NewsItem {
	/**
	 * Updates this news item.
	 * 
	 * @param	integer		$userID
	 * @param	string		$title
	 * @param	string		$newsItemAlias
	 * @param	string		$teaser
	 * @param	string		$text
	 * @param	string		$cssID
	 * @param	string		$cssClasses
 	 * @param	string		$publishingStartTime
	 * @param	string		$publishingEndTime
	 */
	public function update($userID, $title, $newsItemAlias, $teaser, $text, $cssID, $cssClasses, $publishingStartTime, $publishingEndTime) {
		$sql = "UPDATE	wsis".WSIS_N."_news_item
			SET	userID = ".$userID.",
				title = '".escapeString($title)."',
				newsItemAlias = '".escapeString($newsItemAlias)."',
				teaser = '".escapeString($teaser)."',
				text = '".escapeString($text)."',
				cssID = '".escapeString($cssID)."',
				cssClasses = '".escapeString($cssClasses)."',
				publishingStartTime = ".$publishingStartTime.",
				publishingEndTime = ".$publishingEndTime."
			WHERE	newsItemID = ".$this->newsItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Enables this news item.
	 */
	public function enable() {
		$sql = "UPDATE	wsis".WSIS_N."_news_item
			SET	enabled = 1
			WHERE	newsItemID = ".$this->newsItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Disables this news item.
	 */
	public function disable() {
		$sql = "UPDATE	wsis".WSIS_N."_news_item
			SET	enabled = 0
			WHERE	newsItemID = ".$this->newsItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Deletes this news item.
	 */
	public function delete() {
		$sql = "DELETE FROM	wsis".WSIS_N."_news_item
			WHERE		newsItemID = ".$this->newsItemID;
		WCF::getDB()->sendQuery($sql);
	}
	
	/**
	 * Creates a new news item.
	 * 
	 * @param	integer		$newsArchiveID
	 * @param	integer		$userID
	 * @param	string		$title
	 * @param	string		$newsItemAlias
	 * @param	string		$teaser
	 * @param	string		$text
	 * @param	string		$cssID
	 * @param	string		$cssClasses
	 * @param	string		$publishingStartTime
	 * @param	string		$publishingEndTime
	 * @return	NewsItemEditor
	 */
	public static function create($newsArchiveID, $userID, $title, $newsItemAlias, $teaser, $text, $cssID, $cssClasses, $publishingStartTime, $publishingEndTime) {
		$sql = "INSERT INTO	wsis".WSIS_N."_news_item
					(newsArchiveID, userID, title, newsItemAlias, cssID, cssClasses, teaser, text, time, publishingStartTime, publishingEndTime, enabled)
			VALUES		(".$newsArchiveID.", ".$userID.", '".escapeString($title)."', '".escapeString($newsItemAlias)."', '".escapeString($cssID)."', '".escapeString($cssClasses)."', '".escapeString($teaser)."', '".escapeString($text)."', ".TIME_NOW.", '".escapeString($publishingStartTime)."', '".escapeString($publishingEndTime)."', ".intval(WCF::getUser()->getPermission('admin.site.canEnableNewsItem')).")";
		WCF::getDB()->sendQuery($sql);
		
		$newsItemID = WCF::getDB()->getInsertID("wsis".WSIS_N."_news_item", 'newsItemID');
		return new NewsItemEditor($newsItemID);
	}
}
?>