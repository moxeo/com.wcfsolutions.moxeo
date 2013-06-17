<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/comment/Comment.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObjectList.class.php');

/**
 * Represents a list of comments.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.comment
 * @category	Moxeo Open Source CMS
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
			FROM	moxeo".MOXEO_N."_comment comment
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
			FROM		moxeo".MOXEO_N."_comment comment
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