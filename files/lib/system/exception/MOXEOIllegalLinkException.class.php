<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/content/ContentItem.class.php');

/**
 * MOXEOIllegalLinkException shows the unknown link error page.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	system.exception
 * @category	Moxeo Open Source CMS
 */
class MOXEOIllegalLinkException extends IllegalLinkException {
	/**
	 * @see	NamedUserException::show();
	 */
	public function show() {
		// get root id
		if (ContentItemRequestHandler::getInstance()->getRootID()) {
			$rootID = ContentItemRequestHandler::getInstance()->getRootID();
		}
		else {
			$rootID = ContentItem::getFirstRootID();
		}

		// get content item id
		$contentItemID = ContentItem::getErrorContentItemID($rootID, '404');
		if ($contentItemID) {
			// send headers
			@header('HTTP/1.0 404 Not Found');

			// render content item
			require_once(MOXEO_DIR.'lib/system/request/ContentItemRequest.class.php');
			$request = new ContentItemRequest($contentItemID);
			$request->execute();
		}
	}
}
?>