<?php
// moxeo imports
require_once(MOXEO_DIR.'lib/data/comment/CommentEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');

/**
 * Shows the comment edit form.
 *
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.moxeo
 * @subpackage	acp.form
 * @category	Moxeo Open Source CMS
 */
class CommentEditForm extends ACPForm {
	// system
	public $templateName = 'commentEdit';
	public $neededPermissions = 'admin.site.canEditComment';
	public $activeMenuItem = 'moxeo.acp.menu.link.content.comment';
	
	/**
	 * commentable object
	 * 
	 * @var CommentableObject
	 */
	public $commentableObject = null;
	
	/**
	 * comment editor object
	 * 
	 * @var	CommentEditor
	 */
	public $commentObj = null;
	
	// parameters
	public $comment = '';
	
	/**
	 * @see	Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		// get comment
		if (isset($_REQUEST['commentID'])) $this->commentID = intval($_REQUEST['commentID']);
		$this->commentObj = new CommentEditor($this->commentID);
		if (!$this->commentObj->commentID) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// get commentable object
		$this->commentableObject = Comment::getCommentableObjectByID($this->commentObj->commentableObjectType, $this->commentObj->commentableObjectID);
		
		// default values
		if (!count($_POST)) {
			$this->comment = $this->commentObj->comment;
		}
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['comment'])) $this->comment = StringUtil::trim($_POST['comment']);
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		if (empty($this->comment)) {
			throw new UserInputException('comment');
		}
		
		if (StringUtil::length($this->comment) > WCF::getUser()->getPermission('user.site.maxCommentLength')) {
			throw new UserInputException('comment', 'tooLong');
		}
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		ACPForm::save();
		
		// update comment
		$this->commentObj->update($this->comment);
		$this->saved();
		
		// show success message
		WCF::getTPL()->assign('success', true);
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'commentID' => $this->commentID,
			'commentObj' => $this->commentObj,
			'comment' => $this->comment,
			'commentableObject' => $this->commentableObject
		));
	}
}
?>