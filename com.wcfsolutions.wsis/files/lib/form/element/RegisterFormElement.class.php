<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/captcha/Captcha.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/user/UserEditor.class.php');
require_once(WCF_DIR.'lib/form/element/ThemeModuleFormElement.class.php');
require_once(WCF_DIR.'lib/system/auth/UserAuth.class.php');

/**
 * Represents a register form element.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	form.element
 * @category	Infinite Site
 */
class RegisterFormElement extends ThemeModuleFormElement {
	// system
	public $templateName = 'register';
	
	// parameters
	public $username = '';
	public $email = '';
	public $confirmEmail = '';
	public $password = '';
	public $confirmPassword = '';
	public $languageID = 0;
	public $captchaValue = 0;
	
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
	 * user editor object
	 * 
	 * @var	UserEditor
	 */
	public $user = null;
	
	/**
	 * @see Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['username'])) $this->username = StringUtil::trim($_POST['username']); 
		if (isset($_POST['email'])) $this->email = StringUtil::trim($_POST['email']);
		if (isset($_POST['confirmEmail'])) $this->confirmEmail = StringUtil::trim($_POST['confirmEmail']);
		if (isset($_POST['password'])) $this->password = $_POST['password'];
		if (isset($_POST['confirmPassword'])) $this->confirmPassword = $_POST['confirmPassword'];
		if (isset($_POST['languageID'])) $this->languageID = intval($_POST['languageID']);
		if (isset($_POST['captchaID'])) $this->captchaID = intval($_POST['captchaID']);
		if (isset($_POST['captchaValue'])) $this->captchaValue = intval($_POST['captchaValue']);
	}
	
	/**
	 * @see Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// username
		$this->validateUsername($this->username); 
		
		// email
		$this->validateEmail($this->email, $this->confirmEmail); 
		
		// password
		$this->validatePassword($this->password, $this->confirmPassword);
		
		// validate user language
		require_once(WCF_DIR.'lib/system/language/Language.class.php');
		if (!Language::getLanguage($this->languageID)) {
			// use default language
			$this->languageID = Language::getDefaultLanguageID();
		}
		
		// captcha
		if (!WCF::getUser()->userID) {
			$this->captcha = new Captcha($this->captchaID);
			$this->captcha->validate($this->captchaValue);			
		}
	}
	
	/**
	 * Throws a UserInputException if the username is not unique or not valid.
	 * 
	 * @param	string		$username
	 */
	protected function validateUsername($username) {
		if (empty($username)) {
			throw new UserInputException('username');
		}
		
		// check for forbidden chars (e.g. the ",")
		if (!UserUtil::isValidUsername($username)) {
			throw new UserInputException('username', 'notValid');
		}
		
		// Check if username exists already.
		if (!UserUtil::isAvailableUsername($username)) {
			throw new UserInputException('username', 'notUnique');
		}
	}
	
	/**
	 * Throws a UserInputException if the email is not unique or not valid.
	 * 
	 * @param	string		$email
	 * @param	string		$confirmEmail
	 */
	protected function validateEmail($email, $confirmEmail) {
		if (empty($email)) {	
			throw new UserInputException('email');
		}
		
		// check for valid email (one @ etc.)
		if (!UserUtil::isValidEmail($email)) {
			throw new UserInputException('email', 'notValid');
		}
		
		// Check if email exists already.
		if (!UserUtil::isAvailableEmail($email)) {
			throw new UserInputException('email', 'notUnique');
		}
		
		// check confirm input
		if (StringUtil::toLowerCase($email) != StringUtil::toLowerCase($confirmEmail)) {
			throw new UserInputException('confirmEmail', 'notEqual');
		}
	}
	
	/**
	 * Throws a UserInputException if the password is not valid.
	 * 
	 * @param	string		$password
	 * @param	string		$confirmPassword
	 */
	protected function validatePassword($password, $confirmPassword) {
		if (empty($password)) {
			throw new UserInputException('password');
		}
		
		// check confirm input
		if ($password != $confirmPassword) {
			throw new UserInputException('confirmPassword', 'notEqual');
		}
	}
	
	/**
	 * @see Form::save()
	 */
	public function save() {
		AbstractForm::save();
		
		// create user
		$this->user = UserEditor::create($this->username, $this->email, $this->password, array(), array(), array('languageID' => $this->languageID), array(), true);
		
		// update session
		WCF::getSession()->changeUser($this->user);
		
		// login user
		UserAuth::getInstance()->storeAccessData($this->user, $this->username, $this->password);
		$this->saved();
		
		// forward
		HeaderUtil::redirect(URL_PREFIX.SID_ARG_1ST);
		exit;
	}
	
	/**
	 * @see Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// captcha
		if (!WCF::getUser()->userID) {
			$this->captchaID = Captcha::create();
			$this->captcha = new Captcha($this->captchaID);
		}
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'availableLanguages' => $this->getAvailableLanguages(),
			'username' => $this->username,
			'email' => $this->email,
			'confirmEmail' => $this->confirmEmail,
			'password' => $this->password,
			'confirmPassword' => $this->confirmPassword,
			'languageID' => $this->languageID,
			'captchaID' => $this->captchaID,
			'captcha' => $this->captcha
		));
	}
	
	/**
	 * @see Page::show()
	 */
	public function show() {
		if (!WCF::getUser()->userID) {
			parent::show();
		}
	}
	
	/**
	 * Returns a list of all available languages.
	 * 
	 * @return	array
	 */
	protected function getAvailableLanguages() {
		$availableLanguages = array();
		foreach (Language::getAvailableLanguages(PACKAGE_ID) as $language) {
			$availableLanguages[$language['languageID']] = WCF::getLanguage()->get('wcf.global.language.'.$language['languageCode']);	
		}
		
		// sort languages
		StringUtil::sort($availableLanguages);
		
		return $availableLanguages;
	}
}
?>