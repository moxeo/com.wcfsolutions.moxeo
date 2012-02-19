<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/article/section/ArticleSection.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObjectList.class.php');

/**
 * Represents a list of article sections.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.article.section
 * @category	Moxeo Open Source CMS
 */
class ArticleSectionList extends DatabaseObjectList {
	/**
	 * list of article sections
	 * 
	 * @var array<ArticleSection>
	 */
	public $articleSections = array();
	
	/**
	 * @see	DatabaseObjectList::countObjects()
	 */
	public function countObjects() {
		$sql = "SELECT	COUNT(*) AS count
			FROM	moxeo".MOXEO_N."_article_section article_section
			".(!empty($this->sqlConditions) ? "WHERE ".$this->sqlConditions : '');
		$row = WCF::getDB()->getFirstRow($sql);
		return $row['count'];
	}
	
	/**
	 * @see	DatabaseObjectList::readObjects()
	 */
	public function readObjects() {
		$sql = "SELECT		".(!empty($this->sqlSelects) ? $this->sqlSelects.',' : '')."
					article_section.*
			FROM		moxeo".MOXEO_N."_article_section article_section
			".$this->sqlJoins."
			".(!empty($this->sqlConditions) ? "WHERE ".$this->sqlConditions : '')."
			".(!empty($this->sqlOrderBy) ? "ORDER BY ".$this->sqlOrderBy : '');
		$result = WCF::getDB()->sendQuery($sql, $this->sqlLimit, $this->sqlOffset);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$this->articleSections[] = new ArticleSection(null, $row);
		}
	}
	
	/**
	 * @see	DatabaseObjectList::getObjects()
	 */
	public function getObjects() {
		return $this->articleSections;
	}
}
?>