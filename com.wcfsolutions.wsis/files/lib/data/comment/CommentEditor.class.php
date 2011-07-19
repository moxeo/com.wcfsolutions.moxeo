<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/comment/Comment.class.php');

/**
 * Provides functions to manage comments.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.comment
 * @category	Infinite Site
 */
class CommentEditor extends Comment {	
	/**
	 * Updates this comment.
	 * 
	 * @param	string		$comment
	 */
	public function update($comment) {
		$sql = "UPDATE	wsis".WSIS_N."_comment
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
	 * @param	integer		$articleSectionID
	 * @param	integer		$userID
	 * @param	string		$username
	 * @param	string		$comment
	 * @return	CommentEditor
	 */
	public static function create($articleSectionID, $userID, $username, $comment) {
		$sql = "INSERT INTO	wsis".WSIS_N."_comment
					(articleSectionID, userID, username, comment, time, ipAddress)
			VALUES		(".$articleSectionID.", ".$userID.", '".escapeString($username)."', '".escapeString($comment)."', ".TIME_NOW.", '".escapeString(WCF::getSession()->ipAddress)."')";
		WCF::getDB()->sendQuery($sql);
		
		$commentID = WCF::getDB()->getInsertID("wsis".WSIS_N."_comment", 'commentID');
		return new CommentEditor($commentID);
	}
	
	/**
	 * Deletes all comments with the given comment ids.
	 * 
	 * @param	string		$commentIDs
	 */
	public static function deleteAll($commentIDs) {
		if (empty($commentIDs)) return;
		
		$sql = "DELETE FROM	wsis".WSIS_N."_comment
			WHERE		commentID IN (".$commentIDs.")";
		WCF::getDB()->sendQuery($sql);
	}
}
?>