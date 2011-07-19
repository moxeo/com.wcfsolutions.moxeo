<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/comment/CommentList.class.php');
require_once(WSIS_DIR.'lib/page/element/ArticleSectionPageElement.class.php');

/**
 * Represents a comments page element.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	page.element
 * @category	Infinite Site
 */
class CommentsPageElement extends ArticleSectionPageElement {
	// system
	public $templateName = 'comments';
	
	/**
	 * list of comments
	 * 
	 * @var	CommentList
	 */
	public $commentList = null;
	
	/**
	 * comment id
	 * 
	 * @var	integer
	 */
	public $commentID = 0;
	
	/**
	 * comment object
	 * 
	 * @var	PublicationObjectComment
	 */
	public $comment = null;
	
	/**
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// get page no
		if (isset($_REQUEST['pageNo'])) $this->pageNo = intval($_REQUEST['pageNo']);
		
		// get comment
		if (isset($_REQUEST['commentID'])) $this->commentID = intval($_REQUEST['commentID']);
		if ($this->commentID != 0) {
			$this->comment = new Comment($this->commentID);
			if (!$this->comment->commentID || $this->comment->articleSectionID != $this->articleSection->articleSectionID) {
				throw new IllegalLinkException();
			}
			
			// check permissions
			if ($this->action == 'edit' && !$this->comment->isEditable()) {
				throw new PermissionDeniedException();
			}
			
			// get page number
			$sql = "SELECT	COUNT(*) AS comments
				FROM 	wsis".WSIS_N."_comment
				WHERE 	articleSectionID = ".$this->articleSection->articleSectionID."
					AND time >= ".$this->comment->time;
			$result = WCF::getDB()->getFirstRow($sql);
			$this->pageNo = intval(ceil($result['comments'] / $this->itemsPerPage));
		}
		
		// init comment list
		$this->commentList = new CommentList();
		$this->commentList->sqlConditions .= "comment.articleSectionID = ".$this->articleSection->articleSectionID;
		$this->commentList->sqlOrderBy = 'comment.time DESC';
	}
	
	/**
	 * @see MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();
		
		return $this->commentList->countObjects();
	}
	
	/**
	 * @see Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// read comments
		$this->commentList->sqlOffset = ($this->pageNo - 1) * $this->itemsPerPage;
		$this->commentList->sqlLimit = $this->itemsPerPage;
		$this->commentList->readObjects();
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		// init comment form
		require_once(WSIS_DIR.'lib/form/CommentForm.class.php');
		new CommentForm($this->articleSection, $this->contentItem);
		
		WCF::getTPL()->assign(array(
			'comments' => ($this->commentList != null ? $this->commentList->getObjects() : array()),
			'pageNo' => $this->pageNo,
			'pages' => $this->pages,
			'items' => $this->items,
			'itemsPerPage' => $this->itemsPerPage
		));
	}
}
?>