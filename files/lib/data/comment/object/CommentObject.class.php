<?php
/**
 * Any comment object should implement this interface.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.comment.object
 * @category	Infinite Site
 */
interface CommentObject {
	/**
	 * Returns the comment object id.
	 * 
	 * @return 	integer
	 */
	public function getCommentObjectID();
	
	/**
	 * Returns the comment object type.
	 * 
	 * @return 	string
	 */
	public function getCommentObjectType();
	
	/**
	 * Returns the title of this comment object.
	 * 
	 * @return 	string
	 */	
	public function getTitle();
	
	/**
	 * Returns true, if the active user can comment this comment object.
	 * 
	 * @return	boolean
	 */
	public function isCommentable();
}
?>