<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/comment/ACPCommentList.class.php');

// wcf imports
require_once(WCF_DIR.'lib/page/SortablePage.class.php');

/**
 * Shows a list of all comments.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wcf.theme
 * @subpackage	acp.page
 * @category	Community Framework
 */
class CommentListPage extends SortablePage {
	// system
	public $templateName = 'commentList';
	public $defaultSortField = 'time';
	public $defaultSortOrder = 'DESC';
	public $neededPermissions = array('admin.site.canEditComment', 'admin.site.canDeleteComment');
	
	/**
	 * comment list object
	 * 
	 * @var	CommentList
	 */
	public $commentList = null;
	
	/**
	 * deleted comment id
	 * 
	 * @var	integer
	 */
	public $deletedCommentID = 0;
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['deletedCommentID'])) $this->deletedCommentID = intval($_REQUEST['deletedCommentID']);
		
		// init comment list
		$this->commentList = new ACPCommentList();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function readData() {
		parent::readData();
		
		// read comments
		$this->commentList->sqlOffset = ($this->pageNo - 1) * $this->itemsPerPage;
		$this->commentList->sqlLimit = $this->itemsPerPage;
		$this->commentList->sqlOrderBy = 'comment.'.$this->sortField." ".$this->sortOrder;
		$this->commentList->readObjects();
	}
	
	/**
	 * @see	SortablePage::validateSortField()
	 */
	public function validateSortField() {
		parent::validateSortField();
		
		switch ($this->sortField) {
			case 'commentID':
			case 'username':
			case 'ipAddress':
			case 'comment':
			case 'commentableObjectType':
			case 'commentableObjectID':
			case 'time': break;
			default: $this->sortField = $this->defaultSortField;
		}
	}
	
	/**
	 * @see	MultipleLinkPage::countItems()
	 */
	public function countItems() {
		parent::countItems();
		
		return $this->commentList->countObjects();
	}
		
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'comments' => $this->commentList->getObjects(),
			'deletedCommentID' => $this->deletedCommentID
		));
	}
	
	/**
	 * @see	Page::show()
	 */
	public function show() {
		// enable menu item
		WCFACP::getMenu()->setActiveMenuItem('wsis.acp.menu.link.content.comment.view');
		
		parent::show();
	}
}
?>