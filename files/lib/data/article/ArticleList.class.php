<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/Article.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObjectList.class.php');

/**
 * Represents a list of articles.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article
 * @category	Moxeo Open Source CMS
 */
class ArticleList extends DatabaseObjectList {
	/**
	 * list of articles
	 *
	 * @var array<Article>
	 */
	private $articles = array();

	/**
	 * @see	DatabaseObjectList::countObjects()
	 */
	public function countObjects() {
		$sql = "SELECT	COUNT(*) AS count
			FROM	moxeo".MOXEO_N."_article article
			".(!empty($this->sqlConditions) ? "WHERE ".$this->sqlConditions : '');
		$row = WCF::getDB()->getFirstRow($sql);
		return $row['count'];
	}

	/**
	 * @see	DatabaseObjectList::readObjects()
	 */
	public function readObjects() {
		$sql = "SELECT		".(!empty($this->sqlSelects) ? $this->sqlSelects.',' : '')."
					article.*,
					(SELECT COUNT(*) FROM moxeo".MOXEO_N."_article_section WHERE articleID = article.articleID) AS articleSections
			FROM		moxeo".MOXEO_N."_article article
			".$this->sqlJoins."
			".(!empty($this->sqlConditions) ? "WHERE ".$this->sqlConditions : '')."
			".(!empty($this->sqlOrderBy) ? "ORDER BY ".$this->sqlOrderBy : '');
		$result = WCF::getDB()->sendQuery($sql, $this->sqlLimit, $this->sqlOffset);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$this->articles[] = new Article(null, $row);
		}
	}

	/**
	 * @see	DatabaseObjectList::getObjects()
	 */
	public function getObjects() {
		return $this->articles;
	}
}
?>