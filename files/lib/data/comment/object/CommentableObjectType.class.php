<?php
/**
 * Any commentable object type should implement this interface.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.comment.object
 * @category	Infinite Site
 */
interface CommentableObjectType {
	/**
	 * Returns the commentable object with the given object id.
	 * 
	 * @param	integer			$objectID
	 * @return 	CommentableObject
	 */
	public function getObjectByID($objectID);
	
	/**
	 * Returns the commentable objects with the given object ids.
	 * 
	 * @param	array			$objectIDs
	 * @return 	array
	 */
	public function getObjectsByIDs($objectIDs);
}
?>