<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/news/NewsItemList.class.php');
require_once(MOXEO_DIR.'lib/data/news/archive/NewsArchive.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/element/ThemeModulePageElement.class.php');

/**
 * Represents a news item list element.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	page.element
 * @category	Moxeo Open Source CMS
 */
class NewsItemListPageElement extends ThemeModulePageElement {
	// system
	public $templateName = 'newsItemList';

	/**
	 * news item list object
	 *
	 * @var	NewsItemList
	 */
	public $newsItemList = null;

	/**
	 * content item object
	 *
	 * @var	ContentItem
	 */
	public $contentItem = null;

	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		// init news item list
		$this->newsItemList = new NewsItemList();
		$this->newsItemList->sqlConditions = "	news_item.newsArchiveID IN (".implode(',', $this->themeModule->newsArchiveIDs).")
							AND news_item.enabled = 1
							AND (news_item.publishingStartTime = 0 OR news_item.publishingStartTime > ".TIME_NOW.")
							AND (news_item.publishingEndTime = 0 OR news_item.publishingStartTime <= ".TIME_NOW.")";

		// get content item
		if (!isset($this->additionalData['contentItem'])) {
			throw new SystemException('no content item given');
		}
		$this->contentItem = $this->additionalData['contentItem'];

		// news items per page
		if ($this->themeModule->newsItemsPerPage) $this->itemsPerPage = $this->themeModule->newsItemsPerPage;
	}

	/**
	 * @see	MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();

		return $this->newsItemList->countObjects();
	}

	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();

		// read news items
		$this->newsItemList->sqlOffset = ($this->pageNo - 1) * $this->itemsPerPage;
		$this->newsItemList->sqlLimit = $this->itemsPerPage;
		$this->newsItemList->readObjects();
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'contentItem' => $this->contentItem,
			'newsItems' => $this->newsItemList->getObjects()
		));
	}
}
?>