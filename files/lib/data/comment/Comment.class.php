<?php
// wcf imports
require_once(WCF_DIR.'lib/data/DatabaseObject.class.php');

/**
 * Represents a comment.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	data.comment
 * @category	Infinite Site
 */
class Comment extends DatabaseObject {
	/**
	 * list of commentable object types
	 * 
	 * @var	array
	 */
	public static $commentableObjectTypes = null;
	
	/**
	 * list of available commentable object types
	 * 
	 * @var	array<CommentableObjectType>
	 */
	public static $availableCommentableObjectTypes = null;
	
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
	
	/**
	 * Returns the commentable object with the given commentable object type and the given id.
	 *  
	 * @param	string			$commentableObjectType
	 * @param	integer			$commentableObjectID
	 * @return	CommentableObject
	 */
	public static function getCommentableObjectByID($commentableObjectType, $commentableObjectID) {
		// get commentable object type object
		$typeObject = null;
		try {
			$typeObject = self::getCommentableObjectTypeObject($commentableObjectType);
		}
		catch (SystemException $e) {
			return null;
		}
		
		// get commentable object
		return $typeObject->getObjectByID($commentableObjectID);
	}
	
	/**
	 * Returns the commentable objects with the given commentable object type and the given ids.
	 *  
	 * @param	string			$commentableObjectType
	 * @param	array			$commentableObjectIDs
	 * @return	array<CommentableObject>
	 */
	public static function getCommentableObjectsByIDs($commentableObjectType, $commentableObjectIDs) {
		// get commentable object type object
		$typeObject = null;
		try {
			$typeObject = self::getCommentableObjectTypeObject($commentableObjectType);
		}
		catch (SystemException $e) {
			return null;
		}
		
		// get commentable objects
		return $typeObject->getObjectsByIDs($commentableObjectIDs);
	}
	
	/**
	 * Returns the object of an commentable object type.
	 * 
	 * @param	string			$commentableObjectType
	 * @return	CommentableObjectType
	 */
	public static function getCommentableObjectTypeObject($commentableObjectType) {
		$types = self::getAvailableCommentableObjectTypes();
		if (!isset($types[$commentableObjectType])) {
			throw new SystemException("Unknown commentable object type '".$commentableObjectType."'", 11000);
		}	
		return $types[$commentableObjectType];
	}
	
	/**
	 * Returns a list of commentable object types.
	 * 
	 * @return	array
	 */
	public static function getCommentableObjectTypes() {
		if (self::$commentableObjectTypes === null) {
			WCF::getCache()->addResource('commentableObjectTypes', WSIS_DIR.'cache/cache.commentableObjectTypes.php', WSIS_DIR.'lib/system/cache/CacheBuilderCommentableObjectTypes.class.php');
			self::$commentableObjectTypes = WCF::getCache()->get('commentableObjectTypes');
		}
		return self::$commentableObjectTypes;
	}
	
	/**
	 * Returns a list of available commentable object types.
	 * 
	 * @return	array<CommentableObjectType>
	 */
	public static function getAvailableCommentableObjectTypes() {
		if (self::$availableCommentableObjectTypes === null) {
			$types = self::getCommentableObjectTypes();
			foreach ($types as $type) {
				// get path to class file
				$path = WSIS_DIR.$type['classFile'];
				
				// include class file
				if (!class_exists($type['className'])) {
					if (!file_exists($path)) {
						throw new SystemException("Unable to find class file '".$path."'", 11000);
					}
					require_once($path);
				}
				
				// instance object
				if (!class_exists($type['className'])) {
					throw new SystemException("Unable to find class '".$type['className']."'", 11001);
				}
				self::$availableCommentableObjectTypes[$type['commentableObjectType']] = new $type['className'];
			}
		}
		return self::$availableCommentableObjectTypes;
	}
}
?>