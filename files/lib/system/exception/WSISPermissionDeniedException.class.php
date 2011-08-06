<?php
/**
 * A WSISPermissionDeniedException is thrown when a user has no permission to access to a specific area.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	system.exception
 * @category	Infinite Site
 */
class WSISPermissionDeniedException extends PermissionDeniedException {
	/**
	 * @see	NamedUserException::show();
	 */
	public function show() {
		// get content item id
		require_once(WSIS_DIR.'lib/data/content/ContentItem.class.php');
		$contentItemID = ContentItem::getErrorContentItemID('403');
		if ($contentItemID) {
			// send headers
			@header('HTTP/1.0 403 Forbidden');
			
			// render content item
			require_once(WSIS_DIR.'lib/system/request/ContentItemRequest.class.php');
			$request = new ContentItemRequest($contentItemID);
			$request->execute();
		}
	}
}
?>