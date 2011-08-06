<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/comment/Comment.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObjectList.class.php');

/**
 * Represents a list of comments.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.comment
 * @category	Infinite Site
 */
class CommentList extends DatabaseObjectList {
	/**
	 * list of comments
	 * 
	 * @var array<Comment>
	 */
	public $comments = array();
	
	/**
	 * sql order by statement
	 * 
	 * @var	string
	 */
	public $sqlOrderBy = 'comment.time DESC';
	
	/**
	 * @see	DatabaseObjectList::countObjects()
	 */
	public function countObjects() {
		$sql = "SELECT	COUNT(*) AS count
			FROM	wsis".WSIS_N."_comment comment
			".(!empty($this->sqlConditions) ? "WHERE ".$this->sqlConditions : '');
		$row = WCF::getDB()->getFirstRow($sql);
		return $row['count'];
	}
	
	/**
	 * @see	DatabaseObjectList::readObjects()
	 */
	public function readObjects() {
		$sql = "SELECT		".(!empty($this->sqlSelects) ? $this->sqlSelects.',' : '')."
					user_table.*, comment.*
			FROM		wsis".WSIS_N."_comment comment
			LEFT JOIN	wcf".WCF_N."_user user_table
			ON		(user_table.userID = comment.userID)
			".$this->sqlJoins."
			".(!empty($this->sqlConditions) ? "WHERE ".$this->sqlConditions : '')."
			".(!empty($this->sqlOrderBy) ? "ORDER BY ".$this->sqlOrderBy : '');
		$result = WCF::getDB()->sendQuery($sql, $this->sqlLimit, $this->sqlOffset);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$this->comments[] = new Comment(null, $row);
		}
	}
	
	/**
	 * @see	DatabaseObjectList::getObjects()
	 */
	public function getObjects() {
		return $this->comments;
	}
}
?>