<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/ArticleList.class.php');
require_once(WSIS_DIR.'lib/data/content/ContentItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/SortablePage.class.php');

/**
 * Shows a list of all articles.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.page
 * @category	Infinite Site
 */
class ArticleListPage extends SortablePage {
	// system
	public $templateName = 'articleList';
	public $defaultSortField = 'showOrder';
		
	/**
	 * content item id
	 * 
	 * @var	integer
	 */
	public $contentItemID = 0;
	
	/**
	 * content item editor object
	 * 
	 * @var	ContentItemEditor
	 */
	public $contentItem = null;
	
	/**
	 * list of available content items
	 * 
	 * @var	array
	 */
	public $contentItemOptions = array();
	
	/**
	 * article list object
	 * 
	 * @var	ArticleList
	 */
	public $articleList = null;
	
	/**
	 * deleted article id
	 * 
	 * @var	integer
	 */
	public $deletedArticleID = 0;
	
	/**
	 * True, if the list was sorted successfully.
	 * 
	 * @var boolean
	 */
	public $successfulSorting = false;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['deletedArticleID'])) $this->deletedArticleID = intval($_REQUEST['deletedArticleID']);
		if (isset($_REQUEST['successfulSorting'])) $this->successfulSorting = true;
		
		// get content item
		if (isset($_REQUEST['contentItemID'])) $this->contentItemID = intval($_REQUEST['contentItemID']);
		if ($this->contentItemID) {
			$this->contentItem = new ContentItem($this->contentItemID);
			$this->contentItem->checkAdminPermission(array('canEditArticle', 'canDeleteArticle'));
		}
		else {
			WCF::getUser()->checkPermission(array('admin.site.canEditArticle', 'admin.site.canDeleteArticle'));
		}
		
		// init article list
		$this->articleList = new ArticleList();
		$this->articleList->sqlConditions = "article.contentItemID = ".$this->contentItemID;
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function readData() {
		parent::readData();
		
		// get content item options
		$this->contentItemOptions = ContentItem::getContentItemSelect(array(), array('canEditArticle', 'canDeleteArticle'));
		
		// read articles
		$this->articleList->sqlOffset = ($this->pageNo - 1) * $this->itemsPerPage;
		$this->articleList->sqlLimit = $this->itemsPerPage;
		$this->articleList->sqlOrderBy = ($this->sortField != 'articleSections' ? 'article.' : '').$this->sortField." ".$this->sortOrder;
		$this->articleList->readObjects();
	}
	
	/**
	 * @see	SortablePage::validateSortField()
	 */
	public function validateSortField() {
		parent::validateSortField();
		
		switch ($this->sortField) {
			case 'articleID':
			case 'title':
			case 'articleSections':
			case 'themeModulePosition':
			case 'showOrder': break;
			default: $this->sortField = $this->defaultSortField;
		}
	}
	
	/**
	 * @see	MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();
		
		return $this->articleList->countObjects();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'contentItemID' => $this->contentItemID,
			'contentItem' => $this->contentItem,
			'contentItemOptions' => $this->contentItemOptions,
			'articles' => $this->articleList->getObjects(),
			'deletedArticleID' => $this->deletedArticleID,
			'successfulSorting' => $this->successfulSorting
		));
	}
	
	/**
	 * @see	Page::show()
	 */
	public function show() {
		// enable menu item
		WCFACP::getMenu()->setActiveMenuItem('wsis.acp.menu.link.content.article.view');
		
		parent::show();
	}
}
?>