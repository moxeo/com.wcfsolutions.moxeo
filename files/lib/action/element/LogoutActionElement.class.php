<?php
// wcf imports
require_once(WCF_DIR.'lib/action/element/ThemeModuleActionElement.class.php');

/**
 * Represents a logout element.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	action.element
 * @category	Infinite Site
 */
class LogoutActionElement extends ThemeModuleActionElement {	
	/**
	 * @see	Action::execute()
	 */
	public function execute() {
		parent::execute();
		
		if (WCF::getUser()->userID) {
			// delete session
			require_once(WCF_DIR.'lib/system/session/UserSession.class.php');
			WCF::getSession()->delete();
			
			// remove cookies
			if (isset($_COOKIE[COOKIE_PREFIX.'userID'])) {
				HeaderUtil::setCookie('userID', 0);
			}
			if (isset($_COOKIE[COOKIE_PREFIX.'password'])) {
				HeaderUtil::setCookie('password', '');
			}
			$this->executed();
			
			// forward
			HeaderUtil::redirect(URL_PREFIX.SID_ARG_1ST);
			exit;
		}
	}
}
?>