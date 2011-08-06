<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/comment/CommentList.class.php');
require_once(WSIS_DIR.'lib/data/news/NewsItem.class.php');
require_once(WSIS_DIR.'lib/data/news/archive/NewsArchive.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/element/ThemeModulePageElement.class.php');

/**
 * Represents a news item element.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	page.element
 * @category	Infinite Site
 */
class NewsItemPageElement extends ThemeModulePageElement {
	// system
	public $templateName = 'newsItem';
	
	/**
	 * news item alias
	 * 
	 * @var	string
	 */
	public $newsItemAlias = '';
	
	/**
	 * news item object
	 * 
	 * @var	NewsItem
	 */
	public $newsItem = null;
	
	/**
	 * news archive object
	 * 
	 * @var	NewsArchive
	 */
	public $newsArchive = null;
	
	/**
	 * list of comments
	 * 
	 * @var	CommentList
	 */
	public $commentList = null;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// get news item
		$this->newsItemAlias = ContentItemRequestHandler::getInstance()->getFilename();
		$this->newsItem = NewsItem::getNewsItemByAlias($this->newsItemAlias);
		if (!$this->newsItem->newsItemID) {
			throw new IllegalLinkException();
		}
		
		// get news archive
		$this->newsArchive = new NewsArchive($this->newsItem->newsArchiveID);
		$this->newsItem->enter();
		
		// check news archive
		if (!in_array($this->newsArchive->newsArchiveID, $this->themeModule->newsArchiveIDs)) {
			throw new IllegalLinkException();
		}
		
		// init comment list
		$this->commentList = new CommentList();
		$this->commentList->sqlConditions .= "comment.commentableObjectID = ".$this->newsItem->newsItemID." AND comment.commentableObjectType = 'newsItem'";
		$this->commentList->sqlOrderBy = 'comment.time DESC';
	}
	
	/**
	 * @see	MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();
		
		return $this->commentList->countObjects();
	}
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// read comments
		$this->commentList->sqlOffset = ($this->pageNo - 1) * $this->itemsPerPage;
		$this->commentList->sqlLimit = $this->itemsPerPage;
		$this->commentList->readObjects();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		// init comment add form
		require_once(WSIS_DIR.'lib/form/element/CommentAddFormElement.class.php');
		$commentAddForm = new CommentAddFormElement($this->newsItem->getCommentableObject(), $this->additionalData['contentItem'], $this->newsItem->getURL());
		
		WCF::getTPL()->assign(array(
			'newsArchive' => $this->newsArchive,
			'newsItem' => $this->newsItem,
			'newsItemAlias' => $this->newsItemAlias,
			'comments' => $this->commentList->getObjects(),
			'commentForm' => $commentAddForm->getContent()
		));
	}
	
	/**
	 * @see	Page::show()
	 */
	public function show() {
		// set custom page title
		ContentItemPage::setCustomPageTitle($this->newsItem->title);
		
		// set custom meta description
		ContentItemPage::setCustomMetaDescription($this->newsItem->teaser);
		
		// set custom meta keywords
		ContentItemPage::setCustomMetaKeywords($this->newsItem->title);
		
		parent::show();
	}
}
?>