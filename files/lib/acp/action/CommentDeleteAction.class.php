<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/comment/CommentEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

/**
 * Deletes a comment.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	acp.action
 * @category	Infinite Site
 */
class CommentDeleteAction extends AbstractAction {
	/**
	 * comment id
	 * 
	 * @var	integer
	 */
	public $commentID = 0;
	
	/**
	 * comment editor object
	 * 
	 * @var	CommentEditor
	 */
	public $comment = null;
	
	/**
	 * @see	Action::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// get comment
		if (isset($_REQUEST['commentID'])) $this->commentID = intval($_REQUEST['commentID']);
		$this->comment = new CommentEditor($this->commentID);
		if (!$this->comment->commentID) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		// check permission
		WCF::getUser()->checkPermission('admin.site.canDeleteComment');
		
		// delete comment
		$this->comment->delete();
		$this->executed();
		
		// forward to list page
		HeaderUtil::redirect('index.php?page=CommentList&deletedCommentID='.$this->commentID.'&packageID='.PACKAGE_ID.SID_ARG_2ND_NOT_ENCODED);
		exit;
	}
}
?>