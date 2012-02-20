<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/comment/CommentList.class.php');

/**
 * Represents an acp list of comments.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.comment
 * @category	Moxeo Open Source CMS
 */
class ACPCommentList extends CommentList {
	/**
	 * @see	DatabaseObjectList::readObjects()
	 */
	public function readObjects() {
		// get ids
		$commentIDArray = $commentableObjectIDArray = array();
		$sql = "SELECT	comment.*
			FROM	moxeo".MOXEO_N."_comment comment
			".$this->sqlJoins."
			".(!empty($this->sqlConditions) ? "WHERE ".$this->sqlConditions : '')."
			".(!empty($this->sqlOrderBy) ? "ORDER BY ".$this->sqlOrderBy : '');
		$result = WCF::getDB()->sendQuery($sql, $this->sqlLimit, $this->sqlOffset);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$commentIDArray[] = $row['commentID'];

			if (!isset($commentableObjectIDArray[$row['commentableObjectType']])) {
				$commentableObjectIDArray[$row['commentableObjectType']] = array();
			}
			$commentableObjectIDArray[$row['commentableObjectType']][] = $row['commentableObjectID'];
		}

		if (count($commentIDArray)) {
			// get commentable objects
			$commentableObjects = array();
			foreach ($commentableObjectIDArray as $commentableObjectType => $idArray) {
				if (($result = Comment::getCommentableObjectsByIDs($commentableObjectType, $idArray)) !== null) {
					$commentableObjects[$commentableObjectType] = $result;
				}
			}

			// get comments
			$sql = "SELECT		".(!empty($this->sqlSelects) ? $this->sqlSelects.',' : '')."
						user_table.*, comment.*
				FROM		moxeo".MOXEO_N."_comment comment
				LEFT JOIN	wcf".WCF_N."_user user_table
				ON		(user_table.userID = comment.userID)
				".$this->sqlJoins."
				WHERE		comment.commentID IN (".implode(',', $commentIDArray).")
				".(!empty($this->sqlOrderBy) ? "ORDER BY ".$this->sqlOrderBy : '');
			$result = WCF::getDB()->sendQuery($sql);
			while ($row = WCF::getDB()->fetchArray($result)) {
				if (isset($commentableObjects[$row['commentableObjectType']][$row['commentableObjectID']])) {
					$row['commentableObject'] = $commentableObjects[$row['commentableObjectType']][$row['commentableObjectID']];
				}
				$this->comments[] = new Comment(null, $row);
			}
		}
	}
}
?>