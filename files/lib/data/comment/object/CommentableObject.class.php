<?php
/**
 * Any commentable object should implement this interface.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.comment.object
 * @category	Infinite Site
 */
interface CommentableObject {
	/**
	 * Returns the commentable object id.
	 * 
	 * @return 	integer
	 */
	public function getCommentableObjectID();
	
	/**
	 * Returns the commentable object type.
	 * 
	 * @return 	string
	 */
	public function getCommentableObjectType();
	
	/**
	 * Returns the title of this commentable object.
	 * 
	 * @return 	string
	 */	
	public function getTitle();
	
	/**
	 * Returns the url of this commentable object.
	 * 
	 * @return 	string
	 */	
	public function getURL();
}
?>