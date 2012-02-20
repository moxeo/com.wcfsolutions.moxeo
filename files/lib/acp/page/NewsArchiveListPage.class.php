<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/news/archive/NewsArchiveList.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/SortablePage.class.php');

/**
 * Shows a list of all news archives.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wcf.theme
 * @subpackage	acp.page
 * @category	Community Framework
 */
class NewsArchiveListPage extends SortablePage {
	// system
	public $templateName = 'newsArchiveList';
	public $defaultSortField = 'title';
	public $neededPermissions = array('admin.moxeo.canEditNewsArchive', 'admin.moxeo.canDeleteNewsArchive');

	/**
	 * news archive list object
	 *
	 * @var	NewsArchiveList
	 */
	public $newsArchiveList = null;

	/**
	 * deleted news archive id
	 *
	 * @var	integer
	 */
	public $deletedNewsArchiveID = 0;

	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		if (isset($_REQUEST['deletedNewsArchiveID'])) $this->deletedNewsArchiveID = intval($_REQUEST['deletedNewsArchiveID']);

		// init news archive list
		$this->newsArchiveList = new NewsArchiveList();
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function readData() {
		parent::readData();

		// read news archives
		$this->newsArchiveList->sqlOffset = ($this->pageNo - 1) * $this->itemsPerPage;
		$this->newsArchiveList->sqlLimit = $this->itemsPerPage;
		$this->newsArchiveList->sqlOrderBy = ($this->sortField != 'newsItems' ? 'news_archive.' : '').$this->sortField." ".$this->sortOrder;
		$this->newsArchiveList->readObjects();
	}

	/**
	 * @see	SortablePage::validateSortField()
	 */
	public function validateSortField() {
		parent::validateSortField();

		switch ($this->sortField) {
			case 'newsArchiveID':
			case 'title':
			case 'newsItems': break;
			default: $this->sortField = $this->defaultSortField;
		}
	}

	/**
	 * @see	MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();

		return $this->newsArchiveList->countObjects();
	}

	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
			'newsArchives' => $this->newsArchiveList->getObjects(),
			'deletedNewsArchiveID' => $this->deletedNewsArchiveID
		));
	}

	/**
	 * @see	Page::show()
	 */
	public function show() {
		// enable menu item
		WCFACP::getMenu()->setActiveMenuItem('moxeo.acp.menu.link.content.newsArchive.view');

		parent::show();
	}
}
?>