<?php
// wcf imports
require_once(WCF_DIR.'lib/data/user/UserEditor.class.php');
require_once(WCF_DIR.'lib/form/element/ThemeModuleFormElement.class.php');
require_once(WCF_DIR.'lib/system/auth/UserAuth.class.php');

/**
 * Shows the account management form element.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.html>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	form.element
 * @category	Infinite Site
 */
class AccountManagementFormElement extends ThemeModuleFormElement {
	// system
	public $templateName = 'accountManagement';
	
	// parameters
	public $password = '';
	public $email = '';
	public $confirmEmail = '';
	public $newPassword = '';
	public $confirmNewPassword = '';
	public $languageID = 0;
	
	/**
	 * @see Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['password'])) $this->password = $_POST['password'];
		if (isset($_POST['email'])) $this->email = StringUtil::trim($_POST['email']);
		if (isset($_POST['confirmEmail'])) $this->confirmEmail = StringUtil::trim($_POST['confirmEmail']);
		if (isset($_POST['newPassword'])) $this->newPassword = $_POST['newPassword'];
		if (isset($_POST['confirmNewPassword'])) $this->confirmNewPassword = $_POST['confirmNewPassword'];
		if (isset($_POST['languageID'])) $this->languageID = intval($_POST['languageID']);
	}
	
	/**
	 * @see Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// password
		if (empty($this->password)) {
			throw new UserInputException('password');
		}
		
		if (!WCF::getUser()->checkPassword($this->password)) {
			throw new UserInputException('password', 'false');
		}
		
		// password
		if (!empty($this->newPassword) || !empty($this->confirmNewPassword)) {
			if (empty($this->newPassword)) {
				throw new UserInputException('newPassword');
			}
			
			if (empty($this->confirmNewPassword)) {
				throw new UserInputException('confirmNewPassword');
			}
			
			if ($this->newPassword != $this->confirmNewPassword) {
				throw new UserInputException('confirmNewPassword', 'notEqual');
			}
		}
		
		// email
		if ($this->email != WCF::getUser()->email) {
			if (empty($this->email)) {	
				throw new UserInputException('email');
			}
		
			// check if only letter case is changed
			if (StringUtil::toLowerCase($this->email) != StringUtil::toLowerCase(WCF::getUser()->email)) {
				// check for valid email (one @ etc.)
				if (!UserUtil::isValidEmail($this->email)) {
					throw new UserInputException('email', 'notValid');
				}
				
				// Check if email exists already.
				if (!UserUtil::isAvailableEmail($this->email)) {
					throw new UserInputException('email', 'notUnique');
				}
			}
			
			// check confirm input
			if (StringUtil::toLowerCase($this->email) != StringUtil::toLowerCase($this->confirmEmail)) {
				throw new UserInputException('confirmEmail', 'notEqual');
			}
		}
	}
	
	/**
	 * @see Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// default values
		if (!count($_POST)) {
			$this->username = WCF::getUser()->username;
			$this->email = $this->confirmEmail = WCF::getUser()->email;
		}
	}
	
	/**
	 * @see Form::save()
	 */
	public function save() {
		AbstractForm::save();
		
		// get user editor
		$editor = WCF::getUser()->getEditor();
		$success = array();
		
		// email
		if ($this->email != WCF::getUser()->email) {
			$editor->update('', $this->email);
		}
		
		// password
		if (!empty($this->newPassword) || !empty($this->confirmNewPassword)) {
			$editor->update('', '', $this->newPassword);
		
			// update cookie
			if (isset($_COOKIE[COOKIE_PREFIX.'password'])) {
				HeaderUtil::setCookie('password', StringUtil::getSaltedHash($this->newPassword, $editor->salt), TIME_NOW + 365 * 24 * 3600);
			}
		}
		
		// reset session
		WCF::getSession()->resetUserData();
		$this->saved();
		
		// show success message
		WCF::getTPL()->assign('success', true);
		
		// reset values
		$this->password = '';
		$this->newPassword = $this->confirmNewPassword = '';
	}
	
	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'availableLanguages' => $this->getAvailableLanguages(),
			'password' => $this->password,
			'email' => $this->email,
			'confirmEmail' => $this->confirmEmail,
			'newPassword' => $this->newPassword,
			'confirmNewPassword' => $this->confirmNewPassword,
			'languageID' => $this->languageID
		));
	}
	
	/**
	 * @see Page::show()
	 */
	public function show() {
		if (WCF::getUser()->userID) {
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