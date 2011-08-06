<?php
// wsis imports
require_once(WSIS_DIR.'lib/data/user/WSISUserSession.class.php');
require_once(WSIS_DIR.'lib/data/user/WSISGuestSession.class.php');

// wcf imports
require_once(WCF_DIR.'lib/system/session/Session.class.php');

/**
 * WSISACPSession extends the Session class with site specific functions.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsis
 * @subpackage	system.session
 * @category	Infinite Site
 */
class WSISACPSession extends Session {
	protected $userSessionClassName = 'WSISUserSession';
	protected $guestSessionClassName = 'WSISGuestSession';
}
?>