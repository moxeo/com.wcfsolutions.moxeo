<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/article/Article.class.php');
require_once(WSIS_DIR.'lib/data/article/section/ArticleSectionList.class.php');
require_once(WSIS_DIR.'lib/data/content/ContentItem.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/SortablePage.class.php');

/**
 * Shows a list of all article sections.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.page
 * @category	Infinite Site
 */
class ArticleSectionListPage extends SortablePage {
	// system
	public $templateName = 'articleSectionList';
	public $defaultSortField = 'showOrder';
	
	/**
	 * article id
	 * 
	 * @var	integer
	 */
	public $articleID = 0;
	
	/**
	 * article object
	 * 
	 * @var	Article
	 */
	public $article = null;
	
	/**
	 * content item editor object
	 * 
	 * @var	ContentItemEditor
	 */
	public $contentItem = null;
	
	/**
	 * article section list object
	 * 
	 * @var	ArticleSectionList
	 */
	public $articleSectionList = null;
	
	/**
	 * deleted article id
	 * 
	 * @var	integer
	 */
	public $deletedArticleSectionID = 0;
	
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
		
		if (isset($_REQUEST['deletedArticleSectionID'])) $this->deletedArticleSectionID = intval($_REQUEST['deletedArticleSectionID']);
		if (isset($_REQUEST['successfulSorting'])) $this->successfulSorting = true;
		
		// get article
		if (isset($_REQUEST['articleID'])) $this->articleID = intval($_REQUEST['articleID']);
		$this->article = new Article($this->articleID);
		if (!$this->article->articleID) {
			throw new IllegalLinkException();
		}
		
		// get content item
		$this->contentItem = new ContentItem($this->article->contentItemID);
		$this->contentItem->checkAdminPermission('canEditArticle');
		
		// init article section list
		$this->articleSectionList = new ArticleSectionList();
		$this->articleSectionList->sqlConditions = "article_section.articleID = ".$this->articleID;
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function readData() {
		parent::readData();
		
		// read article sections
		$this->articleSectionList->sqlOffset = ($this->pageNo - 1) * $this->itemsPerPage;
		$this->articleSectionList->sqlLimit = $this->itemsPerPage;
		$this->articleSectionList->sqlOrderBy = 'article_section.'.$this->sortField." ".$this->sortOrder;
		$this->articleSectionList->readObjects();
	}
	
	/**
	 * @see	SortablePage::validateSortField()
	 */
	public function validateSortField() {
		parent::validateSortField();
		
		switch ($this->sortField) {
			case 'articleSectionID':
			case 'articleSectionType':
			case 'showOrder': break;
			default: $this->sortField = $this->defaultSortField;
		}
	}
	
	/**
	 * @see	MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();
		
		return $this->articleSectionList->countObjects();
	}
		
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'articleID' => $this->articleID,
			'article' => $this->article,
			'contentItem' => $this->contentItem,
			'articleSections' => $this->articleSectionList->getObjects(),
			'deletedArticleSectionID' => $this->deletedArticleSectionID,
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