<?php
// wcf imports
require_once(WCF_DIR.'lib/form/element/ThemeModuleFormElement.class.php');
require_once(WCF_DIR.'lib/system/auth/UserAuth.class.php');

/**
 * Represents a login form element.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	form.element
 * @category	Infinite Site
 */
class LoginFormElement extends ThemeModuleFormElement {
	// system
	public $templateName = 'login';
	
	// parameters
	public $username = '';
	public $password = '';
	public $useCookies = 1;
	
	/**
	 * user object
	 * 
	 * @var	User
	 */
	public $user = null;
	
	/**
	 * Validates the user access data.
	 */
	protected function validateUser() {
		$this->user = UserAuth::getInstance()->loginManually($this->username, $this->password);
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		if (empty($this->username)) {
			throw new UserInputException('username');
		}
		
		if (empty($this->password)) {
			throw new UserInputException('password');
		}
		
		$this->validateUser();
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		AbstractForm::save();
		
		// set cookies
		if ($this->useCookies == 1) {
			UserAuth::getInstance()->storeAccessData($this->user, $this->username, $this->password);
		}
		
		// change user
		WCF::getSession()->changeUser($this->user);
		$this->saved();
		
		// forward
		HeaderUtil::redirect(URL_PREFIX.SID_ARG_1ST);
		exit;
	}
	
	/**
	 * @see	Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		$this->useCookies = 0;
		
		if (isset($_POST['loginUsername'])) $this->username = StringUtil::trim($_POST['loginUsername']);
		if (isset($_POST['loginPassword'])) $this->password = $_POST['loginPassword'];
		if (isset($_POST['useCookies'])) $this->useCookies = intval($_POST['useCookies']);
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'username' => $this->username,
			'password' => $this->password,
			'useCookies' => $this->useCookies,
			'supportsPersistentLogins' => UserAuth::getInstance()->supportsPersistentLogins()
		));
	}
}
?>