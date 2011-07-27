<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/news/NewsItemList.class.php');
require_once(WSIS_DIR.'lib/data/news/archive/NewsArchive.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/SortablePage.class.php');

/**
 * Shows a list of all news items.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wcf.theme
 * @subpackage	acp.page
 * @category	Community Framework
 */
class NewsItemListPage extends SortablePage {
	// system
	public $templateName = 'newsItemList';
	public $defaultSortField = 'time';
	public $defaultSortOrder = 'DESC';
	public $neededPermissions = array('admin.site.canEditNewsItem', 'admin.site.canDeleteNewsItem');
	
	/**
	 * news archive id
	 * 
	 * @var	integer
	 */
	public $newsArchiveID = 0;
	
	/**
	 * news archive editor object
	 * 
	 * @var	NewsArchiveEditor
	 */
	public $newsArchive = null;
	
	/**
	 * deleted news item id
	 * 
	 * @var	integer
	 */
	public $deletedNewsItemID = 0;
	
	/**
	 * news item list object
	 * 
	 * @var	NewsItemList
	 */
	public $newsItemList = null;
	
	/**
	 * list of available news archives
	 * 
	 * @var	array
	 */
	public $newsArchiveOptions = array();
	
	/**
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['deletedNewsItemID'])) $this->deletedNewsItemID = intval($_REQUEST['deletedNewsItemID']);
		
		// get news archive
		if (isset($_REQUEST['newsArchiveID'])) $this->newsArchiveID = intval($_REQUEST['newsArchiveID']);
		if ($this->newsArchiveID) {
			$this->newsArchive = new NewsArchive($this->newsArchiveID);	
		}
		
		// init news item list
		$this->newsItemList = new NewsItemList();
		$this->newsItemList->sqlConditions = 'news_item.newsArchiveID = '.$this->newsArchiveID;
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function readData() {
		parent::readData();
		
		// get news archive options
		$this->newsArchiveOptions = NewsArchive::getNewsArchives();
		
		// read news items
		$this->newsItemList->sqlOffset = ($this->pageNo - 1) * $this->itemsPerPage;
		$this->newsItemList->sqlLimit = $this->itemsPerPage;
		$this->newsItemList->sqlOrderBy = 'news_item.'.$this->sortField." ".$this->sortOrder;
		$this->newsItemList->readObjects();
	}
	
	/**
	 * @see SortablePage::validateSortField()
	 */
	public function validateSortField() {
		parent::validateSortField();
		
		switch ($this->sortField) {
			case 'newsItemID':
			case 'title':
			case 'time': break;
			default: $this->sortField = $this->defaultSortField;
		}
	}
	
	/**
	 * @see MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();
		
		return $this->newsItemList->countObjects();
	}
	
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'newsArchiveID' => $this->newsArchiveID,
			'newsArchive' => $this->newsArchive,
			'newsItems' => $this->newsItemList->getObjects(),
			'newsArchiveOptions' => $this->newsArchiveOptions,
			'deletedNewsItemID' => $this->deletedNewsItemID
		));
	}
	
	/**
	 * @see Page::show()
	 */
	public function show() {
		// enable menu item
		WCFACP::getMenu()->setActiveMenuItem('wsis.acp.menu.link.content.newsItem.view');
		
		parent::show();
	}
}
?>