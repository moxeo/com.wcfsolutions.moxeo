<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/page/ContentItemPage.class.php');

/**
 * Renders content item pages.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2013 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	data.content
 * @category	Moxeo Open Source CMS
 */
class ContentItemRequest {
	/**
	 * content item id
	 *
	 * @var	integer
	 */
	public $contentItemID = 0;

	/**
	 * content item object
	 *
	 * @var	ContentItem
	 */
	public $contentItem = null;

	/**
	 * Creates a new ContentItemRequest object.
	 *
	 * @param	integer		$contentItemID
	 */
	public function __construct($contentItemID) {
		$this->contentItemID = $contentItemID;
		$this->contentItem = new ContentItem($this->contentItemID);
	}

	/**
	 * Executes this content item request.
	 */
	public function execute() {
		new ContentItemPage($this->contentItem);
	}

	/**
	 * Returns the content item id.
	 *
	 * @return	integer
	 */
	public function getContentItemID() {
		return $this->contentItemID;
	}

	/**
	 * Returns the content item object.
	 *
	 * @return	ContentItem
	 */
	public function getContentItem() {
		return $this->contentItem;
	}
}
?>