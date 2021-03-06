<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/comment/Comment.class.php');

/**
 * Provides functions to manage comments.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.comment
 * @category	Moxeo Open Source CMS
 */
class CommentEditor extends Comment {
	/**
	 * Updates this comment.
	 *
	 * @param	string		$comment
	 */
	public function update($comment) {
		$sql = "UPDATE	moxeo".MOXEO_N."_comment
			SET	comment = '".escapeString($comment)."'
			WHERE	commentID = ".$this->commentID;
		WCF::getDB()->sendQuery($sql);
	}

	/**
	 * Deletes this comment.
	 */
	public function delete() {
		self::deleteAll($this->commentID);
	}

	/**
	 * Creates a new comment.
	 *
	 * @param	integer		$commentableObjectID
	 * @param	string		$commentableObjectType
	 * @param	integer		$userID
	 * @param	string		$username
	 * @param	string		$comment
	 * @return	CommentEditor
	 */
	public static function create($commentableObjectID, $commentableObjectType, $userID, $username, $comment) {
		$sql = "INSERT INTO	moxeo".MOXEO_N."_comment
					(commentableObjectID, commentableObjectType, userID, username, comment, time, ipAddress)
			VALUES		(".$commentableObjectID.", '".escapeString($commentableObjectType)."', ".$userID.", '".escapeString($username)."', '".escapeString($comment)."', ".TIME_NOW.", '".escapeString(WCF::getSession()->ipAddress)."')";
		WCF::getDB()->sendQuery($sql);

		$commentID = WCF::getDB()->getInsertID("moxeo".MOXEO_N."_comment", 'commentID');
		return new CommentEditor($commentID);
	}

	/**
	 * Deletes all comments with the given comment ids.
	 *
	 * @param	string		$commentIDs
	 */
	public static function deleteAll($commentIDs) {
		if (empty($commentIDs)) return;

		$sql = "DELETE FROM	moxeo".MOXEO_N."_comment
			WHERE		commentID IN (".$commentIDs.")";
		WCF::getDB()->sendQuery($sql);
	}
}
?>