<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/captcha/Captcha.class.php');
require_once(WSIS_DIR.'lib/data/comment/CommentEditor.class.php');

// wcf imports
require_once(WCF_DIR.'lib/form/element/AbstractFormElement.class.php');

/**
 * Shows the comment add form.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	form
 * @category	Infinite Site
 */
class CommentAddFormElement extends AbstractFormElement {
	// system
	public $templateName = 'commentAdd';
	
	// parameters
	public $comment = '';
	public $username = '';
	public $captchaValue = 0;
	
	/**
	 * content item object
	 * 
	 * @var ContentItem
	 */
	public $contentItem = null;
	
	/**
	 * article section object
	 * 
	 * @var ArticleSection
	 */
	public $articleSection = null;
	
	/**
	 * comment editor object
	 * 
	 * @var CommentEditor
	 */
	public $commentObj = null;
	
	/**
	 * captcha id
	 * 
	 * @var	integer
	 */
	public $captchaID = 0;
	
	/**
	 * captcha object
	 * 
	 * @var	Captcha
	 */
	public $captcha = null;
	
	/**
	 * Creates a new CommentAddForm object.
	 * 
	 * @param	ArticleSection		$articleSection
	 */
	public function __construct(ArticleSection $articleSection, ContentItem $contentItem) {
		$this->articleSection = $articleSection;
		$this->contentItem = $contentItem;
		parent::__construct();
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['comment'])) $this->comment = StringUtil::trim($_POST['comment']);
		if (isset($_POST['username'])) $this->username = StringUtil::trim($_POST['username']);
		if (isset($_POST['captchaID'])) $this->captchaID = intval($_POST['captchaID']);
		if (isset($_POST['captchaValue'])) $this->captchaValue = intval($_POST['captchaValue']);
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// username
		$this->validateUsername();
		
		// comment
		if (empty($this->comment)) {
			throw new UserInputException('comment');
		}
		
		if (StringUtil::length($this->comment) > WCF::getUser()->getPermission('user.site.maxCommentLength')) {
			throw new UserInputException('comment', 'tooLong');
		}
		
		// captcha
		if (!WCF::getUser()->userID) {
			$this->captcha = new Captcha($this->captchaID);
			$this->captcha->validate($this->captchaValue);			
		}
	}
	
	/**
	 * Validates the username.
	 */
	protected function validateUsername() {
		// only for guests
		if (WCF::getUser()->userID == 0) {
			// username
			if (empty($this->username)) {
				throw new UserInputException('username');
			}
			if (!UserUtil::isValidUsername($this->username)) {
				throw new UserInputException('username', 'notValid');
			}
			if (!UserUtil::isAvailableUsername($this->username)) {
				throw new UserInputException('username', 'notAvailable');
			}
			
			WCF::getSession()->setUsername($this->username);
		}
		else {
			$this->username = WCF::getUser()->username;
		}
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		// save comment
		$this->commentObj = CommentEditor::create($this->articleSection->articleSectionID, WCF::getUser()->userID, $this->username, $this->comment);
		$this->saved();
		
		// forward
		HeaderUtil::redirect($this->contentItem->getURL().SID_ARG_1ST);
		exit;
	}
	
	/**
	 * @see	Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		if (!count($_POST)) {
			// default values
			$this->username = WCF::getSession()->username;
		}
		
		// captcha
		if (!WCF::getUser()->userID) {
			$this->captchaID = Captcha::create();
			$this->captcha = new Captcha($this->captchaID);
		}
	}
	
	/**
	 * @see	AbstractFormElement::getIdentifier()
	 */	
	public function getIdentifier() {
		return $this->articleSection->articleSectionID;
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'comment' => $this->comment,
			'username' => $this->username,
			'maxTextLength' => WCF::getUser()->getPermission('user.site.maxCommentLength'),
			'captchaID' => $this->captchaID,
			'captcha' => $this->captcha
		));
	}
}
?>