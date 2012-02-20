<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/comment/CommentList.class.php');
require_once(MOXEO_DIR.'lib/page/element/ArticleSectionPageElement.class.php');

/**
 * Represents a comments page element.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2012 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	page.element
 * @category	Moxeo Open Source CMS
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
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();

		// init comment list
		$this->commentList = new CommentList();
		$this->commentList->sqlConditions .= "comment.commentableObjectID = ".$this->articleSection->articleSectionID." AND comment.commentableObjectType = 'articleSection'";
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
		require_once(MOXEO_DIR.'lib/form/element/CommentAddFormElement.class.php');
		$commentAddForm = new CommentAddFormElement($this->articleSection->getCommentableObject(), $this->contentItem, $this->contentItem->getURL());

		WCF::getTPL()->assign(array(
			'comments' => $this->commentList->getObjects(),
			'commentForm' => $commentAddForm->getContent()
		));
	}
}
?>