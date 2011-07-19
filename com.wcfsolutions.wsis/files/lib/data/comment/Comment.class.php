<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents a comment.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.comment
 * @category	Infinite Site
 */
class Comment extends DatabaseObject {
	/**
	 * Creates a new Comment object.
	 * 
	 * @param	integer		$commentID
	 * @param 	array<mixed>	$row
	 */
	public function __construct($commentID, $row = null) {
		if ($commentID !== null) {
			$sql = "SELECT	*
				FROM 	wsis".WSIS_N."_comment
				WHERE 	commentID = ".$commentID;
			$row = WCF::getDB()->getFirstRow($sql);
		}
		parent::__construct($row);
	}
	
	/**
	 * Returns the formatted comment.
	 * 
	 * @return	string
	 */
	public function getFormattedComment() {
		return nl2br(StringUtil::encodeHTML($this->comment));
	}
	
	/**
	 * Returns an editor object for this comment.
	 * 
	 * @return	CommentEditor
	 */
	public function getEditor() {
		require_once(WSIS_DIR.'lib/data/comment/CommentEditor.class.php');
		return new CommentEditor(null, $this->data);
	}
}
?>